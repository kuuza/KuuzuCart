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

namespace Kuuzu\KU\Core\SQL\MySQL\Standard;

use Kuuzu\KU\Core\Registry;

class GetTransactionId
{
    public static function execute($data): int
    {
        $KUUZU_PDO = Registry::get('PDO');

        $KUUZU_PDO->beginTransaction();

        $Qv = $KUUZU_PDO->prepare('select tx_value from :table_transaction_ids where tx_key = :tx_key for update');
        $Qv->bindValue(':tx_key', $data['key']);
        $Qv->execute();

        $value = $Qv->valueInt('tx_value');

        $Qv = $KUUZU_PDO->prepare('update :table_transaction_ids set tx_value = tx_value+1 where tx_key = :tx_key');
        $Qv->bindValue(':tx_key', $data['key']);
        $Qv->execute();

        $KUUZU_PDO->commit();

        return $value;
    }
}
