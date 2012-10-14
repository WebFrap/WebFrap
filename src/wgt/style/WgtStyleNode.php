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
class WgtStyleNode
{

  /**
   *
   * @var string
   */
  protected $subStyle = array();

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

////////////////////////////////////////////////////////////////////////////////
// logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Implementieren eines Getters für die StyleElemente
   *
   * @return WgtStyleNode
   */
  public function __get( $type )
  {

    if(!isset( $this->subStyle[$type] ))
    {
      $styleClass = 'WgtStyle'.ucfirst($type);
      $this->subStyle[$type] = new $styleClass();
    }

    return $this->subStyle[$type];

  }//end public function __get */

  /**
   *
   */
  public function __clone()
  {

    $oldNodes = $this->subStyle;

    foreach( $oldNodes as $nodeName => $node )
    {
      $this->subStyle[$nodeName] = clone $node;
    }

  }//end public function __clone

  /**
   * @return string
   */
  public function build()
  {
    return '';
  }//end public function build */


} // end class WgtStyleNode


