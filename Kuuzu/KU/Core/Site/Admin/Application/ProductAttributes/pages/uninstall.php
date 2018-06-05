<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  include('includes/modules/product_attributes/' . basename($_GET['module']) . '.php');

  $module = 'Kuu_ProductAttributes_' . basename($_GET['module']);
  $module = new $module();
?>

<h1><?php echo kuu_link_object(kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule()), $Kuu_Template->getPageTitle()); ?></h1>

<?php
  if ( $Kuu_MessageStack->size($Kuu_Template->getModule()) > 0 ) {
    echo $Kuu_MessageStack->get($Kuu_Template->getModule());
  }
?>

<div class="infoBoxHeading"><?php echo kuu_icon('uninstall.png') . ' ' . $module->getTitle(); ?></div>
<div class="infoBoxContent">
  <form name="mUninstall" action="<?php echo kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '&module=' . basename($_GET['module']) . '&action=uninstall'); ?>" method="post">

  <p><?php echo $Kuu_Language->get('introduction_uninstall_product_attribute_module'); ?></p>

  <p><?php echo '<b>' . $module->getTitle() . '</b>'; ?></p>

  <p align="center"><?php echo kuu_draw_hidden_field('subaction', 'confirm') . '<input type="submit" value="' . $Kuu_Language->get('button_uninstall') . '" class="operationButton" /> <input type="button" value="' . $Kuu_Language->get('button_cancel') . '" onclick="document.location.href=\'' . kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule()) . '\';" class="operationButton" />'; ?></p>

  </form>
</div>
