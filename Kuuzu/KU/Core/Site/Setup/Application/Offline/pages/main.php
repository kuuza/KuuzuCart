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

<div class="mainBlock">
  <ul style="list-style-type: none; padding: 5px; margin: 0px; display: inline; float: right;">
    <li style="font-weight: bold; display: inline;"><?php echo KUUZU::getDef('title_language'); ?></li>

<?php
  foreach ( $KUUZU_Language->getAll() as $available_language ) {
?>

    <li style="display: inline;"><?php echo '<a href="' . KUUZU::getLink(null, null, 'language=' . $available_language['code']) . '">' . $KUUZU_Language->showImage($available_language['code']) . '</a>'; ?></li>

<?php      
  }
?>

  </ul>

  <h1><?php echo KUUZU::getDef('page_title_authorization_required'); ?></h1>
</div>

<div class="contentBlock">
  <div class="contentPane" style="margin-left: 0;">
    <h2><?php echo KUUZU::getDef('page_heading_access_disabled'); ?></h2>

    <p><?php echo KUUZU::getDef('text_access_disabled'); ?></p>

    <p align="center"><?php echo HTML::button(array('href' => KUUZU::getLink(null, KUUZU::getDefaultSiteApplication()), 'priority' => 'primary', 'icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></p>
  </div>
</div>
