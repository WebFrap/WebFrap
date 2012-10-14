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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSearch_Ajax_View
  extends LibTemplatePlain
{
////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   */
  public function displaySearch( $elementId )
  {

    $tpl = $this->getTplEngine();
    
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt_table-'.$elementId;
    $pageFragment->action = 'replace';
    
    $searchElement = new WgtElementDesktopSearch();
    $searchElement->setId( $elementId );
    
    $searchRes = $this->model->performSearch(  );
    
    $pageFragment->setContent( $searchElement->renderResult( $searchRes ) );
    
    $tpl->setArea( 'search_result', $pageFragment);
    

  }//end public function displaySearch */



} // end class WebfrapSearch_Ajax_View */

