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
  use Kuuzu\KU\Core\Site\Shop\Specials as SpecialsClass;

  class Specials implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Specials', new SpecialsClass());

      $KUUZU_Specials = Registry::get('Specials');

      $KUUZU_Specials->activateAll();
      $KUUZU_Specials->expireAll();

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
