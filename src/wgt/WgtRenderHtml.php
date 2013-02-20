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
 * @subpackage tech_core
 */
abstract class WgtRenderHtml
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
   * backref to the owning view element
   * @var LibTemplate
   */
  public $view       = null;

/*//////////////////////////////////////////////////////////////////////////////
// Public Construct
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the to string method
   * @return string
   */
  public function __construct($view )
  {

    $this->view = $view;

  }// end public function __construct */

  /**
   * the to string method
   * @return string
   */
  public function __toString()
  {

    try {
      return $this->render();
    } catch ( Exception $e ) {

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
   * @param string $name
   * @param string $alt
   * @param string $size
   */
  public function icon($name, $alt, $size = 'xsmall' )
  {
    return Wgt::icon($name, $size, array('alt'=>$alt));
  }//end public function icon */

  /**
   * @param string $name
   * @param string $alt
   */
  public function image($name, $param, $flag = false )
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
  protected function asmAttributes($attributes = array() )
  {

    if (!$attributes)
      $attributes = $this->attributes;

    $html = '';

    if (!isset($attributes['id']))
      $attributes['id'] = 'wgt_item_'.uniqid();

    foreach($attributes as $key => $value )
      $html .= $key.'="'.$value.'" ';

    return $html;

  }// end protected function asmAttributes */

  /**
   * Enter description here...
   *
   * @return unknown
   */
  protected function buildToXmlAttributes()
  {

    $html = '';

    if (!isset($this->attributes['id']))
      $this->attributes['id'] = 'wgtitem_'.uniqid();

    $html .= ' id="'.$this->attributes['id'].'" ';

    if ( isset($this->attributes['value']) )
      $html .= ' value="'.$this->attributes['value'].'" ';

    if ( isset($this->attributes['title']) )
      $html .= 'title="'.$this->attributes['title'].'" ';

    return $html;

  }// end protected function asmAttributes */

  /**
   * convert the object to html
   *
   * @return string
   */
  public function toHtml( )
  {

    if ($this->assembled )
      return $this->html;
    else
      return $this->build( );

  } // end public function toHtml */

  /**
   * convert the object to html
   *
   * @return string
   */
  public function toXml( )
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

    if ($this->xml )
      return $this->xml;

    return $this->build();

  }//end public function buildAjaxArea */

}//end class WgtAbstract

