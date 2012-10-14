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
class WebfrapComment_Ajax_View
  extends LibTemplatePlain
{
////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayAdd( $elementId, $refId, $parent, $entry )
  {

    $tpl = $this->getTplEngine();
    
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-comment_tree-'.$elementId.'-cnt-'.(int)$parent;
    $pageFragment->action = 'append';
    
    $commentElement = new WgtElementCommentTree();
    $commentElement->setId( $elementId );

    
    $pageFragment->setContent( $commentElement->renderAjaxAddEntry( $elementId, $entry ) );
    
    $tpl->setArea( 'comment_entry', $pageFragment );
    

  }//end public function displayAdd */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayUpdate( $elementId, $refId, $entry )
  {

    $tpl = $this->getTplEngine();
    
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-comment_tree-'.$elementId.'-'.$refId.'  .comment-'.$entry['id'];
    $pageFragment->action = 'replace';
    
    $commentElement = new WgtElementCommentTree();
    $commentElement->setId( $elementId );

    
    $pageFragment->setContent( $commentElement->renderAjaxUpdateEntry( $elementId, $entry ) );
    
    $tpl->setArea( 'comment_entry', $pageFragment );
    

  }//end public function displayAdd */

} // end class WebfrapComment_Ajax_View */

