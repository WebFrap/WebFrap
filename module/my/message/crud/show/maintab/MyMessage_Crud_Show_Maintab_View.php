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
class MyMessage_Crud_Show_Maintab_View extends WgtMaintab
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
  * Das Edit Form der WbfsysMessage Maske
  *
  * @param int $objid Die Objid der Hauptentity
  * @param TFlag $params Flow Control Flags
  *
  * @return null Error im Fehlerfall
  */
  public function displayForm($objid, $params)
  {

    // laden der benötigten Resource Objekte
    $request = $this->getRequest();

    // fetch the activ entity from the model registry
    $entityMyMessage = $this->model->readMessage();

    // fetch the i18n text for title, status and bookmark
    $i18nTitle = $this->i18n->l
    (
      'Message: {@text@}',
      'wbfsys.message.label',
      array('text' => $entityMyMessage->text())
    );
    $i18nLabel = $this->i18n->l
    (
      'Message: {@text@}',
      'wbfsys.message.label',
      array('text' => $entityMyMessage->text())
    );

    $params->viewType = 'maintab';
    $params->viewId   = $this->getId();

    // set the window title
    $this->setTitle($i18nTitle);
    $this->setLabel($i18nLabel);

    // set the from template
    $this->setTemplate('my/message/maintab/crud/form_show');

    $this->addVar('context', 'show');
    $this->addVar('params', $params);
    $this->addVar('message', $entityMyMessage);

    if ($entityMyMessage->id_sender) {
      $userLib = LibUser::getDefault();
      $this->addVar('sender', $userLib->getUserData($entityMyMessage->id_sender));
    }

    $refer = $this->model->getRefer($entityMyMessage);

    if ($refer)
      $this->addVar('refer', $refer->title);

    $this->addVar('messageStatus', $this->model->getMessageStatus());

    // add window menu, buttons and actions
    $this->addMenu($objid, $params);
    $this->addActions($objid, $params);

    // ok alles gut wir müssen keinen fehler zurückgeben
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
  public function addMenu($objid, $params)
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'MyMessage_Crud_Show'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($this->getAcl());
    $menu->setModel($this->model);

    $menu->buildMenu($objid, $params);

    return true;

  }//end public function addMenu */

  /**
   * just add the code for the edit ui controls
   *
   * @param int $objid die rowid des zu editierende Datensatzes
   * @param TFlag $params benamte parameter
   * {
   *   @param LibAclContainer access: der container mit den zugriffsrechten für
   *     die aktuelle maske
   *
   *   @param string formId: die html id der form zum ansprechen des update
   *     services
   * }
   */
  public function addActions($objid, $params)
  {

    $bookmark = '';
    if ($this->bookmark) {

      $bookmark = <<<BUTTONJS
    self.getObject().find('.wgtac_bookmark').click(function(){
      var requestData  = {
         'wbfsys_bookmark[id_role]':'{$this->bookmark['role']}',
         'wbfsys_bookmark[url]':'{$this->bookmark['url']}',
         'wbfsys_bookmark[title]':'{$this->bookmark['title']}'
      };
      \$R.post('ajax.php?c=Webfrap.Bookmark.add',requestData);
    });
BUTTONJS;

    }

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

{$bookmark}

self.getObject().find(".wgtac_close").click(function(){
  self.close();
});

BUTTONJS;

    $code .= <<<BUTTONJS

self.getObject().find(".wgtac_respond").click(function(){
  self.setChanged(false);
  \$R.form('{$params->formId}');
}).removeClass('wgtac_respond');

self.getObject().find(".wgtac_archive").click(function(){
  self.setChanged(false);
  \$R.put('ajax.php?c=My.Message_Crud.archive&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid={$objid}');
}).removeClass('wgtac_archive');

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class WbfsysMessage_Crud_Edit_Maintab_View

