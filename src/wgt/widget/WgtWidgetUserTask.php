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
 * @subpackage tech_core
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class WgtWidgetUserTask
  extends WgtWidget
{

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab( $containerId, $tabId, $tabSize = 'medium' )
  {

    $user     = $this->getUser();
    $view     = $this->getView();

    $profile  = $user->getProfile();
    $employee = $profile->getEmployee();

    $db       = Db::getActive();

    $query = $db->newQuery('UserTask_Table');

    /*
    if ($params->exclude) {

      $tmp = explode('-',$params->exclude );

      $conName   = $tmp[0];
      $srcId     = $tmp[1];
      $targetId  = $tmp[2];

      $excludeCond = ' project_task.rowid NOT IN '
      .'( select '.$targetId .' from '.$conName.' where '.$srcId.' = '.$params->objid.' ) ';

    }*/

    $query->setCondition( 'project_task_employee.id_employee = '.$employee );

    $query->fetch
    (
      null,
      $params
    );

    $table = $view->newItem
    (
      'TableUserTask',
      'TableUserTask'
    );

    // use the query as datasource for the table
    $table->setData($query);

    /*
    $table->start    = $params->start;
    $table->stepSize = $params->qsize;
    */

    $actions = array('edit');
    $table->addActions( $actions );

    $table->setId( 'wgt-table-user_task' );
    $table->setPagingId( 'wgt-form-user_task-search' );

    $table->buildHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="my tasks"  >
      <form
        id="wgt-form-user_task-search"
        method="post"
        action="index.php?c=Widget.UserTask.reload"  ></form>

      {$table}
      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */


  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function reload( $view, $tabId )
  {

    $user     = $this->getUser();
    $view     = $this->getView();

    $profile  = $user->getProfile();
    $employee = $profile->getEmployee();

    $db       = Db::getActive();

    $query = $db->newQuery('UserTask_Table');

    /*
    if ($params->exclude) {

      $tmp = explode('-',$params->exclude );

      $conName   = $tmp[0];
      $srcId     = $tmp[1];
      $targetId  = $tmp[2];

      $excludeCond = ' project_task.rowid NOT IN '
      .'( select '.$targetId .' from '.$conName.' where '.$srcId.' = '.$params->objid.' ) ';



    }*/

    $query->setCondition( 'project_task_employee.id_employee = '.$employee );

    $query->fetch
    (
      null,
      $params
    );


    $table = $view->newItem
    (
      'TableUserTask',
      'TableUserTask'
    );

    // use the query as datasource for the table
    $table->setData($query);

    /*
    $table->start    = $params->start;
    $table->stepSize = $params->qsize;
    */

    $actions = array('edit');
    $table->addActions( $actions );

    $table->setId( 'wgt-table-user_task' );
    $table->setPagingId( 'wgt-form-user_task-search' );


    $table->buildHtml();


    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="my tasks"  >
      <form
        id="wgt-form-user_task-search"
        method="post"
        action="index.php?c=Widget.UserTask.reload"  ></form>

      {$table}
      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

} // end class WgtWidgetUserTasks
