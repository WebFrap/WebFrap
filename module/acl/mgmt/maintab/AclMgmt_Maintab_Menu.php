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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Maintab_Menu
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

    $iconSupport  = $this->view->icon(  'control/support.png'  ,'Support');
    $iconBug      = $this->view->icon(  'control/bug.png'      ,'Bug'  );
    $iconFaq      = $this->view->icon(  'control/faq.png'      ,'Faq'  );
    $iconHelp     = $this->view->icon(  'control/help.png'     ,'Help' );
    
    // load entries
    $entries = new TArray();
    $entries->masks    = $this->switchMask( $params );

    // assemble all parts to the menu markup
    $this->content = <<<HTML
    
  <div class="inline" >
    <button 
      class="wcm wcm_control_dropmenu wgt-button"
      wgt_drop_box="{$this->id}"
      id="{$this->id}-control" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true"}</var>
  </div>
  
  <div class="wgt-dropdownbox" id="{$this->id}" >
    
    <ul>
      <li>
        <a class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l( 'Bookmark', 'wbf.label' )}</a>
      </li>
    </ul>
    <ul>
{$entries->masks}

  <li>
    <a class="deeplink" >{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</a>
    <span>
      <ul>
        <li><a 
          class="wcm wcm_req_ajax" 
            href="modal.php?c=Webfrap.Docu.show&amp;key={$this->view->domainNode->domainName}-acl" >{$iconHelp} {$this->view->i18n->l('Help','wbf.label')}</a>
        </li>
        <li><a 
          class="wcm wcm_req_ajax" 
          href="modal.php?c=Wbfsys.Issue.create&refer={$this->view->domainNode->domainName}-acl" >{$iconBug} {$this->view->i18n->l('Bug','wbf.label')}</a>
        </li>
        <li><a 
          class="wcm wcm_req_ajax" 
          href="modal.php?c=Wbfsys.Faq.create&refer={$this->view->domainNode->domainName}-acl" >{$iconFaq} {$this->view->i18n->l('Faq','wbf.label')}</a>
        </li>
      </ul>
    </span>
  </li>
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l( 'Close', 'wbf.label' )}</a>
      </li>
    </ul>

  </div>

  


  <div class="wgt-panel-control"  >
    <button 
      class="wcm wgt-button wgtac_edit wcm_ui_tip"
      title="Save Changes" >{$iconEdit}</button>
  </div>

HTML;

  }//end public function buildMenu */


  /**
   * inject the menu logic in the maintab object.
   * the javascript will be executed after the creation of the tab in the browser
   *
   * @param AclMgmt_Maintab $view
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

    self.getObject().find(".wgtac_edit").click(function(){
      \$R.form('{$params->formId}');
      \$S('#{$this->id}-control').dropdown('close');
    });
    
    self.getObject().find(".wgtac_mask_entity_rights").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=Acl.Mgmt.listing' );
    });
    
    self.getObject().find(".wgtac_masks_overview").click(function(){
      \$R.get( 'modal.php?c=Acl.Mgmt.listAllMasks' );
      \$S('#{$this->id}-control').dropdown('close');
    });
    

    self.getObject().find('#wgt-button-{$this->view->domainNode->domainName}-acl-form-append').click(function(){
    
      if(\$S('#wgt-input-{$this->view->domainNode->domainName}-acl-id_group').val()==''){
        \$D.errorWindow('Error','Please select a group first');
        return false;
      }

      \$R.form('wgt-form-{$this->view->domainNode->domainName}-acl-append');
      \$S('#wgt-form-{$this->view->domainNode->domainName}-acl-append').get(0).reset();
      return false;

    });


    self.getObject().find(".wgtac_mask_employee_active").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Active_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_archive").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Archive_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_highpotential").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Highpotential_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_management").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Management_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_planned").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Planned_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_my_employee_data").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
      \$R.get( 'maintab.php?c=My.EmployeeData_Acl.listing' );
    });


    self.getObject().find(".wgtac_close").click(function(){
      \$S('#{$this->id}-control').dropdown('remove');
      self.close( );
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


    $iconMasks         = $this->view->icon('control/masks.png'      ,'Masks');
    $iconMask         = $this->view->icon('control/mask.png'      ,'Mask');


    $numEntries = 0;

    $html = <<<HTML
  <li title="masks provide optimized views for diffrent roles and use cases" >
    <a class="deeplink" >{$iconMasks} {$this->view->i18n->l('Masks','wbf.label')}</a>
    <span>
    <ul>
HTML;


      if( $acl->access( 'mod-enterprise/mgmt-'.$this->view->domainNode->domainName.'>mgmt-employee_active:admin' ) )
      {
        $html .= '<li><a class="wgtac_mask_employee_active" >'.$iconMask.' '.$this->view->i18n->l( 'Active', 'employee.active.label' ).'</a></li>'.NL;
        ++ $numEntries;
      }

      if( $acl->access( 'mod-enterprise/mgmt-'.$this->view->domainNode->domainName.'>mgmt-employee_archive:admin' ) )
      {
        $html .= '<li><a class="wgtac_mask_employee_archive" >'.$iconMask.' '.$this->view->i18n->l( 'Archive', 'employee.archive.label' ).'</a></li>'.NL;
        ++ $numEntries;
      }

      if( $acl->access( 'mod-enterprise/mgmt-'.$this->view->domainNode->domainName.'>mgmt-employee_highpotential:admin' ) )
      {
        $html .= '<li><a class="wgtac_mask_employee_highpotential" >'.$iconMask.' '.$this->view->i18n->l( 'Highpotential', 'employee.highpotential.label' ).'</a></li>'.NL;
        ++ $numEntries;
      }

      if( $acl->access( 'mod-enterprise/mgmt-'.$this->view->domainNode->domainName.'>mgmt-employee_management:admin' ) )
      {
        $html .= '<li><a class="wgtac_mask_employee_management" >'.$iconMask.' '.$this->view->i18n->l( 'Management', 'employee.management.label' ).'</a></li>'.NL;
        ++ $numEntries;
      }

      if( $acl->access( 'mod-enterprise/mgmt-'.$this->view->domainNode->domainName.'>mgmt-employee_planned:admin' ) )
      {
        $html .= '<li><a class="wgtac_mask_employee_planned" >'.$iconMask.' '.$this->view->i18n->l( 'Planned', 'employee.planned.label' ).'</a></li>'.NL;
        ++ $numEntries;
      }

      if( $acl->access( 'mod-enterprise/mgmt-'.$this->view->domainNode->domainName.'>mgmt-my_employee_data:admin' ) )
      {
        $html .= '<li><a class="wgtac_mask_my_employee_data" >'.$iconMask.' '.$this->view->i18n->l( 'My Data', 'my.employee_data.label' ).'</a></li>'.NL;
        ++ $numEntries;
      }


    $html .= <<<HTML
    </ul>
    </span>
  </li>
HTML;

    if( !$numEntries )
      return '';

    return $html;


  }//end public function switchMask */

} // end class AclMgmt_Maintab_Menu */

