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
class WgtColorscheme
{
/*//////////////////////////////////////////////////////////////////////////////
// text colors
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default color for all texts, excluding links
   * @var string
   */
  public $colors = array();

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Zugriff Auf die Elemente per magic set
   * @param string $key
   * @param mixed $value
   */
  public function __set($key , $value )
  {
    $this->colors[$key] = $value;
  }//end public function __set */

  /**
   * Zugriff Auf die Elemente per magic get
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key )
  {
    return isset($this->colors[$key])?$this->colors[$key]:null;
  }//end public function __get */

  /**
   */
  public function __construct()
  {
    $this->load();
  }//end public function __construct */

  /**
   */
  public function load()
  {

  }//end public function load */

} // end class WgtColorschemeDefault

