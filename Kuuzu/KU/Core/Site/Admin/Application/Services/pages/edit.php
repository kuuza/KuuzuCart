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
  use Kuuzu\KU\Core\Site\Admin\Application\Services\Services;

  $KUUZU_ObjectInfo = new ObjectInfo(Services::get($_GET['code']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('title'); ?></h3>

  <form name="mEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&code=' . $KUUZU_ObjectInfo->get('code')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_service_module'); ?></p>

<?php
  $keys = '';

  foreach ( $KUUZU_ObjectInfo->get('keys') as $key ) {
    $key_data = KUUZU::callDB('Admin\Configuration\EntryGet', array('key' => $key));

    $keys .= '<b>' . $key_data['configuration_title'] . '</b><br />' . $key_data['configuration_description'] . '<br />';

    if ( strlen($key_data['set_function']) > 0 ) {
      $keys .= Configuration::callUserFunc($key_data['set_function'], $key_data['configuration_value'], $key);
    } else {
      $keys .= HTML::inputField('configuration[' . $key . ']', $key_data['configuration_value']);
    }

    $keys .= '<br /><br />';
  }

  $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));
?>

  <p><?php echo $keys; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
