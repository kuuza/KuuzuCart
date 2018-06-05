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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\Administrators\Administrators;

  class configureShop {
    public static function execute($data) {
      Registry::set('PDO', PDO::initialize($data['server'], $data['username'], $data['password'], $data['database'], $data['port'], $data['class']));

      KUUZU::setConfig('db_table_prefix', $data['table_prefix'], 'Admin');
      KUUZU::setConfig('db_table_prefix', $data['table_prefix'], 'Shop');
      KUUZU::setConfig('db_table_prefix', $data['table_prefix'], 'Setup');

      $cfg_data = array(array('key' => 'STORE_NAME',
                              'value' => $data['shop_name']),
                        array('key' => 'STORE_OWNER',
                              'value' => $data['shop_owner_name']),
                        array('key' => 'STORE_OWNER_EMAIL_ADDRESS',
                              'value' => $data['shop_owner_email']),
                        array('key' => 'EMAIL_FROM',
                              'value' => '"' . $data['shop_owner_name'] . '" <' . $data['shop_owner_email'] . '>')
                       );

      KUUZU::callDB('Admin\UpdateConfigurationParameters', $cfg_data, 'Site');

      $admin_data = array('username' => $data['admin_username'],
                          'password' => $data['admin_password'],
                          'modules' => array('0'));

      Administrators::save($admin_data);
    }
  }
?>
