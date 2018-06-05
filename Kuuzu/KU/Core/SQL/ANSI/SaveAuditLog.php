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

  namespace Kuuzu\KU\Core\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class SaveAuditLog {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      try {
        $KUUZU_PDO->beginTransaction();

        $audit = [ 'site' => $data['site'],
                   'application' => $data['application'],
                   'action' => $data['action'],
                   'row_id' => $data['id'],
                   'user_id' => $data['user_id'],
                   'ip_address' => $data['ip_address'],
                   'action_type' => $data['action_type'],
                   'date_added' => 'now()' ];

        $KUUZU_PDO->save('audit_log', $audit);

        $audit_id = $KUUZU_PDO->lastInsertId();

        foreach ( $data['rows'] as $row ) {
          $record = [ 'audit_log_id' => $audit_id,
                      'row_key' => $row['key'],
                      'old_value' => $row['old'],
                      'new_value' => $row['new'] ];

          $KUUZU_PDO->save('audit_log_rows', $record);
        }

        $KUUZU_PDO->commit();

        return true;
      } catch ( \Exception $e ) {
        $KUUZU_PDO->rollBack();

        trigger_error($e->getMessage());
      }

      return false;
    }
  }
?>
