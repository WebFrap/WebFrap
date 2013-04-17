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

      'reopen'    => array(
        Wgt::ACTION_BUTTON_PUT,
        'Reopen',
        'ajax.php?c=Webfrap.Message.reopen&amp;objid=',
        'icon-envelope-alt',
        '',
        'wbf.label',
        Acl::UPDATE,
        Wgt::BUTTON_CHECK => function($row, $id, $value, $access) use ($user) {

          // nicht auf eigene mails replyen
          if ($row['wbfsys_message_id_sender'] == $user->getId()) {

            return ($row['wbfsys_message_id_sender_status'] == EMessageStatus::ARCHIVED);

          } else {

            return ($row['wbfsys_message_receiver_status'] == EMessageStatus::ARCHIVED);
          }

        }
      ),

      'archive'    => array(
        Wgt::ACTION_BUTTON_GET,
        'Archive',
        'maintab.php?c=Webfrap.Message.archive&amp;objid=',
        'icon-folder-close',
        '',
        'wbf.label',
        Acl::UPDATE,
        Wgt::BUTTON_CHECK => function($row, $id, $value, $access) use ($user) {

          // nicht auf eigene mails replyen
          if ($row['wbfsys_message_id_sender'] == $user->getId()  ) {

            return ($row['wbfsys_message_id_sender_status'] != EMessageStatus::ARCHIVED);

          } else {

            return ($row['wbfsys_message_receiver_status'] != EMessageStatus::ARCHIVED);
          }

        }
      ),

      'ham'    => array(
        Wgt::ACTION_BUTTON_PUT,
        'Ham',
        'ajax.php?c=Webfrap.Message.setSpam&spam=0&amp;objid=',
        'icon-thumbs-up',
        '',
        'wbf.label',
        Acl::UPDATE,
        Wgt::BUTTON_CHECK => function($row, $id, $value, $access) use ($user) {

          // nicht auf eigene mails replyen
          if ( (int)$row['wbfsys_message_spam_level'] != 0 ) {

            return true;

          } else {

            return false;
          }

        }
      ),

      'spam'    => array(
        Wgt::ACTION_BUTTON_PUT,
        'Spam',
        'ajax.php?c=Webfrap.Message.setSpam&spam=100&amp;objid=',
        'icon-thumbs-down',
        '',
        'wbf.label',
        Acl::UPDATE,
        Wgt::BUTTON_CHECK => function($row, $id, $value, $access) use ($user) {

          // nicht auf eigene mails replyen
          if ( (int)$row['wbfsys_message_spam_level'] > 75 ) {

            return false;

          } else {

            return true;
          }

        }
      ),
      'mark_read'    => array(
          Wgt::ACTION_BUTTON_PUT,
          'Mark as read',
          'ajax.php?c=Webfrap.Message.markAsRead&amp;objid=',
          'icon-eye-open',
          '',
          'wbf.label',
          Acl::UPDATE,
          Wgt::BUTTON_CHECK => function($row, $id, $value, $access) use ($user) {

            // nicht auf eigene mails replyen
            if ( (int)$row['wbfsys_message_receiver_status'] <= EMessageStatus::UPDATED ) {

              if( $row['wbfsys_message_id_receiver'] == $user->getId() )
                return true;
              else
                return false;

            } else {

              return false;
            }

          }
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
    $this->actions[] = 'reopen';
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


    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    $html .= '<th style="width:30px;" class="pos" >'.$this->view->i18n->l('Pos.', 'wbf.label'  ).'</th>'.NL;
    $html .= '<th style="width:20px" wgt_sort_name="order[type]" ></th>'.NL;
    $html .= '<th style="width:250px" wgt_sort_name="order[titel]" >'.$this->view->i18n->l('Title', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:250px" wgt_sort_name="order[sender]" >'.$this->view->i18n->l('Sender', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:250px" wgt_sort_name="order[receiver]" >'.$this->view->i18n->l('Receiver', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:80px" wgt_sort_name="order[date]" >'.$this->view->i18n->l('Date', 'wbf.label').'</th>'.NL;
    $html .= '<th style="width:115px"  wgt_sort_name="order[priority]" >'.$this->view->i18n->l('Status', 'wbf.label').'</th>'.NL;

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
    $iconStatus[EMessageStatus::IS_NEW] = '<i class="icon-envelope new" title="New message" ></i>';
    $iconStatus[EMessageStatus::UPDATED] = '<i class="icon-envelope update" title="Message was updated" ></i>';
    $iconStatus[EMessageStatus::OPEN] = '<i class="icon-folder-open-alt open" title="Message is open" ></i>';
    $iconStatus[EMessageStatus::ARCHIVED] = '<i class="icon-envelope-alt archive" title="Message was archived" ></i>';

    $iconPrio = array();

    $iconPrio[10] = '<i class="icon-flag min" title="min priority" ></i>';
    $iconPrio[20] = '<i class="icon-flag low" title="low priority" ></i>';
    $iconPrio[30] = '<i class="icon-flag avg" title="average priority" ></i>';
    $iconPrio[40] = '<i class="icon-flag high" title="high priority" ></i>';
    $iconPrio[50] = '<i class="icon-flag max" title="max priority" ></i>';

    $iconType = array();
    $iconType[EMessageAspect::MESSAGE] = '<i class="icon-envelope" ></i>';
    $iconType[EMessageAspect::DOCUMENT] = '<i class="icon-file-alt" ></i>';
    $iconType[EMessageAspect::DISCUSSION] = '<i class="icon-comments-alt" ></i>';

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
        .' class="wcm '.$rowWcm.' row'.$num.' "'
        .$rowParams
        .' id="'.$rowid.'" wgt_eid="'.$objid.'" >'.NL;

      $body .= '<td valign="top" class="pos" >'.$pos.'</td>'.NL;

      $body .= '<td valign="top" style="text-align:center;"  >'.$iconType[$row['wbfsys_message_main_aspect']].'</td>'.NL;


      $body .= '<td valign="top" >'
        . '<a class="wcm wcm_req_ajax" href="ajax.php?c=Webfrap.Message.showPreview&amp;objid='.$objid.'" >'
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



      $body .= '<td valign="top" style="text-align:center" >';

      if ($row['wbfsys_message_id_receiver'] == $user->getId()) {
        $isInbox = true;
      } else {
        $isInbox = false;
      }

      // action required

      $body .=  $row['task_id']
        ? '<i class="icon-tasks" title="Is Task" ></i> '
        : '';

      $body .=  $row['appoint_id']
        ? '<i class="icon-calendar" title="Is Appointment" ></i> '
        : '';


      // SPAM / HAM status
      $body .=  ($row['wbfsys_message_spam_level']>51)
        ? '<i class="icon-thumbs-down mal" title="is SPAM" ></i> '
        : '';

      // action required
      $body .=  ( 't' == $row['receiver_action_required'])
        ? '<i class="icon-exclamation-sign attention" title="Your action is required" ></i> '
        : '';

      // urgent
      $body .=  ( 't' == $row['flag_urgent'])
        ? '<i class="icon-time urgent" title="Ok, this getting a little urgent now!" ></i> '
        : '';

      // priority
      $body .=  ( $row['wbfsys_message_priority'] && ($row['wbfsys_message_priority'] > 30 || 10 == $row['wbfsys_message_priority'] )  )
        ? $iconPrio[$row['wbfsys_message_priority']].' '
        : ' ';

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

    $user = User::getActive();

    $iconStatus = array();
    $iconStatus[EMessageStatus::IS_NEW] = '<i class="icon-envelope new" title="New message" ></i>';
    $iconStatus[EMessageStatus::UPDATED] = '<i class="icon-envelope update" title="Message was updated" ></i>';
    $iconStatus[EMessageStatus::OPEN] = '<i class="icon-folder-open-alt open" title="Message is open" ></i>';
    $iconStatus[EMessageStatus::ARCHIVED] = '<i class="icon-envelope-alt archive" title="Message was archived" ></i>';

    $iconPrio = array();

    $iconPrio[10] = '<i class="icon-flag min" title="min priority" ></i>';
    $iconPrio[20] = '<i class="icon-flag low" title="low priority" ></i>';
    $iconPrio[30] = '<i class="icon-flag avg" title="average priority" ></i>';
    $iconPrio[40] = '<i class="icon-flag high" title="high priority" ></i>';
    $iconPrio[50] = '<i class="icon-flag max" title="max priority" ></i>';

    $iconType = array();
    $iconType[EMessageAspect::MESSAGE] = '<i class="icon-envelope" ></i>';
    $iconType[EMessageAspect::DOCUMENT] = '<i class="icon-file-alt" ></i>';
    $iconType[EMessageAspect::DISCUSSION] = '<i class="icon-comments-alt" ></i>';

    $objid = $row['wbfsys_message_rowid'];
    $rowid = $this->id.'_row_'.$objid;
    $num = 0;
    $pos = 1;

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

    $body .= '<td valign="top" class="pos" >'.$pos.'</td>'.NL;

    $body .= '<td valign="top" style="text-align:center;"  >'.$iconType[$row['wbfsys_message_main_aspect']].'</td>'.NL;


    $body .= '<td valign="top" >'
      .'<a class="wcm wcm_req_ajax" href="ajax.php?c=Webfrap.Message.showPreview&amp;objid='.$objid.'" >'
      .Validator::sanitizeHtml($row['wbfsys_message_title'])
     .'<a/></td>'.NL;

    $senderName = "{$row['wbfsys_role_user_name']} <{$row['core_person_lastname']}, {$row['core_person_firstname']}> ";
    $receiverName = "{$row['receiver_wbfsys_role_user_name']} <{$row['receiver_core_person_lastname']}, {$row['receiver_core_person_firstname']}> ";

    $body .= '<td valign="top" >'.Validator::sanitizeHtml($senderName).'</td>'.NL;
    $body .= '<td valign="top" >'.Validator::sanitizeHtml($receiverName).'</td>'.NL;


    $body .= '<td valign="top" >'.(
        '' != trim($row['wbfsys_message_m_time_created'])
        ? $this->view->i18n->date($row['wbfsys_message_m_time_created'])
        : ' '
    ).'</td>'.NL;



    $body .= '<td valign="top" style="text-align:center" >';

    if ($row['wbfsys_message_id_receiver'] == $user->getId()) {
      $isInbox = true;
    } else {
      $isInbox = false;
    }

    // action required

    $body .=  $row['task_id']
    ? '<i class="icon-tasks" title="Is Task" ></i> '
        : '';

    $body .=  $row['appoint_id']
    ? '<i class="icon-calendar" title="Is Appointment" ></i> '
        : '';


    // SPAM / HAM status
    $body .=  ($row['wbfsys_message_spam_level']>51)
    ? '<i class="icon-thumbs-down mal" title="is SPAM" ></i> '
        : '';

    // action required
    $body .=  ( 't' == $row['receiver_action_required'])
    ? '<i class="icon-exclamation-sign attention" title="Your action is required" ></i> '
        : '';

    // urgent
    $body .=  ( 't' == $row['flag_urgent'])
    ? '<i class="icon-time urgent" title="Ok, this getting a little urgent now!" ></i> '
        : '';

    // priority
    $body .=  ( $row['wbfsys_message_priority'] && ($row['wbfsys_message_priority'] > 30 || 10 == $row['wbfsys_message_priority'] )  )
    ? $iconPrio[$row['wbfsys_message_priority']].' '
        : ' ';

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
          href="ajax.php?c=Webfrap.Message.markReadAll"
        ><i class="icon-eye-open" ></i> Mark all as read</a></li>

        <li><a
          class="wcm wcm_req_put_selection"
          href="ajax.php?c=Webfrap.Message.markReadSelection"
          wgt_elem="table#{$this->id}-table"
        ><i class="icon-eye-open" ></i> Mark selected as read</a></li>

      </ul>
      <ul>

        <li><a
          class="wcm wcm_req_put"
          title="You are going to Archive ALL! Messages. Please confirm that you really want to do that."
          href="ajax.php?c=Webfrap.Message.archiveAll"
        ><i class="icon-folder-close" ></i> Archive all</a></li>

        <li><a
          class="wcm wcm_req_put_selection"
          href="ajax.php?c=Webfrap.Message.archiveSelection"
          wgt_elem="table#{$this->id}-table"
          title="Please confirm that you want to archive the selected Messages."
        ><i class="icon-folder-close" ></i> Archive selected</a></li>

      </ul>
      <ul>

        <li><a
          class="wcm wcm_req_del"
          title="You are going to delete ALL! Messages. Please confirm that you really want to do that."
          href="ajax.php?c=Webfrap.Message.deleteAll"
        ><i class="icon-remove" ></i> Delete all</a></li>

        <li><a
          class="wcm wcm_req_del_selection"
          href="ajax.php?c=Webfrap.Message.deleteSelection"
          wgt_elem="table#{$this->id}-table"
          title="Please confirm that you want to delete the selected Messages."
        ><i class="icon-remove" ></i> Delete selected</a></li>

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

