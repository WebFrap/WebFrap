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
class WgtMaintabCloser
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $id       = null ;

/*//////////////////////////////////////////////////////////////////////////////
// magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __get($key )
  {
    return null;
  }

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __set($key , $value )
  {

  }

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __call($name , $args )
  {

  }//end public function __call */

  /**
   * Enter description here...
   *
   * @param unknown_type $id
   */
  public function __construct($id = null )
  {
    if ($id) {
      $this->id = $id;
    }

  }//end public function __construct */

  /**
   * the buildr method
   * @return string
   */
  public function build( )
  {
    return '<tab id="'.$this->id.'" close="true" ></tab>'.NL;

  }//end public function build( )

}//end class WgtMaintabCloser

