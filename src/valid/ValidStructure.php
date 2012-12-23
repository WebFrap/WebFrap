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
 * @subpackage Validator
 */
class ValidStructure
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var array
   */
  public $data = array();
  
  /**
   * @var LibResponseHttp
   */
  public $response = null;
  
  /**
   * Flag ob es fehler gab
   * @var boolean
   */
  public $hasError = false;
  
////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var LibResponseHttp $response
   */
  public function __construct( $response )
  {
    $this->response = $response;
  }//end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// Method
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $message
   */
  public function addError( $message )
  {

    $this->hasError = true;
    $this->response->addError( $message );
    
  }//end public function addError */
  
  /**
   * @param string $key
   * @param string $subKey
   * @return array | null
   */
  public function getData( $key = null, $subKey = null )
  {
    
    if( !is_null( $subKey ) )
      return isset( $this->data[$key][$subKey] )?$this->data[$key][$subKey]:null;
      
    if( !is_null( $key ) )
      return isset( $this->data[$key] )?$this->data[$key]:array();
      
     return $this->data;
    
  }//end public function getData */

} // end class ValidStructure

