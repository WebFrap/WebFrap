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
class WgtModal extends LibTemplatePublisher
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de
   * Die HTML id des Tab Elements im Browser
   * @var int
   */
  public $id      = null ;

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
   * Die Breite des Modal Elements
   * @var string
   */
  public $width   = 600 ;
  
  /**
   * Die Standard höhe des Modal Elements
   * @var string
   */
  public $height   = 360 ;

  /**
   * @lang de:
   * Kann das Tab Element vom User in Client später geschlossen werden
   * @var boolean
   */
  public $closeable  = true ;

  /**
   * @var string
   */
  public $type      = 'modal';

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

/*//////////////////////////////////////////////////////////////////////////////
// Constructors and Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($env = null )
  {


    $this->var         = new TDataObject();
    $this->object      = new TDataObject();
    $this->url         = new TDataObject();
    $this->funcs       = new TTrait();

    if ($env )
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

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * get the id of the wgt object
   *
   */
  public function getId()
  {

    // wenn keine id existiert fällt das objekt automatisch auf einen generiert
    // unique id zurück
    if (!is_null($this->id ) )
      return $this->id;
    else
      return 'wgt-modal-'.uniqid();

  }//end public function getId */
  
  /**
   * Laden einer vorgefertigten Konfiguration für das Modal Element
   * 
   * @param string $confKey
   */
  public function loadUiConf($confKey )
  {
    
  }
  
  /**
   * setzen des HTML Titels
   * @param string $title Titel Der in der HTML Seite zu zeigende Titel
   * @param int $size
   * @param string $append
   * @return void
   */
  public function setTitle($title, $size = 75, $append = '...' )
  {
    $this->title = SParserString::shortLabel($title, $size, $append );
  } // end public function setTitle */

  /**
   * get the id of the wgt object
   * @param string $label
   * @param int $size
   * @param string $append
   */
  public function setLabel($label, $size = 35, $append = '...' )
  {
    $this->label = SParserString::shortLabel($label, $size, $append );
  }//end public function setLabel */
  
  /**
   * get the id of the wgt object
   * @param string $label
   * @param int $size
   * @param string $append
   */
  public function setStatus($label, $size = 35, $append = '...' )
  {
    $this->label = SParserString::shortLabel($label, $size, $append );
  }//end public function setStatus */


  /**
  * @param string/array $key
  */
  public function addJsItem($key  )
  {

    if ( is_array($key) )
    {
      $this->jsItems     = array_merge($this->jsItems, $key );
    } else {
      $this->jsItems[]   = $key;
    }

  }//end public function addJsItem */


/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/


  /** the buildr method
   * @return string
   */
  public function build( )
  {

    $id       = $this->getId();
    $content  = $this->includeTemplate($this->template  );

    $jsCode   = '';
    if ($this->jsCode )
    {

      $this->assembledJsCode = '';

      foreach($this->jsCode as $jsCode )
      {
        if ( is_object($jsCode) )
          $this->assembledJsCode .= $jsCode->getJsCode();
        else
          $this->assembledJsCode .= $jsCode;
      }

      $jsCode = '<script><![CDATA['.NL.$this->assembledJsCode.']]></script>'.NL;
    }

    $closeAble = $this->closeable?' closeable="true" ':'';

    $bottom = '';

    ///TODO xml entitie replacement auslager
    $title = str_replace( array('&','<','>','"'), array('&amp;','&lt;','&gt;','&quot;'), $this->title);
    $label = str_replace( array('&','<','>','"'), array('&amp;','&lt;','&gt;','&quot;'), $this->label);

    if ( DEBUG )
    {
      ob_start();
      $checkXml = new DOMDocument();
      
      if ($this instanceof LibTemplateAjax )
        $checkXml->loadHTML($this->compiled);
      
      $errors = ob_get_contents();
      ob_end_clean();
      
      // wenn xml fehler dann dumpen
      if ( '' !== trim($errors) )
      {
        $this->getResponse()->addWarning('Invalid XML response');
        SFiles::write( PATH_GW.'log/modal_xml_errors.html', $errors.'<pre>'.htmlentities("{$content}").'</pre>' );
        SFiles::write( PATH_GW.'log/modal_xml_errors_'.date('Y-md-H-i_s').'.html', $errors.'<pre>'.htmlentities("{$content}").'</pre>' );
      }
      
    }
    
    return <<<CODE

    <modal id="{$id}" label="{$label}" title="{$title}" width="{$this->width}" height="{$this->height}" >
      <body><![CDATA[{$content}]]></body>
      {$jsCode}
    </modal>

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

} // end class WgtModal

