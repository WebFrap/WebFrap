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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Table_Element
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
  public $id       = 'wgt-table-acl-mgmt-acl';

  /**
   * the most likley class of a given query object
   *
   * @var AclMgmt_Table_Query
   */
  public $data       = null;
  
  /**
   * @var DomainNode
   */
  public $domainNode = null;
  
  /**
   * default constructor
   *
   * @param string $name the name of the wgt object
   * @param LibTemplate $view
   */
  public function __construct( $domainNode, $name = null, $view = null )
  {
    
    $this->domainNode = $domainNode;
    $this->name     = $name;
    $this->stepSize = Wgt::$defListSize;

    // when a view is given we asume that the element should be injected
    // directly to the view
    if( $view )
    {
      $this->view = $view;
      $this->i18n = $view->getI18n();
      
      if( $view->access )
        $this->access = $view->access;

      if( $name )
        $view->addElement( $name, $this );
    }
    else
    {
      $this->i18n     = I18n::getActive();
    }
    
    $this->loadUrl();

  }//end public function __construct */
  

  /**
  * Laden der Urls für die action buttons
  */
  public function loadUrl()
  {
    
    $this->id = 'wgt-table-'.$this->domainNode->aclDomainKey.'-acl';
  
    /**
     * list with all actions for the listed datarows
     * this list is easy extendable via addUrl.
     * This array only contains possible actions, but you have to set it
     * manually wich actions are used with: Wgt::addActions
     * @var array
     */
    $this->url      = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Wbfsys.SecurityAccess.delete&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/delete.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'inheritance'  => array
      (
        Wgt::ACTION_BUTTON_GET,
        'ACL Graph',
        'maintab.php?c=Acl.Mgmt_Path.showGraph&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/acl_inheritance.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'tree'  => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Reference ACLs',
        'maintab.php?c=Acl.Mgmt_Tree.showGraph&amp;dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/mask_tree.png',
        '',
        'wbf.inheritance',
        Acl::ADMIN
      ),
      'edit'  => array
      (
        Wgt::ACTION_JS,
        'Edit',
        'ajax.php?c=Wbfsys.SecurityAccess.delete&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/edit.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'sep'  => array
      (
        Wgt::ACTION_SEP
      ),
  
    );
    
  }//end public function loadUrl */

