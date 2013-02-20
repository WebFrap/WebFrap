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
class WgtTableWebfrapTask extends WgtTable
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the id of the table
   *
   * @var string $id
   */
  public $id = 'wgtTable_webfrap_inbox';

  /**
   * List with all URLS
   * @var array
   */
  public $url = array
  (
    'paging'  => array( Wgt::ACTION_PAGING , 'index.php?c=Project.Alias.search'  )  ,
    'show'    => array( Wgt::ACTION_AJAX_GET, 'show' , 'index.php?c=Project.Alias.show&amp;objid=' , 'control/show.png' , 'wcm wcm_req_ajax' ,'project.alias.label.tableTitleShow' )  ,
    'edit'    => array( Wgt::ACTION_AJAX_GET, 'edit' , 'index.php?c=Webfrap.Message.edit&amp;objid=' , 'control/edit.png' , 'wcm wcm_req_ajax' ,'project.alias.label.tableTitleEdit' )  ,
    'delete'  => array( Wgt::ACTION_AJAX_GET, 'delete' , 'index.php?c=Project.Alias.delete&amp;objid=' , 'control/delete.png' , 'wcm wcm_req_del' , 'project.alias.label.tableTitleDelete'  )  ,
  );

/*//////////////////////////////////////////////////////////////////////////////
//  Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the table
   *
   * @return String
   */
  public function build( )
  {

    if ($this->html )
      return $this->html;

    $this->numCols = 4;

    /*
      'wbfsys_task_rowid'      => '1',
      'wbfsys_task_title'      => 'a task',
      'wbfsys_task_progress'   => '44',
      'wbfsys_task_priority'   => '42',
      'wbfsys_task_m_created'  => '2009-11-12',
     */

    // Creating the Head
    $head = '<thead class="ui-widget-header" >'.NL;
    $head .= '<tr>'.NL;
    $head .= '<th>priority</th>'.NL;
    $head .= '<th>date</th>'.NL;
    $head .= '<th style="width:250px;" >title</th>'.NL;
    $head .= '<th style="width:50px;" >progress</th>'.NL;
    $head .= '<th style="width:70px;">'.I18n::s( 'nav', 'wbf.text.tableNav'  ).'</th>'.NL;
    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody class="ui-widget-content" >'.NL;

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;
    foreach ($this->data as $key => $row) {

      $objid  = $row['wbfsys_task_rowid'];

      $rowid = $this->id.'_row_'.$objid;
      $navigation = $this->rowMenu($objid, $row );

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_task_priority'] ).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_task_m_created'] ).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_task_title'] ).'</td>'.NL;
      $body .= '<td valign="top" class="wcm wcm_ui_progress" >'.(!is_null($row['wbfsys_task_progress'])?$row['wbfsys_task_progress']:0).'</td>'.NL;

      $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } // ENDE FOREACH

    $body .= '</tbody>'.NL;
    //\ Create the table body

    if (!$this->replace )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="full" >'.NL;

    $this->html .= $head;
    $this->html .= $body;

    $this->html .= '<tfoot class="ui-widget-footer" >'.NL;
    $this->html .= '<tr><td colspan="'.$this->numCols.'" >'.NL;
    $this->html .= $this->pagingMenu($this->url['paging'][1]  );
    $this->html .= '</td></tr>'.NL;
    $this->html .= '</tfoot>'.NL;

    $this->html .= '</table>';

    if (!$this->replace) {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function build */

  /**
   * build the table
   *
   * @return String
   */
  public function buildAjaxRows( )
  {

    if ($this->html )
      return $this->html;

    $body = '';

    foreach ($this->data as $key => $row) {

      $objid = $row['project_alias_rowid'];

      $rowid       = $this->id.'_row_'.$objid;
      $navigation  = $this->rowMenu($objid, $row );

      if ($this->ajaxInsert )
        $body .= '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
      else
        $body .= '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';

      $body .= '<td valign="top" class="ignore" style="text-align:center;" ><img class="icon xsmall cursor_icon" src="'.View::$themePath.'icons/xsmall/'.$this->imgIcon.'" /></td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_alias_name'] ).'</td>'.NL;
// project_alias_comment table
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_alias_version'] ).'</td>'.NL;
// project_alias_id_project table

      $body .= '<td valign="top" class="ignore" style="text-align:center;" >'.$navigation.'</td>'.NL;

      if ($this->ajaxInsert )
        $body .= '</tr>]]></htmlArea>'.NL;
      else
        $body .= ']]></htmlArea>'.NL;

    }//end foreach

    $this->html = $body;

    return $this->html;

  }//end public function buildAjaxRows */

  /**
   * build the table
   *
   * @return String
   */
  public function buildOverview( )
  {

    if ($this->html )
      return $this->html;

    $this->numCols = 2;

    // Creating the Head
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;
    $head .= '<th style="width:50px;">'.I18n::s( 'icon', 'wbf.text.icon' ).'</th>'.NL;

    $head .= '<th style="width:70px;">'.I18n::s( 'nav', 'wbf.text.tableNav'  ).'</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;
    foreach ($this->data as $key => $row) {
      $objid = $row['project_alias_rowid'];

      $rowid = $this->id.'_row_'.$objid;
      $navigation = $this->rowMenu($objid, $row );

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" style="text-align:center;" >
        <img class="icon xsmall cursor_icon" src="'.View::$themePath.'icons/xsmall/'.$this->imgIcon.'" /></td>'.NL;
// project_alias_name overview
// project_alias_comment overview
// project_alias_version overview
// project_alias_id_project overview

      $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } // ENDE FOREACH

    $body .= '</tbody>'.NL;
    //\ Create the table body

    if (!$this->replace )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="wgtTable" >'.NL;

    $this->html .= $head;
    $this->html .= $body;

    $this->html .= '<tfoot>'.NL;
    $this->html .= '<tr class="wgtTableNavigation" ><td colspan="'.$this->numCols.'" >'.NL;
    $this->html .= $this->pagingMenu($this->url['paging'][1]  );
    $this->html .= '</td></tr>'.NL;
    $this->html .= '</tfoot>'.NL;

    $this->html .= '</table>';

    if (!$this->replace) {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function buildOverview */

  /**
   * build the table
   *
   * @return String
   */
  public function buildOverviewAjaxRows( )
  {

    if ($this->html )
      return $this->html;

    $body = '';

    foreach ($this->data as $key => $row) {

      $objid = $row['project_alias_rowid'];

      $rowid       = $this->id.'_row_'.$objid;
      $navigation  = $this->rowMenu($objid, $row  );

      if ($this->ajaxInsert )
        $body .= '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
      else
        $body .= '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';

      $body .= '<td valign="top" class="ignore" style="text-align:center;" ><img class="icon xsmall cursor_icon" src="'.View::$themePath.'icons/xsmall/'.$this->imgIcon.'" /></td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_alias_name'] ).'</td>'.NL;
// project_alias_comment table
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['project_alias_version'] ).'</td>'.NL;
// project_alias_id_project table

      $body .= '<td valign="top" class="ignore" style="text-align:center;" >'.$navigation.'</td>'.NL;

      if ($this->ajaxInsert )
        $body .= '</tr>]]></htmlArea>'.NL;
      else
        $body .= ']]></htmlArea>'.NL;

    }//end foreach

    $this->html = $body;

    return $this->html;

  }//end public function buildOverviewAjaxRows */

/*//////////////////////////////////////////////////////////////////////////////
//  Javascript
//////////////////////////////////////////////////////////////////////////////*/

}//end class WgtTableProjectAliasGenf

