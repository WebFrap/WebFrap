<?php
/*******************************************************************************
* Webfrap.net Legion
*
* @author      : Dominik Bonsch <dominik.bonsch@s-db.de>
* @date        : @date@
* @copyright   : Softwareentwicklung Dominik Bonsch <contact@webfrap.de>
* @project     :
* @projectUrl  :
* @licence     : WebFrap.net
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage ModProject
 * @author Dominik Bonsch <dominik.bonsch@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <contact@webfrap.de>
 * @licence WebFrap.net
 */
class WebfrapTag_Ajax_View extends LibTemplateAjaxView
{

  /**
   * @var WebfrapHistory_Model
   */
  public $model = null;

  /**
   * @param TFlag $params
   */
  public function displayOverlay($element, $dKey, $objid )
  {

    $item_Tags = new WgtElementTagCloud( );
    $item_Tags->view = $this;
    $item_Tags->label = 'Tags';
    $item_Tags->width = 480;

    /* @var $tagModel WebfrapTag_Model  */
    $tagModel = $this->loadModel( 'WebfrapTag' );
    $item_Tags->setData($tagModel->getDatasetTaglist($objid ) );
    $item_Tags->refId = $objid;
    //$item_Tags->access = $params->accessTags;
    $item_Tags->render();

    $this->setReturnData( '<div class="wgt-space" >'.$item_Tags->render().'</div>', 'html' );

  }//end public function displayOverlay */

}//end class WebfrapTag_Ajax_View

