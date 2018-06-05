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

  $services = array(array('id' => 'oanda',
                          'text' => 'Oanda (http://www.oanda.com)'),
                    array('id' => 'xe',
                          'text' => 'XE (http://www.xe.com)'));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('update.png') . ' ' . KUUZU::getDef('action_heading_update_rates'); ?></h3>

  <form name="cUpdate" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'UpdateRates&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_update_exchange_rates'); ?></p>

  <fieldset>
    <p><?php echo HTML::radioField('service', $services, null, null, '<br />'); ?></p>
  </fieldset>

  <p><?php echo KUUZU::getDef('service_terms_agreement'); ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'refresh', 'title' => KUUZU::getDef('button_update'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
