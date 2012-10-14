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
class Webfrap_Acl_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the id of the active area
   * @var int
   */
  protected $areaId = null;

////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * request the id of the activ area
   * @param string $areaKey the keyname for the requested area
   * @return int
   */
  public function loadAreaId( $areaKey  )
  {

    if( $this->areaId )
      return $this->areaId;

    $orm = $this->getOrm();

    $this->areaId = $orm->get('WbfsysSecurityArea',"upper(access_key)=upper('{$areaKey}')")->getid();

    return $this->areaId;

  }//end public function loadAreaId */


} // end class WebFrap_Acl_Model */

