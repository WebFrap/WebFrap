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
class WebfrapProtocol_Table_Element extends WgtTable
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
  public $id   = 'wgt_table-webfrap_protocol';
  
  /**
   * the most likley class of a given query object
   *
   * @var WbfsysProtocolAccess_Table_Query
   */
  public $data = null;

  /**
   * Namespace information für die Tabelle
   *
   * @var string $namespace
   */
  public $namespace   = 'WbfsysProtocolAccess';
 

  /**
   * @var string
   */
  public $bodyHeight   = 'large';

 /**
  * Laden der Urls für die Actions
  */
  public function loadUrl()
  {
  
    $this->url  = array
    (
      'paging'  => array
      (
        Wgt::ACTION_PAGING ,
        'index.php?c=Wbfsys.ProtocolAccess.search&amp;target_mask=WbfsysProtocolAccess&amp;ltype=table'
      ),

      'sep'  => array
      (
        Wgt::ACTION_SEP
      ),
  
    );

  }//end public function loadUrl */
    
/*//////////////////////////////////////////////////////////////////////////////
// Context: Table
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * parse the table
   *
   * @return string
   */
  public function buildProtocolEntityHtml( )
  {    
    $conf = $this->getConf();

    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if( $this->html )
      return $this->html;
      
    if( DEBUG )
      $renderStart = Webfrap::startMeasure();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid wgt-border" >'.NL;
      $this->html .= '<var id="'.$this->id.'-table-cfg-grid" >{
        "height":"'.$this->bodyHeight.'",
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
    if( $this->insertMode )
    {
      $this->html .= '</table>';

      $this->html .= $this->buildTableFooter();
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }
    
    if( DEBUG )
      Debug::console( "table ".__METHOD__." {$this->id} rendertime: ".Webfrap::getDuration($renderStart) );

    return $this->html;

  }//end public function buildProtocolEntityHtml */

  /**
   * create the head for the table
   * @return string
   */
  public function buildThead( )
  {
    $this->numCols = 2;

    if( $this->enableNav )
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    $html .= '<th style="width:30px;" class="pos" >'.$this->view->i18n->l( 'Pos.', 'wbf.label'  ).'</th>'.NL;
    $html .= '<th style="width:150px;" >Time</th>'.NL;
    $html .= '<th style="width:180px;" >User</th>'.NL;
    $html .= '<th style="width:70px;" >Type</th>'.NL;
    $html .= '<th style="width:250px;" >Comment</th>'.NL;

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

    $conf = $this->getConf();



    // create the table body
    $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $num = 1;
    $pos = 1;
    foreach( $this->data as $key => $row )
    {

      $objid       = $row['wbfsys_protocol_message_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      
      $body .= '<tr class="wcm wcm_ui_highlight row'.$num.' node-'.$objid.'" '
.' id="'.$rowid.'" >'.NL;
        
      $body .= '<td valign="top" class="pos" name="slct['.$objid.']" style="text-align:right;" >'.$pos.'</td>'.NL;
        
      $body .= '<td valign="top" style="text-align:right;"  >'.$row['wbfsys_protocol_m_time_created'].'</td>'.NL;
      $body .= '<td valign="top"  >'.$row['core_person_lastname'].', '.$row['core_person_firstname'].'</td>'.NL;
      $body .= '<td valign="top"  >'.$row['wbfsys_protocol_message_context'].'</td>'.NL;
      $body .= '<td valign="top"  >'.$row['wbfsys_protocol_message_message'].'</td>'.NL;
      
      
      $body .= '</tr>'.NL;
      
      $pos ++;
      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } //end foreach

    if( $this->dataSize > ($this->start + $this->stepSize) )
    {
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
  public function buildAjax( )
  {
    // if we have html we can assume that the table was allready parsed
    // so we return just the html and stop here
    // this behaviour enables you to call a specific parser method from outside
    // of the view, but then get the html of the called parse method
    if( $this->xml )
      return $this->xml;


    $this->numCols = 2;

    if( $this->enableNav )
      ++ $this->numCols;


    if( $this->appendMode )
    {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="append" ><![CDATA['.NL;
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
      $numCols = 2;

      if( $this->enableNav )
        ++ $numCols;

      if( $this->dataSize > ( $this->start + $this->stepSize ) )
      {
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
  public function buildAjaxTbody( $row  )
  {

    $objid = $row['webfrap_protocol_rowid'];
    $rowid = $this->id.'_row_'.$objid;


    $conf = $this->getConf();


    $body = '';


    // is this an insert or an update area
    if( $this->insertMode )
    {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" >'
        .'<![CDATA[<tr '
        .' wgt_eid="'.$objid.'" ' 
        .' class="wcm wcm_ui_highlight  node-'.$objid.'" '
        .' id="'.$rowid.'" >'.NL;
    }
    else if( $this->appendMode )
    {
      $body = '<tr id="'.$rowid.'" '
        .' wgt_eid="'.$objid.'" '
        .' class="wcm wcm_ui_highlight  node-'.$objid.'" >'.NL;
    }
    else
    {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

    $body .= '<td valign="top" class="pos" name="slct['.$objid.']" style="text-align:right;" >'.$pos.'</td>'.NL;
        
    $body .= '<td valign="top" style="text-align:right;"  >'.$row['wbfsys_protocol_m_time_created'].'</td>'.NL;
    $body .= '<td valign="top"  >'.$row['core_person_lastname'].', '.$row['core_person_firstname'].'</td>'.NL;
    $body .= '<td valign="top"  >'.$row['wbfsys_protocol_message_context'].'</td>'.NL;
    $body .= '<td valign="top"  >'.$row['wbfsys_protocol_message_message'].'</td>'.NL;

    // is this an insert or an update area
    if( $this->insertMode )
    {
      $body .= '</tr>]]></htmlArea>'.NL;
    }
    else if( $this->appendMode )
    {
      $body .= '</tr>'.NL;
    }
    else
    {
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

}//end class _Table_Element

