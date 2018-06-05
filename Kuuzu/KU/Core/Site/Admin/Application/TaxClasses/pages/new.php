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
  <h3><?php echo HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_tax_class'); ?></h3>

  <form name="tcNew" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_new_tax_class'); ?></p>

  <fieldset>
    <p><label for="tax_class_title"><?php echo KUUZU::getDef('field_title'); ?></label><?php echo HTML::inputField('tax_class_title'); ?></p>
    <p><label for="tax_class_description"><?php echo KUUZU::getDef('field_description'); ?></label><?php echo HTML::inputField('tax_class_description'); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
