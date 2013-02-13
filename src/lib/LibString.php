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
 * Bibliothek zum manipulieren von Strings
 * 
 * @package WebFrap
 * @subpackage tech_core
 * 
 * @stateless Diese Klasse ist komplett stateless
 *  Alle informatione müssen als Parameter übergeben werden.
 *  Daher ist hier ein default object erlaub. 
 * 
 */
class LibString
{
/*//////////////////////////////////////////////////////////////////////////////
// Weiches Singleton Pattern 
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Standard instanz
   * @var LibString
   */
  private static $defInstance = null;
  
  /**
   * 
   * @return LibString
   */
  public static function getDefault()
  {
    
    if(!self::$defInstance)
      self::$defInstance = new LibString;
      
    return self::$defInstance;
      
  }//end public static function getDefault */
  
  
/*//////////////////////////////////////////////////////////////////////////////
// Logik
//////////////////////////////////////////////////////////////////////////////*/
  
  
  

} // end class LibString


