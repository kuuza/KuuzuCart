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

  namespace Kuuzu\KU\Core\Site\Setup;

  use Kuuzu\KU\Core\KUUZU;

  class Template extends \Kuuzu\KU\Core\Template {
    public function __construct() {
      $this->set('default');
    }

    public static function getTemplates() {
      return array(array('id' => 0,
                         'code' => 'default'));
    }

    public function set($code = null) {
      if ( !isset($_SESSION[KUUZU::getSite()]['template']) ) {
        $data = array();

        foreach ( $this->getTemplates() as $template ) {
          $data = array('id' => $template['id'],
                        'code' => $template['code']);
        }

        $_SESSION[KUUZU::getSite()]['template'] = $data;
      }

      $this->_template_id = $_SESSION[KUUZU::getSite()]['template']['id'];
      $this->_template = $_SESSION[KUUZU::getSite()]['template']['code'];
    }
  }
?>
