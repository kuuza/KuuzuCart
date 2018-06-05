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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Service;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Session as SessionClass;

  class Session implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Session', SessionClass::load());

      $KUUZU_Session = Registry::get('Session');
      $KUUZU_Session->setLifeTime(SERVICE_SESSION_EXPIRATION_TIME * 60);

      if ( SERVICE_SESSION_FORCE_COOKIE_USAGE == '1' ) {
        ini_set('session.use_only_cookies', 1);
      } else{
        ini_set('session.use_only_cookies', 0);
      }

      if ( (bool)ini_get('session.use_only_cookies') ) {
        KUUZU::setCookie('cookie_test', 'please_accept_for_session', time()+60*60*24*90);

        if ( isset($_COOKIE['cookie_test']) ) {
          $KUUZU_Session->start();
        }
      } elseif ( SERVICE_SESSION_BLOCK_SPIDERS == '1' ) {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $spider_flag = false;

        if ( !empty($user_agent) ) {
          $spiders = file(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/spiders.txt');

          foreach ( $spiders as $spider ) {
            if ( !empty($spider) ) {
              if ( strpos($user_agent, trim($spider)) !== false ) {
                $spider_flag = true;
                break;
              }
            }
          }
        }

        if ( $spider_flag === false ) {
          $KUUZU_Session->start();
        }
      } else {
        $KUUZU_Session->start();
      }

// verify the ssl_session_id
      if ( (KUUZU::getRequestType() == 'SSL') && (SERVICE_SESSION_CHECK_SSL_SESSION_ID == '1') && (KUUZU::getConfig('enable_ssl') == 'true') ) {
        if ( isset($_SERVER['SSL_SESSION_ID']) && ctype_xdigit($_SERVER['SSL_SESSION_ID']) ) {
          if ( !isset($_SESSION['SESSION_SSL_ID']) ) {
            $_SESSION['SESSION_SSL_ID'] = $_SERVER['SSL_SESSION_ID'];
          }

          if ( $_SESSION['SESSION_SSL_ID'] != $_SERVER['SSL_SESSION_ID'] ) {
            $KUUZU_Session->kill();

            KUUZU::redirect(KUUZU::getLink(null, 'Info', 'SSLcheck', 'AUTO'));
          }
        }
      }

// verify the browser user agent
      if ( SERVICE_SESSION_CHECK_USER_AGENT == '1' ) {
        $http_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        if ( !isset($_SESSION['SESSION_USER_AGENT']) ) {
          $_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
        }

        if ( $_SESSION['SESSION_USER_AGENT'] != $http_user_agent ) {
          $KUUZU_Session->kill();

          KUUZU::redirect(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'));
        }
      }

// verify the IP address
      if ( SERVICE_SESSION_CHECK_IP_ADDRESS == '1' ) {
        if ( !isset($_SESSION['SESSION_IP_ADDRESS']) ) {
          $_SESSION['SESSION_IP_ADDRESS'] = KUUZU::getIPAddress();
        }

        if ( $_SESSION['SESSION_IP_ADDRESS'] != KUUZU::getIPAddress() ) {
          $KUUZU_Session->kill();

          KUUZU::redirect(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'));
        }
      }

      Registry::get('MessageStack')->loadFromSession();

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
