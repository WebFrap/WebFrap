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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MaintenanceEntity_Stats_Modal_View
  extends WgtModal
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width   = 950 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height   = 720 ;

////////////////////////////////////////////////////////////////////////////////
// Display Methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * Ausgabe der Statistik
  *
  * @param TFlag $params
  * @return boolean
  */
  public function displayEntity( $domainNode, $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      $domainNode->label.' Statistics',
      $domainNode->domainI18n.'.label'
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    // set the from template
    $this->setTemplate( 'maintenance/modal/entity/overview_stats_entity' );

    $widget = $this->addWidget( 'widgetStats', 'StatsEntity' );
    $widget->entityKey = $domainNode->domainName;

    $this->addVar( 'context', 'stats' );

    // kein fehler aufgetreten
    return null;

  }//end public function displayEntity */

 /**
  * Ausgabe der Statistik
  *
  * @param int $objid
  * @param TFlag $params
  * @return boolean
  */
  public function displayDataset( $domainNode, $objid, $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      $domainNode->label.' Statistics',
      $domainNode->domainI18n.'.label'
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    // set the from template
    $this->setTemplate( 'maintenance/modal/entity/overview_stats_entity' );

    $widget = $this->addWidget( 'widgetStats', 'StatsEntity' );
    $widget->entityKey = $domainNode->domainName;

    $this->addVar( 'context', 'stats' );

    // kein fehler aufgetreten
    return null;

  }//end public function displayDataset */

}//end class EnterpriseCompany_Maintenance_Stats_Modal_View
