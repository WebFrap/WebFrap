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
 * class WgtTableDeveloperErd
 * @package WebFrap
 * @subpackage ModGenf
 */
class DaidalosProjects_Table
  extends WgtTable
{
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

 /**
   * Loading the tabledata from the database
   *
   * @return void
   */
  public function load(  )
  {

    /*
    $folder = new LibFilesystemFolder( PATH_GW.'data/bdl/' );
    $files = $folder->getPlainFiles();

    $this->data = array();

    // Load als xmi Files
    foreach( $files as $file )
      if( substr( $file, -3 , strlen($file) ) == "xml" )
        $this->data[] = $file;
    */

    $data = array();

    include PATH_GW.'conf/map/bdl/projects/projects.php';

    $this->data = $data;

    ksort($this->data);

  } // end public function load

 /**
   * Generieren einer Tabelle ohne Template
   *
   * @param string $Class Der Datenbanktype
   * @return
   */
  public function buildTable( )
  {

    $view = View::getActive();

    // Creating the Head
    $head = '<thead class="ui-widget-header" >'.NL;
    $head .= '<tr>'.NL;

    $head .= '<th  >Project Name</th>'.NL;
    //$head .= '<th>File</th>'.NL;
    $head .= '<th >Description</th>'.NL;
    $head .= '<th style="width:165px" >Nav</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody class="ui-widget-content" >'.NL;

    $num = 1;
    foreach ($this->data as $key => $row) {
      $rowid = $this->name."_row_$key";

      $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

      $urlConf = 'index.php?c=Daidalos.Projects.genMask&amp;objid='.urlencode($key);
      $linkConf = '<a title="GenMask"  class="wcm wcm_req_ajax wgt_info" href="'.$urlConf.'">'
        .Wgt::icon('daidalos/bdl_mask.png' , 'xsmall' , 'build' ).'</a>';

      $urlGenerate = 'index.php?c=Genf.Bdl.build&amp;objid='.urlencode($key);
      $linkGenerate = '<a title="Code generieren"  class="wcm wcm_req_ajax wgt_info" href="'.$urlGenerate.'">'
        .Wgt::icon('daidalos/parser.png' , 'xsmall' , 'build' ).'</a>';

      /*
      $urlEdit = 'index.php?c=Genf.Bdl.edit&amp;objid='.urlencode($key);
      $linkEdit = '<a title="Projekt editieren"  class="wcm wcm_req_ajax wgt_info" href="'.$urlEdit.'">'
        .Wgt::icon('control/edit.png' , 'xsmall' , 'edit' ).'</a>';
      */

      $urlDeploy = 'index.php?c=Genf.Bdl.deploy&amp;objid='.urlencode($key);
      $linkDeploy = '<a title="Deploy the Project"  class="wcm wcm_req_ajax wgt_info" href="'.$urlDeploy.'">'
        .Wgt::icon('genf/deploy.png' , 'xsmall' , 'deploy' ).'</a>';

      $urlRefreshDb = 'index.php?c=Genf.Bdl.refreshDatabase&amp;objid='.urlencode($key);
      $linkRefreshDb = '<a title="Refresh the database"  class="wcm wcm_req_ajax wgt_info" href="'.$urlRefreshDb.'">'
        .Wgt::icon('daidalos/db_refresh.png' , 'xsmall' , 'sync db' ).'</a>';

      $urlSyncDb = 'index.php?c=Genf.Bdl.syncDatabase&amp;objid='.urlencode($key);
      $linkSyncDb = '<a title="Sync the database with the model"  class="wcm wcm_req_ajax wgt_info" href="'.$urlSyncDb.'">'
        .Wgt::icon('daidalos/db_sync.png' , 'xsmall' , 'sync db' ).'</a>';

      $urlPatchDb = 'index.php?c=Genf.Bdl.createDbPatch&amp;objid='.urlencode($key);
      $linkPatchDb = '<a title="Create an SQL Patch to alter the database"  class="wcm wcm_req_ajax wgt_info" href="'.$urlPatchDb.'" >'
        .Wgt::icon('genf/dump.png' , 'xsmall' , 'create alter patch' ).'</a>';

      $urlClean = 'index.php?c=Genf.Bdl.clean&amp;objid='.urlencode($key);
      $linkClean = '<a title="Projekt cleanen"  class="wcm wcm_req_ajax wgt_info" href="'.$urlClean.'">'
        .Wgt::icon('genf/clean.png' , 'xsmall' , 'clean' ).'</a>';

      $body .= '<td valign="top" >'.$row[0].'</td>'.NL;
      //$body .= '<td valign="top" >'.$row[1].'</td>'.NL;
      $body .= '<td valign="top" >'.$row[2].'</td>'.NL;
      $body .= '<td valign="top" align="center"  >'.$linkConf.' | '.$linkGenerate.$linkDeploy.' | '.$linkSyncDb.' '.$linkRefreshDb.' '.$linkPatchDb.' | '.$linkClean.'</td>'.NL;

      $body .= '</tr>'.NL;

      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;

    }// ENDE FOREACH

    $body .= "</tbody>".NL;
    //\ Generieren des Bodys

    $html ='<table id="table_'.$this->name.'" class="full" >'.NL;
    $html .= $head;
    $html .= $body;
    $html .= '</table>'.NL;

    return $html;

  }//end public function load */

 /**
   * Generieren einer Tabelle ohne Template
   *
   * @return string
   */
  public function build( )
  {

    $this->load();
    $this->html = $this->buildTable( ) ;

    return $this->html;

  } // end public function build */

} // end class WgtTableGenfBdl
