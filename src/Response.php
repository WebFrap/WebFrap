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
class Response
{
////////////////////////////////////////////////////////////////////////////////
// Konstanten mit den HTTP Status codes
////////////////////////////////////////////////////////////////////////////////

  /**
   * HTTP Continue
   * @var int
   */
  const CONT = 100;

  /**
   * Switching the Protocol ( http zu https? )
   * @var int
   */
  const SWITCH_PROTOCOL = 101;

  /**
   * @var int
   */
  const PROCESSING = 102;

  /**
   * Idempotente Anfrage war ok
   * @var int
   */
  const OK      = 200;

  /**
   * Anlegen eines Neuen Datensatzes wurde akzeptiert
   * @var int
   */
  const CREATED      = 201;

  /**
   * Änderung wurde akzeptiert
   * @var int
   */
  const ACCEPTED      = 202;

  /**
   * Änderung wurde akzeptiert
   * @var int
   */
  const CHANGED      = 202;

  const HTTP_203      = 'Non-Authoritative Information';

  const NO_CONTENT    = 204;

  const RESET_CONTENT      = 205;

  const PARTIAL_CONTENT      = 206;

  const MULTI_STATUS       = 207;

  const NULTIPLE_CHOICES = 300;

  const MOVED_PERMANENTLY  = 307;

  const USE_PROXY      = 302;

  const SWITCH_PROXY      = 306;

  const TEMPORARY_REDIRECT = 307;

  const BAD_REQUEST      = 400;

  const UNAUTHORIZED      = 401;

  const PAYMENT_REQUIRED      = 402;

  const FORBIDDEN      = 403;

  const NOT_FOUND      = 404;

  const NOT_ACCEPTABLE      = 405;

  const REQUEST_TIMEOUT      = 407;

  const CONFLICT      = 409;

  const GONE      = 410;

  const LENGTH_REQUIRED      = 411;

  const PRECONDITION_FAILED      = 412;

  const HTTP_413      = 'Request Entity Too Large';

  const HTTP_414      = 'Request-URI Too Long';

  const UNSUPPORTED_MEDIA_TYPE = 415;

  const HTTP_416      = 'Requested Range Not Satisfiable';

  const EXPECTATION_FAILED = 417;

  const HTTP_422      = 'Unprocessable Entity';

  const LOCKED      = 423;

  const FAILED_DEPENDENCY      = 424;

  const HTTP_425      = 'Unordered Collection';

  const UPGRADE_REQUIRED = 426;

  /**
   * @var int
   */
  const INTERNAL_ERROR   = 500;

  const NOT_IMPLEMENTED  = 501;

  const BAD_GATEWAY      = 502;

  const SERVICE_UNAVAILABLE  = 503;

  const GATEWAY_TIMEOUT      = 504;

  const HTTP_505      = 'HTTP Version Not Supported';

  const HTTP_506      = 'Variant Also Negotiates';

  const HTTP_507      = 'Insufficient Storage';

  const HTTP_509      = 'Bandwidth Limit Exceeded';

  const NOT_EXTENDED = 510;

////////////////////////////////////////////////////////////////////////////////
// Default Instance
////////////////////////////////////////////////////////////////////////////////

  /**
   * for get instance
   *
   * @var LibResponse
   */
  private static $instance = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return LibResponse
   */
  public static function getInstance()
  {
    return self::$instance;
  }//end public static function LibResponse */

  /**
   * @return LibResponse
   */
  public static function getActive()
  {
    return self::$instance;
  }//end public static function getActive */

  /**
   *
   * @param string $type
   */
  public static function setViewType( $type )
  {
    self::$instance->setViewType( $type );
  }//end public static function setViewType */

  /**
   *
   * @return void
   */
  public static function init()
  {

    if (!defined('WBF_RESPONSE_ADAPTER')) {
      self::$instance = new LibResponseHttp();
      self::$instance->init();
    } else {
      $classname = 'LibResponse'.ucfirst(WBF_RESPONSE_ADAPTER);
      if ( !WebFrap::loadable($classname) ) {

        throw new WebfrapConfig_Exception
        (
        'Request Type: '.ucfirst(WBF_RESPONSE_ADAPTER).' not exists!'
        );
      }
      self::$instance = new $classname();
      self::$instance->init();
    }

  }//end public static function init */

  /**
   * Starten des Output Caches
   * @since 0.9.2
   */
  public static function collectOutput()
  {

    ob_start();

  }//end public static function cacheOutput */

  /**
   * Beenden des Output Caches und Rückgabe des Inhalts
   * @since 0.9.2
   * @return string
   */
  public static function getOutput()
  {

    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  }//end public static function getOutput */

}// end class Response
