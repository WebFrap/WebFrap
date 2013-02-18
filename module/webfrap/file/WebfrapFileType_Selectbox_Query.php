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
 * @subpackage core_data
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapFileType_Selectbox_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
    
/*//////////////////////////////////////////////////////////////////////////////
// Query Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * Fetch method for the WbfsysFileType Selectbox
   * @return void
   */
  public function fetchSelectbox($maskKey = null )
  {

    $db = $this->getDb();
    
    $hasReferences = 0;
    
    if ($maskKey )
    {
      
      if ( is_string($maskKey ) )
      {
      
      $sql = <<<SQL
SELECT COUNT( asgd.rowid ) as num_asgd
  from wbfsys_vref_file_type asgd
JOIN
  wbfsys_management mgmt
    on asgd.vid = mgmt.rowid
WHERE
  UPPER(mgmt.access_key) = UPPER('{$maskKey}');
SQL;

      $hasReferences = $db->select($sql)->getField( 'num_asgd' );
      
      }
      
    }
    

    
    if (!$this->criteria )
      $criteria = $db->orm->newCriteria();
    else
      $criteria = $this->criteria;

    $criteria->select( array
    (
      'DISTINCT wbfsys_file_type.rowid as id',
      'wbfsys_file_type.name as value'
     ));

    $criteria->from( 'wbfsys_file_type' );
    
    if ($maskKey && is_array($maskKey ) )
    {
      
      $searchKey =  "UPPER('".implode( "'), UPPER('", $maskKey )."')" ;
      $criteria->where( "UPPER(wbfsys_file_type.access_key) IN( {$searchKey} )" );
    }
    else if ($hasReferences )
    {
      $criteria->joinOn
      (
        'wbfsys_file_type', 'rowid', 
        'wbfsys_vref_file_type', 'id_type'
      );
      $criteria->joinOn
      (
        'wbfsys_vref_file_type', 'vid', 
        'wbfsys_management', 'rowid'
      );
      $criteria->where( "UPPER(wbfsys_management.access_key) = UPPER('{$maskKey}')" );
      
    } else {
      $criteria->where( 'wbfsys_file_type.flag_global = true' );
    }
    
    $criteria->orderBy( 'wbfsys_file_type.name ' );


    $this->result = $db->orm->select($criteria );

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
  public function fetchSelectboxEntry($entryId )
  {
  
    // wenn keine korrekte id > 0 übergeben wurde müssen wir gar nicht erst
    // nach einträgen suchen
    if (!$entryId )
      return array();
  
    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select( array
    (
      'DISTINCT wbfsys_file_type.rowid as id',
      'wbfsys_file_type.name as value'
     ));
    $criteria->from( 'wbfsys_file_type' );



    $criteria->where( "wbfsys_file_type.rowid = '{$entryId}'"  );

    return $db->orm->select($criteria )->get();

  }//end public function fetchSelectboxEntry */

  /**
   * Laden einer definierten Liste von Werten
   * Wird benötigt wenn die Selectbox mit der option multi
   * verwendet wird und einige der aktiven Werte durch die Filter gerutscht sind.
   * siehe auch self::fetchSelectboxEntry
   *
   * @param int $entryId
   * @return void
   */
  public function fetchSelectboxEntries($entryIds )
  {
    
    // wenn der array leer ist müssen wir nicht weiter prüfen
    if (!$entryIds )
      return array();
  
    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select( array
    (
      'DISTINCT wbfsys_file_type.rowid as id',
      'wbfsys_file_type.name as value'
     ));
    $criteria->from( 'wbfsys_file_type' );



    $criteria->where( "wbfsys_file_type.rowid IN ( '".implode("', '", $entryIds )."' )"  );

    return $db->orm->select($criteria )->getAll();

  }//end public function fetchSelectboxEntries */
  
}//end class WbfsysFileType_Selectbox_Query

