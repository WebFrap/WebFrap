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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapAnnouncement_Table_Element extends WgtTable
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
  public $id   = 'wgt_table-webfrap_announcement';

  /**
   * the most likley class of a given query object
   *
   * @var WbfsysAnnouncement_Table_Query
   */
  public $data = null;

  /**
   * Namespace information für die Tabelle
   *
   * @var string $namespace
   */
  public $namespace   = 'WebfrapAnnouncement';

  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $url  = array
  (
    'edit'    => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Edit',
      'modal.php?c=Webfrap.Announcement.edit&amp;target_mask=WebfrapAnnouncement&amp;ltype=table&amp;objid=',
      'control/edit.png',
      '',
      'wbfsys.announcement.label',
      Acl::UPDATE
    ),

    'delete'  => array
    (
      Wgt::ACTION_DELETE,
      'Delete',
      'ajax.php?c=Wbfsys.Announcement.delete&amp;target_mask=WbfsysAnnouncement&amp;ltype=table&amp;objid=',
      'control/delete.png',
      '',
      'wbfsys.announcement.label',
      Acl::DELETE
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
  public function buildHtml()
  {
    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if ($this->html)
      return $this->html;

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid" >'.NL;
      $this->html .= $this->buildPanel();

      $this->html .= '<table id="'.$this->id
        .'-table" class="wgt-grid wcm wcm_widget_grid hide-head" >'.NL;

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
  public function buildThead()
  {

    $this->numCols = 3;

    if ($this->enableNav)
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    $html .= '<th style="width:30px;">'.$this->view->i18n->l('Pos.', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:250px" >'.$this->view->i18n->l('Title', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:80px" >'.$this->view->i18n->l('Channel', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:80px" >'.$this->view->i18n->l('Importance', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:80px" >'.$this->view->i18n->l('Type', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:190px" >'.$this->view->i18n->l('Creator', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:75px" >'.$this->view->i18n->l('Created', 'wbf.label').'</th>'.NL;

    // the default navigation col
    if ($this->enableNav) {
      $navWidth = count($this->actions)*30+5;
      $html .= '<th style="width:'.$navWidth.'px;">'.$this->view->i18n->l('Nav.', 'wbf.label'  ).'</th>'.NL;
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
  public function buildTbody()
  {

    // create the table body
    $body = '<tbody>'.NL;

    $priorityContainer = new WgtInputPriority('l-prio-dp');

    // simple switch method to create collored rows
    $num = 1;
    $pos = 1;

    foreach ($this->data as $key => $row) {

      $objid       = $row['wbfsys_announcement_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= <<<HTML
    <tr
      class="wcm wcm_control_access_dataset node-{$objid} row{$num}"
      id="{$this->id}_row_{$objid}"
      wgt_url="{$this->url['edit'][2]}{$objid}" >

HTML;

      $body .= '<td valign="top" class="pos" >'.$pos.'</td>'.NL;

      // title
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_announcement_title']).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_announcement_channel_name']).'</td>'.NL;

      // importance
      $prioIcon  = '';
      $prioLabel = '';

      if ($row['wbfsys_announcement_importance']) {
        $prioLabel = $priorityContainer->getLabel($row['wbfsys_announcement_importance']);
        $prioIcon  = $this->icon
        (
          $priorityContainer->getIcon($row['wbfsys_announcement_importance']),
          $prioLabel
        );
      }
      $body .= '<td valign="top" >'.$prioIcon.' '.$prioLabel.'</td>'.NL;

      // type
      $body .= '<td valign="top" >'.EWbfsysAnnouncementType::label($row['wbfsys_announcement_type']).'</td>'.NL;

      // creator
      $userName = "({$row['wbfsys_role_user_name']}) {$row['core_person_lastname']}, {$row['core_person_firstname']} ";
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($userName).'</td>'.NL;

      // created
      $body .= '<td valign="top" >'.($row['wbfsys_announcement_m_time_created']
        ? $this->i18n->date($row['wbfsys_announcement_m_time_created'])
        : '&nbsp;').'</td>'.NL;

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
      if ($num > $this->numOfColors)
        $num = 1;

      ++$pos;

    } //end foreach

    if ($this->dataSize > ($this->start + $this->stepSize)) {
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
  public function buildAjax()
  {
    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if ($this->xml)
      return $this->xml;

    $this->numCols = 3;

    if ($this->enableNav)
      ++ $this->numCols;

    if ($this->enableMultiSelect)
      ++ $this->numCols;

    if ($this->appendMode) {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="append" ><![CDATA['.NL;
    } else {
      $body = '';
    }

    foreach ($this->data as $key => $row) {
      $body .= $this->buildAjaxTbody($row);
    }//end foreach

    if ($this->appendMode) {
      $numCols = 3;

      if ($this->enableNav)
        ++ $numCols;

      if ($this->enableMultiSelect)
        ++ $numCols;

      if ($this->dataSize > ($this->start + $this->stepSize)) {
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

    $objid = $row['wbfsys_announcement_rowid'];
    $rowid = $this->id.'_row_'.$objid;

    // is this an insert or an update area
    if ($this->insertMode) {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
    } elseif ($this->appendMode) {
      $body = '<tr id="'.$rowid.'" class="wcm wcm_ui_highlight" >'.NL;
    } else {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

      $body .= '<td valign="top" class="pos" >1</td>'.NL;

      // title
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_announcement_title']).'</td>'.NL;

      // channel
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_announcement_channel_name']).'</td>'.NL;

      // importance
      $prioIcon  = '';
      $prioLabel = '';

      if ($row['wbfsys_announcement_importance']) {
        $priorityContainer = new WgtInputPriority('l-prio-dp');
        $prioLabel = $priorityContainer->getLabel($row['wbfsys_announcement_importance']);
        $prioIcon  = $this->icon
        (
          $priorityContainer->getIcon($row['wbfsys_announcement_importance']),
          $prioLabel
        );
      }
      $body .= '<td valign="top" >'.$prioIcon.' '.$prioLabel.'</td>'.NL;

      // type
      $body .= '<td valign="top" >'.EWbfsysAnnouncementType::label($row['wbfsys_announcement_type']).'</td>'.NL;

      // creator
      $userName = "({$row['wbfsys_role_user_name']}) {$row['core_person_lastname']}, {$row['core_person_firstname']} ";
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($userName).'</td>'.NL;

      // created
      $body .= '<td valign="top" >'.($row['wbfsys_announcement_m_time_created']
        ? $this->i18n->date($row['wbfsys_announcement_m_time_created'])
        : '&nbsp;').'</td>'.NL;

      if ($this->enableNav) {

        $navigation  = $this->rowMenu
          (
            $objid,
            $row
          );

        $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'
          .$navigation.'</td>'.NL;
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

  /**
   * Der Footer der Tabelle
   * @return string
   */
  public function buildTableFooter()
  {

    $html = '<div class="wgt-panel wgt-border-top" >'.NL;
    $html .= ' <div class="right menu"  >';
    $html .=     $this->menuTableSize();
    $html .= ' </div>';
    $html .= ' <div class="menu" style="float:left;width:100px;" >';
    //$html .=   $this->menuTableSize();
    $html .= ' </div>';
    $html .= ' <div class="menu"  style="text-align:center;margin:0px auto;" >';

    $html .= ' </div>';
    $html .= $this->metaInformations();
    $html .= '</div>'.NL;

    return $html;

  }//end public function buildTableFooter */

}//end class WbfsysAnnouncement_Table_Element

