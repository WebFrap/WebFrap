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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMessage_Table_Query extends LibSqlQuery
{

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
  public function setCalcQuery($criteria, $params)
  {

    if ($params->loadFullSize)
      $this->calcQuery = $criteria->count( 'count(wbfsys_message.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function setCalcQuery */

/*//////////////////////////////////////////////////////////////////////////////
// query elements table
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
  public function fetch($condition = null, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $user = $this->getUser();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    if (!$this->criteria) {
      $criteria = $db->orm->newCriteria();
    } else {
      $criteria = $this->criteria;
    }

    $this->setCols($criteria);

    $this->setTables($criteria);
    $this->appendConditions($criteria, $condition, $params);
    $this->checkLimitAndOrder($criteria, $params);
    $this->appendFilter($criteria, $condition, $params);

    // Run Query und save the result
    $this->result    = $db->orm->select($criteria);

    if ($params->loadFullSize)
      $this->calcQuery = $criteria->count( 'count(wbfsys_message.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */

 /**
   * Injecten der zu ladenden Columns in die SQL Query
   * Wenn bereits Colums vorhanden waren werden diese komplett
   * überschrieben
   * Wenn Columns ergänzt werden sollen, dann können diese mit
   * $criteria->selectAlso( 'additional.column');
   * übergeben werden
   *
   * @param LibSqlCriteria $criteria
   *
   * @return void
   */
  public function setCols($criteria)
  {

    $cols = array
    (
      'DISTINCT wbfsys_message.rowid as "wbfsys_message_rowid"',
      'wbfsys_message.title as "wbfsys_message_title"',
      'wbfsys_message.message as "wbfsys_message_message"',
      'wbfsys_message.priority as "wbfsys_message_priority"',
      'wbfsys_message.message_id as "wbfsys_message_message_id"',
      'wbfsys_message.id_refer as "wbfsys_message_id_refer"',
      'wbfsys_message.id_sender as "wbfsys_message_id_sender"',
      'wbfsys_message.id_receiver as "wbfsys_message_id_receiver"',
      'wbfsys_message.id_sender_status as "wbfsys_message_id_sender_status"',
      'wbfsys_message.id_receiver_status as "wbfsys_message_id_receiver_status"',
      'wbfsys_message.m_role_create as "wbfsys_message_m_role_create"',
      'wbfsys_message.m_time_created as "wbfsys_message_m_time_created"',
      'sender.core_person_lastname',
      'sender.core_person_firstname',
      'sender.wbfsys_role_user_name',
      'receiver.core_person_lastname as receiver_core_person_lastname',
      'receiver.core_person_firstname as receiver_core_person_firstname',
      'receiver.wbfsys_role_user_name as receiver_wbfsys_role_user_name',
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
  public function setTables($criteria )
  {

    $criteria->from( 'wbfsys_message');

    // der sender
    $criteria->joinOn
    (
      'wbfsys_message', 'id_sender',
      'view_person_role', 'wbfsys_role_user_rowid',
      null,
      'sender'
    );

    // der receiver
    $criteria->joinOn
    (
      'wbfsys_message', 'id_receiver',
      'view_person_role', 'wbfsys_role_user_rowid',
      null,
      'receiver'
    );

  }//end public function setTables */

  /**
   * Loading the tabledata from the database
   *
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param TFlag $params
   * @return void
   */
  public function appendConditions($criteria, $condition, $params)
  {

    // append codition if the query has a default filter
    if ($this->condition) {

      if ( is_string($this->condition)) {

        if ( ctype_digit($this->condition)) {
          $criteria->where( 'wbfsys_message.rowid = '.$this->condition);
        } else {
          $criteria->where($this->condition);
        }

      } elseif ( is_array($this->condition)) {
        $this->checkConditions($criteria, $this->condition);
      }

    }

    if ($condition) {

      if ( is_string($condition)) {
        if ( ctype_digit($condition)) {
          $criteria->where( 'wbfsys_message.rowid = '.$condition);
        } else {
          $criteria->where($condition);
        }
      } elseif ( is_array($condition)) {
        $this->checkConditions($criteria, $condition);
      }
    }

    if ($params->begin) {
      $this->checkCharBegin($criteria, $params);
    }

  }//end public function appendConditions */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   *
   * @return void
   */
  public function checkConditions($criteria, array $condition)
  {

    $db = $this->getDb();

    if ( isset($condition['free']) && trim($condition['free']) != '') {

       if ( ctype_digit($condition['free'])) {

          $part = $condition['free'];

          $criteria->where
          (
            '(
               wbfsys_message.rowid = \''.$part.'\'
            )'
          );
       } else {

          // prüfen ob mehrere suchbegriffe kommagetrennt übergeben wurden
          if ( strpos($condition['free'], ',')) {

            $parts = explode( ',', $condition['free']);

            foreach ($parts as $part) {

              $part = trim($part);

              // prüfen, dass der string nicht leer ist
              if ( '' ==  $part)
                continue;

              $safePart = $db->addSlashes($part);

              if ('@' == $safePart[0]) {
                $safePart = substr($safePart, 1);
                $criteria->where
                ('(
                  UPPER(sender.core_person_lastname) = UPPER(\''.$safePart.'\')
                    OR UPPER(sender.core_person_firstname) = UPPER(\''.$safePart.'\')
                    OR UPPER(sender.wbfsys_role_user_name) = UPPER(\''.$safePart.'\')
                )');
              } else {
                $criteria->where
                ('(

                  UPPER(wbfsys_message.title) like UPPER(\'%'.$safePart.'%\')
                    OR UPPER(wbfsys_message.message) like UPPER(\'%'.$safePart.'%\')
                )');
              }

           }

         } else {
           $safePart = $db->addSlashes($condition['free']) ;

           if ('@' == $safePart[0]) {
             $safePart = substr($safePart, 1);
             $criteria->where
             ('(
                UPPER(sender.core_person_lastname) = UPPER(\''.$safePart.'\')
                  OR UPPER(sender.core_person_firstname) = UPPER(\''.$safePart.'\')
                  OR UPPER(sender.wbfsys_role_user_name) = UPPER(\''.$safePart.'\')
             )');
           } else {
             $criteria->where
             ('(
                UPPER(wbfsys_message.title) like UPPER(\'%'.$safePart.'%\')
                  OR UPPER(wbfsys_message.message) like UPPER(\'%'.$safePart.'%\')
             )');
           }

         }

       }

    }//end if
      // search conditions for  wbfsys_message
      if ( isset($condition['wbfsys_message'])) {
        $whereCond = $condition['wbfsys_message'];

        if ( isset($whereCond['title']) && trim($whereCond['title']) != '')
          $criteria->where( ' wbfsys_message.title = \''.$whereCond['title'].'\' ');

        // append meta information
        if ( isset($whereCond['m_role_create']) && trim($whereCond['m_role_create']) != '')
          $criteria->where( ' wbfsys_message.m_role_create = '.$whereCond['m_role_create'].' ');

        if ( isset($whereCond['m_role_change']) && trim($whereCond['m_role_change']) != '')
          $criteria->where( ' wbfsys_message.m_role_change = '.$whereCond['m_role_change'].' ');

        if ( isset($whereCond['m_time_created_before']) && trim($whereCond['m_time_created_before']) != '')
          $criteria->where( ' wbfsys_message.m_time_created <= \''.$whereCond['m_time_created_before'].'\' ');

        if ( isset($whereCond['m_time_created_after']) && trim($whereCond['m_time_created_after']) != '')
          $criteria->where( ' wbfsys_message.m_time_created >= \''.$whereCond['m_time_created_after'].'\' ');

        if ( isset($whereCond['m_time_changed_before']) && trim($whereCond['m_time_changed_before']) != '')
          $criteria->where( ' wbfsys_message.m_time_changed <= \''.$whereCond['m_time_changed_before'].'\' ');

        if ( isset($whereCond['m_time_changed_after']) && trim($whereCond['m_time_changed_after']) != '')
          $criteria->where( ' wbfsys_message.m_time_changed >= \''.$whereCond['m_time_changed_after'].'\' ');

        if ( isset($whereCond['m_rowid']) && trim($whereCond['m_rowid']) != '')
          $criteria->where( ' wbfsys_message.rowid >= \''.$whereCond['m_rowid'].'\' ');

        if ( isset($whereCond['m_uuid']) && trim($whereCond['m_uuid']) != '')
          $criteria->where( ' wbfsys_message.m_uuid >= \''.$whereCond['m_uuid'].'\' ');

      }//end if ( isset ($condition['wbfsys_message']))

  }//end public function checkConditions */

  /**
   * Loading the tabledata from the database
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function checkCharBegin($criteria, $params)
  {

    // filter for a beginning char
    if ($params->begin) {

      if ('?' == $params->begin) {
        $criteria->where( "wbfsys_message.title ~* '^[^a-zA-Z]'");
      } else {
        $criteria->where( "upper(substr(wbfsys_message.title,1,1)) = '".strtoupper($params->begin)."'");
      }

    }

  }//end public function checkCharBegin */

  /**
   * Limit, Offset und Order By daten in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function checkLimitAndOrder($criteria, $params)
  {

    // check if there is a given order
    if ($params->order) {
      $criteria->orderBy($params->order);

    } else { // if not use the default
      $criteria->orderBy( 'wbfsys_message.m_time_created desc');

    }

    // Check the offset
    if ($params->start) {
      if ($params->start < 0)
        $params->start = 0;
    } else {
      $params->start = null;
    }
    $criteria->offset($params->start);

    // Check the limit
    if (-1 == $params->qsize) {
      // no limit if -1
      $params->qsize = null;
    } elseif ($params->qsize) {
      // limit must not be bigger than max, for no limit use -1
      if ($params->qsize > Wgt::$maxListSize)
        $params->qsize = Wgt::$maxListSize;
    } else {
      // if limit 0 or null use the default limit
      $params->qsize = Wgt::$defListSize;
    }

    $criteria->limit($params->qsize);

  }//end public function checkLimitAndOrder */

  /**
   * Nur die sortierung in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param $params
   *
   * @return void
   */
  public function injectOrder($criteria, $params)
  {

    $criteria->orderBy( 'wbfsys_message.m_time_created asc');

    return;

    // check if there is a given order
    if ($params->order) {
      $criteria->orderBy($params->order);
    } else { // if not use the default
      $criteria->orderBy( 'wbfsys_message.m_time_created desc');
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
  public function appendFilter($criteria, $condition, $params)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userId = $user->getId();

    Debug::console( '$condition', $condition);

    if (isset($condition['filters']['channel'])) {
      
    }

    if (!isset($condition['filters']['mailbox'])) {

      if (!$condition['filters']['archive']) {
        $criteria->where
        (
          " (
              wbfsys_message.id_receiver = " .$userId."
              AND
              (
                wbfsys_message.id_receiver_status IN( ".EMessageStatus::IS_NEW.", ".EMessageStatus::OPEN.")
                OR
                wbfsys_message.id_receiver_status IS NULL
              )
            )
              or
            (
              wbfsys_message.id_sender = ".$userId."
                and
              (
                wbfsys_message.id_sender_status IN( ".EMessageStatus::IS_NEW.", ".EMessageStatus::OPEN.")
                OR
                wbfsys_message.id_sender_status IS NULL
              )
            )
          "
        );
      } else {
        $criteria->where
        (
          "
            (
              wbfsys_message.id_receiver = " .$userId."
              AND
              wbfsys_message.flag_receiver_deleted = false
            )
            or
            (
              wbfsys_message.id_sender = ".$userId."
              AND
              wbfsys_message.flag_sender_deleted = false
            )
          "
        );
      }

    } else {
      if ('in' == $condition['filters']['mailbox']) {

        Debug::console( 'FILTER IN');

        if (!$condition['filters']['archive']) {
          $criteria->where
          (
            " (
                wbfsys_message.id_receiver = " .$user->getId()."
                  AND
                (
                  wbfsys_message.id_receiver_status IN( ".EMessageStatus::IS_NEW.", ".EMessageStatus::OPEN.")
                  OR
                  wbfsys_message.id_receiver_status IS NULL
                )
                AND
                  wbfsys_message.flag_receiver_deleted = false
              )
            "
          );
        } else {
          $criteria->where
          (
            "
              wbfsys_message.id_receiver = " .$userId." AND wbfsys_message.flag_receiver_deleted = false
            "
          );
        }
      } elseif ('out' == $condition['filters']['mailbox']) {

        Debug::console( 'FILTER out');

        if (!$condition['filters']['archive']) {
          $criteria->where
          (
            "
              (
                wbfsys_message.id_sender = ".$userId."
                  AND
                (
                  wbfsys_message.id_sender_status IN( ".EMessageStatus::IS_NEW.", ".EMessageStatus::OPEN.")
                  OR
                  wbfsys_message.id_sender_status IS NULL
                 )
                AND
                  wbfsys_message.flag_sender_deleted = false

              )
            "
          );
        } else {
          $criteria->where
          (
            "
              wbfsys_message.id_sender = ".$userId."
              AND
                  wbfsys_message.flag_sender_deleted = false
            "
          );
        }

      } else {

        Debug::console( 'FILTER both');

        if (!$condition['filters']['archive']) {
          $criteria->where
          (
            " (
                wbfsys_message.id_receiver = " .$userId."
                  AND
                (
                  wbfsys_message.id_receiver_status IN( ".EMessageStatus::IS_NEW.", ".EMessageStatus::OPEN.")
                  OR
                  wbfsys_message.id_receiver_status is NULL
                )
                AND
                  wbfsys_message.flag_receiver_deleted = false
              )
                OR
              (
                wbfsys_message.id_sender = ".$userId."
                AND
                (
                  wbfsys_message.id_sender_status IN( ".EMessageStatus::IS_NEW.", ".EMessageStatus::OPEN." )
                  OR
                  wbfsys_message.id_sender_status IS NULL
                )
                AND
                  wbfsys_message.flag_sender_deleted = false
              )
            "
          );
        } else {
          $criteria->where
          (
            "
              ( wbfsys_message.id_receiver = " .$userId." AND wbfsys_message.flag_receiver_deleted = false)
                or
              ( wbfsys_message.id_sender = ".$userId." AND wbfsys_message.flag_sender_deleted = false)
            "
          );
        }

      }
    }

  }//end public function appendFilter */

}// end class WbfsysMessage_Widget_Query_Postgresql

