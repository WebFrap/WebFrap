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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WgtTableUserTask extends WgtTable
{

/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the html id of the table tag, this id can be used to replace the table
   * or table contents via ajax interface.
   *
   * @var string $id
   */
  public $id       = 'wgt-table-user_task';

  /**
   * the most likley class of a given query object
   *
   * @var QueryProjectTask_Table
   */
  public $data       = null;

  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $url      = array
  (
    'paging'  => array
    (
      Wgt::ACTION_PAGING ,
      'index.php?c=Widget.UserTask.reload'
    ),
    'edit'    => array
    (
      Wgt::ACTION_JS,
      'edit',
      'modal.php?c=Project.Task.edit&amp;objid=',
      'control/edit.png',
      'wcm wcm_req_ajax',
      'project.task.label.title_edit'
    ),
    'delete'  => array
    (
      Wgt::ACTION_DELETE,
      'delete',
      'index.php?c=Project.Task.delete&amp;objid=',
      'control/delete.png',
      'wcm wcm_req_del',
      'project.task.label.title_delete'
    ),
    'checkbox'  => array
    (
      Wgt::ACTION_CHECKBOX,
      'select',
      null,
      null,
      null,
      'wbf.label.select'
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// context: table
//////////////////////////////////////////////////////////////////////////////*/



  /**
   * create the head for the table
   * @return string
   */
  public function buildThead( )
  {

    $this->numCols = 4;

    if($this->enableNav)
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;
    $html .= '<th style="width:136px" >
      <span style="float:right" >
        <img style="text-align:right;" class="wcm wcm_menu_table" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >title</span>
    </th>'.NL;

    $html .= '<th style="width:136px" >
      <span style="float:right" >
        <img style="text-align:right;" class="wcm wcm_menu_table" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >'.$this->view->i18n->l('type','project.task.label.table_head_id_type').'</span>
    </th>'.NL;

    $html .= '<th style="width:136px" >
      <span style="float:right" >
        <img style="text-align:right;" class="wcm wcm_menu_table" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >'.$this->view->i18n->l('status','project.task.label.table_head_id_status').'</span>
    </th>'.NL;

    // the default navigation col
    if( $this->enableNav )
      $html .= '<th style="width:70px;">'.$this->i18n->l( 'Nav.', 'wbf.label'  ).'</th>'.NL;

    $html .= '</tr>'.NL;
    $html .= '</thead>'.NL;
    //\ Creating the Head

    return $html;

  }//end public function buildThead */

  /**
   * create the body for the table
   * @return string
   */
  public function buildTbody( )
  {

    // create the table body ( customized )
    if( $this->bodyHeight )
      $body = '<tbody style="max-height:'.$this->bodyHeight.'px;" class="w_scrollh" >'.NL;
    else
      $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $num = 1;
    foreach( $this->data as $key => $row   )
    {

      $objid       = $row['project_task_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_task_title']).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_task_type_name']).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_task_status_name']).'</td>'.NL;

      if( $this->enableNav )
      {
        $navigation  = $this->buildActions( $objid );
        $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } //end foreach

    $body .= '</tbody>'.NL;
    //\ Create the table body

    return $body;

  }//end public function buildTbody */

  /**
   * build the table
   *
   * @return string
   */
  public function buildAjax( )
  {

    // if we have html we can assume that the table was allready buildd
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if( $this->html )
      return $this->html;

    $body = '';

    foreach( $this->data as $key => $row   )
    {

      $body .= $this->buildAjaxTbody( $row );

    }//end foreach

    $this->html = $body;

    return $this->html;

  }//end public function buildAjax */

  /**
   * create the body for the table
   * @param array $row
   * @return string
   */
  public function buildAjaxTbody( $row  )
  {

    $objid = $row['project_task_rowid'];
    $rowid = $this->id.'_row_'.$objid;

    // is this an insert or an update area
    if( $this->insertMode )
      $body = '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
    else
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';

    $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_task_title']).'</td>'.NL;
    $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="modal.php?c=Project.TaskType.listing" >'.Validator::sanitizeHtml($row['project_task_type_name']).'</a></td>'.NL;
    $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="modal.php?c=Project.TaskStatus.listing" >'.Validator::sanitizeHtml($row['project_task_status_name']).'</a></td>'.NL;

    if( $this->enableNav )
    {
      $navigation  = $this->buildActions( $objid );
      $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
    }

    // is this an insert or an update area
    if( $this->insertMode )
      $body .= '</tr>]]></htmlArea>'.NL;
    else
      $body .= ']]></htmlArea>'.NL;

    return $body;

  }//end public function buildAjaxTbody */


}//end class WgtTableUserTask

