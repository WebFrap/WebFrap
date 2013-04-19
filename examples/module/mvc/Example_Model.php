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
class Example_Model extends Model
{

  /**
   * @return array
   */
  public function performSearch()
  {

    $db = $this->getDb();

    $sql = <<<SQL

SELECT
  idx.name,
  idx.title,
  idx.access_key,
  idx.description,
  idx.vid,
  idx.m_role_create as creator,
  ent.default_edit as mask,
  ent.name as entity_label
FROM
  wbfsys_data_index idx
JOIN
  wbfsys_entity ent
    ON ent.rowid = idx.id_vid_entity

WHERE
  idx.name ilike '%{$this->searchKey}%'

LIMIT 10;

SQL;

    return $db->select($sql)->getAll();

  }//end public function performSearch */

} // end class WebfrapSearch_Model

