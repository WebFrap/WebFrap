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
class WebfrapInfo_Maintab
  extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayLegend( $params )
  {

    $this->setLabel( 'Legend' );
    $this->setTitle( 'Legend' );

    $this->setTemplate( 'info/legend'  );

    $this->addMenuMenu( $params );
    $this->addActions( $params );

  }//end public function displayLegend */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenuMenu( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'WebfrapInfo'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl( $this->getAcl() );
    

    $menu->buildMenu( $params );

  }//end public function addMenuMenu */


  /**
   * just add the code for the edit ui controlls
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions(  $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class WebfrapNavigation_Maintab

