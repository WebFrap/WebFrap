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
class LibSettingsModNode
{

  /**
   * Die ID des Nodes
   * kann auch der access key sein
   * @var int|string
   */
  public $id = null;

  /**
   * Value
   * @var string
   */
  public $value = null;

  /**
   * Eventuell vorhandene ID einens Datensatzes auf den referenziert wird
   * @var int
   */
  public $vid = null;

  /**
   * Flag zum feststellen ob die Settings geändert wurden, also ob
   * sie zurückgeschrieben werden müssen
   *
   * @var boolean
   */
  public $changed = false;

  /**
   * @param string $value
   * @param int $vid
   * @param int $id
   */
  public function __construct($value = null, $vid = null, $id = null)
  {

    $this->value = $value;
    $this->vid = $vid;
    $this->id = $id;

    Debug::console("GOT ID ".$id);

    $this->prepareSettings();

  }//end public function __construct */


  /**
   * @return int
   */
  public function getId()
  {

    return $this->id;

  }//end public function getId */

  /**
   * @return int
   */
  public function setId($id)
  {

    $this->id = $id;

  }//end public function setId */


  /**
   * Prepare the settings
   */
  protected function prepareSettings()
  {
    // kann, muss aber nicht implementiert werden daher einfach leer
  }//end protected function prepareSettings */


}// end class LibSettingsModNode

