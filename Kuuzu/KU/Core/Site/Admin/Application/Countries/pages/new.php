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

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_country'); ?></h3>

  <form name="cNew" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_new_country'); ?></p>

  <fieldset>
    <p><label for="countries_name"><?php echo KUUZU::getDef('field_name'); ?></label><?php echo HTML::inputField('countries_name'); ?></p>
    <p><label for="countries_iso_code_2"><?php echo KUUZU::getDef('field_iso_code_2'); ?></label><?php echo HTML::inputField('countries_iso_code_2'); ?></p>
    <p><label for="countries_iso_code_3"><?php echo KUUZU::getDef('field_iso_code_3'); ?></label><?php echo HTML::inputField('countries_iso_code_3'); ?></p>
    <p><label for="address_format"><?php echo KUUZU::getDef('field_address_format'); ?></label><?php echo HTML::textareaField('address_format'); ?><br /><i>:name</i>, <i>:street_address</i>, <i>:suburb</i>, <i>:city</i>, <i>:postcode</i>, <i>:state</i>, <i>:state_code</i>, <i>:country</i></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
