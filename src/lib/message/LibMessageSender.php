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
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageSender
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Id des User Objekts
   * @var int
   */
  public $userId  = null;

  /**
   * @var string
   */
  public $userName = null;

  /**
   * @var string
   */
  public $firstName = null;

  /**
   * @var string
   */
  public $lastName = null;

  /**
   * @var string
   */
  public $fullName = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param User $user
   */
  public function __construct($user )
  {

    if ($user instanceof User) {

      $data = $user->getData();

      $this->userId    = $user->getId();
      $this->userName  = $data['name'];
      $this->firstName = $data['firstname'];
      $this->lastName  = $data['lastname'];
      $this->fullName  = $user->getFullName();
    } else {

      //$orm = Webfrap::$env->getOrm();

      $person = $user->followLink('id_person');

      $this->userId    = $user->getId();
      $this->userName  = $user->name;
      $this->firstName = $person->firstname;
      $this->lastName  = $person->lastname;
      $this->fullName  = $person->lastname.", ".$person->firstname;

    }

  }//end public function __construct */

} // end class LibMessageSender

