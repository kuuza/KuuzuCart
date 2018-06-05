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

<?php
  if ( $KUUZU_MessageStack->exists('TellAFriend') ) {
    echo $KUUZU_MessageStack->get('TellAFriend');
  }
?>

<form name="tell_a_friend" action="<?php echo KUUZU::getLink(null, null, 'TellAFriend&Process&' . $KUUZU_Product->getKeyword()); ?>" method="post">

<div class="moduleBox">
  <em style="float: right; margin-top: 10px;"><?php echo KUUZU::getDef('form_required_information'); ?></em>

  <h6><?php echo KUUZU::getDef('customer_details_title'); ?></h6>

  <div class="content">
    <ol>
      <li><?php echo HTML::label(KUUZU::getDef('field_tell_a_friend_customer_name'), 'from_name', null, true) . HTML::inputField('from_name', ($KUUZU_Customer->isLoggedOn() ? $KUUZU_Customer->getName() : null)); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_tell_a_friend_customer_email_address'), 'from_email_address', null, true) . HTML::inputField('from_email_address', ($KUUZU_Customer->isLoggedOn() ? $KUUZU_Customer->getEmailAddress() : null)); ?></li>
    </ol>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('friend_details_title'); ?></h6>

  <div class="content">
    <ol>
      <li><?php echo HTML::label(KUUZU::getDef('field_tell_a_friend_friends_name'), 'to_name', null, true) . HTML::inputField('to_name'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_tell_a_friend_friends_email_address'), 'to_email_address', null, true) . HTML::inputField('to_email_address'); ?></li>
    </ol>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('tell_a_friend_message'); ?></h6>

  <div class="content">
    <ol>
      <li><?php echo HTML::textareaField('message', null, 40, 8, 'style="width: 98%;"'); ?></li>
    </ol>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>

</form>
