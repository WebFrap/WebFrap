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
class WgtMenuSimplebar
  extends WgtMenu
{
////////////////////////////////////////////////////////////////////////////////
// logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function build(  )
  {

    /*
<div class="entry" >
  <a href="index.php?c=Genf.Bdl.tableProject" >BDML</a>
</div>
     */

    $html = '<div class="wgt-menu bar" >'.$this->body().'</div>';

    return $html;

  }//end public function build */


  /**
   * @return string
   */
  public function body(  )
  {

    $html = '';

    foreach( $this->data as $entry )
    {
      $html .= <<<CODE
<div class="entry" >
  <a href="{$entry[WgtMenu::ACTION]}" >{$entry[WgtMenu::TEXT]}</a>
</div>

CODE;
    }

    return $html;

  }//end public function body */

} // end class WgtMenuSimplebar


