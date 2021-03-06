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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class WhosOnline implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_PDO = Registry::get('PDO');

      if ( $KUUZU_Customer->isLoggedOn() ) {
        $wo_customer_id = $KUUZU_Customer->getID();
        $wo_full_name = $KUUZU_Customer->getName();
      } else {
        $wo_customer_id = null;
        $wo_full_name = 'Guest';

        if ( SERVICE_WHOS_ONLINE_SPIDER_DETECTION == '1' ) {
          $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

          if ( !empty($user_agent) ) {
            $spiders = file(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/spiders.txt');

            foreach ( $spiders as $spider ) {
              if ( !empty($spider) ) {
                if ( (strpos($user_agent, trim($spider))) !== false ) {
                  $wo_full_name = $spider;
                  break;
                }
              }
            }
          }
        }
      }

      $wo_session_id = session_id();
      $wo_ip_address = KUUZU::getIPAddress();
      $wo_last_page_url = HTML::outputProtected(substr($_SERVER['REQUEST_URI'], 0, 255));

      $current_time = time();
      $xx_mins_ago = ($current_time - 900);

// remove entries that have expired
      $Qwhosonline = $KUUZU_PDO->prepare('delete from :table_whos_online where time_last_click < :time_last_click');
      $Qwhosonline->bindValue(':time_last_click', $xx_mins_ago);
      $Qwhosonline->execute();

      $Qwhosonline = $KUUZU_PDO->prepare('select count(*) as count from :table_whos_online where session_id = :session_id');
      $Qwhosonline->bindValue(':session_id', $wo_session_id);
      $Qwhosonline->execute();

      if ( $Qwhosonline->valueInt('count') > 0 ) {
        $Qwhosonline = $KUUZU_PDO->prepare('update :table_whos_online set customer_id = :customer_id, full_name = :full_name, ip_address = :ip_address, time_last_click = :time_last_click, last_page_url = :last_page_url where session_id = :session_id');

        if ( $wo_customer_id > 0 ) {
          $Qwhosonline->bindInt(':customer_id', $wo_customer_id);
        } else {
          $Qwhosonline->bindNull(':customer_id');
        }

        $Qwhosonline->bindValue(':full_name', $wo_full_name);
        $Qwhosonline->bindValue(':ip_address', $wo_ip_address);
        $Qwhosonline->bindValue(':time_last_click', $current_time);
        $Qwhosonline->bindValue(':last_page_url', $wo_last_page_url);
        $Qwhosonline->bindValue(':session_id', $wo_session_id);
        $Qwhosonline->execute();
      } else {
        $Qwhosonline = $KUUZU_PDO->prepare('insert into :table_whos_online (customer_id, full_name, session_id, ip_address, time_entry, time_last_click, last_page_url) values (:customer_id, :full_name, :session_id, :ip_address, :time_entry, :time_last_click, :last_page_url)');

        if ( $wo_customer_id > 0 ) {
          $Qwhosonline->bindInt(':customer_id', $wo_customer_id);
        } else {
          $Qwhosonline->bindNull(':customer_id');
        }

        $Qwhosonline->bindValue(':full_name', $wo_full_name);
        $Qwhosonline->bindValue(':session_id', $wo_session_id);
        $Qwhosonline->bindValue(':ip_address', $wo_ip_address);
        $Qwhosonline->bindValue(':time_entry', $current_time);
        $Qwhosonline->bindValue(':time_last_click', $current_time);
        $Qwhosonline->bindValue(':last_page_url', $wo_last_page_url);
        $Qwhosonline->execute();
      }

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
