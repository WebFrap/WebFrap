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
class CmsMedia_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WbfsysMediathek_Entity
   */
  public $mediaThek = null;

  /**
   * @var array
   */
  public $images = array();

  /**
   * @var array
   */
  public $subImages = array();

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   */
  public function getImgSubs($key)
  {

    if (isset($this->subImages[$key]))
      return $this->subImages[$key];
    else
      return array();

  }//end public function getImgSubs */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   */
  public function loadMediathekByKey($key)
  {

    $orm = $this->getOrm();

    $this->mediaThek = $orm->getByKey('WbfsysMediathek', $key);

    if ($this->mediaThek) {
      $this->loadImages($this->mediaThek->getId());
    }

  }//end public function loadMediathekByKey */

/*//////////////////////////////////////////////////////////////////////////////
// Image Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $mediaThekId
   */
  public function loadImages($mediaThekId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

SELECT
  wbfsys_image.rowid as wbfsys_image_rowid,
  wbfsys_image_format.name as wbfsys_image_format_name,
  wbfsys_content_licence.name as wbfsys_content_licence_name,
  wbfsys_image.width as wbfsys_image_width,
  wbfsys_image.height as wbfsys_image_height,
  wbfsys_file.rowid as wbfsys_file_rowid,
  wbfsys_file.name as wbfsys_file_name,
  wbfsys_file.description as wbfsys_file_description

FROM
  wbfsys_image
    LEFT JOIN
      wbfsys_image_format
    ON
      wbfsys_image_format.rowid = wbfsys_image.id_format
    LEFT JOIN
      wbfsys_content_licence
    ON
      wbfsys_content_licence.rowid = wbfsys_image.id_licence
    JOIN
      wbfsys_file
    ON
      wbfsys_file.rowid = wbfsys_image.id_file
WHERE
  wbfsys_image.id_mediathek = {$mediaThekId};

SQL;

    $this->images = $db->select($sql)->getAll();

    $ids = array();
    foreach ($this->images as $img) {
      $ids[] = $img['wbfsys_image_rowid'];
    }

    $this->loadSubImages( $ids  );

  }//end public function getImages */

  /**
   * @param array $ids
   */
  protected function loadSubImages($ids)
  {

    $db = $this->getDb();

    $whereCond = implode(', ', $ids);

    $sql = <<<SQL

SELECT
  wbfsys_image.rowid as wbfsys_image_rowid,
  wbfsys_image.width as wbfsys_image_width,
  wbfsys_image.height as wbfsys_image_height,
  wbfsys_image.id_parent as wbfsys_image_id_parent,
  wbfsys_file.name as wbfsys_file_name,
  wbfsys_file.rowid as wbfsys_file_rowid,
  wbfsys_file.description as wbfsys_file_description

FROM
  wbfsys_image
      wbfsys_file
    ON
      wbfsys_file.rowid = wbfsys_image.id_file
WHERE
  wbfsys_image.id_parent = IN({$whereCond});

SQL;

    $images = $db->select($sql)->getAll();

    foreach ($images as $img) {
      $this->subImages[$img['wbfsys_image_id_parent']][] = $img;
    }

  }//end protected function loadSubImages */

} // end class CmsMedia_Model

