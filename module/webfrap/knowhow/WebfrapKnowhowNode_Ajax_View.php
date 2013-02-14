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
class WebfrapKnowhowNode_Ajax_View extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   * @param WbfsysKnowHowNode_Entity $node
   */
  public function displayAdd($elementId, $node )
  {

    $tpl = $this->getTplEngine();
    
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-input-commenttree-'.$elementId.'-rowid';
    $pageFragment->action   = 'value';

    $pageFragment->setContent($node->getId() );
    
    $tpl->setArea( 'comment_entry', $pageFragment );
    

  }//end public function displayAdd */

 

} // end class WebfrapKnowhowNode_Ajax_View */

