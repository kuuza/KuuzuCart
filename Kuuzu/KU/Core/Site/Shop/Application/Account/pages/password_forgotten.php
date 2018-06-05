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
  if ( $KUUZU_MessageStack->exists('PasswordForgotten') ) {
    echo $KUUZU_MessageStack->get('PasswordForgotten');
  }
?>

<form name="password_forgotten" action="<?php echo KUUZU::getLink(null, null, 'PasswordForgotten&Process', 'SSL'); ?>" method="post" onsubmit="return check_form(password_forgotten);">

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('password_forgotten_heading'); ?></h6>

  <div class="content">
    <p><?php echo KUUZU::getDef('password_forgotten'); ?></p>

    <ol>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_email_address'), 'email_address') . HTML::inputField('email_address'); ?></li>
    </ol>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, null, 'SSL'), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>

</form>
