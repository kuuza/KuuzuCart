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

  namespace Kuuzu\KU\Core\Template\Tag;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;

  class button extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      $params = explode('|', $string, 2);

      $data = array('icon' => $params[0]);

      if ( isset($params[1]) ) {
        $data['title'] = KUUZU::getDef($params[1]);
      }

      return HTML::button($data);
    }
  }
?>
