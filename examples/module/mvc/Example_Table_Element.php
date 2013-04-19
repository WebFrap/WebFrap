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
 * @subpackage ModCore
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class Example_Table_Element extends WgtTable
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
  public $id   = 'wgt_table-core_person';

  /**
   * the most likley class of a given query object
   *
   * @var CorePerson_Table_Query
   */
  public $data = null;

  /**
   * Namespace information für die Tabelle
   *
   * @var string $namespace
   */
  public $namespace   = 'CorePerson';

  /**
   * @var string
   */
  public $bodyHeight   = 'xxlarge';

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
        'index.php?c=Core.Person.search&amp;target_mask=CorePerson&amp;ltype=table'
      ),

      'show'    => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Show',
        'maintab.php?c=Core.Person.show&amp;target_mask=CorePerson&amp;ltype=table&amp;objid=',
        'control/show.png',
        'wcm wcm_ui_tip',
        'core.person.label',
        Acl::ACCESS,
        Acl::UPDATE
      ),

      'edit'    => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Edit',
        'maintab.php?c=Core.Person.edit&amp;target_mask=CorePerson&amp;ltype=table&amp;objid=',
        'control/edit.png',
        'wcm wcm_ui_tip',
        'core.person.label',
        Acl::UPDATE
      ),

      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Core.Person.delete&amp;target_mask=CorePerson&amp;ltype=table&amp;objid=',
        'control/delete.png',
        'wcm wcm_ui_tip',
        'core.person.label',
        Acl::DELETE
      ),

      'rights'  => array
      (
        Wgt::ACTION_BUTTON_GET,
        'Rights',
        'maintab.php?c=Core.Person_Acl_Dset.listing&amp;objid=',
        'control/rights.png',
        'wcm wcm_ui_tip',
        'core.person.label',
        Acl::ADMIN
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
    if ($this->insertMode) {
      $this->html .= '</table>';

      $this->html .= $this->buildTableFooter();
      $this->html .= '</div>'.NL;

      if ($conf->getStatus('grid.context_menu.enabled')) {
        $this->html .= $this->buildContextMenu();
      }

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

    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Firstname', 'core.person.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Lastname', 'core.person.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Email', 'core.person.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Street', 'core.address.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('Postalcode', 'core.address.label').'</th>'.NL;
    $html .= '<th style="width:200px" >'.$this->view->i18n->l('City', 'core.address.label').'</th>'.NL;

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

    $conf = $this->getConf();

    // soll das kontextmenü aktiviert werden
    $classContext = '';
    if ($conf->getStatus('grid.context_menu.enabled')) {
      $classContext = ' wcm_control_context_menu';
    }

    // create the table body
    $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $num = 1;
    $pos = 1;
    foreach ($this->data as $key => $row) {

      $objid       = $row['core_person_rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      // context menü
      $rowActions  = $this->getRowActions
      (
        $objid,
        $row
      );

      $menuActions = '';
      if ($rowActions) {
        $menuActions = ' wgt_actions="'.implode(',', $rowActions).'" ' ;
      }

      // doubcle click open
      $accessActionKey = $this->hasEditRights($row)?'edit':'show';

      $rowWcm       = '';
      $rowParams   = '';
      $dsUrl        = null;
      // check if the row has
      if ($dsUrl = $this->getActionUrl($objid, $row)) {
        $rowWcm     .= ' wcm_control_access_dataset';
        $rowParams .= ' wgt_url="'.$dsUrl.'" ';
      }

      $body .= '<tr class="wcm wcm_ui_highlight '.$rowWcm.$classContext.' row'.$num.' node-'.$objid.'" '

        .' wgt_context_menu="'.$this->id.'-cmenu" '
        .$menuActions

        .$rowParams

        .' id="'.$rowid.'" >'.NL;

      $body .= '<td valign="top" class="pos" name="slct['.$objid.']" style="text-align:right;" >'.$pos.'</td>'.NL;

      $body .= '<td valign="top" ><a class="wcm wcm_req_mtab" title="Click to open" href="maintab.php?c=Core.Person.'.$accessActionKey.'&amp;objid='.$objid.'&amp;target_id='.$this->id.'" >'.Validator::sanitizeHtml($row['core_person_firstname']).'</a></td>'.NL;

      $body .= '<td valign="top" ><a class="wcm wcm_req_mtab" title="Click to open" href="maintab.php?c=Core.Person.'.$accessActionKey.'&amp;objid='.$objid.'&amp;target_id='.$this->id.'" >'.Validator::sanitizeHtml($row['core_person_lastname']).'</a></td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['core_person_email']).'</td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['address_street']).'</td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['address_postalcode']).'</td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['address_city']).'</td>'.NL;

      if ($this->enableNav) {
        $navigation  = $this->rowMenu
        (
          $objid,
          $row
        );
        $body .= '<td valign="top"  class="nav"  >'.$navigation.'</td>'.NL;
      }

      $body .= '</tr>'.NL;

      $pos ++;
      $num ++;
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

    $conf = $this->getConf();

    $classContext = '';
    if ($conf->getStatus('grid.context_menu.enabled')) {
      $classContext = ' wcm_control_context_menu';
    }

    $body = '';

    $rowActions  = $this->getRowActions
    (
      $objid,
      $row
    );
    $accessActionKey = $this->hasEditRights($row)?'edit':'show';

    $dsUrl        = null;
    $rowWcm       = '';
    $rowParams   = '';
    $menuActions = '';

    if ($rowActions) {
      $menuActions = ' wgt_actions="'.implode(',', $rowActions).'" ' ;
    }

    // check if the row has
    if ($dsUrl = $this->getActionUrl($objid, $row)) {
      $rowWcm     .= ' wcm_control_access_dataset';
      $rowParams .= ' wgt_url="'.$dsUrl.'" ';
    }

    // is this an insert or an update area
    if ($this->insertMode) {
      $body = '<htmlArea selector="table#'.$this->id.'-table>tbody" action="prepend" >'
        .'<![CDATA[<tr '
        .' wgt_context_menu="'.$this->id.'-cmenu" '
        .' wgt_eid="'.$objid.'" '
        .$rowParams
        .' class="wcm wcm_ui_highlight '.$rowWcm .$classContext.' node-'.$objid.'" '
        .' id="'.$rowid.'" >'.NL;
    } elseif ($this->appendMode) {
      $body = '<tr id="'.$rowid.'" '
        .' wgt_eid="'.$objid.'" '
        .$rowParams
        .' wgt_context_menu="'.$this->id.'-cmenu" '
        .' class="wcm wcm_ui_highlight wcm_control_access_dataset '.$classContext.' node-'.$objid.'" >'.NL;
    } else {
      $body = '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';
    }

    $body .= '<td valign="top" class="pos" name="slct['.$objid.']" style="text-align:right;" >1</td>'.NL;

      $body .= '<td valign="top" ><a class="wcm wcm_req_mtab" title="Click to open" href="maintab.php?c=Core.Person.'.$accessActionKey.'&amp;objid='.$objid.'&amp;target_id='.$this->id.'" >'.Validator::sanitizeHtml($row['core_person_firstname']).'</a></td>'.NL;

      $body .= '<td valign="top" ><a class="wcm wcm_req_mtab" title="Click to open" href="maintab.php?c=Core.Person.'.$accessActionKey.'&amp;objid='.$objid.'&amp;target_id='.$this->id.'" >'.Validator::sanitizeHtml($row['core_person_lastname']).'</a></td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['core_person_email']).'</td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['address_street']).'</td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['address_postalcode']).'</td>'.NL;

      $body .= '<td valign="top" >'.Validator::sanitizeHtml($row['address_city']).'</td>'.NL;

    if ($this->enableNav) {

      $navigation  = $this->rowMenu
      (
        $objid,
        $row
      );

      $body .= '<td valign="top"  class="nav"  >'
        .$navigation.'</td>'.NL;
    }

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

    $html = '<div class="wgt-panel wgt-border-top" >'.NL;
    $html .= ' <div class="right menu"  >';
    $html .=     $this->menuTableSize();
    $html .= ' </div>';
    $html .= ' <div class="menu" style="float:left;" style="width:100px;" >';
    //$html .=   $this->menuTableSize();
    $html .= ' </div>';
    $html .= ' <div class="menu"  style="text-align:center;margin:0px auto;" >';
    $html .=     $this->menuCharFilter();
    $html .= ' </div>';
    $html .= $this->metaInformations();
    $html .= '</div>'.NL;

    return $html;

  }//end public function buildTableFooter */

}//end class CorePerson_Table_Element

