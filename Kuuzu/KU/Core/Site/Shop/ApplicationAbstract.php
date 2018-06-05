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

  namespace Kuuzu\KU\Core\Site\Shop;

  use Kuuzu\KU\Core\Registry;

  abstract class ApplicationAbstract extends \Kuuzu\KU\Core\ApplicationAbstract {
    public function __construct() {
      $this->ignoreAction(Registry::get('Session')->getName());

      parent::__construct();
    }
  }
?>
