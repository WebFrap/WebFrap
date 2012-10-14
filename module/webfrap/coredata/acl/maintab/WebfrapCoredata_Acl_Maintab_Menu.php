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
class WebfrapCoredata_Acl_Maintab_Menu
  extends Webfrap_Acl_Maintab_Menu
{
////////////////////////////////////////////////////////////////////////////////
// Menu Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the dropmenu for the maintab
   *
   * @param int $areaId
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $areaId, $params )
  {
  
    $access           = $params->access;
    $user            = $this->getUser();

    // first create icons
    $iconMenu        = $this->view->icon('control/menu.png'      , 'Menu' );
    $iconEdit        = $this->view->icon('control/save.png'      , 'Save' );
    $iconBookmark    = $this->view->icon('control/bookmark.png'  , 'Bookmark' );
    $iconClose       = $this->view->icon('control/close.png'     , 'Close' );
    $iconMasks       = $this->view->icon('control/masks.png'     , 'Masks' );
    $iconMask        = $this->view->icon('control/mask.png'      , 'Mask' );

    
    // load entries
    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $areaId, $params );
    $entries->masks    = $this->switchMask( $params );

    // assemble all parts to the menu markup
    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$this->view->i18n->l( 'Menu', 'wbf.label' )}</button>
    <ul style="margin-top:-10px;" >
      <!--
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l( 'Bookmark', 'wbf.label' )}</p>
      </li>
      -->
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l( 'Close', 'wbf.label' )}</p>
      </li>
    </ul>
  </li>
  {$entries->masks}

  <li class="wgt-root" >
    <button 
      class="wcm wgt-button wgtac_edit wcm_ui_tip"
      title="Save Changes" >{$iconEdit}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
</ul>
HTML;

  }//end public function buildMenu */

  /**
   * build the support submenu part
   *
   * @param TArray $params named parameter / control flags
   */
  protected function entriesSupport( $areaId, $params )
  {

    // first create icons
    $iconSupport  = $this->view->icon(  'control/support.png'  ,'Support');
    $iconBug      = $this->view->icon(  'control/bug.png'      ,'Bug'  );
    $iconFaq      = $this->view->icon(  'control/faq.png'      ,'Faq'  );
    $iconHelp     = $this->view->icon(  'control/help.png'     ,'Help' );

    // assemble al parts to the html submenu
    $html = <<<HTML

  <li>
    <p>{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</p>
    <ul>
      <li><a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Docu.show&amp;key=mod-{$this->view->model->domainKey}-cat-core_data-acl" >{$iconHelp} Help</a></li>
      <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&refer=mod-{$this->view->model->domainKey}-cat-core_data-acl" >{$iconBug} Bug</a></li>
      <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&refer=mod-{$this->view->model->domainKey}-cat-core_data-acl" >{$iconFaq} Faq</a></li>
    </ul>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * inject the menu logic in the maintab object.
   * the javascript will be executed after the creation of the tab in the browser
   *
   * @param WebfrapCoredata_Acl_Maintab_View $view
   * @param int $areaId
   * @param TArray $params
   */
  public function injectMenuLogic( $view, $areaId, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_edit").click(function()
    {
      \$R.form('{$params->formId}');
    });
    
    self.getObject().find(".wgtac_refresh").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=Project.Iteration_Acl.listing&mod_key={$view->model->domainKey}' );
    });
    
    self.getObject().find('#wgt-button-mod-{$view->model->domainKey}-cat-core_data-acl-form-append').click(function()
    {
      if(\$S('#wgt-input-mod-{$view->model->domainKey}-cat-core_data-acl-id_group').val()=='')
      {
        \$D.errorWindow('Error','Please select a group first');
        return false;
      }

      \$R.form('wgt-form-mod-{$view->model->domainKey}-cat-core_data-acl-append');
      \$S('#wgt-form-mod-{$view->model->domainKey}-cat-core_data-acl-append').get(0).reset();
      return false;

    });



BUTTONJS;

    $view->addJsCode($code);

  }//end public function injectMenuLogic */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function switchMask( $params )
  {

    $acl   = $this->getAcl();
    $user  = $this->getUser();

    return null;


  }//end public function switchMask */

} // end class WebfrapCoredata_Acl_Maintab_Menu */

