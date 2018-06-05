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
?>

<div class="ui-widget boxNew">
  <div class="ui-widget-header boxTitle"><?php echo HTML::link($KUUZU_Box->getTitleLink(), $KUUZU_Box->getTitle()); ?></div>

  <div class="ui-widget-content boxContents"><?php echo $KUUZU_Box->getContent(); ?></div>
</div>
