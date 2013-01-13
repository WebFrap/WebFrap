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

  private $data = array();

  /**
   * @param string $key
   * @param string $value
   */
  public function __set( $key , $value )
  {
    $this->data[$key] = $value;
  }

  /**
   * @param string $key
   */
  public function __get( $key )
  {
    return isset( $this->data[$key] )?$this->data[$key]:null;
  }

}// end class WgtButton


