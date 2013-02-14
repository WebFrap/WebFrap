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
class WebfrapUsermenu_Model extends Model
{

  /**
   * @param LibTemplate $view
   * @return void
   */
  public function table($view  )
  {

    $modMenu = $view->newItem( 'widgetUserMenu', 'MenuFolder' );
    $modMenu->setSource('user/menu');
    $modMenu->setId('wbf_desktop_usermenu');

  }//end public function table */


  /**
   * @param LibTemplate $view
   * @return void
   */
  public function desktop($view  )
  {
    $modMenu = $view->newItem( 'widgetUserMenu', 'MenuFolder' );

    $modMenu->setData( DaoFoldermenu::get('user/menu') );
    $modMenu->setId('wbf_desktop_usermenu');

  }//end public function desktop */

} // end class WebfrapUsermenu_Model


