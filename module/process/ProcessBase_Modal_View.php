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
class ProcessBase_Modal_View
  extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * @var ProcessBase_Model
  */
  public $model = null;
  
  /**
   * @var int
   */
  public $height = 550;
  
  /**
   * @var int
   */
  public $width = 850;

/*//////////////////////////////////////////////////////////////////////////////
// method
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  *
  * @param int $process
  * @param TFlag $params
  *
  * @return null|Error im Fehlerfall
  */
  public function displayHistory( $process, $params )
  {

    $request = $this->getRequest();

    // set the window title
    $this->setTitle( 'Process History' );

    // set the window status text
    $this->setStatus( 'Process History' );

    // set the from template
    $this->setTemplate( 'process/history' );

    $table = $this->createElement( 'historyTable'  , 'ProcessBase_Table' );
    $table->setData( $this->model->getProcessEdges( $process ) );
    $table->buildHtml();

    $this->addVar( 'entity', $this->model->getEntity() );

    return null;

  }//end public function displayHistory */

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $objid, $params )
  {

    $menu = $this->newMenu
    (
      $this->id.'_dropmenu',
      'ProcessBase'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $objid, $params );

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
  public function addActions( $objid, $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_edit").click(function(){
      self.setChanged(false);
      \$R.form('{$params->formId}');
    }).removeClass("wgtac_edit");

    self.getObject().find(".wgtac_show").click(function(){
      \$R.get('modal.php?c=Project.Constraint.show&amp;objid={$objid}');
    }).removeClass("wgtac_show");

    self.getObject().find(".wgtac_metadata").click(function(){
      \$R.get('modal.php?c=Project.Constraint.showMeta&amp;objid={$objid}');
    }).removeClass("wgtac_metadata");

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class ProcessBase_Modal_View

