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
 * @subpackage tech_core
 */
class LibSettingsNode
{

  /**
   * der Rootnode der Settings
   * @var stdClass
   */
  protected $node = null;

  /**
   * Flag zum feststellen ob die Settings geändert wurden, also ob
   * sie zurückgeschrieben werden müssen
   *
   * @var boolean
   */
  public $changed = false;

  /**
   * @param string $jsonData
   */
  public function __construct( $jsonData = null )
  {

    if( !is_null($jsonData) )
      $this->node = json_decode($jsonData);
    else
      $this->node = new stdClass();

    $this->prepareSettings();

  }//end public function __construct */


  /**
   * @param string $key
   * @param string $value
   */
  public function __set( $key, $value )
  {

    if( !isset($this->node->{$key}) || $this->node->{$key} !== $value )
      $this->changed = true;

    $this->node->{$key} = $value;

  }//end public function __set */

  /**
   * @param string $key
   */
  public function __get( $key )
  {

    return isset($this->node->{$key})
      ? $this->node->{$key}
      : null;

  }//end public function __get */

  /**
   * Den Settingsnode as json String serialisieren
   */
  public function toJson()
  {

    return json_encode( $this->node );

  }//end public function toJson */


  /**
   * Prepare the settings
   */
  protected function prepareSettings()
  {
    // kann, muss aber nicht implementiert werden daher einfach leer
  }//end protected function prepareSettings */

}// end class LibSettingsNode

