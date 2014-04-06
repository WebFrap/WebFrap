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
 * class LibImageThumbAdapter
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class LibImageThumbAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Original Name des Bildes
   * @var string
   */
  public $origName = null;

  /**
   * Name des späteren thumbs
   * @var string
   */
  public $thumbName = null;

  /**
   * die maximale höhe
   * @var int
   */
  public $maxHeight = 100;

  /**
   * die maximale breite
   * @var int
   */
  public $maxWidth = 100;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $origName
   * @param string $thumbName
   * @param string $maxWidth
   * @param string $maxHeight
   */
  public function __construct($origName = null, $thumbName = null, $maxWidth = null, $maxHeight = null)
  {

    if ($origName) {
      $this->origName = $origName;
    }

    if ($thumbName) {
      $this->thumbName = $thumbName;
    }

    if ($maxWidth) {
      $this->maxWidth = $maxWidth;
    }

    if ($maxHeight) {
      $this->maxHeight = $maxHeight;
    }

  }//end public function __construct

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $origName
   */
  public function setOrigname($origName)
  {
    $this->origName = $origName;

  }//end public function setOrigname

  /**
   * @param string $thumbName
   */
  public function setThumbName($thumbName)
  {
    $this->thumbName = $thumbName;

  }//end public function setThumbName

  /**
   * @param string $maxHeight
   */
  public function setMaxHeight($maxHeight)
  {
    $this->maxHeight = $maxHeight;

  }//end public function setMaxHeight

  /**
   * @param string $maxWidth
   */
  public function setMaxWidth($maxWidth)
  {
    $this->maxWidth = $maxWidth;

  }//end public function setMaxWidth

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  abstract public function genThumb();

}// end abstract class LibImageThumbAdapter

