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
class ShopFront_Frontend extends WgtFrontend
{
  
  /**
   * 
   * @param LibTemplate $view
   * @param WgtTemplate $body
   * 
   * @return string
   */
  public function render( $view, $body )
  {
    
    $view->setIndex( 'shop/base' );
    
    if (!$view->getTemplate() )
      $view->setTemplate( 'shop/start_page' );
    
    $view->addElement( 'footer', new ShopFront_Footer() );
    $view->addElement( 'header', new ShopFront_Header() );
    
    $menu = new ShopFront_Menu();
    $menu->setModel( $this->model );
    
    $view->addElement( 'menu', $menu );
    
    $view->addVar( 'body', $body->render() );

  }//end public function render */


}//end class ShopFront_Frontend

