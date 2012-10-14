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
 * @subpackage ModDeveloper
 */
class DeveloperArchCrud_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var unknown_type
   */
  protected $callAble = array
  (
    'formsingle','formmulti'
  );


////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function formSingle( )
  {

  } // end public function formSingle


  /**
   * @return void
   */
  public function formMulti( )
  {

    if( $this->view->isType( View::WINDOW ) )
    {
      $view = $this->view->newWindow('DeveloperArch', 'Default');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate('daidalos/arch/form_crud_multi');

  } // end public function formMulti


} // end class MexDeveloperStatus

