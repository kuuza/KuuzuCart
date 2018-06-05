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

  use Kuuzu\KU\Core\KUUZU;

  define('KUUZU_TIMESTAMP_START', microtime());

  error_reporting(E_ALL);

  define('KUUZU_PUBLIC_BASE_DIRECTORY', __DIR__ . '/');

  require('Kuuzu/KU/Core/KUUZU.php');
  spl_autoload_register('Kuuzu\\KU\\Core\\KUUZU::autoload');

  KUUZU::initialize();

  echo $KUUZU_Template->getContent();
?>
