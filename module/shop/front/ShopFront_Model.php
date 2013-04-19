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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage ModShop
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class ShopFront_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  public $storeId = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $storeId
   */
  public function setStoreId($storeId)
  {

    $this->storeId = $storeId;

  }//end public function setStoreId */

  /**
   * @return int
   */
  public function getStoreId()
  {
    return $this->storeId;

  }//end public function getStoreId */

  /**
   * @return int
   */
  public function getDefStoreId()
  {

    $db     = $this->getDb();

    $sql = <<<SQL
SELECT store.rowid as store_id
  FROM shop_store store
  JOIN
    wbfsys_module_setting
      ON
        UPPER(wbfsys_module_setting.value) = UPPER(store.access_key)
          AND UPPER(wbfsys_module_setting.access_key) = UPPER('shop_def_page');

SQL;


    $id = $db->select($sql)->getField('store_id');

    $this->storeId = $id;

    return $this->storeId;

  }//end public function getDefStoreId */

  /**
   * @param int $idArticle
   * @return array
   */
  public function getArticleData($idArticle)
  {

    $db     = $this->getDb();

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
        AND article.rowid = {$idArticle};

SQL;

    return $db->select($sql)->get();

  }//end public function getArticleData */

  /**
   * @return ShopFront_MenuCategory_Query
   */
  public function getMenuCategories()
  {

    $db     = $this->getDb();

    /* @var $query ShopFront_MenuCategory_Query */
    $query  = $db->newQuery('ShopFront_MenuCategory');

    $query->fetch($this->storeId);

    return $query;

  }//end public function getMenuCategories */

  /**
   * @param string $key
   * @return ShopFront_MenuCategory_Query
   */
  public function getCategoryArticles($key)
  {

    $db     = $this->getDb();

    /* @var $query ShopFront_CategoryArticle_Query  */
    $query  = $db->newQuery('ShopFront_CategoryArticle');

    if (ctype_digit($key)) {
      $query->fetchById($key);
    } else {
      $query->fetchByKey($key, $this->storeId);
    }

    return $query;

  }//end public function getCategoryArticles */

  /**
   * @param array $ids
   * @return ShopFront_MenuCategory_Query
   */
  public function getArticlesByIds(array $ids)
  {

    $db     = $this->getDb();

    /* @var $query ShopFront_CategoryArticle_Query  */
    $query  = $db->newQuery('ShopFront_CategoryArticle');
    $query->fetchByIds($ids);

    return $query;

  }//end public function getCategoryArticles */

}//end class ShopFront_Model

