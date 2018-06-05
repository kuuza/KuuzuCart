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
  use Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\PaymentModules;

  $KUUZU_ObjectInfo = new ObjectInfo(PaymentModules::get($_GET['code']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('title'); ?></h3>

  <form name="pmEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&code=' . $KUUZU_ObjectInfo->get('code')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_payment_module'); ?></p>

  <fieldset>

<?php
  $keys = '';

  foreach ( $KUUZU_ObjectInfo->get('keys') as $key ) {
    $Qkey = $KUUZU_PDO->prepare('select configuration_title, configuration_value, configuration_description, use_function, set_function from :table_configuration where configuration_key = :configuration_key');
    $Qkey->bindValue(':configuration_key', $key);
    $Qkey->execute();

    $keys .= '<p><label for="' . $key . '">' . $Qkey->value('configuration_title') . '</label><br />' . $Qkey->value('configuration_description');

    if ( strlen($Qkey->value('set_function')) > 0 ) {
      $keys .= Configuration::callUserFunc($Qkey->value('set_function'), $Qkey->value('configuration_value'), $key);
    } else {
      $keys .= HTML::inputField('configuration[' . $key . ']', $Qkey->value('configuration_value'));
    }

    $keys .= '</p>';
  }

  echo $keys;
?>

  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
