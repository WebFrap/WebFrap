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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosTheme_Subwindow
  extends WgtWindowTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $request
   * @param string $params
   * @return void
   */
  public function display( $request, $params )
  {

    $this->setStatus('Themes');
    $this->setTitle('Themes');

    $this->setTemplate( 'daidalos/themes/form' );


    /*
    $params = new TArray();
    $this->addMenuMenu( $params );
    */

  }//end public function display */

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
      'DaidalosBase'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->build( $params );

  }//end public function addMenuMenu */

}//end class DaidalosBase_Subwindow

