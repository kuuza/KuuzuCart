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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Dashboard\RPC;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Admin\Application\Dashboard\Dashboard;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

  class GetShortcutNotifications {
    public static function execute() {
      $site = KUUZU::getSite();

      $result = array('entries' => array());

      if ( isset($_SESSION[$site]['id']) ) {
        if ( isset($_GET['reset']) && !empty($_GET['reset']) && KUUZU::siteApplicationExists($_GET['reset']) ) {
          Dashboard::updateAppDateOpened($_SESSION[$site]['id'], $_GET['reset']);
        }

        $shortcuts = array();

        foreach ( Dashboard::getShortcuts($_SESSION[$site]['id']) as $app ) {
          $shortcuts[$app['module']] = $app['last_viewed'];
        }

        foreach ( $_SESSION[$site]['access'] as $module => $data ) {
          if ( $data['shortcut'] === true ) {
            if ( method_exists('Kuuzu\\KU\\Core\\Site\\Admin\\Application\\' . $data['module'] . '\\' . $data['module'], 'getShortcutNotification') || class_exists('Kuuzu\\KU\\Core\\Site\\Admin\\Application\\' . $data['module'] . '\\Model\\getShortcutNotification') ) {
              $result['entries'][$data['module']] = call_user_func(array('Kuuzu\\KU\\Core\\Site\\Admin\\Application\\' . $data['module'] . '\\' . $data['module'], 'getShortcutNotification'), $shortcuts[$data['module']]);
            }
          }
        }
      }

      $result['rpcStatus'] = RPC::STATUS_SUCCESS;

      echo json_encode($result);
    }
  }
?>
