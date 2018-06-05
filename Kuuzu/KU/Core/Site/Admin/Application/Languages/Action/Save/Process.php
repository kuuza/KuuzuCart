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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\Action\Save;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = array('id' => $_GET['id'],
                    'name' => $_POST['name'],
                    'code' => $_POST['code'],
                    'locale' => $_POST['locale'],
                    'charset' => $_POST['charset'],
                    'date_format_short' => $_POST['date_format_short'],
                    'date_format_long' => $_POST['date_format_long'],
                    'time_format' => $_POST['time_format'],
                    'text_direction' => $_POST['text_direction'],
                    'currencies_id' => $_POST['currencies_id'],
                    'numeric_separator_decimal' => $_POST['numeric_separator_decimal'],
                    'numeric_separator_thousands' => $_POST['numeric_separator_thousands'],
                    'parent_id' => $_POST['parent_id'],
                    'sort_order' => $_POST['sort_order'],
                    'set_default' => (isset($_POST['default']) && ($_POST['default'] == 'on')));

      if ( Languages::update($data) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
