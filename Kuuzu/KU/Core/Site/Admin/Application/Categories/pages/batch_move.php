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
?>

<script>
$(function() {
  $('#cMoveBatchForm input, #cMoveBatchForm select, #cMoveBatchForm textarea, #cMoveBatchForm fileupload').safetynet();
});
</script>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<form id="cMoveBatchForm" name="cMoveBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchMove&Process&cid=' . $KUUZU_Application->getCurrentCategoryID()); ?>" method="post">

<div id="formButtons" style="float: right;"><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('type' => 'button', 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'), 'params' => 'onclick="$.safetynet.suppressed(true); window.location.href=\'' . KUUZU::getLink(null, null, 'cid=' . $KUUZU_Application->getCurrentCategoryID()) . '\';"')); ?></div>

<div style="clear: both;"></div>

<div class="infoBox">
  <h3><?php echo HTML::icon('move.png') . ' ' . KUUZU::getDef('action_heading_batch_move_categories'); ?></h3>

  <p><?php echo KUUZU::getDef('introduction_batch_move_categories'); ?></p>

  <fieldset>

<?php
  $categories = '';

  foreach ( $_POST['batch'] as $c ) {
    $categories .= HTML::hiddenField('batch[]', $c) . '<b>' . $KUUZU_CategoryTree->getData($c, 'name') . '</b>, ';
  }

  if ( !empty($categories) ) {
    $categories = substr($categories, 0, -2);
  }

  echo '<p>' . $categories . '</p>';
?>

    <p><label for="parent_id"><?php echo KUUZU::getDef('field_parent_category'); ?></label><?php echo HTML::selectMenu('parent_id', array_merge(array(array('id' => '0', 'text' => KUUZU::getDef('top_category'))), $KUUZU_Application->getCategoryList()), $KUUZU_Application->getCurrentCategoryID()); ?></p>
  </fieldset>
</div>

</form>
