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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMessage_Checklist_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(

    // message logic
    'save' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'delete' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/


 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_save($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new WebfrapMessage_Attachment_Request($request);

    $model = $this->loadModel('WebfrapMessage');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    /* @var $view WebfrapMessage_Attachment_Modal_View */
    $view   = $response->loadView(
      'form-messages-attachment-insert',
      'WebfrapMessage_Attachment',
      'displayInsert'
    );

    // request bearbeiten
    /* @var $model WebfrapMessage_Attachment_Model */
    $attachModel = $this->loadModel('WebfrapMessage_Attachment');
    $view->setModel($attachModel);
    
    $attachModel->insert( $params );

    $view->displayInsert($params);

  }//end public function service_save */
  
  
 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_delete($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $model = $this->loadModel('WebfrapMessage');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }
    
    $params->delId = $request->param('delid',Validator::EID);
    
    if( !$params->delId ){
      throw new InvalidRequest_Exception('Missing the request id');
    }

    /* @var $view WebfrapMessage_Attachment_Ajax_View */
    $view   = $response->loadView(
      'form-messages-attachment-delete',
      'WebfrapMessage_Attachment',
      'displayDelete'
    );

    // request bearbeiten
    /* @var $model WebfrapMessage_Attachment_Model */
    $attachModel = $this->loadModel('WebfrapMessage_Attachment');
    $view->setModel($attachModel);
    
    $attachModel->delete( $params->delId, $params );

    $view->displayDelete( $params->delId );

  }//end public function service_insert */
  
} // end class WebfrapMessage_Attachment_Controller
