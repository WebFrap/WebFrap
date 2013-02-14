<?php
/*******************************************************************************
* Webfrap.net Legion
*
* @author      : Dominik Bonsch <dominik.bonsch@s-db.de>
* @date        : @date@
* @copyright   : Softwareentwicklung Dominik Bonsch <contact@webfrap.de>
* @project     :
* @projectUrl  :
* @licence     : WebFrap.net
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage ModProject
 * @author Dominik Bonsch <dominik.bonsch@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <contact@webfrap.de>
 * @licence WebFrap.net
 */
class WebfrapProtocol_Overlay_Query extends LibSqlQuery
{

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

    if (!$params )
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria = new LibSqlCriteria( 'webfrap-protocol-overlay', $db );

    $this->setCols( $criteria );
    $this->setTables( $criteria );
    $this->appendConditions( $criteria, $condition, $params  );
    $this->checkLimitAndOrder( $criteria, $params );
    $this->appendFilter( $criteria, $condition, $params );

    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );

    if( $params->loadFullSize )
      $this->calcQuery = $criteria->count( 'count( DISTINCT wbfsys_protocol_message.rowid ) as '.Db::Q_SIZE );

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
    $this->injectOrder( $criteria, $params );

    $criteria->where
    (
      " wbfsys_protocol_message.rowid  IN( ". implode( ', ', array_keys($inKeys) ) ." )"
    );

    // Run Query und save the result
    $result    = $db->orm->select( $criteria );

    $this->data = array();

    foreach( $result as $row )
    {
      $row['acl-level'] = $inKeys[$row['log_rowid']];
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
      'DISTINCT wbfsys_protocol_message.rowid as "log_rowid"',
      'wbfsys_protocol_message.message as "log_content"',
      'wbfsys_role_user.name as "user_name"',
      'core_person.rowid as "person_id"',
      'core_person.firstname as "person_firstname"',
      'core_person.lastname as "person_lastname"',
      'wbfsys_protocol_message.m_time_created'
    );

    $criteria->select( $cols );

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

    $criteria->from( 'wbfsys_protocol_message' );

    $criteria->leftJoinOn
    (
      'wbfsys_protocol_message',
      'm_role_create',
      'wbfsys_role_user',
      'rowid',
      null,
      'wbfsys_role_user'
    );

    $criteria->leftJoinOn
    (
      'wbfsys_role_user',
      'id_person',
      'core_person',
      'rowid',
      null,
      'core_person'
    );

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

    if( $params->loadFullSize )
      $this->calcQuery = $criteria->count( 'count(DISTINCT wbfsys_protocol_message.rowid) as '.Db::Q_SIZE );

  }//end public function setCalcQuery */

  /**
   * Loading the tabledata from the database
   *
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

      if( is_string( $this->condition ) )
      {

        if( ctype_digit( $this->condition ) )
        {
          $criteria->where( 'wbfsys_protocol_message.rowid = '.$this->condition );
        }
        else
        {
          $criteria->where( $this->condition );
        }

      }
      else if( is_array( $this->condition ) )
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
          $criteria->where( 'wbfsys_protocol_message.rowid = '.$condition );
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

  }//end public function appendConditions */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   *
   * @return void
   */
  public function checkConditions( $criteria, array $condition )
  {


    	// in query wenn ids vorhanden sind
    	if( isset($condition['ids']) && !empty( $condition['ids'] ) )
    	{
				$criteria->where
	      (
	        'wbfsys_protocol_message.rowid IN( '. implode( ', ', $condition['ids'] ) .' ) '
	      );
    	}

    	if( isset( $condition['vid'] ) )
    	{
        $criteria->where( 'wbfsys_protocol_message.vid = '.$condition['vid'].'  ' );
    	}

    	if( isset( $condition['id_entity'] ) )
    	{
        $criteria->where( 'wbfsys_protocol_message.id_vid_entity = '.$condition['id_entity'].'  ' );
    	}

    	if( isset( $condition['id_mask'] ) )
    	{
        $criteria->where( 'wbfsys_protocol_message.id_mask = '.$condition['id_mask'].'  ' );
    	}


      if( isset($condition['free']) && trim( $condition['free'] ) != ''  )
      {

         // muss ein int sein, und darf nicht größer
         // als 9223372036854775807 sein
         if
         (
            ctype_digit( $condition['free'] )
              && strlen( $condition['free'] ) <= 20
         )
         {

            $part = $condition['free'];

            $criteria->where
            (
              '(  wbfsys_protocol_message.rowid = \''.$part.'\' )'
            );
         }
        else
        {

          // prüfen ob mehrere suchbegriffe kommagetrennt übergeben wurden
          if( strpos( $condition['free'], ',' ) )
          {

            $parts = explode( ',', $condition['free'] );

            foreach( $parts as $part )
            {

              $part = trim( $part );

              // prüfen, dass der string nicht leer ist
              if( '' == trim( $part ) )
                continue;

              /*
              $criteria->where
              ('(

                UPPER(trade_article.name) like UPPER(\'%'.$part.'%\')
              )');
							*/
           }

         }
         else
         {
           $part = $condition['free'];

           /*
           $criteria->where
           ('(

                UPPER(trade_article.name) like UPPER(\'%'.$part.'%\')
           )');
						*/
         }

      }

      }//end if

      // search conditions for  project_resource
      if( isset( $condition['wbfsys_protocol_message'] ) )
      {
        $whereCond = $condition['wbfsys_protocol_message'];

        /*
        if( isset( $whereCond['title']) && trim( $whereCond['title'] ) != ''  )
          $criteria->where( ' project_resource.title = \''.$whereCond['title'].'\' ');
				*/

        // append meta information
        if( isset( $whereCond['m_role_create' ]) && trim( $whereCond['m_role_create'] ) != ''  )
          $criteria->where( ' wbfsys_protocol_message.m_role_create = '.$whereCond['m_role_create'].' ');

        if( isset( $whereCond['m_time_created_before'] ) && trim( $whereCond['m_time_created_before'] ) != ''  )
          $criteria->where( ' wbfsys_protocol_message.m_time_created <= \''.$whereCond['m_time_created_before'].'\' ');

        if( isset( $whereCond['m_time_created_after'] ) && trim( $whereCond['m_time_created_after'] ) != ''  )
          $criteria->where( ' wbfsys_protocol_message.m_time_created >= \''.$whereCond['m_time_created_after'].'\' ');

      }//end if( isset ($condition['wbfsys_protocol_message']) )

  }//end public function checkConditions */



  /**
   * Limit, Offset und Order By daten in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function checkLimitAndOrder( $criteria, $params  )
  {

    // inject the default order
    /**/
    $criteria->orderBy( 'wbfsys_protocol_message.m_time_created' );
    $criteria->selectAlso( 'wbfsys_protocol_message.m_time_created as "wbfsys_protocol_message-m_time_created-order"' );


    // Check the offset
    if( $params->start )
    {
      if( $params->start < 0 )
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


    // inject the default order

    $criteria->orderBy( 'wbfsys_protocol_message.m_time_created' );
    $criteria->selectAlso( 'wbfsys_protocol_message.m_time_created as "wbfsys_protocol_message-m_time_created-order"' );

  }//end public function injectOrder */

  /**
   * Nur die sortierung in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param LibSqlCriteria $envelop
   * @param $params
   *
   * @return void
   */
  public function injectAclOrder( $criteria, $envelop, $params  )
  {


    // inject the default order
    /**/
    $criteria->orderBy( 'wbfsys_protocol_message.m_time_created' );
    $criteria->selectAlso( 'wbfsys_protocol_message.m_time_created as "wbfsys_protocol_message-m_time_created-order"' );

    $envelop->groupBy( 'inner_acl."wbfsys_protocol_message-m_time_created-order"' );
    $envelop->selectAlso( 'inner_acl."wbfsys_protocol_message-m_time_created-order"' );
    $envelop->orderBy( 'inner_acl."wbfsys_protocol_message-m_time_created-order"' );


  }//end public function injectAclOrder */

  /**
   * Limit, Offset und Order By daten in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function injectLimit( $criteria, $params  )
  {

    // Check the offset
    if( $params->start )
    {
      if( $params->start < 0 )
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

  }//end public function injectLimit */

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
  public function appendFilter( $criteria, $condition, $params  )
  {

    // laden der potentiell nötigen resource objekte
    $db    = $this->getDb();
    $user  = $this->getUser();
    $acl   = $this->getAcl();


  }//end public function appendFilter */

}//end class WebfrapHistory_Query

