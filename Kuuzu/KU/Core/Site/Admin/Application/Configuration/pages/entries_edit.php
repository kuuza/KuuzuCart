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
  use Kuuzu\KU\Core\Site\Admin\Application\Configuration\Configuration;

  $KUUZU_ObjectInfo = new ObjectInfo(Configuration::getEntry($_GET['pID']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }

  if ( strlen($KUUZU_ObjectInfo->get('set_function')) > 0 ) {
    $value_field = Configuration::callUserFunc($KUUZU_ObjectInfo->get('set_function'), $KUUZU_ObjectInfo->get('configuration_value'), $KUUZU_ObjectInfo->get('configuration_key'));
  } else {
    $value_field = HTML::inputField('configuration[' . $KUUZU_ObjectInfo->get('configuration_key') . ']', $KUUZU_ObjectInfo->get('configuration_value'));
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('configuration_title'); ?></h3>

  <form name="cEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'EntrySave&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_parameter'); ?></p>

  <fieldset>
    <p><label for="configuration[<?php echo $KUUZU_ObjectInfo->get('configuration_key'); ?>]"><?php echo $KUUZU_ObjectInfo->getProtected('configuration_title'); ?></label><?php echo $value_field; ?></p>
    <p><?php echo $KUUZU_ObjectInfo->get('configuration_description'); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
