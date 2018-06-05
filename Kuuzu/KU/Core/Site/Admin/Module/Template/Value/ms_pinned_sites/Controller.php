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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Value\ms_pinned_sites;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $ms_pinned_sites = '';

      if ( Access::hasShortcut() ) {
        $ms_pinned_sites .= 'window.external.msSiteModeClearJumplist();' . "\n" .
                            'window.external.msSiteModeCreateJumplist("Shortcuts");' . "\n";

        foreach ( Access::getShortcuts() as $shortcut ) {
          $ms_pinned_sites .= 'window.external.msSiteModeAddJumpListItem("' . $shortcut['title'] . '", "' . KUUZU::getLink(null, $shortcut['module']) . '", "", "self");' . "\n";
        }

        $ms_pinned_sites .= 'window.external.msSiteModeShowJumplist();' . "\n";
      }

      return $ms_pinned_sites;
    }
  }
?>
