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

namespace Kuuzu\KU\Core\Hash;

class Salt
{
    public static function get(string $string): string
    {
        $hash = '';

        for ($i = 0; $i < 10; $i++) {
            $hash .= random_int(PHP_INT_MIN, PHP_INT_MAX);
        }

        $salt = substr(md5($hash), 0, 2);

        $hash = md5($salt . $string) . ':' . $salt;

        return $hash;
    }

    public static function validate(string $plain, string $hashed): bool
    {
        if (empty($plain) || empty($hashed)) {
            return false;
        }

// split apart the hash / salt
        $stack = explode(':', $hashed);

        if (count($stack) != 2) {
            return false;
        }

        return (md5($stack[1] . $plain) == $stack[0]);
    }

    public static function canUse(): bool
    {
        return true;
    }
}
