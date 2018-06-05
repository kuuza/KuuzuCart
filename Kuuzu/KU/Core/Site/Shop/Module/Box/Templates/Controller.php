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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Templates;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Template;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Templates',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_templates_heading');
    }

    public function initialize() {
      $KUUZU_Session = Registry::get('Session');

      $data = array();

      foreach ( Template::getTemplates() as $template ) {
        $data[] = array('id' => $template['code'],
                        'text' => $template['title']);
      }

      if ( count($data) > 1 ) {
        $hidden_get_params = '';

        foreach ( $_GET as $key => $value ) {
          if ( ($key != 'template') && ($key != $KUUZU_Session->getName()) && ($key != 'x') && ($key != 'y') ) {
            $hidden_get_params .= HTML::hiddenField($key, $value);
          }
        }

        $this->_content = '<form name="templates" action="' . KUUZU::getLink(null, null, null, 'AUTO', false) . '" method="get">' .
                          $hidden_get_params . HTML::selectMenu('template', $data, $_SESSION['template']['code'], 'onchange="this.form.submit();" style="width: 100%"') . HTML::hiddenSessionIDField() .
                          '</form>';
      }
    }
  }
?>
