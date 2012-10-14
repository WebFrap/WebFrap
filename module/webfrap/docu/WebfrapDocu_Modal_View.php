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
class WebfrapDocu_Modal_View
  extends WgtModal
{
////////////////////////////////////////////////////////////////////////////////
// form export methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * @param WbfsysDocuPage $helpPage
  */
  public function displayShow( $helpPage )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Help for: {@label@}',
      'wbf.label',
      array
      ( 
        'label' => $helpPage->title 
      )
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    // set the from template
    $this->addVar( 'entity' , $helpPage );
    $this->setTemplate( 'webfrap/docu/modal/show' );


    $this->addMenu( $helpPage );
    $this->addActions( $helpPage );
    

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
  public function addMenu( $helpPage )
  {
    
    $view = $this->getView();
    $i18n = $this->getI18n();
  
    $iconMenu     = $this->icon('control/menu.png'      ,'Menu');
    $iconSupport  = $this->icon('control/support.png'      ,'Support');
    $iconHelp     = $this->icon('control/help.png'      ,'Help');
    $iconClose    = $this->icon('control/close.png'      ,'Close');
    $iconEdit     = $this->icon('control/edit.png'      ,'Edit');
    $iconBug      = $this->icon('control/bug.png'      ,'Bug');


    $menu          =  <<<HTML
    
<div class="wgt-panel wgt-border" >

  <div class="inline" >
    <button 
      class="wcm wcm_control_dropmenu wgt-button"
      id="{$this->id}_dropmenu-control" 
      wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$view->i18n->l('Menu','wbf.label')}</button>
  </div>
  
  <div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
    <ul>
      <li>
        <a class="deeplink" >{$iconSupport} {$i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li>
              <a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Bug.create&amp;context=webfrap_docu-create" >
                {$iconBug} {$i18n->l('Bug','wbf.label')}
              </a>
            </li>
          </ul>
        </span>
      </li>
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" >{$iconClose} {$i18n->l('Close','wbf.label')}</a>
      </li>
    </ul>
  </div>
    
  <div class="wgt-panel-control" >
    <button class="wgtac_edit wgt-button" >{$iconEdit} {$i18n->l('Edit','wbf.label')}</button>
  </div>
  
</div>

HTML;

    $this->addVar( 'menuPanel', $menu );

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
  public function addActions( $helpPage )
  {

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.find(".wgtac_edit").click(function(){
      \$S.modal.close();
      \$R.get( 'modal.php?c=Webfrap.Docu.edit&amp;key={$helpPage->access_key}' );
    });
    
    self.find(".wgtac_close").click(function(){
      \$S.modal.close();
    });

BUTTONJS;

    $this->addJsCode( $code );

  }//end public function addActions */



}//end class WebfrapDocu_Modal_View

