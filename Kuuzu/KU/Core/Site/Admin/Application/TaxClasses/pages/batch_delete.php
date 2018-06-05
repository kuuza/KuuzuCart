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
  use Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\TaxClasses;
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_tax_classes'); ?></h3>

  <form name="tcDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDelete&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_tax_classes'); ?></p>

<?php
  $check_tax_classes_flag = array();

  $Qclasses = $KUUZU_PDO->query('select tax_class_id, tax_class_title from :table_tax_class where tax_class_id in (\'' . implode('\', \'', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '\') order by tax_class_title');
  $Qclasses->execute();

  $names_string = '';

  while ( $Qclasses->fetch() ) {
    if ( TaxClasses::hasProducts($Qclasses->valueInt('tax_class_id')) ) {
      $check_tax_classes_flag[] = $Qclasses->value('tax_class_title');
    }

    $names_string .= HTML::hiddenField('batch[]', $Qclasses->valueInt('tax_class_id')) . '<b>' . $Qclasses->value('tax_class_title') . ' (' . sprintf(KUUZU::getDef('total_entries'), TaxClasses::getNumberOfTaxRates($Qclasses->valueInt('tax_class_id'))) . ')</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }

  echo '<p>' . $names_string . '</p>';

  if ( empty($check_tax_classes_flag) ) {
    echo '<p>' . HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))) . '</p>';
  } else {
    echo '<p><b>' . KUUZU::getDef('batch_delete_warning_tax_class_in_use') . '</b></p>' .
         '<p>' . implode(', ', $check_tax_classes_flag) . '</p>';

    echo '<p>' . HTML::button(array('href' => KUUZU::getLink(), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))) . '</p>';
  }
?>

  </form>
</div>
