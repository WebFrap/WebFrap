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
 * @subpackage ModPlan
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyAnnouncement_Widget_Table_Archive_Filter
  extends LibSqlFilter
{/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   * @return LibSqlCriteria
   */
  public function inject( $criteria, $params )
  {

    $criteria->filter
    ( 
      '(wbfsys_announcement_access_status.value is null OR NOT wbfsys_announcement_access_status.value = '
            .EUserAnnouncementStatus::ARCHIVED.')',
      'AND' 
    );

    return $criteria;

  }//end public function inject */
  
} // end class MyAnnouncement_Widget_Table_Archive_Filter_Postgresql */

