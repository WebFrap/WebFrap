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
 * @subpackage Taskplanner
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapTaskPlanner_TaskList_Modal_View extends WgtModal
{

  /**
   * @var array
   */
  public $plan = null;

  /**
   * @var int
   */
  public $width = 850;

  /**
   * @var int
   */
  public $height = 600;

/*//////////////////////////////////////////////////////////////////////////////
// form export methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param int $objid
  * @param TFlag $params
  */
  public function displayListing($objid, $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Tasks',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText );

    // set the window status text
    $this->setLabel($i18nText );

    $this->tasks = $this->model->getPlanTasks($objid );

    // set the from template
    $this->setTemplate( 'webfrap/task/planner/modal/plan_task_list', true );

    // kein fehler aufgetreten
    return null;

  }//end public function displayListing */

}//end class WebfrapTaskPlanner_TaskList_Modal_View

