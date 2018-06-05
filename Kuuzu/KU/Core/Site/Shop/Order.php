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

  namespace Kuuzu\KU\Core\Site\Shop;

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\Mail;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Address;
  use Kuuzu\KU\Core\Site\Shop\AddressBook;
  use Kuuzu\KU\Core\Site\Shop\Products;

  class Order {
// HPDL add getter methods for the following and set as protected
    public $info;
    public $totals;
    public $products;
    public $customer;
    public $delivery;
    public $content_type;

    protected $_id;

    public function __construct($id = null) {
      if ( is_numeric($id) ) {
        $this->_id = $id;
      }

      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

      if ( is_numeric($id) ) {
        $this->query($id);
      } else {
        $this->cart();
      }
    }

    function getStatusID($id) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qorder = $KUUZU_PDO->prepare('select orders_status from :table_orders where orders_id = :orders_id');
      $Qorder->bindInt(':orders_id', $id);
      $Qorder->execute();

      if ( $Qorder->fetch() !== false ) {
        return $Qorder->valueInt('orders_status');
      }

      return false;
    }

    function remove($id) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcheck = $KUUZU_PDO->prepare('select orders_status from :table_orders where orders_id = :orders_id');
      $Qcheck->bindInt(':orders_id', $id);
      $Qcheck->execute();

      if ( $Qcheck->valueInt('orders_status') === 4 ) {
        $Qdel = $KUUZU_PDO->prepare('delete from :table_orders where orders_id = :orders_id');
        $Qdel->bindInt(':orders_id', $id);
        $Qdel->execute();
      }

      if ( isset($_SESSION['prepOrderID']) ) {
        unset($_SESSION['prepOrderID']);
      }
    }

    public static function insert() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Tax = Registry::get('Tax');

      if ( isset($_SESSION['prepOrderID']) ) {
        $_prep = explode('-', $_SESSION['prepOrderID']);

        if ( $_prep[0] == $KUUZU_ShoppingCart->getCartID() ) {
          return $_prep[1]; // order_id
        } else {
          if ( self::getStatusID($_prep[1]) === 4 ) {
            self::remove($_prep[1]);
          }
        }
      }

      if ( $KUUZU_Customer->isLoggedOn() ) {
        $customer_address = AddressBook::getEntry($KUUZU_Customer->getDefaultAddressID());
      } else {
        $customer_address = array('company' => $KUUZU_ShoppingCart->getShippingAddress('company'),
                                  'street_address' => $KUUZU_ShoppingCart->getShippingAddress('street_address'),
                                  'suburb' => $KUUZU_ShoppingCart->getShippingAddress('suburb'),
                                  'city' => $KUUZU_ShoppingCart->getShippingAddress('city'),
                                  'postcode' => $KUUZU_ShoppingCart->getShippingAddress('postcode'),
                                  'state' => $KUUZU_ShoppingCart->getShippingAddress('state'),
                                  'zone_id' => $KUUZU_ShoppingCart->getShippingAddress('zone_id'),
                                  'country_id' => $KUUZU_ShoppingCart->getShippingAddress('country_id'),
                                  'telephone' => $KUUZU_ShoppingCart->getShippingAddress('telephone'));
      }

      $Qorder = $KUUZU_PDO->prepare('insert into :table_orders (customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_state_code, customers_country, customers_country_iso2, customers_country_iso3, customers_telephone, customers_email_address, customers_address_format, customers_ip_address, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_state_code, delivery_country, delivery_country_iso2, delivery_country_iso3, delivery_address_format, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_state_code, billing_country, billing_country_iso2, billing_country_iso3, billing_address_format, payment_method, payment_module, date_purchased, orders_status, currency, currency_value) values (:customers_id, :customers_name, :customers_company, :customers_street_address, :customers_suburb, :customers_city, :customers_postcode, :customers_state, :customers_state_code, :customers_country, :customers_country_iso2, :customers_country_iso3, :customers_telephone, :customers_email_address, :customers_address_format, :customers_ip_address, :delivery_name, :delivery_company, :delivery_street_address, :delivery_suburb, :delivery_city, :delivery_postcode, :delivery_state, :delivery_state_code, :delivery_country, :delivery_country_iso2, :delivery_country_iso3, :delivery_address_format, :billing_name, :billing_company, :billing_street_address, :billing_suburb, :billing_city, :billing_postcode, :billing_state, :billing_state_code, :billing_country, :billing_country_iso2, :billing_country_iso3, :billing_address_format, :payment_method, :payment_module, now(), :orders_status, :currency, :currency_value)');
      $Qorder->bindInt(':customers_id', $KUUZU_Customer->getID());
      $Qorder->bindValue(':customers_name', $KUUZU_Customer->getName());
      $Qorder->bindValue(':customers_company', $customer_address['company']);
      $Qorder->bindValue(':customers_street_address', $customer_address['street_address']);
      $Qorder->bindValue(':customers_suburb', $customer_address['suburb']);
      $Qorder->bindValue(':customers_city', $customer_address['city']);
      $Qorder->bindValue(':customers_postcode', $customer_address['postcode']);
      $Qorder->bindValue(':customers_state', $customer_address['state']);
      $Qorder->bindValue(':customers_state_code', Address::getZoneCode($customer_address['zone_id']));
      $Qorder->bindValue(':customers_country', Address::getCountryName($customer_address['country_id']));
      $Qorder->bindValue(':customers_country_iso2', Address::getCountryIsoCode2($customer_address['country_id']));
      $Qorder->bindValue(':customers_country_iso3', Address::getCountryIsoCode3($customer_address['country_id']));
      $Qorder->bindValue(':customers_telephone', $customer_address['telephone']);
      $Qorder->bindValue(':customers_email_address', $KUUZU_Customer->getEmailAddress());
      $Qorder->bindValue(':customers_address_format', Address::getFormat($customer_address['country_id']));
      $Qorder->bindValue(':customers_ip_address', KUUZU::getIPAddress());
      $Qorder->bindValue(':delivery_name', $KUUZU_ShoppingCart->getShippingAddress('firstname') . ' ' . $KUUZU_ShoppingCart->getShippingAddress('lastname'));
      $Qorder->bindValue(':delivery_company', $KUUZU_ShoppingCart->getShippingAddress('company'));
      $Qorder->bindValue(':delivery_street_address', $KUUZU_ShoppingCart->getShippingAddress('street_address'));
      $Qorder->bindValue(':delivery_suburb', $KUUZU_ShoppingCart->getShippingAddress('suburb'));
      $Qorder->bindValue(':delivery_city', $KUUZU_ShoppingCart->getShippingAddress('city'));
      $Qorder->bindValue(':delivery_postcode', $KUUZU_ShoppingCart->getShippingAddress('postcode'));
      $Qorder->bindValue(':delivery_state', $KUUZU_ShoppingCart->getShippingAddress('state'));
      $Qorder->bindValue(':delivery_state_code', $KUUZU_ShoppingCart->getShippingAddress('zone_code'));
      $Qorder->bindValue(':delivery_country', $KUUZU_ShoppingCart->getShippingAddress('country_title'));
      $Qorder->bindValue(':delivery_country_iso2', $KUUZU_ShoppingCart->getShippingAddress('country_iso_code_2'));
      $Qorder->bindValue(':delivery_country_iso3', $KUUZU_ShoppingCart->getShippingAddress('country_iso_code_3'));
      $Qorder->bindValue(':delivery_address_format', $KUUZU_ShoppingCart->getShippingAddress('format'));
      $Qorder->bindValue(':billing_name', $KUUZU_ShoppingCart->getBillingAddress('firstname') . ' ' . $KUUZU_ShoppingCart->getBillingAddress('lastname'));
      $Qorder->bindValue(':billing_company', $KUUZU_ShoppingCart->getBillingAddress('company'));
      $Qorder->bindValue(':billing_street_address', $KUUZU_ShoppingCart->getBillingAddress('street_address'));
      $Qorder->bindValue(':billing_suburb', $KUUZU_ShoppingCart->getBillingAddress('suburb'));
      $Qorder->bindValue(':billing_city', $KUUZU_ShoppingCart->getBillingAddress('city'));
      $Qorder->bindValue(':billing_postcode', $KUUZU_ShoppingCart->getBillingAddress('postcode'));
      $Qorder->bindValue(':billing_state', $KUUZU_ShoppingCart->getBillingAddress('state'));
      $Qorder->bindValue(':billing_state_code', $KUUZU_ShoppingCart->getBillingAddress('zone_code'));
      $Qorder->bindValue(':billing_country', $KUUZU_ShoppingCart->getBillingAddress('country_title'));
      $Qorder->bindValue(':billing_country_iso2', $KUUZU_ShoppingCart->getBillingAddress('country_iso_code_2'));
      $Qorder->bindValue(':billing_country_iso3', $KUUZU_ShoppingCart->getBillingAddress('country_iso_code_3'));
      $Qorder->bindValue(':billing_address_format', $KUUZU_ShoppingCart->getBillingAddress('format'));
      $Qorder->bindValue(':payment_method', $KUUZU_ShoppingCart->getBillingMethod('title'));
