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

  namespace Kuuzu\KU\Core\Site\Setup;

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\XML;

  class Language extends \Kuuzu\KU\Core\Site\Admin\Language {
    public function __construct() {
      $DLlang = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages');
      $DLlang->setIncludeDirectories(false);
      $DLlang->setCheckExtension('xml');

      foreach ( $DLlang->getFiles() as $file ) {
        $lang = XML::toArray(simplexml_load_file(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $file['name']));

        if ( !isset($lang['language']) ) { // create root element (simpleXML does not use root element)
          $lang = array('language' => $lang);
        }

        $this->_languages[$lang['language']['data']['code']] = array('id' => 1, //HPDL to remove
                                                                     'code' => $lang['language']['data']['code'],
                                                                     'name' => $lang['language']['data']['title'],
                                                                     'locale' => $lang['language']['data']['locale'],
                                                                     'charset' => $lang['language']['data']['character_set'],
                                                                     'date_format_short' => $lang['language']['data']['date_format_short'],
                                                                     'date_format_long' => $lang['language']['data']['date_format_long'],
                                                                     'time_format' => $lang['language']['data']['time_format'],
                                                                     'text_direction' => $lang['language']['data']['text_direction'],
                                                                     'parent_id' => 0);
      }

      unset($lang);

      $language = (isset($_GET['language']) && !empty($_GET['language']) ? $_GET['language'] : '');

      $this->set($language);

      header('Content-Type: text/html; charset=' . $this->getCharacterSet());

      $this->loadIniFile();
      $this->loadIniFile(KUUZU::getSiteApplication() . '.php');
    }

    function set($code = null) {
      $this->_code = $code;

      if ( empty($this->_code) ) {
        if ( isset($_COOKIE[KUUZU::getSite()]['language']) ) {
          $this->_code = $_COOKIE[KUUZU::getSite()]['language'];
        } else {
          $this->_code = $this->getBrowserSetting();
        }
      }

      if ( empty($this->_code) || !$this->exists($this->_code) ) {
        $this->_code = 'en_US';
      }

      if ( !isset($_COOKIE[KUUZU::getSite()]['language']) || ($_COOKIE[KUUZU::getSite()]['language'] != $this->_code) ) {
        KUUZU::setCookie(KUUZU::getSite() . '[language]', $this->_code, time()+60*60*24*90);
      }
    }

    public function loadIniFile($filename = null, $comment = '#', $language_code = null) {
      if ( is_null($language_code) ) {
        $language_code = $this->_code;
      }

      if ( $this->_languages[$language_code]['parent_id'] > 0 ) {
        $this->loadIniFile($filename, $comment, $this->getCodeFromID($this->_languages[$language_code]['parent_id']));
      }

      if ( is_null($filename) ) {
        if ( file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code . '.php') ) {
          $contents = file(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code . '.php');
        } else {
          return array();
        }
      } else {
        if ( substr(realpath(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code . '/' . $filename), 0, strlen(realpath(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code))) != realpath(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code) ) {
          return array();
        }

        if ( !file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code . '/' . $filename) ) {
          return array();
        }

        $contents = file(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Languages/' . $language_code . '/' . $filename);
      }

      $ini_array = array();

      foreach ( $contents as $line ) {
        $line = trim($line);

        $firstchar = substr($line, 0, 1);

        if ( !empty($line) && ( $firstchar != $comment) ) {
          $delimiter = strpos($line, '=');

          if ( $delimiter !== false ) {
            $key = trim(substr($line, 0, $delimiter));
            $value = trim(substr($line, $delimiter + 1));

            $ini_array[$key] = $value;
          } elseif ( isset($key) ) {
            $ini_array[$key] .= trim($line);
          }
        }
      }

      unset($contents);

      $this->_definitions = array_merge($this->_definitions, $ini_array);
    }

    function getCode($id = null) {
      return $this->_code;
    }
  }
?>
