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
 * @subpackage wgt
 */
abstract class WgtBlocklist extends WgtList
{

  public function build(){ return $this->html; }

  /**
   *
   */
  public function menuNumEntries()
  {

    ///@todo extend this
    //wcm wcm_req_page '.$this->searchForm
    // $S(\'form#'.$this->searchForm.'\').data(\'size\',$S(this).val());

    //$onchange = 'onchange="$S(\'form#'.$this->searchForm.'\').data(\'qsize\',$S(this).val());$R.form(\''.$this->searchForm.'\');"';
    $onchange = 'onchange="$S(\'table#'.$this->id.'_table\').grid( \'pageSize\', \''.$this->searchForm.'\' )"';


    $sizes = array(10,25,50,100,250,500);

    $menu = '<select class="wgt-no-save small" '.$onchange.' >';

    foreach ($sizes as $size) {
      $selected = ($size==$this->stepSize)?'selected="selected"':'';
      $menu .= '<option value="'.$size.'" '.$selected.' >'.$size.'</option>';
    }

    $menu .= '</select>';

    return $menu;

  }//end public function menuNumEntries */

  /**
   *
   */
  public function menuDisplaySize()
  {

    ///@todo extend this
    return '<span>found <strong>'.$this->dataSize.'</strong> entries</span>';

  }//end public function menuNumEntries */

  /**
   *
   */
  public function menuCharFilter()
  {

    $class  = 'class="wcm wcm_req_page '.$this->searchForm.'"';

    $html   = '<span class="wgt_char_filter" >';
    $html   .= '<a '.$class.' href="c=?" > ? </a> | ';

    $char = 'A';

    while ($char < 'Z') {
      $html .= '<a '.$class.' href="b='.$char.'" > '.$char.' </a> | ';
      ++ $char;
    }

    $html .= '<a '.$class.' href="b=" > '.Wgt::icon('control/cancel.png','xsmall','clear').' </a>';
    $html .= '</span>';

    return $html;

  }//end public function menuCharFilter */

  /**
   *
   */
  public function footerLeft()
  {


  }//end public function footerLeft */


   /**
   *
   */
  public function subFooterRight()
  {
    return $this->menuNumEntries();

  }//end public function footerLeft */

  /**
   *
   */
  public function subFooterLeft()
  {
    return $this->menuDisplaySize();

  }//end public function footerLeft */

  /**
   *
   */
  public function footerRight()
  {
    return '';

  }//end public function footerRight */

  /**
   *
   */
  public function buildTableFooter()
  {

    $html = '<li class="wgt_footer" >'.NL;
    $html .= '  <div class="full" >';
    $html .= '    <div class="right menu"  >';
    $html .=        $this->footerRight();
    $html .= '    </div>';
    $html .= '    <div class="menu" style="float:left;width:100px;" >';
    $html .=        $this->footerLeft();
    $html .= '    </div>';
    $html .= '    <div class="menu"  style="text-align:center;margin:0px auto;width:350px;" >';
    $html .=        $this->pagingMenu($this->url['paging'][1]  );
    $html .= '    </div>';
    $html .= '  </div>';
    $html .= '  <div class="full"  >';
    $html .= '    <div class="right menu"  >';
    $html .=        $this->subFooterRight();
    $html .= '    </div>';
    $html .= '    <div class="menu" style="float:left;width:100px;" >';
    $html .=        $this->subFooterLeft();
    $html .= '    </div>';
    $html .= '    <div class="menu"  style="text-align:center;margin:0px auto;" >';
    $html .=        $this->menuCharFilter( );
    $html .= '    </div>';
    $html .= '  </div>';
    $html .= '</li>'.NL;

    return $html;

  }//end public function buildTableFooter */

}//end class WgtBlocklist

