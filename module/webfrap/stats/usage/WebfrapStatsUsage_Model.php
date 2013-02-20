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
class WebfrapStatsUsage_Model  extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
//  Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
//  Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function loadData()
  {
    $db = $this->getDb();

    $sql = <<<SQL

SQL;

    return $db->select($sql );

  }//end public function loadData */

}//end  class  WebfrapKnowhowNode_Model

