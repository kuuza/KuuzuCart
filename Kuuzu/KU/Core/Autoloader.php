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

  namespace {
    if ( !class_exists('SplClassLoader') ) {
      include(__DIR__ . '/../External/SplClassLoader.php');
    }
  }

  namespace Kuuzu\KU\Core {
    class Autoloader extends \SplClassLoader {
      public function loadClass($className) {
        if (null === $this->_namespace || $this->_namespace.$this->_namespaceSeparator === substr($className, 0, strlen($this->_namespace.$this->_namespaceSeparator))) {
          $fileName = '';
          $namespace = '';

          if (false !== ($lastNsPos = strripos($className, $this->_namespaceSeparator))) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
          }

          $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . $this->_fileExtension;

          $includeFile = ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $fileName;

// HPDL; require() returns a "file does not exist" error when \class_exists() is
// used. Instead, use file_exists() and include()

// HPDL: Check for and include custom version
          if ( strpos($includeFile, 'Kuuzu' . DIRECTORY_SEPARATOR . 'KU' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR) !== false ) {
            $includeFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $includeFile;

            $custom_includeFile = str_replace('Kuuzu' . DIRECTORY_SEPARATOR . 'KU' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR, 'Kuuzu' . DIRECTORY_SEPARATOR . 'KU' . DIRECTORY_SEPARATOR . 'Custom' . DIRECTORY_SEPARATOR, $includeFile);

            if (file_exists($custom_includeFile)) {
              include ($custom_includeFile);
              return true;
            }
          }

          if (file_exists($includeFile)) {
            include ($includeFile);
            return true;
          }
        }
      }
    }
  }
?>
