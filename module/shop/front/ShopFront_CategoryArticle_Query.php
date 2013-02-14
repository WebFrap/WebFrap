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
class ShopFront_CategoryArticle_Query extends LibSqlTreeQuery
{ 
/*//////////////////////////////////////////////////////////////////////////////
// query elements table
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $id
   * 
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetchById($id )
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

    $this->result = $this->getDb()->select($sql );


  }//end public function fetchById */
  
  /**
   * @param string $key
   * @param int $storeId
   * 
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetchByKey($key, $storeId )
  {
    
    $sql = <<<SQL
    
    SELECT 
      article.rowid as article_id,
      article.title,
      article.access_key as article_number,
      price_b.price_brutto as price,
      article.short_desc as short_desc,
      article.description as description,
      tradeart.id_image as image,
      tradeart.article_number as article_number2
    FROM
      shop_article article 
    JOIN
      trade_article tradeart
        ON article.id_article = tradeart.rowid
    JOIN
      shop_article_category category
        ON article.id_category = category.rowid
    JOIN
      trade_price_bracket_article price_b
        ON article.id_article = price_b.id_article
    WHERE
      category.is_active = TRUE 
        AND article.is_active = TRUE
        AND upper(category.access_key) = upper('{$key}') ;
SQL;

    $this->data = $this->getDb()->select($sql )->getAll();
    
    Debug::console( 'Found Data '.count($this->data), $this->data );

//  article.access_key,
    
  }//end public function fetchByKey */
  
  /**
   * @param string $ids
   * @param int $storeId
   * 
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetchByIds( array $ids, $storeId )
  {
    
    
    if (!$ids )
    {
      $this->data = array();
      return;
    }
    
    $sqlIds = implode(', ', $ids);
    
    $sql = <<<SQL
    
    SELECT 
      article.rowid as article_id,
      article.title,
      article.access_key as article_number,
      price_b.price_brutto as price,
      article.short_desc as description,
      tradeart.id_image as image,
      tradeart.article_number as article_number2
    FROM
      shop_article article 
    JOIN
      trade_article tradeart
        ON article.id_article = tradeart.rowid
    JOIN
      shop_article_category category
        ON article.id_category = category.rowid
    JOIN
      trade_price_bracket_article price_b
        ON article.id_article = price_b.id_article
    WHERE
      category.is_active = TRUE 
        AND article.is_active = TRUE
        AND article.rowid = {$sqlIds} ;
SQL;

    $this->data = $this->getDb()->select($sql )->getAll();
    
    Debug::console( 'Found Data '.count($this->data), $this->data );

//  article.access_key,
    
  }//end public function fetchByKey */

}//end class ShopFront_CategoryArticle_Query

