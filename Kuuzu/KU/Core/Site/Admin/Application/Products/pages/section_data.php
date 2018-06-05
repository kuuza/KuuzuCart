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
  use Kuuzu\KU\Core\Site\Admin\Application\ProductAttributes\ProductAttributes;

  if ( !$new_product ) {
    $attributes = $KUUZU_ObjectInfo->get('attributes');
  }
?>

<div id="sectionMenu_data">
  <div class="infoBox">

<?php
  if ( $new_product ) {
    echo '<h3>' . HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_product') . '</h3>';
  } else {
    echo '<h3>' . HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('products_name') . '</h3>';
  }
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>

<?php
  $data_width = ( !$new_product && ($KUUZU_ObjectInfo->getInt('has_children') === 1) ) ? '100%' : '50%';

  if ( $new_product || ($KUUZU_ObjectInfo->getInt('has_children') !== 1) ) {
?>

        <td width="<?php echo $data_width;?>" height="100%" valign="top">
          <h4><?php echo KUUZU::getDef('subsection_price'); ?></h4>

          <fieldset>
            <p><label for="products_price_tax_class"><?php echo KUUZU::getDef('field_tax_class'); ?></label><?php echo HTML::selectMenu('products_tax_class_id', $KUUZU_Application->getTaxClassesList(), (!$new_product ? $KUUZU_ObjectInfo->getInt('products_tax_class_id') : null), 'id="products_price_tax_class" onchange="updateGross(\'products_price\');"'); ?></p>
            <p><label for="products_price"><?php echo KUUZU::getDef('field_price_net'); ?></label><?php echo HTML::inputField('products_price', (!$new_product ? $KUUZU_ObjectInfo->get('products_price') : null), 'onkeyup="updateGross(\'products_price\')"'); ?></p>
            <p><label for="products_price_gross"><?php echo KUUZU::getDef('field_price_gross'); ?></label><?php echo HTML::inputField('products_price_gross', (!$new_product ? $KUUZU_ObjectInfo->get('products_price') : null), 'onkeyup="updateNet(\'products_price\')"'); ?></p>
          </fieldset>
        </td>

<?php
  }
?>

        <td width="<?php echo $data_width;?>" height="100%" valign="top">
          <h4><?php echo KUUZU::getDef('subsection_data'); ?></h4>

          <fieldset>
            <p id="productStatusField"><label for="products_status"><?php echo KUUZU::getDef('field_status'); ?></label><?php echo HTML::radioField('products_status', array(array('id' => '1', 'text' => KUUZU::getDef('status_enabled')), array('id' => '0', 'text' => KUUZU::getDef('status_disabled'))), (!$new_product ? $KUUZU_ObjectInfo->get('products_status') : '0')); ?></p>

<script>$('#productStatusField').buttonset();</script>

<?php
  if ( $new_product || ($KUUZU_ObjectInfo->getInt('has_children') !== 1) ) {
?>

            <p><label for="products_model"><?php echo KUUZU::getDef('field_model'); ?></label><?php echo HTML::inputField('products_model', (!$new_product ? $KUUZU_ObjectInfo->get('products_model') : null)); ?></p>
            <p><label for="products_quantity"><?php echo KUUZU::getDef('field_quantity'); ?></label><?php echo HTML::inputField('products_quantity', (!$new_product ? $KUUZU_ObjectInfo->get('products_quantity') : null)); ?></p>
            <p><label for="products_weight"><?php echo KUUZU::getDef('field_weight'); ?></label><?php echo HTML::inputField('products_weight', (!$new_product ? $KUUZU_ObjectInfo->get('products_weight') : null)) . HTML::selectMenu('products_weight_class', $KUUZU_Application->getWeightClassesList(), (!$new_product ? $KUUZU_ObjectInfo->get('products_weight_class') : SHIPPING_WEIGHT_UNIT)); ?></p>

<?php
  }
?>

          </fieldset>
        </td>
      </tr>
    </table>

<?php
  if ( !$new_product && ($KUUZU_ObjectInfo->getInt('has_children') === 1) ) {
    echo HTML::hiddenField('products_tax_class_id', 0) . HTML::hiddenField('products_price', 0) . HTML::hiddenField('products_model') . HTML::hiddenField('products_quantity', 0), HTML::hiddenField('products_weight', 0), HTML::hiddenField('products_weight_class', 0);
  }
?>

    <h4><?php echo KUUZU::getDef('subsection_attributes'); ?></h4>

    <fieldset>

<?php
  $installed = ProductAttributes::getInstalled();

  foreach ( $installed['entries'] as $pa ) {
    $pamo = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\ProductAttribute\\' . $pa['code'];
    $pam = new $pamo();

    echo '<p><label for="pa_' . $pa['code'] . '">' . $pa['title'] . '</label>' . $pam->getInputField(!$new_product && isset($attributes[$pa['id']]) ? $attributes[$pa['id']] : null) . '</p>';
  }
?>

    </fieldset>
  </div>
</div>

<script>

<?php
  $tr_array = array();

  foreach ( $KUUZU_Application->getTaxClassesList() as $tc_entry ) {
    if ( $tc_entry['id'] > 0 ) {
      $tr_array[$tc_entry['id']] = $KUUZU_Tax->getTaxRate($tc_entry['id']);
    }
  }

  echo 'var tax_rates = ' . json_encode($tr_array) . ';' . "\n";
?>

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}

function getTaxRate(field) {
  var value = $('#' + field + '_tax_class').val();

  if ( (value > 0) && (tax_rates[value] > 0) ) {
    return tax_rates[value];
  } else {
    return 0;
  }
}

function updateGross(field) {
  var taxRate = getTaxRate(field);
  var grossValue = $('#' + field).val();

  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }

  $('#' + field + '_gross').val(doRound(grossValue, 4));
}

function updateNet(field) {
  var taxRate = getTaxRate(field);
  var netValue = $('#' + field + '_gross').val();

  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }

  $('#' + field).val(doRound(netValue, 4));
}

$(function(){
  updateGross('products_price');
});
</script>
