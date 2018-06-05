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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Address;
?>

<ol>

<?php
  if ( ACCOUNT_GENDER > -1 ) {
    $gender_array = array(array('id' => 'm', 'text' => KUUZU::getDef('gender_male')),
                          array('id' => 'f', 'text' => KUUZU::getDef('gender_female')));
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_gender'), 'gender_1', null, (ACCOUNT_GENDER > 0)) . HTML::radioField('gender', $gender_array, (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('gender') ? $Kuu_oiAddress->get('gender') : (!$KUUZU_Customer->hasDefaultAddress() ? $KUUZU_Customer->getGender() : null))); ?></li>

<?php
  }
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_first_name'), 'firstname', null, true) . HTML::inputField('firstname', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('firstname') ? $Kuu_oiAddress->get('firstname') : (!$KUUZU_Customer->hasDefaultAddress() ? $KUUZU_Customer->getFirstName() : null))); ?></tli>
  <li><?php echo HTML::label(KUUZU::getDef('field_customer_last_name'), 'lastname', null, true) . HTML::inputField('lastname', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('lastname') ? $Kuu_oiAddress->get('lastname') : (!$KUUZU_Customer->hasDefaultAddress() ? $KUUZU_Customer->getLastName() : null))); ?></li>

<?php
  if ( ACCOUNT_COMPANY > -1 ) {
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_company'), 'company', null, (ACCOUNT_COMPANY > 0)) . HTML::inputField('company', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('company') ? $Kuu_oiAddress->get('company') : null)); ?></li>

<?php
  }
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_street_address'), 'street_address', null, true) . HTML::inputField('street_address', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('street_address') ? $Kuu_oiAddress->get('street_address') : null)); ?></li>

<?php
  if ( ACCOUNT_SUBURB > -1 ) {
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_suburb'), 'suburb', null, (ACCOUNT_SUBURB > 0)) . HTML::inputField('suburb', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('suburb') ? $Kuu_oiAddress->get('suburb') : null)); ?></li>

<?php
  }

  if ( ACCOUNT_POST_CODE > -1 ) {
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_post_code'), 'postcode', null, (ACCOUNT_POST_CODE > 0)) . HTML::inputField('postcode', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('postcode') ? $Kuu_oiAddress->get('postcode') : null)); ?></li>

<?php
  }
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_city'), 'city', null, true) . HTML::inputField('city', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('city') ? $Kuu_oiAddress->get('city') : null)); ?></li>

<?php
  if ( ACCOUNT_STATE > -1 ) {
?>

  <li>

<?php
    echo HTML::label(KUUZU::getDef('field_customer_state'), 'state', null, (ACCOUNT_STATE > 0));

    if ( isset($entry_state_has_zones) ) { // HPDL
      if ( $entry_state_has_zones === true ) {
        $Qzones = $KUUZU_PDO->prepare('select zone_name from :table_zones where zone_country_id = :zone_country_id order by zone_name');
        $Qzones->bindInt(':zone_country_id', $_POST['country']);
        $Qzones->execute();

        $zones_array = array();
        while ( $Qzones->fetch() ) {
          $zones_array[] = array('id' => $Qzones->value('zone_name'),
                                 'text' => $Qzones->value('zone_name'));
        }

        echo HTML::selectMenu('state', $zones_array);
      } else {
        echo HTML::inputField('state');
      }
    } else {
      $zone = null;

      if ( isset($Kuu_oiAddress) ) {
        if ( $Kuu_oiAddress->exists('zone_id') && ($Kuu_oiAddress->getInt('zone_id') > 0) ) {
          $zone = Address::getZoneName($Kuu_oiAddress->getInt('zone_id'));
        } elseif ( $Kuu_oiAddress->exists('state') ) {
          $zone = $Kuu_oiAddress->get('state');
        }
      }

      echo HTML::inputField('state', $zone);
    }
?>

  </li>

<?php
  }
?>

  <li>

<?php
  echo HTML::label(KUUZU::getDef('field_customer_country'), 'country', null, true);

  $countries_array = array(array('id' => '',
                                 'text' => KUUZU::getDef('pull_down_default')));

  foreach ( Address::getCountries() as $country ) {
    $countries_array[] = array('id' => $country['id'],
                               'text' => $country['name']);
  }

  echo HTML::selectMenu('country', $countries_array, (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('country_id') ? $Kuu_oiAddress->getInt('country_id') : STORE_COUNTRY));
?>

  </li>

<?php
  if ( ACCOUNT_TELEPHONE > -1 ) {
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_telephone_number'), 'telephone', null, (ACCOUNT_TELEPHONE > 0)) . HTML::inputField('telephone', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('telephone') ? $Kuu_oiAddress->get('telephone') : null)); ?></li>

<?php
  }

  if ( ACCOUNT_FAX > -1 ) {
?>

  <li><?php echo HTML::label(KUUZU::getDef('field_customer_fax_number'), 'fax', null, (ACCOUNT_FAX > 0)) . HTML::inputField('fax', (isset($Kuu_oiAddress) && $Kuu_oiAddress->exists('fax') ? $Kuu_oiAddress->get('fax') : null)); ?></li>

<?php
  }

  if ( $KUUZU_Customer->hasDefaultAddress() && ((isset($_GET['Edit']) && ($KUUZU_Customer->getDefaultAddressID() != $_GET['Edit'])) || isset($_GET['Create'])) ) {
?>

  <li><?php echo HTML::checkboxField('primary', array(array('id' => 'on', 'text' => KUUZU::getDef('set_as_primary'))), false); ?></li>

<?php
  }
?>

</ol>
