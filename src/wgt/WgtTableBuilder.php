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
 * @subpackage tech_core
 */
class WgtTableBuilder extends WgtTable
{
/*//////////////////////////////////////////////////////////////////////////////
// Table Navigation
//////////////////////////////////////////////////////////////////////////////*/

  public $keyName = 'id';

  /**
   *
   * Enter description here ...
   * @var function
   */
  public $cbHead = null;

  /**
   *
   * Enter description here ...
   * @var function
   */
  public $cbBody = null;

  /**
   *
   * Enter description here ...
   * @var function
   */
  public $cbFoot = null;

  /**
   *
   * Enter description here ...
   * @var function
   */
  public $cbAction = null;

  /**
   * build the table
   * @return string
   */
  public function build( )
  {

    if ($this->html )
      return $this->html;

    if ($this->cbHead) {
      $cbHead = $this->cbHead;
      $head   = $cbHead($this );
    } else {
      $this->numCols = count($this->cols ) + 1 ;
      $keys = array_keys($this->cols );
      $head = $this->buildHead($keys );
    }

    if ($this->cbBody) {
      $cbBody = $this->cbBody;

      $body = '<tbody>'.NL;
      foreach ($this->data as $line => $row) {
        $body .= $cbBody($this, $line, $row );
      }
      $body .= '</tbody>'.NL;

    } else {
      $body = $this->buildBody($keys);
    }

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="wgt-table" >'.NL;

    $this->html .= $head;
    $this->html .= $body;

    if ($this->cbFoot) {
      $cbFoot = $this->cbFoot;
      $this->html .= $cbFoot($this );
    } else {
      $this->html .= $this->buildTableFooter();
    }

    $this->html .= '</table>';

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function build */

  /**
   *
   */
  public function buildHead($keys )
  {

    // Creating the Head
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;
    foreach($keys as $colName )
      $head .= '<th>'.$colName.'</th>'.NL;

    $head .= '<th style="width:70px;">'.$this->i18n->l( 'nav', 'wbf.text.tableNav'  ).'</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head
    return $head;

  }//end public function buildHead */

  /**
   *
   */
  public function buildBody($keys )
  {

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    if ($this->cbAction)
      $cbAction = $this->cbAction;
    else
      $cbAction = function($objid, $row) use ($this) {
        return $this->rowMenu($objid, $row );
      };

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;
    foreach ($this->data as $line => $row) {

      if ( isset($row[$this->keyName]) )
        $objid  = $row[$this->keyName];
      else
        $objid = $line;

      $rowid = $this->id.'_row_'.$objid;
      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;

      foreach($keys as $key )
        $body .= '<td>'.Validator::sanitizeHtml($row[$key] ).'</td>'.NL;

      $body .= '<td valign="top" style="text-align:center;" >'.$cbAction($objid ).'</td>'.NL;
      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } // ENDE FOREACH

    $body .= '</tbody>'.NL;
    //\ Create the table body
    return $body;

  }//end public function buildBody */

}//end class WgtTable

