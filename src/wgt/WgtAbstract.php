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
 * @lang de:
 *
 *
 * @package WebFrap
 * @subpackage wgt
 */
abstract class WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * Die HTML Id des WGT Elements
   *
   * @var string
   */
  public $id            = null;

  /**
   * this is the name of the object which indentifies it in templates
   * @var string
   */
  public $name          = null;

  /**
   * should the item refresh the html on the browser in an ajax call
   * @var string
   */
  public $refresh       = null;

  /**
   * JavaScript Code soweit vorhanden
   * @var string
   */
  public $jsCode        = null;

  /**
   *
   * @var string
   */
  public $width        = null;

  /**
   *
   * @var string
   */
  public $height        = null;

  /**
   * @var array
   */
  public $classes      = array();

  /**
   * backref to the owning view element
   * @var LibTemplate
   */
  public $view       = null;

  /**
   * the i18n object
   * @var LibI18nAbstract
   */
  public $i18n       = null;

  /**
   * Ein Environment object
   * @var Base
   */
  public $env       = null;

  /**
   * Modell wenn vorhanden
   * @var Model
   */
  public $model       = null;

  /**
   * Access container
   * @var LibAclPermission
   */
  public $access       = null;

  /**
   * Steuerflags zum customizen des elements
   * @var TArray
   */
  public $flags = null;

  /**
   * @var array
   */
  public $attributes = array();
  
  
/*//////////////////////////////////////////////////////////////////////////////
// Protected Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * data structur for the item
   * @var array
   */
  protected $data       = null;

  /**
   * the assembled html (for caching or what ever)
   * @var string
   */
  protected $html       = '';

  /**
   * Check ob das element schon gebaut wurde
   * @todo checken ob wir das so wollen
   * @var string
   */
  protected $assembled  = false;

  /**
   * xml string for ajax
   * @var string
   */
  protected $xml        = '';

