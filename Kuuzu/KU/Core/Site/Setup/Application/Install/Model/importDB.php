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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install\Model;

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Setup\Language;

  class importDB {
    public static function execute($data) {
      Registry::set('PDO', PDO::initialize($data['server'], $data['username'], $data['password'], $data['database'], $data['port'], $data['class']));

// Import SQL queries

      KUUZU::callDB('Setup\Install\ImportSQL', array('table_prefix' => $data['table_prefix']));

// Import language definitions

      KUUZU::setConfig('db_table_prefix', $data['table_prefix'], 'Admin');
      KUUZU::setConfig('db_table_prefix', $data['table_prefix'], 'Shop');
      KUUZU::setConfig('db_table_prefix', $data['table_prefix'], 'Setup');

      foreach ( Language::extractDefinitions('en_US.xml') as $def ) {
        $def['id'] = 1;

        KUUZU::callDB('Admin\InsertLanguageDefinition', $def, 'Site');
      }

      $DL_lang = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/en_US');
      $DL_lang->setRecursive(true);
      $DL_lang->setIncludeDirectories(false);
      $DL_lang->setAddDirectoryToFilename(true);
      $DL_lang->setCheckExtension('xml');

      foreach ( $DL_lang->getFiles() as $files ) {
        foreach ( Language::extractDefinitions('en_US/' . $files['name']) as $def ) {
          $def['id'] = 1;

          KUUZU::callDB('Admin\InsertLanguageDefinition', $def, 'Site');
        }
      }

// Import Service modules

      $services = array('OutputCompression',
                        'Session',
                        'Language',
                        'Debug',
                        'Currencies',
                        'Core',
                        'SimpleCounter',
                        'CategoryPath',
                        'Breadcrumb',
                        'WhosOnline',
// HPDL                   'banner',
                        'Specials',
                        'Reviews',
                        'RecentlyVisited');

      $installed = array();

      foreach ( $services as $service ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $service;
        $module = new $class();
        $module->install();

        if ( isset($module->depends) ) {
          if ( is_string($module->depends) && (($key = array_search($module->depends, $installed)) !== false) ) {
            if ( isset($installed[$key+1]) ) {
              array_splice($installed, $key+1, 0, $service);
            } else {
              $installed[] = $service;
            }
          } elseif ( is_array($module->depends) ) {
            foreach ( $module->depends as $depends_module ) {
              if ( ($key = array_search($depends_module, $installed)) !== false ) {
                if ( !isset($array_position) || ($key > $array_position) ) {
                  $array_position = $key;
                }
              }
            }

            if ( isset($array_position) ) {
              array_splice($installed, $array_position+1, 0, $service);
            } else {
              $installed[] = $service;
            }
          }
        } elseif ( isset($module->precedes) ) {
          if ( is_string($module->precedes) ) {
            if ( ($key = array_search($module->precedes, $installed)) !== false ) {
              array_splice($installed, $key, 0, $service);
            } else {
              $installed[] = $service;
            }
          } elseif ( is_array($module->precedes) ) {
            foreach ( $module->precedes as $precedes_module ) {
              if ( ($key = array_search($precedes_module, $installed)) !== false ) {
                if ( !isset($array_position) || ($key < $array_position) ) {
                  $array_position = $key;
                }
              }
            }

            if ( isset($array_position) ) {
              array_splice($installed, $array_position, 0, $service);
            } else {
              $installed[] = $service;
            }
          }
        } else {
          $installed[] = $service;
        }

        unset($array_position);
      }

      $cfg_data = array('title' => 'Service Modules',
                        'key' => 'MODULE_SERVICES_INSTALLED',
                        'value' => implode(';', $installed),
                        'description' => 'Installed services modules',
                        'group_id' => '6');

      KUUZU::callDB('Admin\InsertConfigurationParameters', $cfg_data, 'Site');

// Import Payment modules

      define('DEFAULT_ORDERS_STATUS_ID', 1);

      $module = new \Kuuzu\KU\Core\Site\Admin\Module\Payment\COD();
      $module->install();

      $pm_data = array('key' => 'MODULE_PAYMENT_COD_STATUS',
                       'value' => '1');

      KUUZU::callDB('Admin\UpdateConfigurationParameters', $pm_data, 'Site');

// Import Shipping modules

      $module = new \Kuuzu\KU\Core\Site\Admin\Module\Shipping\Flat();
      $module->install();

// Import Order Total modules

      $module = new \Kuuzu\KU\Core\Site\Admin\Module\OrderTotal\SubTotal();
      $module->install();

      $module = new \Kuuzu\KU\Core\Site\Admin\Module\OrderTotal\Shipping();
      $module->install();

      $module = new \Kuuzu\KU\Core\Site\Admin\Module\OrderTotal\Tax();
      $module->install();

      $module = new \Kuuzu\KU\Core\Site\Admin\Module\OrderTotal\Total();
      $module->install();

// Import Foreign Keys

      KUUZU::callDB('Setup\Install\ImportFK', array('table_prefix' => $data['table_prefix']));
    }
  }
?>
