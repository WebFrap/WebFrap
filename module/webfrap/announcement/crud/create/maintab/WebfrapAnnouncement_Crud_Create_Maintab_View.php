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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WbfsysAnnouncement_Crud_Create_Maintab_View
  extends WgtMaintab
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
    /**
    * @var WbfsysAnnouncement_Crud_Model
    */
    public $model = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * Methode zum befüllen des WbfsysAnnouncement Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayForm( $params )
  {

    // laden der benötigten Resource Objekte
    $request = $this->getRequest();

    // I18n Label und Titel Laden
    $i18nTitle = $this->i18n->l
    (
      'Create a new Announcement',
      'wbfsys.announcement.label'
    );

    $i18nLabel = $this->i18n->l
    (
      'Create Announcement',
      'wbfsys.announcement.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle( $i18nTitle );
    $this->setLabel( $i18nLabel  );
    $this->setTabId( 'wgt-tab-form-wbfsys_announcement-create' );

    // set the form template
    $this->setTemplate( 'wbfsys/announcement/maintab/crud/form_create' );
    
    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'maintab';
    $params->viewId    = $this->getId();

    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=Wbfsys.Announcement.insert';
    $params->formId       = 'wgt-form-wbfsys_announcement';
    
    // Setzen der letzten metadaten
    $this->addVar( 'params', $params );
    $this->addVar( 'context', 'create' );
    
    // Das Create Form Objekt erstellen und mit allen nötigen Daten befüllen
    $form = $this->newForm( 'WbfsysAnnouncement_Crud_Create' );
    $entity = $this->model->getEntity();
    $form->setEntity( $entity );

    // Form Action und ID setzen
    $form->setFormTarget( $params->formAction, $params->formId, $params );
    
    // Potentiell vorhandene Default Werte aus dem POST Array auslesen
    if( $request->method( Request::POST ) )
    {
      $form->fetchDefaultData( $request );

    }

    $form->renderForm( $params );
    

    
    // Menü und Javascript Logik erstellen
    $this->addMenu( $params );
    $this->addActions( $params );

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayForm */

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

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'WbfsysAnnouncement_Crud_Create'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl( $this->getAcl() );
    $menu->setModel( $this->model );

    $menu->buildMenu( $params );

    return true;

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
  public function addActions( $params )
  {

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS
    
self.getObject().find(".wgtac_create").click(function(){
  self.setChanged( false );
  \$R.form('{$params->formId}','&amp;reopen=true',{append:true});
  self.close();
});

self.getObject().find(".wgtac_create_a_close").click(function(){
  self.setChanged( false );
  \$R.form('{$params->formId}');
  self.close();
});

// close tab
self.getObject().find(".wgtac_close").click(function(){
  self.close();
});

BUTTONJS;

    $this->addJsCode( $code );

  }//end public function addActions */

}//end class WbfsysAnnouncement_Crud_Create_Maintab_View

