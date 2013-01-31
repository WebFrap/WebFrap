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
 * Ausgeführte Aktionen protokollieren
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibProtocol_SystemError
{

  /**
   * Das Default objekt
   * @var LibProtocol_SystemError
   */
  private static $default = null;

  /**
   * @var LibDbOrm
   */
  private $orm = null;


  /**
   * Laden des Default objektes
   * @param LibDbOrm $orm
   */
  public static function getDefault( $orm = null )
  {

    if( !self::$default )
      self::$default = new LibProtocol_SystemError( $orm ?: Webfrap::$env->getOrm() );

    return self::$default;

  }//end public static function getDefault */

  /** Default constructor
   *  the conf and open a file
   *
   */
  public function __construct( $orm )
  {

    $this->orm = $orm;

  } // end public function __construct */

  /**
   * @param string $message
   * @param LibRequest $request
   * @param string $area
   * @param Entity $entity
   */
  public function write( $message, $trace, $request, $mask = null, $entity = null )
  {

    $vid      = null;
    $idEntity = null;
 
    $msgHash = md5($message.$trace);
    $errNode = $this->orm->getId( 'WbfsysProtocolError', "message_hash='{$msgHash}'"  );

    if( $errNode )
    {
      $this->orm->db->update( 'UPDATE wbfsys_protocol_error set counter = counter + 1 where rowid =  '.$errNode );
    }
    else
    {
      $this->orm->insert(
        'WbfsysProtocolError',
        array(
          'message'       => $message,
          'trace'         => $trace,
          'message_hash'  => $msgHash,
          'counter'       => 1,
          'request'       => $request->dumpAsJson(),
          'vid'           => $vid,
          'id_vid_entity' => $idEntity,
          'id_mask'	      => $mask
        )
      );
    }

  } // end public function __destruct */


} // end LibProtocol_SystemError

