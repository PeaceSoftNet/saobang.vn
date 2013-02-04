<?php

/**
 * LikeBox class file.
 *
 * @author Evan Johnson <thaddeusmt - AT - gmail - DOT - com>
 * @author Ianaré Sévi (original author) www.digitick.net
 * @link https://github.com/splashlab/yii-facebook-opengraph
 * @copyright &copy; Digitick <www.digitick.net> 2011
 * @copyright Copyright &copy; 2012 SplashLab Social  http://splashlabsocial.com
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License v3.0
 *
 */
//require_once "php-sdk-3.1.1/base_facebook.php";
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'php-sdk-3.1.1' . DIRECTORY_SEPARATOR . 'BaseFacebook.php');

/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class SBaseFacebook extends BaseFacebook {

    /**
     * Identical to the parent constructor, except that
     * we start a PHP session to store the user ID and
     * access token if during the course of execution
     * we discover them.
     *
     * @param Array $config the application configuration.
     * @see BaseFacebook::__construct in facebook.php
     */
    /* public function __construct($config) {
      if (!session_id()) { // Yii should already have started the session
      session_start();
      }
      parent::__construct($config);
      } */

    protected static $kSupportedKeys =
            array('state', 'code', 'access_token', 'user_id');

    /**
     * Provides the implementations of the inherited abstract
     * methods.  The implementation uses PHP sessions to maintain
     * a store for authorization codes, user ids, CSRF states, and
     * access tokens.
     */
    protected function setPersistentData($key, $value) {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to setPersistentData.');
            return;
        }

        $session_var_name = $this->constructSessionVariableName($key);
        Yii::app()->session[$session_var_name] = $value;
    }

    protected function getPersistentData($key, $default = false) {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to getPersistentData.');
            return $default;
        }

        $session_var_name = $this->constructSessionVariableName($key);
        return isset(Yii::app()->session[$session_var_name]) ?
                Yii::app()->session[$session_var_name] : $default;
    }

    protected function clearPersistentData($key) {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to clearPersistentData.');
            return;
        }

        $session_var_name = $this->constructSessionVariableName($key);
        unset(Yii::app()->session[$session_var_name]);
    }

    protected function clearAllPersistentData() {
        foreach (self::$kSupportedKeys as $key) {
            $this->clearPersistentData($key);
        }
    }

    protected function constructSessionVariableName($key) {
        return implode('_', array('fb',
                    $this->getAppId(),
                    $key));
    }

    /**
     * Prints to the error log if you aren't in command line mode.
     * Overidden to use the Yii log instead of the default server log.
     *
     * @param string $msg Log message
     */
    protected static function errorLog($msg) {
        // disable error log if we are running in a CLI environment
        // @codeCoverageIgnoreStart
        if (php_sapi_name() != 'cli') {
            //error_log($msg);
            Yii::log($msg, CLogger::LEVEL_ERROR, 'ext.SBaseFacebook');
        }
        // uncomment this if you want to see the errors on the page
        // print 'error_log: '.$msg."\n";
        // @codeCoverageIgnoreEnd
    }

}
