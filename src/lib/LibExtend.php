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
 * @require php >= 5.3.0
 */
class LibExtend
{

  protected $dynMethods = array();

  /**
   *
   * @param unknown_type $param
   * @param unknown_type $arguments
   * @return unknown_type
   */
  public function __call( $param, $arguments = array() )
  {

  }//end public function __call

} // end class LibExtend
