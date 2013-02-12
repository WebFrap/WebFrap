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
 * @subpackage tech_core
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibProcessStatus_Selectbox_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  public $processName = null;

  public $processId = null;

////////////////////////////////////////////////////////////////////////////////
// Query Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Fetch method for the ProjectProject Selectbox
   * @return void
   */
  public function fetchSelectbox( )
  {

    if (!$this->processName && !$this->processId) {
      // ohne process id werden keine statusnodes geladen
      $this->data = array();

      return;
    }

    $db = $this->getDb();

    if( !$this->criteria )
      $criteria = $db->orm->newCriteria();
    else
      $criteria = $this->criteria;

    $criteria->select( array
    (
      'wbfsys_process_node.rowid as id',
      'wbfsys_process_node.label as value'
     ));

    $criteria->from( 'wbfsys_process_node' );

    if ($this->processId) {
      $criteria->where( 'wbfsys_process_node.id_process = '.$this->processId );
    } else {

      $criteria->leftJoinOn
      (
        'wbfsys_process_node',
        'id_process',
        'wbfsys_process',
        'rowid',
        null,
        'wbfsys_process'
      );

      $criteria->where( 'upper(wbfsys_process.access_key) = upper(\''.$this->processName."')" );
    }

    $criteria->orderBy( 'wbfsys_process_node.m_order' );

    $this->result = $db->orm->select( $criteria );

  }//end public function fetchSelectbox */

}//end class LibProcessStatus_Selectbox_Query
