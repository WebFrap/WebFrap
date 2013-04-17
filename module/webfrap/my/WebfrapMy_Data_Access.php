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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMy_Data_Access extends LibAclPermission
{

  /**
   * @param TFlag $params
   * @param WbfsysMessage_Entity $entity
   */
  public function loadDefault($params, $entity = null)
  {

    // laden der benötigten Resource Objekte
    $acl = $this->getAcl();

    $this->level = Acl::DELETE;

  }//end public function loadDefault */



}//end class WebfrapMy_Data_Access

