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

use Kuuzu\KU\Core\Registry;

class Check
{
    public static function execute(array $data): bool
    {
        $KUUZU_PDO = Registry::get('PDO');

        $Qsession = $KUUZU_PDO->prepare('select 1 from :table_sessions where id = :id');
        $Qsession->bindValue(':id', $data['id']);
        $Qsession->execute();

        return $Qsession->fetch() !== false;
    }
}
