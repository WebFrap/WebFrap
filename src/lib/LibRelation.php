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
class LibRelation extends BaseChild
{

  /**
   * @var LibRelation
   */
  private static $default = null;

  /**
   * @var LibRelationLoader_Query
   */
  protected $relationLoader = null;

  /**
   * @return LibRelation
   */
  public static function getDefault()
  {

    if (!self::$default) {
      self::$default = new LibRelation();
      self::$default->setEnv(Webfrap::$env  );
    }

    return self::$default;

  }//end public function getDefault *

  /**
   * Mit dieser Methoden werden alle relevanten Adressdaten für die Empfänger
   * einer Nachricht geladen
   *
   * Welche genau das sind kann den Nachrichten Umschlag entnommen werden
   *
   * @param array<IReceiver> $receivers
   * @param string $type
   *
   */
  public function getUsers($relations)
  {

    //$receivers = $message->getReceivers();
    $users = array();

    foreach ($relations as $relation) {

      try {

        switch ($relation->type) {
          case 'group':
          {
            $users = $this->loadGroup($relation, $users);
            break;
          }
          case 'user':
          {
            $users = $this->loadUser($relation, $users);
            break;
          }

        }
      } catch (LibRelation_Exception $exc) {

      }

    }

    return $users;

  }//end public function getUsers */

  /**
   * @param LibMessage_Receiver_Group $receiver
   * @param string $type
   * @param array $userList
   *
   * @return array
   */
  public function loadGroup($receiver, $userList)
  {

    $relationLoader = $this->getRelationLoader();

    if (!$users = $relationLoader->fetchGroups($receiver)) {

      if ($receiver->else) {
        foreach ($receiver->else as $elseReceiver) {
          $userList = $this->getUsers($elseReceiver, $userList);
        }
      }

      return $userList;
    }

    foreach ($users as $userData) {
      $node = new LibRelationNode_User($userData);

      // jede adresse nur einmal zulassen, doppelte werden einfach
      // überschrieben
      $userList[$node->id] = $node;
    }

    return $userList;

  }//end public function loadGroup */

  /**
   * @param LibMessage_Receiver_User $receiver
   * @param string $type
   * @param array $contacts
   *
   * @return array
   */
  public function loadUser($receiver, $users)
  {

    $addressLoader = $this->getRelationLoader();

    if (!$userData = $addressLoader->fetchUser($receiver)) {
      if ($receiver->else) {
        foreach ($receiver->else as $elseReceiver) {
          $users = $this->getUsers($elseReceiver, $users);
        }
      }

      return $users;
    }

    $contact = new LibRelationNode_User($userData);
    $users[$contact->address] = $contact;

    return $users;

  }//end public function loadUser */

  /**
   * @return LibRelationLoader_Query
   */
  public function getRelationLoader()
  {

    if (!$this->relationLoader) {
      $db  = $this->getDb();
      $this->relationLoader = $db->newQuery('LibRelationLoader');
    }

    return $this->relationLoader;

  }//end public function getRelationLoader */

} // end class LibDataRelation

