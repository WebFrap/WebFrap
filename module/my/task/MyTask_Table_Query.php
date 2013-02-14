<?php 
/*******************************************************************************
          _______          ______    _______      ______    _______
         |   _   | ______ |   _  \  |   _   \    |   _  \  |   _   |
         |   1___||______||.  |   \ |.  1   / __ |.  |   \ |.  1___|
         |____   |        |.  |    \|.  _   \|__||.  |    \|.  __)_
         |:  1   |        |:  1    /|:  1    \   |:  1    /|:  1   |
         |::.. . |        |::.. . / |::.. .  /   |::.. . / |::.. . |
         `-------'        `------'  `-------'    `------'  `-------'
                             __.;:-+=;=_.
                                    ._=~ -...    -~:
                     .:;;;:.-=si_=s%+-..;===+||=;. -:
                  ..;::::::..<mQmQW>  :::.::;==+||.:;        ..:-..
               .:.:::::::::-_qWWQWe .=:::::::::::::::   ..:::-.  . -:_
             .:...:.:::;:;.:jQWWWE;.+===;;;;:;::::.=ugwmp;..:=====.  -
           .=-.-::::;=;=;-.wQWBWWE;:++==+========;.=WWWWk.:|||||ii>...
         .vma. ::;:=====.<mWmWBWWE;:|+||++|+|||+|=:)WWBWE;=liiillIv; :
       .=3mQQa,:=====+==wQWBWBWBWh>:+|||||||i||ii|;=$WWW#>=lvvvvIvv;.
      .--+3QWWc:;=|+|+;=3QWBWBWWWmi:|iiiiiilllllll>-3WmW#>:IvlIvvv>` .
     .=___<XQ2=<|++||||;-9WWBWWWWQc:|iilllvIvvvnvvsi|\'\?Y1=:{IIIIi+- .
     ivIIiidWe;voi+|illi|.+9WWBWWWm>:<llvvvvnnnnnnn}~     - =++-
     +lIliidB>:+vXvvivIvli_."$WWWmWm;:<Ilvvnnnnonnv> .          .- .
      ~|i|IXG===inovillllil|=:"HW###h>:<lIvvnvnnvv>- .
        -==|1i==|vni||i|i|||||;:+Y1""'i=|IIvvvv}+-  .
           ----:=|l=+|+|+||+=:+|-      - --++--. .-
                  .  -=||||ii:. .              - .
                       -+ilI+ .;..
                         ---.::....

********************************************************************************
*
* @author      : Dominik Bonsch <db@s-db.de>
* @date        :
* @copyright   : s-db.de (Softwareentwicklung Dominik Bonsch) <contact@s-db.de>
* @distributor : s-db.de <contact@s-db.de>
* @project     : S-DB Modules
* @projectUrl  : http://s-db.de
* @version     : 1
* @revision    : 1
*
* @licence     : S-DB Business <contact@s-db.de>
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyTask_Table_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

    
 /**
   * Vollständige Datenbankabfrage mit allen Filtern und Formatierungsanweisungen
   * ACLs werden nicht beachtet
   *
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   *
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetch( $condition = null, $params = null )
  {

    if(!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    if (!$this->criteria )
    {
      $criteria = $db->orm->newCriteria();
    }
    else
    {
      $criteria = $this->criteria;
    }

    if (!$criteria->cols )
    {
      $this->setCols( $criteria );
    }

    $this->setTables( $criteria );
    $this->appendConditions( $criteria, $condition, $params  );
    $this->checkLimitAndOrder( $criteria, $params );
    $this->appendFilter( $criteria, $params );

    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );

    if($params->loadFullSize)
      $this->calcQuery = $criteria->count('count(wbfsys_task.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */


 /**
   * Nur die Datensätz laden die im Key übergeben werden
   * 
   * Es werden keine Filter oder Acls, limits, offset oder sortierung beachtet!
   *
   *
   * @param array<int rowid:int access level> $inKeys
   * @param int   $sourceSize setzen der Source Size, muss hier von ausen übergeben werden
   * @param TFlag $params benamte parameter
   *
   * @return void keine Rückgabe, im Fehlerfall wird eine Exception geworfen
   *
   * @throws LibDb_Exception
   *  wenn bei der Abfragen technische Problemen auftreten, zb server nicht
   *  ereichbar, invalides sql... etc.
   */
  public function fetchInAcls( array $inKeys, $params = null )
  {

    if (!$params )
      $params = new TFlag();

    $db                = $this->getDb();
    
    // wenn keine keys vorhanden sind wird ein leeres result objekt gesetzt
    if (!$inKeys )
    {
      $this->result = $db->getEmptyResult();
      return;
    }
    
    $criteria          = $db->orm->newCriteria();

    $this->setCols( $criteria );
    $this->setTables( $criteria );

    $criteria->where
    (
      " wbfsys_task.rowid  IN( ". implode( ', ', array_keys($inKeys) ) ." )"
    );

    // Run Query und save the result
    $result    = $db->orm->select( $criteria );
    
    $this->data = array();
    
    foreach( $result as $row )
    {
      $row['acl-level'] = $inKeys[$row['wbfsys_task_rowid']];
      $this->data[]     = $row;
    }

  }//end public function fetchInAcls */

 /**
   * Injecten der zu ladenden Columns in die SQL Query
   * Wenn bereits Colums vorhanden waren werden diese komplett 
   * überschrieben 
   * Wenn Columns ergänzt werden sollen, dann können diese mit
   * $criteria->selectAlso( 'additional.column' );
   * übergeben werden
   *
   * @param LibSqlCriteria $criteria
   *
   * @return void
   */
  public function setCols( $criteria )
  {

    $cols = array
    (
      'wbfsys_task.title as "my_task_title"',
      'wbfsys_task.http_url as "my_task_http_url"',
      'wbfsys_task.progress as "my_task_progress"',
      'wbfsys_task.id_type as "my_task_type_id_type"',
      'wbfsys_task_type.name as "wbfsys_task_type_name"',
      'wbfsys_task.id_status as "wbfsys_task_status_id_status"',
      'wbfsys_task_status.name as "wbfsys_task_status_name"',
      'wbfsys_task.rowid as "my_task_rowid"',
    );

    $criteria->select($cols);

  }//end public function setCols */

  /**
   * Injecten der Zieltabelle, sowie 
   * aller nötigen Joins zum laden der Daten
   *
   * Es werden jedoch nicht sofort alle möglichen Joins injiziert
   * Die Filter Methode hängt selbständig optionale Joins an, wenn
   * diese nicht schon geladen wurden jedoch zum filtern der Daten
   * benötigt werden
   *
   * @param LibSqlCriteria $criteria
   *
   * @return void
   */
  public function setTables( $criteria   )
  {

    $criteria->from('wbfsys_task');

    $criteria->leftJoinOn
    (
      'wbfsys_task',
      'id_type',
      'wbfsys_task_type',
      'rowid',
      null,
      'wbfsys_task_type'
    );// attribute reference wbfsys_task  by alias wbfsys_task_type

    $criteria->leftJoinOn
    (
      'wbfsys_task',
      'id_status',
      'wbfsys_task_status',
      'rowid',
      null,
      'wbfsys_task_status'
    );// attribute reference wbfsys_task  by alias wbfsys_task_status



  }//end public function setTables */

 /**
   * Leider gibt num_cols nur die Anzahl der tatsächlich gefundenen 
   * Datensätze zurück. Wenn Limit in der Query verwendet 
   * bringt diese Zahl dann nichtsmehr, wenn man eigentlich wissen 
   * möchte wieviele denn ohne limit gefunden worden wären.
   * 
   * Setzen der query mit der die anzahl der gefundenen datensätze ohne
   * limit ermittelt wird
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   * @return void
   */
  public function setCalcQuery( $criteria, $params )
  {

    if($params->loadFullSize)
      $this->calcQuery = $criteria->count('count(wbfsys_task.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function setCalcQuery */

  /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param TFlag $params
   * @return void
   */
  public function appendConditions( $criteria, $condition, $params )
  {


    // append codition if the query has a default filter
    if( $this->condition )
    {

      if( is_string($this->condition) )
      {

        if( ctype_digit($this->condition) )
        {
          $criteria->where( 'wbfsys_task.rowid = '.$this->condition );
        }
        else
        {
          $criteria->where( $this->condition );
        }

      }
      else if( is_array($this->condition) )
      {
        $this->checkConditions( $criteria, $this->condition  );
      }
    }

    if( $condition )
    {

      if( is_string( $condition) )
      {
        if( ctype_digit( $condition ) )
        {
          $criteria->where( 'wbfsys_task.rowid = '.$condition );
        }
        else
        {
          $criteria->where( $condition );
        }
      }
      else if( is_array( $condition ) )
      {
        $this->checkConditions( $criteria, $condition  );
      }
    }


    if( $params->begin )
    {
      $this->checkCharBegin( $criteria, $params );
    }

  }//end public function appendConditions */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @return void
   */
  public function checkConditions( $criteria, array $condition )
  {


      if( isset($condition['free']) && trim( $condition['free'] ) != ''  )
      {

         if( ctype_digit( $condition['free'] ) )
         {

            $part = $condition['free'];

            $criteria->where
            (
              '(
                  wbfsys_task.rowid = \''.$part.'\' 
              )'
            );
         }

      }//end if

      // search conditions for  wbfsys_task
      if( isset ($condition['wbfsys_task']) )
      {
        $whereCond = $condition['wbfsys_task'];

        if( isset($whereCond['title']) && trim($whereCond['title']) != ''  )
          $criteria->where( ' wbfsys_task.title = \''.$whereCond['title'].'\' ');

        if( isset($whereCond['http_url']) && trim($whereCond['http_url']) != ''  )
          $criteria->where( ' wbfsys_task.http_url = \''.$whereCond['http_url'].'\' ');

        if( isset($whereCond['id_type']) && count($whereCond['id_type']) )
          $criteria->where( " wbfsys_task.id_type IN( '".implode("','",$whereCond['id_type'])."' ) " );

        if( isset($whereCond['id_status']) && count($whereCond['id_status']) )
          $criteria->where( " wbfsys_task.id_status IN( '".implode("','",$whereCond['id_status'])."' ) " );

        // append meta information
        if( isset($whereCond['m_role_create']) && trim($whereCond['m_role_create']) != ''  )
          $criteria->where( ' wbfsys_task.m_role_create = '.$whereCond['m_role_create'].' ');

        if( isset($whereCond['m_role_change']) && trim($whereCond['m_role_change']) != ''  )
          $criteria->where( ' wbfsys_task.m_role_change = '.$whereCond['m_role_change'].' ');

        if( isset($whereCond['m_time_created_before']) && trim($whereCond['m_time_created_before']) != ''  )
          $criteria->where( ' wbfsys_task.m_time_created <= \''.$whereCond['m_time_created_before'].'\' ');

        if( isset($whereCond['m_time_created_after']) && trim($whereCond['m_time_created_after']) != ''  )
          $criteria->where( ' wbfsys_task.m_time_created >= \''.$whereCond['m_time_created_after'].'\' ');

        if( isset($whereCond['m_time_changed_before']) && trim($whereCond['m_time_changed_before']) != ''  )
          $criteria->where( ' wbfsys_task.m_time_changed <= \''.$whereCond['m_time_changed_before'].'\' ');

        if( isset($whereCond['m_time_changed_after']) && trim($whereCond['m_time_changed_after']) != ''  )
          $criteria->where( ' wbfsys_task.m_time_changed >= \''.$whereCond['m_time_changed_after'].'\' ');

        if( isset($whereCond['m_rowid']) && trim($whereCond['m_rowid']) != ''  )
          $criteria->where( ' wbfsys_task.rowid >= \''.$whereCond['m_rowid'].'\' ');

        if( isset($whereCond['m_uuid']) && trim($whereCond['m_uuid']) != ''  )
          $criteria->where( ' wbfsys_task.m_uuid >= \''.$whereCond['m_uuid'].'\' ');

      }//end if( isset ($condition['wbfsys_task']) )


  }//end public function checkConditions */

  /**
   * Loading the tabledata from the database
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function checkCharBegin( $criteria, $params )
  {

      // filter for a beginning char
      if( $params->begin )
      {

        if( '?' == $params->begin  )
        {
          $criteria->where( "wbfsys_task.m_parent ~* '^[^a-zA-Z]'" );
        }
        else
        {
          $criteria->where( "upper(substr(wbfsys_task.m_parent,1,1)) = '".strtoupper($params->begin)."'" );
        }

      }


  }//end public function checkCharBegin */

  /**
   * Limit, Offset und Order By daten in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param $params
   *
   * @return void
   */
  public function checkLimitAndOrder( $criteria, $params  )
  {


    // check if there is a given order
    if( $params->order )
    {
      $criteria->orderBy( $params->order );
    }
    else // if not use the default
    {
      $criteria->orderBy('wbfsys_task.rowid');
    }

    // Check the offset
    if( $params->start )
    {
      if( $params->start < 0)
        $params->start = 0;
    }
    else
    {
      $params->start = null;
    }
    $criteria->offset( $params->start );

    // Check the limit
    if( -1 == $params->qsize )
    {
      // no limit if -1
      $params->qsize = null;
    }
    else if( $params->qsize )
    {
      // limit must not be bigger than max, for no limit use -1
      if( $params->qsize > Wgt::$maxListSize )
        $params->qsize = Wgt::$maxListSize;
    }
    else
    {
      // if limit 0 or null use the default limit
      $params->qsize = Wgt::$defListSize;
    }

    $criteria->limit( $params->qsize );


  }//end public function checkLimitAndOrder */

  /**
   * Nur die sortierung in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param $params
   *
   * @return void
   */
  public function injectOrder( $criteria, $params  )
  {


    // check if there is a given order
    if( $params->order )
    {
      $criteria->orderBy( $params->order );
    }
    else // if not use the default
    {
      $criteria->orderBy('wbfsys_task.rowid');
    }


  }//end public function injectOrder */

  /**
   * Mit dieser Methode werden alle Filter, zB. aus einem Suchformular
   * bearbeitet und in die Query eingebaut
   *
   * Es werden nur Parameter verwendet die in der Logik definiert wurden
   * Weitere Parameter werden einfach ignoriert, so dass der Anwender
   * nicht einfach neue Filter hinzufügen kann
   *
   * @param LibSqlCriteria $criteria
   * @param $params
   *
   * @return void
   */
  public function appendFilter( $criteria, $params  )
  {
  
    $db = $this->getDb();

  }//end public function appendFilter */

}//end class MyTask_Table_Query

