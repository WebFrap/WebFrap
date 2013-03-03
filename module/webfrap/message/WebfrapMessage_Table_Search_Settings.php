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
   * @var array
   */
  public $channel = null;


  /**
   * @param array $channel
   */
  public function setChannel( $channel ){

    $channel = (object)$channel;

     $this->changed = true;

    if( $this->channel != $channel ){

      $this->channel = $channel;
    }

  }//end public function setChannel */

  /**
   * Prepare the settings
   *
   */
  protected function prepareSettings()
  {

    $this->channel = isset( $this->node->chanel )
      ? (object)$this->node->chanel
      : new stdClass();

  }//end protected function prepareSettings */

  /**
   * Den Settingsnode as json String serialisieren
   */
  public function toJson()
  {

    $this->node->channel = $this->channel;

    return json_encode( $this->node );

  }//end public function toJson */

} // end class WebfrapMessage_Table_Search_Request */

