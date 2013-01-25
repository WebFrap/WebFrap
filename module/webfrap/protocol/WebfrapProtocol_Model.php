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
 * @package  WebFrap
 * @subpackage  Core
 * @author  Dominik  Bonsch  <dominik.bonsch@webfrap.net>
 * @copyright  Webfrap  Developer  Network  <contact@webfrap.net>
 * @licence  BSD
 */
class WebfrapProtocol_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
//  Attributes
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param string $dKey
   * @param int $objid
   * @return WebfrapProtocol_Overlay_Query
   */
  public function loadDsetProtocol( $dKey, $objid )
  {

    $db = $this->getDb();


    $condition = array();
    $condition['vid'] = $objid;

    /* @var $query WebfrapProtocol_Overlay_Query  */
    $query = $db->newQuery( 'WebfrapProtocol_Overlay' );
    $query->fetch( $condition );

    return $query;

  }//end public function loadDsetProtocol */


}//end class WebfrapHistory_Model


