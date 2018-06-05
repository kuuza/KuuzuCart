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
  if ( $KUUZU_MessageStack->exists('Contact') ) {
    echo $KUUZU_MessageStack->get('Contact');
  }
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('contact_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px;">
      <?php echo nl2br(STORE_NAME_ADDRESS); ?>
    </div>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('contact_store_address_title') . '</b>'; ?>
    </div>

    <p style="margin-top: 0px;"><?php echo KUUZU::getDef('contact'); ?></p>

    <div style="clear: both;"></div>
  </div>
</div>

<form name="contact" action="<?php echo KUUZU::getLink(null, null, 'Contact&Process'); ?>" method="post">

<div class="moduleBox">
  <div class="content">
    <ol>
      <li><?php echo HTML::label(KUUZU::getDef('contact_name_title'), 'name') . HTML::inputField('name'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('contact_email_address_title'), 'email') . HTML::inputField('email'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('contact_enquiry_title'), 'enquiry') . HTML::textareaField('enquiry', null, 50, 15); ?></li>
    </ol>
  </div>
</div>

<div class="submitFormButtons" style="text-align: right;">
  <?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
</div>

</form>
