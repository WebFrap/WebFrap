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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Dset_Maintab_Menu extends WgtDropmenu
{

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// build methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param int $objid Die ID des Relevanten Datensatzes
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($objid, $params)
  {

    $iconMenu        = $this->view->icon('control/menu.png', 'Menu');
    $iconEdit        = $this->view->icon('control/save.png', 'Save');
    $iconBookmark    = $this->view->icon('control/bookmark.png', 'Bookmark');
    $iconMask        = $this->view->icon('control/mask.png', 'Mask');
    $iconListMask    = $this->view->icon('control/mask_tree.png', 'List Mask');

    $access           = $params->access;
    $user            = $this->getUser();

    $entries = new TArray();
    $entries->support  = $this->entriesSupport($objid, $params);


    $codeButton = '';

    if ($this->domainNode->aclKey != $this->domainNode->aclBaseKey) {
      $codeButton = <<<BUTTON

  <div class="wgt-panel-control"  >
    <button
      class="wcm wcm_ui_button wgtac_mask_entity_rights" >{$iconMask} {$this->view->i18n->l('Entity Rights','wbf.label')}</button>
  </div>

BUTTON;

    }


    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      wgt_drop_box="{$this->id}"
      id="{$this->id}-control" ><i class="icon-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')} <i class="icon-angle-down" ></i></button>
  </div>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true"}</var>

  <div class="wgt-dropdownbox" id="{$this->id}" >

    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="icon-bookmark" ></i> {$this->view->i18n->l('Bookmark','wbf.label')}</a>
      </li>
    </ul>
    <ul>
{$entries->support}
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" ><i class="icon-remove-circle" ></i> {$this->view->i18n->l('Close','wbf.label')}</a>
      </li>
    </ul>
  </div>

{$codeButton}

  <div class="wgt-panel-control"  >
    <button class="wcm wcm_ui_button wgtac_mask_list_rights" >{$iconListMask} {$this->view->i18n->l('List Rights','wbf.label')}</button>
  </div>

  <div class="wgt-panel-control" >
    <button class="wcm wcm_ui_button wgtac_edit" ><i class="icon-save" ></i> {$this->view->i18n->l('Save','wbf.label')}</button>
  </div>

HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param int $objid
   * @param TArray $params
   */
  protected function entriesSupport($objid, $params)
  {

    $iconSupport  = $this->view->icon( 'control/support.png'  ,'Support');
    $iconBug      = $this->view->icon( 'control/bug.png'      ,'Bug'  );
    $iconFaq      = $this->view->icon( 'control/faq.png'      ,'Faq'  );
    $iconHelp     = $this->view->icon( 'control/help.png'     ,'Help');


    $html = <<<HTML

  <li>
    <a class="deeplink" >{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</a>
    <span>
      <ul>
        <li><a
          class="wcm wcm_req_ajax"
          href="modal.php?c=Wbfsys.Faq.create&refer=enterprise_employee-acl-dset" >{$iconFaq} Faq</a>
        </li>
      </ul>
    </span>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * @param AclMgmt_Dset_Maintab_View $view
   * @param int $objid
   * @param TArray $params
   */
  public function addMenuLogic($view, $objid, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_edit").click(function() {
      \$R.form('{$params->formId}');
    });

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_mask_entity_rights").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
      \$R.get('maintab.php?c=Acl.Mgmt_Dset.listing&dkey={$view->domainNode->srcName}&objid={$objid}');
    });

    self.getObject().find(".wgtac_mask_list_rights").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
      \$R.get('maintab.php?c=Acl.Mgmt.listing&dkey={$view->domainNode->domainName}&objid={$objid}');
    });

    self.getObject().find(".wgtac_search").click(function() {
      \$R.form('{$params->searchFormId}',null,{search:true});
    });

    self.getObject().find('#wgt-button-{$view->domainNode->aclDomainKey}-acl-form-append').click(function() {

      if (\$S('#wgt-input-{$view->domainNode->aclDomainKey}-acl-id_group').val() === '') {

        \$D.errorWindow('Error','Please select a group first');

        return false;
      }

      \$R.form('wgt-form-{$view->domainNode->aclDomainKey}-acl-append');
      \$S('#wgt-form-{$view->domainNode->aclDomainKey}-acl-append').get(0).reset();

      return false;

    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function addMenuLogic */

} // end class AclMgmt_Dset_Maintab_Menu */

