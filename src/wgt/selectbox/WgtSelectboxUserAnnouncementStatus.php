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
 * @subpackage tech_core
 */
class WgtSelectboxUserAnnouncementStatus
  extends WgtSelectboxHardcoded
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function load()
  {

    $this->data =  array
    (
      EUserAnnouncementStatus::IS_NEW   => array( 'value' => 'New' ),
      EUserAnnouncementStatus::OPEN     => array( 'value' => 'Open' ),
      EUserAnnouncementStatus::ARCHIVED => array( 'value' => 'Archived' ),
    );

  }//end public function load */

} // end class WgtSelectboxUserAnnouncementStatus
