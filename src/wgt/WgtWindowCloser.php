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
 * class WgtItemAbstract
 * Abstraktes View Objekt als Vorlage für alle ViewObjekte
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtWindowCloser
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  public $id       = null ;

////////////////////////////////////////////////////////////////////////////////
// magic
////////////////////////////////////////////////////////////////////////////////

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __get( $key )
  {
    return null;
  }

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __set( $key , $value )
  {

  }

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __call( $name , $args )
  {

  }

  /**
   * Enter description here...
   *
   * @param unknown_type $id
   */
  public function __construct( $id = null )
  {
    if($id)
    {
       $this->id = $id;
    }

  }

  /**
   * the buildr method
   * @return string
   */
  public function build( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

    return '<window id="wgt_window_'.$this->id.'" close="true" ></window>'.NL;

  }//end public function build( )

}//end class WgtWindowCloser

