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
 * @package WebFrap
 * @subpackage tech_core
 */
class LibFormatterFactory
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $languageData = array();

  /**
   * @var ObjFormatterFactory
   */
  protected $instance     = null;


/*//////////////////////////////////////////////////////////////////////////////
// Singleton Factory
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public static function createInstance()
  {
    self::$instance = new LibFormatterFactory();
  }//end public static function createInstance

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return
   */
  public static function getDateFormatter()
  {
    if( is_null( self::$instance ) )
    {
      self::createInstance();
    }


  }//end public static function getDateFormatter


} // end class LibFormatterFactory

