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
class WgtMenuHtml
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $html = null;

////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////


  /**
   * Enter description here...
   *
   * @param string $html
   */
  public function __construct( $html = null  )
  {
    $this->html = $html;
  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * set the menu name
   *
   * @param string $html
   */
  public function setHtml( $html )
  {
    $this->html = $html ;
  }//end public function sethtml */

  /**
   * @param string $menu
   * @return string
   */
  public function build( $menu )
  {

    return  $menu.'.addHtml( \''.$this->html.'\' );'.NL;

  }//end public function build */

} // end class WgtMenuHtml


