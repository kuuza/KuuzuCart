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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Administrators\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\Administrators\Administrators;

/**
 * @since v3.0.3
 */

  class SavePermissions { // HPDL Albert would proudly say "Hey, hey, hey, it's a faattt SQL module!"; abstraction needed
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $error = false;

      $KUUZU_PDO->beginTransaction();

      if ( ($data['mode'] == Administrators::ACCESS_MODE_ADD) || ($data['mode'] == Administrators::ACCESS_MODE_SET) ) {
        foreach ( $data['modules'] as $module ) {
          $execute = true;

          if ( $module != '*' ) {
            $Qcheck = $KUUZU_PDO->prepare('select administrators_id from :table_administrators_access where administrators_id = :administrators_id and module = :module limit 1');
            $Qcheck->bindInt(':administrators_id', $data['id']);
            $Qcheck->bindValue(':module', '*');
            $Qcheck->execute();

            if ( $Qcheck->fetch() !== false ) {
              $execute = false;
            }
          }

          if ( $execute === true ) {
            $Qcheck = $KUUZU_PDO->prepare('select administrators_id from :table_administrators_access where administrators_id = :administrators_id and module = :module limit 1');
            $Qcheck->bindInt(':administrators_id', $data['id']);
            $Qcheck->bindValue(':module', $module);
            $Qcheck->execute();

            if ( $Qcheck->fetch() === false ) {
              $Qinsert = $KUUZU_PDO->prepare('insert into :table_administrators_access (administrators_id, module) values (:administrators_id, :module)');
              $Qinsert->bindInt(':administrators_id', $data['id']);
              $Qinsert->bindValue(':module', $module);
              $Qinsert->execute();

              if ( $Qinsert->isError() ) {
                $error = true;
                break;
              }
            }
          }
        }
      }

      if ( $error === false ) {
        if ( ($data['mode'] == Administrators::ACCESS_MODE_REMOVE) || ($data['mode'] == Administrators::ACCESS_MODE_SET) || in_array('*', $data['modules']) ) {
          if ( !empty($data['modules']) ) {
            $sql_query = 'delete from :table_administrators_access where administrators_id = :administrators_id';

            if ( $data['mode'] == Administrators::ACCESS_MODE_REMOVE ) {
              if ( !in_array('*', $data['modules']) ) {
                $sql_query .= ' and module in (\'' . implode('\', \'', $data['modules']) . '\')'; // HPDL create bindRaw()?
              }
            } else {
              $sql_query .= ' and module not in (\'' . implode('\', \'', $data['modules']) . '\')'; // HPDL create bindRaw()?
            }

            $Qdel = $KUUZU_PDO->prepare($sql_query);
            $Qdel->bindInt(':administrators_id', $data['id']);
            $Qdel->execute();

            if ( $Qdel->isError() ) {
              $error = true;
              break;
            }
          }
        }
      }

      if ( $error === false ) {
        $KUUZU_PDO->commit();

        return true;
      }

      $KUUZU_PDO->rollBack();

      return false;
    }
  }
?>
