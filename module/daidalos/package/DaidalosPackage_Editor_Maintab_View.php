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
class DaidalosPackage_Editor_Maintab_View extends WgtMaintab
{

  
  /**
   * @var DaidalosPackage_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// form export methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * @param TFlag $params
  */
  public function displayEditor( $key, $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Edit package '.$key,
      'wbf.label'
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    $this->addVar( 'package', $this->model->getPackageFile( $key, $params->type ) );
    $this->addVar( 'packages', $this->model->getPackageList( $key, $params->type ) );
    $this->addVar( 'packageKey', $key );
    $this->addVar( 'type', $params->type );
    
    $this->setTabId( 'wgt-tab-form-daidalos_package-'.$key );
    
    // set the from template
    $this->setTemplate( 'daidalos/package/maintab/form_edit' );

    $this->addMenu( $key, $params );

    // kein fehler aufgetreten
    return null;

  }//end public function displayList */

/*//////////////////////////////////////////////////////////////////////////////
// protocol for entities
//////////////////////////////////////////////////////////////////////////////*/
    
 

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  protected function addMenu( $key, $params )
  {

    $i18n         = $this->getI18n();
  
    $iconMenu     = $this->icon( 'control/menu.png'      ,'Menu');
    $iconSupport  = $this->icon( 'control/support.png'      ,'Support');
    $iconHelp     = $this->icon( 'control/help.png'      ,'Help');
    $iconClose    = $this->icon( 'control/close.png'      ,'Close');
    $iconSave     = $this->icon( 'control/save.png'      ,'Save');
    $iconBug      = $this->icon( 'control/bug.png'      ,'Bug');

    $iconSync      = $this->icon( 'control/sync.png'      ,'Sync');
    $iconBuild     = $this->icon( 'daidalos/build.png'      ,'Build');

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
  <li class="wgt-root" >
    <button class="wgt-button wgtac_save" >{$iconSave} {$this->i18n->l('Save','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_sync_files" >{$iconSync} {$this->i18n->l('Sync Files','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_build_package" >{$iconBuild} {$this->i18n->l('Build','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
</ul>
HTML;

    $this->addActions( $key, $params );

  }//end protected function addMenu */

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
  protected function addActions( $key, $params )
  {

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

// close tab
self.getObject().find(".wgtac_close").click(function(){
  self.close();
});

self.getObject().find(".wgtac_save").click(function(){
  \$R.form('wgt-form-daidalos_package_edit-{$key}');
  //self.close();
});

self.getObject().find(".wgtac_build_package").click(function(){
  \$S('#wgt-modal-daidalos-package-{$key}').modal();
  //self.close();
});

BUTTONJS;

    $this->addJsCode( $code );

  }//end protected function addActions */



}//end class MaintenanceCache_Maintab_View

