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
 * Basisklasse für Error hanlder Controller
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class ControllerErrorBase
  extends Controller
{

/*//////////////////////////////////////////////////////////////////////////////
// Der Controller
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $action
   */
  public function run( $action = null )
  {

    $this->showErrorPage();

  }//end public function run


/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function showErrorPage( )
  {

    $this->view->setTemplate( 'ModError' , 'errors' );

  } // end public function errorPage


} // end class MexCoreBase

