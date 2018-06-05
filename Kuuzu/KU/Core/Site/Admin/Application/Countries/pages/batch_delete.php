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

  $Qcountries = $KUUZU_PDO->query('select countries_id, countries_name from :table_countries where countries_id in (\'' . implode('\', \'', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '\') order by countries_name');
  $Qcountries->execute();

  $names_string = '';

  while ( $Qcountries->fetch() ) {
    $names_string .= HTML::hiddenField('batch[]', $Qcountries->valueInt('countries_id')) . '<b>' . $Qcountries->valueProtected('countries_name') . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_countries'); ?></h3>

  <form name="cDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDelete&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_countries'); ?></p>

  <p><?php echo $names_string; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
