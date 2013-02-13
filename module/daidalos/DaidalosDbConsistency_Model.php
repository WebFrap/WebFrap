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
 * @subpackage Daidalos
 */
class DaidalosDbConsistency_Model
  extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   */
  public function fixAll()
  {

    $this->fixUserRoleEmployeeAsg();
    $this->fixRoleData();

  }//end public function fixAll */


  /**
   *
   */
  public function fixUserRoleEmployeeAsg()
  {

    $sql = <<<SQL
update wbfsys_role_user
  set id_employee =
  (
    select
      enterprise_employee.rowid
    from
      enterprise_employee
    join
      core_person person
        on enterprise_employee.id_person = person.rowid
    join
      wbfsys_role_user intern
        on intern.id_person = person.rowid
    where
      intern.rowid = wbfsys_role_user.rowid
    limit 1
  );
SQL;

    $this->getDb()->exec( $sql );

  }//end public function fixUserRoleEmployeeAsg */


  /**
   *
   */
  public function fixRoleData()
  {

    // fix level
    $sql = <<<SQL
update wbfsys_role_user
  set level = 25
  where level is null;
SQL;

    $this->getDb()->exec( $sql );


    $sql = <<<SQL
update wbfsys_role_group
  set level = 25
  where level is null;
SQL;

    $this->getDb()->exec( $sql );

    // fix Profile
    $sql = <<<SQL
update wbfsys_role_user
  set profile = 'Default'
  where profile is null;
SQL;

    $this->getDb()->exec( $sql );

    $sql = <<<SQL
update wbfsys_role_group
  set profile = 'Default'
  where profile is null;
SQL;

    $this->getDb()->exec( $sql );

  }//end public function fixRoleLevels */


}//end class ModelDaidalosSearch

