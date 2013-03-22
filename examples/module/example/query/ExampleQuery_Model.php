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
 * @subpackage ModExample
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class ExampleQuery_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @return LibDbResult
  */
  public function runQuery()
  {

    $db = $this->getDb();
    $orm = $this->getOrm();

    $textPublic = $orm->newEntity('WbfsysText');
    $textPublic->access_key = 'text_public';
    $orm->insert($textPublic);

    $query =<<<QUERY

  select * from project_project_status;

QUERY;

    return $db->select($query)->getAll();

  }//end public function displayQuery */

}//end class ExampleMessage_Model

