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
class WebfrapMenu_Query
  extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// queries
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchMenuEntries( $menuKey , $params = null )
  {

    $this->sourceSize   = null;
    $db                 = $this->getDb();

    $query = <<<CODE

select
  entry.rowid ,
  entry.label ,
  entry.icon  ,
  entry.url   ,
  entry.access_key,
  entry.id_parent
from
  wbfsys_menu_entry entry
where
  entry.id_menu = {$menuKey}
order by
  entry.id_parent

CODE;


    // Run Query und save the result
    $this->result     = $db->select( $query );

  }//end public function fetchMenuEntries */



}//end class WebfrapMenu_Query

