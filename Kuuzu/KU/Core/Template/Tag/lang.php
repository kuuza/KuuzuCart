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

use Kuuzu\KU\Core\KUUZU;

class lang extends \Kuuzu\KU\Core\Template\TagAbstract
{
    public static function execute($string)
    {
        $args = func_get_args();

        $key = trim($string);
        $values = [];

        if (strpos($key, ' ') !== false) {
            $x = new \SimpleXMLElement('<' . $key . ' />');

            if (count($x->attributes()) > 0) {
                $key = $x->getName();

                foreach ($x->attributes() as $k => $v) {
                    $values[':' . $k] = (string)$v;
                }
            }
        }

        $result = KUUZU::getDef($key, $values);

        if (isset($args[1]) && !empty($args[1])) {
            $result = call_user_func(trim($args[1]), $result);
        }

        return $result;
    }
}
