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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Value\apps_links;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $KUUZU_Template = Registry::get('Template');

      $apps_links = '';

      if ( isset($_SESSION[KUUZU::getSite()]['id']) ) {
        $apps_links .= '<ul>';

        foreach ( Access::getLevels() as $group => $links ) {
          $application = current($links);

          $apps_links .= '  <li><a href="' . KUUZU::getLink(null, $application['module']) . '"><span style="float: right;">&#9656;</span>' . Access::getGroupTitle($group) . '</a>' .
                         '    <ul>';

          foreach ( $links as $link ) {
            $apps_links .= '      <li><a href="' . KUUZU::getLink(null, $link['module']) . '">' . $KUUZU_Template->getIcon(16, $link['icon']) . '&nbsp;' . $link['title'] . '</a></li>';
          }

          $apps_links .= '    </ul>' .
                         '  </li>';
        }

        $apps_links .= '</ul>';
      }

      return $apps_links;
    }
  }
?>
