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
 *
 * @package WebFrap
 * @subpackage Modprofiles
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Widget_Table_Element extends WgtTable
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
  public $id   = 'wgt_table-my_message';

  /**
   * the most likley class of a given query object
   *
   * @var WbfsysMessage_Table_Query
   */
  public $data = null;

  /**
   * Namespace information für die Tabelle
   *
   * @var string $namespace
   */
  public $namespace   = 'MyMessage_Widget';
 

  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $url  = array
  (
    'show'    => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Show',
      'maintab.php?c=My.Message_Crud.show&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid=',
      'message/mail_open.png',
      'wcm wcm_ui_tip',
      'wbfsys.message.label',
      Acl::ACCESS
    ),
    /*
    'respond'    => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Respond',
      'maintab.php?c=My.Message_Crud.respond&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid=',
      'message/mail_respond.png',
      'wcm wcm_ui_tip',
      'wbfsys.message.label',
      Acl::ACCESS
    ),
    'forward'    => array
    (
      Wgt::ACTION_BUTTON_GET,
      'Respond',
      'maintab.php?c=My.Message_Crud.forward&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid=',
      'message/mail_forward.png',
      'wcm wcm_ui_tip',
      'wbfsys.message.label',
      Acl::ACCESS
    ),
    */
    'archive'  => array
    (
      Wgt::ACTION_BUTTON_PUT,
      'Archive',
      'ajax.php?c=My.Message_Crud.archive&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid=',
      'message/mail_archive.png',
      'wcm wcm_ui_tip',
      'wbfsys.message.label',
      Wgt::BUTTON_CONFIRM => 'Confirm to archive this message'
      
    ),
    'sep'  => array
    (
      Wgt::ACTION_SEP
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
    if ($this->insertMode )
    {
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid" >'.NL;
      $this->html .= $this->buildPanel();

      $this->html .= '<table id="'.$this->id
        .'-table" class="wgt-grid wcm wcm_widget_grid hide-head" >'.NL;
        
      $this->html .= $this->buildThead();
    }

    $this->html .= $this->buildTbody();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode )
    {
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

    $this->numCols = 3;

    if ($this->enableNav )
      ++ $this->numCols;

    if ($this->enableMultiSelect )
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    if ($this->enableMultiSelect )
      $html .= '<th style="width:40px;">'.$this->view->i18n->l( 'Check', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:250px" >'.$this->view->i18n->l( 'Title', 'wbfsys.message.label' ).'</th>'.NL;
    $html .= '<th style="width:55px" >'.$this->view->i18n->l( 'In/Out', 'wbfsys.message.label' ).'</th>'.NL;
    $html .= '<th style="width:55px" >'.$this->view->i18n->l( 'Status', 'wbfsys.message.label' ).'</th>'.NL;
    $html .= '<th style="width:250px" >'.$this->view->i18n->l( 'Sender / Receiver', 'wbfsys.message.label' ).'</th>'.NL;
    $html .= '<th style="width:50px" >'.$this->view->i18n->l( 'Prio', 'wbfsys.message.label' ).'</th>'.NL;
    $html .= '<th style="width:80px" >'.$this->view->i18n->l( 'Date', 'wbfsys.message.label' ).'</th>'.NL;


    // the default navigation col
    if ($this->enableNav )
    {
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
    
    $user = Webfrap::$env->getUser();

    // create the table body
    $body = '<tbody>'.NL;
    
    $iconStatus = array();
    $iconStatus[EMessageStatus::IS_NEW] = $this->icon('message/mail_new.png', 'New' );
    $iconStatus[EMessageStatus::OPEN] = $this->icon('message/mail_open.png', 'Open' );
    $iconStatus[EMessageStatus::ARCHIVED] = $this->icon('message/mail_archive.png', 'Archive' );

    $iconPrio = array();
    
    $iconPrio[10] = $this->icon( 'priority/min.png', 'Very Low' );
    $iconPrio[20] = $this->icon( 'priority/low.png', 'Low' );
    $iconPrio[30] = $this->icon( 'priority/normal.png', 'Normal' );
    $iconPrio[40] = $this->icon( 'priority/high.png', 'High' );
    $iconPrio[50] = $this->icon( 'priority/max.png', 'Very Heigh' );
    
    $iconInbox   = $this->icon( 'message/inbox.png', 'Inbox' );
    $iconOutbox  = $this->icon( 'message/outbox.png', 'Outbox' );
    
    // simple switch method to create collored rows
    $num = 1;
    foreach($this->data as $key => $row   )
    {

      $objid       = $row['wbfsys_message_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;

      $body .= '<td valign="top" >'
        . '<a class="wcm wcm_req_ajax" href="maintab.php?c=My.Message_Crud.show&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid='.$objid.'" >'
        . Validator::sanitizeHtml($row['wbfsys_message_title'])
        . '<a/></td>'.NL;

      if ($row['wbfsys_message_id_sender'] == $user->getId() )
      {
        $iconType = $iconOutbox;
        $isInbox = false;
      } else {
        $iconType = $iconInbox;
        $isInbox = true;
      }
      
      $body .= '<td valign="top" style="text-align:center" >'.$iconType.'</td>'.NL;
      
      if ($isInbox )
      {
        // status
        $body .= '<td valign="top" style="text-align:center" >'.
          (
            isset($row['wbfsys_message_receiver_id_status']) && isset($iconStatus[$row['wbfsys_message_receiver_id_status']])
              ? $iconStatus[$row['wbfsys_message_receiver_id_status']]
              : $iconStatus[EMessageStatus::IS_NEW]
          ).'</td>'.NL;
      
      
        $userName = "({$row['wbfsys_role_user_name']}) {$row['core_person_lastname']}, {$row['core_person_firstname']} ";
      } else {
        // status
        $body .= '<td valign="top" style="text-align:center" >'.
          (
            $row['wbfsys_message_id_sender_status']
              ? $iconStatus[$row['wbfsys_message_id_sender_status']]
              : $iconStatus[EMessageStatus::IS_NEW]
          ).'</td>'.NL;
          
        $userName = "({$row['receiver_wbfsys_role_user_name']}) {$row['receiver_core_person_lastname']}, {$row['receiver_core_person_firstname']} ";
      }
        
        
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($userName ).'</td>'.NL;

      // priority
      $body .= '<td valign="top" style="text-align:center" >'.
        (
          $row['wbfsys_message_priority']
            ? $iconPrio[$row['wbfsys_message_priority']]
            : $iconPrio[30]
        ).'</td>'.NL;
        

        
      $body .= '<td valign="top" >'.
        (
          '' != trim($row['wbfsys_message_m_time_created'] )
          ? $this->view->i18n->date($row['wbfsys_message_m_time_created'] )
          : ' ' 
        ).'</td>'.NL;

      if ($this->enableNav )
      {
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

    if ($this->dataSize > ($this->start + $this->stepSize) )
    {
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


    $this->numCols = 3;

    if ($this->enableNav )
      ++ $this->numCols;

    if ($this->enableMultiSelect )
      ++ $this->numCols;

    if ($this->appendMode )
    {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="append" ><![CDATA['.NL;
    } else {
      $body = '';
    }

    foreach($this->data as $key => $row   )
    {
      $body .= $this->buildAjaxTbody($row );
    }//end foreach

    if ($this->appendMode )
    {
      $numCols = 3;

      if ($this->enableNav )
        ++ $numCols;

      if ($this->enableMultiSelect )
        ++ $numCols;

      if ($this->dataSize > ($this->start + $this->stepSize ) )
      {
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

    $objid = $row['wbfsys_message_rowid'];
    $rowid = $this->id.'_row_'.$objid;
    $user  = Webfrap::$env->getUser();

    $iconStatus = array();
    $iconStatus[EMessageStatus::IS_NEW]   = $this->icon( 'message/mail_new.png', 'New' );
    $iconStatus[EMessageStatus::OPEN]     = $this->icon( 'message/mail_open.png', 'Open' );
    $iconStatus[EMessageStatus::ARCHIVED] = $this->icon( 'message/mail_archive.png', 'Archive' );

    $iconPrio = array();
    
    $iconPrio[10] = $this->icon( 'priority/min.png', 'Very Low' );
    $iconPrio[20] = $this->icon( 'priority/low.png', 'Low' );
    $iconPrio[30] = $this->icon( 'priority/normal.png', 'Normal' );
    $iconPrio[40] = $this->icon( 'priority/high.png', 'High' );
    $iconPrio[50] = $this->icon( 'priority/max.png', 'Very Heigh' );
    
    $iconInbox   = $this->icon( 'message/inbox.png', 'Inbox' );
    $iconOutbox  = $this->icon( 'message/outbox.png', 'Outbox' );
    
    // is this an insert or an update area
    if ($this->insertMode )
    {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
    }
    else if ($this->appendMode )
    {
      $body = '<tr id="'.$rowid.'" class="wcm wcm_ui_highlight" >'.NL;
    } else {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

    $body .= '<td valign="top" >'
      . '<a class="wcm wcm_req_ajax" href="maintab.php?c=My.Message_Crud.show&amp;target_mask=MyMessage_Widget&amp;ltype=table&amp;objid='.$objid.'" >'
      . Validator::sanitizeHtml($row['wbfsys_message_title'])
      . '<a/></td>'.NL;

    if ($row['wbfsys_message_id_sender'] == $user->getId() )
    {
      $iconType = $iconOutbox;
      $isInbox = false;
    } else { 
      $iconType = $iconInbox;
      $isInbox = true;
    }
    
    $body .= '<td valign="top" style="text-align:center" >'.$iconType.'</td>'.NL;
    
    if ($isInbox )
    {
      // status
      $body .= '<td valign="top" style="text-align:center" >'.
        (
          $row['wbfsys_message_reciever_id_status'] && isset($iconStatus[$row['wbfsys_message_reciever_id_status']])
            ? $iconStatus[$row['wbfsys_message_reciever_id_status']]
            : $iconStatus[EMessageStatus::IS_NEW]
        ).'</td>'.NL;
    
    
      $userName = "({$row['wbfsys_role_user_name']}) {$row['core_person_lastname']}, {$row['core_person_firstname']} ";
    } else {
      // status
      $body .= '<td valign="top" style="text-align:center" >'.
        (
          $row['wbfsys_message_id_sender_status'] && isset($iconStatus[$row['wbfsys_message_id_sender_status']])
            ? $iconStatus[$row['wbfsys_message_id_sender_status']]
            : $iconStatus[EMessageStatus::IS_NEW]
        ).'</td>'.NL;
        
      $userName = "({$row['receiver_wbfsys_role_user_name']}) {$row['receiver_core_person_lastname']}, {$row['receiver_core_person_firstname']} ";
    }
      
    $body .= '<td valign="top" >'.Validator::sanitizeHtml($userName ).'</td>'.NL;
    
    // priority
    $body .= '<td valign="top" style="text-align:center" >'.
      (
        $row['wbfsys_message_priority']
          ? $iconPrio[$row['wbfsys_message_priority']]
          : $iconPrio[30]
      ).'</td>'.NL;
      

      
    $body .= '<td valign="top" >'.
      (
        '' != trim($row['wbfsys_message_m_time_created'] )
        ? $this->view->i18n->date($row['wbfsys_message_m_time_created'] )
        : ' ' 
      ).'</td>'.NL;

    if ($this->enableNav )
    {
      $navigation  = $this->rowMenu
      (
        $objid,
        $row
      );
      $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'.$navigation.'</td>'.NL;
    }

    // is this an insert or an update area
    if ($this->insertMode )
    {
      $body .= '</tr>]]></htmlArea>'.NL;
    }
    else if ($this->appendMode )
    {
      $body .= '</tr>'.NL;
    } else {
      $body .= ']]></htmlArea>'.NL;
    }

    return $body;

  }//end public function buildAjaxTbody */
  
  /**
   * @return string
   */
  public function buildTableFooter()
  {

    return '';
  
  }//end public function buildTableFooter */

}// end class MyMessage_Widget_Table_Element

