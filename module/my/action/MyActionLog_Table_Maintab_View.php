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
 * @subpackage ModMy
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class MyActionLog_Table_Maintab_View extends WgtMaintab
{

/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var MyTask_Table_Model
    */
    public $model = null;

    /**
    * @var MyTask_Crud_Model
    */
    public $crudModel = null;

    /**
    * @var MyTask_Table_Ui
    */
    public $ui = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

    /**
     * @setter self::crudModel
     * @param MyTask_Crud_Model $crudModel
     */
    public function setModelCrud($crudModel)
    {

      $this->crudModel = $crudModel;

    }//end public function setModelCrud */

    /**
     * @getter self::crudModel
     * @return MyTask_Crud_Model
     */
    public function getModelCrud()
    {
      return $this->crudModel;

    }//end public function getModelCrud */

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
  public function displayListing($params)
  {

    // laden der benötigten resourcen
    $request = $this->getRequest();

    // setzen des templates
    $this->setTemplate('my/task/maintab/listing');

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'My personal assigned Tasks',
      'my.task.label'
    );

    // setzen des Tabl Labels, sowie den Titel des Tab Title panels
    $this->setLabel($i18nText);
    $this->setTitle($i18nText);

    // such formular ID und Aktion müssen gesetzt werden
    // sie können von auserhalb übergeben werden, wenn nicht vorhanden
    // muss eine standard action sowie eine standard id gesetzt werden
    if (!$params->searchFormAction)
      $params->searchFormAction = 'index.php?c=Project.Project.search';

    if (!$params->searchFormId)
      $params->searchFormId = 'wgt-form-table-project_project-search';

    // set search form erweitert die Action anhand der in params mit
    // übergebene flags und schiebt formAction und formId in den VAR index
    // der aktuellen view
    $this->setSearchFormData($params);

    /// addMenu erstellt das dropdown menü und schiebt es dann in die view
    $this->addMenuListing($params);
    $this->addActionsListing($params);

    // über publish kann definiert werden, dass mit dem schliesen des listen
    // elements der inhalt eines bestimmten UI-Elements neu geladen werden muss
    // Diese Feature wird unter anderem dazu verwendet editierbare Selectboxen
    // zu erstellen
    // target, field and targetId. If not this was an invalid request
    if ('selectbox' === $params->publish) {

      $onClose = <<<BUTTONJS

      \$R.get('ajax.php?c={$params->target}.item&amp;field={$params->field}&amp;target_id={$params->targetId}');

BUTTONJS;

      // on close the calling selectbox has to be updated
      $this->addEvent('onclose' , 'refreshSelectbox' , $onClose);

      // clean the targetId to no affect the id of the table
      $params->targetId = null;
    }

    $crudUi = $this->loadUi('MyTask_Crud');
    $crudUi->setModel($this->crudModel);
    $crudUi->createForm($params);


    $ui = $this->loadUi('MyTask_Table');

    // Das Listenelement wird erstellt
    // ACLs werden im Model weiter ausgewertet
    $ui->createListItem
    (
      $this->model->search($params),
      $params
    );
/*
    // Das Suchformular wird erstellt
    $ui->searchForm
    (
      $this->model,
      $params
    );
    */

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
  public function addMenuListing($params)
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'MyTask_Table'
    );

    // wir übernehmen einfach die ID des Maintabs und hängen dropmenu dran
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($params);

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
  public function addActionsListing($params)
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
    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_search").click(function() {
      \$R.form('{$params->searchFormId}', null, {search:true});
    });


BUTTONJS;

    // create code wird ohne creatbutton auch nicht benötigt
    if ($params->access->insert) {
      $code .= <<<BUTTONJS
    self.getObject().find(".wgtac_new").click(function() {
       \$S('#wgt-form-my_task-table-crud').show();
    });

    self.getObject().find(".wgtac_create").click(function() {
      \$R.form('{$params->formId}');
      \$S('#wgt-form-my_task-table-crud').hide();
    });

    self.getObject().find(".wgtac_cancel").click(function() {
       \$S('#wgt-form-my_task-table-crud').hide();
    });

BUTTONJS;
    }

    $this->addJsCode($code);

  }//end public function addActionsListing */

}//end class MyTask_Table_Maintab_View

