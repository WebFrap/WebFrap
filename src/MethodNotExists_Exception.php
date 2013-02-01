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
 * Always Thrown If A Class Not Exists
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class MethodNotExists_Exception
  extends WebfrapSys_Exception
{
  
  /**
   * @param string $object
   * @param string $message
   * @param string $arguments
   */
  public function __construct( $object, $method, $arguments = array() )
  {

    $message = 'The method '.$method.' not exists on class '.get_class($object).' args: '.implode( ', ', array_keys($arguments) ) ;
    
    parent::__construct( $message );


  }//end public function __construct */
  
}//end class MethodNotExists_Exception 



