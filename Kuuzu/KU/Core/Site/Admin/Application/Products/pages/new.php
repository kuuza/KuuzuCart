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

  $new_product = true;
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div id="sectionMenuContainer" style="float: left; padding-bottom: 10px;">
  <span class="ui-widget-header ui-corner-all" style="padding: 10px 4px;">
    <span id="sectionMenu"><?php echo HTML::radioField('sections', array(array('id' => 'general', 'text' => KUUZU::getDef('section_general')), array('id' => 'data', 'text' => KUUZU::getDef('section_data')), array('id' => 'images', 'text' => KUUZU::getDef('section_images')), array('id' => 'variants', 'text' => KUUZU::getDef('section_variants')), array('id' => 'categories', 'text' => KUUZU::getDef('section_categories'))), (isset($_GET['tabIndex']) ? $_GET['tabIndex'] : null), null, ''); ?></span>
  </span>
</div>

<form id="pEditForm" name="product" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&cid=' . $KUUZU_Application->getCurrentCategoryID()); ?>" method="post">

<div id="formButtons" style="float: right;"><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('type' => 'button', 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'), 'params' => 'onclick="$.safetynet.suppressed(true); window.location.href=\'' . KUUZU::getLink(null, null, 'cid=' . $KUUZU_Application->getCurrentCategoryID()) . '\';"')); ?></div>

<div style="clear: both;"></div>

<?php
// HPDL Modularize, zack zack!
  include('section_general.php');
  include('section_data.php');
  include('section_images.php');
  include('section_variants.php');
  include('section_categories.php');
?>

</form>

<script>
$(function() {
  $('#sectionMenu').buttonsetTabs();

  $('#pEditForm input, #pEditForm select, #pEditForm textarea, #pEditForm fileupload').safetynet();
});
</script>
