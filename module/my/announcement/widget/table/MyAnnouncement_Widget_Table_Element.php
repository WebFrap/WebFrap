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
class MyAnnouncement_Widget_Table_Element extends WgtTable
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
  public $id   = 'wgt_table-my_announcement';

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
  public $namespace   = 'MyAnnouncement_Widget';
 

  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $url  = array
  (
    'archive'  => array
    (
      Wgt::ACTION_JS,
      'Archive',
      "\$R.put('ajax.php?c=My.Announcement.archive&amp;objid={\$id}',{},{'callback':function(){\$S('#{\$parentId}_row_{\$id}').remove()}});",
      'control/archive.png',
      'wcm wcm_ui_tip',
      'wbfsys.announcement.label',
      Wgt::BUTTON_CONFIRM => "Are you shure you want to Archive this Announcement?"
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
    if( $this->html )
      return $this->html;

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '<div id="'.$this->id.'" >'.NL;
      $this->html .= $this->buildPanel();

      $this->html .= '<ul id="'.$this->id.'-table" class="wgt-message-pipe wgt-space" >'.NL;
    }

    $this->html .= $this->buildTbody();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '</ul>';

      $this->html .= $this->buildTableFooter();
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function buildHtml */


  /**
   * create the body for the table
   * @return string
   */
  public function buildTbody( )
  {

    // create the table body
    $body = ''.NL;
    
    $priorityContainer = new WgtInputPriority( 'l-prio-dp' );

    // simple switch method to create collored rows
    $num = 1;
    foreach( $this->data as $key => $row   )
    {

      $objid       = $row['wbfsys_announcement_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= '<li class="row'.$num.'" id="'.$rowid.'" >'.NL;


      $navigation  = $this->rowMenu
      (
        $objid,
        $row
      );
      
      // importance
      $prioIcon  = '';
      $prioLabel = '';
      $prioBg = '';
      
      if( $row['wbfsys_announcement_importance'] )
      {
        $prioLabel = $priorityContainer->getLabel( $row['wbfsys_announcement_importance'] );
        $prioIcon  = $this->icon
        ( 
          $priorityContainer->getIcon( $row['wbfsys_announcement_importance'] ), 
          $prioLabel,
          'xsmall',
          array( 'class' => 'wcm wcm_ui_tip', 'title' => $prioLabel )
        );
        
        $bgVal = $priorityContainer->getBg( $row['wbfsys_announcement_importance'] );
        
        if( $bgVal )
        {
          $prioBg = ' style="background-color:'.$bgVal.'" ';
        }
        
      }
      
      $body .= '
        <div class="title"'.$prioBg.' >
          <div class="title_text" >'.$prioIcon.Validator::sanitizeHtml($row['wbfsys_announcement_title']).' (@'.Validator::sanitizeHtml($row['wbfsys_announcement_channel_name']).')</div>
          <div class="title_menu wcm wcm_ui_buttonset" >'.$navigation.'</div>
        </div>
        <div class="content" >'.$row['wbfsys_announcement_message'].'</div>
        <div class="footer" >'.( $row['wbfsys_announcement_m_time_created'] 
        ? $this->i18n->date( $row['wbfsys_announcement_m_time_created'] )
        : '&nbsp;' ).' by <span>('.$row['wbfsys_role_user_name'].') '.$row['core_person_lastname'].', '.$row['core_person_firstname'].'<span></div>'.NL;

      $body .= '</li>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } //end foreach

    if( $this->dataSize > ($this->start + $this->stepSize) )
    {
      $body .= '<li><span colspan="'.$this->numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>'.$this->image('wgt/bar-loader.gif','loader').' Loading the next '.$this->stepSize.' entries.</span></li>';
    }

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
    if( $this->xml )
      return $this->xml;


    $this->numCols = 3;

    if( $this->enableNav )
      ++ $this->numCols;

    if( $this->enableMultiSelect )
      ++ $this->numCols;

    if( $this->appendMode )
    {
      $body = '<htmlArea selector="ul#'.$this->id.'-table" action="append" ><![CDATA['.NL;
    }
    else
    {
      $body = '';
    }

    foreach( $this->data as $key => $row   )
    {
      $body .= $this->buildAjaxTbody( $row );
    }//end foreach

    if( $this->appendMode )
    {
      $numCols = 3;

      if( $this->enableNav )
        ++ $numCols;

      if( $this->enableMultiSelect )
        ++ $numCols;

      if( $this->dataSize > ( $this->start + $this->stepSize ) )
      {
        $body .= '<li><span colspan="'.$numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>'.$this->image('wgt/bar-loader.gif','loader').' Loading the next '.$this->stepSize.' entries.</span></li>';
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
  public function buildAjaxTbody( $row  )
  {

    $objid = $row['wbfsys_announcement_rowid'];
    $rowid = $this->id.'_row_'.$objid;
    
    $priorityContainer = new WgtInputPriority( 'l-prio-dp' );

    // is this an insert or an update area
    if( $this->insertMode )
    {
      $body = '<htmlArea selector="ul#'.$this->id.'-table" action="prepend" ><![CDATA[<li id="'.$rowid.'" >'.NL;
    }
    else if( $this->appendMode )
    {
      $body = '<li id="'.$rowid.'" class="wcm wcm_ui_highlight" >'.NL;
    }
    else
    {
      $body = '<htmlArea selector="li#'.$rowid.'" action="html" ><![CDATA[';
    }

    $navigation  = $this->rowMenu
    (
      $objid,
      $row
    );
    
    // importance
    $prioIcon  = '';
    $prioLabel = '';
    $prioBg = '';
    
    if( $row['wbfsys_announcement_importance'] )
    {
      $prioLabel = $priorityContainer->getLabel( $row['wbfsys_announcement_importance'] );
      $prioIcon  = $this->icon
      ( 
        $priorityContainer->getIcon( $row['wbfsys_announcement_importance'] ), 
        $prioLabel,
        'xsmall',
        array( 'class' => 'wcm wcm_ui_tip', 'title' => $prioLabel )
      );
      
      $bgVal = $priorityContainer->getBg( $row['wbfsys_announcement_importance'] );
      
      if( $bgVal )
      {
        $prioBg = ' style="background-color:'.$bgVal.'" ';
      }
      
    }
    
    $body .= '
      <div class="title"'.$prioBg.' >
        <div class="title_text" >'.$prioIcon.Validator::sanitizeHtml($row['wbfsys_announcement_title']).' (@'.Validator::sanitizeHtml($row['wbfsys_announcement_channel_name']).')</div>
        <div class="title_menu wcm wcm_ui_buttonset" >'.$navigation.'</div>
      </div>
      <div class="content" >'.$row['wbfsys_announcement_message'].'</div>
      <div class="footer" >'.( $row['wbfsys_announcement_m_time_created'] 
        ? $this->i18n->date( $row['wbfsys_announcement_m_time_created'] )
        : '&nbsp;' ).'by <span>('.$row['wbfsys_role_user_name'].') '.$row['core_person_lastname'].', '.$row['core_person_firstname'].'<span></div>'.NL;

    // is this an insert or an update area
    if( $this->insertMode )
    {
      $body .= '</li>]]></htmlArea>'.NL;
    }
    else if( $this->appendMode )
    {
      $body .= '</li>'.NL;
    }
    else
    {
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
  
  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    $this->refresh = true;

    if($this->xml)
      return $this->xml;

    if( $this->appendMode )
    {
      $html = '<htmlArea selector="ul#'.$this->id.'-table" action="append" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>'.NL;
    }
    else
    {
      $html = '<htmlArea selector="ul#'.$this->id.'-table" action="replace" ><![CDATA[<ul id="'.$this->id.'-table" class="wgt-message-pipe wgt-space" >';
      $html .= $this->build();
      $html .= '</ul>]]></htmlArea>'.NL;
    }

    $this->xml = $html;

    return $html;

  }//end public function buildAjaxArea */

}// end class WbfsysAnnouncement_Widget_Table_Element

