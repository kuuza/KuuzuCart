<?php
/**
 * Kuuzu Cart
 * 
 * @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
 */

  namespace Kuuzu\KU\Core\Site\Shop\Application\Cart\RPC\PayPal;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Module\Payment\PayPalExpressCheckout;
  use Kuuzu\KU\Core\Site\Shop\Shipping;

  class ExpressCheckoutInstantUpdate {
    public static function execute() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_Tax = Registry::get('Tax');

      $KUUZU_ShoppingCart->reset();

      $KUUZU_Payment = new PayPalExpressCheckout();

      if ( $KUUZU_Payment->isEnabled() && (MODULE_PAYMENT_PAYPAL_EXPRESS_CHECKOUT_INSTANT_UPDATE == '1') ) {
        $counter = 0;

        while ( true ) {
          if ( isset($_POST['L_NUMBER' . $counter]) ) {
            $KUUZU_ShoppingCart->add($_POST['L_NUMBER' . $counter], $_POST['L_QTY' . $counter]);
          } else {
            break;
          }

          $counter++;
        }

        if ( $KUUZU_ShoppingCart->hasContents() ) {
          $Qcountry = $KUUZU_PDO->prepare('select countries_id from :table_countries where countries_iso_code_2 = :countries_iso_code_2 limit 1');
          $Qcountry->bindValue(':countries_iso_code_2', $_POST['SHIPTOCOUNTRY']);
          $Qcountry->execute();

          if ( $Qcountry->fetch() !== false ) {
            $address = array('firstname' => '',
                             'lastname' => '',
                             'gender' => '',
                             'company' => '',
                             'street_address' => '',
                             'suburb' => '',
                             'city' => $_POST['SHIPTOCITY'],
                             'postcode' => $_POST['SHIPTOZIP'],
                             'state' => $_POST['SHIPTOSTATE'],
                             'zone_id' => '',
                             'country_id' => $Qcountry->valueInt('countries_id'),
                             'telephone' => '',
                             'fax' => '');

            $Qzone = $KUUZU_PDO->prepare('select * from :table_zones where zone_country_id = :zone_country_id and (zone_name = :zone_name or zone_code = :zone_code) limit 1');
            $Qzone->bindInt(':zone_country_id', $address['country_id']);
            $Qzone->bindValue(':zone_name', $address['state']);
            $Qzone->bindValue(':zone_code', $address['state']);
            $Qzone->execute();

            if ( $Qzone->fetch() !== false ) {
              $address['zone_id'] = $Qzone->valueInt('zone_id');
              $address['state'] = $Qzone->value('zone_name');
            }

            $KUUZU_ShoppingCart->setShippingAddress($address);
            $KUUZU_ShoppingCart->setBillingAddress($address);

            $tax_total = 0;

            foreach ( $KUUZU_ShoppingCart->getProducts() as $product ) {
              $product_tax = $KUUZU_Currencies->formatRaw($product['price'] * ($KUUZU_Tax->getTaxRate($product['tax_class_id']) / 100));

              $tax_total += $product_tax * $product['quantity'];
            }

            $quotes_array = array();

            if ( $KUUZU_ShoppingCart->getContentType() != 'virtual' ) {
              $KUUZU_Shipping = new Shipping();

              foreach ( $KUUZU_Shipping->getQuotes() as $quote ) {
                if ( !isset($quote['error']) ) {
                  foreach ( $quote['methods'] as $rate ) {
                    $quotes_array[] = array('id' => $quote['id'] . '_' . $rate['id'],
                                            'name' => $quote['module'],
                                            'label' => $rate['title'],
                                            'cost' => $rate['cost'],
                                            'tax' => $quote['tax']);
                  }
                }
              }
            } else {
              $quotes_array[] = array('id' => 'null',
                                      'name' => 'No Shipping',
                                      'label' => 'No Shipping',
                                      'cost' => '0',
                                      'tax' => '0');
            }

            $params = array('METHOD' => 'CallbackResponse',
                            'OFFERINSURANCEOPTION' => 'false');

            $counter = 0;
            $cheapest_rate = null;
            $cheapest_counter = $counter;

            foreach ( $quotes_array as $quote ) {
              $shipping_rate = $KUUZU_Currencies->formatRaw($quote['cost'] + ($quote['cost'] * ($quote['tax'] / 100)));

              $params['L_SHIPPINGOPTIONNAME' . $counter] = $quote['name'] . ' (' . $quote['label'] . ')';
              $params['L_SHIPINGPOPTIONLABEL' . $counter] = $quote['name'] . ' (' . $quote['label'] . ')';
              $params['L_SHIPPINGOPTIONAMOUNT' . $counter] = $KUUZU_Currencies->formatRaw($quote['cost']);
              $params['L_SHIPPINGOPTIONISDEFAULT' . $counter] = 'false';
              $params['L_TAXAMT' . $counter] = $KUUZU_Currencies->formatRaw($tax_total + ($quote['cost'] * ($quote['tax'] / 100)));

              if ( is_null($cheapest_rate) || ($shipping_rate < $cheapest_rate) ) {
                $cheapest_rate = $shipping_rate;
                $cheapest_counter = $counter;
              }

              $counter++;
            }

            $params['L_SHIPPINGOPTIONISDEFAULT' . $cheapest_counter] = 'true';

            $post_string = '';

            foreach ( $params as $key => $value ) {
              $post_string .= $key . '=' . urlencode(utf8_encode(trim($value))) . '&';
            }

            $post_string = substr($post_string, 0, -1);

            echo $post_string;
          }
        }
      }

      $KUUZU_ShoppingCart->reset();
    }
  }
?>
