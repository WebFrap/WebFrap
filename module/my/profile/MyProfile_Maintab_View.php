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
class MyProfile_Maintab_View extends WgtMaintab
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
  public function displayForgotPasswordForm($params )
  {

    // laden der benötigten Resource Objekte
    $request = $this->getRequest();

    // I18n Label und Titel Laden
    $i18nTitle = $this->i18n->l
    (
      'Forgot Password',
      'wbfsys.message.label'
    );

    $i18nLabel = $this->i18n->l
    (
      'Forgot Password',
      'wbfsys.message.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nTitle );
    $this->setLabel($i18nLabel  );
    //$this->setTabId( 'wgt-tab-form-my_message-create' );

    // set the form template
    $this->setTemplate( 'my/profile/maintab/forgot_password' );
    
    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'maintab';
    $params->viewId    = $this->getId();

    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=My.Profile.forgotPassword';
    $params->formId     = 'wgt-form-my_profile-forgot_password';

    // Setzen der letzten metadaten
    $this->addVar( 'params', $params );
    $this->addVar( 'context', 'create' );
    
    // Das Create Form Objekt erstellen und mit allen nötigen Daten befüllen
    $form = $this->newForm( 'MyProfile_ForgotPassword' );

    // Form Action und ID setzen
    $form->setFormTarget($params->formAction, $params->formId, $params );
    $form->renderForm($params );

    // Menü und Javascript Logik erstellen
    $this->addMenu($params );
    $this->addActions($params );

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayForgotPasswordForm */

 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayShow($params )
  {

    // laden der benötigten Resource Objekte
    $request = $this->getRequest();

    // I18n Label und Titel Laden
    $i18nLabel = $this->i18n->l
    (
      'My Profile',
      'wbfsys.message.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel );
    $this->setLabel($i18nLabel  );
    //$this->setTabId( 'wgt-tab-form-my_message-create' );

    // set the form template
    $this->setTemplate( 'my/profile/maintab/my_profile' );
    
    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'maintab';
    $params->viewId    = $this->getId();

    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=My.Profile.save';
    $params->formId     = 'wgt-form-my_profile-show';

    // Setzen der letzten metadaten
    $this->addVar( 'params', $params );
    $this->addVar( 'context', 'create' );
    
    // Das Create Form Objekt erstellen und mit allen nötigen Daten befüllen
    $form = $this->newForm( 'MyProfile_Crud' );

    // Form Action und ID setzen
    $form->setFormTarget($params->formAction, $params->formId, $params );
    $form->renderForm($params );

    // Menü und Javascript Logik erstellen
    $this->addMenu($params );
    $this->addActions($params );

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayShow */
  
/*//////////////////////////////////////////////////////////////////////////////
// Menu & Logic
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
  public function addMenu($params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'MyMessage_Crud_Create'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($this->getAcl() );
    $menu->setModel($this->model );

    $menu->buildMenu($params );

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
  public function addActions($params )
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

    $this->addJsCode($code );

  }//end public function addActions */

}//end class WbfsysMessage_Crud_Create_Maintab_View

