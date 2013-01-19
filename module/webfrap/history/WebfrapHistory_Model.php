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
class WebfrapHistory_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
//  Attributes
////////////////////////////////////////////////////////////////////////////////


  /**
   * @return WebfrapHistory_Query
   */
  public function loadDsetHistory()
  {

    $db = $this->getDb();

    /* @var $query WebfrapHistory_Query  */
    $query = $db->newQuery( 'WebfrapHistory' );
    $query->fetch();

    return $query;

  }//end public function loadDsetHistory */


}//end class WebfrapHistory_Model


