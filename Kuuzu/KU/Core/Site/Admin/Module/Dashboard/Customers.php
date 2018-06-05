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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Dashboard;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.2
 */

  class Customers extends \Kuuzu\KU\Core\Site\Admin\IndexModulesAbstract {
    public function __construct() {
      Registry::get('Language')->loadIniFile('modules/Dashboard/Customers.php');

      $this->_title = KUUZU::getDef('admin_indexmodules_customers_title');
      $this->_title_link = KUUZU::getLink(null, 'Customers');

      if ( Access::hasAccess(KUUZU::getSite(), 'Customers') ) {
        $this->_data = '<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable">' .
                       '  <thead>' .
                       '    <tr>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_customers_table_heading_customers') . '</th>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_customers_table_heading_date') . '</th>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_customers_table_heading_status') . '</th>' .
                       '    </tr>' .
                       '  </thead>' .
                       '  <tbody>';

        $Qcustomers = Registry::get('PDO')->query('select customers_id, customers_gender, customers_lastname, customers_firstname, customers_status, date_account_created from :table_customers order by date_account_created desc limit 6');
        $Qcustomers->execute();

        $counter = 0;

        while ( $Qcustomers->fetch() ) {
          $customer_icon = HTML::icon('people.png');

          if ( ACCOUNT_GENDER > -1 ) {
            switch ( $Qcustomers->value('customers_gender') ) {
              case 'm':
                $customer_icon = HTML::icon('user_male.png');

                break;

              case 'f':
                $customer_icon = HTML::icon('user_female.png');

                break;
            }
          }

          $this->_data .= '    <tr onmouseover="$(this).addClass(\'mouseOver\');" onmouseout="$(this).removeClass(\'mouseOver\');"' . ($counter % 2 ? ' class="alt"' : '') . '>' .
                          '      <td>' . HTML::link(KUUZU::getLink(null, 'Customers', 'Save&id=' . $Qcustomers->valueInt('customers_id')), $customer_icon . '&nbsp;' . $Qcustomers->valueProtected('customers_firstname') . ' ' . $Qcustomers->valueProtected('customers_lastname')) . '</td>' .
                          '      <td>' . $Qcustomers->value('date_account_created') . '</td>' .
                          '      <td align="center">' . HTML::icon(($Qcustomers->valueInt('customers_status') === 1) ? 'checkbox_ticked.gif' : 'checkbox_crossed.gif', null, null) . '</td>' .
                          '    </tr>';

          $counter++;
        }

        $this->_data .= '  </tbody>' .
                        '</table>';
      }
    }
  }
?>
