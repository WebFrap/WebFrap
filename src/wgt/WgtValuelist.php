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
class WgtValuelist
  extends WgtList
{
////////////////////////////////////////////////////////////////////////////////
// Protected Attributes
////////////////////////////////////////////////////////////////////////////////


  /**
   *
   * @var store the meta informations for the table
   */
  protected $metaInfo   = '';


  /**
   * show multiselect row in the table
   * @var boolean
   */
  public $enableMultiSelect = false;

  /**
   * show multiselect row in the table
   * @var boolean
   */
  public $bodyHeight = null;


////////////////////////////////////////////////////////////////////////////////
// Magic methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param string $name the name of the wgt object
   */
  public function __construct( $name = null )
  {

    $this->name     = $name;
    $this->stepSize = Wgt::$defListSize;

    //
    $this->i18n     = I18n::getDefault();

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * generieren des Menüs
   * @param $id
   * @param $row
   * @return string
   */
  public function rowMenu( $id , $row = array()  )
  {
    return $this->buildActions( $id  , $row );
  }//end public function rowMenu */



////////////////////////////////////////////////////////////////////////////////
// Table Navigation
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the table
   *
   * @return string
   */
  public function build( )
  {

    if( !$this->html )
      $this->html = '<p>empty</p>';

    return $this->html;

  }//end public function build */

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
            Wgt::icon( $data[3] ,'xsmall', $data[1] ),
            array(
              'class'=> $data[4],
              'title'=> I18n::s($data[1],$data[5])
            )
          );
        }
        else if(  $data[0] == Wgt::ACTION_JS )
        {
          $html .= WgtRndForm::fakeButton
          (
            Wgt::icon( $data[3] ,'xsmall', $data[1] ).' '.$data[1],
            $data[2].$id.'&amp;target_id='.$this->id,
            array
            (
              'class'=> $data[4],
              'title'=> I18n::s($data[1],$data[5])
            )
          );
        }
        else if(  $data[0] == Wgt::ACTION_CHECKBOX )
        {
          $html .= '<input class="wgt-no-save" value="'.$id.'" />';
        }
        else
        {
          $html .= '<span onclick="'.$data[2]."('".$id."');".'" class="'.$data[4].'" title="'.I18n::s($data[1],$data[5]).'" >'.
            Wgt::icon( $data[3] ,'xsmall', $data[1] ).'</span>';
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
    $onchange = 'onchange="$S(\'table#'.$this->id.'_table\').grid( \'pageSize\', \''.$this->searchForm.'\',this)"';

    if(!$sizes=Conf::status('ui.listing.numEntries'))
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
  public function menuTableSize()
  {

    ///@todo extend this
    return '<span>found <strong class="wgt-num-entry" >'.$this->dataSize.'</strong> entries</span>';

  }//end public function menuNumEntries */

  /**
   *
   */
  public function menuCharFilter()
  {

    $class  = 'wcm wcm_req_page '.$this->searchForm.'';

    $html   = '<span class="wgt_char_filter" >';
    $html   .= '<a '.$class.' href="c=?" > ? </a> | ';

    $char = 'A';

    while ( $char <= 'Z' )
    {
      $aktiv = '';

      if( $this->begin == $char )
        $aktiv = ' wgt_activ';

      $html .= '<a class="'.$class.$aktiv.'" href="b='.$char.'" > '.$char.' </a> | ';
      ++ $char;
    }

    $html .= '<a class="'.$class.'" href="b=" > '.Wgt::icon('control/cancel.png','xsmall','clear').' </a>';
    $html .= '</span>';

    return $html;

  }//end public function menuCharFilter */





  /**
   *
   */
  public function metaInformations()
  {
    return $this->metaInfo;
  }//end public function metaInformations */


  /**
   * build the table
   *
   * @return string
   */
  public function buildHtml( )
  {

    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if( $this->html )
      return $this->html;

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<ul id="'.$this->id.'_table" class="wgt_valuelist" >'.NL;

    $this->html .= $this->buildbody();

    $this->html .= '</ul>';

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="text/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;

    }

    return $this->html;

  }//end public function buildHtml */


}//end class WgtTable

