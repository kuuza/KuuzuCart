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

namespace Kuuzu\KU\Core;

class Sanitize
{
    public static function simple(string $value = null): string
    {
        if (!isset($value)) {
            return '';
        }

        return trim(str_replace([
            "\r\n",
            "\n",
            "\r"
        ], '', $value));
    }
}
