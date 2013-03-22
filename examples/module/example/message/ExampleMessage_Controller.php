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
 * Dummy class for Extentions
 * This class will be loaded if the System requests for an Extention that
 * doesn't exist
 * @package WebFrap
 * @subpackage Core
 */
class ExampleMessage_Controller extends Controller
{

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param TFlag $params
   */
  public function menu($params = null)
  {

    $view = $response->loadView
    (
      'example_menu_message',
      'ExampleMessage_Menu',
      'displayMenu'
    );

    if (!$view) {
      $this->errorPage(new Error_ViewNotFound('ExampleMessageMenu'));

      return false;
    }

    $params = $this->getFlags($params);

    $view->displayMenu($params);

  }//end public function menu */

  /**
   * @param TFlag $params
   */
  public function service_helloWorld($request, $response)
  {

    $params   = $this->getFlags($request);

    try {
      $message = new ExampleMessage_HelloWorld_Message();

      $message->addReceiver(new LibMessage_Receiver_User('example'  ));


      $msgProvider = $this->getMessage();
      $msgProvider->send($message);

      $response->addMessage("Sended Message");

    } catch (LibMessage_Exception $e) {

      $response->addError("Failed to send Message ".$e->getMessage());

    }


  }//end public function service_helloWorld */

  /**
   * @param TFlag $params
   */
  public function sendUser($params = null)
  {

    $params   = $this->getFlags($params);
    $response = $this->getResponse();

    try {
      $message = new ExampleMessage_HelloWorld_Message();

      $message->addReceiver(new LibMessage_Receiver_User('example'  ));


      $msgProvider = $this->getMessage();
      $msgProvider->send($message);

      $response->addMessage("Sended Message");

    } catch (LibMessage_Exception $e) {

      $response->addError("Failed to send Message ".$e->getMessage());

    }


  }//end public function sendUser */

  /**
   * @param TFlag $params
   */
  public function sendGroup($params = null)
  {

    $params   = $this->getFlags($params);
    $response = $this->getResponse();

    try {
      $message = new ExampleMessage_HelloWorld_Message();

      $message->addReceiver(new LibMessage_Receiver_Group('example_group'  ));


      $msgProvider = $this->getMessage();
      $msgProvider->send($message);

      $response->addMessage("Sended Message");

    } catch (LibMessage_Exception $e) {

      $response->addError("Failed to send Message ".$e->getMessage());

    }


  }//end public function sendGroup */

  /**
   * @param TFlag $params
   */
  public function sendGroupArea($params = null)
  {

    $params   = $this->getFlags($params);
    $response = $this->getResponse();

    try {
      $message = new ExampleMessage_HelloWorld_Message();

      $message->addReceiver
      (
        new LibMessage_Receiver_Group
        (
          'example_group_area',
          'mod-wbfsys/entity-wbfsys_tag/mgmt-wbfsys_tag'
        )
      );


      $msgProvider = $this->getMessage();
      $msgProvider->send($message);

      $response->addMessage("Sended Message");

    } catch (LibMessage_Exception $e) {

      $response->addError("Failed to send Message ".$e->getMessage());

    }


  }//end public function sendGroupArea */


  /**
   * @param TFlag $params
   */
  public function sendGroupDataset($params = null)
  {

    $params   = $this->getFlags($params);
    $response = $this->getResponse();
    $orm      = $this->getOrm();

    try {
      $message = new ExampleMessage_HelloWorld_Message();

      $message->addReceiver
      (
        new LibMessage_Receiver_Group
        (
          'example_group_dataset',
          'mod-wbfsys/entity-wbfsys_tag/mgmt-wbfsys_tag',
          $orm->getByKey('WbfsysTag', 'example')
        )
      );

      $msgProvider = $this->getMessage();
      $msgProvider->send($message);

      $response->addMessage("Sended Message");

    } catch (LibMessage_Exception $e) {

      $response->addError("Failed to send Message ".$e->getMessage());

    }

  }//end public function sendGroupDataset */

} // end class ControllerCrud
