<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  $categories_array = array(array('id' => '0',
                                  'text' => $Kuu_Language->get('top_category')));

  foreach ($Kuu_CategoryTree->getArray() as $value) {
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

<div class="infoBoxHeading"><?php echo kuu_icon('copy.png') . ' ' . $Kuu_Language->get('action_heading_batch_copy_products'); ?></div>
<div class="infoBoxContent">
  <form name="pBatchCopy" class="dataForm" action="<?php echo kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '&cID=' . $_GET['cID'] . '&action=batch_copy'); ?>" method="post">

  <p><?php echo $Kuu_Language->get('introduction_batch_copy_products'); ?></p>

<?php
  $Qproducts = $Kuu_Database->query('select products_id, products_name from :table_products_description where products_id in (":products_id") and language_id = :language_id order by products_name');
  $Qproducts->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
  $Qproducts->bindRaw(':products_id', implode('", "', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))));
  $Qproducts->bindInt(':language_id', $Kuu_Language->getID());
  $Qproducts->execute();

  $names_string = '';

  while ($Qproducts->next()) {
    $names_string .= kuu_draw_hidden_field('batch[]', $Qproducts->valueInt('products_id')) . '<b>' . $Qproducts->value('products_name') . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2) . kuu_draw_hidden_field('subaction', 'confirm');
  }

  echo '<p>' . $names_string . '</p>';
?>

  <p><?php echo '<b>' . $Kuu_Language->get('field_categories') . '</b><br />' . kuu_draw_pull_down_menu('new_category_id', $categories_array); ?></p>

  <p><?php echo '<b>' . $Kuu_Language->get('field_copy_method') . '</b><br />' . kuu_draw_radio_field('copy_as', array(array('id' => 'link', 'text' => $Kuu_Language->get('copy_method_link')), array('id' => 'duplicate', 'text' => $Kuu_Language->get('copy_method_duplicate'))), 'link', null, '<br />'); ?></p>

  <p align="center"><?php echo '<input type="submit" value="' . $Kuu_Language->get('button_copy') . '" class="operationButton" /> <input type="button" value="' . $Kuu_Language->get('button_cancel') . '" onclick="document.location.href=\'' . kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '&cID=' . $_GET['cID']) . '\';" class="operationButton" />'; ?></p>

  </form>
</div>
