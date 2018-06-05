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
  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\ErrorHandler;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class ErrorLog extends \Kuuzu\KU\Core\Site\Admin\IndexModulesAbstract {
    public function __construct() {
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Template = Registry::get('Template');

      $KUUZU_Language->loadIniFile('modules/Dashboard/ErrorLog.php');

      $this->_title = KUUZU::getDef('admin_dashboard_module_errorlog_title');
      $this->_title_link = KUUZU::getLink(null, 'ErrorLog');

      if ( Access::hasAccess(KUUZU::getSite(), 'ErrorLog') ) {
        $this->_data = '<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable">' .
                       '  <thead>' .
                       '    <tr>' .
                       '      <th>' . KUUZU::getDef('admin_dashboard_module_errorlog_table_heading_date') . '</th>' .
                       '      <th>' . KUUZU::getDef('admin_dashboard_module_errorlog_table_heading_message') . '</th>' .
                       '    </tr>' .
                       '  </thead>' .
                       '  <tbody>';

        if ( ErrorHandler::getTotalEntries() > 0 ) {
          $counter = 0;

          foreach ( ErrorHandler::getAll(6) as $row ) {
            $this->_data .= '    <tr onmouseover="$(this).addClass(\'mouseOver\');" onmouseout="$(this).removeClass(\'mouseOver\');"' . ($counter % 2 ? ' class="alt"' : '') . '>' .
                            '      <td style="white-space: nowrap;">' . $KUUZU_Template->getIcon(16, 'errorlog.png') . '&nbsp;' . DateTime::getShort(DateTime::fromUnixTimestamp($row['timestamp']), true) . '</td>' .
                            '      <td>' . HTML::outputProtected(substr($row['message'], 0, 60)) . '..</td>' .
                            '    </tr>';

            $counter++;
          }
        } elseif ( !is_writable(KUUZU::BASE_DIRECTORY . 'Work/Database/') ) {
          $this->_data .= '    <tr onmouseover="$(this).addClass(\'mouseOver\');" onmouseout="$(this).removeClass(\'mouseOver\');">' .
                          '      <td colspan="2">' . HTML::icon('cross.png') . '&nbsp;' . sprintf(KUUZU::getDef('admin_dashboard_module_errorlog_not_writable'), KUUZU::BASE_DIRECTORY . 'Work/Database/') . '</td>' .
                          '    </tr>';
        } else {
          $this->_data .= '    <tr onmouseover="$(this).addClass(\'mouseOver\');" onmouseout="$(this).removeClass(\'mouseOver\');">' .
                          '      <td colspan="2">' . HTML::icon('tick.png') . '&nbsp;' . KUUZU::getDef('admin_dashboard_module_errorlog_no_errors_found') . '</td>' .
                          '    </tr>';
        }

        $this->_data .= '  </tbody>' .
                        '</table>';
      }
    }
  }
?>
