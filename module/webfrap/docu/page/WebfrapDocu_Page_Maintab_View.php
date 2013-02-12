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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapDocu_Page_Maintab_View
  extends WgtMaintab
{

  /**
   * @var WebfrapDocu_Page_Model
   */
  public $model = null;

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param string $key
   * @param TFlag $params
   * @return void
   */
  public function displayPage( $key,  $params )
  {


    $this->setLabel( 'Docu' );
    $this->setTitle( 'Docu' );


    $pageData = $this->model->getInfoPage( $key );

    if( !$pageData )
    {
      $this->setTemplate( 'webfrap/docu/page/maintab/missing', true );
    }
    else
    {
      $this->addVar( 'pageData', $pageData );
      $this->setTemplate( 'webfrap/docu/page/maintab/as_'.$pageData->template, true );
    }

    $params = new TArray();
    $this->addMenu( $key, $params );

  }//end public function displayPage */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $key, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'WebfrapDocu_Page'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $key, $params );

    $menu->injectActions( $this, $params );

  }//end public function addMenu */

}//end class WebfrapDocu_Menu_Maintab_View

