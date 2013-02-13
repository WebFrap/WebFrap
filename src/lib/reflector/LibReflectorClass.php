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
 * A layer above the Base Reflection Class of PHP
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibReflectorClass
  extends ReflectionClass
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Enter description here...
   *
   * @param string $className
   */
  public function __construct( $className )
  {

    if( is_string($className) )
    {
      if(!Webfrap::loadable($className))
      {
        throw new Lib_Exception('Class: '.$className.' is not loadable!');
      }
    }

    parent::__construct( $className );

  }//end public function __construct( $className )


  /**
   * Enter description here...
   *
   * @param array $args
   * @return stdclass
   */
  public function getInstance( array $args = array() )
  {
    if($args)
    {
      return $this->newInstanceArgs($args);
    }
    else
    {
      return $this->newInstanceArgs();
    }
  }//end public function getInstance( array $args = array() )

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function getAllMethodNames( )
  {

    $methodes = array();

    foreach( $this->getMethods() as $method )
    {
      $methodes[] = $method->getName();
    }

    return $methodes;

  }//end public function getAllMethodNames( )



} // end class LibReflectorClass


