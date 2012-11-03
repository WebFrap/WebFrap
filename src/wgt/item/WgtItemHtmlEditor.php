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
 * class WgtItemTextarea
 * Objekt zum generieren einer Textarea
 * @package WebFrap
 * @subpackage ModCms
 */
class WgtItemHtmlEditor
  extends WgtItemAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  protected $content = null;

  /**
   * @var array
   */
  protected $editorAttributes = array();

  /**
   * @var string
   */
  protected $iconPath = './templates/default/icons/xsmall/';

  /**
   * @var array
   */
  protected $showBars = array
  (
  'CmsText' => true,
  'CmsHtml' => true,
  );

  /**
   * @var array
   */
  protected $barAttributes = array();

  /**
   * @var array
   */
  protected $barStyles = array();

////////////////////////////////////////////////////////////////////////////////
// Magic Funktions
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct( $name )
  {
    parent::__construct( $name );

    $this->attributes = array( 'cols' => '' , 'rows' => '' );

  }//end public function __construct( $name )

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

 /**
  * @param mixed
  * @return void
  */
  public function setContent( $data )
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__,__method__ ,array($data) );

    $this->data = $data;

  }//end public function setContent( $data )

 /**
  * @param mixed
  * @return void
  */
  public function getContent(  )
  {

    return $this->data;

  }//end public function getContent(  )

    /** adding new attributes
   *
   * @param mixed(string,array) $name
   * @param string[optinal] $data
   * @return void
   */
  public function addEditorAttributes( $name , $data  = null )
  {

    if( is_array($name) )
    {
      $this->editorAttributes = array_merge( $this->editorAttributes , $name );
    }
    else
    {
      $this->editorAttributes[$name] = $data ;

    }// Ende Else

  } // end public function addEditorAttributes( $name , $data  = null )

  /** request the attributes
   *
   * @param string $key
   * @return mixed
   */
  public function getEditorAttributes( $key = null )
  {

    if( is_null($key) )
    {
      return $this->editorAttributes;
    }
    else
    {
      return isset($this->editorAttributes[$key]) ? $this->editorAttributes[$key] : null ;
    }// Ende Else

  } // end public function getEditorAttributes( $key = null )

  /**
   * set the path for the icons
   * @var string $iconPath
   */
  public function setIconPath( $iconPath )
  {

    $this->iconPath = $iconPath;

  }//end public function setIconPath( $iconPath )

  /**
   * which bars should be shown
   * @var string/array  $key
   * @var booelan[optional]  $value
   */
  public function setShowBar( $key , $value = null )
  {


    if( is_array($key) )
    {
      $this->showBars = array_merge( $this->showBars , $key );
    }
    else
    {
      $this->showBars[$key] = $value;
    }

  }//end public function setShowBar( $key , $value = null )


////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @return String
   */
  protected function buildEditorAttributes()
  {

    $html = '';

    foreach( $this->editorAttributes as $key => $value )
    {
      $html .= $key.'="'.$value.'" ';
    }

    return $html;

  }// endprotected function buildEditorAttributes()

  /**
   *
   * @return String
   */
  protected function asmAttributes( $editorName )
  {

    $html = '';

    if(!isset($this->attributes['onselect']))
    {
      $this->attributes['onselect'] = $editorName.'.activate();';
    }
    if(!isset($this->attributes['onclick']))
    {
      $this->attributes['onclick'] = $editorName.'.activate();';
    }
    if(!isset($this->attributes['onkeyup']))
    {
      $this->attributes['onkeyup'] = $editorName.'.activate();';
    }

    foreach( $this->attributes as $key => $value )
    {
      $html .= $key.'="'.$value.'" ';
    }

    return $html;

  }//end protected function asmAttributes( $editorName )


  /**
   * Parser
   *
   * @return String
   */
  public function build( )
  {

    $view = Controller::getSysmodul('VIEW');
    $view->addWgtPlugin('wgt.item.htmleditor');

    $editorName = 'htmlEditor'.ucfirst($this->name);

    $attributes       = $this->asmAttributes( $editorName );
    $editorAttributes = $this->buildEditorAttributes();

    $html = '<div '.$editorAttributes.' >';

    $html .= '<script type="application/javascript" >
      var '.$editorName.' = new WgtItemHtmleditor( "'.$editorName.'" , false );
      </script>'.NL.'</div>';

    $html .= $this->buildEditor( $editorName );

    $html .= '<textarea id="wgt'.$editorName.'" '.$attributes.' >';
    $html .= $this->data;
    $html .= '</textarea>'.NL;
    $html .= '<script type="application/javascript" >'.$editorName.'.init();</script>'.NL;
    $html .= '<div id="wgtPreview'.$editorName.'" style="display:none;margin-top:30px;" class="text"></div>'.NL;

    return $html;

  } // end public function build( )


  /**
   * @param string $name
   * @param string $wysiwyg
   */
  public function buildEditor( $editorName )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,method__,array( $editorName ));

    $html = '<div>'.NL;

    // Load Bars and Parse Them
    foreach( $this->showBars as $bar => $activ )
    {
      if( $activ )
      {
        $barName = 'WgtToolbar'.$bar;
        $barObj = new $barName( $this->name.'Bar'.$bar );

        if(isset( $this->barAttributes[$bar] ))
        {
          $barObj->addAttributes($this->barAttributes[$bar]);
        }

        if(isset( $this->barAttributes[$bar] ))
        {
          $barObj->addAttributes($this->barAttributes[$bar]);
        }

        $barObj->setIconPath( $this->iconPath );
        $barObj->setEditorName( $editorName );

        $html .= $barObj->build();
      }
    }

    $html .= '</div>';
    return $html;

  }//end public function buildEditor( $name  )


} // end class WgtItemHtmlEditor

