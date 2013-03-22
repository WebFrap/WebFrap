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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAuth_Query extends LibSqlQuery
{

 /**
   * Loading the tabledata from the database
   * @param string $email
   * @return array
   */
  public function dataUserByEmail($email  )
  {

    $db       = $this->getDb();
    $criteria = $db->orm->newCriteria();
    $criteria->select('wbfsys_role_user.*')->from('wbfsys_role_user');

    $criteria->joinOn
    (
      'wbfsys_role_user',     // the base table
      'rowid',                // id in base table (here we always join the pk of base)
      'wbfsys_address_item',  // the join table
      'id_user'               // id for the join
    );

    $criteria->joinOn
    (
      'wbfsys_address_item',      // the base table
      'id_type',                    // id in base table (here we always join the pk of base)
      'wbfsys_address_item_type', // the join table
      'rowid'                   // id for the join
    );

    //Wenn ein Standard Condition gesetzt wurde dann kommt diese in die Query
    $criteria->where
    (
      " upper(wbfsys_address_item.address_value) = upper('{$email}')
          and upper(wbfsys_address_item_type.access_key) = upper('mail') "
    );

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);

    return $this->get();

  }//end public function dataUserByEmail */

}//end class ProjectIspcatsImport_Query

