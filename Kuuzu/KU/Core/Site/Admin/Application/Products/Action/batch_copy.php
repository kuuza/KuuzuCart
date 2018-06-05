<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  class Kuu_Application_Products_Actions_batch_copy extends Kuu_Application_Products {
    public function __construct() {
      global $Kuu_Language, $Kuu_MessageStack;

      parent::__construct();

      if ( isset($_POST['batch']) && is_array($_POST['batch']) && !empty($_POST['batch']) ) {
        $this->_page_contents = 'batch_copy.php';

        if ( isset($_POST['subaction']) && ($_POST['subaction'] == 'confirm') ) {
          $error = false;

          foreach ( $_POST['batch'] as $id ) {
            if ( !Kuu_Products_Admin::copy($id, $_POST['new_category_id'], $_POST['copy_as']) ) {
              $error = true;
              break;
            }
          }

          if ( $error === false ) {
            $Kuu_MessageStack->add($this->_module, $Kuu_Language->get('ms_success_action_performed'), 'success');
          } else {
            $Kuu_MessageStack->add($this->_module, $Kuu_Language->get('ms_error_action_not_performed'), 'error');
          }

          kuu_redirect_admin(kuu_href_link_admin(FILENAME_DEFAULT, $this->_module . '&cID=' . $_GET['cID']));
        }
      }
    }
  }
?>
