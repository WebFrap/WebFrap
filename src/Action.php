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
 * Static Interface to get the activ configuration object
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Action
  extends BaseChild
{
////////////////////////////////////////////////////////////////////////////////
// static attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Action Pool
   * @var array
   */
  public static $pool = array();
  
  /**
   * Array mit geladenen models
   * @var array
   */
  protected $models         = array();
  
////////////////////////////////////////////////////////////////////////////////
// pool logic
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * 
   * @param string $key
   * @param string $classname
   * 
   * @throws Lib_Exception
   */
  public static function getActionContainer( $key, $classname )
  {
    
    if( !isset( self::$pool[$key] ) )
    {
      if( !Webfrap::classLoadable( $classname ) )
      {
        throw new Lib_Exception( 'Requested nonexisting Action: '.$classname.' key '.$key );
      }
      else 
      {
        self::$pool[$key] = new $classname( WebFrap::$env );
      }
    }
    
    return self::$pool[$key];
    
  }//end public static function getActionContainer */
  
  /**
   * @param string $key
   * @param Model $model
   */
  public function setModel( $key, $model )
  {
    $this->models[$key] = $model;
  }//end public function setModel */
    
  /**
   * @param string $key
   * @return Model
   */
  public function getModel( $key )
  {
    if( isset( $this->models[$key] ) ) 
      return $this->models[$key];
    else
      return null;
      
  }//end public function setModel */
  
  /**
   * Eine Modelklasse laden
   * 
   * @param string $modelKey
   * @param string $key
   * 
   * @return Model
   * @throws ModelNotExists_Exception wenn das angefragt Modell nicht existiert
   */
  public function loadModel( $modelKey , $key = null )
  {

    if( !$key )
      $key = $modelKey;

    $modelName    = $modelKey.'_Model';

    if( !isset( $this->models[$key]  ) )
    {
      if( Webfrap::classLoadable( $modelName ) )
      {
        $model = new $modelName( $this );
        
        $this->models[$key] = $model;
      }
      else
      {
        throw new ModelNotExists_Exception
        (
          'Internal Error',
          'The requested model: '.$modelName.' not exists.'
        );
      }
    }

    return $this->models[$key];

  }//end public function loadModel */
  
////////////////////////////////////////////////////////////////////////////////
// default method
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param Entity $entity
   * @param Base $caller
   * /
  public function trigger( $entity, $caller )
  {
    
  }//end public function trigger */

}// end class Action
