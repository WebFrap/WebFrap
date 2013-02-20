<?php
/*******************************************************************************
          _______          ______    _______      ______    _______
         |   _   | ______ |   _  \  |   _   \    |   _  \  |   _   |
         |   1___||______||.  |   \ |.  1   / __ |.  |   \ |.  1___|
         |____   |        |.  |    \|.  _   \|__||.  |    \|.  __)_
         |:  1   |        |:  1    /|:  1    \   |:  1    /|:  1   |
         |::.. . |        |::.. . / |::.. .  /   |::.. . / |::.. . |
         `-------'        `------'  `-------'    `------'  `-------'
                             __.;:-+=;=_.
                                    ._=~ -...    -~:
                     .:;;;:.-=si_=s%+-..;===+||=;. -:
                  ..;::::::..<mQmQW>  :::.::;==+||.:;        ..:-..
               .:.:::::::::-_qWWQWe .=:::::::::::::::   ..:::-.  . -:_
             .:...:.:::;:;.:jQWWWE;.+===;;;;:;::::.=ugwmp;..:=====.  -
           .=-.-::::;=;=;-.wQWBWWE;:++==+========;.=WWWWk.:|||||ii>...
         .vma. ::;:=====.<mWmWBWWE;:|+||++|+|||+|=:)WWBWE;=liiillIv; :
       .=3mQQa,:=====+==wQWBWBWBWh>:+|||||||i||ii|;=$WWW#>=lvvvvIvv;.
      .--+3QWWc:;=|+|+;=3QWBWBWWWmi:|iiiiiilllllll>-3WmW#>:IvlIvvv>` .
     .=___<XQ2=<|++||||;-9WWBWWWWQc:|iilllvIvvvnvvsi|\'\?Y1=:{IIIIi+- .
     ivIIiidWe;voi+|illi|.+9WWBWWWm>:<llvvvvnnnnnnn}~     - =++-
     +lIliidB>:+vXvvivIvli_."$WWWmWm;:<Ilvvnnnnonnv> .          .- .
      ~|i|IXG===inovillllil|=:"HW###h>:<lIvvnvnnvv>- .
        -==|1i==|vni||i|i|||||;:+Y1""'i=|IIvvvv}+-  .
           ----:=|l=+|+|+||+=:+|-      - --++--. .-
                  .  -=||||ii:. .              - .
                       -+ilI+ .;..
                         ---.::....

********************************************************************************
*
* @author      : Dominik Bonsch <db@s-db.de>
* @date        :
* @copyright   : s-db.de (Softwareentwicklung Dominik Bonsch) <contact@s-db.de>
* @distributor : s-db.de <contact@s-db.de>
* @project     : S-DB Modules
* @projectUrl  : http://s-db.de
* @version     : 1
* @revision    : 1
*
* @licence     : S-DB Business <contact@s-db.de>
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyTask_Table_Element extends WgtTable
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
  public $id   = 'wgt_table-my_task';

  /**
   * the most likley class of a given query object
   *
   * @var MyTask_Table_Query
   */
  public $data = null;

  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $url  = array
  (
    'paging'  => array
    (
      Wgt::ACTION_PAGING ,
      'index.php?c=Wbfsys.Task.search'
    ),
    'edit'    => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Edit',
      'maintab.php?c=Wbfsys.Task.edit&amp;objid=',
      'control/edit.png',
      'wcm wcm_ui_tip',
      'wbfsys.task.label',
      Acl::UPDATE
    ),
    'show'    => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Show',
      'maintab.php?c=Wbfsys.Task.show&amp;objid=',
      'control/show.png',
      'wcm wcm_ui_tip',
      'wbfsys.task.label',
      Acl::ACCESS
    ),
    'delete'  => array
    (
      Wgt::ACTION_DELETE,
      'Delete',
      'index.php?c=Wbfsys.Task.delete&amp;objid=',
      'control/delete.png',
      'wcm wcm_ui_tip',
      'wbfsys.task.label',
      Acl::DELETE
    ),
    'rights'  => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Rights',
      'maintab.php?c=Wbfsys.Task_Acl_Dset.listing&amp;objid=',
      'control/rights.png',
      'wcm wcm_ui_tip',
      'wbfsys.task.label',
      Acl::ADMIN
    ),
    'sep'  => array
    (
      Wgt::ACTION_SEP
    ),
    'checkbox'  => array
    (
      Wgt::ACTION_CHECKBOX,
      'select',
      null,
      null,
      null,
      'wbf.label.select',
      Acl::ACCESS
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// context: table
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * parse the table
   *
   * @return string
   */
  public function buildHtml( )
  {
    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if ($this->html )
      return $this->html;

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid" >'.NL;
      $this->html .= $this->buildPanel();

      $this->html .= '<table id="'.$this->id.'-table" class="wgt-grid wcm wcm_ui_grid" >'.NL;
      $this->html .= $this->buildThead();
    }

    $this->html .= $this->buildTbody();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '</table>';
      $this->html .= $this->buildTableFooter();
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function buildHtml */

  /**
   * create the head for the table
   * @return string
   */
  public function buildThead( )
  {

    $this->numCols = 6;

    if ($this->enableNav)
      ++ $this->numCols;

    if ($this->enableMultiSelect)
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    if ($this->enableMultiSelect )
      $html .= '<th style="width:40px;">'.$this->view->i18n->l( 'Check', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Title','wbfsys.task.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('URL','wbfsys.task.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Progress','wbfsys.task.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Type','wbfsys.task.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Status','wbfsys.task.label').'</th>'.NL;

    // the default navigation col
    if ($this->enableNav) {
      $navWidth = count($this->actions)*30+5;
      $html .= '<th style="width:'.$navWidth.'px;">'.$this->view->i18n->l( 'Nav.', 'wbf.label'  ).'</th>'.NL;
    }

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

    // create the table body
    $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $num = 1;
    foreach ($this->data as $key => $row) {

      $objid       = $row['my_task_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      if ($this->enableMultiSelect) {
        $body .= '<td valign="top" style="text-align:center;" >
            <input type="checkbox" name="slct[]" value="'.$objid.'" class="wgt-ignore" />
          </td>'.NL;
      }

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['my_task_title']).'</td>'.NL;
      $body .= '<td valign="top" style="text-align:center;" >'.( trim($row['my_task_http_url'] ) == '' ? ' ' : '<a href="'.Validator::sanitizeHtml($row['my_task_http_url']).'">'.Validator::sanitizeHtml($row['my_task_http_url']).'</a>' ).'</td>'.NL;
      $body .= '<td valign="top" class="wcm wcm_ui_progress" >'.(!is_null($row['my_task_progress'])?$row['my_task_progress']:0).'</td>'.NL;
      $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="maintab.php?c=Wbfsys.TaskType.listing" >'.Validator::sanitizeHtml($row['wbfsys_task_type_name']).'</a></td>'.NL;
      $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="maintab.php?c=Wbfsys.TaskStatus.listing" >'.Validator::sanitizeHtml($row['wbfsys_task_status_name']).'</a></td>'.NL;

      if ($this->enableNav) {
        $navigation  = $this->rowMenu
          (
            $objid,
            $row
          );
        $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } //end foreach

    if ($this->dataSize > ($this->start + $this->stepSize) ) {
      $body .= '<tr><td colspan="'.$this->numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>'.$this->image('wgt/bar-loader.gif','loader').' Loading the next '.$this->stepSize.' entries.</td></tr>';
    }

    $body .= '</tbody>'.NL;
    //\ Create the table body
    return $body;

  }//end public function buildTbody */

  /**
   * parse the table
   *
   * @return string
   */
  public function buildAjax( )
  {

    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if ($this->xml )
      return $this->xml;

    if ($this->appendMode) {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="append" ><![CDATA['.NL;
    } else {
      $body = '';
    }

    foreach ($this->data as $key => $row) {
      $body .= $this->buildAjaxTbody($row );
    }//end foreach

    if ($this->appendMode) {
      $numCols = 6;

      if ($this->enableNav)
        ++ $numCols;

      if ($this->enableMultiSelect)
        ++ $numCols;

      if ($this->dataSize > ($this->start + $this->stepSize) ) {
        $body .= '<tr><td colspan="'.$numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>'.$this->image('wgt/bar-loader.gif','loader').' Loading the next '.$this->stepSize.' entries.</td></tr>';
      }

      $body .= ']]></htmlArea>';
    }

    $this->xml = $body;

    return $this->xml;

  }//end public function buildAjax */

  /**
   * create the body for the table
   * @param array $row
   * @return string
   */
  public function buildAjaxTbody($row  )
  {

    $objid = $row['my_task_rowid'];
    $rowid = $this->id.'_row_'.$objid;

    // is this an insert or an update area
    if ($this->insertMode) {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
    } elseif ($this->appendMode) {
      $body = '<tr id="'.$rowid.'" class="wcm wcm_ui_highlight" >'.NL;
    } else {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

    if ($this->enableMultiSelect) {
      $body .= '<td valign="top" style="text-align:center;" >
          <input type="checkbox" name="slct[]" value="'.$objid.'" class="wgt-ignore" />
        </td>'.NL;
    }

    $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['my_task_title']).'</td>'.NL;
    $body .= '<td valign="top" style="text-align:center;" >'.( trim($row['my_task_http_url'] ) == '' ? ' ' : '<a href="'.Validator::sanitizeHtml($row['my_task_http_url']).'">'.Validator::sanitizeHtml($row['my_task_http_url']).'</a>' ).'</td>'.NL;
    $body .= '<td valign="top" class="wcm wcm_ui_progress" >'.(!is_null($row['my_task_progress'])?$row['my_task_progress']:0).'</td>'.NL;
    $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="maintab.php?c=Wbfsys.TaskType.listing" >'.Validator::sanitizeHtml($row['wbfsys_task_type_name']).'</a></td>'.NL;
    $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="maintab.php?c=Wbfsys.TaskStatus.listing" >'.Validator::sanitizeHtml($row['wbfsys_task_status_name']).'</a></td>'.NL;

    if ($this->enableNav) {
      $navigation  = $this->rowMenu
      (
        $objid,
        $row
      );
      $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'.$navigation.'</td>'.NL;
    }

    // is this an insert or an update area
    if ($this->insertMode) {
      $body .= '</tr>]]></htmlArea>'.NL;
    } elseif ($this->appendMode) {
      $body .= '</tr>'.NL;
    } else {
      $body .= ']]></htmlArea>'.NL;
    }

    return $body;

  }//end public function buildAjaxTbody */

}//end class MyTask_Table_Element

