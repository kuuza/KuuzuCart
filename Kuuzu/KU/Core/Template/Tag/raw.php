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

use Kuuzu\KU\Core\{
    KUUZU,
    Registry
};

class raw extends \Kuuzu\KU\Core\Template\TagAbstract
{
    protected static $_parse_result = false;

    public static function execute($string)
    {
        $args = func_get_args();

        $KUUZU_Template = Registry::get('Template');

        $result = '';

        if (strpos($string, ' ') === false) {
            if ($KUUZU_Template->valueExists($string)) {
                $result = $KUUZU_Template->getValue($string);
            }
        } else {
            list($array, $key) = explode(' ', $string, 2);

            if ($KUUZU_Template->valueExists($array)) {
                $value = $KUUZU_Template->getValue($array);

                if (is_array($value)) {
                    $pass = true;

                    foreach (explode(' ', $key) as $k) {
                        if (isset($value[$k])) {
                            $value = $value[$k];
                        } else {
                            $pass = false;
                            break;
                        }
                    }

                    if ($pass === true) {
                        $result = $value;
                    }
                }
            }
        }

        if (isset($args[1]) && !empty($args[1])) {
            $result = call_user_func(trim($args[1]), $result);
        }

        return $result;
    }
}
