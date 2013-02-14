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
 * @subpackage ModDemo
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class WebfrapProtocol_Table extends WgtTable
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
  public $id       = 'wgt-table_demo_entity1';

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
      'index.php?c=Demo.Entity1.search'
    ),
    'show'    => array
    (
      Wgt::ACTION_AJAX_GET,
      'show',
      'index.php?c=Demo.Entity1.show&amp;objid=',
      'webfrap/show.png',
      'wcm wcm_req_ajax',
      'demo.entity1.label.title_show'
    ),
    'edit'    => array
    (
      Wgt::ACTION_AJAX_GET,
      'edit',
      'index.php?c=Demo.Entity1.edit&amp;objid=',
      'control/edit.png',
      'wcm wcm_req_ajax',
      'demo.entity1.label.title_edit'
    ),
    'delete'  => array
    (
      Wgt::ACTION_AJAX_GET,
      'delete',
      'index.php?c=Demo.Entity1.delete&amp;objid=',
      'control/delete.png',
      'wcm wcm_req_del',
      'demo.entity1.label.title_delete'
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
   * the default table buildr method. This Method will be called when the
   * table is loaded as item in a view eg.
   *
   * @return string
   */
  public function buildProtocolEntityHtml( )
  {

    // if we have html we can assume that the table was allready buildd
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if( $this->html )
      return $this->html;

    $this->numCols = 4;

    // Creating the Head
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;

    $head .= '<th>
      <span style="float:right" >
        <img style="text-align:right;" class="wgt-table_menu" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >user</span>
    </th>'.NL;
    $head .= '<th>
      <span style="float:right" >
        <img style="text-align:right;" class="wgt-table_menu" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >'.$this->view->i18n->l('context','wbfsys.protocol_message.label.table_head_context').'</span>
    </th>'.NL;
    $head .= '<th>
      <span style="float:right" >
        <img style="text-align:right;" class="wgt-table_menu" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >'.$this->view->i18n->l('message','wbfsys.protocol_message.label.table_head_message').'</span>
    </th>'.NL;


    // the default navigation col
    $head .= '<th style="width:70px;">'.$this->i18n->l( 'Nav.', 'wbf.label'  ).'</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // create the table body
    $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $num = 1;
    foreach( $this->data as $key => $row   )
    {

      $objid       = $row['wbfsys_protocol_message_'.Db::PK];
      $rowid       = $this->id.'_row_'.$objid;
      $navigation  = $this->buildActions( $objid );

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;


      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['core_person_firstname']).' '.Validator::sanitizeHtml($row['core_person_lastname']).'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['wbfsys_protocol_message_context']).'</td>'.NL;
      $body .= '<td valign="top" >'.$row['wbfsys_protocol_message_message'].'</td>'.NL;


      $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } //end foreach

    $body .= '</tbody>'.NL;
    //\ Create the table body

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="wgt-table" >'.NL;

    $this->html .= $head;
    $this->html .= $body;
    $this->html .= $this->buildTableFooter();

    $this->html .= '</table>';

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function buildProtocolEntityHtml */

  /**
   * build the tables as areas for the ajax interface
   *
   * @return String
   */
  public function buildProtocolEntityAjax( )
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

      $objid       = $row['demo_entity1_'.Db::PK];

      $rowid       = $this->id.'_row_'.$objid;
      $navigation  = $this->buildActions( $objid  );

      // is this an insert or an update area
      if( $this->insertMode )
        $body .= '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
      else
        $body .= '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
      $body .= '<td valign="top" ><a class="wcm wcm_req_ajax" href="modal.php?c=Demo.Entity1.edit&amp;objid='.$objid.'" >'.Validator::sanitizeHtml($row['demo_entity1_name']).'</a></td>'.NL;

      $body .= '<td valign="top" class="ignore" style="text-align:center;" >'.$navigation.'</td>'.NL;

      // is this an insert or an update area
      if( $this->insertMode )
        $body .= '</tr>]]></htmlArea>'.NL;
      else
        $body .= ']]></htmlArea>'.NL;

    }//end foreach

    $this->html = $body;

    return $this->html;


  }//end public function buildProtocolEntityAjax */

  /**
   *
   */
  public function buildTableFooter()
  {

    $html = '<tfoot>'.NL;
    $html .= '  <tr class="wgt-table navigation" ><td  colspan="'.$this->numCols.'" >'.NL;
    $html .= '    <div class="full" >';
    $html .= '     <div class="menu left" style="width:100px;" >';
    $html .=         $this->menuTableSize();
    $html .= '     </div>';
    $html .= '     <div class="right menu"  >';
    $html .=         $this->menuNumEntries();
    $html .= '     </div>';
    $html .= '    </div>';
    $html .= '  </td></tr>'.NL;
    $html .= $this->metaInformations();
    $html .= '</tfoot>'.NL;

    return $html;

  }//end public function buildTableFooter */

}//end class WgtTableWebfrapProtocol

