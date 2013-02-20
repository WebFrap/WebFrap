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
class WebfrapProtocol_Ajax_View extends LibTemplateAjaxView
{

  /**
   * @var WebfrapProtocol_Model
   */
  public $model = null;

  /**
   * @param TFlag $params
   */
  public function displayOverlay($dKey, $objid )
  {

    $history = new WgtElementProtocol();
    $history->view = $this;

    $history->setData($this->model->loadDsetProtocol($dKey, $objid ) ) ;

    $this->setReturnData
    (
      '<div class="wgt-scroll-y" style="max-height:600px;margin-top:-5px;" >'.$history->render().'</div>',
      'html'
    );

  }//end public function displayOverlay */

}//end class WebfrapHistory_Ajax_View

