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
 * Exception to throw if you want to throw an unspecific Exception inside the
 * bussines logic.
 * If you don't catch it it will be catched by the system and you will get an
 * Error Screen Inside the Applikation.
 *
 * @package WebFrap
 * @subpackage Example
 */
class WebfrapCalendar_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Loading the tabledata from the database
   * @param string $key
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchAutocomplete($key)
  {

    $this->sourceSize  = null;
    $db               = $this->getDb();

    $sql = <<<SQL
  SELECT
    wbfsys_role_user_rowid as id,
    wbfsys_role_user_name || ' <' || core_person_lastname || ', ' || core_person_firstname || '>'  as value

  FROM
    view_person_role

  WHERE
    UPPER(wbfsys_role_user_name) like UPPER('{$db->addSlashes($key)}%')
      OR UPPER(core_person_lastname) like UPPER('{$db->addSlashes($key)}%')
      OR UPPER(core_person_lastname) like UPPER('{$db->addSlashes($key)}%')

  LIMIT 10

SQL;

    $this->result = $db->select($sql);

  }//end public function WebfrapMessage_Query */

}//end class Example_Query

