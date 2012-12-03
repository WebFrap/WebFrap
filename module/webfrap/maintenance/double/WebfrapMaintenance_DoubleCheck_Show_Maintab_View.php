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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMaintenance_DoubleCheck_Show_Maintab_View
  extends WgtMaintab
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
    /**
    * @var WebfrapMaintenance_DataIndex_Model
    */
    public $model = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayShow( $params )
  {

    // laden der benötigten Resource Objekte
    $request = $this->getRequest();

    $i18nLabel = $this->i18n->l
    (
      'Data Index Stats',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle( $i18nLabel );
    $this->setLabel( $i18nLabel  );
    
    $this->addVar( 'modules', $this->model->getModules() );

    // set the form template
    $this->setTemplate( 'webfrap/maintenance/data_index/maintab/stats' );
    
    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'maintab';
    $params->viewId    = $this->getId();


    // Menü und Javascript Logik erstellen
    $this->addMenu( $params );
    $this->addActions( $params );

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
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
    
    // benötigte resourcen laden
    $acl    = $this->getAcl();

    $menu  = $this->newMenu( $this->id.'_dropmenu' );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl( $acl );
    $menu->setModel( $this->model );


    $iconMenu      = $view->icon(  'control/menu.png',  'Menu');
    $iconRebuild   = $view->icon(  'maintenance/rebuild_index.png', 'Rebuild Index');
    $iconBookmark  = $view->icon(  'control/bookmark.png', 'Bookmark');
    $iconClose     = $view->icon(  'control/close.png', 'Close');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport(  $menu );


    $menu->content = <<<HTML
    
  <div class="inline" >
    <button 
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$menu->id}-control" 
      wgt_drop_box="{$menu->id}"  >{$iconMenu} {$i18n->l('Menu','wbf.label')}</button>
      <var id="{$menu->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>
    
  <div class="wgt-dropdownbox" id="{$menu->id}" >
    <ul>
      <li>
        <a class="wgtac_bookmark" >{$iconBookmark} {$i18n->l('Bookmark','wbf.label')}</a>
      </li>
    {$entries->support}
      <li>
        <a class="wgtac_close" >{$iconClose} {$i18n->l( 'Close', 'wbf.label' )}</a>
      </li>
    </ul>
  </div>

{$entries->buttonInsert}

HTML;

  }//end public function addMenu */



  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport( $menu )
  {

    $iconSupport    = $this->icon('control/support.png'  ,'Support');
    $iconBug        = $this->icon('control/bug.png'     ,'Bug');
    $iconFaq        = $this->icon('control/faq.png'     ,'Faq');
    $iconHelp       = $this->icon('control/help.png'    ,'Help');

    $html = <<<HTML
		
      <li>
        <a class="deeplink" >{$iconSupport} {$this->i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li><a 
            	class="wcm wcm_req_ajax" 
            	href="modal.php?c=Webfrap.Docu.open&amp;key=wbfsys_message-create" >{$iconHelp} {$this->i18n->l('Help','wbf.label')}</a></li>
            <li><a 
            	class="wcm wcm_req_ajax" 
            	href="modal.php?c=Wbfsys.Issue.create&amp;context=create" >{$iconBug} {$this->i18n->l('Bug','wbf.label')}</a></li>
            <li><a 
            	class="wcm wcm_req_ajax" 
            	href="modal.php?c=Wbfsys.Faq.create&amp;context=create" >{$iconFaq} {$this->i18n->l('FAQ','wbf.label')}</a></li>
          </ul>
        </span>
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

BUTTONJS;

    $this->addJsCode( $code );

  }//end public function addActions */

}//end class WebfrapMaintenance_DataIndex_Maintab_View

