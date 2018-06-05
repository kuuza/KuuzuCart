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

<style type="text/css">
#pageContent {
  width: 100%;
  margin: 0;
  padding: 0;
}

div#pageBlockLeft {
  width: 100%;
  margin: 0;
}
</style>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('search_help_heading'); ?></h6>

  <div class="content">
    <p><?php echo KUUZU::getDef('search_help'); ?></p>

    <p align="right"><?php echo HTML::link('javascript:window.close();', KUUZU::getDef('close_window')); ?></p>
  </div>
</div>
