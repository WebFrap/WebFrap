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
 */
class LibSettingsNode
{

  /**
   * @var stdClass
   */
  private $node = null;

  /**
   * @param string $jsonData
   */
  public function __construct( $jsonData = null )
  {

    if( !is_null($jsonData) )
      $this->node = json_decode($jsonData);
    else
      $this->node = new stdClass();

  }//end public function __construct */

  /**
   * @param string $key
   * @param string $value
   */
  public function __set( $key, $value )
  {

    $this->node->{$key} = $value;

  }//end public function __set */

  /**
   * @param string $key
   */
  public function __get( $key )
  {

    return isset($this->node->{$key})
      ? $this->node->{$key}
      : null;

  }//end public function __get */

}// end class LibSettingsNode

