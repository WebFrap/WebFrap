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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdl_Mvcbase_PermissionRef_Edit_Maintab_Menu extends WgtDropmenu
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der domainkey
   * eg: profile
   * @var string
   */
  public $domainKey = null;

  /**
   * Domain Class Part
   * eg: Profile
   * @var string
   */
  public $domainClass = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $params)
  {

    $iconMenu          = $this->view->icon('control/menu.png'     ,'Menu'   );
    $iconClose         = $this->view->icon('control/close.png'    ,'Close'   );
    $iconSearch        = $this->view->icon('control/search.png'   ,'Search'  );
    $iconBookmark      = $this->view->icon('control/bookmark.png' ,'Bookmark');
    $iconSave          = $this->view->icon('control/save.png' ,'Save');
    $iconRefresh       = $this->view->icon('control/refresh.png' ,'Refresh');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport($params);

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}"  >
  <li class="wgt-root" >
    <button class="wgt-button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_refresh" >{$iconRefresh} {$this->view->i18n->l('Refresh','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_save" >{$iconSave} {$this->view->i18n->l('Save','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
</ul>
HTML;

  }//end public function buildMenu */



  /**
   * @param TFlag $params
   */
  protected function entriesSupport($params)
  {

    $iconSupport = $this->view->icon('control/support.png'  ,'Support');
    $iconBug     = $this->view->icon('control/bug.png'      ,'Bug');
    $iconFaq     = $this->view->icon('control/faq.png'      ,'Faq');
    $iconHelp    = $this->view->icon('control/help.png'     ,'Help');

    $html = <<<HTML

      <li>
        <p>{$iconSupport} Support</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=menu" >{$iconBug} Bug</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" >{$iconFaq} Faq</a></li>
        </ul>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

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
  public function injectActions($path, $view, $params)
  {

    $pNodeName = $view->model->parentNode->getName();

    $pathId = str_replace('.', '-', $path);

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_save").click(function() {
      \$R.form(
        'wgt-form-bdl_{$this->domainKey}-{$pNodeName}-permission-ref-edit-{$pathId}',
        null,
        {"statusCallback":{
          "ok":function() { self.close(); }
        }}
      );
    });

    self.getObject().find(".wgtac_refresh").click(function() {
      self.close();
      \$R.get('maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.edit'
        +'&amp;key={$view->model->modeller->key}&amp;bdl_file={$view->model->modeller->bdlFileName}'
        +'&amp;path='+\$S(this).attr('wgt_path'));
    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function injectActions */

}//end class DaidalosBdl_Mvcbase_PermissionRef_Edit_Maintab_Menu */

