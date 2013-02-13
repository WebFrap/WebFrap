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
 * Basis Klasse für Widgets
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtWidget
  extends PBase
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
   * Enter description here ...
   * @var string
   */
  protected $jsCode       = null;
  
  /**
   * Der ID key des elements
   * @var string
   */
  public $idKey       = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor and other Magics
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return string
   */
  public function getIdKey()
  {
    
    if( is_null( $this->idKey ) )
      $this->idKey = Webfrap::uniqKey();
      
    return $this->idKey;
    
  }//end public function getIdKey */
  
  /**
   * @param string $idKey
   */
  public function setIdKey( $idKey )
  {
    $this->idKey = $idKey;
  }//end public function setIdKey */
  
  /**
   * request the default action of the ControllerClass
   *
   * @param string $modelKey
   * @param string $key
   *
   * @return Model
   */
  protected function loadModel( $modelKey , $key = null )
  {

    if(!$key)
      $key = $modelKey;

    $modelName    = $modelKey.'_Model';
    $modelNameOld = 'Model'.$modelKey;


    if( !isset( $this->models[$key]  ) )
    {
      if(!Webfrap::classLoadable($modelName))
      {

        $modelName = $modelNameOld;

        if(!Webfrap::classLoadable($modelName))
          throw new Controller_Exception('Internal Error','Failed to load Submodul: '.$modelName);

      }

      $this->models[$key] = new $modelName( $this );

    }

    return $this->models[$key];

  }//end protected function loadModel */

  /**
   * Getter für die in dem Widget vorhandenen Models
   *
   * @param string $key
   * @return Model
   */
  protected function getModel( $key )
  {

    if( isset( $this->models[$key] ) )
      return $this->models[$key];
    else
      return null;

  }//protected function getModel */
  
  /**
   * Methode wir beim initialisieren des Widgest aufgerufen
   */
  public function getJscode()
  {
    return $this->jsCode;
  }//end public function getJscode */


  /**
   * Methode wir beim initialisieren des Widgest aufgerufen
   */
  public function init()
  {
    return true;
  }

  /**
   * Methode wird nach dem Rendern des Widgets aufgerufen
   */
  public function shutdown(){}

} // end abstract class WgtWidget

