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
class WebfrapTaskPlanner_Edit_Maintab_View
  extends WgtModal
{
  
  /**
   * @var array
   */
  public $plan = null;
  
////////////////////////////////////////////////////////////////////////////////
// form export methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * @param TFlag $params
  */
  public function displayForm( $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Taskplanner',
      'wbf.label'
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/task/planner/modal/plan_form', true );

    // kein fehler aufgetreten
    return null;

  }//end public function displayList */



}//end class WebfrapTaskPlanner_Edit_Maintab_View

