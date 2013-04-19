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
class ShopFront_Footer extends WgtTemplate
{

  /**
   * @return string
   */
  public function render()
  {
    return <<<HTML

  <ul>
    <li>* Preisangaben inkl. gesetzl. MwSt. und zzgl. Versandkosten | </li>
    <li>** UVP des Herstellers | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=agb" >AGB</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=impressum" >Impressum</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=datenschutz" >Datenschutz</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=hilfecenter" >Hilfecenter</a> | </li>
    <li><a href="frontend.php?c=Shop.Cms_Frontend.page&page=my_data" >Meine Daten</a></li>
  </ul>

HTML;

  }//end public function render */

}//end class ShopFront_Footer

