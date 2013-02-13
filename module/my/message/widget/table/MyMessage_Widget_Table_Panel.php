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
 *
 * @package WebFrap
 * @subpackage Modprofiles
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Widget_Table_Panel
  extends WgtPanelTable
{
/*//////////////////////////////////////////////////////////////////////////////
// set up method
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * set up the panel data
   *
   * @return string
   */
  public function setUp( )
  {
    
    $user   = $this->getUser();
    $acl    = $this->getAcl();
    $i18n   = $this->getI18n();
    
    $this->title = $i18n->l( 'My Messages', 'my.message.label' );
    $this->searchKey = 'my_message';
    
   
    $buttonArchive = <<<HTML


    <div class="inline wgt-border-light wgt-bg-light" style="padding:2px;margin-top:-2px;margin-right:3px;" >
    <span>{$i18n->l( 'In/Out', 'project.plan.label' )}: </span>
    <span>&nbsp;&nbsp;Both </span>
    <input 
      type="radio"
      id="wgt-filter-project_plan-activ_projects_1"
      name="filter[mailbox]"
      value="both"
      class="wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
   
    <span>&nbsp;&nbsp;Inbox </span>
    <input 
      type="radio"
      id="wgt-filter-project_plan-activ_projects_2"
      name="filter[mailbox]"
      checked="checked"
      value="in"
      class="wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
      
    <span>&nbsp;&nbsp;Outbox </span>
    <input 
      type="radio"
      id="wgt-filter-project_plan-activ_projects_3"
      name="filter[mailbox]"
      value="out"
      class="wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
    </div>
    
    <div class="inline wgt-border-light wgt-bg-light" style="padding:2px;margin-top:-2px;margin-right:3px;" >
      <span>{$i18n->l( 'Archive', 'project.plan.label' )}: </span>
      <input 
        type="checkbox"
        id="wgt-filter-project_plan-activ_projects"
        name="filter[archive]"
        value="1"
        class="wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
    </div>
     
HTML;
    
    $this->filterButtons[] = $buttonArchive;


    
  }//end public function setUp */
    
}// end class WbfsysMessage_Widget_Table_Panel

