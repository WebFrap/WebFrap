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
 * @subpackage tech_core
 */
class LibUploadImage extends LibUploadAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var string $thumbPath
   */
  protected $thumbPath = null;

  /**
   * Enter description here...
   *
   * @var string $thumbName
   */
  protected $thumbName = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public function setThumbPath($thumbPath)
  {
    $this->thumbPath = $thumbPath;
  }//end public function setThumbPath

  /**
   * Enter description here...
   *
   */
  public function setThumbName($thumbName)
  {
    $this->thumbName = $thumbName;
  }//end public function setThumbPath

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * Enter description here...
   *
   */
  public function thumb($newName = null , $thumbPath = null , $x = 100, $y = 100)
  {

    if ($thumbPath) {
      $this->thumbPath = $thumbPath;
    }
    if (!$this->thumbPath) {
      $this->thumbPath = PATH_UPLOADS.'images/thumb/';
    }

    if ($newName) {
      $this->thumbName = $newName;
    }

    return $this->convert($this->thumbName, $this->thumbPath , $x, $y);

  }//end public function copyThumb($newName = null)

  /**
   * Enter description here...
   *
   * @param unknown_type $newName
   * @param unknown_type $thumbPath
   * @param unknown_type $x
   * @param unknown_type $y
   * @return unknown
   */
  public function convert($newname = null , $newpath = null , $x = 640, $y = 480)
  {

    if ($newpath) {
      $this->newpath = $newpath;
    }

    if ($newname) {
      $this->newname = $newname;
    }

    if (!$this->newpath) {
      $this->newpath = PATH_UPLOADS.'images/';
    }

    if (is_null($this->newname)) {
      $newname = $this->newpath.'/'.$this->oldname;
    } else {
      $newname = $this->newpath.'/'.$this->newname;
    }

    // Wenn der Ordner nicht existiert, einfach versuchen zu erstellen
    if (!is_dir($this->newpath)) {
      if (!SFilesystem::mkdir($this->newpath)) {
        throw new LibUploadException( 'Failed to create Folder: '.$this->newpath );
      }
    }

    // Falls der Ordner nicht beschreibbar ist Fehler werfen
    if (!is_writeable($this->newpath)) {
      throw new LibUploadException('Target Folder :  '.$this->newpath.' is not writeable');
    }

    $thumb = LibImageThumbFactory::getThumb($this->tmpname , $newname , $x , $y);

    $thumb->genThumb();

    $this->copies[] = $newname;

    return $newname;

  }//end public function convert($newname = null)

} // end class LibUploadImage

