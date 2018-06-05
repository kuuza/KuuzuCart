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
  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Admin\Application\CreditCards\CreditCards;

  $KUUZU_ObjectInfo = new ObjectInfo(CreditCards::get($_GET['id']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('credit_card_name'); ?></h3>

  <form name="ccEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&id=' . $KUUZU_ObjectInfo->getInt('id')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_card'); ?></p>

  <fieldset>
    <p><label for="credit_card_name"><?php echo KUUZU::getDef('field_name'); ?></label><?php echo HTML::inputField('credit_card_name', $KUUZU_ObjectInfo->get('credit_card_name')); ?></p>
    <p><label for="pattern"><?php echo KUUZU::getDef('field_pattern'); ?></label><?php echo HTML::inputField('pattern', $KUUZU_ObjectInfo->get('pattern')); ?></p>
    <p><label for="sort_order"><?php echo KUUZU::getDef('field_sort_order'); ?></label><?php echo HTML::inputField('sort_order', $KUUZU_ObjectInfo->get('sort_order')); ?></p>
    <p><label for="credit_card_status"><?php echo KUUZU::getDef('field_status'); ?></label><?php echo HTML::checkboxField('credit_card_status', '1', $KUUZU_ObjectInfo->get('credit_card_status')); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
