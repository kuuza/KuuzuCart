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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Value\shortcut_links;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $KUUZU_Template = Registry::get('Template');

      $shortcut_links = '';

      if ( isset($_SESSION[KUUZU::getSite()]['id']) ) {
        $shortcut_links .= '<ul class="apps" style="float: right;">';

        if ( Registry::get('Application')->canLinkTo() ) {
          if ( Access::isShortcut(KUUZU::getSiteApplication()) ) {
            $shortcut_links .= '  <li class="shortcuts">' . HTML::link(KUUZU::getLink(null, 'Dashboard', 'RemoveShortcut&shortcut=' . KUUZU::getSiteApplication()), HTML::icon('shortcut_remove.png')) . '</li>';
          } else {
            $shortcut_links .= '  <li class="shortcuts">' . HTML::link(KUUZU::getLink(null, 'Dashboard', 'AddShortcut&shortcut=' . KUUZU::getSiteApplication()), HTML::icon('shortcut_add.png')) . '</li>';
          }
        }

        if ( Access::hasShortcut() ) {
          $shortcut_links .= '  <li class="shortcuts">';

          foreach ( Access::getShortcuts() as $shortcut ) {
            $shortcut_links .= '<a href="' . KUUZU::getLink(null, $shortcut['module']) . '" id="shortcut-' . $shortcut['module'] . '">' . $KUUZU_Template->getIcon(16, $shortcut['icon'], $shortcut['title']) . '<div class="notBubble"></div></a>';
          }

          $shortcut_links .= '  </li>';
        }

        $shortcut_links .= '  <li><a href="#">' . HTML::outputProtected($_SESSION[KUUZU::getSite()]['username']) . ' &#9662;</a>' .
                           '    <ul>' .
                           '      <li><a href="' . KUUZU::getLink(null, 'Login', 'Logoff') . '">' . KUUZU::getDef('header_title_logoff') . '</a></li>' .
                           '    </ul>' .
                           '  </li>' .
                           '</ul>';
      }

      return $shortcut_links;
    }
  }
?>
