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
 * @subpackage Modprofiles
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyAnnouncement_Widget_Query_Postgresql extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// setter
//////////////////////////////////////////////////////////////////////////////*/

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
      $this->calcQuery = $criteria->count('count(wbfsys_announcement.'.Db::PK.') as '.Db::Q_SIZE);

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
  public function fetch($user, $condition = null, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria = $db->orm->newCriteria();
    $this->criteria = $criteria;

    $this->setCols($criteria);

    $this->setTables($criteria);
    $this->appendConditions($criteria, $condition, $params  );
    $this->checkLimitAndOrder($criteria, $params);
    $this->appendFilter($criteria, $condition, $params);

    $criteria->where('wbfsys_announcement_channel_subscription.id_role = '.$user->getId());

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);

    if ($params->loadFullSize)
      $this->calcQuery = $criteria->count('count(wbfsys_announcement.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */

  /**
   * Injecten der zu ladenden Columns in die SQL Query
   * Wenn bereits Colums vorhanden waren werden diese komplett
   * überschrieben
   * Wenn Columns ergänzt werden sollen, dann können diese mit
   * $criteria->selectAlso('additional.column');
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
      'DISTINCT wbfsys_announcement.rowid as "wbfsys_announcement_rowid"',
      'wbfsys_announcement.title as "wbfsys_announcement_title"',
      'wbfsys_announcement.message as "wbfsys_announcement_message"',
      'wbfsys_announcement.importance as "wbfsys_announcement_importance"',
      'wbfsys_announcement.m_time_created as "wbfsys_announcement_m_time_created"',
      'wbfsys_announcement_type.name as "wbfsys_announcement_type_name"',
      'wbfsys_announcement.id_type as "wbfsys_announcement_id_type"',
      'wbfsys_announcement_channel.name as "wbfsys_announcement_channel_name"',
      'wbfsys_announcement_access_status.value as "wbfsys_announcement_access_status_value"',
      'view_person_role.core_person_firstname',
      'view_person_role.core_person_lastname',
      'view_person_role.wbfsys_role_user_name',
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
  public function setTables($criteria   )
  {

    $user = $this->getUser();

    $criteria->from('wbfsys_announcement');

    $criteria->leftJoinOn
    (
      'wbfsys_announcement',
      'id_type',
      'wbfsys_announcement_type',
      'rowid',
      null,
      'wbfsys_announcement_type'
    );

    $criteria->leftJoinOn
    (
      'wbfsys_announcement',
      'id_channel',
      'wbfsys_announcement_channel',
      'rowid',
      null,
      'wbfsys_announcement_channel'
    );

    $criteria->leftJoinOn
    (
      'wbfsys_announcement',
      'rowid',
      'wbfsys_announcement_access_status',
      'id_announcement',
      'wbfsys_announcement_access_status.id_user = '.$user->getId(),
      'wbfsys_announcement_access_status'
    );

    $criteria->leftJoinOn
    (
      'wbfsys_announcement',
      'm_role_create',
      'view_person_role',
      'wbfsys_role_user_rowid',
      null,
      'view_person_role'
    );

    $criteria->leftJoinOn
    (
      'wbfsys_announcement_channel',
      'rowid',
      'wbfsys_announcement_channel_subscription',
      'id_channel',
      null,
      'wbfsys_announcement_channel_subscription'
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

      if (is_string($this->condition)) {

        if (ctype_digit($this->condition)) {
          $criteria->where('wbfsys_announcement.rowid = '.$this->condition);
        } else {
          $criteria->where($this->condition);
        }

      } elseif (is_array($this->condition)) {
        $this->checkConditions($criteria, $this->condition  );
      }

    }

    if ($condition) {

      if (is_string($condition)) {
        if (ctype_digit($condition)) {
          $criteria->where('wbfsys_announcement.rowid = '.$condition);
        } else {
          $criteria->where($condition);
        }
      } elseif (is_array($condition)) {
        $this->checkConditions($criteria, $condition  );
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

    if (isset($condition['free']) && trim($condition['free']) != ''  ) {

       if (ctype_digit($condition['free'])) {

          $part = $condition['free'];

          $criteria->where
          (
            '(
               wbfsys_announcement.rowid = \''.$part.'\'
            )'
          );
       } else {

          // prüfen ob mehrere suchbegriffe kommagetrennt übergeben wurden
          if (strpos($condition['free'], ',')) {

            $parts = explode(',', $condition['free']);

            foreach ($parts as $part) {

              $part = trim($part);

              // prüfen, dass der string nicht leer ist
              if ('' ==  $part)
                continue;

              $safePart = $db->addSlashes($part);

              if ('@' == $safePart[0]) {
                $safePart = substr($safePart, 1);
                $criteria->where
                ('(
                  UPPER(wbfsys_announcement_channel.name) = UPPER(\''.$safePart.'\')
                )');
              } else {
                $criteria->where
                ('(

                  UPPER(wbfsys_announcement.title) like UPPER(\'%'.$safePart.'%\')
                    OR UPPER(wbfsys_announcement.message) like UPPER(\'%'.$safePart.'%\')
                )');
              }

           }

         } else {
           $safePart = $db->addSlashes($condition['free']) ;

           if ('@' == $safePart[0]) {
             $safePart = substr($safePart, 1);
             $criteria->where
             ('(
               UPPER(wbfsys_announcement_channel.name) = UPPER(\''.$safePart.'\')
             )');
           } else {
             $criteria->where
             ('(
                UPPER(wbfsys_announcement.title) like UPPER(\'%'.$safePart.'%\')
                 OR UPPER(wbfsys_announcement.message) like UPPER(\'%'.$safePart.'%\')
             )');
           }

         }

       }

    }//end if

    // search conditions for  wbfsys_announcement
    if (isset($condition['wbfsys_announcement'])) {
      $whereCond = $condition['wbfsys_announcement'];

      if (isset($whereCond['title']) && trim($whereCond['title']) != ''  )
        $criteria->where(' wbfsys_announcement.title = \''.$whereCond['title'].'\' ');

      if (isset($whereCond['id_type']) && count($whereCond['id_type']))
        $criteria->where(" wbfsys_announcement.id_type IN('".implode("','",$whereCond['id_type'])."') ");

      // append meta information
      if (isset($whereCond['m_role_create']) && trim($whereCond['m_role_create']) != ''  )
        $criteria->where(' wbfsys_announcement.m_role_create = '.$whereCond['m_role_create'].' ');

      if (isset($whereCond['m_role_change']) && trim($whereCond['m_role_change']) != ''  )
        $criteria->where(' wbfsys_announcement.m_role_change = '.$whereCond['m_role_change'].' ');

      if (isset($whereCond['m_time_created_before']) && trim($whereCond['m_time_created_before']) != ''  )
        $criteria->where(' wbfsys_announcement.m_time_created <= \''.$whereCond['m_time_created_before'].'\' ');

      if (isset($whereCond['m_time_created_after']) && trim($whereCond['m_time_created_after']) != ''  )
        $criteria->where(' wbfsys_announcement.m_time_created >= \''.$whereCond['m_time_created_after'].'\' ');

      if (isset($whereCond['m_time_changed_before']) && trim($whereCond['m_time_changed_before']) != ''  )
        $criteria->where(' wbfsys_announcement.m_time_changed <= \''.$whereCond['m_time_changed_before'].'\' ');

      if (isset($whereCond['m_time_changed_after']) && trim($whereCond['m_time_changed_after']) != ''  )
        $criteria->where(' wbfsys_announcement.m_time_changed >= \''.$whereCond['m_time_changed_after'].'\' ');

      if (isset($whereCond['m_rowid']) && trim($whereCond['m_rowid']) != ''  )
        $criteria->where(' wbfsys_announcement.rowid >= \''.$whereCond['m_rowid'].'\' ');

      if (isset($whereCond['m_uuid']) && trim($whereCond['m_uuid']) != ''  )
        $criteria->where(' wbfsys_announcement.m_uuid >= \''.$whereCond['m_uuid'].'\' ');

    }//end if (isset ($condition['wbfsys_announcement']))

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
        $criteria->where("wbfsys_announcement.title ~* '^[^a-zA-Z]'");
      } else {
        $criteria->where("upper(substr(wbfsys_announcement.title,1,1)) = '".strtoupper($params->begin)."'");
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
  public function checkLimitAndOrder($criteria, $params  )
  {

    // check if there is a given order
    if ($params->order) {
      $criteria->orderBy($params->order);

    } else { // if not use the default
      $criteria->orderBy('wbfsys_announcement.m_time_created desc');

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
      $params->qsize = 12;
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
  public function injectOrder($criteria, $params  )
  {

    // check if there is a given order
    if ($params->order) {
      $criteria->orderBy($params->order);
    } else { // if not use the default
      $criteria->orderBy('wbfsys_announcement.m_time_created desc');
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
  public function appendFilter($criteria, $condition, $params  )
  {

    $db = $this->getDb();
    $user = $this->getUser();

    if (isset($condition['filters']['important'])) {
      $filterOnlyImportant= $db->newFilter
      (
        'MyAnnouncement_Widget_Table_OnlyImportant'
      );
      $filterOnlyImportant->inject($criteria, $params);
    }

    if (isset($condition['filters']['archive'])) {
      $filterActive = $db->newFilter
      (
        'MyAnnouncement_Widget_Table_Archive'
      );
      $filterActive->inject($criteria, $params);
    }

  }//end public function appendFilter */

}// end class WbfsysAnnouncement_Widget_Query_Postgresql

