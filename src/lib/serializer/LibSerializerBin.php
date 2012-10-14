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
 * serializer to xml
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSerializerBin
  extends LibSerializerAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * instance of the
   *
   * @var ObjSerializerXml
   */
  private static $instance = null;

  /**
   *
   * @var array
   */
  protected $data      = array();


////////////////////////////////////////////////////////////////////////////////
// Singleton
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return ObjSerializerXml
   */
  public static function getInstance()
  {

  }
/* (non-PHPdoc)
 * @see LibSerializerAbstract::serialize()
 */
  public function serialize( $data = null )
  {

    // TODO Auto-generated method stub
    
  }
//end public static function getInstance()

////////////////////////////////////////////////////////////////////////////////
// Add Validator
////////////////////////////////////////////////////////////////////////////////


} // end class LibSerializerBin


