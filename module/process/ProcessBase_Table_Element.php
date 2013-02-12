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
class ProcessBase_Table_Element
  extends WgtTable
{

////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string $id
   */
  public $id       = 'wgt-table-process-base-history';

  /**
   * @var array
   */
  public $classes  = array( 'full' );

  /**
   * the most likley class of a given query object
   *
   * @var ProcesBase_Query
   */
  public $data       = null;

  /**
   *
   * @var array
   */
  public $url      = array
  (
    'paging'  => array
    (
      Wgt::ACTION_PAGING ,
      'index.php?c=Widget.UserTask.reload'
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
// context: table
////////////////////////////////////////////////////////////////////////////////

  /**
   * create the head for the table
   * @return string
   */
  public function buildThead( )
  {

    $this->numCols = 4;

    if($this->enableNav)
      ++ $this->numCols;

    // Creating the Head
    $html = '<thead>'.NL;
    $html .= '<tr>'.NL;
    $html .= '<th style="width:30px" >Pos.</th>'.NL;
    $html .= '<th style="width:230px" >User</th>'.NL;
    $html .= '<th style="width:70px" >Date</th>'.NL;
    $html .= '<th style="width:180px" >Step</th>'.NL;
    $html .= '<th>Comment</th>'.NL;
    $html .= '<th style="width:80px" >Rating</th>'.NL;

    // the default navigation col
    /*
    if( $this->enableNav )
      $html .= '<th style="width:70px;">'.$this->i18n->l( 'Nav.', 'wbf.label'  ).'</th>'.NL;
    */

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

    $body = '<tbody>'.NL;

    // simple switch method to create collored rows
    $pos = 1;
    $num = 1;
    foreach ($this->data as $key => $row) {

      $objid       = $row['rowid'];
      $rowid       = $this->id.'_row_'.$objid;

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" class="pos" >'.$pos.'</td>'.NL;
      $body .= '<td valign="top" >( '.$row['wbfsys_role_user_name'].' ) '.$row['core_person_lastname'].', '.$row['core_person_firstname'].' </td>'.NL;
      $body .= '<td valign="top" >'.(!is_null($row['m_time_created'])?$this->view->i18n->timestamp($row['m_time_created']):'').'</td>'.NL;
      $body .= '<td valign="top" >'.$row['node_from_name'].'<br /> =&gt; <br />'.$row['node_to_name'].'</td>'.NL;
      $body .= '<td valign="top" >'.Validator::sanitizeHtml( $row['comment'] ).'</td>'.NL;
      $body .= '<td valign="top" >'.$row['rate'].'</td>'.NL;

      $body .= '</tr>'.NL;

      $pos ++;
      $num ++;
      if ( $num > $this->numOfColors )
        $num = 1;

    } //end foreach

    $body .= '</tbody>'.NL;
    //\ Create the table body
    return $body;

  }//end public function buildTbody */

  /**
   * @return string
   */
  public function buildTableFooter()
  {

    $html = ' <div class="wgt-panel wgt-border-top" >';
    $html .= '</div>'.NL;

    return $html;

  }//end public function buildTableFooter */

}//end class UserProjectTask_Table
