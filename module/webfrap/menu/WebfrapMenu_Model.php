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
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class WebfrapMenu_Model extends Model
{

  /**
   * @param LibTemplate $view
   * @return void
   */
  public function getMainMenu()
  {
    return DaoFoldermenu::get('webfrap/root',true);

  }//end public function desktop */

  /**
   * @return void
   */
  public function getStartMenu(  )
  {

    $db     = $this->getDb();

    $conf   = $this->getConf();
    $appKey = $conf->getStatus('gateway.key');

    if (!$appKey)
      return array();

    $app = $db->orm->getBeyKey('WbfsysApp', "{$appKey}");

    $query = $db->newQuery('WebfrapMenu');

    if (!$app->id_main_menu) {
      return $query->fetchMenuEntries($app->id_main_menu);
    } else {
      return array();
    }

  }//end public function getStartMenu */

} // end class WebfrapMenu_Model

