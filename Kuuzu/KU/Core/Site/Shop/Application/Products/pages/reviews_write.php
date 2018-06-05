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

<div style="float: right;"><?php echo HTML::link(KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()), $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle(), 'hspace="5" vspace="5"', 'mini')); ?></div>

<h1><?php echo $KUUZU_Template->getPageTitle() . ($KUUZU_Product->hasModel() ? '<br /><span class="smallText">' . $KUUZU_Product->getModel() . '</span>' : ''); ?></h1>

<div style="clear: both;"></div>

<?php
  if ( $KUUZU_MessageStack->exists('Reviews') ) {
    echo $KUUZU_MessageStack->get('Reviews');
  }
?>

<form name="reviews_write" action="<?php echo KUUZU::getLink(null, null, 'Reviews&Process&' . $KUUZU_Product->getID()); ?>" method="post" onsubmit="return checkForm(this);">

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('new_review_title'); ?></h6>

  <div class="content">
    <ol>

<?php
  if ( $KUUZU_Customer->isLoggedOn() === false ) {
?>

      <li><?php echo HTML::label(ENTRY_NAME, 'customer_name') . HTML::inputField('customer_name'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_customer_email_address'), 'customer_email_address') . HTML::inputField('customer_email_address'); ?></li>

<?php
  }
?>

      <li><?php echo HTML::textareaField('review', null, null, 15, 'style="width: 98%;"'); ?></li>
      <li><?php echo KUUZU::getDef('field_review_rating') . ' ' . KUUZU::getDef('review_lowest_rating_title') . ' ' . HTML::radioField('rating', array('1', '2', '3', '4', '5')) . ' ' . KUUZU::getDef('review_highest_rating_title'); ?></li>
    </ol>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Reviews&' . $KUUZU_Product->getID()), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>

</form>
