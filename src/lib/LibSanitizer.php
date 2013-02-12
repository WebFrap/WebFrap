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
 * Bibliothek zum reinigen von potentiell gefährlichem Userinhalt
 * 
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSanitizer
{
  
  /**
   * @var LibSanitizerAdapter
   */
  private static $htmlAdapter = null;
  
  /**
   * @return LibSanitizerAdapter
   */
  public static function getHtmlSanitizer()
  {
    
    if( !self::$htmlAdapter )
    {
      self::$htmlAdapter = new LibSanitizer_Rudimental();
      
      /*
      if( Webfrap::classLoadable( 'LibVendorHtmlpurifier' ) )
      {
        // best solution!
        //self::$htmlAdapter = new LibVendor_Htmlpurifier();
        self::$htmlAdapter = new LibSanitizer_Rudimental();
      }
      else 
      {
        // well let's hope your users like you :-(
        self::$htmlAdapter = new LibSanitizer_Rudimental();
      }
      */
    }
    
    return self::$htmlAdapter;
    
  }//end public static function getHtmlSanitizer */
  
}//end class LibSanitizer

