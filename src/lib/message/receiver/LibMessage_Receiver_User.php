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
class LibMessage_Receiver_User
  implements IReceiver
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WbfsysRoleUser_Entity
   */
  public $user = null;

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
  public $type = 'user';

  /**
   * @var array<IReceiver>
   */
  public $else = array();

  /**
   * @param mixed $user
   */
  public function __construct($user )
  {

    if ( is_object($user ) ) {
      $this->user = $user;
      $this->id   = $user->getId();
    } elseif ( is_numeric($user ) ) {
      $this->id = $user;
    } else {
      $this->name = $user;
    }

  }//end public function __construct */

} // end LibMessage_Receiver_User

