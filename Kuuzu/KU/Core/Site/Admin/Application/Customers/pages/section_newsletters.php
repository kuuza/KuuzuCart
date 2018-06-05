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

<div id="sectionMenu_newsletters">
  <div class="infoBox">

<?php
  if ( $new_customer ) {
    echo '<h3>' . HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_customer') . '</h3>';
  } else {
    echo '<h3>' . HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('customers_name') . '</h3>';
  }
?>

    <fieldset>

<?php
  if ( ACCOUNT_NEWSLETTER == '1' ) {
?>

      <p><label for="newsletter"><?php echo KUUZU::getDef('field_newsletter_subscription'); ?></label><?php echo HTML::checkboxField('newsletter', null, ($new_customer ? null : ($KUUZU_ObjectInfo->get('customers_newsletter') == '1'))); ?></p>

<?php
  }
?>

    </fieldset>
  </div>
</div>
