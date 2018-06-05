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

<?php
  if ( $KUUZU_Customer->isLoggedOn() ) {
    echo '<p>' . sprintf(KUUZU::getDef('greeting_customer'), HTML::outputProtected($KUUZU_Customer->getFirstName()), KUUZU::getLink(null, 'Products', 'New')) . '</p>';
  } else {
    echo '<p>' . sprintf(KUUZU::getDef('greeting_guest'), KUUZU::getLink(null, 'Account', 'Login', 'SSL'), KUUZU::getLink(null, 'Products', 'New')) . '</p>';
  }
?>

<p><?php echo KUUZU::getDef('index_text'); ?></p>
