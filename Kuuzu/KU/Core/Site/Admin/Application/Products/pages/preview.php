<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  $Qp = $Kuu_Database->query('select p.products_id, p.products_quantity, p.products_price, p.products_model, p.products_weight, p.products_weight_class, p.products_date_added, p.products_last_modified, p.products_status, p.products_tax_class_id, p.manufacturers_id, i.image from :table_products p left join :table_products_images i on (p.products_id = i.products_id and default_flag = :default_flag) where p.products_id = :products_id');
  $Qp->bindTable(':table_products', TABLE_PRODUCTS);
  $Qp->bindTable(':table_products_images', TABLE_PRODUCTS_IMAGES);
  $Qp->bindInt(':products_id', $_GET[$Kuu_Template->getModule()]);
  $Qp->bindInt(':default_flag', 1);
  $Qp->execute();

  $Qpd = $Kuu_Database->query('select products_name, products_description, products_url, language_id from :table_products_description where products_id = :products_id');
  $Qpd->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
  $Qpd->bindInt(':products_id', $_GET[$Kuu_Template->getModule()]);
  $Qpd->execute();

  $pd_extra = array();
  while ( $Qpd->next() ) {
    $pd_extra['products_name'][$Qpd->valueInt('language_id')] = $Qpd->valueProtected('products_name');
    $pd_extra['products_description'][$Qpd->valueInt('language_id')] = $Qpd->value('products_description');
    $pd_extra['products_url'][$Qpd->valueInt('language_id')] = $Qpd->valueProtected('products_url');
  }

  $Kuu_ObjectInfo = new Kuu_ObjectInfo(array_merge($Qp->toArray(), $pd_extra));

  $products_name = $Kuu_ObjectInfo->get('products_name');
  $products_description = $Kuu_ObjectInfo->get('products_description');
  $products_url = $Kuu_ObjectInfo->get('products_url');
?>

<h1><?php echo kuu_link_object(kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule()), $Kuu_Template->getPageTitle()); ?></h1>

<?php
  if ( $Kuu_MessageStack->exists($Kuu_Template->getModule()) ) {
    echo $Kuu_MessageStack->get($Kuu_Template->getModule());
  }
?>

<div style="background-color: #fff3e7;">

<?php
  foreach ( $Kuu_Language->getAll() as $l ) {
    echo '<span id="lang_' . $l['code'] . '"' . (($l['code'] == $Kuu_Language->getCode()) ? ' class="highlight"' : '') . '><a href="javascript:toggleDivBlocks(\'pName_\', \'pName_' . $l['code'] . '\'); toggleClass(\'lang_\', \'lang_' . $l['code'] . '\', \'highlight\', \'span\');">' . $Kuu_Language->showImage($l['code']) . '</a></span>&nbsp;&nbsp;';
  }
?>

</div>

<?php
  foreach ( $Kuu_Language->getAll() as $l ) {
?>

<div id="pName_<?php echo $l['code']; ?>" <?php echo (($l['code'] != $Kuu_Language->getCode()) ? ' style="display: none;"' : ''); ?>>
  <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr>
      <td><h1><?php echo kuu_output_string_protected($products_name[$l['id']]) . (!kuu_empty($Kuu_ObjectInfo->get('products_model')) ? '<br /><span>' . $Kuu_ObjectInfo->getProtected('products_model') . '</span>': ''); ?></h1></td>
      <td align="right"><h1><?php echo $Kuu_Currencies->format($Kuu_ObjectInfo->get('products_price')); ?></h1></td>
    </tr>
  </table>

  <p><?php echo $Kuu_Image->show($Kuu_ObjectInfo->get('image'), $products_name[$l['id']], 'align="right" hspace="5" vspace="5"', 'product_info') . $products_description[$l['id']]; ?></p>

<?php
    if ( !empty($products_url[$l['id']]) ) {
      echo '<p>' . sprintf($Kuu_Language->get('more_product_information'), kuu_output_string_protected($products_url[$l['id']])) . '</p>';
    }
?>

<?php
// HPDL
//    if ($Kuu_ObjectInfo->get('products_date_available') > date('Y-m-d')) {
//      echo '<p align="center">' . sprintf($Kuu_Language->get('product_date_available'), Kuu_DateTime::getLong($Kuu_ObjectInfo->get('products_date_available'))) . '</p>';
//    } else {
      echo '<p align="center">' . sprintf($Kuu_Language->get('product_date_added'), Kuu_DateTime::getLong($Kuu_ObjectInfo->get('products_date_added'))) . '</p>';
//    }
?>

</div>

<?php
  }
?>

<p align="right"><?php echo '<input type="button" value="' . $Kuu_Language->get('button_back') . '" onclick="document.location.href=\'' . kuu_href_link_admin(FILENAME_DEFAULT, $Kuu_Template->getModule() . '&cID=' . $_GET['cID']) . '\';" class="operationButton" />'; ?></p>
