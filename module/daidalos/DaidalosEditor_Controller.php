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
 * @subpackage Core
 */
class DaidalosEditor_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var unknown_type
   */
  protected $callAble = array
  (
    'test',
  );

/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function test( )
  {

    if ($this->view->isType( View::WINDOW ) ) {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
      $view->setTitle('Daidalos Module');
    } else {
      $view = $this->view;
    }

    $view->setTemplate( 'daidalos/editor' );

  }//end public function menu */

}//end class DaidalosEditor_Controller

