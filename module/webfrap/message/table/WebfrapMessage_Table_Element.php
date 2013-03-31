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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMessage_Table_Element extends WgtTable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the html id of the table tag, this id can be used to replace the table
   * or table contents via ajax interface.
   *
   * @var string $id
   */
  public $id   = 'wgt_table-user-messages';

  /**
   * the most likley class of a given query object
   *
   * @var CorePerson_Table_Query
   */
  public $data = null;

  /**
   * Das aktuelle User Object
   * @var User
   */
  public $user = null;

  /**
   * @var string
   */
  public $bodyHeight   = 'xxlarge';

 /**
  * Laden der Urls für die Actions
  */
  public function loadUrl()
  {

    $user = Webfrap::$env->getUser();

    $this->url  = array(
      'show'    => array(
        Wgt::ACTION_BUTTON_GET,
        'Show',
        'maintab.php?c=Webfrap.Message.formShow&amp;objid=',
        'icon-envelope',
        '',
        'wbf.label',
        Acl::ACCESS
      ),

      'forward'    => array(
        Wgt::ACTION_BUTTON_GET,
        'Forward',
        'maintab.php?c=Webfrap.Message.formForward&amp;objid=',
        'icon-share-alt',
        '',
        'wbf.label',
        Acl::INSERT
      ),

      'reply'    => array(
        Wgt::ACTION_BUTTON_GET,
        'Reply',
        'maintab.php?c=Webfrap.Message.formReply&amp;objid=',
        'icon-reply',
        '',
        'wbf.label',
        Acl::INSERT,
        Wgt::BUTTON_CHECK => function($row, $id, $value, $access) use ($user) {

          // nicht auf eigene mails replyen
          if ($row['wbfsys_message_id_sender'] == $user->getId()  ) {
            return false;
          }

          return true;
        }
      ),

      'archive'    => array(
        Wgt::ACTION_BUTTON_GET,
        'Archive',
        'maintab.php?c=Webfrap.Message.archive&amp;objid=',
        'icon-folder-close',
        '',
        'wbf.label',
        Acl::UPDATE
      ),

      'ham'    => array(
        Wgt::ACTION_BUTTON_PUT,
        'Ham',
        'ajax.php?c=Webfrap.Message.setSpam&spam=0&amp;objid=',
        'icon-thumbs-up',
        '',
        'wbf.label',
        Acl::UPDATE
      ),

      'spam'    => array(
        Wgt::ACTION_BUTTON_PUT,
        'Spam',
        'ajax.php?c=Webfrap.Message.setSpam&spam=100&amp;objid=',
        'icon-thumbs-down',
        '',
        'wbf.label',
        Acl::UPDATE
      ),

      'delete'  => array(
        Wgt::ACTION_DELETE,
        'Delete',
        'ajax.php?c=Webfrap.Message.deleteMessage&amp;objid=',
        'icon-remove-circle',
        '',
        'wbf.label',
        Acl::DELETE
      ),

      'sep'  => array(
        Wgt::ACTION_SEP
      )

    );

    $this->actions[] = 'show';
    $this->actions[] = 'reply';
    $this->actions[] = 'forward';
    $this->actions[] = 'sep';
    $this->actions[] = 'spam';
    $this->actions[] = 'ham';
    $this->actions[] = 'sep';
    $this->actions[] = 'archive';
    $this->actions[] = 'sep';
    $this->actions[] = 'delete';


  }//end public function loadUrl */

