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
class ImportExample_Csv_Subwindow_View
  extends WgtWindowTemplate
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

    /**
    * @var ImportExample_Csv_Model
    */
    public $model = null;

////////////////////////////////////////////////////////////////////////////////
// method
////////////////////////////////////////////////////////////////////////////////

 /**
  * @param TFlag $params
  *
  * @return null|Error im Fehlerfall
  */
  public function displayStats( $params )
  {

    // set the window title
    $this->setTitle( 'Import CSV Example' );

    // set the window status text
    $this->setStatus( 'Import CSV Example' );

    // set the from template
    $this->setTemplate( 'import/example/stats_csv' );
    
    $this->addMenu( $params );
    $this->addActions( $params );

    return null;

  }//end public function displayStats */

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $params )
  {

    $menu = $this->newMenu
    (
      $this->id.'_dropmenu',
      'ImportExample_Csv'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params );

    return true;

  }//end public function addMenu */

  /**
   * just add the code for the edit ui controlls
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions( $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class ProcessBase_Subwindow_View

