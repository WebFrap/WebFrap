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
abstract class WgtFrontend
{

  /**
   * @var Model
   */
  protected $model = null;
  
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->render();
  }//end public function __toString */
  
  /**
   * 
   */
  public function setModel($model )
  {
    $this->model = $model;
  }//end public function setModel */
  
  /**
   * @param string $name
   * @param string $alt
   * @param string $size
   */
  public function icon($name, $alt, $size = 'xsmall' )
  {
    
    return Wgt::icon($name, $size, array('alt'=>$alt) );
    
  }//end public function icon */

  /**
   * @param string $name
   * @param string $param
   * @param boolean $flag
   */
  public function image($name, $param, $flag = false )
  {
    
    return Wgt::image($name, array('alt'=>$param),true);
    
  }//end public function image */
  
  /**
   * @param LibTemplate $view
   * @param WgtTemplate $body
   */
  public abstract function render($view, $body );


}//end class WgtFrontend

