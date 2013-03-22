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
class LibUploadMp3 extends LibUploadAdapter
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
  public function copyThumb()
  {

    if (is_null($this->thumbName)) {
      $newName = $this->thumbPath.'/'.$this->oldname;
    } else {
      $newName = $this->thumbPath.'/'.$this->thumbName;
    }

    if (!is_writeable($this->thumbPath)  ) {
      Error::addError
      (
      'Target Folder ist not writeable',
      'LibUploadException'
      );
    }

    $thumb = LibImageThumbFactory::getThumb($this->tmpname , $newName , '100' , '100');
    $thumb->genThumb();

    return true;

  }//end public function copy

  /**
   * Enter description here...
   *
   */
  public function deleteNewThumb()
  {

    if (is_null($this->thumbName)) {
      $newName = $this->thumbPath.'/'.$this->oldname;
    } else {
      $newName = $this->thumbPath.'/'.$this->thumbName;
    }

    if (!is_writeable($this->thumbPath)  ) {
      Error::addError
      (
      'Target Folder: '.$this->thumbPath.' ist not writeable!? or does not exist',
      'LibUploadException'
      );
    }

    if (!unlink($newName  )) {
      Error::addError
      (
      'Was not able to delete the created Thumbfile!?',
      'LibUploadException'
      );
    }

  }//end public function deleteNewThumb

} // end class LibUploadMp3