////////////////////////////////////////////////////////////////////////////////
// Plain Html Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * parse the table
   *
   * @return string
   */
  public function buildHtml( )
  {
    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific builder method from outside
    // of the view, but then get the html of the called parse method
    if( $this->html )
      return $this->html;

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '<div id="'.$this->id.'" class="wgt_border wgt-grid" >'.NL;
      $this->html .= $this->buildPanel();
        //$this->html .= '<div id="'.$this->id.'-body" >'.NL;
      $this->html .= '<table id="'.$this->id
        .'-table" class="wgt-grid wcm wcm_widget_grid hide-head" >'.NL;

      $this->html .= $this->buildThead();
    }

    $this->html .= $this->buildTbody();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      //$this->html .= '</div></div>'.NL;
      $this->html .= '</table>';
      $this->html .= '<var class="wgt-settings" >{
        "height":"large",
        "search_form":"'.$this->searchForm.'",
        "expandable":false
        }</var>';

      $this->html .= $this->elementFooter();
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

    $this->numCols = 2;

    if($this->enableNav)
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    $html .= '<th style="width:30px;" class="pos" >'.$this->i18n->l( 'Pos.', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:250px" >
      '.$this->view->i18n->l('Group','wbf.label').'
    </th>'.NL;

    $html .= '<th style="width:80px" >
      '.$this->view->i18n->l('Assignments','wbf.label').'
    </th>'.NL;

    $html .= '<th style="width:100px" >
      '.$this->view->i18n->l('Access Level','wbf.label').'
    </th>'.NL;

    $html .= '<th style="width:130px" >
      '.$this->view->i18n->l('Date Start','wbf.label').'
    </th>'.NL;

    $html .= '<th style="width:130px" >
      '.$this->view->i18n->l('Date End','wbf.label').'
    </th>'.NL;

    // the default navigation col
    if( $this->enableNav )
      $html .= '<th style="width:100px;">'.$this->view->i18n->l( 'Menu', 'wbf.label'  ).'</th>'.NL;

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
    $pos = 1;
    foreach( $this->data as $key => $row   )
    {

      $objid  = $row['security_access_rowid'];
      $rowid  = $this->id.'_row_'.$objid;

      $body .= '<tr class="wcm wcm_ui_highlight row'.$num.' node-'.$objid.'" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" class="pos" name="slct['.$objid.']" >'.$pos.'</td>'.NL;

      $body .= '<td valign="top"  >'
        .(!is_null($row['role_group_name'])?$row['role_group_name']:' ')
        .'</td>'.NL;
        
      $body .= '<td valign="top"  >'
        .(!is_null($row['num_assignments'])?$row['num_assignments']:' ')
        .'</td>'.NL;

      $body .= '<td valign="top" style="text-align:right;" >'.$this->selectRights
        (
          $row['security_access_access_level'],
          "ar[security_access][{$objid}][access_level]"
        ).'</td>'.NL;

      $body .= '<td valign="top" >'
        .'<input type="text" class="'.$this->editForm.' wcm wcm_ui_date show small" '
        .' id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_start" '
        .' name="ar[security_access]['.$objid.'][date_start]" value="'
        .(
           '' != trim( $row['security_access_date_start'] )
            ? $this->view->i18n->date( $row['security_access_date_start'] )
            : ''
        ).'" /></td>'.NL;

      $body .= '<td valign="top" >'
        .'<input type="text" class="'.$this->editForm.' wcm wcm_ui_date show small" '
        .' id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end" '
        .' name="ar[security_access]['.$objid.'][date_end]" value="'
        .(
           '' != trim( $row['security_access_date_end'] )
            ? $this->view->i18n->date( $row['security_access_date_end'] )
            : ''
        ).'" /></td>'.NL;

      if( $this->enableNav )
      {
        $navigation  = $this->rowMenu
          (
            $objid.'&group_id='.$row['role_group_rowid'],
            $row,
            $row['role_group_name']
          );
        $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;
        
      $pos ++;

    } //end foreach


    if( $this->dataSize > ($this->start + $this->stepSize) )
    {
      $body .= '<tr><td class="pos" ></td>'
        . '<td colspan="'.$this->numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '
        . $this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>Paging to the next '
        . $this->stepSize.' entries.</td></tr>';
    }

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
    // this behaviour enables you to call a specific builder method from outside
    // of the view, but then get the html of the called parse method
    if( $this->xml )
      return $this->xml;

    if( $this->appendMode )
    {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" ><![CDATA['.NL;
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

      if( $this->dataSize > ($this->start + $this->stepSize) )
      {
        $body .= '<tr><td class="pos" ></td>'
          .'<td colspan="'.$numCols.'" class="wcm wcm_action_appear '
          .$this->searchForm.' '.$this->id.'"  ><var>'
          .($this->start + $this->stepSize).'</var>Paging to the next '
          .$this->stepSize.' entries.</td></tr>';
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

    $objid = $row['security_access_rowid'];
    $rowid = $this->id.'_row_'.$objid;

    // is this an insert or an update area
    if( $this->insertMode )
    {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" ><![CDATA[<tr id="'.$rowid.'" class="wcm wcm_ui_highlight node-'.$rowid.'" >'.NL;
    }
    else if( $this->appendMode )
    {
      $body = '<tr id="'.$rowid.'" class="wcm wcm_ui_highlight node-'.$rowid.'" >'.NL;
    }
    else
    {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

    $body .= '<td valign="top" name="slct['.$objid.']" class="pos" ></td>'.NL;

    $body .= '<td valign="top" >'.
      (!is_null($row['role_group_name'])?$row['role_group_name']:' ')
      .'</td>'.NL;
        
    $body .= '<td valign="top"  >'
        .(!is_null($row['num_assignments'])?$row['num_assignments']:' ')
        .'</td>'.NL;

    $body .= '<td valign="top" style="text-align:right;" >'.
      $this->selectRights( $row['security_access_access_level'], "ar[security_access][{$objid}][access_level]"  )
      .'</td>'.NL;

    $body .= '<td valign="top" >'
      .'<input type="text" class="'.$this->editForm.' wcm wcm_ui_date show small" '
      .' id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_start" '
      .' name="ar[security_access]['.$objid.'][date_start]" value="'
      .( 
        '' != trim( $row['security_access_date_start'] )
          ? $this->view->i18n->date( $row['security_access_date_start'] )
          : ''
       ).'" /></td>'.NL;

    $body .= '<td valign="top" >'
      .'<input type="text" class="'.$this->editForm.' wcm wcm_ui_date show small" '
      .' id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end" '
      .' name="ar[security_access]['.$objid.'][date_end]" value="'
      .( 
        '' != trim( $row['security_access_date_end'] )
          ? $this->view->i18n->date( $row['security_access_date_end'] )
          : ''
      ).'" /></td>'.NL;

    if( $this->enableNav )
    {
      $navigation  = $this->rowMenu
        (
          $objid.'&group_id='.$row['role_group_rowid'],
          $row,
          $row['role_group_name']
        );
      $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
    }

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

    foreach( Acl::$accessLevels as  $label => $value )
    {
      $checked = ($value==$active)
        ? 'selected="selected"'
        : '';
      $html .= '<option '.$checked.' value="'.$value.'" >'.$label.'</option>'.NL;
    }

    $html .= '</select>';

    return $html;

  }//end protected function selectRights */

  /**
   * build the table footer
   * @return string
   */
  public function elementFooter()
  {

    $html = '<div class="wgt-panel" >'.NL;
    $html .= '  <div class="right"  >';
    $html .=    $this->menuTableSize();
    $html .= '  </div>';
    $html .= '</div>'.NL;

    return $html;

  }//end public function elementFooter */

} // end class AclMgmt_Table_Element */

