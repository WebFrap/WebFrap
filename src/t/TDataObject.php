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
class TDataObject
{

  /** Der Inhalt des Knotens
   */
  public $content  = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  public function __construct($content = array())
  {

    if ($anz = func_num_args()) {
      if ($anz == 1 and is_array(func_get_arg(0))) {
        $this->content = func_get_arg(0);
      } else {
        // hier kommt auf jeden fall ein Array
        $this->content = func_get_args();
      }
    }

  } // end of member function __construct

  /**
   * Enter description here...
   *
   * @param string $key
   * @param unknown_type $value
   */
  public function __set($key , $value)
  {
    $this->content[$key] = $value;
  }// end of public function __set($key , $value)

  /**
   * Enter description here...
   *
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    return isset($this->content[$key])?$this->content[$key]:null;
  }// end of public function __get($key)

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param mixed $content
   */
  public function setData(array $content)
  {
    $this->content = $content;
  }//end public function setContent($content)

  /**
   * Enter description here...
   *
   * @param mixed $content
   */
  public function addData(array $content)
  {
    $this->content = array_merge($this->content ,  $content);
  }//end public function addContent($content)

  /**
   * Enter description here...
   *
   * @param string $key
   * @return mixed
   */
  public function getData($key, $fallback = null)
  {
    return isset($this->content[$key])
      ? $this->content[$key]
      : $fallback;
  }//end public function getData */

  /**
   * @param string $key
   * @param string $fallback
   * @return mixed
   */
  public function value($key, $fallback = null)
  {
    return isset($this->content[$key])
      ? $this->content[$key]
      : $fallback;

  }//end public function value */

  /**
   * @param string $key
   */
  public function getMoney($key, $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return number_format($this->content[$key] , 2 , ',' , '.') ;
    } else {
      return null;
    }

  } // end of member function getData

  /**
   * @param string $key
   */
  public function getHtml($key, $fallback = null   )
  {

    if (isset($this->content[$key])) {
      return html_entity_decode($this->content[$key]) ;
    } else {
      return null;
    }

  } // end public function getHtml */

  /**
   * @param string key
   */
  public function getNumeric($key, $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return number_format($this->content[$key] , 2 , ',' , '.') ;
    } else {
      return null;
    }

  } // end public function getNumeric */

  /**
   * @param string key
   */
  public function getChecked($key , $subkey = null)
  {

    if (isset($this->content[$key])) {
      if ($subkey) {
        if ($this->content[$key] == $subkey)
          return ' checked="checked" ';
      } else {
        if ($this->content[$key])
          return ' checked="checked" ';
      }
    }

    return '';

  } // end public function getChecked */

  /**
   * @param string $key
   */
  public function getDate($key , $format = 'd.m.Y', $fallback = null   )
  {

    if (isset($this->content[$key])) {
      return date($format , strtotime($this->content[$key])) ;
    } else {
      return null;
    }

  }//end  public function getDate  */

  /**
   * @param string $key
   */
  public function getTime($key , $format = 'H:i:s', $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return date($format , strtotime($this->content[$key])) ;
    } else {
      return null;
    }

  }//end public function getTime  */

  /**
   * @param string $key
   */
  public function getTimestamp($key , $format =   'd.m.Y H:i:s', $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return date($format , strtotime($this->content[$key])) ;
    } else {
      return null;
    }

  }//end public function getTimestamp  */

  /**
   * @return void
   */
  public function reset()
  {
    $this->content = array();
  }//end public function reset  */

} // end class TDataObject

