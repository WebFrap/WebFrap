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
 * @subpackage Mvc
 */
abstract class MvcModel
  extends BaseChild
{
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Die vorhadenen Registry keys
   * @var array
   */
  protected $regKeys  = array();

  /**
   * sub Modul Extention
   * @var array
   */
  protected $subModels       = array();

  /**
   * Error Object zum sammeln von Fehlermeldungen
   * @var Error
   */
  protected $error = null;

////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param Base $env
   */
  public function __construct( $env = null )
  {

    if( !$env )
      $env = Webfrap::getActive();

    $this->env = $env;

    $this->getRegistry();

    if( DEBUG )
      Debug::console( 'Load model '.get_class( $this ) );

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// registry methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * get data from the registry of the model
   * @param string $key
   * @return mixed
   */
  public function getRegisterd( $key )
  {
    return isset($this->registry[$key])
      ?$this->registry[$key]
      :null;

  }//end public function getRegisterd */

  /**
   * a data to the registry in the model
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function register( $key, $value )
  {
    $this->regKeys[$key]  = true;
    $this->registry[$key] = $value;
  }//end public function register */

  /**
   * a data to the registry in the model
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function protocol( $message, $context = null, $object = null, $mask = null )
  {

    $this->getResponse()->protocol( $message, $context, $object, $mask );

  }//end public function protocol */

  /**
   * @param string $type
   * @param mixed $where
   * @return Entity
   */
  public function getGenericEntity( $type, $where )
  {
    return $this->getOrm()->get( $type, $where );

  }//end public function getGenericEntity */

  /**
   * Die Registry leeren
   * @return void
   */
  public function reset(  )
  {

    if( !$this->regKeys )

      return;

    if ( $keys = array_keys( $this->regKeys ) ) {
      foreach ($keys as $key) {
        if( isset( $this->registry[$key] ) )
          unset( $this->registry[$key] );
      }
    }

  }//end public function reset */

  /**
   * request the default action of the ControllerClass
   * @param string $modelKey
   * @param string $key
   * @return Model
   */
  public function loadModel( $modelKey, $key = null )
  {

    if(!$key)
      $key = $modelKey;

    $modelName    = $modelKey.'_Model';
    $modelNameOld = 'Model'.$modelKey;

    if ( !isset( $this->subModels[$key]  ) ) {
      if ( !Webfrap::classLoadable($modelName) ) {
        $modelName = $modelNameOld;
        if ( !Webfrap::classLoadable($modelName) ) {
          throw new Controller_Exception( 'Internal Error', 'Failed to load Submodul: '.$modelName );
        }
      }

      $this->subModels[$key] = new $modelName( $this );

    }

    return $this->subModels[$key];

  }//end public function loadModel */

  /**
   *
   * @param string $key
   * @return Model
   */
  public function getModel( $key )
  {

    if( isset( $this->subModels[$key] ) )

      return $this->subModels[$key];
    else
      return null;

  }//public function getModel */

} // end abstract class Model