/*//////////////////////////////////////////////////////////////////////////////
// Constructors and Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name = null)
  {

    $this->name = $name;
    $this->init();

  } // end public function __construct */

  /**
   * the to string method
   * @return string
   */
  public function __toString()
  {

    try {
      
      return $this->build();
      
    } catch (Exception $e) {

      $this->html = '<b>failed to create</b>';

      Error::report
      (
        'failed to build wgt item: '.get_class($this),
        $e
      );

      if (Log::$levelDebug)
        return '<b>failed to create: '.get_class($this).'</b>';
      else
        return '<b>failed to create</b>';

    }

  }// end public function __toString */

  /**
   * Magic Setter für den Zugriff auf die Html Attribute eines Items
   *
   * @param string $key
   * @param string $value
   * @deprecated
   */
  public function __set($key , $value)
  {

    if (is_array($value)) {
      $this->attributes = array_merge($this->attributes , $value);
    } else {
      $this->attributes[$key] = $value;
    }

  }//end public function __set */

  /**
   * Magic Getter zum Auslesen der Html Attribute eines Items
   *
   * @param string $key
   * @return string
   * @deprecated
   */
  public function __get($key)
  {

    if (isset($this->attributes[$key])) {
      return $this->attributes[$key];
    } else {
      return null;
    }

  }//end public function __get */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * get the id of the wgt object
   * @return string
   */
  public function getId()
  {

    if (isset($this->attributes['id'])) {
      return $this->attributes['id'];
    } else {
      $this->attributes['id'] = 'wgt-item-'.uniqid();

      return $this->attributes['id'];
    }

  }//end public function getId */

  public function setId($id)
  {
    $this->id = $id;

    if (!isset($this->attributes['id']))
      $this->attributes['id'] = $id;
  }

  /** request Item Name
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  } // end public function getName */

  /** add Data to the Item
   *
   * @param string $key
   * @param array $value
   * @param boolean[optinal] $multi
   * @return void
   */
  public function addData($key, $value = null)
  {

    if (is_array($key)) {
      $this->data = array_merge($this->data, $key) ;
    } elseif (!is_null($value)) {
      $this->data[$key] = $value;
    } elseif (is_object($key) && $key instanceof LibSqlQuery) {
      $this->data = $key;
    } else {
      $this->data[] = $key;
    }

  } // end public function addData */

  /**
   * Setter für die im Element darzustellenden Daten
   *
   * @param array/string $key
   * @param mixed $value
   */
  public function setData($key, $value = null)
  {

    if (!is_null($value))
      $this->data = array((string) $key => $value);
    else
      $this->data = $key;

  }// end public function setData */

  /** adding new attributes
   *
   * @param mixed(string,array) $name
   * @param string[optinal] $data
   * @return void
   */
  public function addAttributes($name, $data  = null)
  {

    if (is_array($name)) {
      $this->attributes = array_merge($this->attributes , $name);
    } else {
      $this->attributes[$name] = $data ;
    }

  } // end public function addAttributes  */

  /** adding new attributes
   *
   * @param array $attributes
   * @return void
   */
  public function setAttributes($attributes)
  {

    $this->attributes = $attributes;

  } // end public function setAttributes  */

  /** adding new attributes
   *
   * @param string[optional] $key
   * @return mixed
   */
  public function getAttributes($key = null)
  {

    if (is_null($key))
      return $this->attributes;
    else
      return isset($this->attributes[$key]) ? $this->attributes[$key] : null ;

  } // end public function getAttributes */

  /**
   * Add a Class to the Item, not just overwrite the class Attribute
   *
   * @param string $className
   */
  public function addClass($className)
  {

    ///TODO implement a remove Class method
    if (!isset($this->attributes['class']))
      $this->attributes['class'] = $className;
    else
      $this->attributes['class'] .= ' '.$className;

  }//end public function addClass */

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {

    if (!$this->i18n)
      $this->i18n = I18n::getActive();

    return $this->i18n;

  }//end public function getI18n */

  /**
   * this ist the init method, use this method insteat of the constructor
   * if you want to initialize you object
   * the constructor will call init
   *
   */
  public function init()
  {

  }//end public function init */

  /**
   * set the item to readonly
   *
   * @param boolean $readOnly
   */
  public function setReadOnly($readOnly = true)
  {
    if ($readOnly) {
      $this->attributes['disabled'] = 'disabled';
      $this->attributes['readonly'] = 'readonly';
    } else {
      if (isset($this->attributes['disabled']))
        unset($this->attributes['disabled']);

      if (isset($this->attributes['readonly']))
        unset($this->attributes['readonly']);
    }

  }//end public function setReadOnly */

  /**
   * @return string
   */
  public function getJscode()
  {
    return $this->jsCode;
  }//end public function getJscode */

  /**
   * @param LibTemplate
   */
  public function injectJsCode($view)
  {

    if (!$this->jsCode)
      $this->buildJsCode();

    if ($this->jsCode){
      Debug::console("inject JS CODE ".$this->jsCode);
      $view->addJsCode($this->jsCode);
    } else {
      Debug::console("no code to inject");
    }


  }//end public function getJscode */

  /**
   * @param string $width
   */
  public function setWidth($width)
  {
    $this->width = $width;
  }//end public function setWidth */

  /**
   * @param string $height
   */
  public function setHeight($height)
  {
    $this->height = $height.'_height';
  }//end public function setHeight */

  /**
   * @param string $name
   * @param string $alt
   * @param string $size
   */
  public function icon($name, $alt, $size = 'xsmall', $attributes = array())
  {

    $attributes['alt'] = $alt;

    return Wgt::icon($name, $size, $attributes);

  }//end public function icon */

  /**
   * @param string $name
   * @param string $alt
   * @param string $size
   */
  public function iconUrl($name, $size = 'xsmall')
  {
    return Wgt::iconUrl($name, $size);

  }//end public function iconUrl */

  /**
   * @param string $name
   * @param string $param
   * @param boolean $flag
   */
  public function image($name, $param, $flag = false)
  {
    return Wgt::image($name, array('alt'=>$param),true);

  }//end public function image */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the attributes
   * @return String
   */
  protected function asmAttributes($attributes = array())
  {

    if (!$attributes)
      $attributes = $this->attributes;

    $html = '';

    if (!isset($attributes['id']))
      $attributes['id'] = 'wgt_item_'.uniqid();

    foreach($attributes as $key => $value)
      $html .= $key.'="'.$value.'" ';

    return $html;

  }// end protected function asmAttributes */

  /**
   * @return string
   */
  protected function buildToXmlAttributes()
  {

    $html = '';

    if (!isset($this->attributes['id']))
      $this->attributes['id'] = 'wgtitem_'.uniqid();

    $html .= ' id="'.$this->attributes['id'].'" ';

    if (isset($this->attributes['value']))
      $html .= ' value="'.$this->attributes['value'].'" ';

    if (isset($this->attributes['title']))
      $html .= 'title="'.$this->attributes['title'].'" ';

    return $html;

  }// end protected function asmAttributes */

  /**
   * convert the object to html
   *
   * @return string
   */
  public function toHtml()
  {

    if ($this->assembled)
      return $this->html;
    else
      return $this->build();

  } // end public function toHtml */

  /**
   * convert the object to html
   *
   * @return string
   */
  public function toXml()
  {

    if ($this->assembled) {
      return $this->xml;
    } else {
      return $this->buildAjaxArea();
    }

  }//end public function toXml */

  /**
   * Mapper Methode um paseAjax einfach zu implementieren
   *
   * @return string
   */
  public function buildAjaxArea()
  {

    if ($this->xml)
      return $this->xml;

    return $this->build();

  }//end public function buildAjaxArea */

  /**
   * Rückgabe von debugdaten welche helfen sollen den Ort eines Fehlers
   * leichter zu finden
   *
   * @return string
   */
  public function debugData()
  {
    return get_class($this)." name ".$this->name;
  }//end public function debugData */

  /**
   * @return string
   */
  public function build()
  {
    return $this->render();
  }//end public function build */

  /**
   * Methode zum bauen des Javascript codes für das UI Element.
   *
   * Dieser kann / soll in die aktuelle view injected werden
   *
   * @return string
   */
  public function buildJsCode()
  {

  }//end public function buildJsCode */

  /**
   * @return string
   */
  public function render($params = null)
  {
    return '<p>Sombody forgott to overwrite render</p>';

  }//end public function render */

}//end class WgtAbstract

