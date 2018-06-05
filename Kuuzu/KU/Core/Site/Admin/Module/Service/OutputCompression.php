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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Service;

  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class OutputCompression extends \Kuuzu\KU\Core\Site\Admin\ServiceAbstract {
    var $precedes = 'Session';

    protected function initialize() {
      $this->title = KUUZU::getDef('services_output_compression_title');
      $this->description = KUUZU::getDef('services_output_compression_description');
    }

    public function install() {
      $data = array('title' => 'GZIP Compression Level',
                    'key' => 'SERVICE_OUTPUT_COMPRESSION_GZIP_LEVEL',
                    'value' => '5',
                    'description' => 'Set the GZIP compression level to this value (0=min, 9=max).',
                    'group_id' => '6',
                    'set_function' => 'kuu_cfg_set_boolean_value(array(\'0\', \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\'))');

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function remove() {
      KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->keys(), 'Site');
    }

    public function keys() {
      return array('SERVICE_OUTPUT_COMPRESSION_GZIP_LEVEL');
    }
  }
?>
