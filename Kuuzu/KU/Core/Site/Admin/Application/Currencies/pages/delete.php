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
  <h3><?php echo HTML::icon('trash.png') . ' ' . $KUUZU_ObjectInfo->getProtected('title'); ?></h3>

<?php
  if ( $KUUZU_ObjectInfo->get('code') == DEFAULT_CURRENCY ) {
?>

  <p><?php echo '<b>' . KUUZU::getDef('introduction_delete_currency_invalid') . '</b>'; ?></p>

  <p><?php echo HTML::button(array('href' => KUUZU::getLink(), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?></p>

<?php
  } else {
?>

  <form name="cDelete" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Delete&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_delete_currency'); ?></p>

  <p><?php echo '<b>' . $KUUZU_ObjectInfo->getProtected('title') . '</b>'; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>

<?php
  }
?>

</div>
