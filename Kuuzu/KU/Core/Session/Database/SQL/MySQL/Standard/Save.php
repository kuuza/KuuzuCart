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

namespace Kuuzu\KU\Core\Session\Database\SQL\MySQL\Standard;

use Kuuzu\KU\Core\{
    KUUZU,
    Registry
};

class Save
{
    public static function execute(array $data): bool
    {
        $KUUZU_PDO = Registry::get('PDO');

        $Qsession = $KUUZU_PDO->prepare('insert into :table_sessions (id, expiry, value) values (:id, :expiry, :value) on duplicate key update expiry = values(expiry), value = values(value)');
        $Qsession->bindValue(':id', $data['id']);
        $Qsession->bindInt(':expiry', $data['expiry']);
        $Qsession->bindValue(':value', $data['value']);
        $Qsession->execute();

        return $Qsession->isError() === false;
    }
}
