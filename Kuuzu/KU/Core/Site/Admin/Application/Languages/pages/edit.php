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
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;
  use Kuuzu\KU\Core\Site\Admin\Application\Currencies\Currencies;

  $languages_array = array(array('id' => '0',
                                 'text' => KUUZU::getDef('none')));

  foreach ( ObjectInfo::to(Languages::getAll(-1))->get('entries') as $l ) {
    if ( $l['languages_id'] != $_GET['id'] ) {
      $languages_array[] = array('id' => $l['languages_id'],
                                 'text' => $l['name'] . ' (' . $l['code'] . ')');
    }
  }

  $currencies_array = array();

  foreach ( ObjectInfo::to(Currencies::getAll(-1))->get('entries') as $c ) {
    $currencies_array[] = array('id' => $c['currencies_id'],
                                'text' => $c['title']);
  }

  $KUUZU_ObjectInfo = new ObjectInfo(Languages::get($_GET['id']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('name'); ?></h3>

  <form name="lEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_language'); ?></p>

  <fieldset>
    <p><label for="name"><?php echo KUUZU::getDef('field_name'); ?></label><?php echo HTML::inputField('name', $KUUZU_ObjectInfo->get('name')); ?></p>
    <p><label for="code"><?php echo KUUZU::getDef('field_code'); ?></label><?php echo HTML::inputField('code', $KUUZU_ObjectInfo->get('code')); ?></p>
    <p><label for="locale"><?php echo KUUZU::getDef('field_locale'); ?></label><?php echo HTML::inputField('locale', $KUUZU_ObjectInfo->get('locale')); ?></p>
    <p><label for="charset"><?php echo KUUZU::getDef('field_character_set'); ?></label><?php echo HTML::inputField('charset', $KUUZU_ObjectInfo->get('charset')); ?></p>
    <p><label for="text_direction"><?php echo KUUZU::getDef('field_text_direction'); ?></label><?php echo HTML::selectMenu('text_direction', array(array('id' => 'ltr', 'text' => 'ltr'), array('id' => 'rtl', 'text' => 'rtl')), $KUUZU_ObjectInfo->get('text_direction')); ?></p>
    <p><label for="date_format_short"><?php echo KUUZU::getDef('field_date_format_short'); ?></label><?php echo HTML::inputField('date_format_short', $KUUZU_ObjectInfo->get('date_format_short')); ?></p>
    <p><label for="date_format_long"><?php echo KUUZU::getDef('field_date_format_long'); ?></label><?php echo HTML::inputField('date_format_long', $KUUZU_ObjectInfo->get('date_format_long')); ?></p>
    <p><label for="time_format"><?php echo KUUZU::getDef('field_time_format'); ?></label><?php echo HTML::inputField('time_format', $KUUZU_ObjectInfo->get('time_format')); ?></p>
    <p><label for="currencies_id"><?php echo KUUZU::getDef('field_currency'); ?></label><?php echo HTML::selectMenu('currencies_id', $currencies_array, $KUUZU_ObjectInfo->get('currencies_id')); ?></p>
    <p><label for="numeric_separator_decimal"><?php echo KUUZU::getDef('field_currency_separator_decimal'); ?></label><?php echo HTML::inputField('numeric_separator_decimal', $KUUZU_ObjectInfo->get('numeric_separator_decimal')); ?></p>
    <p><label for="numeric_separator_thousands"><?php echo KUUZU::getDef('field_currency_separator_thousands'); ?></label><?php echo HTML::inputField('numeric_separator_thousands', $KUUZU_ObjectInfo->get('numeric_separator_thousands')); ?></p>
    <p><label for="parent_id"><?php echo KUUZU::getDef('field_parent_language'); ?></label><?php echo HTML::selectMenu('parent_id', $languages_array, $KUUZU_ObjectInfo->get('parent_id')); ?></p>
    <p><label for="sort_order"><?php echo KUUZU::getDef('field_sort_order'); ?></label><?php echo HTML::inputField('sort_order', $KUUZU_ObjectInfo->get('sort_order')); ?></p>

<?php
    if ( $KUUZU_ObjectInfo->get('code') != DEFAULT_LANGUAGE ) {
?>

    <p><label for="default"><?php echo KUUZU::getDef('field_set_default'); ?></label><?php echo HTML::checkboxField('default'); ?></p>

<?php
    }
?>

  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
