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
  $('#cNewForm input, #cNewForm select, #cNewForm textarea, #cNewForm fileupload').safetynet();
});
</script>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<form id="cNewForm" name="cNew" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&cid=' . $KUUZU_Application->getCurrentCategoryID()); ?>" method="post" enctype="multipart/form-data">

<div id="formButtons" style="float: right;"><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('type' => 'button', 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'), 'params' => 'onclick="$.safetynet.suppressed(true); window.location.href=\'' . KUUZU::getLink(null, null, 'cid=' . $KUUZU_Application->getCurrentCategoryID()) . '\';"')); ?></div>

<div style="clear: both;"></div>

<div class="infoBox">
  <h3><?php echo HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_category'); ?></h3>

  <fieldset>
    <p><label for="parent_id"><?php echo KUUZU::getDef('field_parent_category'); ?></label><?php echo HTML::selectMenu('parent_id', array_merge(array(array('id' => '0', 'text' => KUUZU::getDef('top_category'))), $KUUZU_Application->getCategoryList()), $KUUZU_Application->getCurrentCategoryID()); ?></p>
    <p><label><?php echo KUUZU::getDef('field_name'); ?></label></p>

<?php
  foreach ( $KUUZU_Language->getAll() as $l ) {
    echo '<p>' . $KUUZU_Language->showImage($l['code']) . '&nbsp;' . $l['name'] . '<br />' . HTML::inputField('categories_name[' . $l['id'] . ']') . '</p>';
  }
?>

    <p><label><?php echo KUUZU::getDef('field_image'); ?></label></p>
    <p id="cImage" class="imageSelectorPlaceholder"></p>

    <p><label><?php echo KUUZU::getDef('field_image_browser'); ?></label></p>
    <div class="imageSelector">
      <ul id="cImages"></ul>

      <div id="fileUploader" style="padding-top: 50px; padding-left: 20px;"></div>
    </div>
  </fieldset>
</div>

</form>

<script>
function loadImageSelector() {
  $('#cImages').imageSelector({
    json: '<?php echo KUUZU::getRPCLink(null, null, 'GetAvailableImages'); ?>',
    imagePath: 'public/upload',
    show: 5,
    selector: 'cImage'
  });
}

$(function() {
  loadImageSelector();

  var uploader = new qq.FileUploader({
    element: document.getElementById('fileUploader'),
    action: '<?php echo KUUZU::getRPCLink(null, null, 'SaveUploadedImage'); ?>',
    allowedExtensions: ['gif', 'jpg', 'png'],
    textUpload: '<?php echo KUUZU::getDef('button_upload_new_file'); ?>',
    onComplete: function(id, fileName, responseJSON) {
      fileName = responseJSON.filename;

      loadImageSelector();

      $('#cImage').css('backgroundImage', 'none').html('<img src="public/upload/' + fileName + '" alt="' + fileName + '" title="' + fileName + '" onclick="window.open(this.src);" /><input type="hidden" name="cImageSelected" value="' + fileName + '" />');
    }
  });
});
</script>