/*//////////////////////////////////////////////////////////////////////////////
// Context: Table
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * parse the table
   *
   * @return string
   */
  public function buildHtml()
  {
    $conf = $this->getConf();

    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if ($this->html)
      return $this->html;

    if (DEBUG)
      $renderStart = Webfrap::startMeasure();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid" >'.NL;
      $this->html .= '<var id="'.$this->id.'-table-cfg-grid" >{
        "height":"medium",
        "search_form":"'.$this->searchForm.'"
      }</var>';
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

    if (DEBUG)
      Debug::console("table ".__METHOD__." {$this->id} rendertime: ".Webfrap::getDuration($renderStart));

    return $this->html;

  }//end public function buildHtml */

  /**
   * create the head for the table
   * @return string
   */
  public function buildThead()
  {
    $this->numCols = 9;

    if ($this->enableNav)
      ++ $this->numCols;

    $iconInbox   = $this->icon('message/in.png', 'Inbox');
    $iconOutbox  = $this->icon('message/out.png', 'Outbox');

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    $html .= '<th style="width:30px;" class="pos" >'.$this->view->i18n->l('Pos.', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:55px" >'.$this->view->i18n->l('Status', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:250px" >'.$this->view->i18n->l('Title', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:250px" >'.$this->view->i18n->l('Sender', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:250px" >'.$this->view->i18n->l('Receiver', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:80px" >'.$this->view->i18n->l('Date', 'wbf.label').'</th>'.NL;

    // the default navigation col
    if ($this->enableNav) {
      $html .= '<th style="width:75px;">'.$this->view->i18n->l('Menu', 'wbf.label'  ).'</th>'.NL;
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

    $user = User::getActive();

    $iconStatus = array();
    $iconStatus[EMessageStatus::IS_NEW] = $this->icon('message/mail_new.png', 'New');
    $iconStatus[EMessageStatus::OPEN] = $this->icon('message/mail_open.png', 'Open');
    $iconStatus[EMessageStatus::ARCHIVED] = $this->icon('message/mail_archive.png', 'Archive');

    $iconPrio = array();

    $iconPrio[10] = $this->icon('priority/min.png', 'Very Low');
    $iconPrio[20] = $this->icon('priority/low.png', 'Low');
    $iconPrio[30] = $this->icon('priority/normal.png', 'Normal');
    $iconPrio[40] = $this->icon('priority/high.png', 'High');
    $iconPrio[50] = $this->icon('priority/max.png', 'Very Heigh');

    // create the table body
    $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $num = 1;
    $pos = 1;
    $data = $this->data->getAll();

    foreach ($data as $key => $row) {

      $objid       = $row['wbfsys_message_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $rowWcm       = '';
      $rowParams   = '';
      $dsUrl        = null;
      // check if the row has
      if ($dsUrl = $this->getActionUrl($objid, $row)) {
        $rowWcm     .= ' wcm_control_access_dataset';
        $rowParams .= ' wgt_url="'.$dsUrl.'" ';
      }

      $body .= '<tr '
        .' class="wcm '.$rowWcm.' row'.$num.' good"'
        .$rowParams
        .' id="'.$rowid.'" wgt_eid="'.$objid.'" >'.NL;

      $body .= '<td valign="top" class="pos" >'.$pos.'</td>'.NL;

      $body .= '<td valign="top" style="text-align:center" >';

      if ($row['wbfsys_message_id_receiver'] == $user->getId()) {
        $isInbox = true;
      } else {
        $isInbox = false;
      }

      // priority
      $body .=  $row['wbfsys_message_priority']
        ? $iconPrio[$row['wbfsys_message_priority']].' '
        : $iconPrio[30].' ';

      if ($isInbox) {

        // status
        $body .= isset( $iconStatus[(int) $row['wbfsys_message_receiver_status']])
          ? $iconStatus[(int) $row['wbfsys_message_receiver_status']]
          : $iconStatus[EMessageStatus::IS_NEW];

      } else {

        // status
        $body .= $row['wbfsys_message_id_sender_status']
          ? $iconStatus[(int) $row['wbfsys_message_id_sender_status']]
          : $iconStatus[EMessageStatus::IS_NEW];

      }

      $body .= '</td>'.NL;

      $body .= '<td valign="top" >'
        . '<a class="wcm wcm_req_ajax" href="maintab.php?c=Webfrap.Message.formShow&amp;objid='.$objid.'" >'
        . Validator::sanitizeHtml($row['wbfsys_message_title'])
        . '<a/></td>'.NL;

      $senderName = "{$row['wbfsys_role_user_name']} <{$row['core_person_lastname']}, {$row['core_person_firstname']}> ";
      $receiverName = "{$row['receiver_wbfsys_role_user_name']} <{$row['receiver_core_person_lastname']}, {$row['receiver_core_person_firstname']}> ";

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($senderName).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($receiverName).'</td>'.NL;


      $body .= '<td valign="top" >'.(
          '' != trim($row['wbfsys_message_m_time_created'])
          ? $this->view->i18n->date($row['wbfsys_message_m_time_created'])
          : ' '
        ).'</td>'.NL;

      if ($this->enableNav) {
        $navigation  = $this->rowMenu(
          $objid,
          $row
        );
        $body .= '<td valign="top" style="text-align:center;" '
          .' class="wcm wcm_ui_buttonset nav" >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $num ++;
      $pos ++;
      if ($num > $this->numOfColors)
        $num = 1;

    } //end foreach

    if ($this->dataSize > ($this->start + $this->stepSize)) {
      $body .= '<tr class="wgt-block-appear" >'
        .'<td class="pos" >&nbsp;</td>'
        .'<td colspan="'.$this->numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  >'
        .'<var>'.($this->start + $this->stepSize).'</var>'
        .$this->image('wgt/bar-loader.gif','loader').' Loading the next '.$this->stepSize.' entries.</td>'
        .'</tr>';
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

    $this->numCols = 9;

    if ($this->enableNav)
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
      $numCols = 9;

      if ($this->enableNav)
        ++ $numCols;

      if ($this->dataSize > ($this->start + $this->stepSize)) {
        $body .= '<tr class="wgt-block-appear" ><td class="pos" ></td><td colspan="'.$numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>'.$this->image('wgt/bar-loader.gif','loader').' Loading the next '.$this->stepSize.' entries.</td></tr>';
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

    $objid = $row['core_person_rowid'];
    $rowid = $this->id.'_row_'.$objid;

    $user = User::getActive();

    $iconStatus = array();
    $iconStatus[EMessageStatus::IS_NEW] = $this->icon('message/mail_new.png', 'New');
    $iconStatus[EMessageStatus::OPEN] = $this->icon('message/mail_open.png', 'Open');
    $iconStatus[EMessageStatus::ARCHIVED] = $this->icon('message/mail_archive.png', 'Archive');

    $iconPrio = array();

    $iconPrio[10] = $this->icon('priority/min.png', 'Very Low');
    $iconPrio[20] = $this->icon('priority/low.png', 'Low');
    $iconPrio[30] = $this->icon('priority/normal.png', 'Normal');
    $iconPrio[40] = $this->icon('priority/high.png', 'High');
    $iconPrio[50] = $this->icon('priority/max.png', 'Very Heigh');

    $iconInbox   = $this->icon('message/inbox.png', 'Inbox');
    $iconOutbox  = $this->icon('message/outbox.png', 'Outbox');

    // is this an insert or an update area
    if ($this->insertMode) {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" >'
        .'<![CDATA[<tr '
        .' wgt_eid="'.$objid.'" '
        .' class="wcm wcm_ui_highlight node-'.$objid.'" '
        .' id="'.$rowid.'" >'.NL;
    } elseif ($this->appendMode) {
      $body = '<tr id="'.$rowid.'" '
        .' wgt_eid="'.$objid.'" '
        .' class="wcm wcm_ui_highlight node-'.$objid.'" >'.NL;
    } else {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

    $body .= '<td valign="top" class="pos" >'.($key+1).'</td>'.NL;

      $body .= '<td valign="top" style="text-align:center" >';

      if ($row['wbfsys_message_id_receiver'] == $user->getId()) {
        $iconType = $iconInbox;
        $isInbox = true;
      } else {
        $iconType = $iconOutbox;
        $isInbox = false;
      }

      // priority
      $body .=  $row['wbfsys_message_priority']
        ? $iconPrio[$row['wbfsys_message_priority']].' '
        : $iconPrio[30].' ';

      if ($isInbox) {

        // status
        $body .= isset( $iconStatus[(int) $row['wbfsys_message_receiver_status']])
          ? $iconStatus[(int) $row['wbfsys_message_receiver_status']]
          : $iconStatus[EMessageStatus::IS_NEW];

        $userName = "{$row['wbfsys_role_user_name']} <{$row['core_person_lastname']}, {$row['core_person_firstname']}> ";
      } else {

        // status
        $body .= $row['wbfsys_message_id_sender_status']
          ? $iconStatus[(int) $row['wbfsys_message_id_sender_status']]
          : $iconStatus[EMessageStatus::IS_NEW];

        $userName = "{$row['receiver_wbfsys_role_user_name']} <{$row['receiver_core_person_lastname']}, {$row['receiver_core_person_firstname']}> ";
      }

      $body .= '</td>'.NL;

      $body .= '<td valign="top" >'
        . '<a class="wcm wcm_req_ajax" href="maintab.php?c=Webfrap.Message.showMessage&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid='.$objid.'" >'
        . Validator::sanitizeHtml($row['wbfsys_message_title'])
        . '<a/></td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($userName).'</td>'.NL;

      $body .= '<td valign="top" >'.(
        '' != trim($row['wbfsys_message_m_time_created'])
        ? $this->view->i18n->date($row['wbfsys_message_m_time_created'])
        : ' '
      ).'</td>'.NL;

      if ($this->enableNav) {
        $navigation  = $this->rowMenu (
          $objid,
          $row
        );
        $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'.$navigation.'</td>'.NL;
      }

    $body .= '</tr>'.NL;

    $num ++;
    if ($num > $this->numOfColors)
      $num = 1;

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

    $accessPath = $this->getAccessPath();

    $html = '<div class="wgt-panel wgt-border-top" >'.NL;
    $html .= ' <div class="right menu"  >';
    $html .=     $this->menuTableSize();
    $html .= ' </div>';
    $html .= ' <div class="menu" style="float:left;width:200px;" >';

    $htmlDelete = '';


    $html .=   <<<HTML

 <div class="wgt-panel-control" id="{$this->id}-list-action" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    tabindex="-1"
    id="{$this->id}-list-action-cntrl"
    wgt_drop_box="{$this->id}-list-action-menu" ><i class="icon-list" ></i> List Menu</button>
  </div>
  <div class="wgt-dropdownbox" id="{$this->id}-list-action-menu" >
      <ul>

        <li><a
          class="wcm wcm_req_put"
          title="You are going to Archive ALL! Messages. Please confirm that you really want to do that."
          href="ajax.php?c=Webfrap.Message.archiveAll"
        ><i class="icon-folder-close" ></i> Archive all Messages</a></li>

        <li><a
          class="wcm wcm_req_put_selection"
          href="ajax.php?c=Webfrap.Message.archiveSelection"
          wgt_elem="table#{$this->id}-table"
          title="Please confirm that you want to archive the selected Messages."
        ><i class="icon-folder-close" ></i> Archive selected Messages</a></li>

      </ul>
      <ul>

        <li><a
          class="wcm wcm_req_del"
          title="You are going to delete ALL! Messages. Please confirm that you really want to do that."
          href="ajax.php?c=Webfrap.Message.deleteAll"
        ><i class="icon-remove" ></i> Delete all Messages</a></li>

        <li><a
          class="wcm wcm_req_del_selection"
          href="ajax.php?c=Webfrap.Message.deleteSelection"
          wgt_elem="table#{$this->id}-table"
          title="Please confirm that you want to delete the selected Messages."
        ><i class="icon-remove" ></i> Delete selected Messages</a></li>

      </ul>
   </div>
  <var id="{$this->id}-list-action-cntrl-cfg-dropmenu"  >{"align":"left","valign":"top"}</var>

  <div class="wgt-panel-control" >
    <button
      onclick="\$S('table#{$this->id}-table').grid('deSelectAll');"
      class="wcm wcm_ui_tip wgt-button"
      tabindex="-1"
      tooltip="Deselect all entries" ><i class="icon-check-empty" ></i></button>
  </div>

HTML;


    $html .= ' </div>';
    $html .= ' <div class="menu"  style="text-align:center;margin:0px auto;" >';
    $html .=     $this->menuCharFilter();
    $html .= ' </div>';
    $html .= $this->metaInformations();
    $html .= '</div>'.NL;

    return $html;

  }//end public function buildTableFooter */

}//end class CorePerson_Table_Element

