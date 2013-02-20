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
 * @subpackage Build
 */
class WgtTableBuild extends WgtTable
{
/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

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
    foreach($files as $file )
      if ( substr($file, -3 , strlen($file) ) == "xml" )
        $this->data[] = $file;
    */

    $data = array();

    include PATH_GW.'conf/map/build/projects.php';

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
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;

    $head .= '<th>Project Name</th>'.NL;
    //$head .= '<th>File</th>'.NL;
    $head .= '<th>Description</th>'.NL;
    $head .= '<th style="width:140px" >Nav</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    $num = 1;
    foreach ($this->data as $key => $row) {
      $rowid = $this->name."_row_$key";

      $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

      $urlGenerate = 'index.php?c=Build.Base.build&amp;objid='.urlencode($key);
      $linkGenerate = '<a title="Projekt bauen"  class="wcm wcm_req_ajax wgt_info" href="'.$urlGenerate.'">'
        .Wgt::icon('daidalos/buildr.png' , 'xsmall' , 'build' ).'</a>';

      $body .= '<td valign="top" >'.$row[0].'</td>'.NL;
      //$body .= '<td valign="top" >'.$row[1].'</td>'.NL;
      $body .= '<td valign="top" >'.$row[2].'</td>'.NL;
      $body .= '<td valign="top" align="center" >'.$linkGenerate.'</td>'.NL;

      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    }// ENDE FOREACH

    $body .= "</tbody>".NL;
    //\ Generieren des Bodys

    $html ='<table id="table_'.$this->name.'" class="wgt-table" >'.NL;
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

} // end class WgtTableBuild

