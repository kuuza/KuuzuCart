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

  namespace Kuuzu\KU\Core\Site\Shop;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.0
 */

  class NavigationHistory {

/**
 * @since v3.0.0
 */

    protected $_data = array();

/**
 * @since v3.0.0
 */

    protected $_snapshot = array();

/**
 * @since v3.0.0
 */

    public function __construct($add_current_page = false) {
      if ( isset($_SESSION[KUUZU::getSite()]['NavigationHistory']['data']) && is_array($_SESSION[KUUZU::getSite()]['NavigationHistory']['data']) && !empty($_SESSION[KUUZU::getSite()]['NavigationHistory']['data']) ) {
        $this->_data =& $_SESSION[KUUZU::getSite()]['NavigationHistory']['data'];
      }

      if ( isset($_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot']) && is_array($_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot']) && !empty($_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot']) ) {
        $this->_snapshot =& $_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot'];
      }

      if ( $add_current_page === true ) {
        $this->addCurrentPage();
      }
    }

/**
 * @since v3.0.0
 */

    public function addCurrentPage() {
      $action_counter = 0;
      $application_key = null;
      $action = array();

      foreach ( $_GET as $key => $value ) {
        if ( !isset($application_key) && ($key == KUUZU::getSiteApplication()) ) {
          $application_key = $action_counter;

          $action_counter++;

          continue;
        }

        $action[] = array($key => $value);

        if ( $this->siteApplicationActionExists(implode('\\', array_keys($action))) === false ) {
          array_pop($action);

          break;
        }

        $action_counter++;
      }

      $action_get = http_build_query($action);

      for ( $i=0, $n=sizeof($this->_data); $i<$n; $i++ ) {
        if ( ($this->_data[$i]['application'] == KUUZU::getSiteApplication()) && ($this->_data[$i]['action'] == $action_get) ) {
          array_splice($this->_data, $i);
          break;
        }
      }

      $this->_data[] = array('application' => KUUZU::getSiteApplication(),
                             'action' => $action_get,
                             'mode' => KUUZU::getRequestType(),
                             'get' => array_slice($_GET, $action_counter),
                             'post' => $_POST);

      if ( !isset($_SESSION[KUUZU::getSite()]['NavigationHistory']['data']) ) {
        $_SESSION[KUUZU::getSite()]['NavigationHistory']['data'] = $this->_data;
      }
    }

/**
 * @since v3.0.0
 */

    public function removeCurrentPage() {
      array_pop($this->_data);

      if ( empty($this->_data) ) {
        $this->resetPath();
      }
    }

/**
 * @since v3.0.0
 */

    public function hasPath($back = 1) {
      if ( (is_numeric($back) === false) || (is_numeric($back) && ($back < 1)) ) {
        $back = 1;
      }

      return isset($this->_data[count($this->_data) - $back]);
    }

/**
 * @since v3.0.0
 */

    public function getPathURL($back = 1, $exclude = array()) {
      if ( (is_numeric($back) === false) || (is_numeric($back) && ($back < 1)) ) {
        $back = 1;
      }

      $back = count($this->_data) - $back;

      return KUUZU::getLink(null, $this->_data[$back]['application'], $this->_data[$back]['action'] . '&' . $this->parseParameters($this->_data[$back]['get'], $exclude), $this->_data[$back]['mode']);
    }

/**
 * @since v3.0.0
 */

    public function setSnapshot($page = null) {
      if ( isset($page) && is_array($page) ) {
        $this->_snapshot = array('application' => $page['application'],
                                 'action' => $page['action'],
                                 'mode' => $page['mode'],
                                 'get' => $page['get'],
                                 'post' => $page['post']);
      } else {
        $this->_snapshot = $this->_data[count($this->_data) - 1];
      }

      if ( !isset($_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot']) ) {
        $_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot'] = $this->_snapshot;
      }
    }

/**
 * @since v3.0.0
 */

    public function hasSnapshot() {
      return !empty($this->_snapshot);
    }

/**
 * @since v3.0.0
 */

    public function getSnapshot($key) {
      if ( isset($this->_snapshot[$key]) ) {
        return $this->_snapshot[$key];
      }
    }

/**
 * @since v3.0.0
 */

    public function getSnapshotURL($auto_mode = false) {
      if ( $this->hasSnapshot() ) {
        $target = KUUZU::getLink(null, $this->_snapshot['application'], $this->_snapshot['action'] . '&' . $this->parseParameters($this->_snapshot['get']), ($auto_mode === true) ? 'AUTO' : $this->_snapshot['mode']);
      } else {
        $target = KUUZU::getLink(null, null, null, ($auto_mode === true) ? 'AUTO' : $this->_snapshot['mode']);
      }

      return $target;
    }

/**
 * @since v3.0.0
 */

    public function redirectToSnapshot() {
      $target = $this->getSnapshotURL(true);

      $this->resetSnapshot();

      KUUZU::redirect($target);
    }

/**
 * @since v3.0.0
 */

    public function resetPath() {
      $this->_data = array();

      if ( isset($_SESSION[KUUZU::getSite()]['NavigationHistory']['data']) ) {
        unset($_SESSION[KUUZU::getSite()]['NavigationHistory']['data']);
      }
    }

/**
 * @since v3.0.0
 */

    public function resetSnapshot() {
      $this->_snapshot = array();

      if ( isset($_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot']) ) {
        unset($_SESSION[KUUZU::getSite()]['NavigationHistory']['snapshot']);
      }
    }

/**
 * @since v3.0.0
 */

    public function reset() {
      $this->resetPath();
      $this->resetSnapshot();

      if ( isset($_SESSION[KUUZU::getSite()]['NavigationHistory']) ) {
        unset($_SESSION[KUUZU::getSite()]['NavigationHistory']);
      }
    }

/**
 * @since v3.0.1
 */

    protected function parseParameters($array, $additional_exclude = array()) {
      $exclude = array('x', 'y', Registry::get('Session')->getName());

      if ( is_array($additional_exclude) && !empty($additional_exclude) ) {
        $exclude = array_merge($exclude, $additional_exclude);
      }

      $string = '';

      if ( is_array($array) && !empty($array) ) {
        foreach ( $array as $key => $value ) {
          if ( !in_array($key, $exclude) ) {
            $string .= $key . '=' . $value . '&';
          }
        }

        $string = substr($string, 0, -1);
      }

      return $string;
    }

/**
 * @since v3.0.1
 */

    protected function siteApplicationActionExists($action) {
      return class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Application\\' . KUUZU::getSiteApplication() . '\\Action\\' . $action);
    }
  }
?>