// HPDL verify payment module class
      $Qorder->bindValue(':payment_module', $KUUZU_ShoppingCart->getBillingMethod('id'));
      $Qorder->bindInt(':orders_status', 4);
// HPDL move currencies to the products level
      $Qorder->bindValue(':currency', $KUUZU_Currencies->getCode());
      $Qorder->bindValue(':currency_value', $KUUZU_Currencies->value($KUUZU_Currencies->getCode()));
      $Qorder->execute();

      $insert_id = $KUUZU_PDO->lastInsertId();

      foreach ( $KUUZU_ShoppingCart->getOrderTotals() as $module ) {
        $Qtotals = $KUUZU_PDO->prepare('insert into :table_orders_total (orders_id, title, text, value, class, sort_order) values (:orders_id, :title, :text, :value, :class, :sort_order)');
        $Qtotals->bindInt(':orders_id', $insert_id);
        $Qtotals->bindValue(':title', $module['title']);
        $Qtotals->bindValue(':text', $module['text']);
        $Qtotals->bindValue(':value', $module['value']);
        $Qtotals->bindValue(':class', $module['code']);
        $Qtotals->bindInt(':sort_order', $module['sort_order']);
        $Qtotals->execute();
      }

      $Qstatus = $KUUZU_PDO->prepare('insert into :table_orders_status_history (orders_id, orders_status_id, date_added, customer_notified, comments) values (:orders_id, :orders_status_id, now(), :customer_notified, :comments)');
      $Qstatus->bindInt(':orders_id', $insert_id);
      $Qstatus->bindInt(':orders_status_id', 4);
      $Qstatus->bindInt(':customer_notified', '0');
      $Qstatus->bindValue(':comments', (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''));
      $Qstatus->execute();

      foreach ( $KUUZU_ShoppingCart->getProducts() as $products ) {
        $Qproducts = $KUUZU_PDO->prepare('insert into :table_orders_products (orders_id, products_id, products_model, products_name, products_price, products_tax, products_quantity) values (:orders_id, :products_id, :products_model, :products_name, :products_price, :products_tax, :products_quantity)');
        $Qproducts->bindInt(':orders_id', $insert_id);
        $Qproducts->bindInt(':products_id', Products::getProductID($products['id']));
        $Qproducts->bindValue(':products_model', $products['model']);
        $Qproducts->bindValue(':products_name', $products['name']);
        $Qproducts->bindValue(':products_price', $products['price']);
        $Qproducts->bindValue(':products_tax', $KUUZU_Tax->getTaxRate($products['tax_class_id']));
        $Qproducts->bindInt(':products_quantity', $products['quantity']);
        $Qproducts->execute();

        $order_products_id = $KUUZU_PDO->lastInsertId();

        if ( $KUUZU_ShoppingCart->isVariant($products['item_id']) ) {
          foreach ( $KUUZU_ShoppingCart->getVariant($products['item_id']) as $variant ) {
/* HPDL
            if (DOWNLOAD_ENABLED == '1') {
              $Qattributes = $KUUZU_PDO->prepare('select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount, pad.products_attributes_filename from :table_products_options popt, :table_products_options_values poval, :table_products_attributes pa left join :table_products_attributes_download pad on (pa.products_attributes_id = pad.products_attributes_id) where pa.products_id = :products_id and pa.options_id = :options_id and pa.options_id = popt.products_options_id and pa.options_values_id = :options_values_id and pa.options_values_id = poval.products_options_values_id and popt.language_id = :popt_language_id and poval.language_id = :poval_language_id');
              $Qattributes->bindInt(':products_id', $products['id']);
              $Qattributes->bindInt(':options_id', $attributes['options_id']);
              $Qattributes->bindInt(':options_values_id', $attributes['options_values_id']);
              $Qattributes->bindInt(':popt_language_id', $KUUZU_Language->getID());
              $Qattributes->bindInt(':poval_language_id', $KUUZU_Language->getID());
              $Qattributes->execute();
            }
*/

            $Qvariant = $KUUZU_PDO->prepare('insert into :table_orders_products_variants (orders_id, orders_products_id, group_title, value_title) values (:orders_id, :orders_products_id, :group_title, :value_title)');
            $Qvariant->bindInt(':orders_id', $insert_id);
            $Qvariant->bindInt(':orders_products_id', $order_products_id);
            $Qvariant->bindValue(':group_title', $variant['group_title']);
            $Qvariant->bindValue(':value_title', $variant['value_title']);
            $Qvariant->execute();

/*HPDL
            if ((DOWNLOAD_ENABLED == '1') && (strlen($Qattributes->value('products_attributes_filename')) > 0)) {
              $Qopd = $KUUZU_PDO->prepare('insert into :table_orders_products_download (orders_id, orders_products_id, orders_products_filename, download_maxdays, download_count) values (:orders_id, :orders_products_id, :orders_products_filename, :download_maxdays, :download_count)');
              $Qopd->bindInt(':orders_id', $insert_id);
              $Qopd->bindInt(':orders_products_id', $order_products_id);
              $Qopd->bindValue(':orders_products_filename', $Qattributes->value('products_attributes_filename'));
              $Qopd->bindValue(':download_maxdays', $Qattributes->value('products_attributes_maxdays'));
              $Qopd->bindValue(':download_count', $Qattributes->value('products_attributes_maxcount'));
              $Qopd->execute();
            }
*/
          }
        }
      }

      $_SESSION['prepOrderID'] = $KUUZU_ShoppingCart->getCartID() . '-' . $insert_id;

      return $insert_id;
    }

    public static function process($order_id, $status_id = null) {
      $KUUZU_PDO = Registry::get('PDO');

      if ( !is_numeric($status_id) || ($status_id < 1) ) {
        $status_id = DEFAULT_ORDERS_STATUS_ID;
      }

      $Qstatus = $KUUZU_PDO->prepare('insert into :table_orders_status_history (orders_id, orders_status_id, date_added, customer_notified, comments) values (:orders_id, :orders_status_id, now(), :customer_notified, :comments)');
      $Qstatus->bindInt(':orders_id', $order_id);
      $Qstatus->bindInt(':orders_status_id', $status_id);
      $Qstatus->bindInt(':customer_notified', (SEND_EMAILS == '1') ? '1' : '0');
      $Qstatus->bindValue(':comments', '');
      $Qstatus->execute();

      $Qupdate = $KUUZU_PDO->prepare('update :table_orders set orders_status = :orders_status where orders_id = :orders_id');
      $Qupdate->bindInt(':orders_status', $status_id);
      $Qupdate->bindInt(':orders_id', $order_id);
      $Qupdate->execute();

      $Qproducts = $KUUZU_PDO->prepare('select products_id, products_quantity from :table_orders_products where orders_id = :orders_id');
      $Qproducts->bindInt(':orders_id', $order_id);
      $Qproducts->execute();

      while ( $Qproducts->fetch() ) {
        if (STOCK_LIMITED == '1') {

/********** HPDL ; still uses logic from the shopping cart class
          if (DOWNLOAD_ENABLED == '1') {
            $Qstock = $KUUZU_PDO->prepare('select products_quantity, pad.products_attributes_filename from :table_products p left join :table_products_attributes pa on (p.products_id = pa.products_id) left join :table_products_attributes_download pad on (pa.products_attributes_id = pad.products_attributes_id) where p.products_id = :products_id');
            $Qstock->bindInt(':products_id', $Qproducts->valueInt('products_id'));

// Will work with only one option for downloadable products otherwise, we have to build the query dynamically with a loop
            if ($KUUZU_ShoppingCart->hasAttributes($products['id'])) {
              $products_attributes = $KUUZU_ShoppingCart->getAttributes($products['id']);
              $products_attributes = array_shift($products_attributes);

              $Qstock->appendQuery('and pa.options_id = :options_id and pa.options_values_id = :options_values_id');
              $Qstock->bindInt(':options_id', $products_attributes['options_id']);
              $Qstock->bindInt(':options_values_id', $products_attributes['options_values_id']);
            }
          } else {
************/
            $Qstock = $KUUZU_PDO->prepare('select products_quantity from :table_products where products_id = :products_id');
            $Qstock->bindInt(':products_id', $Qproducts->valueInt('products_id'));
// HPDL          }

          $Qstock->execute();

          if ( $Qstock->fetch() !== false ) {
            $stock_left = $Qstock->valueInt('products_quantity');

// do not decrement quantities if products_attributes_filename exists
// HPDL            if ((DOWNLOAD_ENABLED == '-1') || ((DOWNLOAD_ENABLED == '1') && (strlen($Qstock->value('products_attributes_filename')) < 1))) {
              $stock_left = $stock_left - $Qproducts->valueInt('products_quantity');

              $Qupdate = $KUUZU_PDO->prepare('update :table_products set products_quantity = :products_quantity where products_id = :products_id');
              $Qupdate->bindInt(':products_quantity', $stock_left);
              $Qupdate->bindInt(':products_id', $Qproducts->valueInt('products_id'));
              $Qupdate->execute();
// HPDL            }

            if ( (STOCK_ALLOW_CHECKOUT == '-1') && ($stock_left < 1) ) {
              $Qupdate = $KUUZU_PDO->prepare('update :table_products set products_status = 0 where products_id = :products_id');
              $Qupdate->bindInt(':products_id', $Qproducts->valueInt('products_id'));
              $Qupdate->execute();
            }
          }
        }

// Update products_ordered (for bestsellers list)
        $Qupdate = $KUUZU_PDO->prepare('update :table_products set products_ordered = products_ordered + :products_ordered where products_id = :products_id');
        $Qupdate->bindInt(':products_ordered', $Qproducts->valueInt('products_quantity'));
        $Qupdate->bindInt(':products_id', $Qproducts->valueInt('products_id'));
        $Qupdate->execute();
      }

      self::sendEmail($order_id);

      unset($_SESSION['prepOrderID']);
    }

    public static function sendEmail($id) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_Language = Registry::get('Language');

      $Qorder = $KUUZU_PDO->prepare('select * from :table_orders where orders_id = :orders_id limit 1');
      $Qorder->bindInt(':orders_id', $id);
      $Qorder->execute();

      if ( $Qorder->fetch() !== false ) {
        $email_order = STORE_NAME . "\n" .
                       KUUZU::getDef('email_order_separator') . "\n" .
                       sprintf(KUUZU::getDef('email_order_order_number'), $id) . "\n" .
                       sprintf(KUUZU::getDef('email_order_invoice_url'), KUUZU::getLink('Shop', 'Account', 'Orders=' . $id, 'SSL', false, true, true)) . "\n" .
                       sprintf(KUUZU::getDef('email_order_date_ordered'), DateTime::getLong()) . "\n\n" .
                       KUUZU::getDef('email_order_products') . "\n" .
                       KUUZU::getDef('email_order_separator') . "\n";

        $Qproducts = $KUUZU_PDO->prepare('select orders_products_id, products_model, products_name, products_price, products_tax, products_quantity from :table_orders_products where orders_id = :orders_id order by orders_products_id');
        $Qproducts->bindInt(':orders_id', $id);
        $Qproducts->execute();

        while ( $Qproducts->fetch() ) {
          $email_order .= $Qproducts->valueInt('products_quantity') . ' x ' . $Qproducts->value('products_name') . ' (' . $Qproducts->value('products_model') . ') = ' . $KUUZU_Currencies->displayPriceWithTaxRate($Qproducts->value('products_price'), $Qproducts->value('products_tax'), $Qproducts->valueInt('products_quantity'), false, $Qorder->value('currency'), $Qorder->value('currency_value')) . "\n";

          $Qvariants = $KUUZU_PDO->prepare('select group_title, value_title from :table_orders_products_variants where orders_id = :orders_id and orders_products_id = :orders_products_id order by id');
          $Qvariants->bindInt(':orders_id', $id);
          $Qvariants->bindInt(':orders_products_id', $Qproducts->valueInt('orders_products_id'));
          $Qvariants->execute();

          while ( $Qvariants->fetch() ) {
            $email_order .= "\t" . $Qvariants->value('group_title') . ': ' . $Qvariants->value('value_title') . "\n";
          }
        }

        $email_order .= KUUZU::getDef('email_order_separator') . "\n";

        $Qtotals = $KUUZU_PDO->prepare('select title, text from :table_orders_total where orders_id = :orders_id order by sort_order');
        $Qtotals->bindInt(':orders_id', $id);
        $Qtotals->execute();

        while ( $Qtotals->fetch() ) {
          $email_order .= strip_tags($Qtotals->value('title') . ' ' . $Qtotals->value('text')) . "\n";
        }

        if ( (strlen($Qorder->value('delivery_name')) > 0) && (strlen($Qorder->value('delivery_street_address')) > 0) ) {
          $address = array('name' => $Qorder->value('delivery_name'),
                           'company' => $Qorder->value('delivery_company'),
                           'street_address' => $Qorder->value('delivery_street_address'),
                           'suburb' => $Qorder->value('delivery_suburb'),
                           'city' => $Qorder->value('delivery_city'),
                           'state' => $Qorder->value('delivery_state'),
                           'zone_code' => $Qorder->value('delivery_state_code'),
                           'country_title' => $Qorder->value('delivery_country'),
                           'country_iso2' => $Qorder->value('delivery_country_iso2'),
                           'country_iso3' => $Qorder->value('delivery_country_iso3'),
                           'postcode' => $Qorder->value('delivery_postcode'),
                           'format' => $Qorder->value('delivery_address_format'));

          $email_order .= "\n" . KUUZU::getDef('email_order_delivery_address') . "\n" .
                          KUUZU::getDef('email_order_separator') . "\n" .
                          Address::format($address) . "\n";
        }

        $address = array('name' => $Qorder->value('billing_name'),
                         'company' => $Qorder->value('billing_company'),
                         'street_address' => $Qorder->value('billing_street_address'),
                         'suburb' => $Qorder->value('billing_suburb'),
                         'city' => $Qorder->value('billing_city'),
                         'state' => $Qorder->value('billing_state'),
                         'zone_code' => $Qorder->value('billing_state_code'),
                         'country_title' => $Qorder->value('billing_country'),
                         'country_iso2' => $Qorder->value('billing_country_iso2'),
                         'country_iso3' => $Qorder->value('billing_country_iso3'),
                         'postcode' => $Qorder->value('billing_postcode'),
                         'format' => $Qorder->value('billing_address_format'));

        $email_order .= "\n" . KUUZU::getDef('email_order_billing_address') . "\n" .
                        KUUZU::getDef('email_order_separator') . "\n" .
                        Address::format($address) . "\n\n";

        $Qstatus = $KUUZU_PDO->prepare('select orders_status_name from :table_orders_status where orders_status_id = :orders_status_id and language_id = :language_id');
        $Qstatus->bindInt(':orders_status_id', $Qorder->valueInt('orders_status'));
        $Qstatus->bindInt(':language_id', $KUUZU_Language->getID());
        $Qstatus->execute();

        $email_order .= sprintf(KUUZU::getDef('email_order_status'), $Qstatus->value('orders_status_name')) . "\n" .
                        KUUZU::getDef('email_order_separator') . "\n";

        $Qstatuses = $KUUZU_PDO->prepare('select date_added, comments from :table_orders_status_history where orders_id = :orders_id and comments != "" order by orders_status_history_id');
        $Qstatuses->bindInt(':orders_id', $id);
        $Qstatuses->execute();

        while ( $Qstatuses->fetch() ) {
          $email_order .= DateTime::getLong($Qstatuses->value('date_added')) . "\n\t" . wordwrap(str_replace("\n", "\n\t", $Qstatuses->value('comments')), 60, "\n\t", 1) . "\n\n";
        }

// HPDL
//        if (is_object($GLOBALS[$payment])) {
//          $email_order .= KUUZU::getDef('email_order_payment_method') . "\n" .
//                          KUUZU::getDef('email_order_separator') . "\n";

//          $email_order .= $KUUZU_ShoppingCart->getBillingMethod('title') . "\n\n";
//          if (isset($GLOBALS[$payment]->email_footer)) {
//            $email_order .= $GLOBALS[$payment]->email_footer . "\n\n";
//          }
//        }

        $oEmail = new Mail($Qorder->value('customers_name'), $Qorder->value('customers_email_address'), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, KUUZU::getDef('email_order_subject'));
        $oEmail->setBodyPlain($email_order);
        $oEmail->send();

// send emails to other people
        if ( SEND_EXTRA_ORDER_EMAILS_TO != '' ) {
          $oEmail = new Mail('', SEND_EXTRA_ORDER_EMAILS_TO, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, KUUZU::getDef('email_order_subject'));
          $oEmail->setBodyPlain($email_order);
          $oEmail->send();
        }
      }
    }

    public static function getListing($limit = null, $page_keyword = 'page') {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_Language = Registry::get('Language');

      $result = array();

      $sql_query = 'select SQL_CALC_FOUND_ROWS o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name from :table_orders o, :table_orders_total ot, :table_orders_status s where o.customers_id = :customers_id and o.orders_id = ot.orders_id and ot.class = "total" and o.orders_status = s.orders_status_id and s.language_id = :language_id order by orders_id desc';

      if ( is_numeric($limit) ) {
        $sql_query .= ' limit :batch_pageset, :batch_max_results';
      }

      $sql_query .= '; select found_rows();';

      $Qorders = $KUUZU_PDO->prepare($sql_query);
      $Qorders->bindInt(':customers_id', $KUUZU_Customer->getID());
      $Qorders->bindInt(':language_id', $KUUZU_Language->getID());

      if ( is_numeric($limit) ) {
        $Qorders->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom((isset($_GET[$page_keyword]) && is_numeric($_GET[$page_keyword]) ? $_GET[$page_keyword] : 1), $limit));
        $Qorders->bindInt(':batch_max_results', $limit);
      }

      $Qorders->execute();

      $result['entries'] = $Qorders->fetchAll();

      $Qorders->nextRowset();

      $result['total'] = $Qorders->fetchColumn();

      return $result;
    }

    function getStatusListing($id = null) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      if ( ($id === null) && isset($this) ) {
        $id = $this->_id;
      }

      $Qstatus = $KUUZU_PDO->prepare('select os.orders_status_name, osh.date_added, osh.comments from :table_orders_status os, :table_orders_status_history osh where osh.orders_id = :orders_id and osh.orders_status_id = os.orders_status_id and os.language_id = :language_id order by osh.date_added');
      $Qstatus->bindInt(':orders_id', $id);
      $Qstatus->bindInt(':language_id', $KUUZU_Language->getID());

      return $Qstatus;
    }

    public static function getCustomerID($id) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcustomer = $KUUZU_PDO->prepare('select customers_id from :table_orders where orders_id = :orders_id');
      $Qcustomer->bindInt(':orders_id', $id);
      $Qcustomer->execute();

      return $Qcustomer->valueInt('customers_id');
    }

    public static function numberOfEntries() {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_PDO = Registry::get('PDO');

      static $total_entries;

      if ( is_numeric($total_entries) === false ) {
        if ( $KUUZU_Customer->isLoggedOn() ) {
          $Qorders = $KUUZU_PDO->prepare('select count(*) as total from :table_orders where customers_id = :customers_id');
          $Qorders->bindInt(':customers_id', $KUUZU_Customer->getID());
          $Qorders->execute();

          $total_entries = $Qorders->valueInt('total');
        } else {
          $total_entries = 0;
        }
      }

      return $total_entries;
    }

    public static function numberOfProducts($id) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qproducts = $KUUZU_PDO->prepare('select count(*) as total from :table_orders_products where orders_id = :orders_id');
      $Qproducts->bindInt(':orders_id', $id);
      $Qproducts->execute();

      return $Qproducts->valueInt('total');
    }

    function exists($id, $customer_id = null) {
      $KUUZU_PDO = Registry::get('PDO');

      $sql_query = 'select orders_id from :table_orders where orders_id = :orders_id';

      if ( isset($customer_id) && is_numeric($customer_id) ) {
        $sql_query .= ' and customers_id = :customers_id';
      }

      $sql_query .= ' limit 1';

      $Qorder = $KUUZU_PDO->prepare($sql_query);

      if ( isset($customer_id) && is_numeric($customer_id) ) {
        $Qorder->bindInt(':customers_id', $customer_id);
      }

      $Qorder->bindInt(':orders_id', $id);
      $Qorder->execute();

      return ( $Qorder->fetch() !== false );
    }

    function query($order_id) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $Qorder = $KUUZU_PDO->prepare('select * from :table_orders where orders_id = :orders_id');
      $Qorder->bindInt(':orders_id', $order_id);
      $Qorder->execute();

      $Qtotals = $KUUZU_PDO->prepare('select title, text, class from :table_orders_total where orders_id = :orders_id order by sort_order');
      $Qtotals->bindInt(':orders_id', $order_id);
      $Qtotals->execute();

      $shipping_method_string = '';
      $order_total_string = '';

      while ( $Qtotals->fetch() ) {
        $this->totals[] = array('title' => $Qtotals->value('title'),
                                'text' => $Qtotals->value('text'));

        if ( $Qtotals->value('class') == 'Shipping' ) {
          $shipping_method_string = strip_tags($Qtotals->value('title'));

          if ( substr($shipping_method_string, -1) == ':' ) {
            $shipping_method_string = substr($Qtotals->value('title'), 0, -1);
          }
        }

        if ( $Qtotals->value('class') == 'Total' ) {
          $order_total_string = strip_tags($Qtotals->value('text'));
        }
      }

      $Qstatus = $KUUZU_PDO->prepare('select orders_status_name from :table_orders_status where orders_status_id = :orders_status_id and language_id = :language_id');
      $Qstatus->bindInt(':orders_status_id', $Qorder->valueInt('orders_status'));
      $Qstatus->bindInt(':language_id', $KUUZU_Language->getID());
      $Qstatus->execute();

      $this->info = array('currency' => $Qorder->value('currency'),
                          'currency_value' => $Qorder->value('currency_value'),
                          'payment_method' => $Qorder->value('payment_method'),
                          'date_purchased' => $Qorder->value('date_purchased'),
                          'orders_status' => $Qstatus->value('orders_status_name'),
                          'last_modified' => $Qorder->value('last_modified'),
                          'total' => $order_total_string,
                          'shipping_method' => $shipping_method_string);

      $this->customer = array('id' => $Qorder->valueInt('customers_id'),
                              'name' => $Qorder->valueProtected('customers_name'),
                              'company' => $Qorder->valueProtected('customers_company'),
                              'street_address' => $Qorder->valueProtected('customers_street_address'),
                              'suburb' => $Qorder->valueProtected('customers_suburb'),
                              'city' => $Qorder->valueProtected('customers_city'),
                              'postcode' => $Qorder->valueProtected('customers_postcode'),
                              'state' => $Qorder->valueProtected('customers_state'),
                              'zone_code' => $Qorder->value('customers_state_code'),
                              'country_title' => $Qorder->valueProtected('customers_country'),
                              'country_iso2' => $Qorder->value('customers_country_iso2'),
                              'country_iso3' => $Qorder->value('customers_country_iso3'),
                              'format' => $Qorder->value('customers_address_format'),
                              'telephone' => $Qorder->valueProtected('customers_telephone'),
                              'email_address' => $Qorder->valueProtected('customers_email_address'));

      $this->delivery = array('name' => $Qorder->valueProtected('delivery_name'),
                              'company' => $Qorder->valueProtected('delivery_company'),
                              'street_address' => $Qorder->valueProtected('delivery_street_address'),
                              'suburb' => $Qorder->valueProtected('delivery_suburb'),
                              'city' => $Qorder->valueProtected('delivery_city'),
                              'postcode' => $Qorder->valueProtected('delivery_postcode'),
                              'state' => $Qorder->valueProtected('delivery_state'),
                              'zone_code' => $Qorder->value('delivery_state_code'),
                              'country_title' => $Qorder->valueProtected('delivery_country'),
                              'country_iso2' => $Qorder->value('delivery_country_iso2'),
                              'country_iso3' => $Qorder->value('delivery_country_iso3'),
                              'format' => $Qorder->value('delivery_address_format'));

      if ( empty($this->delivery['name']) && empty($this->delivery['street_address']) ) {
        $this->delivery = false;
      }

      $this->billing = array('name' => $Qorder->valueProtected('billing_name'),
                             'company' => $Qorder->valueProtected('billing_company'),
                             'street_address' => $Qorder->valueProtected('billing_street_address'),
                             'suburb' => $Qorder->valueProtected('billing_suburb'),
                             'city' => $Qorder->valueProtected('billing_city'),
                             'postcode' => $Qorder->valueProtected('billing_postcode'),
                             'state' => $Qorder->valueProtected('billing_state'),
                             'zone_code' => $Qorder->value('billing_state_code'),
                             'country_title' => $Qorder->valueProtected('billing_country'),
                             'country_iso2' => $Qorder->value('billing_country_iso2'),
                             'country_iso3' => $Qorder->value('billing_country_iso3'),
                             'format' => $Qorder->value('billing_address_format'));

      $Qproducts = $KUUZU_PDO->prepare('select orders_products_id, products_id, products_name, products_model, products_price, products_tax, products_quantity from :table_orders_products where orders_id = :orders_id');
      $Qproducts->bindInt(':orders_id', $order_id);
      $Qproducts->execute();

      $index = 0;

      while ( $Qproducts->fetch() ) {
        $subindex = 0;

        $this->products[$index] = array('qty' => $Qproducts->valueInt('products_quantity'),
                                        'id' => $Qproducts->valueInt('products_id'),
                                        'name' => $Qproducts->value('products_name'),
                                        'model' => $Qproducts->value('products_model'),
                                        'tax' => $Qproducts->value('products_tax'),
                                        'price' => $Qproducts->value('products_price'));

        $Qvariants = $KUUZU_PDO->prepare('select group_title, value_title from :table_orders_products_variants where orders_id = :orders_id and orders_products_id = :orders_products_id order by id');
        $Qvariants->bindInt(':orders_id', $order_id);
        $Qvariants->bindInt(':orders_products_id', $Qproducts->valueInt('orders_products_id'));
        $Qvariants->execute();

        while ( $Qvariants->fetch() ) {
          $this->products[$index]['attributes'][$subindex] = array('option' => $Qvariants->value('group_title'),
                                                                   'value' => $Qvariants->value('value_title'));

          $subindex++;
        }

        $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

        $index++;
      }
    }
  }
?>
