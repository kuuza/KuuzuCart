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
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_currency'); ?></h3>

  <form name="aDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDelete&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_currencies'); ?></p>

<?php
  $check_default_flag = false;

  $Qcurrencies = $KUUZU_PDO->query('select currencies_id, title, code from :table_currencies where currencies_id in (\'' . implode('\', \'', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '\') order by title');
  $Qcurrencies->execute();

  $names_string = '';

  while ( $Qcurrencies->fetch() ) {
    if ( $Qcurrencies->value('code') == DEFAULT_CURRENCY ) {
      $check_default_flag = true;
    }

    $names_string .= HTML::hiddenField('batch[]', $Qcurrencies->valueInt('currencies_id')) . '<b>' . $Qcurrencies->value('title') . ' (' . $Qcurrencies->value('code') . ')</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2) . HTML::hiddenField('subaction', 'confirm');
  }

  echo '<p>' . $names_string . '</p>';

  if ( $check_default_flag === false ) {
    echo '<p>' . HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))) . '</p>';
  } else {
    echo '<p><b>' . KUUZU::getDef('introduction_delete_currency_invalid') . '</b></p>';

    echo '<p>' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'primary', 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))) . '</p>';
  }
?>

  </form>
</div>
