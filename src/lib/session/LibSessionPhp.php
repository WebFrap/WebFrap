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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSessionPhp
{
/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   * @var boolean
   */
  public $wakeup = false;

  /**
   * Enter description here...
   *
   * @param string $key
   * @param mixed $value
   */
  public function __set( $key , $value )
  {
    $_SESSION[$key] = $value;
  }// end of public function __set( $key , $value )

  /**
   * Enter description here...
   *
   * @param string $key
   * @return mixed
   */
  public function __get( $key )
  {
    return isset($_SESSION[$key])?$_SESSION[$key]:null;
  }// end of public function __get( $key )

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $offset
   * @param $value
   * @return unknown_type
   */
  public function offsetSet($offset, $value)
  {
    $_SESSION[$offset] = $value;
  }//end public function offsetSet($offset, $value)

  /**
   *
   * @param $offset
   * @return unknown_type
   */
  public function offsetGet($offset)
  {
    return $_SESSION[$offset];
  }//end public function offsetGet($offset)

  /**
   *
   * @param $offset
   * @return unknown_type
   */
  public function offsetUnset($offset)
  {
    unset($_SESSION[$offset]);
  }//end public function offsetUnset($offset)

  /**
   *
   * @param $offset
   * @return unknown_type
   */
  public function offsetExists($offset)
  {
    return isset($_SESSION[$offset])?true:false;
  }//end public function offsetExists($offset)

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $name
   * @param string $sessionId
   * @param string $sessionSavePath
   * @return void
   */
  public function start( $name , $sessionId = null , $sessionSavePath = null )
  {

    ///TODO fehlermeldung wenn die session schon läuft
    if( '' != session_id() )
      return;

    session_name($name);

    if( !is_null($sessionId) )
    {
      session_id($sessionId);
    }

    if( !is_null($sessionSavePath) )
    {
      session_save_path($sessionSavePath);
    }
    else
    {
      if( !file_exists(PATH_GW.'tmp/session/') )
        SFilesystem::touchFolder(PATH_GW.'tmp/session/');
      
      session_save_path(PATH_GW.'tmp/session/');
    }

    session_start();

  }//end public function start */

  /**
   * Enter description here...
   * @return void
   */
  public function close()
  {
    session_write_close();
  }//end public function close()

  /**
   * Enter description here...
   * @return void
   */
  public function destroy()
  {
    session_destroy();
  }//end public function destroy()

/*//////////////////////////////////////////////////////////////////////////////
// Static Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string / array $key
   * @param string[optional] $value
   * @return void
   */
  public function setStatus( $key , $value = null )
  {
    if( is_array( $key ) )
      $_SESSION['WBF_STATUS'] = array_merge( $_SESSION['WBF_STATUS'] , $key );

    else
      $_SESSION['WBF_STATUS'][$key] = $value;

  }//end public function setStatus( $key , $value = null )

  /**
   * Enter description here...
   *
   * @param string $key
   * @param string[optional] $value
   * @return void
   */
  public function getStatus( $key = null )
  {
    if( !$key && isset($_SESSION['WBF_STATUS']) )
      return $_SESSION['WBF_STATUS'];

    elseif( isset($_SESSION['WBF_STATUS'][$key]) )
      return $_SESSION['WBF_STATUS'][$key];

    else
      return null;

  }//end public function getStatus( $key )

  /**
   * Enter description here...
   *
   * @param string $key
   * @param string[optional] $value
   * @return void
   */
  public function add( $key , $value = null )
  {
    if( is_array( $key ) )
      $_SESSION = array_merge( $_SESSION , $key );

    else
      $_SESSION[$key] = $value;

  }//end public function add

  /**
   * Enter description here...
   *
   * @param string $key
   * @param string[optional] $value
   * @return void
   */
  public function append( $key , $value = null )
  {
    $_SESSION[$key][] = $value;
  }//end public function append( $key , $value = null )

  /**
   * Enter description here...
   *
   * @param string $key
   * @param string $value[optional]
   * @return mixed
   */
  public function get( $key )
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null ;
  }//end public function get

  /**
   * Enter description here...
   *
   * @param string $key
   * @return boolean
   */
  public function exists( $key )
  {
    return isset($_SESSION[$key]) ? true:false;
  }//end public function exists

  /**
   * Enter description here...
   *
   * @param string $key
   * @return void
   */
  public function delete( $key )
  {
    if( isset($_SESSION[$key])) unset($_SESSION[$key]);
  }//end public function delete


}//end class SessionPhp


