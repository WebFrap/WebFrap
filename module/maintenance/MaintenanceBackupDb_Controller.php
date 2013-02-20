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
class MaintenanceBackupDb_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'table','form','backup'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'table';

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function table( )
  {

    // check if the request type is WINDOW, if not return an error page
    if (!$this->view->isType(View::SUBWINDOW) ) {
      $this->errorPage
      (
        $this->i18n->l
        (
          'Invalid viewtype',
          'wbf.message.invalidViewType'
        ),
        $this->i18n->l
        (
          'This request is only valid for window requests',
          'wbf.message.requestMustBeWindow'
        )
      );

      return false;
    }

    $view = $this->view->newWindow('table_maintenance_backup');
    $view->setStatus($this->i18n->l( 'backup database', 'wbfsys.bookmark.label.table'  ) );

    $view->setTemplate( 'maintenance/table_db' );

    $modelBookmark = $this->loadModel('WbfsysBookmark');

    $db = Db::getActive();

    $conf = Conf::get('db');

    $table = $view->newItem( 'tableMaintenanceDb' , 'TableMaintenanceDb' );
    $table->setData($conf['connection']);
    $table->setActions(array('form','backup','restore'));

  }//end public function menu */

}//end class MaintenanceBackupDb_Controller

