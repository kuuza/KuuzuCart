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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Debug implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( SERVICE_DEBUG_CHECK_LOCALE == '1' ) {
        $setlocale = setlocale(LC_TIME, explode(',', $KUUZU_Language->getLocale()));

        if ( ($setlocale === false) || ($setlocale === null) ) {
          $KUUZU_MessageStack->add('debug', 'Error: Locale does not exist: ' . $KUUZU_Language->getLocale(), 'error');
        }
      }

      if ( (SERVICE_DEBUG_CHECK_INSTALLATION_MODULE == '1') && file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/Setup') ) {
        $KUUZU_MessageStack->add('debug', sprintf(KUUZU::getDef('warning_install_directory_exists'), KUUZU::BASE_DIRECTORY . 'Core/Site/Setup'), 'warning');
      }

      if ( (SERVICE_DEBUG_CHECK_CONFIGURATION == '1') && is_writeable(KUUZU::BASE_DIRECTORY . 'Config/settings.ini') ) {
        $KUUZU_MessageStack->add('debug', sprintf(KUUZU::getDef('warning_config_file_writeable'), KUUZU::BASE_DIRECTORY . 'Config//settings.ini'), 'warning');
      }

      if ( (SERVICE_DEBUG_CHECK_SESSION_DIRECTORY == '1') && (KUUZU::getConfig('store_sessions') == '') ) {
        if ( !is_dir(KUUZU_Registry::get('Session')->getSavePath()) ) {
          $KUUZU_MessageStack->add('debug', sprintf(KUUZU::getDef('warning_session_directory_non_existent'), KUUZU_Registry::get('Session')->getSavePath()), 'warning');
        } elseif ( !is_writeable(KUUZU_Registry::get('Session')->getSavePath()) ) {
          $KUUZU_MessageStack->add('debug', sprintf(KUUZU::getDef('warning_session_directory_not_writeable'), KUUZU_Registry::get('Session')->getSavePath()), 'warning');
        }
      }

      if ( (SERVICE_DEBUG_CHECK_SESSION_AUTOSTART == '1') && (bool)ini_get('session.auto_start') ) {
        $KUUZU_MessageStack->add('debug', KUUZU::getDef('warning_session_auto_start'), 'warning');
      }

      if ( (SERVICE_DEBUG_CHECK_DOWNLOAD_DIRECTORY == '1') && (DOWNLOAD_ENABLED == '1') ) {
        if ( !is_dir(DIR_FS_DOWNLOAD) ) {
          $KUUZU_MessageStack->add('debug', sprintf(KUUZU::getDef('warning_download_directory_non_existent'), DIR_FS_DOWNLOAD), 'warning');
        }
      }

      return true;
    }

    public static function stop() {
      $KUUZU_MessageStack = Registry::get('MessageStack');
      $KUUZU_Template = Registry::get('Template');

      $time_start = explode(' ', KUUZU_TIMESTAMP_START);
      $time_end = explode(' ', microtime());
      $parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);

      if ( strlen(SERVICE_DEBUG_EXECUTION_TIME_LOG) > 0 ) {
        if ( !error_log(strftime('%c') . ' - ' . $_SERVER['REQUEST_URI'] . ' (' . $parse_time . 's)' . "\n", 3, SERVICE_DEBUG_EXECUTION_TIME_LOG)) {
          if ( !file_exists(SERVICE_DEBUG_EXECUTION_TIME_LOG) || !is_writable(SERVICE_DEBUG_EXECUTION_TIME_LOG) ) {
            $KUUZU_MessageStack->add('debug', 'Error: Execution time log file not writeable: ' . SERVICE_DEBUG_EXECUTION_TIME_LOG, 'error');
          }
        }
      }

      if ( SERVICE_DEBUG_EXECUTION_DISPLAY == '1' ) {
        $KUUZU_MessageStack->add('debug', 'Execution Time: ' . $parse_time . 's', 'warning');
      }

      if ( $KUUZU_Template->showDebugMessages() && $KUUZU_MessageStack->exists('debug') ) {
        echo $KUUZU_MessageStack->get('debug');
      }

      return true;
    }
  }
?>
