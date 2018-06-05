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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Service;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\DateTime;

  class SimpleCounter implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcounter = $KUUZU_PDO->query('select startdate, counter from :table_counter');
      $Qcounter->execute();

      $result = $Qcounter->fetchAll();

      if ( count($result) > 0 ) {
        $KUUZU_PDO->exec('update :table_counter set counter = counter+1');
      } else {
        $Qcounterupdate = $KUUZU_PDO->prepare('insert into :table_counter (startdate, counter) values (:start_date, 1)');
        $Qcounterupdate->bindValue(':start_date', DateTime::getNow());
        $Qcounterupdate->execute();
      }

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
