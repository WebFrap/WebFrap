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
class AclMgmt_Tree_Maintab_Menu
  extends WgtDropmenu
{
////////////////////////////////////////////////////////////////////////////////
// Attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var DomainNode
   */
  public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// build methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * add a drop menu to the create window
   *
   * @param int $objid
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $objid, $params )
  {

    $view             = $this->view;
    $iconMenu        = $view->icon( 'control/menu.png'      ,'Menu' );
    $iconEdit        = $view->icon( 'control/save.png'      ,'Save' );
    $iconBookmark    = $view->icon( 'control/bookmark.png'  ,'Bookmark' );
    $iconClose       = $view->icon( 'control/close.png'     ,'Close' );

    $access           = $params->access;
    $user            = $this->getUser();

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $objid, $params );

    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$this->id}-control"
      wgt_drop_box="{$this->id}"  >{$iconMenu} {$view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >

    <ul>
      <li>
        <a class="wgtac_bookmark" >{$iconBookmark} {$view->i18n->l('Bookmark', 'wbf.label')}</a>
      </li>
    </ul>

    <ul>
{$entries->support}
    </ul>

    <ul>
      <li>
        <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</a>
      </li>
    </ul>
  </div>

HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param int $objid
   * @param TArray $params
   */
  protected function entriesSupport( $objid, $params )
  {

    $iconSupport  = $this->view->icon(  'control/support.png'  ,'Support');
    $iconBug      = $this->view->icon(  'control/bug.png'      ,'Bug'  );
    $iconFaq      = $this->view->icon(  'control/faq.png'      ,'Faq'  );
    $iconHelp     = $this->view->icon(  'control/help.png'     ,'Help' );


    $html = <<<HTML

  <li>
    <a class="deeplink" >{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</a>
    <span>
      <ul>
        <li><a
          class="wcm wcm_req_ajax"
          href="modal.php?c=Wbfsys.Faq.create&refer={$this->domainNode->domainName}-acl-path" >{$iconFaq} Faq</a>
        </li>
      </ul>
    </span>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * @param LibTemplatePresenter $view
   * @param int $objid
   * @param TArray $params
   */
  public function addMenuLogic( $view, $objid, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find('#wgt-button-{$this->domainNode->domainName}-acl-form-append').click(function(){
      if (\$S('#wgt-input-{$this->domainNode->domainName}-acl-id_group').val()=='') {
        \$D.errorWindow( 'Error', 'Please select a group first' );

        return false;
      }

      \$R.form('wgt-form-{$this->domainNode->domainName}-acl-append');
      \$S('#wgt-form-{$this->domainNode->domainName}-acl-append').get(0).reset();

      return false;

    });

    self.getObject().find(".wgtac_close").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function addMenuLogic */

} // end class AclMgmt_Tree_Maintab_Menu */
