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

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_tax_rates'); ?></h3>

  <form name="rDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDeleteEntries&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_tax_rates'); ?></p>

<?php
  $Qentries = $KUUZU_PDO->query('select tax_rates_id, tax_description from :table_tax_rates where tax_rates_id in (\'' . implode('\', \'', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '\') order by tax_description');
  $Qentries->execute();

  $names_string = '';

  while ( $Qentries->fetch() ) {
    $names_string .= HTML::hiddenField('batch[]', $Qentries->valueInt('tax_rates_id')) . '<b>' . $Qentries->valueProtected('tax_description') . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }

  echo '<p>' . $names_string . '</p>';

  echo '<p>' . HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))) . '</p>';
?>

  </form>
</div>
