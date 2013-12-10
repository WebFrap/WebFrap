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
   * @param string $value
   * @param int $vid
   * @param int $id
   */
  public function __construct($value = null, $vid = null, $id = null)
  {

    if(is_array($value)){
      $this->value = $value['value'];
      $this->vid = $value['vid'];
      $this->id = $value['rowid'];
    } else if(is_object($value)){
      $this->value = $value->value;
      $this->vid = $value->vid;
      $this->id = $value->rowid;
    } else {
      $this->value = $value;
      $this->vid = $vid;
      $this->id = $id;
    }

  }//end public function __construct */

}// end class LibSettingsModNode

