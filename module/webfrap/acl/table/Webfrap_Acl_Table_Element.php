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
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebFrap_Acl_Table_Element
  extends WgtTable
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the html id of the table tag, this id can be used to replace the table
   * or table contents via ajax interface.
   *
   * @var string $id
   */
  public $id       = 'wgt-table-project_alias-acl';

  /**
   * the most likley class of a given query object
   *
   * @var ProjectAlias_Acl_Table_Query
   */
  public $data       = null;

  /**
   * the most likley class of a given query object
   *
   * @var array
   */
  public $rightValues       = array(
    '0' => 'No Rights',
    '1' => 'Own Entries',
    '2' => 'All Entries',
  );

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
      'index.php?c=Project.Alias_Acl.search'
    ),
    'delete'  => array
    (
      Wgt::ACTION_DELETE,
      'Delete',
      'index.php?c=Wbfsys.SecurityAccess.delete&amp;objid=',
      'control/delete.png',
      '',
      'wbfsys.security_access.label.title_delete'
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

////////////////////////////////////////////////////////////////////////////////
// Plain Html Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the table
   *
   * @return string
   */
  public function buildHtml( )
  {
    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if( $this->html )
      return $this->html;

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="wgt-table" >'.NL;

    $this->html .= $this->buildThead();
    $this->html .= $this->buildTbody();
    $this->html .= $this->buildTableFooter();

    $this->html .= '</table>';

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="text/javascript" >'.NL;
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

    if($this->enableNav)
      ++ $this->numCols;

    if($this->enableMultiSelect)
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    if( $this->enableMultiSelect )
      $html .= '<th style="width:40px;">'.$this->i18n->l( 'check', 'wbf.label.table_check'  ).'</th>'.NL;

    $html .= '<th style="width:125px" >
      <span style="float:right" >
        <img style="text-align:right;" class="wcm wcm_menu_table" src="'.View::$iconsWeb.'xsmall/control/sort_menu.png" />
      </span>
      <span class="label" >'.$this->view->i18n->l('Group','wbfsys.security_access.label.table_head_id_group').'</span>
    </th>'.NL;

    $html .= '<th style="width:125px" >
      <span class="label" >'.$this->view->i18n->l('Has Access','wbfsys.security_access.label.table_head_has_access').'</span>
    </th>'.NL;
    $html .= '<th style="width:125px" >
      <span class="label" >'.$this->view->i18n->l('Has Insert','wbfsys.security_access.label.table_head_has_insert').'</span>
    </th>'.NL;
    $html .= '<th style="width:125px" >
      <span class="label" >'.$this->view->i18n->l('Has Update','wbfsys.security_access.label.table_head_has_update').'</span>
    </th>'.NL;
    $html .= '<th style="width:125px" >
      <span class="label" >'.$this->view->i18n->l('Has Delete','wbfsys.security_access.label.table_head_has_delete').'</span>
    </th>'.NL;
    $html .= '<th style="width:125px" >
      <span class="label" >'.$this->view->i18n->l('Has Admin','wbfsys.security_access.label.table_head_has_admin').'</span>
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

    // create the table body
    if( $this->bodyHeight )
    {
      $body = '<tbody style="height:'.$this->bodyHeight.'#;overflow-y:auto;overflow-x:hidden;" >'.NL;
    }
    else
    {
      // create the table body
      $body = '<tbody>'.NL;
    }

    // simple switch method to create collored rows
    $num = 1;
    foreach( $this->data as $key => $row   )
    {

      $objid       = $row['wbfsys_security_access_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      if( $this->enableMultiSelect )
      {
        $body .= '<td valign="top" style="text-align:center;" ><input type="checkbox" name="slct[]" value="'.$objid.'" class="wgt-ignore" /></td>'.NL;
      }

      $body .= '<td valign="top" style="text-align:right;" >'.(!is_null($row['wbfsys_role_group_name'])?$row['wbfsys_role_group_name']:' ').'</td>'.NL;

      $body .= '<td valign="top" style="text-align:right;" >'.$this->selectRights( $row['wbfsys_security_access_has_access'], "ar[wbfsys_security_access][{$objid}][has_access]"  ).'</td>'.NL;
      $body .= '<td valign="top" style="text-align:right;" >'.$this->selectRights( $row['wbfsys_security_access_has_insert'], "ar[wbfsys_security_access][{$objid}][has_insert]" ).'</td>'.NL;
      $body .= '<td valign="top" style="text-align:right;" >'.$this->selectRights( $row['wbfsys_security_access_has_update'], "ar[wbfsys_security_access][{$objid}][has_update]" ).'</td>'.NL;
      $body .= '<td valign="top" style="text-align:right;" >'.$this->selectRights( $row['wbfsys_security_access_has_delete'], "ar[wbfsys_security_access][{$objid}][has_delete]" ).'</td>'.NL;
      $body .= '<td valign="top" style="text-align:right;" >'.$this->selectRights( $row['wbfsys_security_access_has_admin'], "ar[wbfsys_security_access][{$objid}][has_admin]" ).'</td>'.NL;

      if( $this->enableNav )
      {
        $navigation  = $this->rowMenu( $objid );
        $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;

    } //end foreach

    $body .= '</tbody>'.NL;
    //\ Create the table body

    return $body;

  }//end public function buildTbody */

////////////////////////////////////////////////////////////////////////////////
// Ajax Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the table
   *
   * @return string
   */
  public function buildAjax( )
  {

    // if we have html we can assume that the table was allready assembled
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

    $objid = $row['wbfsys_security_access_rowid'];
    $rowid = $this->id.'_row_'.$objid;

    // is this an insert or an update area
    if( $this->insertMode )
      $body = '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
    else
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';

    if( $this->enableMultiSelect )
    {
      $body .= '<td valign="top" style="text-align:center;" ><input type="checkbox" name="slct[]" value="'.$objid.'" class="wgt-ignore" /></td>'.NL;
    }

    $body .= '<td valign="top" style="text-align:right;" >'.
      (!is_null($row['wbfsys_role_group_name'])?$row['wbfsys_role_group_name']:' ')
      .'</td>'.NL;


    $body .= '<td valign="top" style="text-align:right;" >'.
      $this->selectRights( $row['wbfsys_security_access_has_access'], "ar[wbfsys_security_access][{$objid}][has_access]"  )
      .'</td>'.NL;

    $body .= '<td valign="top" style="text-align:right;" >'.
      $this->selectRights( $row['wbfsys_security_access_has_insert'], "ar[wbfsys_security_access][{$objid}][has_insert]" )
      .'</td>'.NL;

    $body .= '<td valign="top" style="text-align:right;" >'.
      $this->selectRights( $row['wbfsys_security_access_has_update'], "ar[wbfsys_security_access][{$objid}][has_update]" )
      .'</td>'.NL;

    $body .= '<td valign="top" style="text-align:right;" >'.
    $this->selectRights( $row['wbfsys_security_access_has_delete'], "ar[wbfsys_security_access][{$objid}][has_delete]" )
    .'</td>'.NL;

    $body .= '<td valign="top" style="text-align:right;" >'.
    $this->selectRights( $row['wbfsys_security_access_has_admin'], "ar[wbfsys_security_access][{$objid}][has_admin]" )
    .'</td>'.NL;

    if( $this->enableNav )
    {
      $navigation  = $this->rowMenu( $objid );
      $body .= '<td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >'.$navigation.'</td>'.NL;
    }

    // is this an insert or an update area
    if( $this->insertMode )
      $body .= '</tr>]]></htmlArea>'.NL;
    else
      $body .= ']]></htmlArea>'.NL;

    return $body;

  }//end public function buildAjaxTbody */

////////////////////////////////////////////////////////////////////////////////
// Helper Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * create a selectbox with the rights
   * @param string $active
   * @param int $name
   */
  protected function selectRights( $active, $name )
  {

    $html = '<select name="'.$name.'" class="wcm wcm_ui_color_code prop_key_access full '.$this->editForm.'" >'.NL;

    foreach( $this->rightValues as $value => $label )
    {
      $checked = ($value==$active)?'selected="selected"':'';
      $html .= '<option '.$checked.' value="'.$value.'" >'.$label.'</option>'.NL;
    }

    $html .= '</select>';

    return $html;

  }//end protected function selectRights */

  /**
   * build the table footer
   * @return string
   */
  public function buildTableFooter()
  {

    $html = '<tfoot>'.NL;
    $html .= '  <tr><td  colspan="'.$this->numCols.'" >'.NL;
    $html .= '    <div class="full" >';
    $html .= '      <div class="right menu"  >';
    $html .=          $this->menuNumEntries();
    $html .= '      </div>';
    $html .= '      <div class="menu" style="float:left;width:100px;" >';
    $html .=          $this->menuTableSize();
    $html .= '      </div>';
    $html .= '      <div class="menu" style="text-align:center;margin:0px auto;width:350px;" >';
    $html .= '      </div>';
    $html .= '    </div>';
    $html .= '  </td></tr>'.NL;
    $html .= $this->metaInformations();
    $html .= '</tfoot>'.NL;

    return $html;

  }//end public function buildTableFooter */

} // end class WebFrap_Acl_Table_Element */

