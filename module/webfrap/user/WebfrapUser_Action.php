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
 * @subpackage User
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapUser_Action extends Action
{

  /**
   * @interface Dataset
   * @param Entity $entity
   * @param Context $params
   * @param Base $env
   */
  public function setupAdressItems($entity, $params, $env)
  {

    $orm = $env->getOrm();

    $addrItem = $orm->newEntity('WbfsysAddressItem');
    $addrItem->address_value = $entity->getId();
    $addrItem->id_user = $entity->getId();
    $addrItem->vid = $entity->getId();
    $addrItem->flag_private = false;
    $addrItem->use_for_contact = true;
    $addrItem->name = "User ID";
    $addrItem->id_type = $orm->getByKey('WbfsysAddressItemType', 'message');

    $orm->insert($addrItem);

  }//end public function setupAdressItems */

}//end class WebfrapUser_Action

