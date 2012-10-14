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
 * @subpackage tech_core
 */
abstract class WgtInputAbstract
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Das Label zum Inputelement
   * @var string
   */
  public $label = null;

  /**
   * ist das feld ein pflichtfeld
   * @var boolean
   */
  public $required = false;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param string $label
   * @param boolean $required
   * @return unknown_type
   */
  public function setLabel( $label, $required = false )
  {
    $this->label    = $label;
    $this->required = $required;
  }//end public function setLabel( $label, $required = false )

 /**
  * @param $data
  * @param $value
  * @return void
  */
  public function setData( $data , $value = null )
  {

    $this->attributes['value'] = $data;

  }// end public function setData */

  /** add Data to the Item
   *
   * @param string $key
   * @param array $value
   * @return void
   */
  public function addData( $key , $value = null )
  {
    $this->setData( $key );
  }//end public function addData */

 /**
  * @param mixed
  * @return void
  */
  public function getData( )
  {
    return isset($this->attributes['value'])?$this->attributes['value']:null;
  }// end public function getData */

 /**
  * @param mixed
  * @return void
  */
  public function value( )
  {
    return isset($this->attributes['value'])?$this->attributes['value']:null;
  }// end public function value */

  /**
   *
   * @param array $attributes
   * @return string
   */
  public abstract function build($attributes = array());


} // end class WgtInputAbstract
