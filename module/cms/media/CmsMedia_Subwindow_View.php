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
class CmsMedia_Subwindow_View
  extends WgtWindowTemplate
{

////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////
    
    /**
    * @var CmsMedia_Model
    */
    public $model = null;

    /**
    * @var CmsMedia_Ui
    */
    public $ui = null;

////////////////////////////////////////////////////////////////////////////////
// context selection
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * de:
  * Erstellen eines neuen Subwindows mit einem Auswahl Listenelement vom
  * Type: project_idea
  *
  * @param TFlag $params benamte parameter
  * {
  *   @param: ckey searchFormAction, Die URL an welche das Suchformular
  *     Bzw. der Paging Request des Listenelements geschickt werden soll
  *
  *   @param: ckey searchFormId, Die HTML ID des Suchformulars, welches mit dem Listenelement
  *     verbunden ist.
  *     Auf diesem Formular TAG werden im Client alle für das Element relevanten Metadaten, z.B Daten zum Paging
  *     Sortierung etc. per jQuery.data() abgelegt
  * }
  * @return boolean
  */
  public function displayMediatheke( $key, $params )
  {

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'Mediathek',
      'wgt.text'
    );
    
    // set the window status
    $this->setStatus( $i18nText );
    // set the window title
    $this->setTitle( $i18nText );
    
    //$access = $params->access;
  
    // set the default table template
    $this->setTemplate( 'cms/media/subwindow/base' );
    
    $this->model->loadMediathekByKey( $key );


    // create the form action
    if( !$params->searchFormAction )
      $params->searchFormAction = 'index.php?c=Project.Idea.filter';

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-selection-project_idea-search';

    $params->windowId = $this->getId();

    // fill the relevant data for the search form
    $this->setSearchFormData( $params );

    // append the buttons and menu
    $this->addMenu( $params );
    $this->addActions( $params );

    // kein fehler passiert? also geben wir keinen zurück
    return null;

  }//end public function displayMediatheke */

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

    $iconMenu         = $this->icon('control/menu.png'      ,'Menu');
    $iconAdd         = $this->icon('control/add.png'      ,'Create');
    $iconSearch         = $this->icon('control/search.png'      ,'Search');
    $iconClose         = $this->icon('control/close.png'      ,'Close');
    $iconEntity         = $this->icon('control/entity.png'      ,'Entity');
    $iconSupport         = $this->icon('control/support.png'      ,'Support');
    $iconHelp         = $this->icon('control/help.png'      ,'Help');
    $iconBug         = $this->icon('control/bug.png'      ,'Bug');
    $iconFaq         = $this->icon('control/faq.png'      ,'Faq');


    $entries = new TArray();



    $menu          = $this->newMenu($this->id.'_dropmenu');
    $menu->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}_dropmenu" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} Menu</button>
    <ul style="margin-top:-10px;" >
      <li class="current" >
        <p>{$iconSupport} Support</p>
        <ul>
          <li><a 
            class="wcm wcm_req_ajax" 
            href="modal.php?c=Webfrap.Docu.show&amp;key=project_idea-selection" >{$iconHelp} Help</a></li>
          <li><a 
            class="wcm wcm_req_ajax" 
            href="modal.php?c=Wbfsys.Issue.create&amp;context=selection&amp;mask=project_idea" >{$iconBug} Bug</a></li>
          <li><a 
            class="wcm wcm_req_ajax" 
            href="modal.php?c=Wbfsys.Faq.create&amp;context=selection&amp;mask=project_idea" >{$iconFaq} Faq</a></li>
        </ul>
      </li>
      <li>
        <p class="wgtac_close" >{$iconClose} Close</p>
      </li>
    </ul>
  </li>
</ul>
HTML;

  }//end public function addMenu */

  /**
   * create the create buttons
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string searchFormId: the id of the search form;
   * }
   */
  public function addActions( $params )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_search").click(function(){
      \$R.form('{$params->searchFormId}', null, {search:true});
    });

BUTTONJS;


    $code .= <<<BUTTONJS

    self.getObject().find(".wgtac_new").click(function(){
      \$R.get('maintab.php?c=Project.Idea.create');
    });

BUTTONJS;


    $this->addJsCode( $code );

  }//end public function addActions */

}//end class CmsMedia_Subwindow_View

