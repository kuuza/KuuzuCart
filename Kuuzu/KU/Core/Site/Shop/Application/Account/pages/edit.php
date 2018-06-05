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
  use Kuuzu\KU\Core\Site\Shop\Account;

  $Qaccount = Account::getEntry();
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('Edit') ) {
    echo $KUUZU_MessageStack->get('Edit');
  }
?>

<form name="account_edit" action="<?php echo KUUZU::getLink(null, null, 'Edit&Process', 'SSL'); ?>" method="post" onsubmit="return check_form(account_edit);">

<div class="moduleBox">
  <em style="float: right; margin-top: 10px;"><?php echo KUUZU::getDef('form_required_information'); ?></em>

  <h6><?php echo KUUZU::getDef('my_account_title'); ?></h6>

  <div class="content">
    <ol>

<?php
  if ( ACCOUNT_GENDER > -1 ) {
    $gender_array = array(array('id' => 'm', 'text' => KUUZU::getDef('gender_male')),
                          array('id' => 'f', 'text' => KUUZU::getDef('gender_female')));
?>

      <li><?php echo HTML::label(KUUZU::getDef('field_customer_gender'), 'gender_1', null, (ACCOUNT_GENDER > 0)) . HTML::radioField('gender', $gender_array, $Qaccount->value('customers_gender')); ?></li>

<?php
  }
?>

      <li><?php echo HTML::label(KUUZU::getDef('field_customer_first_name'), 'firstname', null, true) . ' ' . HTML::inputField('firstname', $Qaccount->value('customers_firstname')); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_last_name'), 'lastname', null, true) . ' ' . HTML::inputField('lastname', $Qaccount->value('customers_lastname')); ?></li>

<?php
  if ( ACCOUNT_DATE_OF_BIRTH == '1' ) {
?>

      <li><?php echo HTML::label(KUUZU::getDef('field_customer_date_of_birth'), 'dob_days', null, true) . ' ' . HTML::dateSelectMenu('dob', array('year' => $Qaccount->value('customers_dob_year'), 'month' => $Qaccount->value('customers_dob_month'), 'date' => $Qaccount->value('customers_dob_date')), false, null, null, date('Y')-1901, -5); ?></li>

<?php
  }
?>

      <li><?php echo HTML::label(KUUZU::getDef('field_customer_email_address'), 'email_address', null, true) . ' ' . HTML::inputField('email_address', $Qaccount->value('customers_email_address')); ?></li>
    </ol>
  </div>
</div>

<div class="submitFormButtons" style="text-align: right;">
  <?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
</div>

</form>
