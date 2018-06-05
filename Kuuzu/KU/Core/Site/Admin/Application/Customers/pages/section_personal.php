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

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
?>

<div id="sectionMenu_personal">
  <div class="infoBox">

<?php
  if ( $new_customer ) {
    echo '<h3>' . HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_customer') . '</h3>';
  } else {
    echo '<h3>' . HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('customers_name') . '</h3>';
  }
?>

    <fieldset>

<?php
  if ( ACCOUNT_GENDER > -1 ) {
?>

      <p id="genderFields"><label for="gender"><?php echo KUUZU::getDef('field_gender'); ?></label><?php echo HTML::radioField('gender', $gender_array, ($new_customer ? 'm' : $KUUZU_ObjectInfo->get('customers_gender')), null, ''); ?></p>

      <script>$('#genderFields').buttonset();</script>

<?php
  }
?>

      <p><label for="firstname"><?php echo KUUZU::getDef('field_first_name'); ?></label><?php echo HTML::inputField('firstname', ($new_customer ? null : $KUUZU_ObjectInfo->get('customers_firstname'))); ?></p>
      <p><label for="lastname"><?php echo KUUZU::getDef('field_last_name'); ?></label><?php echo HTML::inputField('lastname', ($new_customer ? null : $KUUZU_ObjectInfo->get('customers_lastname'))); ?></p>

<?php
  if ( ACCOUNT_DATE_OF_BIRTH == '1' ) {
?>

      <p><label for="dob"><?php echo KUUZU::getDef('field_date_of_birth'); ?></label><?php echo HTML::inputField('dob', ($new_customer ? null : DateTime::fromUnixTimestamp(DateTime::getTimestamp($KUUZU_ObjectInfo->get('customers_dob')), 'Y-m-d'))); ?></p>

      <script>$('#dob').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '-100:+0'});</script>

<?php
  }
?>

      <p><label for="email_address"><?php echo KUUZU::getDef('field_email_address'); ?></label><?php echo HTML::inputField('email_address', ($new_customer ? null : $KUUZU_ObjectInfo->get('customers_email_address'))); ?></p>
      <p><label for="status"><?php echo KUUZU::getDef('field_status'); ?></label><?php echo HTML::checkboxField('status', null, ($new_customer ? true : ($KUUZU_ObjectInfo->get('customers_status') == '1'))); ?></p>
    </fieldset>
  </div>
</div>
