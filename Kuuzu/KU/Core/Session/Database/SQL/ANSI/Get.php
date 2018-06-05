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

class Get
{
    public static function execute(array $data)
    {
        $KUUZU_PDO = Registry::get('PDO');

        $Qsession = $KUUZU_PDO->prepare('select value from :table_sessions where id = :id');
        $Qsession->bindValue(':id', $data['id']);
        $Qsession->execute();

        return $Qsession->fetch();
    }
}
