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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Widget\message_stack;

  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Template\WidgetAbstract {
    static public function execute($group = null) {
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( $KUUZU_MessageStack->exists($group) ) {
        return $KUUZU_MessageStack->get($group);
      }
    }
  }
?>
