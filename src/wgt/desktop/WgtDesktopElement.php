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
 * @subpackage wgt
 */
abstract class WgtDesktopElement extends Base
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * sub Modul Extention
   * @var array
   */
  protected $models       = array();

  /**
   * sub Modul Extention
   * @var array
   */
  protected $assembledHtml    = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor and other Magics
//////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  public function __toString()
  {
    return $this->build();
  }

  /**
   */
  public function build()
  {
    return '';
  }

  /**
   * request the default action of the ControllerClass
   * @param string $modelName
   * @param string $key
   * @return Model
   */
  protected function loadModel($modelName , $key = null )
  {

    if (!$key )
      $key = $modelName;

    $modelName = 'Model'.$modelName;
    if (!isset($this->models[$key] ) )
    {
      if ( Webfrap::classLoadable($modelName) )
      {
        $this->models[$key] = new $modelName();
      } else {
        throw new Controller_Exception( 'Internal Error','Failed to load Submodul: '.$modelName );
      }
    }

    return $this->models[$key];

  }//end protected function loadModel */

  /**
   * @param string $key
   * @return Model
   */
  protected function getModel($key )
  {

    if ( isset($this->models[$key] ) )
      return $this->models[$key];
    else
      return null;

  }//end protected function getModel */


  /**
   * @param string $name
   * @param array $param
   * @param array $flag
   */
  public function image($name, $param, $flag )
  {
    return Wgt::image($name,$param,$flag);
  }//end public function image */

  /**
   * @param string $name
   * @param string $label
   * @param string $size
   * @param array $param
   * @return string
   */
  public function icon($name, $alt, $size = 'xsmall', $param = array() )
  {
    $param['alt'] = $alt;
    
    return Wgt::icon($name, $size, $param );
    
  }//end public function icon  */


} // end abstract class WgtDesktopElement

