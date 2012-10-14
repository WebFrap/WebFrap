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
class DaidalosBackupDb_Table_Element
  extends WgtTable
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the id of the table
   *
   * @var string $id
   */
  public $id       = 'wgt-table-maintenance_backup_db';



  /**
   * List with all URLS
   * @var array
   */
  public $url = array
  (

    'form'  => array
    (
      Wgt::ACTION_AJAX_GET,
      'form',
      'index.php?c=Daidalos.BackupDb.form&amp;objid=',
      'webfrap/form.png',
      'wcm wcm_req_ajax',
      'wbfsys.bookmark.label.tableTitleEdit'
    ),
    'backup'  => array
    (
      Wgt::ACTION_AJAX_GET,
      'backup',
      'index.php?c=Daidalos.BackupDb.backup&amp;objid=',
      'webfrap/backup.png',
      'wcm wcm_req_conf',
      'wbfsys.bookmark.label.tableTitleDelete'
    ),
    'restore'  => array
    (
      Wgt::ACTION_AJAX_GET,
      'restore',
      'index.php?c=Daidalos.BackupDb.restore&amp;objid=',
      'webfrap/restore.png',
      'wcm wcm_req_conf',
      'wbfsys.bookmark.label.tableTitleDelete'
    ),

  );

////////////////////////////////////////////////////////////////////////////////
// buildr methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the table
   *
   * @return String
   */
  public function buildHtml( )
  {

    if( $this->html )
      return $this->html;

    $this->numCols = 2;

    // Creating the Head
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;

    $head .= '<th style="width:120px" >'.I18n::s( 'name', 'maintenance.text.name'  ).'</th>'.NL;
    $head .= '<th style="width:120px" >'.I18n::s( 'driver', 'maintenance.text.driver'  ).'</th>'.NL;
    $head .= '<th style="width:120px" >'.I18n::s( 'server', 'maintenance.text.server'  ).'</th>'.NL;
    $head .= '<th style="width:120px" >'.I18n::s( 'database', 'maintenance.text.database'  ).'</th>'.NL;
    $head .= '<th style="width:120px" >'.I18n::s( 'schema', 'maintenance.text.schema'  ).'</th>'.NL;
    $head .= '<th style="width:90px;">'.I18n::s( 'nav', 'wbf.text.tableNav'  ).'</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    //$data = $this->data['connection'];

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;
    foreach( $this->data as $key => $row   )
    {
      //$objid  = $row['wbfsys_bookmark_'.Db::PK];

      $rowid      = $this->id.'_row_'.$key;
      $navigation = $this->buildActions( $key );

/*
'class'     => 'PostgresqlPersistent',
'dbhost'    => 'localhost',
'dbport'    => '5432',
//'dbname'    => 'webfrap_de',
'dbname'    => 'webfrap_gw_full',
'dbuser'    => 'webfrapadmin',
'dbpwd'     => 'webfrapadmin',
'dbschema'  => 'webfrap',
'quote'     => 'single' // single|multi
*/

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" >'.$key.'</td>'.NL;
      $body .= '<td valign="top" >'.$row['class'].'</td>'.NL;
      $body .= '<td valign="top" >'.$row['dbhost'].'</td>'.NL;
      $body .= '<td valign="top" >'.$row['dbname'].'</td>'.NL;

      if( isset($row['dbschema']) )
        $body .= '<td valign="top" >'.$row['dbschema'].'</td>'.NL;
      else
        $body .= '<td valign="top" > </td>'.NL;

      $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
      $body .= '</tr>'.NL;

      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;

    } // ENDE FOREACH

    $body .= '</tbody>'.NL;
    //\ Create the table body

    if($this->insertMode )
    {
      $this->html .= '<div id="'.$this->id.'" class="wgt-grid" >'.NL;

      $this->html .= $this->buildPanel();

      $this->html .= '<table id="'.$this->id.'_table" class="wgt-grid wcm wcm_ui_grid" >'.NL;

      $this->html .= $head;
    }

    $this->html .= $body;

    if( $this->insertMode )
    {

      $this->html .= '</table>';
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="text/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;
    }

    return $this->html;

  }//end public function buildHtml */

  /**
   * build the table
   *
   * @return String
   */
  public function buildAjaxRows( )
  {

    if( $this->html )
      return $this->html;

    $body = '';

    foreach( $this->data as $key => $row   )
    {

      $objid = $row['wbfsys_bookmark_'.Db::PK];

      $rowid       = $this->id.'_row_'.$objid;
      $navigation  = $this->buildActions( $objid );

      if( $this->ajaxInsert )
        $body .= '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
      else
        $body .= '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';

      $body .= '<td valign="top" class="ignore" style="text-align:center;" ><img class="icon xsmall cursor_icon" src="'.View::$iconsPath.'xsmall/'.$this->imgIcon.'" /></td>'.NL;

      $body .= '<td valign="top" class="ignore" style="text-align:center;" >'.$navigation.'</td>'.NL;

      if( $this->ajaxInsert )
        $body .= '</tr>]]></htmlArea>'.NL;
      else
        $body .= ']]></htmlArea>'.NL;

    }//end foreach


    $this->html = $body;

    return $this->html;

  }//end public function buildAjaxRows */


}//end class WgtTableDaidalosBackupDb

