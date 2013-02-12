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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @author Malte Schirmacher <malte.schirmacher@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
abstract class TStruct
{
  
////////////////////////////////////////////////////////////////////////////////
// Magic Functions
////////////////////////////////////////////////////////////////////////////////
  

  /**
   * do not set to set unknown properties
   *
   * @param string $key          
   * @param unknown_type $value          
   */
  public function __set ( $key, $value )
  {
    
    throw new RuntimeException ( 'Property "' . $key . '" is unknown' );
  } // end of public function __set( $key , $value )
  

  /**
   * do not set to get unknown properties
   *
   * @param string $key          
   * @return unknown
   */
  public function __get ( $key )
  {
    
    throw new RuntimeException ( 'Property "' . $key . '" is unknown' );
  } // end of public function __get( $key )
  
} // end class TStruct

