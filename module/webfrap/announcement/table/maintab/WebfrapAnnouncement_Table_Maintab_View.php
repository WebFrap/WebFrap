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
 * de:
 * View Klasse zum erstellen eines Maintab Elements
 * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=architecture.views.overview" >Tutorial Viewtypes</a>
 *
 * Diese Klasse enthält die Logik zur Erstellung eines Maintab Element + Menü
 * für das Listenelement der Announcement
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapAnnouncement_Table_Maintab_View
  extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/
    
    /**
    * @var WebfrapAnnouncement_Table_Model
    */
    public $model = null;

    /**
    * @var WebfrapAnnouncement_Table_Ui
    */
    public $ui = null;

/*//////////////////////////////////////////////////////////////////////////////
// list display methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * de:
  *
  * View Methode zum Erstellen des Listing Elements und eines Suchformulars
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayListing( $params )
  {
    
    // laden der benötigten resourcen
    $request  = $this->getRequest();
    $access   = $params->access;

    // Setzen der letzten metadaten
    $this->addVar( 'params', $params );
    
    // setzen des templates
    $this->setTemplate( 'webfrap/announcement/maintab/table/listing_table' );

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'Announcements',
      'wbfsys.announcement.label'
    );

    // setzen des Tabl Labels, sowie den Titel des Tab Title panels
    $this->setLabel( $i18nText );
    $this->setTitle( $i18nText );

    // such formular ID und Aktion müssen gesetzt werden
    // sie können von auserhalb übergeben werden, wenn nicht vorhanden
    // muss eine standard action sowie eine standard id gesetzt werden
    if( !$params->searchFormAction )
      $params->searchFormAction = 'index.php?c=Webfrap.Announcement.search';

    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-webfrap_announcement-search';

    // set search form erweitert die Action anhand der in params mit
    // übergebene flags und schiebt formAction und formId in den VAR index
    // der aktuellen view
    $this->setSearchFormData( $params );

    // filter auswerten die mitgeschickt werden können
    $condition = array();

    $ui = $this->loadUi( 'WebfrapAnnouncement_Table' );

    // Das Listenelement wird erstellt
    // ACLs werden im Model weiter ausgewertet
    $ui->createListItem
    (
      $this->model->search( $access, $params, $condition ),
      $access,
      $params
    );

    // Das Suchformular wird erstellt
    $ui->searchForm
    (
      $this->model,
      $params
    );
    
    // crudform 
    
    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=Webfrap.Announcement.insert';
    $params->formId       = 'wgt-form-webfrap_announcement';
    
    // Das Create Form Objekt erstellen und mit allen nötigen Daten befüllen
    $form = $this->newForm( 'WebfrapAnnouncement_Crud_Create' );
    $entity = $this->model->getEntity();
    $form->setEntity( $entity );

    // Form Action und ID setzen
    $form->setFormTarget( $params->formAction, $params->formId, $params );
    $form->renderForm( $params );
    
    
    /// addMenu erstellt das dropdown menü und schiebt es dann in die view
    $this->addMenuListing( $params );
    $this->addActionsListing( $params );

    // kein fehler aufgetreten?
    // na dann ist ja bestens :-)
    return null;

  }//end public function displayListing */

/*//////////////////////////////////////////////////////////////////////////////
// context table
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * de:
   *
   * Das Menü Objekt erstellen und direkt bauen
   *
   * @param TFlag $params benamte parameter
   */
  public function addMenuListing( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'WebfrapAnnouncement_Table'
    );

    // wir übernehmen einfach die ID des Maintabs und hängen dropmenu dran
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params );

    return true;

  }//end public function addMenuListing */

  /**
   * de:
   * In dieser Methode wird die Javascript Logik für das Maintab Element dynamisch
   * generiert
   *
   * Relevant für den Umfang sind die übergebenen Parameter und die ACLs
   *
   * @param TFlag $params benamte parameter
   * {
   *   string searchFormId: the id of the search form;
   *   LibAclContainer access: Container mit den aktiven ACL Informationen
   * }
   */
  public function addActionsListing( $params )
  {

    // en:
    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action

    // de:
    // die logik wird über klassen auf and die Buttons gebunden
    // das ermöglich es auch eine aktion direkt an mehr als nur einen
    // button zu binden
    // Ein weiterer Vorteil is, dass kein Javascript im Markup vorhanden sein
    // muss
    $code = <<<BUTTONJS

    // close tab
    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });

    self.getObject().find(".wgtac_search").click(function(){
      \$R.form('{$params->searchFormId}', null, {search:true});
    });


BUTTONJS;

    // create code wird ohne creatbutton auch nicht benötigt
    if( $params->access->insert )
    {
      $code .= <<<BUTTONJS
    self.getObject().find(".wgtac_new").click(function(){
       \$R.get('modal.php?c=Webfrap.Announcement.create&ltype=table');
    });

BUTTONJS;

    }

    $this->addJsCode($code);

  }//end public function addActionsListing */

}//end class WbfsysAnnouncement_Table_Maintab_View

