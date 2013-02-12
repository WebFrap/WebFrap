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
class AclUser_Treetable_Element
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
  public $id       = 'wgt-treetable-mgmt-acl-list-tuser';

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
  public $dataGroup   = null;

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
   * @var DomainNode
   */
  public $domainNode  = null;
  
  /**
   * Ist kein Single menu
   * @var boolean
   */
  public $bTypeSingle = false;

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
  * initiales setup der urls
  */
  public function loadUrl()
  {
    
    $this->id = 'wgt-treetable-'.$this->domainNode->domainName.'-acl-list-tuser';
  
    $this->url['group']      = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt_Qfdu.cleanGroup&amp;dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/clean.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'inheritance'  => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Inherit Rights',
        'maintab.php?c=Acl.Mgmt_Path.showGraph&dkey='.$this->domainNode->domainName.'&amp;objid=',
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
    $this->actions['group'] = array( 'inheritance', 'delete' );

    $this->url['user']  = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt_Qfdu.deleteUser&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/delete.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'clean'  => array
      (
        Wgt::ACTION_DELETE,
        'Clean',
        'index.php?c=Acl.Mgmt_Qfdu.cleanUser&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/clean.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
    );
    $this->actions['user'] = array( 'clean', 'delete' );

    $this->url['dset']  = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Acl.Mgmt_Qfdu.deleteDataset&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/delete.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
      'dset_mask'  => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Dset Rights',
        'maintab.php?c=Acl.Mgmt_Dset.listing&dkey='.$this->domainNode->domainName.'&amp;objid=',
        'control/rights.png',
        '',
        'wbf.label',
        Acl::ADMIN
      ),
    );
    $this->actions['dset'] = array( 'dset_mask', 'delete' );

  }//end public function loadUrl */

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////



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
      //$this->dataUser   = $data->users;
      //$this->dataEntity = $data->datasets;
    }
    else
    {
      $this->data = $data;
    }

  }//end public function setData */
  
  /**
   * set the table data
   * @param array $data
   * @return void
   */
  public function setUserData( $data, $count = false )
  {

    if( !$data )
      return;

    if( is_object( $data ) && $count )
    {
      $this->dataUser   = $data;
      $this->dataSize   = $data->getSourceSize();
      //$this->dataUser   = $data->users;
      //$this->dataEntity = $data->datasets;
    }
    else
    {
      $this->dataUser = $data;
    }

  }//end public function setUserData */
  
  /**
   * set the table data
   * @param array $data
   * @return void
   */
  public function setDsetData( $data )
  {

    $this->dataEntity = $data;
    //$this->dataSize   = $data->getSourceSize();

  }//end public function setDsetData */

  /**
   * set the table data
   * @param array $data
   * @return void
   */
  public function setGroupData( $data )
  {

    $this->dataGroup = $data;
    //$this->dataSize   = $data->getSourceSize();

  }//end public function setGroupData */

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
      

    $icons = array();
    $icons['closed'] = $this->icon( 'control/closed.png', 'Closed' );

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
      $this->html .= '<var id="'.$this->id.'-table-cfg-grid"  >{
        "height":"large",
        "search_form":"'.$this->searchForm.'",
        "expandable":false,
        "load_urls":{
        	"dsets"  : "ajax.php?c=Acl.Mgmt_Qfdu.loadListUserDsets&dkey='.$this->domainNode->domainName.'&elid='.$this->id.'-table",
        	"groups" : "ajax.php?c=Acl.Mgmt_Qfdu.loadListUserGroups&dkey='.$this->domainNode->domainName.'&elid='.$this->id.'-table"
        }
      }</var>';

      $this->html .= $this->buildElementFooter();

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

    if( $this->enableNav )
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;

    // check for multi selection
    $html .= '<th style="width:40px;" class="pos" >'.$this->i18n->l( 'Pos:', 'wbf.label'  ).'</th>'.NL;

    $html .= '<th style="width:350px" >
      '.$this->view->i18n->l
      (
        'User / {@label@} / Group',
        'wbf.label',
        array( 'label' => $this->domainNode->label )
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
      $html .= '<th style="width:55px;">'.$this->view->i18n->l( 'Menu', 'wbf.label'  ).'</th>'.NL;

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

    $icons = array();
    $icons['closed'] = $this->icon( 'control/closed.png', 'Closed' );
    $icons['user'] = $this->icon( 'control/user.png', 'User' );
    
    // create the table body
    $body = '<tbody>'.NL;

    $pos = 1;
    $num = 1;  
    
    foreach( $this->dataUser as  $row )
    {

        $userId     = $row['role_user_rowid'];
        $objid      = $userId;
        $rowid      = $this->id.'_row_'.$userId;
        
        if( $this->enableNav )
        {
          $navigation  = $this->rowMenu
          ( 
            '0&user_id='.$userId.'&area_id='.$this->areaId,
            $row,
            null,
            null,
            'user'
          );
          $navigation = '<td valign="top" class="nav_split" >'.$navigation.'</td>'.NL;
        }
        
        $body .= <<<HTML

	<tr class="wcm wcm_ui_highlight row{$num} wgt-border-top flag_partial" id="{$rowid}"  >
		<td valign="top" class="pos" >{$pos}</td>
		<td valign="top" class="ind1" ><span 
				class="wgt-loader" 
				wgt_source_key="dsets" 
				wgt_eid="{$userId}" >{$icons['closed']}</span> {$icons['user']}
			<a 
      	class="wcm wcm_req_ajax" 
        href="modal.php?c=Webfrap.ContactForm.formUser&amp;user_id={$row['role_user_rowid']}&amp;d_src={$this->domainNode->domainName}" >
        {$row['user']}</a> ({$row['num_dsets']})
    </td>
		<td colspan="2" >&nbsp;</td>
		{$navigation}
	</tr>

HTML;
      
      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;
        
      ++$pos;

    }

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
   * Rendern des User Blocks
   * @param int $groupId
   * @param ContextListing $context
   * 
   * @used
   */
  public function renderDsetBlock( $userId, $context )
  {
    
    $icons = array();
    $icons['closed'] = $this->icon( 'control/closed.png', 'Closed' );
    $icons['dset']   = $this->icon( 'control/dset.png', 'Dset' );

    $body = '<htmlArea selector="tr#'.$this->id.'_row_'.$userId.'" action="after" ><![CDATA['.NL;

    $pos = 1;
    $num = 1;

    foreach( $this->dataEntity as $row )
    {

      $objid       = $row['dset_rowid'];
      $rowid       = $this->id.'_row_'.$userId.'_'.$objid;
      $pRowid      = 'c-'.$this->id.'_row_'.$userId.' user-'.$userId;
      

      if( $this->enableNav )
      {
        $navigation  = $this->rowMenu
        ( 
          $objid,
          $row,
          null,
          null,
          'dset'           
        );
        $navigation = '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
      }

      $body .= <<<HTML
      
      <tr class="wcm wcm_ui_highlight row{$num} {$pRowid}" id="{$rowid}" >
      	<td valign="top" class="pos" >{$context->pRowPos}.{$pos}</td>
        
        <td valign="top" class="ind1" >&nbsp;&nbsp;
        	<span 
        		class="wgt-loader" 
        		wgt_source_key="groups" 
        		wgt_param="&amp;user={$userId}" wgt_eid="{$objid}" >{$icons['closed']}</span>
          
          <a 
            href="maintab.php?c={$this->domainNode->domainUrl}.edit&amp;objid={$row['dset_rowid']}" 
            class="wcm wcm_req_ajax" >
            {$icons['dset']} {$row['dset_text']}
          </a> ({$row['num_groups']})
        </td>
        
        <td valign="top" colspan="2" >&nbsp;</td>
        {$navigation}
      </tr>

HTML;


      $pos ++;
      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;
      
    }

    $body .= ']]></htmlArea>'.NL;

    return $body;
    
  }//end public function renderDsetBlock */
  
  /**
   * Rendern des User Blocks
   * @param int $groupId
   * @param ContextListing $context
   */
  public function renderGroupBlock( $userId, $dsetId, $context )
  {

    $icons = array();
    $icons['closed'] = $this->icon( 'control/closed.png', 'Closed' );
    
    $body = '<htmlArea selector="tr#'.$this->id.'_row_'.$userId.'_'.$dsetId.'" action="after" ><![CDATA['.NL;

    $pos = 1;
    $num = 1;  
    
    foreach( $this->dataGroup as  $row )
    {

      $objid      = $row['group_users_rowid'];
      $rowid      = $this->id.'_row_'.$userId.'_'.$dsetId.'_'.$objid;
      $pRowid     = 'c-'.$this->id.'_row_'.$userId.'_'.$dsetId.' user-'.$userId.' dset-'.$dsetId;
      
      $dateStart  = '' != trim( $row['group_users_date_start'] )
        ? $this->view->i18n->date( $row['group_users_date_start'] )
        : '';
      $dateEnd    = '' != trim( $row['group_users_date_end'] )
        ? $this->view->i18n->date( $row['group_users_date_end'] )
        : '';
        
      $navigation  = $this->rowMenu
      ( 
        $objid.'&dset_id='.$dsetId.'&user_id='.$userId.'&area_id='.$this->areaId,
        $row,
        null,
        null,
        'group'
      );
      $navigation = '<td valign="top"  class="nav_split"  >'.$navigation.'</td>'.NL;
              
      $body .= <<<HTML
      
      <tr class="row{$num} {$pRowid} wgt-border-top" id="{$rowid}"  >
      	<td valign="top" class="pos" >{$context->pRowPos}.{$pos}</td>
      	<td valign="top" class="ind2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$row['role_group_name']}</td>
      	
				<td valign="top" >
  				<input
            type="text"
            class="{$this->editForm} wcm wcm_ui_date show small"
            id="wgt-input-acl-{$this->domainNode->aclDomainKey}-tuser-{$objid}-date_start"
            name="qfdu[group_users][{$objid}][date_start]"
            value="{$dateStart}" />
        </td>
				<td valign="top" >
          <input
            type="text"
            class="{$this->editForm} wcm wcm_ui_date show small"
            id="wgt-input-acl-{$this->domainNode->aclDomainKey}-tuser-{$objid}-date_end"
            name="qfdu[group_users][{$objid}][date_end]"
          	value="{$dateEnd}" /></td>
        
      	{$navigation}
      </tr>

HTML;


      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;
        
      ++$pos;

    }
    
    $body .= ']]></htmlArea>'.NL;

    return $body;
    
  }//end public function renderGroupBlock */

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
      $body .= '<td valign="top" colspan="3" >'.$row['role_group_name'].'</td>'.NL;

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

        $userId     = $row['role_user_rowid'];
        $objid      = $row['group_users_rowid'];
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
            name="qfdu[group_users]['.$objid.'][date_start]"
            value="'.
            (
              '' != trim( $row['group_users_date_start'] )
                ? $this->view->i18n->date( $row['group_users_date_start'] )
                : ''
            ).'" /></td>'.NL;

        $body .= '<td valign="top" >'
          .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
            name="qfdu[group_users]['.$objid.'][date_end]"
            value="'.
            (
              '' != trim( $row['group_users_date_end'] )
                ? $this->view->i18n->date( $row['group_users_date_end'] )
                : ''
            ).'" /></td>'.NL;


        if( $this->enableNav )
        {
          $navigation  = $this->buildCustomButtons
          ( 
            $this->userButtons, 
            array('clean','delete'), 
            $row['group_users_rowid'].'&group_id='.$groupId.'&user_id='.$userId.'&area_id='.$this->areaId 
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

    if( !isset( $this->dataEntity[$groupId][$userId] ) )
      return '';

    $childs = $this->dataEntity[$groupId][$userId];

    $body = '';

    foreach( $childs as $row )
    {

      $objid       = $row['group_users_rowid'];
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
            name="qfdu[group_users]['.$objid.'][date_start]"
            value="'
            .(
               '' != trim( $row['group_users_date_start'] )
                ? $this->view->i18n->date( $row['group_users_date_start'] )
                : ''
            ).'" />'
        .'</td>'.NL;

      $body .= '<td valign="top" >'
        .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
            name="qfdu[group_users]['.$objid.'][date_end]"
            value="'
          .(
            '' != trim( $row['group_users_date_end'] )
              ? $this->view->i18n->date( $row['group_users_date_end'] )
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
  
////////////////////////////////////////////////////////////////////////////////
// Deprecated
////////////////////////////////////////////////////////////////////////////////
  

  /**
   * @param int $groupId
   * @param int $groupPos
   * @return string
   * @deprecated
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
        $objid      = $row['group_users_rowid'];
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
            name="qfdu[group_users]['.$objid.'][date_start]"
            value="'.
            (
               '' != trim( $row['group_users_date_start'] )
                ?$this->view->i18n->date( $row['group_users_date_start'] )
                :''
            ).'" /></td>'.NL;

        $body .= '<td valign="top" >'
          .'<input
            type="text"
            class="'.$this->editForm.' wcm wcm_ui_date show small"
            id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
            name="qfdu[group_users]['.$objid.'][date_end]"
            value="'.
            (
              '' != trim( $row['group_users_date_end'] )
                ?$this->view->i18n->date( $row['group_users_date_end'] )
                :''
            ).'" /></td>'.NL;


        if( $this->enableNav )
        {
        
          $navigation  = $this->buildCustomButtons
          ( 
            $this->userButtons, 
            array('clean','delete'), 
            $row['group_users_rowid'].'&group_id='.$groupId.'&user_id='.$userId.'&area_id='.$this->areaId 
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

      $objid       = $row['group_users_rowid'];
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
            name="qfdu[group_users]['.$objid.'][date_start]" value="'.
            (
              '' != trim( $row['group_users_date_start'] )
                ?$this->view->i18n->date( $row['group_users_date_start'] )
                :''
            ).'" />'
        .'</td>'.NL;

      $body .= '<td valign="top" >'
        .'<input
          type="text"
          class="'.$this->editForm.' wcm wcm_ui_date show small"
          id="wgt-input-acl-enterprise_employee-qfdu-'.$objid.'-date_end"
          name="qfdu[group_users]['.$objid.'][date_end]"
          value="'.
          (
            '' != trim( $row['group_users_date_end'] )
              ? $this->view->i18n->date( $row['group_users_date_end'] )
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
  

} // end class AclMgmt_Qfdu_Treetable_User_Element */

