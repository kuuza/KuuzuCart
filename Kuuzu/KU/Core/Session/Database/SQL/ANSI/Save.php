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

namespace Kuuzu\KU\Core\Session\Database\SQL\ANSI;

use Kuuzu\KU\Core\{
    KUUZU,
    Registry
};

class Save
{
    public static function execute(array $data): bool
    {
        $KUUZU_PDO = Registry::get('PDO');

        if (KUUZU::callDB('Session\Database\Check', [
            'id' => $data['id']
        ], 'Core')) {
            $sql_query = 'update :table_sessions set expiry = :expiry, value = :value where id = :id';
        } else {
            $sql_query = 'insert into :table_sessions (id, expiry, value) values (:id, :expiry, :value)';
        }

        $Qsession = $KUUZU_PDO->prepare($sql_query);
        $Qsession->bindValue(':id', $data['id']);
        $Qsession->bindInt(':expiry', $data['expiry']);
        $Qsession->bindValue(':value', $data['value']);
        $Qsession->execute();

        return $Qsession->isError() === false;
    }
}
