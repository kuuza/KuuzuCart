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
  use Kuuzu\KU\Core\Site\Admin\Application\Currencies\Currencies;

  $KUUZU_ObjectInfo = new ObjectInfo(Currencies::get($_GET['id']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('title'); ?></h3>

  <form name="cEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_currency'); ?></p>

  <fieldset>
    <p><label for="title"><?php echo KUUZU::getDef('field_title'); ?></label><?php echo HTML::inputField('title', $KUUZU_ObjectInfo->get('title')); ?></p>
    <p><label for="code"><?php echo KUUZU::getDef('field_code'); ?></label><?php echo HTML::inputField('code', $KUUZU_ObjectInfo->get('code')); ?></p>
    <p><label for="symbol_left"><?php echo KUUZU::getDef('field_symbol_left'); ?></label><?php echo HTML::inputField('symbol_left', $KUUZU_ObjectInfo->get('symbol_left')); ?></p>
    <p><label for="symbol_right"><?php echo KUUZU::getDef('field_symbol_right'); ?></label><?php echo HTML::inputField('symbol_right', $KUUZU_ObjectInfo->get('symbol_right')); ?></p>
    <p><label for="decimal_places"><?php echo KUUZU::getDef('field_decimal_places'); ?></label><?php echo HTML::inputField('decimal_places', $KUUZU_ObjectInfo->get('decimal_places')); ?></p>
    <p><label for="value"><?php echo KUUZU::getDef('field_currency_value'); ?></label><?php echo HTML::inputField('value', $KUUZU_ObjectInfo->get('value')); ?></p>

<?php
    if ( $KUUZU_ObjectInfo->get('code') != DEFAULT_CURRENCY ) {
?>

    <p><label for="default"><?php echo KUUZU::getDef('field_set_default'); ?></label><?php echo HTML::checkboxField('default'); ?></p>

<?php
    }
?>

  </fieldset>

  <p>

<?php
  if ( $KUUZU_ObjectInfo->get('code') == DEFAULT_CURRENCY ) {
    echo HTML::hiddenField('is_default', 'true');
  }

  echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel')));
?>

  </p>

  </form>
</div>
