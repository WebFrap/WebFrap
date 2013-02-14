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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MaintenanceDb_Index_Search_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
    
    /**
    * @var MaintenanceDb_Index
    */
    public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
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

    $i18nLabel = $this->i18n->l
    (
      'Index Search',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle( $i18nLabel );
    $this->setLabel( $i18nLabel  );


    // set the form template
    $this->setTemplate( 'maintenance/db_index/maintab/search_form' );
    
    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'maintab';
    $params->viewId    = $this->getId();


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
  
    // benötigte resourcen laden
    $acl     = $this->getAcl();
    $view   = $this->getView();

    $iconMenu      = $view->icon(  'control/menu.png',  'Menu');
    $iconRebuild   = $view->icon(  'maintenance/rebuild_index.png', 'Rebuild Index');
    $iconBookmark  = $view->icon(  'control/bookmark.png', 'Bookmark');
    $iconClose     = $view->icon(  'control/close.png', 'Close');
    $iconSearch    = $view->icon('control/search.png','Search');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $params );

    $menu          = $this->newMenu($this->id.'_dropmenu');
    $menu->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->custom}
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
  
  <li class="wgt-root" >
  <form 
    method="get" 
    id="wgt-form-maintenance-db_index-search" 
    action="ajax.php?c=Maintenance.Db_Index.search" />
  

    <input 
      type="text"
      class="wcm wcm_req_search wgt-no-save fparam-wgt-form-maintenance-db_index-search xxlarge"
      name="key"
      id="wgt-input-maintenance-db_index-search" />
    <button class="wgt-button append" id="wgt-button-webfrap_navigation_search">Search {$iconSearch}</button>
    <ul style="margin-top:-10px;" >
    </ul>
  </li>

{$entries->customButton}
</ul>
HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport( $params )
  {

    $iconSupport    = $this->icon('control/support.png'  ,'Support');
    $iconBug        = $this->icon('control/bug.png'     ,'Bug');
    $iconFaq        = $this->icon('control/faq.png'     ,'Faq');
    $iconHelp       = $this->icon('control/help.png'    ,'Help');

    $html = <<<HTML

      <li>
        <p>{$iconSupport} {$this->i18n->l('Support','wbf.label')}</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Docu.open&amp;key=wbfsys_message-create" >{$iconHelp} {$this->i18n->l('Help','wbf.label')}</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=create" >{$iconBug} {$this->i18n->l('Bug','wbf.label')}</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=create" >{$iconFaq} {$this->i18n->l('FAQ','wbf.label')}</a></li>
        </ul>
      </li>

HTML;

    return $html;
    
  }//end public function entriesSupport */

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

// close tab
self.getObject().find(".wgtac_close").click(function(){
  self.close();
});

self.getObject().find(".wgtac_search").click(function(){
  \$R.form('ajax.php?c=Maintenance.Db_Index.search');
});

BUTTONJS;

    $this->addJsCode( $code );

  }//end public function addActions */

}//end class MaintenanceDb_Index_Stats_Maintab_View

