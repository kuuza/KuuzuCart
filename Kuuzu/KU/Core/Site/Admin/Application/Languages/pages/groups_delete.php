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

  $KUUZU_ObjectInfo = new ObjectInfo(Languages::getGroup($_GET['group']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . HTML::outputProtected($_GET['group']); ?></h3>

  <form name="gDelete" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'DeleteGroup&Process&id=' . $_GET['id'] . '&group=' . $_GET['group']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_delete_definition_group'); ?></p>

  <p><?php echo '<b>' . HTML::outputProtected($_GET['group']) . '</b>'; ?></p>

  <p>

<?php
  foreach ( $KUUZU_ObjectInfo->get('entries') as $l ) {
    echo Languages::get($l['languages_id'], 'name') . ': ' . (int)$l['total_entries'] . '<br />';
  }
?>

  </p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
