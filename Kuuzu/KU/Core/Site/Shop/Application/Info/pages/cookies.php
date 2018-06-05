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

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<div class="moduleBox" style="width: 40%; float: right; margin: 0 0 10px 10px;">
  <h6><?php echo KUUZU::getDef('cookie_usage_box_heading'); ?></h6>

  <div class="content">
    <?php echo KUUZU::getDef('cookie_usage_box_contents'); ?>
  </div>
</div>

<p><?php echo KUUZU::getDef('cookie_usage'); ?></p>

<div class="submitFormButtons" style="text-align: right;">
  <?php echo HTML::button(array('href' => KUUZU::getLink(), 'icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
</div>
