<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  $Kuu_ObjectInfo = new Kuu_ObjectInfo(Kuu_Products_Admin::get($_GET[$Kuu_Template->getModule()]));
?>

<h1><?php echo kuu_link_object(kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule()), $Kuu_Template->getPageTitle()); ?></h1>

<?php
  if ( $Kuu_MessageStack->exists($Kuu_Template->getModule()) ) {
    echo $Kuu_MessageStack->get($Kuu_Template->getModule());
  }
?>

<div class="infoBoxHeading"><?php echo kuu_icon('trash.png') . ' ' . $Kuu_ObjectInfo->getProtected('products_name'); ?></div>
<div class="infoBoxContent">
  <form name="pDelete" class="dataForm" action="<?php echo kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '=' . $Kuu_ObjectInfo->getInt('products_id') . '&cID=' . $_GET['cID'] . '&action=delete'); ?>" method="post">

  <p><?php echo $Kuu_Language->get('introduction_delete_product'); ?></p>

  <p><?php echo '<b>' . $Kuu_ObjectInfo->getProtected('products_name') . '</b>'; ?></p>

  <p align="center"><?php echo kuu_draw_hidden_field('subaction', 'confirm') . '<input type="submit" value="' . $Kuu_Language->get('button_delete') . '" class="operationButton" /> <input type="button" value="' . $Kuu_Language->get('button_cancel') . '" onclick="document.location.href=\'' . kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '&cID=' . $_GET['cID']) . '\';" class="operationButton" />'; ?></p>

  </form>
</div>
