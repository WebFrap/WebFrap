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
 * @subpackage webfrap\maintenance\process
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_ProcessNode_Selectbox_Query
  extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
    
/*//////////////////////////////////////////////////////////////////////////////
// Query Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * Fetch method for the WbfsysFileStorage Selectbox
   * @return void
   */
  public function fetchSelectbox( $processNode )
  {

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select( array
    (
      'wbfsys_process_node.rowid as id',
      'wbfsys_process_node.label as value'
     ));

    $criteria->from( 'wbfsys_process_node' );


    $criteria->orderBy( 'wbfsys_process_node.m_order ' );
    $criteria->where( "wbfsys_process_node.id_process = {$processNode}" );


    $this->result = $db->orm->select( $criteria );

  }//end public function fetchSelectbox */
  
  /**
   * Laden einer einzelnen Zeile,
   * Wird benötigt wenn der aktive Wert durch die Filter gerutscht ist.
   * Kann in archive Szenarien passieren.
   * In diesem Fall soll der Eintrag trotzdem noch angezeigt werden, daher
   * wird er explizit geladen
   *
   * @param int $entryId
   * @return void
   */
  public function fetchSelectboxEntry( $entryId )
  {
  
    // wenn keine korrekte id > 0 übergeben wurde müssen wir gar nicht erst
    // nach einträgen suchen
    if( !$entryId )
      return array();
  
    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select( array
    (
      'wbfsys_process_node.rowid as id',
      'wbfsys_process_node.label as value'
     ));

    $criteria->from( 'wbfsys_process_node' );


    $criteria->orderBy( 'wbfsys_process_node.name ' );
    $criteria->where( "wbfsys_process_node.rowid = {$entryId}" );

    return $db->orm->select( $criteria )->get();

  }//end public function fetchSelectboxEntry */


}//end class WebfrapMaintenance_ProcessNode_Selectbox_Query

