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
 *
 */
class TUrl
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $arrtibutes = array();

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlDesign    = URL_DESIGN;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlEndSep    = URL_END_SEP;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlParamSep  = URL_PARAM_SEP;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlValueSep  = URL_VALUE_SEP;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlTitleSep  = URL_TITLE_SEP;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlFile = 'index.php';

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlParams = array();

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlTitle = null;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $urlAnchor = null;

  /**
   * Enter description here...
   *
   * @var array
   */
  protected static $fileMap = array
  (
  'index.php' => array('sys','.html'),
  'ajax.php'  => array('ajax','.xml'),
  'get.php'   => array('file',''),
  );

  /**
   * persistent parameters that will be used in every created url
   *
   * @var array
   */
  protected static $persistentParam = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $file
   */
  public function setFile($file)
  {
    $this->urlFile = $file;
  }//end public function setFile($file)

  /**
   * Enter description here...
   *
   * @param unknown_type $params
   */
  public function addParams($params)
  {
    $this->urlParams = array_merge($this->urlParams,$params);
  }//end public function addParams($params)

  /**
   * Enter description here...
   *
   */
  public function cleanParams()
  {
    $this->urlFile   = 'index.php';
    $this->urlParams = array();

  }//end public function cleanParams()

  /**
   * Enter description here...
   *
   * @param unknown_type $title
   */
  public function setTitle($title)
  {
    $this->urlTitle = $title;
  }//end public function setTitle($title)

  /**
   * set the url anchor
   *
   * @param string $anchor
   */
  public function setAnchor($anchor)
  {
    $this->urlAnchor = $anchor;
  }//end public function setAnchor($anchor)

  /**
   * Enter description here...
   *
   */
  public static function cleanPersistentParams()
  {
    self::$persistentParam = array();
  }//end public static function cleanPersistentParams()

  /**
   * Enter description here...
   *
   * @param string/array $key
   * @param string[optional] $value
   */
  public static function addPersistentParams($key , $value = null)
  {
    if (is_array($key)) {
      self::$persistentParam = array_merge(self::$persistentParam,$key);
    } else {
      self::$persistentParam[$key] = $value;
    }
  }

/*//////////////////////////////////////////////////////////////////////////////
// Static Methodes
///////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @return String
   */
  public function toUrl($file = null , $params = array() , $title = null , $anchor = null)
  {
    if (Log::$levelDebug)
     Log::start(__file__,__line__,__method__,array($file, $params, $title, $anchor));

    $file = $file?$file:$this->urlFile;

    $params = $params?$params:$this->urlParams;
    $params = array_merge(self::$persistentParam,$params);
    $title = $title?$title:$this->urlTitle;
    $anchor = $anchor?$anchor:$this->urlAnchor;

    return self::asUrl($file,$params,$title,$anchor);

  }//end public function toUrl()

/*//////////////////////////////////////////////////////////////////////////////
// Static Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * map to url
   *
   * @param string $filename
   * @param array $attributes
   * @param string $title
   * @param string $anchor
   * @return string
   */
  public static function asUrl($filename , $attributes , $title = null , $anchor = null)
  {
    if (Log::$levelDebug)
     Log::start(__file__,__line__,__method__,array($filename , $attributes , $title, $anchor));

    $attributes = array_merge(self::$persistentParam,$attributes);

    if (URL_DESIGN) {
      $url ='';

      $map = self::getDesignedData($filename);

      $url .= $map[0]
        .self::asmAttributes($attributes)
        .self::buildTitle($title)
        .$map[1]
        .self::buildAnchor($anchor);

      return $url;
    } else {
      return $filename.self::asmAttributes($attributes).self::buildAnchor($anchor);
    }

  }//end public static function asUrl($filename , $attributes , $title = null , $anchor = null)

  /**
   * Enter description here...
   *
   * @param unknown_type $filename
   * @return unknown
   */
  protected static function getDesignedData($filename)
  {
    if (isset(self::$fileMap[$filename])) {
       return self::$fileMap[$filename];
    } else {
      return array($filename,'');
    }
  }//end protected static function getDesignedData($filename)

  /**
   * Enter description here...
   *
   * @param unknown_type $attributes
   * @return unknown
   */
  protected static function asmAttributes($attributes)
  {
    if (Log::$levelDebug)
     Log::start(__file__,__line__,__method__,array($attributes));

    if (URL_DESIGN) {
      if ($attributes) {
        $params = URL_START_SEP;
        foreach ($attributes as $name => $param) {
           $params .= $name.URL_VALUE_SEP.$param.URL_PARAM_SEP;
        }

        return substr($params ,0, -1).URL_END_SEP;
      } else {
        return URL_START_SEP.URL_END_SEP;
      }
    } else {
      $params = '?';
      foreach ($attributes as $name => $param) {
         $params .= $name.'='.$param.'&';
      }

      return substr($params ,0, -1);
    }

  }//end public static function asmAttributes($attributes)

  /**
   * Enter description here...
   *
   * @param unknown_type $title
   * @return unknown
   */
  protected static function buildTitle($title)
  {

    if (trim($title) == '') {
      return 'Webfrap';
    } else {

      $parts = explode(' ',$title);

      $assembled = '';

      foreach ($parts as $part) {
        $assembled .= $part.URL_TITLE_SEP;
      }

      return substr($assembled,0,-1);
    }

  }//end protected static function buildTitle($title)

  /**
   * Enter description here...
   *
   * @param string $anchor
   * @return string
   */
  protected static function buildAnchor($anchor)
  {
    if (Log::$levelDebug)
     Log::start(__file__,__line__,__method__,array($anchor));

    return trim($anchor) != '' ? '#'.$anchor : '';

  }//end protected static function buildAnchor($anchor)

}//end class TUrl

