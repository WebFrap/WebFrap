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
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class ControllerHttp
  extends Controller
{
  
  /**
   * @var array
   */
  protected $inject = array
  (
    'hello' => array( 'db', 'cache' )
  );
  
  /**
   * @var array
   */
  protected $validMethodes = array
  (
    'hello' => array( Request::GET, Request::POST )
  );


} // end class ControllerHttp
