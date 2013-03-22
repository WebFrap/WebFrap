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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Consistency extends DataContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Liste mit den Ids aller user
   * @var array
   */
  protected $sysUsers = array();

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run()
  {

    $orm = $this->getOrm();
    $this->sysUsers   = $orm->getIds("WbfsysRoleUser", "rowid>0");

    $this->fixUserAddresses();

  }//end public function run */

  /**
   *
   */
  protected function fixUserAddresses()
  {

    $orm = $this->getOrm();

    $itemType = $orm->getByKey('WbfsysAddressItemType', 'message');
    $itemId   = $itemType->getId();

    foreach ($this->sysUsers as $sysUser) {

      if (!$item = $orm->get('WbfsysAddressItem', 'id_user='.$sysUser.' and id_type='.$itemId)) {
        // Private Channel für den User erstellen
        $item = $orm->newEntity('WbfsysAddressItem');
        $item->address_value   = $sysUser;
        $item->id_user = $sysUser;
        $item->id_type = $itemId;
        $item->use_for_contact = true;
        $orm->save($item);

      }

    }

  }//end protected function fixUserAddresses */
  
  /**
   *
   */
  protected function fixUserReceiver()
  {
    
    $db = $this->getDb();
    $orm = $this->getOrm();
    
    $sql = <<<SQL
SELECT 
	rowid, 
	id_receiver,
	id_receiver_status,
	flag_receiver_deleted
FROM 
	wbfsys_message 
WHERE 
		not id_receiver is null;
    
SQL;

    $msgs = $db->select($sql);
    
    foreach($msgs as $msg){
      
      $receiver = $orm->newEntity('WbfsysMessageReceiver');
      $receiver->status = $msg['id_receiver_status'];
      $receiver->vid = $msg['id_receiver'];
      $receiver->id_message = $msg['rowid'];
      $receiver->flag_deleted = false;
      
      $orm->insert($receiver);
      
    }
    
    $sql = <<<SQL
UPDATE
	wbfsys_message 
	SET  id_receiver = null, id_receiver_status = null
	WHERE
		not id_receiver is null;
    
SQL;

    $msgs = $db->select($sql);

  }//end protected function fixUserAddresses */

}//end class WebfrapMessage_Consistency

