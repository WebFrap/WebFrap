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
class WebfrapHistory_Ajax_View
  extends LibTemplateAjaxView
{

  /**
   * @var WebfrapHistory_Model
   */
  public $model = null;

  /**
   * @param TFlag $params
   */
  public function displayOverlay( $element, $dKey, $objid )
  {


    $history = new WgtElementHistory();
    $history->view = $this;

    $history->data = $this->model->loadDsetHistory();

    $this->setReturnData( $history->render(), 'html' );

  }//end public function displayOverlay */

}//end class WebfrapHistory_Ajax_View

