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
class LibMessage_Receiver_Group
  implements IReceiver
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WbfsysRoleGroup_Entity
   */
  public $group = null;

  /**
   * @var id
   */
  public $id = null;

  /**
   * @var string
   */
  public $name = null;

  /**
   * @var string
   */
  public $area = null;

  /**
   * @var string
   */
  public $entity = null;

  /**
   * @var string
   */
  public $type = 'group';

  /**
   * @var array<IReceiver>
   */
  public $else = array();

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param mixed $group
   * @param string $area
   * @param Entity $entiy
   * @param array<IReceiver> $else
   */
  public function __construct($group, $area = null, $entiy = null, $else = array())
  {

    if (is_object($group)) {
      $this->group = $group;
    } elseif (is_numeric($group)) {
      $this->id = $group;
    } else {
      $this->name = $group;
    }

    $this->area = $area;
    $this->entity = $entiy;

    $this->else = $else;

  }//end public function __construct */

} // end LibMessage_Receiver_Group

