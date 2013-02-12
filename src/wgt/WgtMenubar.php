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
 * class Controller
 * Extention zum verwalten und erstellen von neuen Menus in der Applikation
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtMenubar
  extends Base
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * sub Modul Extention
   * @var array
   */
  protected $models       = array();

////////////////////////////////////////////////////////////////////////////////
// Constructor and other Magics
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

  /**
   * @return string
   */
  public function build()
  {
    return '';
  }//end public function build */

  /**
   * request the default action of the ControllerClass
   * @return Model
   */
  protected function loadModel( $modelName , $key = null )
  {

    if(!$key)
      $key = $modelName;

    $modelName = 'Model'.$modelName;
    if ( !isset( $this->models[$key]  ) ) {
      if (Webfrap::classLoadable($modelName)) {
        $this->models[$key] = new $modelName();
      } else {
        throw new Controller_Exception('Internal Error','Failed to load Submodul: '.$modelName);
      }
    }

    return $this->models[$key];

  }//end protected function loadModel */

  /**
   *
   * @param $key
   * @return Model
   */
  protected function getModel( $key )
  {

    if( isset( $this->models[$key] ) )

      return $this->models[$key];
    else
      return null;

  }//public function getModel */

} // end abstract class WgtMenubar
