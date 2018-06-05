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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Access;

  class Orders extends \Kuuzu\KU\Core\Site\Admin\IndexModulesAbstract {
    public function __construct() {
      Registry::get('Language')->loadIniFile('modules/Dashboard/Orders.php');

      $this->_title = KUUZU::getDef('admin_indexmodules_orders_title');
      $this->_title_link = KUUZU::getLink(null, 'Orders');

      if ( Access::hasAccess(KUUZU::getSite(), 'Orders') ) {
        $this->_data = '<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable">' .
                       '  <thead>' .
                       '    <tr>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_orders_table_heading_orders') . '</th>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_orders_table_heading_total') . '</th>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_orders_table_heading_date') . '</th>' .
                       '      <th>' . KUUZU::getDef('admin_indexmodules_orders_table_heading_status') . '</th>' .
                       '    </tr>' .
                       '  </thead>' .
                       '  <tbody>';

        $Qorders = Registry::get('PDO')->prepare('select o.orders_id, o.customers_name, greatest(o.date_purchased, ifnull(o.last_modified, "1970-01-01")) as date_last_modified, s.orders_status_name, ot.text as order_total from :table_orders o, :table_orders_total ot, :table_orders_status s where o.orders_id = ot.orders_id and ot.class = "total" and o.orders_status = s.orders_status_id and s.language_id = :language_id order by date_last_modified desc limit 6');
        $Qorders->bindInt(':language_id', Registry::get('Language')->getID());
        $Qorders->execute();

        $counter = 0;

        while ( $Qorders->fetch() ) {
          $this->_data .= '    <tr onmouseover="$(this).addClass(\'mouseOver\');" onmouseout="$(this).removeClass(\'mouseOver\');"' . ($counter % 2 ? ' class="alt"' : '') . '>' .
                          '      <td>' . kuu_link_object(KUUZU::getLink(null, 'Orders', 'oID=' . $Qorders->valueInt('orders_id') . '&action=save'), kuu_icon('orders.png') . '&nbsp;' . $Qorders->valueProtected('customers_name')) . '</td>' .
                          '      <td>' . strip_tags($Qorders->value('order_total')) . '</td>' .
                          '      <td>' . $Qorders->value('date_last_modified') . '</td>' .
                          '      <td>' . $Qorders->value('orders_status_name') . '</td>' .
                          '    </tr>';

          $counter++;
        }

        $this->_data .= '  </tbody>' .
                        '</table>';
      }
    }
  }
?>