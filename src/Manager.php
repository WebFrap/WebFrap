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
 * @stateless bis auf Resource Objekte müssen Manager immer komplett Stateless sein
 *
 */
class Manager extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// pool logic
//////////////////////////////////////////////////////////////////////////////*/

  private static $managers = array();

  /**
   * @param PBase $env
   */
  public function __construct($env = null)
  {

  	if(!$env)
  		$env = Webfrap::$env;

    $this->env = $env;

  } //end public function __construct */

  /**
   * @param string $className
   * @param string $key
   * @return Manager
   */
  public static function get( $className, $key = null )
  {

    if (!$key)
      $key = $className;

    $className .= '_Manager';

    if(isset(self::$managers[$key])){
      return self::$managers[$key];
    }

    if(!Webfrap::classLoadable($className)){
      throw new ClassNotFound_Exception( 'There is no '.$className );
    }

    self::$managers[$key] = new $className( Webfrap::$env );

    return self::$managers[$key];

  }//end public static get */


}// end class Manager
