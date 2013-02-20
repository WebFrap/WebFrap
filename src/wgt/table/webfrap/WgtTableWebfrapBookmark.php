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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WgtTableWebfrapBookmark extends WgtTable
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the id of the table
   *
   * @var string $id
   */
  public $id       = 'wgt-table_webfrap_bookmark';

  /**
  *
  * @var string $imgIcon
  */
  public $imgIcon  = 'wbfsys/bookmark.png';

  /**
   * List with all URLS
   * @var array
   */
  public $url = array
  (
    'paging'  => array
    (
      Wgt::ACTION_PAGING ,
      'index.php?c=Wbfsys.Bookmark.search'
    ),
    'edit'    => array
    (
      Wgt::ACTION_AJAX_GET,
      'edit',
      'index.php?c=Wbfsys.Bookmark.edit&amp;objid=',
      'control/edit.png',
      'wcm wcm_req_ajax',
      'wbfsys.bookmark.label.tableTitleEdit'
    ),
    'delete'  => array
    (
      Wgt::ACTION_AJAX_GET,
      'delete',
      'index.php?c=Wbfsys.Bookmark.delete&amp;objid=',
      'control/delete.png',
      'wcm wcm_req_del',
      'wbfsys.bookmark.label.tableTitleDelete'
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// buildr methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the table
   *
   * @return String
   */
  public function build( )
  {

    if ($this->html )
      return $this->html;

    $this->numCols = 2;

    // Creating the Head
    $head = '<thead>'.NL;
    $head .= '<tr>'.NL;
    $head .= '<th>'.I18n::s( 'title', 'wbf.text.tableNav'  ).'</th>'.NL;
    $head .= '<th>'.I18n::s( 'bookmark', 'wbf.text.tableNav'  ).'</th>'.NL;
    $head .= '<th style="width:70px;">'.I18n::s( 'nav', 'wbf.text.tableNav'  ).'</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;
    foreach ($this->data as $key => $row) {

      $objid  = $row['wbfsys_bookmark_'.Db::PK];

      $rowid = $this->id.'_row_'.$objid;
      $navigation = $this->rowMenu($objid, $row );

      $url = urldecode($row['wbfsys_bookmark_url']);

      $body .= '<tr class="row'.$num.'" id="'.$rowid.'" >'.NL;
      $body .= '<td valign="top" >'.$row['wbfsys_bookmark_title'].'</td>'.NL;
      $body .= '<td valign="top" ><a href="'.$url.'" class="wcm wcm_req_ajax" >'.$url.'</a></td>'.NL;
      $body .= '<td valign="top" style="text-align:center;" >'.$navigation.'</td>'.NL;
      $body .= '</tr>'.NL;

      $num ++;
      if ($num > $this->numOfColors )
        $num = 1;

    } // ENDE FOREACH

    $body .= '</tbody>'.NL;
    //\ Create the table body

    if (!$this->replace )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="wgt-table" >'.NL;

    $this->html .= $head;
    $this->html .= $body;

    $this->html .= '<tfoot class="ui-widget-footer" >'.NL;
    $this->html .= '<tr><td colspan="'.$this->numCols.'" >'.NL;
    $this->html .= $this->pagingMenu($this->url['paging'][1]  );
    $this->html .= '</td></tr>'.NL;
    $this->html .= '</tfoot>'.NL;

    $this->html .= '</table>';

    if (!$this->replace) {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function build */

  /**
   * build the table
   *
   * @return String
   */
  public function buildAjaxRows( )
  {

    if ($this->html )
      return $this->html;

    $body = '';

    foreach ($this->data as $key => $row) {

      $objid = $row['wbfsys_bookmark_'.Db::PK];

      $rowid       = $this->id.'_row_'.$objid;
      $navigation  = $this->rowMenu($objid, $row );

      if ($this->ajaxInsert )
        $body .= '<htmlArea selector="table#'.$this->id.'_table>tbody" action="append" ><![CDATA[<tr id="'.$rowid.'" >'.NL;
      else
        $body .= '<htmlArea selector="tr#'.$rowid.'" action="html" ><![CDATA[';

      $body .= '<td valign="top" class="ignore" style="text-align:center;" ><img class="icon xsmall cursor_icon" src="'.View::$iconsWeb.'xsmall/'.$this->imgIcon.'" /></td>'.NL;

      $body .= '<td valign="top" class="ignore" style="text-align:center;" >'.$navigation.'</td>'.NL;

      if ($this->ajaxInsert )
        $body .= '</tr>]]></htmlArea>'.NL;
      else
        $body .= ']]></htmlArea>'.NL;

    }//end foreach

    $this->html = $body;

    return $this->html;

  }//end public function buildAjaxRows */

}//end class WgtTableWbfsysBookmarkGenf

