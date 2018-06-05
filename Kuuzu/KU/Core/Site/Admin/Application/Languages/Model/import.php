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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\Model;

  use Kuuzu\KU\Core\XML;
  use Kuuzu\KU\Core\Site\Admin\Application\Currencies\Currencies;
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;
  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Admin\Language;
  use Kuuzu\KU\Core\Cache;

  class import {
    public static function execute($data) {
      $source = array('language' => XML::toArray(simplexml_load_file(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $data['code'] . '.xml')));

      $language = array('name' => $source['language']['data']['title'],
                        'code' => $source['language']['data']['code'],
                        'locale' => $source['language']['data']['locale'],
                        'charset' => $source['language']['data']['character_set'],
                        'date_format_short' => $source['language']['data']['date_format_short'],
                        'date_format_long' => $source['language']['data']['date_format_long'],
                        'time_format' => $source['language']['data']['time_format'],
                        'text_direction' => $source['language']['data']['text_direction'],
                        'currency' => $source['language']['data']['default_currency'],
                        'numeric_separator_decimal' => $source['language']['data']['numerical_decimal_separator'],
                        'numeric_separator_thousands' => $source['language']['data']['numerical_thousands_separator'],
                        'parent_language_code' => (isset($source['language']['data']['parent_language_code']) ? $source['language']['data']['parent_language_code'] : ''),
                        'parent_id' => 0);

      if ( !Currencies::exists($language['currency']) ) {
        $language['currency'] = DEFAULT_CURRENCY;
      }

      $language['currencies_id'] = Currencies::get($language['currency'], 'currencies_id');

      if ( !empty($language['parent_language_code']) && Languages::exists($language['parent_language_code']) ) {
        $language['parent_id'] = Languages::get($language['parent_language_code'], 'languages_id');
      }

      $language['id'] = Languages::get($language['code'], 'languages_id');
      $language['default_language_id'] = Languages::get(DEFAULT_LANGUAGE, 'languages_id');
      $language['import_type'] = $data['type'];

      $definitions = array();

      if ( isset($source['language']['definitions']['definition']) ) {
        $definitions = $source['language']['definitions']['definition'];

        if ( isset($definitions['key']) && isset($definitions['value']) && isset($definitions['group']) ) {
          $definitions = array(array('key' => $definitions['key'],
                                     'value' => $definitions['value'],
                                     'group' => $definitions['group']));
        }
      }

      unset($source);

      $KUUZU_DirectoryListing = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $data['code']);
      $KUUZU_DirectoryListing->setRecursive(true);
      $KUUZU_DirectoryListing->setIncludeDirectories(false);
      $KUUZU_DirectoryListing->setAddDirectoryToFilename(true);
      $KUUZU_DirectoryListing->setCheckExtension('xml');

      foreach ( $KUUZU_DirectoryListing->getFiles() as $files ) {
        $definitions = array_merge($definitions, Language::extractDefinitions($data['code'] . '/' . $files['name']));
      }

      $language['definitions'] = $definitions;

      if ( KUUZU::callDB('Admin\Languages\Import', $language) ) {
        Cache::clear('languages');

        return true;
      }

      return false;
    }
  }
?>
