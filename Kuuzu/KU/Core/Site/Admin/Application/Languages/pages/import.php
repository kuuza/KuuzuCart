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
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;

  $languages_array = array();

  foreach ( Languages::getDirectoryListing() as $directory ) {
    $languages_array[] = array('id' => $directory,
                               'text' => $directory);
  }
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_import_language'); ?></h3>

  <form name="lImport" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Import&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_import_language'); ?></p>

  <fieldset>
    <p><label for="language_import"><?php echo KUUZU::getDef('field_language_selection'); ?></label><?php echo HTML::selectMenu('language_import', $languages_array); ?></p>
    <p><label for="import_type"><?php echo KUUZU::getDef('field_import_type'); ?></label><br /><?php echo HTML::radioField('import_type', array(array('id' => 'add', 'text' => KUUZU::getDef('only_add_new_records')), array('id' => 'update', 'text' => KUUZU::getDef('only_update_existing_records')), array('id' => 'replace', 'text' => KUUZU::getDef('replace_all'))), 'add', null, '<br />'); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'triangle-1-se', 'title' => KUUZU::getDef('button_import'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
