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

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
?>

<div id="adminMenu">
  <ul class="apps">
    <li class="shortcuts"><?php echo HTML::link(KUUZU::getLink(null, KUUZU::getDefaultSiteApplication()), HTML::image(KUUZU::getPublicSiteLink('images/kuuzu_icon.png'), null, 16, 16)); ?></li>

<?php
  if ( isset($_SESSION[KUUZU::getSite()]['id']) ) {
    echo '  <li><a href="#">Applications &#9662;</a>' .
         '    <ul>';

    foreach ( Access::getLevels() as $group => $links ) {
      $application = current($links);

      echo '      <li><a href="' . KUUZU::getLink(null, $application['module']) . '"><span style="float: right;">&#9656;</span>' . Access::getGroupTitle($group) . '</a>' .
           '        <ul>';

      foreach ( $links as $link ) {
        echo '          <li><a href="' . KUUZU::getLink(null, $link['module']) . '">' . $KUUZU_Template->getIcon(16, $link['icon']) . '&nbsp;' . $link['title'] . '</a></li>';
      }

      echo '        </ul>' .
           '      </li>';
    }

    echo '    </ul>' .
         '  </li>';
  }

  echo '  <li><a href="' . KUUZU::getLink('Shop', 'Index', null, 'NONSSL', false) . '" target="_blank">' . KUUZU::getDef('header_title_online_catalog') . '</a></li>' .
       '  <li><a href="https://kuuzu.org" target="_blank">' . KUUZU::getDef('header_title_help') . ' &#9662;</a>' .
       '    <ul>' .
       '      <li><a href="https://kuuzu.org" target="_blank">Kuuzu Support Site</a></li>' .
       '      <li><a href="https://kuuzu.org/docs" target="_blank">Online Documentation</a></li>' .
       '      <li><a href="https://kuuzu.org/forum" target="_blank">Community Support Forums</a></li>' .
       '      <li><a href="https://kuuzu.org/apps" target="_blank">Add-Ons Site</a></li>' .
       '      <li><a href="https://github.com/kuuza/kuuzu/issues" target="_blank">Bug Reporter</a></li>' .
       '    </ul>' .
       '  </li>';
?>

  </ul>

<?php
  $total_shortcuts = 0;

  if ( isset($_SESSION[KUUZU::getSite()]['id']) ) {
    echo '<ul class="apps" style="float: right;">';

    if ( $KUUZU_Application->canLinkTo() ) {
      if ( Access::isShortcut(KUUZU::getSiteApplication()) ) {
        echo '  <li class="shortcuts">' . HTML::link(KUUZU::getLink(null, 'Dashboard', 'RemoveShortcut&shortcut=' . KUUZU::getSiteApplication()), HTML::icon('shortcut_remove.png')) . '</li>';
      } else {
        echo '  <li class="shortcuts">' . HTML::link(KUUZU::getLink(null, 'Dashboard', 'AddShortcut&shortcut=' . KUUZU::getSiteApplication()), HTML::icon('shortcut_add.png')) . '</li>';
      }
    }

    if ( Access::hasShortcut() ) {
      echo '  <li class="shortcuts">';

      foreach ( Access::getShortcuts() as $shortcut ) {
        echo '<a href="' . KUUZU::getLink(null, $shortcut['module']) . '" id="shortcut-' . $shortcut['module'] . '">' . $KUUZU_Template->getIcon(16, $shortcut['icon'], $shortcut['title']) . '<div class="notBubble"></div></a>';

        $total_shortcuts++;
      }

      echo '  </li>';
    }

    echo '  <li><a href="#">' . HTML::outputProtected($_SESSION[KUUZU::getSite()]['username']) . ' &#9662;</a>' .
         '    <ul>' .
         '      <li><a href="' . KUUZU::getLink(null, 'Login', 'Logoff') . '">' . KUUZU::getDef('header_title_logoff') . '</a></li>' .
         '    </ul>' .
         '  </li>' .
         '</ul>';
  }
?>

</div>

<script type="text/javascript">
  $('#adminMenu .apps').droppy({speed: 0});
  $('#adminMenu .apps li img').tipsy();
</script>

<?php
  if ( isset($_SESSION[KUUZU::getSite()]['id']) ) {
?>

<script type="text/javascript">
  var totalShortcuts = <?php echo $total_shortcuts; ?>;
  var wkn = new Object;

  if ( $.cookie('wkn') ) {
    wkn = $.secureEvalJSON($.cookie('wkn'));
  }

  function updateShortcutNotifications(resetApplication) {
    $.getJSON('<?php echo KUUZU::getRPCLink('Admin', 'Dashboard', 'GetShortcutNotifications&reset=RESETAPP'); ?>'.replace('RESETAPP', resetApplication), function (data) {
      if ( ('rpcStatus' in data) && (data['rpcStatus'] == 1) ) {
        $.each(data['entries'], function(key, val) {
          if ( $('#shortcut-' + key + ' .notBubble').html != val ) {
            if ( val > 0 || val.length > 0 ) {
              $('#shortcut-' + key + ' .notBubble').html(val).show();

              if ( (typeof webkitNotifications != 'undefined') && (webkitNotifications.checkPermission() == 0) ) {
                if ( typeof wkn[key] == 'undefined' ) {
                  wkn[key] = new Object;
                }

                if ( wkn[key].value != val ) {
                  wkn[key].value = val;
                  wkn[key].n = webkitNotifications.createNotification('<?php echo KUUZU::getPublicSiteLink('images/applications/32/APPICON.png'); ?>'.replace('APPICON', key), key, val);
                  wkn[key].n.replaceId = key;
                  wkn[key].n.ondisplay = function(event) {
                    setTimeout(function() {
                      event.currentTarget.cancel();
                    }, 5000);
                  };
                  wkn[key].n.show();
                }
              }
            } else {
              $('#shortcut-' + key + ' .notBubble').hide();
            }
          }
        });
      }

      $.cookie('wkn', $.toJSON(wkn));
    });
  }

  $(document).ready(function() {
    if ( totalShortcuts > 0 ) {
      updateShortcutNotifications(typeof resetShortcutNotification != 'undefined' ? '<?php echo KUUZU::getSiteApplication(); ?>' : null);

      setInterval('updateShortcutNotifications()', 10000);
    }
  });

  if ( (typeof window.external.msAddSiteMode != 'undefined') && window.external.msIsSiteMode() ) {

<?php
    if ( Access::hasShortcut() ) {
      echo '    window.external.msSiteModeClearJumplist();' . "\n" .
           '    window.external.msSiteModeCreateJumplist("Shortcuts");' . "\n";

      foreach ( Access::getShortcuts() as $shortcut ) {
        echo '    window.external.msSiteModeAddJumpListItem("' . $shortcut['title'] . '", "' . KUUZU::getLink(null, $shortcut['module']) . '", "", "self");' . "\n";
      }

      echo '    window.external.msSiteModeShowJumplist();' . "\n";
    }
?>

  }
</script>

<?php
  }
?>
