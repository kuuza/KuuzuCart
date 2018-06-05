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
  use Kuuzu\KU\Core\Site\Shop\Reviews as ReviewsClass;

  class Reviews implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Reviews', new ReviewsClass());

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
