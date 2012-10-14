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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_Treetable_Element
  extends WgtTreetable
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
  public $id       = 'wgt-treetable-enterprise_employee-acl-qfdu';

  /**
   * the html id of the table tag, this id can be used to replace the table
   * or table contents via ajax interface.
   *
   * @var string $id
   */
  public $areaId   = null;

  /**
   * the most likley class of a given query object
   *
   * @var AclMgmt_Table_Query
   */
  public $data        = null;

  /**
   * the most likley class of a given query object
   *
   * @var array
   */
  public $dataUser    = array();

  /**
   * the most likley class of a given query object
   *
   * @var array
   */
  public $dataEntity  = array();
  
  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $userButtons  = array();

  /**
   * @var array
   */
  public $userActions  = array();


  /**
   * list with all actions for the listed datarows
   * this list is easy extendable via addUrl.
   * This array only contains possible actions, but you have to set it
   * manually wich actions are used with: Wgt::addActions
   * @var array
   */
  public $datasetButtons  = array();

  /**
   * @var array
   */
  public $datasetActions  = array();

  
  /**
  *
  */
  public function loadUrl()
  {
  
    $this->url      = array
    (
      'paging'  => array
      (
        Wgt::ACTION_PAGING ,
        'index.php?c=Acl.Mgmt.searchQdfu'
      ),
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt.cleanQfduGroup&amp;objid=',
        'control/clean.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'inheritance'  => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Inherit Rights',
        'maintab.php?c=Acl.Mgmt_Path.showGraph&amp;objid=',
        'control/acl_inheritance.png',
        '',
        'wbf.inheritance',
        Acl::ADMIN
      ),
      'sep'  => array
      (
        Wgt::ACTION_SEP
      ),
  
    );

    $this->userButtons  = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt.deleteQfdUser&amp;objid=',
        'control/delete.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'clean'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt.cleanQfdUser&amp;objid=',
        'control/clean.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
    );

    $this->datasetButtons  = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt.deleteQfduDataset&amp;objid=',
        'control/delete.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
    );

  }//end public function loadUrl */

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param array $actions
   */
  public function addUserActions( $actions )
  {
    if(is_array($actions))
    {
      $this->userActions = array_merge($this->userActions,$actions);
    }
    else
    {
      $this->userActions[] = $actions;
    }

  }//end public function addUserActions */

  /**
   * @param array $actions
   */
  public function addDatasetActions( $actions )
  {
    if(is_array($actions))
    {
      $this->datasetActions = array_merge($this->datasetActions,$actions);
    }
    else
    {
      $this->datasetActions[] = $actions;
    }

  }//end public function addDatasetActions */

  /**
   * set the table data
   * @param array $data
   * @param $value
   * @return void
   */
  public function setData( $data , $value = null )
  {

    if( !$data )
      return;

    if( is_object( $data ) )
    {
      $this->data       = $data;
      $this->dataSize   = $data->getSourceSize();
      $this->dataUser   = $data->users;
      $this->dataEntity = $data->datasets;
    }
    else
    {
      $this->data = $data;
    }

  }//end public function setData */

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
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid" >'.NL;
      $this->html .= $this->buildPanel();
      //wcm_ui_treetable
      $this->html .= '<table id="'.$this->id
        .'-table" class="wgt-grid wcm wcm_widget_grid wcm_ui_treetable hide-head" >'.NL;

      $this->html .= $this->buildThead();
    }

    $this->html .= $this->buildTbody();

    //$this->html .= $this->parseTableFooter();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {

      $this->html .= '</table>';
      $this->html .= '<var class="wgt-settings" >{
        "height":"large",
        "search_form":"'.$this->searchForm.'",
        "expandable":false
      }</var>';

      $this->html .= $this->buildElementFooter();

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

    $this->numCols = 3;

    if( $this->enableNav )
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    $html .= '<th style="width:30px;" class="pos" >'.$this->i18n->l( 'Pos:', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:350px" >
      '.$this->view->i18n->l
      (
        'Group / User / {@label@}',
        'wbf.label',
        array( 'label' => 'Employee' )
      ).'
    </th>'.NL;

    $html .= '<th style="width:125px" >
      '.$this->view->i18n->l( 'Start', 'wbf.label' ).'
    </th>'.NL;

    $html .= '<th style="width:125px" >
      '.$this->view->i18n->l( 'End', 'wbf.label' ).'
    </th>'.NL;

    // the default navigation col
    if( $this->enableNav )
      $html .= '<th style="width:75px;">'.$this->view->i18n->l( 'Menu', 'wbf.label'  ).'</th>'.NL;

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
    
    foreach( $this->data as $groupId => $row   )
    {

      $objid       = $groupId;
      $rowid       = $this->id.'_row_'.$groupId;

      $body .= '<tr class="row'.$num.' title" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" style="text-align:center;" >'.$pos.'</td>'.NL;

      $body .= '<td valign="top" colspan="3" >'.$row['wbfsys_role_group_name'].'</td>'.NL;


      $this->num ++;
      if ( $this->num > $this->numOfColors )
        $this->num = 1;

      if( $this->enableNav )
      {
        $navigation  = $this->rowMenu
          (
            $objid.'&group_id='.$groupId.'&area_id='.$this->areaId,
            $row
          );
        $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $this->num ++;
      if ( $this->num > $this->numOfColors )
        $this->num = 1;

      $body .= $this->buildUserNode( $groupId, $pos );
      
      ++$pos;

    } //end foreach

    /*
    if( $this->dataSize > ($this->start + $this->stepSize) )
    {
      $body .= '<tr><td colspan="'.$this->numCols.'" class="wcm wcm_action_appear '.$this->searchForm.' '.$this->id.'"  ><var>'.($this->start + $this->stepSize).'</var>Paging to the next '.$this->stepSize.' entries.</td></tr>';
    }
    */

    $body .= '</tbody>'.NL;
    //\ Create the table body

    return $body;

  }//end public function buildTbody */

  /**
   * @param int $groupId
   * @param int $groupPos
   * @return string
   */
  public function buildUserNode( $groupId, $groupPos )
  {

    if( !isset( $this->dataUser[$groupId] ) )
      return '';

    $childs = $this->dataUser[$groupId];

    $body = '';
    
    $pos = 1;

    foreach( $childs as $userId => $row )
    {

      if( isset($row['id']) )
      {
        $rowid      = $this->id.'_row_'.$groupId.'_'.$userId;
        $pRowid     = 'child-of-'.$this->id.'_row_'.$groupId.' group-'.$groupId;

        $body .= '<tr class="row'.$this->num.' '.$pRowid.' wgt-border-top flag_partial" id="'.$rowid.'"  >'.NL;
      
        $body .= '<td valign="top" class="pos" >'.$groupPos.'.'.$pos.'</td>'.NL;
        $body .= '<td valign="top" class="ind1" >'.$this->icon('control/user.png','User').' '.$row['name'].' (partial)</td>'.NL;
        $body .= '<td colspan="2"  ></td>'.NL;

        if( $this->enableNav )
        {
          $navigation  = $this->buildCustomButtons
          ( 
            $this->userButtons, 
            array('clean'), 
            '0&group_id='.$groupId.'&user_id='.$userId.'&area_id='.$this->areaId 
           );
          $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
        }

        $body .= '</tr>'.NL;
      }
      else
      {
        $objid      = $row['wbfsys_group_users_rowid'];
        $rowid      = $this->id.'_row_'.$groupId.'_'.$userId;
        $pRowid     = 'child-of-'.$this->id.'_row_'.$groupId.' group-'.$groupId;


        $body .= '<tr class="row'.$this->num.' '.$pRowid.' wgt-border-top" id="'.$rowid.'"  >'.NL;
        
        $body .= '<td valign="top" class="pos" >'.$groupPos.'.'.$pos.'</td>'.NL;
        $body .= '<td valign="top" >'.$this->icon('control/user.png','User').' '.$row['user'].'</td>'.NL;
        $body .= '<td valign="top" >'
          .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_start"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_start]"
            value="'.
            (
               '' != trim( $row['wbfsys_group_users_date_start'] )
                ?$this->view->i18n->date( $row['wbfsys_group_users_date_start'] )
                :''
            ).'" /></td>'.NL;

        $body .= '<td valign="top" >'
          .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_end]"
            value="'.
            (
              '' != trim( $row['wbfsys_group_users_date_end'] )
                ?$this->view->i18n->date( $row['wbfsys_group_users_date_end'] )
                :''
            ).'" /></td>'.NL;


        if( $this->enableNav )
        {
        
          $navigation  = $this->buildCustomButtons
          ( 
            $this->userButtons, 
            array('clean','delete'), 
            $row['wbfsys_group_users_rowid'].'&group_id='.$groupId.'&user_id='.$userId.'&area_id='.$this->areaId 
          );
          
          $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
        }

        $body .= '</tr>'.NL;
      }

      $this->num ++;
      if ( $this->num > $this->numOfColors )
        $this->num = 1;

      $body .= $this->buildDatasetNode( $groupId, $userId, $groupPos, $pos );
      
      ++$pos;

    }

    return $body;

  }//end public function buildUserNode */

  /**
   * @param int $groupId
   * @param int $userId
   */
  public function buildDatasetNode( $groupId, $userId, $groupPos, $userPos  )
  {

    if(!isset($this->dataEntity[$groupId][$userId]))
      return '';

    $childs = $this->dataEntity[$groupId][$userId];

    $body = '';
    
    $pos  = 1;

    foreach( $childs as $row )
    {

      $objid       = $row['wbfsys_group_users_rowid'];
      $rowid       = $this->id.'_row_'.$objid;
      $pRowid      = 'child-of-'.$this->id.'_row_'.$groupId.'_'.$userId.' user-'.$userId.' group-'.$groupId;

      $body .= '<tr class="row'.$this->num.' '.$pRowid.'" id="'.$rowid.'" >'.NL;
      
      $body .= '<td valign="top" class="pos" >'.$groupPos.'.'.$userPos.'.'.$pos.'</td>'.NL;

      $body .= '<td valign="top" class="ind2" >'.$this->icon( 'control/entity.png', 'Entity' ).' <a href="maintab.php?c=Enterprise.Employee.edit&amp;objid='.$row['enterprise_employee_rowid'].'" class="wcm wcm_req_ajax" >Employee: '.$row['enterprise_employee_rowid'].'</a></td>'.NL;
      $body .= '<td valign="top" >'
        .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_start"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_start]" value="'.
            (
              '' != trim( $row['wbfsys_group_users_date_start'] )
                ?$this->view->i18n->date( $row['wbfsys_group_users_date_start'] )
                :''
            ).'" />'
        .'</td>'.NL;

      $body .= '<td valign="top" >'
        .'<input
          type="text"
          class="'.$this->editForm.' wcm wcm_ui_date show small"
          id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
          name="qfdu[wbfsys_group_users]['.$objid.'][date_end]"
          value="'.
          (
            '' != trim( $row['wbfsys_group_users_date_end'] )
              ? $this->view->i18n->date( $row['wbfsys_group_users_date_end'] )
              : ''
          ).'" />'
        .'</td>'.NL;

      if( $this->enableNav )
      {
        $navigation  = $this->buildCustomButtons
        ( 
          $this->datasetButtons, 
          $this->datasetActions, 
          $objid 
        );
        $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $this->num ++;
      if ( $this->num > $this->numOfColors )
        $this->num = 1;
        
      ++$pos;

    }

    return $body;

  }//end public function buildDatasetNode */

////////////////////////////////////////////////////////////////////////////////
// Ajax Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * parse the table
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
        $body .= '<tr><td colspan="'.$numCols.'" class="wcm wcm_action_appear '
          .$this->searchForm.' '.$this->id.'"  ><var>'
          .($this->start + $this->stepSize)
          .'</var>Paging to the next '.$this->stepSize.' entries.</td></tr>';
      }

      $body .= ']]></htmlArea>';
    }

    $this->xml = $body;

    return $this->xml;

  }//end public function buildAjax */

  /**
   * parse the table
   *
   * @return string
   */
  public function buildAjaxEntry( )
  {

    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific builder method from outside
    // of the view, but then get the html of the called parse method
    if( $this->xml )
      return $this->xml;

    // erst mal kein append mode, gehen wir mal davon aus
    // dass alles angezeigt werden kann

    foreach( $this->data as $key => $row   )
    {

      $objid       = $key;
      $rowid       = $this->id.'_row_'.$objid;

      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" check="#'.$rowid.'" not="true" ><![CDATA['.NL;
      $body .= '<tr class="title" id="'.$rowid.'" >'.NL;
      
      $body .= '<td valign="top" class="pos" >1</td>'.NL;
      $body .= '<td valign="top" colspan="3" >'.$row['wbfsys_role_group_name'].'</td>'.NL;

      $navigation  = $this->rowMenu
        (
          $objid.'&group_id='.$key,
          $row
        );
      $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;

      $body .= '</tr>]]></htmlArea>'.NL;

      $body .= $this->buildAjaxUserNode( $key );

    }//end foreach


    $this->xml = $body;

    return $this->xml;

  }//end public function buildAjaxEntry */

  /**
   * @param int $groupId
   * @return string
   */
  public function buildAjaxUserNode( $groupId )
  {

    if(!isset($this->dataUser[$groupId]))
      return '';

    $childs = $this->dataUser[$groupId];

    $body = '';

    foreach( $childs as $key => $row )
    {

      if( isset($row['id']) )
      {
        $userId     = $row['id'];
        $objid      = $userId;
        $rowid      = $this->id.'_row_'.$groupId.'_'.$userId;
        $pRowid     = 'child-of-'.$this->id.'_row_'.$groupId.' group-'.$groupId;

        $body .= '<htmlArea selector="tr.#'.$this->id.'_row_'
          .$groupId.'" action="after" check="#'
          .$rowid.'" not="true" ><![CDATA['.NL;
          
        $body .= '<tr class="row'.$this->num.' '.$pRowid.' wgt-border-top flag_partial" id="'.$rowid.'"  >'.NL;
        
        $body .= '<td valign="top" class="pos" >1</td>'.NL;
        $body .= '<td valign="top" class="ind1" >'.$this->icon('control/user.png','User').' '.$row['name'].' (partial)</td>'.NL;
        $body .= '<td colspan="2"  ></td>'.NL;

        if( $this->enableNav )
        {
          $navigation  = $this->buildCustomButtons
          ( 
            $this->userButtons, 
            array('clean'), 
            '0&group_id='.$groupId.'&user_id='.$userId.'&area_id='.$this->areaId 
          );
          $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
        }

        $body .= '</tr>]]></htmlArea>'.NL;
      }
      else
      {

        $userId     = $row['wbfsys_role_user_rowid'];
        $objid      = $row['wbfsys_group_users_rowid'];
        $rowid      = $this->id.'_row_'.$groupId.'_'.$userId;
        $pRowid     = 'child-of-'.$this->id.'_row_'.$groupId.' group-'.$groupId;

        $body .= '<htmlArea selector="tr.#'.$this->id.'_row_'.$groupId
          .'" action="after" else="replace" check="#'.$rowid.'" not="true"  ><![CDATA['.NL;
          
        $body .= '<tr class="row'.$this->num.' '.$pRowid.' wgt-border-top" id="'.$rowid.'"  >'.NL;
        
        $body .= '<td valign="top" class="pos" >1</td>'.NL;
        $body .= '<td valign="top" >'.$this->icon('control/user.png','User').' '.$row['user'].'</td>'.NL;
        $body .= '<td valign="top" >'
          .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_start"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_start]"
            value="'.
            (
              '' != trim( $row['wbfsys_group_users_date_start'] )
                ? $this->view->i18n->date( $row['wbfsys_group_users_date_start'] )
                : ''
            ).'" /></td>'.NL;

        $body .= '<td valign="top" >'
          .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_end]"
            value="'.
            (
              '' != trim( $row['wbfsys_group_users_date_end'] )
                ? $this->view->i18n->date( $row['wbfsys_group_users_date_end'] )
                : ''
            ).'" /></td>'.NL;


        if( $this->enableNav )
        {
          $navigation  = $this->buildCustomButtons
          ( 
            $this->userButtons, 
            array('clean','delete'), 
            $row['wbfsys_group_users_rowid'].'&group_id='.$groupId.'&user_id='.$userId.'&area_id='.$this->areaId 
          );
          $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
        }

        $body .= '</tr>]]></htmlArea>'.NL;

      }

      $this->num ++;
      if ( $this->num > $this->numOfColors )
        $this->num = 1;

      $body .= $this->buildAjaxDatasetNode( $groupId, $userId );

    }

    return $body;

  }//end public function buildAjaxUserNode */

  /**
   * @param int $groupId
   * @param int $userId
   */
  public function buildAjaxDatasetNode( $groupId, $userId  )
  {

    if(!isset($this->dataEntity[$groupId][$userId]))
      return '';

    $childs = $this->dataEntity[$groupId][$userId];

    $body = '';

    foreach( $childs as $row )
    {

      $objid       = $row['wbfsys_group_users_rowid'];
      $rowid       = $this->id.'_row_'.$objid;
      $pRowid      = 'child-of-'.$this->id.'_row_'.$groupId.'_'.$userId.' user-'.$userId.' group-'.$groupId;

      $body = '<htmlArea selector="tr#'.$this->id.'_row_'.$groupId.'_'
        .$userId.'" action="after" check="#'.$rowid
        .'" else="replace" not="true" ><![CDATA['.NL;
        
      $body .= '<tr class="row'.$this->num.' '.$pRowid.'" id="'.$rowid.'" >'.NL;
      
      $body .= '<td valign="top" class="pos" >1</td>'.NL;
      $body .= '<td valign="top" class="ind2" >'.$this->icon('control/entity.png','Entity').' <a href="maintab.php?c=Enterprise.Employee.edit&amp;objid='.$row['enterprise_employee_rowid'].'" class="wcm wcm_req_ajax" >Employee: '.$row['enterprise_employee_rowid'].'</a></td>'.NL;
      $body .= '<td valign="top" >'
        .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_start"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_start]"
            value="'
            .(
               '' != trim( $row['wbfsys_group_users_date_start'] )
                ? $this->view->i18n->date( $row['wbfsys_group_users_date_start'] )
                : ''
            ).'" />'
        .'</td>'.NL;

      $body .= '<td valign="top" >'
        .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
            name="qfdu[wbfsys_group_users]['.$objid.'][date_end]"
            value="'
          .(
            '' != trim( $row['wbfsys_group_users_date_end'] )
              ? $this->view->i18n->date( $row['wbfsys_group_users_date_end'] )
              : ''
            ).'" />'
        .'</td>'.NL;

      if( $this->enableNav )
      {
        $navigation  = $this->buildCustomButtons
        ( 
          $this->datasetButtons, 
          $this->datasetActions, 
          $objid 
        );
        $body .= '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>]]></htmlArea>'.NL;

      $this->num ++;
      if ( $this->num > $this->numOfColors )
        $this->num = 1;

    }

    return $body;

  }//end public function buildAjaxDatasetNode */

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

    $html = '<div class="wgt-panel wgt-border-top" >'.NL;
    $html .= '  <div class="right menu"  >';
    $html .=  $this->menuTableSize();
    $html .= '  </div>';
    $html .= $this->metaInformations();
    $html .= '</div>'.NL;

    return $html;

  }//end public function buildTableFooter */

  /**
   * build the table footer
   * @return string
   */
  public function buildElementFooter()
  {

    $html = <<<HTML
  <div class="wgt-panel" >
  </div>
HTML;

    return $html;

  }//end public function buildElementFooter */

} // end class AclMgmt_Qfdu_Treetable_Element */

