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
  if ( $KUUZU_MessageStack->exists('LogIn') ) {
    echo $KUUZU_MessageStack->get('LogIn');
  }
?>

<div class="moduleBox" style="width: 49%; float: right;">
  <form name="login" action="<?php echo KUUZU::getLink(null, null, 'LogIn&Process', 'SSL'); ?>" method="post">

  <h6><?php echo KUUZU::getDef('login_returning_customer_heading'); ?></h6>

  <div class="content">
    <p><?php echo KUUZU::getDef('login_returning_customer_text'); ?></p>

    <ol>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_email_address'), 'email_address') . HTML::inputField('email_address'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_password'), 'password') . HTML::passwordField('password'); ?></li>
    </ol>

    <p><?php echo sprintf(KUUZU::getDef('login_returning_customer_password_forgotten'), KUUZU::getLink(null, null, 'PasswordForgotten', 'SSL')); ?></p>

    <p align="right"><?php echo HTML::button(array('icon' => 'key', 'title' => KUUZU::getDef('button_sign_in'))); ?></p>
  </div>

  </form>
</div>

<div class="moduleBox" style="width: 49%;">
  <div class="outsideHeading">
    <h6><?php echo KUUZU::getDef('login_new_customer_heading'); ?></h6>
  </div>

  <div class="content">
    <p><?php echo KUUZU::getDef('login_new_customer_text'); ?></p>

    <p align="right"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Create', 'SSL'), 'icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></p>
  </div>
</div>
