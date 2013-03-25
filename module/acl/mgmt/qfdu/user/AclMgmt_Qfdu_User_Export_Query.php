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
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_User_Export_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $context
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch($areaId, $condition = null, $context = null)
  {

    if (!$context)
      $context = new Context();

    $context->qsize = -1;

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria  = $db->orm->newCriteria();
    $dsetEntiy = $db->orm->newEntity($this->domainNode->srcKey);

    $textKeys = $dsetEntiy->textKeys();
    $tableKey = $dsetEntiy->getTable();
    $fieldKeys = array();

    if ($textKeys) {
      foreach ($textKeys as $fieldName) {
        $fieldKeys[] = "{$tableKey}.{$fieldName}";
      }
    }

    $this->setCols($criteria, $tableKey, $fieldKeys);
    $this->setTables($criteria, $tableKey);
    $this->appendConditions($criteria, $areaId, $context  );


    // Run Query und save the result
    $this->result     = $db->orm->select($criteria);
    $this->calcQuery  = $criteria->count('count(DISTINCT group_users.rowid) as '.Db::Q_SIZE);

  }//end public function fetch */



 /** inject the requested cols in the criteria
   *
   * to add more cols overwrite this method, or create more methods that also
   * inject cols.
   * It't not expected that you try to remove a onetime setted col, so think
   * about what you are going to do.
   *
   * @param LibSqlCriteria $criteria
   * @param int $tableKey
   * @param array $textKeys
   * @return void
   */
  public function setCols($criteria, $tableKey, $textKeys)
  {

    $colSql = '';

    if ($textKeys) {
      $colSql = implode(" || ', ' ||  ", $textKeys).' as dset_text ';
    } else {
      $colSql = "'{$this->domainNode->label}: ' || {$tableKey}.rowid as dset_text ";
    }

    $cols = array
    (
      'group_users.date_start as date_start',
      'group_users.date_end as date_end',
      'role_group.name as "role_group_name"',
      "role_user.name || ' <' ||
      COALESCE
      (
        person.lastname || ', ' || person.firstname,
        person.lastname,
        person.firstname,
        ''
      ) || '>' as full_name",
      "role_user.rowid as user_id",
      "{$tableKey}.rowid as dset_id",
      $colSql
    );

    $criteria->select($cols, true);

     // check if there is a given order
    $criteria->orderBy
    (array(
      'full_name',
      'dset_text',
      'role_group.name',
    ));

    $this->structure = array
    (
      'full_name' => array('User', 'text', 40),
      'dset_text' => array($this->domainNode->label, 'text', 40),
      'role_group_name' => array('Group', 'text', 40),
      'date_start' => array('Start', 'date', 10),
      'date_end' => array('End', 'date', 10),
    );

  }//end public function setCols */

 /**
   * inject the table an join conditions in the criteria object
   * to append new join conditions overwrite this method, or create a second
   * method that injects more join conditions
   *
   * @param LibSqlCriteria $criteria
   * @param string $tableKey
   *
   * @return void
   */
  public function setTables($criteria, $tableKey)
  {

    $criteria->from('wbfsys_group_users group_users', 'group_users');

    $criteria->join
    (
      'JOIN wbfsys_role_group role_group
          ON group_users.id_group = role_group.rowid
      ',
      array('role_group')
    );

    $criteria->join
    (
      '
        JOIN wbfsys_role_user role_user
          ON group_users.id_user = role_user.rowid
        JOIN
          core_person person
            ON person.rowid = role_user.id_person
      ',
      array('role_user', 'person')
    );

    $criteria->join
    (
      '
        LEFT JOIN '.$tableKey.'
          ON group_users.vid = '.$tableKey.'.rowid
      ',
      array($tableKey)
    );

  }//end public function setTables */

  /** inject conditions in the criteria object
   *
   * this method checks if there where conditions that has to injected in the
   * criteria
   * if condition is a int value the method expects to get the rowid
   * if condition is a string, the system expects to get a query fragment
   * if condition is an array the variable is delegated to checkConditions to be
   *   interpreted by convention
   *
   * if there's a flag begin on $context the system expect that this is a char
   * that sould be used to filter by a beginning char
   *
   * @param LibSqlCriteria $criteria
   * @param int $areaId the area id
   * @param TFlag $context
   * @return void
   */
  public function appendConditions($criteria, $areaId, $context)
  {

    $criteria->where
    (
      "group_users.id_area={$areaId}
        and (group_users.partial = 0 or group_users.partial is null) "
    );

  }//end public function appendConditions */

} // end class AclMgmt_Qfdu_User_Export_Query */

