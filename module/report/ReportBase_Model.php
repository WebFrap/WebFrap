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
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class ReportBase_Model
  extends Model
{

  /**
   * @return int
   */
  public function getNumPersons( )
  {

    $db = $this->getDb();

    $query = <<<SQL

 select count(rowid) as num from core_person;

SQL;

    $res = $db->select($query);

    return $res->getField('num');

  }//end public function getNumPersons */

} // end class ReportBase_Model
