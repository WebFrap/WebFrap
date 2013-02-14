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
 * @subpackage ModShop
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class ShopFront_Header extends WgtTemplate
{
  
  /**
   * @return string
   */
  public function render()
  {
    
    return <<<HTML
  
  <div id="cms-logo" class="left" >
    <h1><a href="frontend.php?c=Shop.Front.start" >Super Shop</a></h1>
  </div>
  
  <ul class="right" >
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=impressum" >Cat 1</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=datenschutz" >Cat 2</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=hilfecenter" >Cat 3</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=my_data" >Cat 4</a></li>
  </ul>

HTML;
    
  }//end public function render */


}//end class ShopFront_Footer

