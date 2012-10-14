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
class WebfrapDocuViewer_Maintab_View
  extends WgtMaintab
{

////////////////////////////////////////////////////////////////////////////////
// form export methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * @param WbfsysDocuPage $helpPage
  * @param TFlag $params
  */
  public function displayShow( $helpPage, $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Docu for: {@label@}',
      'wbf.label',
      array
      ( 
        'label' => $helpPage 
      )
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    $this->addVar( 'fileName', $helpPage );
    
    // set the from template
    $this->setTemplate( 'webfrap/docu/maintab/docu_viewer' );


    $this->addMenu( $helpPage, $params );
    $this->addActions( $helpPage, $params );
    

    // kein fehler aufgetreten
    return null;

  }//end public function display */

////////////////////////////////////////////////////////////////////////////////
// protocol for entities
////////////////////////////////////////////////////////////////////////////////
    
 

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $helpPage, $params )
  {

    $i18n         = $this->getI18n();
  
    $iconMenu     = $this->icon( 'control/menu.png'      ,'Menu');
    $iconSupport  = $this->icon( 'control/support.png'      ,'Support');
    $iconHelp     = $this->icon( 'control/help.png'      ,'Help');
    $iconClose    = $this->icon( 'control/close.png'      ,'Close');
    $iconEdit     = $this->icon( 'control/edit.png'      ,'Edit');
    $iconBug      = $this->icon( 'control/bug.png'      ,'Bug');


    $menu          = $this->newMenu($this->id.'_dropmenu');
    $menu->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}_dropmenu" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li class="current" >
        <p>{$iconSupport} {$i18n->l('Support','wbf.label')}</p>
        <ul>
          <li>
            <a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Bug.create&amp;context=webfrap_docu-create" >
              {$iconBug} {$i18n->l('Bug','wbf.label')}
            </a>
          </li>
        </ul>
      </li>
      <li>
        <p class="wgtac_close" >{$iconClose} {$i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
</ul>
HTML;

  }//end public function addMenu */

  /**
   * this method is for adding the buttons in a create window
   * per default there is only one button added: save with the action
   * to save the window onclick
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions( $helpPage, $params )
  {


  }//end public function addActions */



}//end class WebfrapDocu_Subwindow_View

