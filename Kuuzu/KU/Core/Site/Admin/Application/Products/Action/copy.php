<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  class Kuu_Application_Products_Actions_copy extends Kuu_Application_Products {
    public function __construct() {
      global $Kuu_Language, $Kuu_MessageStack;

      parent::__construct();

      $this->_page_contents = 'copy.php';

      if ( isset($_POST['subaction']) && ($_POST['subaction'] == 'confirm') ) {
        if ( Kuu_Products_Admin::copy($_GET[$this->_module], $_POST['new_category_id'], $_POST['copy_as']) ) {
          $Kuu_MessageStack->add($this->_module, $Kuu_Language->get('ms_success_action_performed'), 'success');
        } else {
          $Kuu_MessageStack->add($this->_module, $Kuu_Language->get('ms_error_action_not_performed'), 'error');
        }

        kuu_redirect_admin(kuu_href_link_admin(FILENAME_DEFAULT, $this->_module . '&cID=' . $_GET['cID']));
      }
    }
  }
?>
