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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class GroupwareMessage_Model
  extends Model
{

  /**
   * @param TFlag $params
   * @return GroupwareMessage_List_Access
   */
  public function loadTableAccess( $params )
  {
    
    $user = $this->getUser();
    
    // ok nun kommen wir zu der zugriffskontrolle
    $this->access = new GroupwareMessage_Table_Access( null, null, $this );
    $this->access->load( $user->getProfileName(), $params );
    
    $params->access = $this->access;
    
    return $this->access;
    
  }//end public function loadTableAccess */
  
  /**
   * @param TFlag $params
   * @return array
   */
  public function fetchMessages( $params )
  {
    
    $db = $this->getDb();
    
    // filter für die query konfigurieren
    $condition = array();
    $condition['filters'] = array();
    $condition['filters']['mailbox'] = 'in';
    $condition['filters']['archive'] = false;

    $query = $db->newQuery( 'GroupwareMessage_Table' );

    $query->fetch
    (
      $condition,
      $params
    );
    
    return $query->getAll();
    
  }//end public function fetchMessages */
    

} // end class WebfrapSearch_Model


