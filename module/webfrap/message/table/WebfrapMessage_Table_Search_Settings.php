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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Table_Search_Settings extends LibSettingsNode
{

  /**
   * @var stdClass
   */
  public $channels = null;

  /**
   * @var stdClass
   */
  public $aspects = null;

  /**
   * @var stdClass
   */
  public $status = null;

  /**
   * @var stdClass
   */
  public $taskAction = null;


  /**
   * @param array $channels
   */
  public function setChannel( $channels ){

    $channels = (object)$channels;

    if ( $this->channels != $channels ){

      $this->changed = true;
      $this->channels = $channels;
    }

  }//end public function setChannel */

  /**
   * @param array $channels
   */
  public function setAspects( $aspects ){

    if ( $this->aspects !== $aspects ){
      $this->changed = true;
      $this->aspects = $aspects;
    }

  }//end public function setAspects */

  /**
   * @param array $status
   */
  public function setStatus( $status ){

    $status = (object)$status;

    $this->changed = true;

    if ( $this->status != $status ){

      $this->status = $status;
    }

  }//end public function setStatus */

  /**
   * @param array $taskAction
   */
  public function setTaskAction( $taskAction ){

    $taskAction = (object)$taskAction;

    $this->changed = true;

    if ( $this->taskAction != $taskAction ){

      $this->taskAction = $taskAction;
    }

  }//end public function setActionStatus */

  /**
   * Prepare the settings
   *
   */
  protected function prepareSettings()
  {

    $this->channels = isset( $this->node->channels )
      ? (object)$this->node->channels
      : new stdClass();

    $this->aspects = isset( $this->node->aspects )
      ? $this->node->aspects
      : array();

    $this->status = isset( $this->node->status )
      ? (object)$this->node->status
      : new stdClass();

    $this->taskAction = isset( $this->node->task_action )
      ? (object)$this->node->task_action
      : new stdClass();

  }//end protected function prepareSettings */

  /**
   * Den Settingsnode as json String serialisieren
   */
  public function toJson()
  {

    $this->node->channels = $this->channels;
    $this->node->aspects = $this->aspects;
    $this->node->task_action = $this->taskAction;
    $this->node->status = $this->status;

    return json_encode( $this->node );

  }//end public function toJson */

} // end class WebfrapMessage_Table_Search_Request */

