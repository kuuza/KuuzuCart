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

use Kuuzu\KU\Core\KUUZU;

class AuditLog
{
    public static function save($data)
    {
        if (!isset($data['site'])) {
            $data['site'] = KUUZU::getSite();
        }

        if (!isset($data['application'])) {
            $data['application'] = KUUZU::getSiteApplication();
        }

        if (!isset($data['action'])) {
            $data['action'] = null;
        }

        KUUZU::callDB('SaveAuditLog', $data, 'Core');
    }

    public static function getAll($req, $id, $limit = 10)
    {
        $sig = explode('\\', $req, 3);

        $data = [
            'site' => $sig[0],
            'application' => $sig[1],
            'action' => $sig[2],
            'id' => $id,
            'limit' => $limit
        ];

        return KUUZU::callDB('GetAuditLog', $data, 'Core');
    }

    public static function getDiff(array $array1, array $array2)
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (!array_key_exists($key, $array2) || !is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = static::getDiff($value, $array2[$key]);

                    if (!empty($new_diff)) {
                        $difference[$key] = $new_diff;
                    }
                }
            } else if (!array_key_exists($key, $array2) || ($array2[$key] !== $value)) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }
}
