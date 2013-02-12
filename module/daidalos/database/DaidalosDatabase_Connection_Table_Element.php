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
class DaidalosDatabase_Connection_Table_Element
  extends WgtTable
{
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////



 /**
   * Generieren einer Tabelle ohne Template
   *
   * @param string $Class Der Datenbanktype
   * @return
   */
  public function build( )
  {


    // Creating the Head
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;

    $head .= '<th>Con Name</th>'.NL;
    $head .= '<th>Class</th>'.NL;
    $head .= '<th>Host</th>'.NL;
    $head .= '<th>Port</th>'.NL;
    $head .= '<th>Db Name</th>'.NL;
    $head .= '<th>Db Schema</th>'.NL;
    $head .= '<th>Db User</th>'.NL;
    $head .= '<th style="width:165px" >Nav</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    $num = 1;
    foreach( $this->data as $key => $row   )
    {
      $rowid = $this->name."_row_$key";

      $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

      $urlConf = 'index.php?c=Daidalos.Projects.genMask&amp;objid='.urlencode($key);
      $linkConf = '<a title="GenMask"  class="wcm wcm_req_ajax wgt_info" href="'.$urlConf.'">'
        .Wgt::icon('daidalos/bdl_mask.png' , 'xsmall' , 'build' ).'</a>';


      $body .= '<td valign="top" >'.$key.'</td>'.NL;
      $body .= '<td valign="top" >'.$row['class'].'</td>'.NL;
      $body .= '<td valign="top" >'.$row['dbhost'].'</td>'.NL;
      $body .= '<td valign="top" >'.$row['dbport'].'</td>'.NL;
      $body .= '<td valign="top" >'.$row['dbname'].'</td>'.NL;
      $body .= '<td valign="top" >'.(isset($row['dbschema'])?$row['dbschema']:'').'</td>'.NL;
      $body .= '<td valign="top" >'.$row['dbuser'].'</td>'.NL;
      $body .= '<td valign="top" align="center"  >'.$linkConf.'</td>'.NL;

      $body .= '</tr>'.NL;

      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;

    }// ENDE FOREACH

    $body .= "</tbody>".NL;
    //\ Generieren des Bodys


    $html ='<table id="table_'.$this->name.'" class="wgt-table" >'.NL;
    $html .= $head;
    $html .= $body;
    $html .= '</table>'.NL;

    return $html;

  }//end public function build */



} // end class DaidalosDatabase_Connection_Table_Element

