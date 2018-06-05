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

  $products_name = array();
  $products_description = array();
  $products_keyword = array();
  $products_tags = array();
  $products_url = array();

  if ( !$new_product ) {
    $Qpd = $KUUZU_PDO->prepare('select products_name, products_description, products_keyword, products_tags, products_url, language_id from :table_products_description where products_id = :products_id');
    $Qpd->bindInt(':products_id', $KUUZU_ObjectInfo->getInt('products_id'));
    $Qpd->execute();

    while ( $Qpd->fetch() ) {
      $products_name[$Qpd->valueInt('language_id')] = $Qpd->value('products_name');
      $products_description[$Qpd->valueInt('language_id')] = $Qpd->value('products_description');
      $products_keyword[$Qpd->valueInt('language_id')] = $Qpd->value('products_keyword');
      $products_tags[$Qpd->valueInt('language_id')] = $Qpd->value('products_tags');
      $products_url[$Qpd->valueInt('language_id')] = $Qpd->value('products_url');
    }
  }
?>

<div id="sectionMenu_general">
  <div class="infoBox">

<?php
  if ( $new_product ) {
    echo '<h3>' . HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_product') . '</h3>';
  } else {
    echo '<h3>' . HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('products_name') . '</h3>';
  }
?>

    <div id="languageTabs">
      <ul>

<?php
  foreach ( $KUUZU_Language->getAll() as $l ) {
    echo '<li>' . HTML::link('#languageTabs_' . $l['code'], $KUUZU_Language->showImage($l['code']) . '&nbsp;' . $l['name']) . '</li>';
  }
?>

      </ul>

<?php
  foreach ( $KUUZU_Language->getAll() as $l ) {
?>

      <div id="languageTabs_<?php echo $l['code']; ?>">
        <fieldset>
          <p><label for="<?php echo 'products_name[' . $l['id'] . ']'; ?>"><?php echo KUUZU::getDef('field_name'); ?></label><?php echo HTML::inputField('products_name[' . $l['id'] . ']', (!$new_product && isset($products_name[$l['id']]) ? $products_name[$l['id']] : null)); ?></p>
          <p><label for="<?php echo 'products_description[' . $l['id'] . ']'; ?>"><?php echo KUUZU::getDef('field_description'); ?></label><?php echo HTML::textareaField('products_description[' . $l['id'] . ']', (!$new_product && isset($products_description[$l['id']]) ? $products_description[$l['id']] : null)); ?></p>
          <p><label for="<?php echo 'products_keyword[' . $l['id'] . ']'; ?>"><?php echo KUUZU::getDef('field_keyword'); ?></label><?php echo HTML::inputField('products_keyword[' . $l['id'] . ']', (!$new_product && isset($products_keyword[$l['id']]) ? $products_keyword[$l['id']] : null)); ?></p>
          <p><label for="<?php echo 'products_tags[' . $l['id'] . ']'; ?>"><?php echo KUUZU::getDef('field_tags'); ?></label><?php echo HTML::inputField('products_tags[' . $l['id'] . ']', (!$new_product && isset($products_tags[$l['id']]) ? $products_tags[$l['id']] : null)); ?></p>
          <p><label for="<?php echo 'products_url[' . $l['id'] . ']'; ?>"><?php echo KUUZU::getDef('field_url'); ?></label><?php echo HTML::inputField('products_url[' . $l['id'] . ']', (!$new_product && isset($products_url[$l['id']]) ? $products_url[$l['id']] : null)); ?></p>
        </fieldset>
      </div>

<?php
  }
?>

    </div>
  </div>
</div>

<script>
$(function(){
  $("#languageTabs").tabs( { selected: 0 } );
});
</script>
