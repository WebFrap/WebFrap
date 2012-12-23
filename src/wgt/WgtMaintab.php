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
 * @lang de:
 *
 * Basis klasse für alle Maintabs Views
 *
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtMaintab
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
   * @lang de
   * Die HTML id des Tab Elements im Browser
   * @var int
   */
  public $id      = null ;

  /**
   *
   * @var int
   */
  public $tabId   = null ;

  /**
   * @lang de:
   * Das Label welches später im Tab / fürs tabbing verwendet wird
   * @var string
   */
  public $label   = null ;

  /**
   * @lang de:
   * Der Inhalt des Title Panels
   * @var string
   */
  public $title   = null ;


  /**
   * @lang de:
   * Kann das Tab Element vom User in Client später geschlossen werden
   * @var boolean
   */
  public $closeable  = true ;

  /**
   * @var string
   */
  public $type      = 'tab';

  /**
   * @lang de:
   * Liste mit Buttons die links in der Tab Bar des Maintabs angezeigt werden
   * @var array
   */
  public $buttons   = array();
  
  /**
   * Mask Actions
   * @var array
   */
  public $maskActions   = array();

  /**
   * data for bookmarking this tab
   * @var array
   */
  public $bookmark  = array();
  
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
   * @var string
   */
  protected $assembledJsCode = null;

  /**
   * @var array
   */
  protected $jsItems       = array();

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

    // wenn keine id existiert fällt das objekt automatisch auf einen generiert
    // unique id zurück
    if( !is_null( $this->id ) )
      return $this->id;
    else
      return 'wgt-tab-'.uniqid();

  }//end public function getId */
  
  /**
   * setzen des HTML Titels
   * @param string $title Titel Der in der HTML Seite zu zeigende Titel
   * @param int $size
   * @param string $append
   * @return void
   */
  public function setTitle( $title, $size = 75, $append = '...' )
  {
    $this->title = SParserString::shortLabel( $title, $size, $append );
  } // end public function setTitle */

  /**
   * get the id of the wgt object
   * @param string $label
   * @param int $size
   * @param string $append
   */
  public function setLabel( $label, $size = 35, $append = '...' )
  {
    $this->label = SParserString::shortLabel( $label, $size, $append );
  }//end public function setLabel */

  /**
   * @param string $tabId
   */
  public function setTabId( $tabId )
  {
    $this->tabId = $tabId;
  }//end public function setTabId */

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

  }//end public function newButton */

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
   * @param string $name
   * @param string $type
   * 
   * @return WgtDropmenu
   */
  public function newMenu( $name, $type = null )
  {

    if( $type )
    {

      $className  = ucfirst($type).'_Maintab_Menu';

      if( !Webfrap::classLoadable($className) )
      {
        throw new LibTemplate_Exception('requested nonexisting menu '.$type);
      }

      $button     = new $className( $this );
    }
    else
    {
      $button     = new WgtDropmenu( $this );
    }

    $button->name = $name;

    // ACLs und die view werden direkt übergeben
    // Bei einer sauberen Implementierung der Architektur werden beide Objekte
    // in ca. 99% der Fälle benötigt ( +1% fehlerquote )
    $button->setAcl( $this->getAcl() );
    $button->setView( $this );

    $this->buttons[$button->name] = $button;
    return $button;

  }//end public function newMenu */


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
   * @return string
   */
  public function buildButtons()
  {

    // if empty we need no Buttons
    if( !$this->buttons )
      return '';

    $html = '<div class="buttons left" >';

    foreach( $this->buttons as /* @var $button WgtButton */ $button )
      $html .= $button->buildMaintab();

    $html .= '</div>';

    return $html;

  }//end public function buildButtons */

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////


  /** the buildr method
   * @return string
   */
  public function build( )
  {

    $id       = $this->getId();

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

    $closeAble = $this->closeable?' closeable="true" ':'';

    $buttons = '';

    foreach( $this->buttons as /* @var $button WgtButton */ $button )
      $buttons .= $button->buildMaintab();
      
    $maskActions = '';

    $tabs    = '';

    if( '' != trim($this->tabId)  )
    {

      $themePath = View::$themeWeb;

      $tabTitle = '';
      
      if( $this->title || $this->searchElement )
      {
        if( $this->title )
        {
          if( $this->searchElement )
          {
            $tabTitle = '<div class="wgt-panel title left" style="width:100%" >'
              .'<div class="wl2 left" style="height:30px;" ><h2>'.$this->title.'</h2></div>'
              .$this->searchElement->render()
              .'</div><!-- end wgt-panel title left 100 -->';
          }
          else 
          {
            $tabTitle = '<div class="wgt-panel title left" style="width:100%" ><h2>'.$this->title.'</h2></div><!-- end wgt-panel title left -->';
          }
        }
        else 
        {
          $tabTitle = '<div class="wgt-panel left" style="width:100%" >'.$this->searchElement->render().'</div><!-- end wgt-panel left -->';
        }
      }

      $panel = <<<HTML
  <div class="wgt-panel maintab" >
    <div id="{$this->tabId}-head" class="wgt_tab_head" >
      <div class="wgt-container-controls">
        <div class="wgt-container-buttons">{$buttons}</div><!-- end menu -->
        <div class="tab_outer_container">
          <div class="tab_scroll" >
            <div class="tab_container" >&nbsp;</div>
          </div>
        </div>
      </div>
    </div><!-- end wgt_tab_head -->
    {$tabTitle}
  </div><!-- end wgt-panel maintab -->
HTML;

    }
    else
    {

      $tabTitle = '';
      if( $this->title || $this->searchElement )
      {
        if( $this->title )
        {
          if( $this->searchElement )
          {
            $tabTitle = '<div class="wgt-panel title left" style="width:100%" >'
              .'<div class="wl2 left" style="height:30px;" >'
              .'<h2>'.$this->title.'</h2>'
              .'</div>'
              .$this->searchElement->render()
              .'</div><!-- end search element -->';
          }
          else 
          {
            $tabTitle = '<div class="wgt-panel title left" style="width:100%" ><h2>'.$this->title.'</h2></div><!-- end wgt-panel title left -->';
          }
        }
        else 
        {
          $tabTitle = '<div class="wgt-panel left" style="width:100%" >'.$this->searchElement->render().'</div><!-- end wgt-panel left -->';
        }
      }
      
      $filters = '';
      if( $this->filterElement )
      {
        $filters = '<div class="right inner" >'.$this->filterElement->render().'</div><!-- end filter -->';
      }

      $icClose = $this->icon('control/close_tab.png', 'close' );
      //
      
      $panel = <<<HTML
    <div class="wgt-panel maintab" >
      <div class="wgt-panel head" >
        {$buttons}
        {$filters}
        <div class="right" >
        	{$maskActions}
          <button
          	class="wcm wcm_ui_tip-left wgt-button wgtac_close" 
          	tabindex="-1" 
          	tooltip="Close the active tab"  >{$icClose}</button>
        </div>
      </div><!-- end tab wgt-panel head-->
      {$tabTitle}<!-- end tab title -->
    </div>
    <!-- end tab -->
HTML;

      /*
      $panel = <<<HTML
    <div class="wgt-panel maintab" >
      {$tabTitle}
      <div class="wgt_tab_head" >
        <div class="wgt-container-controls">
          <div class="wgt-container-buttons">{$buttons}</div>
          <div class="tab_outer_container"></div>
        </div>
      </div>
    </div>
HTML;
       */

    }

    $bottom = <<<HTML
    <div class="wgt_footer maintab" >
      footer
    </div>
HTML;

    $bottom = '';

    ///TODO xml entitie replacement auslager
    $title = str_replace( array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), $this->title);
    $label = str_replace( array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), $this->label);
    
    if( DEBUG )
    {
      ob_start();
      $checkXml = new DOMDocument();
      
      if( $this instanceof LibTemplateAjax )
        $checkXml->loadHTML($this->compiled);
      
      $errors = ob_get_contents();
      ob_end_clean();
      
      if( '' !== trim($errors) )
      {
        
        $this->getResponse()->addWarning('Invalid XML Response');
        
        SFiles::write
        (
          PATH_GW.'log/maintab_xml_errors.html', 
          $errors.'<pre>'.htmlentities("{$panel}<div class=\"wgt-content maintab\" >{$content}</div>{$bottom}").'</pre>' 
        );
        SFiles::write
        (
          PATH_GW.'log/maintab_xml_errors_'.date('Y-md-H-i_s').'.html', 
          $errors.'<pre>'.htmlentities("{$panel}<div class=\"wgt-content maintab\" >{$content}</div>{$bottom}").'</pre>'  
        );
      }
    }

    return <<<CODE

    <tab id="{$id}" label="{$label}" title="{$title}" {$closeAble}  >
      <body><![CDATA[{$panel}<div class="wgt-content maintab" >{$content}</div>{$bottom}]]></body>
      {$jsCode}
    </tab>

CODE;

//<body><![CDATA[{$panel}<div class="wgt-content maintab" ><div class="body" >{$content}</div></div>]]></body>

  }//end public function build */


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

} // end class WgtMaintab

