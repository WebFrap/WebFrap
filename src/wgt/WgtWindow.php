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
 * class WgtItemAbstract
 * Abstraktes View Objekt als Vorlage für alle ViewObjekte
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtWindow
  extends LibTemplatePublisher
{
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////


/*
<window resizable="resizable" movable="movable" id="wgt_window_FormEnterpriseCompany" planet="" >

  <dimensions width="760" height="390" min-width="760" min-height="100"/>
    <title>Create: Enterprise Company</title>
    <subtitle>Fujijama</subtitle>

    <buttons>
        <!-- <button text="Save" class="save"/>  -->
        <!--
        <button text="Publish" class="next"/>
        <button text="Retire">
          <action>
                <![CDATA[
      return function(){
        //self == Current window

      }
      ]]>
            </action>
        </button>-->
    </buttons>

    <content><![CDATA[ hans wurst ]]></content>
    <script><![CDATA[ ]]></script>
</window>
 */

  /**
   * Die ID des Fensters
   *
   * @var int
   */
  public $id       = null ;

  /**
   * Die minimal mögliche Weite
   * @var int
   */
  public $minWidth = 300 ;

  /**
   * Die minimal mögliche Höhe
   * @var int
   */
  public $minHeight= 200 ;

  /**
   * Die Breite mit der das Fenster im Browser geöffnet wird
   * @var int
   */
  public $width    = 300;

  /**
   * Die Höhe mit der das Fenster im Browser geöffnet wird
   * @var int
   */
  public $height   = 200 ;

  /**
   *
   * @var boolean
   */
  public $resizable = true;

  /**
   *
   * @var boolean
   */
  public $movable   = true;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $closable = true ;

  /**
   *
   * @var string
   */
  public $type         = 'window';

  /**
   *
   * @var string
   */
  public $planet    = null;

  /**
   *
   * @var string
   */
  public $subtitle  = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  public $statusBar = null;

  /**
   *
   * @var boolean $editable
   */
  public $editAble  = true;

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $buttons   = array();

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $bookmark  = null;

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $events    = array();


  /**
   * Variable zum anhängen von Javascript Code
   * Aller Inline JS Code sollte am Ende der Html Datei stehen
   * Also sollte der Code nicht direkt in den Templates stehen sondern
   * in die View geschrieben werden können, so dass das Templatesystem den Code
   * am Ende der Seite einfach anhängen kann
   * @var string
   */
  protected $jsCode       = array();

  /**
   *
   * @var string
   */
  protected $assembledJsCode = null;


  /**
   * @var array
   */
  protected $jsItems       = array();
  
  /**
   * Suche
   * @var WgtPanelElementSearch
   */
  public $searchElement  = null;
  
  /**
   * Suche
   * @var WgtPanelElementFilter
   */
  public $filterElement  = null;

////////////////////////////////////////////////////////////////////////////////
// Constructors and Magic Functions
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $name, $env = null )
  {

    $this->name = $name;

    $this->var         = new TDataObject();
    $this->object      = new TDataObject();
    $this->url         = new TDataObject();
    $this->funcs       = new TTrait();
    
    if( $env )
      $this->env = $env;
    else
      $this->env = Webfrap::getActive();
    
    // overwriteable empty init method
    $this->init();

  }//end public function __construct */

  /**
   * the to string method
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }// end public function __toString */

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * get the id of the wgt object
   *
   */
  public function getId()
  {
    if( !is_null( $this->id ) )
      return $this->id;
    else
      return 'wgt_window_'.uniqid();
  }//end public function getId */
  
  /**
   * setzen des HTML Titels
   * @param string $title Titel Der in der HTML Seite zu zeigende Titel
   * @param int $size
   * @param string $append
   * @return void
   */
  public function setTitle( $title, $size = 100, $append = '...' )
  {
    $this->title = SParserString::shortLabel( $title, $size, $append );
  } // end public function setTitle */

  /**
   * @param string $subtitle
   * @param int $size
   * @param string $append
   */
  public function setSubtitle( $subtitle, $size = 100, $append = '...' )
  {
    $this->subtitle = SParserString::shortLabel( $subtitle, $size, $append );
  }//end public function setSubtitle */

  /**
   * @param string $status
   * @param int $size
   * @param string $append
   */
  public function setStatus( $status, $size = 100, $append = '...' )
  {
    $this->statusBar = SParserString::shortLabel( $status, $size, $append );
  }//end public function setStatus */

  /**
   *
   * @param string $name
   * @param string $button
   * @return void
   */
  public function addButton( $button )
  {
    $this->buttons[$button->name] = $button;
    return $button;
  }//end public function addButton */

  /**
   *
   * @param string $name
   * @param string $button
   * @return void
   */
  public function newButton( $name, $type = null )
  {

    $button       = new WgtButton;
    $button->name = $name;

    $this->buttons[$button->name] = $button;
    return $button;

  }//end public function newButton */

  /**
   *
   * @param string $name
   * @param string $button
   * @return void
   */
  public function newMenu( $name, $type = null )
  {

    if( $type )
    {

      $className  = ucfirst($type).'_Subwindow_Menu';
      $classNameOld  = 'WgtMenuWindow'.ucfirst($type);

      if( !Webfrap::classLoadable($className) )
      {
        $className = $classNameOld;
        if( !Webfrap::classLoadable($className) )
        {
          throw new LibTemplate_Exception('requested nonexisting menu '.$type);
        }
      }

      $button     = new $className( $this );
    }
    else
    {
      $button     = new WgtDropmenu( $this );
    }

    $button->name = $name;

    $this->buttons[$button->name] = $button;
    return $button;

  }//end public function newMenu */

  /**
   *
   * @param string $name
   * @param string $button
   * @return void
   */
  public function setBookmark(  $title, $url, $role = null )
  {

    $this->bookmark = array
    (
      'title'   => $title,
      'url'     => $url,
      'role'    => $role,
    );

  }//end public function setBookmark */

  /**
   * 
   * Enter description here ...
   * @param string $type
   * @param unknown_type $name
   * @param unknown_type $code
   */
  public function addEvent( $type, $name, $code )
  {
    //'onclose' , 'refreshSelectbox' , \$onClose

    if(!isset($this->events))
      $this->events[$type] = array();

    $this->events[$type][$name] = $code;

  }


  /**
  * @param string/array $key
  */
  public function addJsItem( $key  )
  {

    if( is_array($key) )
    {
      $this->jsItems     = array_merge( $this->jsItems, $key );
    }
    else
    {
      $this->jsItems[]   = $key;
    }

  }//end public function addJsItem */

  /**
   *
   * @param string $jsCode
   * @return void
   */
  public function addJsCode( $jsCode )
  {
    $this->jsCode[] = $jsCode;
  }//end public function addJsCode */

  /**
   * @param array
   */
  public function setWindowProperties( $props )
  {

    foreach( $props as $key => $val )
    {
      $this->$key = $val;
    }

  }//end public function setWindowProperties */

  /**
   * request an icon
   * @return string
   */
  public function icon( $name , $alt )
  {
    return Wgt::icon($name,'xsmall',$alt);
  }//end public function icon */

  /**
   * @param array
   */
  public function loadWindowConf( $confKey )
  {

    $classname = 'WgtWindowConf'.ucfirst($confKey);

    if( Webfrap::classLoadable( $classname ) )
    {

      $props = new $classname();
      //$props = $props->asArray();

      foreach( $props as $key => $val )
      {
        $this->$key = $val;
      }

    }
    else
    {
      Error::addError('Requested conf: '.$confKey.' not exixts!');
    }


  }//end public function setWindowProperties */
  
  /**
   * Ein Suchfeld in injecten
   * @param WgtPanelElementSearch $element
   * @return WgtPanelElementSearch
   */
  public function setSearchElement( $element )
  {
    $this->searchElement = $element;
    return $element;
  } // end public function setSearchElement */
  
  /**
   * Ein Suchfeld in injecten
   * @param WgtPanelElementFilter $element
   * @return WgtPanelElementFilter
   */
  public function setFilterElement( $element )
  {
    $this->filterElement = $element;
    return $element;
  } // end public function setFilterElement */

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////


  /** the  method
   * @return string
   */
  public function build( )
  {

    $id         = $this->getId();
    $resizeable = $this->resizable
      ? ' resizable="resizable" ' : '';
    $movable    = $this->movable
      ? ' movable="movable" ' : '';
    $planet     = $this->planet
      ? ' planet="'.$this->planet.'" ' : '';

    $editAble   = $this->editAble
      ? '' : ' editable="false" ';

    $title      = $this->title
      ? '<title>'.$this->title.'</title>':'';
    $subtitle   = $this->subtitle
      ? '<subtitle>'.$this->subtitle.'</subtitle>':'';
    $statusBar  = $this->statusBar
      ? '<status>'.$this->statusBar.'</status>':'';

    $events = '';
    if( $this->events )
    {
      $events = '<events>';

      foreach( $this->events as $type => $subEvents )
      {
        foreach( $subEvents as $name => $code )
        {
          $events .= '<event type="'.$type.'" name="'.$name.'" ><![CDATA['.$code.']]></event>'.NL;
        }
      }

      $events .= '</events>';
    }

    $bookmark  = $this->bookmark
      ? '<bookmark title="'.$this->bookmark['title'].'"  url="'.urlencode($this->bookmark['url']).'" role="'.$this->bookmark['role'].'"  />'
      : '';



    $buttons  = $this->buildButtons();
    $content  = $this->includeTemplate( $this->template  );

    $jsCode   = '';
    if( $this->jsCode )
    {

      $this->assembledJsCode = '';

      foreach( $this->jsCode as $jsCode )
      {
        if( is_object($jsCode) )
          $this->assembledJsCode .= $jsCode->getJsCode();
        else
          $this->assembledJsCode .= $jsCode;
      }

      $jsCode = '<script><![CDATA['.NL.$this->assembledJsCode.']]></script>'.NL;
    }


    return <<<CODE

    <window $resizeable $movable id="{$id}" {$planet} {$editAble} >
      <dimensions width="{$this->width}" height="{$this->height}" min-width="{$this->minWidth}" min-height="{$this->minHeight}" />
      {$title}
      {$subtitle}
      {$statusBar}
      {$buttons}
      {$bookmark}
      {$events}
      <content><![CDATA[{$content}]]></content>
      {$jsCode}
    </window>

CODE;

  }//end public function build */

  /**
   *
   * @return string
   */
  public function buildButtons()
  {

    // if empty we need no Buttons
    if(!$this->buttons)
      return '';

    /*
    <buttons>
        <!-- <button text="Save" class="save"/>  -->
        <!--
        <button text="Publish" class="next"/>
        <button text="Retire">
          <action>
                <![CDATA[
      return function(){
        //self == Current window

      }
      ]]>
            </action>
        </button>-->
    </buttons>
    */

    $html = '<buttons>';

    foreach( $this->buttons as $button )
      $html .= $button->build();

    $html .= '</buttons>';

    return $html;

  }//end public function buildButtons */


 /**
  *
  * @param string $title
  * @param string $template
  * @return boolean
  */
  public function display( $title, $template )
  {

    // set the window status
    $this->setStatus($title);

    // set the window title
    $this->setTitle($title);

    // set the form template
    $this->setTemplate( $template );

    return true;

  }//end public function display */

/*//////////////////////////////////////////////////////////////////////////////
// emppty default methodes, more or less optional
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return void
   */
  public function compile(){}

  /**
   *
   * @return void
   */
  public function init(){}

  /**
   *
   * @return void
   */
  public function publish(){}

  /**
   *
   */
  protected function buildMessages(){}

} // end class WgtWindow

