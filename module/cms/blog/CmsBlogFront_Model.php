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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class CmsBlogFront_Model extends Model
{

  /**
   * @param string $accessKey
   * @return CmsPage_Entity
   */
  public function getPage( $accessKey )
  {

    $orm = $this->getOrm();

    if( ctype_digit($accessKey) )
    {
      $entityPage = $orm->get( 'CmsPage', $accessKey );
    } else {
      $entityPage = $orm->getByKey( 'CmsPage', $accessKey );
    }

    return $entityPage;

  }//end public function getPage */

  /**
   * @param CmsPage_Entity $page
   * @return Entity
   */
  public function getTemplate( $page )
  {

    $orm = $this->getOrm();

    $entityTemplate = $orm->get( 'CmsTemplate', $page->id_template );

    return $entityTemplate;

  }//end public function getTemplate */


  /**
   * @param CmsTemplate_Entity $tplNode
   * @return Entity
   */
  public function getMenus( $tplNode )
  {

    $db = $this->getDb();

    $tmp = array();

    $sql = <<<SQL

select
  cms_template_menus.key,
  cms_menu.parsed_content as content
from
  cms_menu
    join
      cms_template_menus
    on
      cms_menu.rowid = cms_template_menus.id_menu
where
  cms_template_menus.id_template = {$tplNode}

SQL;

    $result = $db->select($sql);

    foreach( $result as $row )
    {
      $tmp[$row['key']] = $row['content'];
    }

    return $tmp;

  }//end public function getMenus */
  
  /**
   * @param CmsTemplate_Entity $tplNode
   * @return array
   */
  public function getAreas( $tplNode )
  {

    $db = $this->getDb();

    $tmp = array();

    $sql = <<<SQL

select
  cms_template_area.key,
  cms_area.parsed_content as content
from
  cms_template_area
    join
      cms_area
    on
      cms_area.rowid = cms_template_area.id_area
where
  cms_template_area.id_template = {$tplNode}

SQL;

    $result = $db->select($sql);

    foreach( $result as $row )
    {
      $tmp[$row['key']] = $row['content'];
    }

    return $tmp;

  }//end public function getAreas */


  /**
   * @param CmsTemplate_Entity $tplNode
   * @return Entity
   */
  public function getTexts( $tplNode )
  {

    $db = $this->getDb();

    $tmp = array();

    $sql = <<<SQL

select
  cms_template_texts.key,
  cms_text_node.content
from
  cms_text_node
    join
      cms_template_texts
    on
      cms_text_node.rowid = cms_template_texts.id_node
where
  cms_template_texts.id_template = {$tplNode}

SQL;

    $result = $db->select($sql);

    foreach( $result as $row )
    {
      $tmp[$row['key']] = $row['content'];
    }

    return $tmp;

  }//end public function getTexts */



} // end class CmsFront_Model

