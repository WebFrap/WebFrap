<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Request
{
/*//////////////////////////////////////////////////////////////////////////////
// constant
//////////////////////////////////////////////////////////////////////////////*/

  const GET     = 'GET';
  const PUT     = 'PUT';
  const POST    = 'POST';
  const DELETE  = 'DELETE';

  const HEAD    = 'HEAD';
  const OPTIONNS = 'OPTIONS';
  const TRACE   = 'TRACE';
  const CONNECT = 'CONNECT';

  const MOD = 'mod';
  const CON = 'mex';
  const RUN = 'do';

/*//////////////////////////////////////////////////////////////////////////////
// Liste der HTTP Status Codes
// @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
// @see http://tools.ietf.org/html/rfc4918
// @see http://tools.ietf.org/html/rfc2774
//
// Beschreibungen teils aus Wikipedia übernommen.
// Danke an alle Authoren
// @see http://de.wikipedia.org/wiki/HTTP-Statuscode
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Anfrage wurde erfolgreich bearbeitet und das Ergebnis der Anfrage
   * wird in der Antwort übertragen.
   * @var int
   */
  const OK = 200;

  /**
   * Die Anfrage wurde erfolgreich bearbeitet. Die angeforderte Ressource wurde
   * vor dem Senden der Antwort erstellt. Das „Location“-Header-Feld enthält
   * eventuell die Adresse der erstellten Ressource.
   * @var int
   */
  const CREATED = 201;

  /**
   * Die Anfrage wurde erfolgreich bearbeitet. Die angeforderte Ressource wurde
   * vor dem Senden der Antwort erstellt. Das „Location“-Header-Feld enthält
   * eventuell die Adresse der erstellten Ressource.
   * @var int
   */
  const ACCEPTED = 202;

  /**
   * Die angeforderte Ressource steht ab sofort unter der im „Location“-Header-Feld
   * angegebenen Adresse bereit. Die alte Adresse ist nicht länger gültig.
   * @var int
   */
  const MULTIPLE_CHOICE = 300;

  /**
   * Die angeforderte Ressource steht in verschiedenen Arten zur Verfügung.
   * Die Antwort enthält eine Liste der verfügbaren Arten.
   * Das „Location“-Header-Feld enthält eventuell die Adresse der vom Server
   * bevorzugten Repräsentation.
   * @var int
   */
  const MOVED_PERMANENTLY = 301;

  /**
   * Der Inhalt der angeforderten Ressource hat sich seit der letzten Abfrage des
   * Clients nicht verändert und wird deshalb nicht übertragen.
   * @var int
   */
  const NOT_MODIFIED = 304;

  /**
   * en:
   * {
   *  The syntax of the request was not understood by the server.
   * }
   * @var int
   */
  const BAD_REQUEST = 400;

  /**
   * en:
   * {
   *   The request needs user authentication
   * }
   * @var int
   */
  const NOT_AUTHORIZED = 401;

  /**
   * en:
   * {
   *   The user has no permission to do what ever he tried to do
   * }
   * @var int
   */
  const FORBIDDEN = 403;

  /**
   * en:
   * {
   *   Requested resource not exists
   * }
   * @var int
   */
  const NOT_FOUND = 404;

  /**
   * en:
   * {
   *   The Request method is not allowed for this request
   * }
   * @var int
   */
  const METHOD_NOT_ALLOWED = 405;

  /**
   * Die angeforderte Ressource steht nicht in der gewünschten Form zur Verfügung.
   * Gültige „Content-Type“-Werte können in der Antwort übermittelt werden
   * @var int
   */
  const NOT_ACCEPTABLE = 406;

  /**
   * de:
   * {
   *   Prozess konnte nicht beendet werden, da ein konflikt aufgetreten ist
   *   Wird zb. bei Unique Exceptions verwendet, oder wenn es beim speichern
   *   zu race conditions gekommen ist.
   * }
   * @var int
   */
  const CONFLICT = 409;

  /**
   * Requested Range Not Satisfiable
   * @var int
   */
  const INVALID_RANGE = 416;

  /**
   * There are too many connections from your internet address
   * Verwendet, wenn die Verbindungshöchstzahl überschritten wird
   * @var int
   */
  const TO_MANY_CONNECTIONS = 421;

  /**
   * Die angeforderte Ressource ist zurzeit gesperrt
   * @var int
   */
  const LOCKED = 423;

  /**
   * Die Anfrage konnte nicht durchgeführt werden, weil sie das Gelingen
   * einer vorherigen Anfrage voraussetzt
   * @var int
   */
  const FAILED_DEPENDENCY = 424;

  /**
   * Der Client sollte auf Transport Layer Security (TLS/1.0) umschalten
   * @var int
   */
  const UPGRADE_REQUIRED = 426;

  /**
   * Denied for legal reasons
   * @var int
   */
  const CENSORSHIP_SUCKS = 451;

  /**
   * en:
   * {
   *   valid request but internal failure in by handling it
   * }
   * @var int
   */
  const INTERNAL_ERROR = 500;

  /**
   * en:
   * is used when some standard defines functionallity which is not yet
   * implemented
   *
   * de:
   * Was auch immer angefragt wurd ist leider nicht oder noch nicht implementiert
   *
   * @var int
   */
  const NOT_IMPLEMENTED = 501;

  /**
   * Die Anfrage konnte nicht bearbeitet werden, weil der Speicherplatz
   * des Servers dazu zurzeit nicht mehr ausreicht.
   *
   * @var int
   */
  const INSUFFICIENT_STORAGE = 507;

/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * for get instance
   *
   * @var LibRequestAbstract
   */
  private static $instance = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibRequestAbstract
   * @deprecated
   */
  public static function getInstance()
  {
    return self::$instance;
  }//end public static function getInstance */

  /**
   * @return LibRequestHttp
   */
  public static function getActive()
  {
    return self::$instance;
  }//end public static function getActive */

  /**
   *
   * @return void
   */
  public static function init()
  {

    if (!defined('WBF_REQUEST_ADAPTER')) {
      self::$instance = new LibRequestPhp();
      self::$instance->init();
    } else {
      $classname = 'LibRequest'.ucfirst(WBF_REQUEST_ADAPTER);
      if (!WebFrap::classExists($classname)) {

        throw new WebfrapConfig_Exception
        (
          'Request Type: '.ucfirst(WBF_REQUEST_ADAPTER).' not exists!'
        );
      }
      self::$instance = new $classname();
      self::$instance->init();
    }

  }//end public static function init */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param unknown_type $target
   * @param unknown_type $params
   * @param unknown_type $data
   * @param unknown_type $files
   */
  public static function newStackRequest(
    $method,
    $target,
    $params = array(),
    $data = array(),
    $files = array()
  )
  {
    return new LibRequestStack
    (
      self::$instance,
      $method,
      $target,
      $params,
      $data,
      $files
    );

  }//end public static function newStackNode */

/*//////////////////////////////////////////////////////////////////////////////
// getter Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public static function issetCookie($key  )
  {
    return self::$instance->issetCookie($key  );
  } // end public function issetCookie */

 /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public static function cookie($key = null , $validator = null , $message = null)
  {
    return self::$instance->cookie($key, $validator , $message);
  } // end public function cookie */

 /**
  * Request if a File Upload Exists
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public static function fileExists($key)
  {
    return self::$instance->fileExists($key);
  } // end public function fileExists */

 /**
  * Request if a File Upload Exists
  *
  * @param string Key Name des zu testenden Cookies
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public static function file($key = null , $typ = null , $message = null)
  {
    return self::$instance->file($key, $typ, $message);
  } // end public function file */

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public static function serverExists($key  )
  {
    return self::$instance->serverExists($key);
  } // end public function serverExists */

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public static function server($key = null , $validator = null, $message = null  )
  {
    return self::$instance->server($key, $validator, $message);
  } // end public function server */

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public static function envExists($key  )
  {
    return self::$instance->envExists($key);
  } // end public function envExists */

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string $key name of the requested env value
  * @param string $validator the validatorname
  * @return mixed
  */
  public static function env($key = null , $validator = null, $message = null)
  {
    return self::$instance->env($key, $validator, $message);
  } // end public function env */

  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return Validator
   *
   */
  public static function checkFormInput($values , $messages, $subkey = null , $rules = array() , $rulesMessages = array())
  {
    return self::$instance->checkFormInput($values , $messages, $subkey, $rules, $rulesMessages);
  }//end public function checkFormInput */

  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return Validator
   *
   */
  public static function checkSearchInput($values , $messages, $subkey = null , $rules = array() , $rulesMessages = array())
  {
    return self::$instance->checkSearchInput($values , $messages, $subkey, $rules, $rulesMessages);
  }//end public function checkFormInput */

  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return array
   *
   */
  public static function checkMultiFormInput($values , $messages, $subkey = null , $rules = array() , $rulesMessages = array())
  {
    return self::$instance->checkMultiFormInput($values , $messages, $subkey, $rules, $rulesMessages);
  }//end public function checkFormInput */

  /** method for validating form multilingual data
   * this mean empty datasets will not be given back
   *
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @param string $rules
   * @param array $rulesMessages
   * @return array
   *
   */
  public static function checkMultiInputLang($values , $messages, $subkey = null , $rules = array() , $rulesMessages = array())
  {
    return self::$instance->checkMultiInputLang($values , $messages, $subkey, $rules, $rulesMessages);
  }//end public function checkMultiInputLang */

  /**
   * @param string $key
   * @param string $subkey
   */
  public static function checkMultiIds($key , $subkey = null)
  {
    return self::$instance->checkMultiIds($key, $subkey);

  }//end public static function checkMultiIds */

  /**
   * get the request method
   *
   * @return string
   */
  public static function method($requested = null)
  {

    if (!$method = self::$instance->server('REQUEST_METHOD')) {
      Error::addError
      (
        'got no request method, asumig this was a get request'
      );

      $method = 'GET';
    }

    //this should always be uppper, but no risk here
    if (!$requested) {
      return strtoupper($method);
    } else {
      return strtoupper($requested) == strtoupper($method) ? true:false;
    }

  }//end public static function method */

}// end class Request

