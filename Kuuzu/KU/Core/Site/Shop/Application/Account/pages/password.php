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
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('Password') ) {
    echo $KUUZU_MessageStack->get('Password');
  }
?>

<form name="account_password" action="<?php echo KUUZU::getLink(null, null, 'Password&Process', 'SSL'); ?>" method="post" onsubmit="return check_form(account_edit);">

<div class="moduleBox">
  <em style="float: right; margin-top: 10px;"><?php echo KUUZU::getDef('form_required_information'); ?></em>

  <h6><?php echo KUUZU::getDef('my_password_title'); ?></h6>

  <div class="content">
    <ol>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_password_current'), 'password_current', null, true) . HTML::passwordField('password_current'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_password_new'), 'password_new', null, true) . HTML::passwordField('password_new'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_password_confirmation'), 'password_confirmation', null, true) . HTML::passwordField('password_confirmation'); ?></li>
    </ol>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, null, 'SSL'), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>

</form>
