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

<div id="sectionMenu_social">
  <div class="infoBox">

<?php
  if ( $new_customer ) {
    echo '<h3>' . HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_customer') . '</h3>';
  } else {
    echo '<h3>' . HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('customers_name') . '</h3>';
  }
?>

    <div id="gravatarInfo"></div>
  </div>
</div>

<script>
function loadGravatar(profile) {
  if ( profile.entry.length > 0 ) {
    $('#gravatarInfo').html('<a href="' + profile.entry[0].profileUrl + '" target="_blank"><img src="' + profile.entry[0].thumbnailUrl + '" alt="' + profile.entry[0].displayName + ' @Gravatar" title="' + profile.entry[0].displayName + ' @Gravatar" style="padding: 10px;" /></a>');
  }
}

$(function() {
  $('#sectionMenu input:radio[value=social]').click(function() {
    $('#gravatarInfo').html('');

    $.getScript('https://secure.gravatar.com/' + $.md5($('input[name="email_address"]').val()) + '.json?callback=loadGravatar');
  });
});
</script> 
