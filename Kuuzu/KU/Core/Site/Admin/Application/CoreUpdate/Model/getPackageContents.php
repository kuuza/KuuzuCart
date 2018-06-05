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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\Model;

  use \Phar;
  use \RecursiveIteratorIterator;
  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;

  class getPackageContents {
    public static function execute() {
      $result = array('entries' => array());

      $phar_can_open = true;

      try {
        $phar = new Phar(KUUZU::BASE_DIRECTORY . 'Work/CoreUpdate/update.phar');
      } catch ( \Exception $e ) {
        $phar_can_open = false;

        trigger_error($e->getMessage());
      }

      if ( $phar_can_open === true ) {
        $update_pkg = array();

        foreach ( new RecursiveIteratorIterator($phar) as $iteration ) {
          if ( ($pos = strpos($iteration->getPathName(), 'update.phar')) !== false ) {
            $update_pkg[] = substr($iteration->getPathName(), $pos+12);
          }
        }

        natcasesort($update_pkg);

        $counter = 0;

        foreach ( $update_pkg as $file ) {
          if ( substr($file, 0, 14) == 'Kuuzu/KU/' ) {
            $custom = false;

            if ( substr($file, 14, 5) == 'Core/' ) {
              $custom = file_exists(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/Kuuzu/KU/Custom/' . substr($file, 19));
            }

            $result['entries'][] = array('key' => $counter,
                                         'name' => $file,
                                         'exists' => file_exists(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . $file),
                                         'writable' => self::isWritable(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . $file) && self::isWritable(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . dirname($file)),
                                         'custom' => $custom,
                                         'to_delete' => false);

            $counter++;
          } elseif ( substr($file, 0, 7) == 'public/' ) {
            $result['entries'][] = array('key' => $counter,
                                         'name' => $file,
                                         'exists' => file_exists(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . $file),
                                         'writable' => self::isWritable(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . $file) && self::isWritable(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . dirname($file)),
                                         'custom' => false,
                                         'to_delete' => false);

            $counter++;
          }
        }
      }

      $meta = $phar->getMetadata();

      if ( isset($meta['delete']) ) {
        $files = array();

        foreach ( $meta['delete'] as $file ) {
          if ( substr($file, 0, 14) == 'Kuuzu/KU/' ) {
            if ( file_exists(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . $file) ) {
              if ( is_dir(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . $file) ) {
                $DL = new DirectoryListing(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . $file);
                $DL->setRecursive(true);
                $DL->setAddDirectoryToFilename(true);
                $DL->setIncludeDirectories(false);

                foreach ( $DL->getFiles() as $f ) {
                  $files[] = $file . '/' . $f['name'];
                }
              } else {
                $files[] = $file;
              }
            }
          } elseif ( substr($file, 0, 7) == 'public/' ) {
            if ( file_exists(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . $file) ) {
              if ( is_dir(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . $file) ) {
                $DL = new DirectoryListing(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . $file);
                $DL->setRecursive(true);
                $DL->setAddDirectoryToFilename(true);
                $DL->setIncludeDirectories(false);

                foreach ( $DL->getFiles() as $f ) {
                  $files[] = $file . '/' . $f['name'];
                }
              } else {
                $files[] = $file;
              }
            }
          }
        }

        natcasesort($files);

        foreach ( $files as $d ) {
          $writable = false;
          $custom = false;

          if ( substr($d, 0, 14) == 'Kuuzu/KU/' ) {
            $writable = self::isWritable(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . $d) && self::isWritable(realpath(KUUZU::BASE_DIRECTORY . '../../') . '/' . dirname($d));
          } elseif ( substr($d, 0, 7) == 'public/' ) {
            $writable = self::isWritable(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . $d) && self::isWritable(realpath(KUUZU::getConfig('dir_fs_public', 'KUUZU') . '../') . '/' . dirname($d));
          }

          $result['entries'][] = array('key' => $counter,
                                       'name' => $d,
                                       'exists' => true,
                                       'writable' => $writable,
                                       'custom' => $custom,
                                       'to_delete' => true);

          $counter++;
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }

    public static function isWritable($location) {
      if ( !file_exists($location) ) {
        while ( true ) {
          $location = dirname($location);

          if ( file_exists($location) ) {
            break;
          }
        }
      }

      return is_writable($location);
    }
  }
?>
