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
class ShopCms_Page_Body extends WgtTemplate
{
  
  public $pageKey = null;
  
  /**
   * @param LibTemplate $view
   * @param LibTemplate $body
   * 
   * @return string
   */
  public function render(  )
  {
 
    $pageEntity = $this->model->getPage( $this->pageKey );
    
    if (!$pageEntity )
      $pageEntity = $this->model->getPage( 'error_404' );
      
    $this->view->setTitle( $pageEntity->title );
    
    if( $pageEntity->template )
    {
      $template = $pageEntity->template;
    } else {
      $template = 'shop/page' ;
    }
    
    $this->addVar( 'body', $pageEntity->page_content );
    
    return $this->renderTemplate( $template );
    
  }//end public function render */


}//end class ShopFront_Start_Body

