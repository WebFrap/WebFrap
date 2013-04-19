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
 */
class DaidalosDatabase_Model extends Model
{

  /**
   * @return array
   */
  public function getConnections()
  {

    $conf = $this->getConf();

    $dbConf = $conf->getResource('db');

    return $dbConf['connection'];

  }//end public function getConnections */

}//end class DaidalosDatabase_Model

