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
class MyAnnouncement_Widget_Table_Panel extends WgtPanelTable
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

    $this->title = $i18n->l( 'My Announcements', 'wbfsys.announcement.label' );
    $this->searchKey = 'my_announcement';

    $buttonArchive = <<<HTML
      <div class="inline wgt-border-light wgt-bg-light" style="padding:2px;margin-top:-2px;margin-right:3px;" >
        <span>{$i18n->l( 'Only Important', 'wbf.label' )}: </span>
        <input
          type="checkbox"
          id="wgt-filter-my_announcement-important"
          name="filter[important]"
          style="margin-top:-2px"
          value="1"
          class="wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
      </div>

      <div class="inline wgt-border-light wgt-bg-light" style="padding:2px;margin-top:-2px;margin-right:3px;" >
        <span>{$i18n->l( 'Archive', 'wbf.label' )}: </span>
        <input
          type="checkbox"
          id="wgt-filter-my_announcement-archive"
          name="filter[archive]"
          style="margin-top:-2px"
          value="1"
          class="wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
      </div>
HTML;

    $this->filterButtons[] = $buttonArchive;

  }//end public function setUp */

}// end class WbfsysAnnouncement_Widget_Table_Panel

