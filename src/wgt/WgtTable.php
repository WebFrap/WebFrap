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
class WgtTable
  extends WgtList
{
////////////////////////////////////////////////////////////////////////////////
// Protected Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  protected $icon       = null;

  /**
   *
   * @var store the meta informations for the table
   */
  protected $metaInfo   = '';

  /**
   *
   * @var string
   */
  protected $searchUrl  = null;


  /**
   * flag if this table is editable
   * @var boolean
   */
  public $editAble      = false;

  /**
   * show multiselect row in the table
   * @var boolean
   */
  public $enableMultiSelect = false;

  /**
   * die höhe des bodies
   * @var string
   */
  public $bodyHeight    = null;

  /**
   * char flag, for a filter on a first char in a col
   * @var string
   */
  public $begin         = null;

  /**
   * the title of the table
   * @var string
   */
  public $title         = null;
  
  /**
   * Setzen eines Namespaces
   * @var string
   */
  public $namespace     = null;

  /**
   * Key zum errechnen des korrekten Search Formulars
   * @var string
   */
  public $searchKey     = null;

  /**
   * is there a advanced search
   * @var boolean
   */
  public $advancedSearch = false;

////////////////////////////////////////////////////////////////////////////////
// Magic methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param string $name the name of the wgt object
   * @param LibTemplate $view
   */
  public function __construct( $name = null, $view = null )
  {

    $this->name     = $name;
    $this->stepSize = Wgt::$defListSize;

    // when a view is given we asume that the element should be injected
    // directly to the view
    if( $view )
    {
      $this->view = $view;
      $this->i18n = $view->getI18n();
      
      if( $view->access )
        $this->access = $view->access;

      if( $name )
        $view->addElement( $name, $this );
    }
    else
    {
      $this->i18n     = I18n::getActive();
    }
    
    $this->loadUrl();

    if( DEBUG )
      Debug::console( "new element ".get_class( $this ) );

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $icon
   */
  public function setIcon( $icon )
  {
    $this->icon = $icon;
  }//end public function setIcon */

  /**
   * @param string $title
   */
  public function setTitle( $title )
  {
    $this->title = $title;
  }//end public function setTitle */

  /**
   * @param string $key
   */
  public function setSearchKey( $key )
  {
    $this->searchKey = $key;
  }//end public function setSearchKey */
  
  /**
   * @param string $namespace
   */
  public function setNamespace( $namespace )
  {
    $this->namespace = $namespace;
  }//end public function setNamespace */

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
      $baseUrl = $linkTarget .= '&amp;target_id='.$this->id.'&amp;start=';
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

    $class = $ajax
      ? 'class="wcm wcm_req_page '.$this->searchForm.'"'
      : '';

    $html = '<a '.$class.' title="'.$this->i18n->l('Back to Start','wbf.label').'" href="'.$baseUrl.'0">
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/toStart.png"
            style="border:0px"
            alt="'.$this->i18n->l('Back to start','wbf.label').'" />
      </a>&nbsp;&nbsp;';

    $html .= '<a '.$class.' title="'.$this->i18n->l
      (
        '{@X@} Entries back',
        'wbf.label',
        array( 'X' => $this->stepSize )
      )
      .'" href="'.$baseUrl.($oneZurueck * $this->stepSize).'">
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/back.png"
            style="border:0px"
            alt="'.$this->i18n->l
        (
          '{@X@} Entries back',
          'wbf.label',
          array
          (
            'X'=>$this->stepSize
          )
        ).'" />
        </a>&nbsp;&nbsp;';

    // add the entries in the middle
    for ( $nam = $startPos; $nam < $endPos ; ++$nam )
    {

      if($ajax)
      {
        $urlClass = ($nam == $activPos)
          ? 'class="ui-state-active wcm wcm_req_page '.$this->searchForm.'"'
          : 'class="wcm wcm_req_page '.$this->searchForm.'"';
      }
      else
      {
        $urlClass = ($nam == $activPos)
          ? 'class="ui-state-active"'
          : '';
      }

      $title = $this->i18n->l
      (
        'Show the next {@Y@} {@X@} Entires',
        'wbf.label',
        array
        (
          'Y' => $nam,
          'X' => $this->stepSize
        )
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
        'Show the Last {@X@} Entries',
        'wbf.label',
        array('X'=>$this->stepSize)
      );


      $html .='<a '.$class.'
        title="'.$title.'"
        href="'.$baseUrl.($last * $this->stepSize).'" >'.($last+1).'</a>&nbsp;&nbsp;' ;
    }

    $title = $this->i18n->l
    (
      'Show the next {@X@} Entries',
      'wbf.label',
      array('X'=>$this->stepSize)
    );
    $html .= '<a '.$class.' title="'.$title.'"
      href="'.$baseUrl.($oneVor * $this->stepSize).'" >
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/forward.png"
            style="border:0px"
            alt="'.$title.'" /></a>&nbsp;&nbsp;';

    $html .= '<a '.$class.' title="'.$this->i18n->l('Go to the Last Entry','wbf.label').'"
      href="'.$baseUrl.($last * $this->stepSize).'" >
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/toEnd.png"
            style="border:0px"
            alt="'.$this->i18n->l('Go to the last entry','wbf.label').'" /></a>';

    return $html;

  } // end public function pagingMenu */

  /**
   * @return string
   */
  public function menuNumEntries()
  {

    ///@todo extend this
    //wcm wcm_req_page '.$this->searchForm
    // $S(\'form#'.$this->searchForm.'\').data(\'size\',$S(this).val());

    //$onchange = 'onchange="$S(\'form#'.$this->searchForm.'\').data(\'qsize\',$S(this).val());$R.form(\''.$this->searchForm.'\');"';
    $onchange = 'onchange="$S(\'table#'.$this->id.'-table\').grid( \'pageSize\', \''.$this->searchForm.'\',this)"';

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
   * @return string
   */
  public function menuTableSize()
  {

    ///@todo extend this
    return '<span>found <strong class="wgt-num-entry" >'
      .$this->dataSize.'</strong> '
      .$this->i18n->l('Entries','wbf.label')
      .'</span>';

  }//end public function menuNumEntries */

  /**
   * @return string
   */
  public function menuCharFilter()
  {

    $class  = 'wcm wcm_req_page '.$this->searchForm.'';

    $html   = '<span class="wgt_char_filter" >';
    $html   .= '<a class="'.$class.'" href="c=?" > ? </a> | ';

    $charVal = 65;

    while ( $charVal < 91 )
    {
      $aktiv = '';

      $char = chr($charVal);

      if( $this->begin == $char )
        $aktiv = ' ui-state-active';

      $html .= '<a class="'.$class.$aktiv.'" href="b='.$char.'" > '.$char.' </a> | ';
      ++ $charVal;
    }

    $html .= '<a class="'.$class.'" href="b=" > '.Wgt::icon('control/cancel.png','xsmall','clear').' </a>';
    $html .= '</span>';

    return $html;

  }//end public function menuCharFilter */

  /**
   *
   */
  public function tableFootLeft()
  {

    //return $this->menuFootActions();

  }//end public function tableFootLeft */

  /**
   * @return string
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
        'onclick' =>  "\$R.form('{$this->searchForm}','&amp;export=excel',{append:true,ajax:false} )"
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
        'onclick' =>  "\$R.form('{$this->searchForm}','&amp;export=xml',{append:true,ajax:false} )"
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
        'onclick' =>  "\$R.form('{$this->searchForm}','&amp;export=csv',{append:true,ajax:false} )"
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
        'onclick' =>  "\$R.form('{$this->searchForm}','&amp;export=json',{append:true,ajax:false} )"
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
        'onclick' =>  '$S(\'table#'.$this->id.'-table\').grid(\'cleanFilter\');'
      )
    );


    return $html;

  }//end public function tableFootLeft */

   /**
   *
   */
  public function tableSubFootRight()
  {

    return $this->menuNumEntries();

  }//end public function tableFootLeft */

  /**
   *
   */
  public function tableSubFootLeft()
  {

    return $this->menuTableSize();

  }//end public function tableFootLeft */

  /**
   * @return string
   */
  public function tableFootRight()
  {

    return '';

  }//end public function tableFootRight */

  /**
   * @return string
   */
  public function buildTableFooter()
  {

    $html = ' <div class="wgt-panel wgt-border-top" >';
    $html .= '  <div class="right menu"  >';
    $html .=      $this->menuTableSize();
    $html .= '  </div>';
    $html .= '  <div class="menu"  style="text-align:center;margin:0px auto;" >';
    $html .=      $this->menuCharFilter( );
    $html .= '  </div>';
    $html .= $this->metaInformations();
    $html .= '</div>'.NL;

    return $html;

  }//end public function buildTableFooter */


  /**
   * @return string
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
    {
      $this->html .= '<div id="'.$this->id.'" class="wgt-border" >'.NL;
      $this->html .= $this->buildPanel();


      $classes = implode( ' ', $this->classes );

      $this->html .= '<table id="'.$this->id.'-table" class="wgt-table '.$classes.'" >'.NL;
      $this->html .= $this->buildThead();
    }

    $this->html .= $this->buildTbody();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if( $this->insertMode )
    {
      $this->html .= '</table>';
      $this->html .= $this->buildTableFooter();
      $this->html .= '</div>'.NL;

      $this->html .= '<script type="application/javascript" >'.NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>'.NL;
    }

    return $this->html;

  }//end public function buildHtml */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    $this->refresh = true;

    if($this->xml)
      return $this->xml;

    if( $this->appendMode )
    {
      $html = '<htmlArea selector="#'.$this->id.'-table>tbody" action="append" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>'.NL;
    }
    else
    {
      $html = '<htmlArea selector="#'.$this->id.'-table>tbody" action="replace" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>'.NL;
    }

    $this->xml = $html;

    return $html;

  }//end public function buildAjaxArea */

  /**
   * @return string
   */
  public function buildPanel()
  {

    if( !$this->panel )
      return '';

    return $this->panel->build();

  }//end public function buildPanel */


  /**
   * build the table
   *
   * @return string
   */
  public function buildCli( )
  {

    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if( $this->html )
      return $this->html;

    $line = "--------------------------------------------------------------------------------".NL;


    $this->html = $line;

    if( !$this->data )
    {
      $this->html = '| No data ';
    }



    return $this->html;

  }//end public function buildCli */


}//end class WgtTable

