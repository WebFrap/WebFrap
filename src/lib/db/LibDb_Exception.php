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
 * class LibDb_Exception
 * the database exception, this exception always will be thrown on database errors
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDb_Exception
  extends Io_Exception
{

  public $sql = null;

  /**
   *
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct
  (
    $message,
    $debugMessage = 'Internal Error',
    $errorKey = Response::INTERNAL_ERROR,
    $sql = null,
    $numQuery = -1,
    $report = true
  )
  {


    if( DEBUG && $sql )
      Debug::console(  "QUERY {$numQuery} FAILED: ".$sql );

    $this->sql = $sql;

    if( is_object( $message ) )
    {

      if( DEBUG && 'Internal Error' != $debugMessage )
        parent::__construct( $debugMessage );
      else
        parent::__construct( 'Multiple Errors' );

      $this->error = $message;

      $this->debugMessage = $debugMessage;
      $this->errorKey     = $message->getId();

      Error::addException( $debugMessage, $this );
    }
    else
    {
      if( DEBUG && 'Internal Error' != $debugMessage && !is_numeric($debugMessage) )
        parent::__construct( $debugMessage );
      else
        parent::__construct( $message );

      $this->debugMessage = $debugMessage;
      $this->errorKey     = $errorKey;

      Error::addException( $message , $this );
    }


  }//end public function __construct */

  /**
   * @return string
   */
  public function getSql()
  {

    return $this->sql;

  }//end public function getSql */

}//end class LibDb_Exception


