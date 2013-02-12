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
class MyAnnouncement_Widget_Table_OnlyImportant_Filter_Postgresql
  extends LibSqlFilter
{////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   * @return LibSqlCriteria
   */
  public function inject( $criteria, $params )
  {

    $criteria->filter
    (
      " wbfsys_announcement.importance  IN( 50 ) "
    );

    return $criteria;

  }//end public function inject */

} // end class MyAnnouncement_Widget_Table_OnlyImportant_Filter_Postgresql */
