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

  namespace Kuuzu\KU\Core;

  use Kuuzu\KU\Core\Events;
  use Kuuzu\KU\Core\KUUZU;

/**
 * The Session class manages the session data and custom storage handlers
 *
 * @since v3.0.0
 */

  abstract class SessionAbstract {

/**
 * Holds the session cookie parameters (lifetime, path, domain, secure, httponly)
 *
 * @var array
 * @since v3.0.0
 */

    protected $_cookie_parameters = array();

/**
 * Holds the name of the session
 *
 * @var string
 * @since v3.0.0
 */

    protected $_name;

/**
 * Holds the session id
 *
 * @var string
 * @since v3.0.0
 */

    protected $_id;

/**
 * Holds the life time in seconds of the session
 *
 * @var int
 * @since v3.0.0
 */

    protected $_life_time;

/**
 * Checks if a session exists
 *
 * @param string $session_id The ID of the session
 */

    abstract public function exists(string $session_id);

/**
 * Verify an existing session ID and create or resume the session if the existing session ID is valid
 *
 * @return boolean
 * @since v3.0.0
 */

    public function start() {
// this is performed manually
      if ( (bool)ini_get('session.use_strict_mode') ) {
        ini_set('session.use_strict_mode', 0);
      }

      session_set_cookie_params(0, ((KUUZU::getRequestType() == 'NONSSL') ? KUUZU::getConfig('http_cookie_path') : KUUZU::getConfig('https_cookie_path')), ((KUUZU::getRequestType() == 'NONSSL') ? KUUZU::getConfig('http_cookie_domain') : KUUZU::getConfig('https_cookie_domain')), (bool)ini_get('session.cookie_secure'), (bool)ini_get('session.cookie_httponly'));

      if ( isset($_GET[$this->_name]) && ((bool)ini_get('session.use_only_cookies') || !(bool)preg_match('/^[a-zA-Z0-9,-]+$/', $_GET[$this->_name]) || !$this->exists($_GET[$this->_name])) ) {
        unset($_GET[$this->_name]);
      }

      if ( isset($_POST[$this->_name]) && ((bool)ini_get('session.use_only_cookies') || !(bool)preg_match('/^[a-zA-Z0-9,-]+$/', $_POST[$this->_name]) || !$this->exists($_POST[$this->_name])) ) {
        unset($_POST[$this->_name]);
      }

      if ( isset($_COOKIE[$this->_name]) && (!(bool)preg_match('/^[a-zA-Z0-9,-]+$/', $_COOKIE[$this->_name]) || !$this->exists($_COOKIE[$this->_name])) ) {
        setcookie($this->_name, '', time()-42000, $this->getCookieParameters('path'), $this->getCookieParameters('domain'), $this->getCookieParameters('secure'), $this->getCookieParameters('httponly'));
        unset($_COOKIE[$this->_name]);
      }

      if ( session_start() ) {
        $this->_id = session_id();

        Events::fire('session_started', [
            'id' => $this->_id
        ]);

        return true;
      }

      return false;
    }

/**
 * Checks if the session has been started or not
 *
 * @return boolean
 * @since v3.0.0
 */

    public function hasStarted() {
      return session_status() === PHP_SESSION_ACTIVE;
    }

/**
 * Deletes an existing session
 *
 * @since v3.0.3
 */

    public function kill() {
      $result = true;

      if ( isset($_COOKIE[$this->_name]) ) {
        setcookie($this->_name, '', time()-42000, $this->getCookieParameters('path'), $this->getCookieParameters('domain'), $this->getCookieParameters('secure'), $this->getCookieParameters('httponly'));
        unset($_COOKIE[$this->_name]);
      }

      if ($this->hasStarted()) {
        $_SESSION = [];

        $result = session_destroy();
      }

      return $result;
    }

/**
 * Delete an existing session and move the session data to a new session with a new session ID
 *
 * @since v3.0.0
 */

    public function recreate() {
      $delete_flag = true;

      if (!$this->exists($this->_id)) {
        $delete_flag = false;
      }

      return session_regenerate_id($delete_flag);
    }

/**
 * Return the session ID
 *
 * @return string
 * @since v3.0.0
 */

    public function getID() {
      return $this->_id;
    }

/**
 * Return the name of the session
 *
 * @return string
 * @since v3.0.0
 */

    public function getName() {
      return $this->_name;
    }

/**
 * Sets the name of the session
 *
 * @param string $name The name of the session
 * @since v3.0.0
 */

    public function setName($name) {
      session_name($name);
      $this->_name = session_name();
    }

/**
 * Sets the life time of the session (in seconds)
 *
 * @param int $time The life time of the session (in seconds)
 * @since v3.0.0
 */

    public function setLifeTime($time) {
      ini_set('session.gc_maxlifetime', $time);
      $this->_life_time = $time;
    }

/**
 * Returns the cookie parameters for the session (lifetime, path, domain, secure, httponly)
 *
 * @param string $key If specified, return only the value of this cookie parameter setting
 * @since v3.0.0
 */

    public function getCookieParameters($key = null) {
      if ( empty($this->_cookie_parameters) ) {
        $this->_cookie_parameters = session_get_cookie_params();
      }

      if ( !empty($key) ) {
        return $this->_cookie_parameters[$key];
      }

      return $this->_cookie_parameters;
    }
  }
?>
