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
  use Kuuzu\KU\Core\Site\Admin\Application\Customers\Customers;

  $new_customer = true;

  if ( ACCOUNT_GENDER > -1 ) {
    $gender_array = array(array('id' => 'm', 'text' => KUUZU::getDef('gender_male')),
                          array('id' => 'f', 'text' => KUUZU::getDef('gender_female')));
  }
?>

<script>
$(function() {
  $('#cEditForm input, #cEditForm select, #cEditForm textarea, #cEditForm fileupload').safetynet();
});
</script>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div id="sectionMenuContainer" style="float: left; padding-bottom: 10px;">
  <span class="ui-widget-header ui-corner-all" style="padding: 10px 4px;">
    <span id="sectionMenu"><?php echo HTML::radioField('sections', array(array('id' => 'personal', 'text' => KUUZU::getDef('section_personal')), array('id' => 'password', 'text' => KUUZU::getDef('section_password')), array('id' => 'addressBook', 'text' => KUUZU::getDef('section_address_book')), array('id' => 'newsletters', 'text' => KUUZU::getDef('section_newsletters')), array('id' => 'map', 'text' => KUUZU::getDef('section_map')), array('id' => 'social', 'text' => KUUZU::getDef('section_social'))), (isset($_GET['tabIndex']) ? $_GET['tabIndex'] : null), null, ''); ?></span>
  </span>
</div>

<script>
$(function() {
  $('#sectionMenu').buttonsetTabs();
});
</script>

<form id="cEditForm" name="cEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process'); ?>" method="post">

<div id="formButtons" style="float: right;"><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('type' => 'button', 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'), 'params' => 'onclick="$.safetynet.suppressed(true); window.location.href=\'' . KUUZU::getLink() . '\';"')); ?></div>

<div style="clear: both;"></div>

<?php
// HPDL Modularize, zack zack!
  include('section_personal.php');
  include('section_password.php');
  include('section_addressBook.php');
  include('section_newsletters.php');
  include('section_map.php');
  include('section_social.php');
?>

</form>
