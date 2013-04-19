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
class Example_Query extends LibSqlQuery
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
    $db                = $this->getDb();

    $sql = <<<SQL
  SELECT
    project_activity.rowid as id,
    project_activity.name as value

  FROM
    project_activity

  WHERE
    upper(project_activity.name) like upper('{$db->addSlashes($key)}%')
  LIMIT 10

SQL;

    $this->result = $db->select($sql);

  }//end public function fetchAutocomplete */

}//end class Example_Query

