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
class WebfrapTask_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function loadTasks( $view )
  {

    $data = array();

    $data[] = array
    (
      'wbfsys_task_rowid'      => '1',
      'wbfsys_task_title'      => 'a task',
      'wbfsys_task_progress'   => '44',
      'wbfsys_task_priority'   => '42',
      'wbfsys_task_m_created'  => '2009-11-12',
    );

    $data[] = array
    (
      'wbfsys_task_rowid'      => '2',
      'wbfsys_task_title'      => 'yet another task',
      'wbfsys_task_progress'   => '80',
      'wbfsys_task_priority'   => '42',
      'wbfsys_task_m_created'  => '2009-11-12',
    );

    $data[] = array
    (
      'wbfsys_task_rowid'      => '3',
      'wbfsys_task_title'      => 'wow, really many tasks here',
      'wbfsys_task_progress'   => '4',
      'wbfsys_task_priority'   => '22',
      'wbfsys_task_m_created'  => '2009-11-12',
    );


    $table = $view->newItem( 'tableTasks', 'TableWebfrapTask' );
    $table->setData($data);

    $actions = array('edit','delete');

    $table->setActions( $actions );

  }//end public function loadTasks */


}//end class WebfrapTask_Model

