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
 * @subpackage ModCms
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class ShopFront_MenuCategory_Query
  extends LibSqlTreeQuery
{ 
////////////////////////////////////////////////////////////////////////////////
// query elements table
////////////////////////////////////////////////////////////////////////////////
    
 /**
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetchRoot( )
  {

    $this->data = null;
    
    $sql = <<<SQL
    
    SELECT 
      rowid,
      name,
      access_key,
      id_parent
    FROM
      shop_article_category
    WHERE
      is_active = TRUE
      and id_parent is null;    
SQL;

    $this->result = $this->getDb()->select( $sql );

  }//end public function fetchRoot */
  
 /**
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetchTree( )
  {
    
    $sql = <<<SQL
    
    SELECT 
      rowid,
      name,
      access_key,
      id_parent
    FROM
      shop_article_category
    WHERE
      is_active = TRUE
      and id_parent is null;    
SQL;

    $this->result = $this->getDb()->select( $sql );
    
    foreach( $this->result as $entry )
    {
      if( $entry['id_parent'] )
      {
        $this->childs[$entry['id_parent']][] = $entry;
      }
      else
      {
        $this->data[] = $entry;
      }
      
    }

  }//end public function fetchRoot */

}//end class ShopFront_MenuCategory_Query

