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
class LibRelationNode_User
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Id des User Objekts
   * @var int
   */
  public $id  = null;
  
  /**
   * @var string
   */
  public $nickname = null;

  /**
   * @var string
   */
  public $firstname = null;
  
  /**
   * @var string
   */
  public $lastname = null;
  
  /**
   * @var string
   */
  public $title = null;

  
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $userData
   * @param string $address
   */
  public function __construct($userData, $address = null )
  {
    
    if ( is_array($userData) )
    {
      
      if ( isset($userData['userid'] ) )
      {
        $this->id = $userData['userid'];
      }
      
      if ( isset($userData['name'] ) )
      {
        $this->nickname = $userData['name'];
      }
      
      if ( isset($userData['firstname'] ) )
      {
        $this->firstname = $userData['firstname'];
      }
      
      if ( isset($userData['lastname'] ) )
      {
        $this->lastname = $userData['lastname'];
      }
      
      if ( isset($userData['title'] ) )
      {
        $this->title = $userData['title'];
      }

    } else {
      $this->id        = $userData->userId;
      $this->nickname  = $userData->nickname;
      $this->firstname = $userData->firstname;
      $this->lastname  = $userData->lastname;
      $this->title     = $userData->title;
    }

  }//end public function __construct */

} // end class LibRelationNode_User

