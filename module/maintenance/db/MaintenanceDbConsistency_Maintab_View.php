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
class MaintenanceDbConsistency_Maintab_View extends WgtMaintabCustom
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var MyMessage_Crud_Model
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
  public function display($params)
  {

    // laden der mvc/utils adapter Objekte
    $request = $this->getRequest();

    // I18n Label und Titel Laden
    $i18nLabel = $this->i18n->l
    (
      'Database Consistency',
      'pontos.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel);
    $this->setLabel($i18nLabel  );
    //$this->setTabId('wgt-tab-form-my_message-create');

    // set the form template
    $this->setTemplate('maintenance/db/list', true);

    $extensionLoader = new ExtensionLoader('fix_db');
    $this->addVar('extensions', $extensionLoader);

    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'maintab';
    $params->viewId    = $this->getId();

    // Setzen der letzten metadaten
    $this->addVar('params', $params);
    $this->addVar('context', 'list');

    // Menü und Javascript Logik erstellen
    $this->addMenu($params);
    $this->addActions($params);

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
  public function addMenu($params)
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'MaintenanceDbConsistency'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($this->getAcl());
    $menu->setModel($this->model);

    $menu->buildMenu($params);

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
  public function addActions($params)
  {

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

self.getObject().find(".wgtac_run_all").click(function() {
  \$R.get('ajax.php?c=Maintenance.DbConsistency.fixAll');
});

// close tab
self.getObject().find(".wgtac_close").click(function() {
  self.close();
});

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class WbfsysMessage_Crud_Create_Maintab_View

