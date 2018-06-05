<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  $Kuu_ObjectInfo = new Kuu_ObjectInfo(Kuu_Products_Admin::get($_GET[$Kuu_Template->getModule()]));

  $in_categories = array();

  $Qcategories = $Kuu_Database->query('select categories_id from :table_products_to_categories where products_id = :products_id');
  $Qcategories->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
  $Qcategories->bindInt(':products_id', $Kuu_ObjectInfo->getInt('products_id'));
  $Qcategories->execute();

  while ( $Qcategories->next() ) {
    $in_categories[] = $Qcategories->valueInt('categories_id');
  }

  $in_categories_path = '';

  foreach ( $in_categories as $category_id ) {
    $in_categories_path .= $Kuu_CategoryTree->getPath($category_id, 0, ' &raquo; ') . '<br />';
  }

  if ( !empty($in_categories_path) ) {
    $in_categories_path = substr($in_categories_path, 0, -6);
  }

  $categories_array = array(array('id' => '0',
                                  'text' => $Kuu_Language->get('top_category')));

  foreach ( $Kuu_CategoryTree->getArray() as $value ) {
    $categories_array[] = array('id' => $value['id'],
                                'text' => $value['title']);
  }
?>

<h1><?php echo kuu_link_object(kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule()), $Kuu_Template->getPageTitle()); ?></h1>

<?php
  if ( $Kuu_MessageStack->exists($Kuu_Template->getModule()) ) {
    echo $Kuu_MessageStack->get($Kuu_Template->getModule());
  }
?>

<div class="infoBoxHeading"><?php echo kuu_icon('copy.png') . ' ' . $Kuu_ObjectInfo->getProtected('products_name'); ?></div>
<div class="infoBoxContent">
  <form name="pCopy" class="dataForm" action="<?php echo kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '=' . $Kuu_ObjectInfo->get('products_id') . '&cID=' . $_GET['cID'] . '&action=copy'); ?>" method="post">

  <p><?php echo $Kuu_Language->get('introduction_copy_product'); ?></p>

  <fieldset>
    <p><?php echo '<b>' . $Kuu_Language->get('field_current_categories') . '</b><br />' . $in_categories_path; ?></p>

    <div><label for="new_category_id"><?php echo $Kuu_Language->get('field_categories'); ?></label><?php echo kuu_draw_pull_down_menu('new_category_id', $categories_array); ?></div>
    <div><label for="copy_as"><?php echo $Kuu_Language->get('field_copy_method'); ?></label><?php echo kuu_draw_radio_field('copy_as', array(array('id' => 'link', 'text' => $Kuu_Language->get('copy_method_link')), array('id' => 'duplicate', 'text' => $Kuu_Language->get('copy_method_duplicate'))), 'link', null, '<br />'); ?></div>
  </fieldset>

  <p align="center"><?php echo kuu_draw_hidden_field('subaction', 'confirm') . '<input type="submit" value="' . $Kuu_Language->get('button_copy') . '" class="operationButton" /> <input type="button" value="' . $Kuu_Language->get('button_cancel') . '" onclick="document.location.href=\'' . kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '&cID=' . $_GET['cID']) . '\';" class="operationButton" />'; ?></p>

  </form>
</div>
