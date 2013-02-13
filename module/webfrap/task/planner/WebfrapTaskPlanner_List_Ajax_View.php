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
class WebfrapTaskPlanner_List_Ajax_View
  extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var WebfrapTaskPlanner_Model
   */
  public $model = null;
  
  /**
   * @var WgtSimpleListmenu
   */
  public $listMenu = null;
  
  /**
   * @var array
   */
  public $plans = array();
  
  /**
   * @var array
   */
  public $plan = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// form export methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param TFlag $params
  */
  public function displayAdd( $id, $params )
  {
    
    $this->plan = $this->model->getPlans( 'rowid='.$id )->get();
    $this->listMenu = new WebfrapTaskPlanner_List_Menu( $this );

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-taskplanner-table>tbody';
    $pageFragment->action = 'prepend';

    $pageFragment->setContent
    ( 
      $this->includeContentTemplate( 'webfrap/task/planner/maintab/plan_list_entry', true) 
    );
    
    $this->setArea( 'le', $pageFragment );
    
    
    //.grid('incEntries')

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-taskplanner-table').grid('renderRowLayout');

WGTJS;

    $this->addJsCode( $jsCode );
 

  }//end public function displayList */

 /**
  * @param TFlag $params
  */
  public function displayUpdate( $id, $params )
  {
    
    $this->plan = $this->model->getPlans( 'rowid='.$id )->get();
    $this->listMenu = new WebfrapTaskPlanner_List_Menu( $this );

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-table-taskplanner-'.$id;
    $pageFragment->action = 'replace';

    $pageFragment->setContent
    ( 
      $this->includeContentTemplate( 'webfrap/task/planner/maintab/plan_list_entry', true) 
    );
    
    $this->setArea( 'le', $pageFragment );
    
    
    //.grid('incEntries')

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-taskplanner-table').grid('renderRowLayout');

WGTJS;

    $this->addJsCode( $jsCode );
 

  }//end public function displayUpdate */
  
 /**
  * @param TFlag $params
  */
  public function displayDelete( $id, $params )
  {
    
    $this->plan = $this->model->getPlans( 'rowid='.$id )->get();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-table-taskplanner-'.$id;
    $pageFragment->action = 'remove';

    $this->setArea( 'le', $pageFragment );
    
    
    //.grid('incEntries')

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-taskplanner-table').grid('renderRowLayout');

WGTJS;

    $this->addJsCode( $jsCode );
 

  }//end public function displayUpdate */
  
}//end class WebfrapTaskPlanner_List_Ajax_View

