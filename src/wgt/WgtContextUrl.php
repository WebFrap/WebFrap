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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage wgt
 */
class WgtContextUrl
{

  /**
   * @var array
   */
  private $data = array();

  /**
   * @param string $key
   * @param string $value
   */
  public function __set( $key , $value )
  {
    $this->data[$key] = $value;
  }//end public function __set

  /**
   * @param string $key
   */
  public function __get( $key )
  {
    return isset( $this->data[$key] )?$this->data[$key]:null;
  }//end public function __get */
  
  /**
   * @return string
   */
  public function build( $htmlEnc = false )
  {
    
    $html = '';
    
    $sep = $htmlEnc ? '&amp;' : '&';
    
    
    foreach( $this->data as $key => $value )
    {
      $html .= $sep.$key."=".$value;
    }
    
    return $html;
    
  }//end public function build */
  
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

}// end class WgtButton


