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
abstract class WgtBlocklist
  extends WgtList
{


  public function build(){ return $this->html; }


  /**
   *
   * @param $id
   * @param $row
   * @return string
   */
  protected function buildActions( $id  , $row = array() )
  {

    $html = '';

    foreach( $this->actions as $action  )
    {

      if( isset( $this->url[$action] ) )
      {
        $data = $this->url[$action];

        if(  $data[0] == Wgt::ACTION_AJAX_GET )
        {
          $html .= Wgt::urlTag
          (
            $data[2].$id.'&amp;target_id='.$this->id,
            Wgt::icon( $data[3] ,'medium', $data[1] ),
            array
            (
              'class'=> $data[4],
              'title'=> I18n::s($data[1],$data[5])
            )
          ).'<br />';
        }
        else if(  $data[0] == Wgt::ACTION_CHECKBOX )
        {
          $html .= '<input class="wgt-no-save" value="'.$id.'" /><br />';
        }
        else
        {
          $html .= '<span onclick="'.$data[2]."('".$id."');".'" class="'.$data[4].'" title="'.I18n::s($data[1],$data[5]).'" >'.
            Wgt::icon( $data[3] ,'medium', $data[1] ).'</span><br />';
        }

      }

    }

    return $html;

  }//end protected function buildActions */


  /**
   *
   * @param string  $linkTarget
   * @param boolean $ajax
   * @return string
   */
  public function pagingMenu( $linkTarget, $ajax = true )
  {

    if( $this->dataSize <= $this->stepSize )
      return '';

    if( $ajax )
    {
      $baseUrl = 'p=';
    }
    else
    {
      $baseUrl = $linkTarget .= '&amp;target_id='.$this->id.'&start=';
    }


    $activPos = $this->start;

    // calculate the activ position
    $activPos = floor($activPos / $this->stepSize);
    $startPos = $activPos - floor( $this->anzMenuNumbers / 2 );

    // start can not be smaller than 0
    if( $startPos < 0 )
      $startPos = 0;

    $endPos = $startPos + $this->anzMenuNumbers;

    $last = floor( $this->dataSize / $this->stepSize );

    if( $activPos >  $last )
      $activPos = $last;

    if( $endPos >  $last )
      $endPos = $last + 1;

    $oneVor     = $activPos + 1;
    $oneZurueck = $activPos - 1;

    if( $oneVor > $last )
      $oneVor = $last;

    if( $oneZurueck < $startPos )
      $oneZurueck = $startPos;

    $class = $ajax?'class="wcm wcm_req_page '.$this->searchForm.'"':'';

    $html = '<a '.$class.' title="'.$this->i18n->l('Back to start','wbf.table.back_to_start').'" href="'.$baseUrl.'0">
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/toStart.png"
            style="border:0px"
            alt="'.$this->i18n->l('Back to start','wbf.table.back_to_start').'" />
      </a>&nbsp;&nbsp;';

    $html .= '<a '.$class.' title="'.$this->i18n->l($this->stepSize.' entries back','wbf.table.x_entries_back')
      .'" href="'.$baseUrl.($oneZurueck * $this->stepSize).'">
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/back.png"
            style="border:0px"
            alt="'.$this->i18n->l($this->stepSize.' entries back','wbf.table.x_entries_back').'" />
      </a>&nbsp;&nbsp;';

    // add the entries in the middle
    for ( $nam = $startPos; $nam < $endPos ; ++$nam )
    {

      if($ajax)
      {
        $urlClass = ($nam == $activPos)
          ? 'class="wgt_activ wcm wcm_req_page '.$this->searchForm.'"'
          :'class="wcm wcm_req_page '.$this->searchForm.'"';
      }
      else
      {
        $urlClass = ($nam == $activPos) ? 'class="wgt_activ"':'';
      }

      $title = $this->i18n->l
      (
        'show the nex '.$nam.' '.$this->stepSize.' entires',
        'wbf.table.show_next_x_entries',
        array($nam,$this->stepSize)
      );

      $html .='<a '.$urlClass.' title="'.$title.'"
        href="'.$baseUrl.($nam * $this->stepSize).'">'.($nam+1).'</a>&nbsp;&nbsp;' ;

      $urlClass ='';
    }

    // check if it's neccesary to show the end
    if( $last > $this->anzMenuNumbers )
    {
      $html .= '&nbsp;...&nbsp;&nbsp;';

      $title = $this->i18n->l
      (
        'show the last '.$this->stepSize.' entries',
        'wbf.table.show_last_x_entries',
        array($this->stepSize)
      );


      $html .='<a '.$class.' title="'.$title.'"
        href="'.$baseUrl.($last * $this->stepSize).'" >'.($last+1).'</a>&nbsp;&nbsp;' ;
    }

    $title = $this->i18n->l
    (
      'show the next '.$this->stepSize.' entries',
      'wbf.table.show_next_x_entries',
      array($this->stepSize)
    );
    $html .= '<a '.$class.' title="'.$title.'"
      href="'.$baseUrl.($oneVor * $this->stepSize).'" >
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/forward.png"
            style="border:0px"
            alt="'.$title.'" /></a>&nbsp;&nbsp;';

    $html .= '<a '.$class.' title="'.$this->i18n->l('go to the last entry','wbf.table.last_entries').'"
      href="'.$baseUrl.($last * $this->stepSize).'" >
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/toEnd.png"
            style="border:0px"
            alt="'.$this->i18n->l('go to the last entry','wbf.table.last_entries').'" /></a>';

    return $html;

  } // end public function pagingMenu */

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

    foreach( $sizes as $size )
    {
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

    while ( $char < 'Z' )
    {
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

    return $this->menuFootActions();

  }//end public function footerLeft */

  /**
   *
   */
  public function menuFootActions()
  {

    ///@todo extend this

    $html = Wgt::icon
    (
      'control/refresh.png',
      'xsmall',
      array
      (
        'alt'     =>  'refresh',
        'title'   =>  'refresh the table',
        'onclick' =>  '$R.form(\''.$this->searchForm.'\')'
      )
    );

    $html .= ' &nbsp;&nbsp;|&nbsp;&nbsp;';

    $html .= Wgt::icon
    (
      'mimetype/excel.png',
      'xsmall',
      array
      (
        'alt'     =>  'export excel',
        'title'   =>  'export all datasets as excel',
        'onclick' =>  "\$R.form('{$this->searchForm}','&export=excel',{append:true,ajax:false} )"
      )
    );
    $html .= Wgt::icon
    (
      'mimetype/xml.png',
      'xsmall',
      array
      (
        'alt'     =>  'export xml',
        'title'   =>  'export all datasets as xml',
        'onclick' =>  "\$R.form('{$this->searchForm}','&export=xml',{append:true,ajax:false} )"
      )
    );
    /*
    $html .= Wgt::icon
    (
      'mimetype/csv.png',
      'xsmall',
      array
      (
        'alt'   =>  'export csv',
        'title' =>  'export all datasets as csv',
        'onclick' =>  "\$R.form('{$this->searchForm}','&export=csv',{append:true,ajax:false} )"
      )
    );

    $html .= Wgt::icon
    (
      'mimetype/json.png',
      'xsmall',
      array
      (
        'alt'   =>  'export json',
        'title' =>  'export all datasets as json',
        'onclick' =>  "\$R.form('{$this->searchForm}','&export=json',{append:true,ajax:false} )"
      )
    );
    */

    $html .=' &nbsp;&nbsp;|&nbsp;&nbsp;';

    $html .= Wgt::icon
    (
      'control/cancel.png',
      'xsmall',
      array
      (
        'alt'     =>  'cancel',
        'title'   =>  'cancel all filters',
        'onclick' =>  '$S(\'table#'.$this->id.'_table\').grid(\'cleanFilter\');'
      )
    );


    return $html;

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
    $html .= '    <div class="menu" style="float:left;" style="width:100px;" >';
    $html .=        $this->footerLeft();
    $html .= '    </div>';
    $html .= '    <div class="menu"  style="text-align:center;margin:0px auto;width:350px;" >';
    $html .=        $this->pagingMenu( $this->url['paging'][1]  );
    $html .= '    </div>';
    $html .= '  </div>';
    $html .= '  <div class="full"  >';
    $html .= '    <div class="right menu"  >';
    $html .=        $this->subFooterRight();
    $html .= '    </div>';
    $html .= '    <div class="menu" style="float:left;" style="width:100px;" >';
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

