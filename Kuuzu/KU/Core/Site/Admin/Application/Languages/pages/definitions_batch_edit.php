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
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . HTML::outputProtected($_GET['group']); ?></h3>

  <form name="lDefineBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchSaveDefinitions&Process&id=' . $_GET['id'] . '&group=' . $_GET['group']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_language_definitions'); ?></p>

  <fieldset>

<?php
  foreach ( $_POST['batch'] as $id ) {
    $KUUZU_ObjectInfo = new ObjectInfo(Languages::getDefinition($id));

    echo '<p><label for="def[' . $KUUZU_ObjectInfo->getProtected('definition_key') . ']">' . $KUUZU_ObjectInfo->getProtected('definition_key') . '</label>' . HTML::textareaField('def[' . $KUUZU_ObjectInfo->get('definition_key') . ']', $KUUZU_ObjectInfo->get('definition_value')) . HTML::hiddenField('batch[]', $KUUZU_ObjectInfo->getInt('id')) . '</p>';
  }
?>

  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id'] . '&group=' . $_GET['group']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
