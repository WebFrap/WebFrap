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
class LibTemplateHtmlHead
{

  /**
   * array with ajax javascript code
   * this code will be executed per eval on the client
   * no eval is not evil, it definitly doens't care anymore if i execute
   * this code with eval, or the code will be executed as i write it somewhere
   * in the browser
   *
   * @var array
   */
  public $ajaxActions         = array();

  /**
   * @var string
   */
  public $type                = 'html';

  /**
   * @var string
   */
  public $keyCss              = null;

  /**
   * @var string
   */
  public $keyTheme            = null;

  /**
   * @var string
   */
  public $keyJs               = null;

  /**
   *
   * @var array
   */
  protected $jsItems          = array();

  /**
   * doctype of the page
   * @var string
   */
  protected $doctype          = null;

  /**
   * @var boolan
   */
  protected $killFrames       = array();

  /**
   * @var array
   */
  protected $defMetas         = true;

  /**
   * @var array
   */
  protected $metas            = array();

  /**
   * @var string
   */
  protected $output           = '';

  /**
   * @var array
   */
  protected $fileJs           = array();

  /**
   * dynamic generated js files
   * @var array
   */
  protected $dynJs            = array();

  /**
   * Variable zum anhängen von Javascript Code
   * Aller Inline JS Code sollte am Ende der Html Datei stehen
   * Also sollte der Code nicht direkt in den Templates stehen sondern
   * in die View geschrieben werden können, so dass das Templatesystem den Code
   * am Ende der Seite einfach anhängen kann
   * @var string
   */
  protected $jsCode           = array();

  /**
   *
   * @var string
   */
  protected $assembledJsCode     = null;

  /**
   * @var array
   */
  protected $fileStyles       = array();

  /**
   * @var array
   */
  protected $embeddedStyles   = array();

  /**
   * @var array
   */
  protected $rssFeed          = array();

  /**
   * @var int
   */
  protected $httpStatus       = '200';

  /**
   * @var array
   */
  protected $urlIcon          = null;

  /**
   * resource address for a window that should be open
   * @var string
   */
  protected $openWindow       = null;


/*//////////////////////////////////////////////////////////////////////////////
// magic methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the contstructor
   * @param array $conf the configuration loaded from the conf
   */
  public function __construct($conf = array() )
  {
     $this->theme = 'default';

     $doctype     = isset($conf['doctype'])
      ? $conf['doctype']
      : View::XML1_TRANS;

     $this->setDoctype($doctype );

     // Wenn es keinen neuen gibt bleibt alles beim alten
     $this->contentType = isset($conf['contentType'])
      ? $conf['contentType']
      : $this->contentType;

     parent::__construct ($conf );

   }// end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setting a doctype for the Page
   *
   * @param int Doctype
   * @return void
   *
   * possible Doctypes
   * <ul>
   *   <li>View::HTML4_STRICT</li>
   *   <li>View::HTML4_TRANS</li>
   *   <li>View::HTML4_FRAME</li>
   *   <li>View::XML1_STRICT</li>
   *   <li>View::XML1_TRANS</li>
   *   <li>View::XML1_FRAME</li>
   *   <li>View::XML1_1_STRICT</li>
   * </ul>
   */
  public function setDoctype($doctype )
  {
    switch ($doctype) {
      case View::HTML4_STRICT :
      {
        $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>';
        break;
      }

      case View::HTML4_TRANS :
      {
        $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>';
        break;
      }
      case View::HTML4_FRAME :
      {
        $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
        "http://www.w3.org/TR/html4/frameset.dtd">
<html>';
        break;
      }
      case View::XML1_STRICT :
      {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }
      case View::XML1_TRANS :
      {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }
      case View::XML1_FRAME :
      {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }
      case View::XML1_1_STRICT:
      {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }
    } // ENDE SWITCH

  } // end public function setDoctype */



  /**
   * Methode zum deaktivieren bzw aktivieren der Defaultmetas
   *
   * @param bool $Aktiv Sollen die Defaultmetas ausgegeben werden
   * @return void
   */
  public function setDefaultMetas($activ = false )
  {
    $this->defMetas = $activ;
  } // end public function setDefaultMetas($activ = false )


  /**
   * setzten einer neuen MainCss Datei zum überschreiben der StandardCss Datei
   *
   * @param string Name Name der neuen Css Datei
   * @return void
   */
  public function setMainCss($name )
  {
    $this->mainCss = $name;
  } // end public function setMainCss */

  /** Neuen Metatype hinzufügen
   *
   * Folgende Metas werden unterstützt
   * <ul>
   *  <li>description (Hallo ich bin eine Seite)</li>
   *  <li>keywords (Stich, Worte)</li>
   *  <li>author (Dominik Bonsch)</li>
   *  <li>generator (MEIOS)</li>
   *  <li>date ()</li>
   *  <li>revisit (1 weeks)</li>
   *  <li>publisher (DEVIOS CREW - http://www.meios.de/)</li>
   *  <li>copyright (Copyright (c) 2005 meios.de (Dominik Bonsch))</li>
   *  <li>audience (alle)</li>
   *  <li>publisher-email (ollum@meios.de)</li>
   *  <li>identifier-url (http://www.meios.de)</li>
   *  <li>page-topic (Hallo ich bin der TITEL)</li>
   *  <li>page-type (Unterseite/Homepage)</li>
   *  <li>content-type (text/html; charset=ISO-8859-1)</li>
   *  <li>script-type (application/javascript)</li>
   *  <li>style-type (text/css)</li>
   *  <li>refresh (5; URL=http://de.meios.de/)</li>
   *  <li>language ( de )</li>
   *  <li>cookie (cookiename=cookiewert; expires=Sun, 01 Jan 2006 00:00:00
   *     GMT; path=/;)</li>
   *  <li>expires (0)</li>
   *  <li>cache-control (no-cache)</li>
   *  <li>pragma (no-cache)</li>
   *  <li>norobots</li>
   *  <li>allrobots</li>
   *  <li>robots ( follow,index)</li>
   * </ul>
   *
   * @param string Type Txpe der HTML Metadaten
   * @param string Content Inhalt der Metadaten falls vorhanden
   * @return
   */
  public function addMeta($type,  $content = null )
  {

    switch ($type) {

      case 'description':
      { // Hinzufügen einer Beschreibung für die Seite
        $this->metas[] = '<meta name="description" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'keywords':
      { // Hinzufügen von keywords für die Seite
        $this->metas[] = '<meta name="keywords" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'author':
      { // Angeben des Authors der Seite
        $this->metas[] = '<meta name="author" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'generator':
      { //Welche Software hat die Seite generiert
        $this->metas[] = '<meta name="generator" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'date':
      { // Wann wurde Diese Seite erstellt
        $this->metas[] = '<meta name="date" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'revisit':
      { // Wann wurde Diese Seite erstellt ( content='1 weeks' )
        $this->metas[] = '<meta name="revisit-after" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann wurde Diese Seite erstellt ( content='#php::QNet Staff - http://www.php-q.net/' )
      case 'publisher':
      {
        $this->metas[] = '<meta name="publisher" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      // Copyright ( Content='Copyright (c) 2005 meios.de (Dominik Bonsch)' )
      case 'copyright':
      {
          $this->metas[] = '<meta name="copyright" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Für wen ist diese Seite bestimmt ( content='alle'
      case 'audience':
      {
        $this->metas[] = '<meta name="audience" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // email des Erstellers der Seite ( content='ollum@meios.de' )
      case 'publisher-email':
      {
        $this->metas[] = '<meta name="publisher-email" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // URL der Seite zum genauen identifizieren ( content='http://www.meios.de' )
      case 'identifier-url':
      {
        $this->metas[] = '<meta name="identifier-url" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // TITEL der Seite ( content='Hallo ich bin der TITEL' )
      case 'page-topic':
      {
        $this->metas[] = '<meta name="page-topic" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // um welche Art von Seite handelt es sich ( content='Unterseite/Homepage' )
      case 'page-type':
      {
        $this->metas[] = '<meta name="page-type" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Http Equive Tags

        // Festlegen des ContentTypes ( content='text/html; charset=ISO-8859-1' )
      case 'content-type':
      {
        if ($content != '') {

          $contenTyp  = $this->tplConf['contentype'];
          $charSet    = $this->tplConf['charset'];
          $content    = $contenTyp.'; charset='.$charSet;
        }// Ende If
        $this->metas[] = '<meta http-equiv="content-type"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Festlegen des Scripttypes auf der Seite ( content='application/javascript' )
      case 'script-type':
      {
        $this->metas[] = '<meta http-equiv="content-script-type"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Festlegen des Styletypes auf der Seite ( content='text/css' )
      case 'style-type':
      {
        $this->metas[] = '<meta http-equiv="content-style-type"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Ein Metarefresh einbauen ( content='5; URL=http://de.selfhtml.org/' )
      case 'refresh':
      {
        $this->metas[] = '<meta http-equiv="refresh" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'language':
      { // Die Sprache auf der Seite ( content='de' )
        $this->metas[] = '<meta http-equiv="content-language" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // setzen eines Cookies per HTML ( content='cookiename=cookiewert; expires=Sun, 01 Jan 2006 00:00:00 GMT; path=/;' )
      case 'cookie':
      {
        $this->metas[] = '<meta http-equiv="set-cookie"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann ist das Haltbarkeitsdatum des Inhalts abgelaufen ( content='0' )
      case 'expires':
      {
        $this->metas[] = '<meta http-equiv="expires"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann ist das Haltbarkeitsdatum des Inhalts abgelaufen ( content='no-cache' )
      case 'cache-control':
      {
        $this->metas[] = '<meta http-equiv="cache-control" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann ist das Haltbarkeitsdatum des Inhalts abgelaufen ( content='no-cache' )
      case 'pragma':
      {
        $this->metas[] = '<meta http-equiv="pragma" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Abschnitt für die Robots

      case 'norobots':
      { // Robots dürfen nix
        $this->metas[] = '<meta name="robots"  content="noindex, nofollow" />'.NL;
        break;
      } // ENDE CASE

      case 'allrobots':
      { // Robots dürfen alles
        $this->metas[] = '<meta name="robots" content="all" />'.NL;
        break;
      } // ENDE CASE

      case 'robots':
      { // Konfigurieren der Robots
        $this->metas[] = '<meta name="robots" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

    } // ENDE SWITCH
  } // end public function addMeta */

  /**
   * Funktion zum hinzufügen von Metadaten in die Seite
   *
   * @return
   */
  public function addDefaultMetas()
  {

    $session    = $this->getSession();

    $contentTyp = $this->tplConf['contenttype'];
    $charset    = $this->tplConf['charset'];
    $language   = $session->getStatus('activ.lang');
    $generator  = $session->getStatus('sys.generator');

    $metas = '<meta http-equiv="content-type" content="'.$contentTyp.'; charset='.$charset.'" />'.NL;
    $metas .= '<meta http-equiv="content-Script-Type" content="application/javascript" />'.NL;
    $metas .= '<meta http-equiv="content-Style-Type" content="text/css" />'.NL;
    $metas .= '<meta http-equiv="content-language" content="'.$language.'" />'.NL;
    $metas .= '<meta name="generator" content="'.$generator.'" />'.NL;

    return $metas;

  } //end public function addDefaultMetas  */

  /**
   * Hinzufügen einer JS Datei die als Datei in die Seite eingebunden wird
   *
   * @param string $name Name der Js Datei die eingebunden werden soll
   * @return void
   */
  public function addJsFile($name )
  {
    $this->fileJs[$name] = $name;
  } // end public function addJsFile */

  /**
  * @param string/array $key
  */
  public function addJsItem($key  )
  {

    if ( is_array($key) ) {
      $this->jsItems     = array_merge($this->jsItems, $key );
    } else {
      $this->jsItems[]   = $key;
    }

  }//end public function addJsItem */

  /**
   *
   * @param string $jsCode
   * @return void
   */
  public function addJsCode($jsCode )
  {
    $this->jsCode[] = $jsCode;
  }//end public function addJsCode */

  /**
   * path to a css file to embed
   *
   * @param string Name Name der CSS Datei die eingebunden werden soll
   * @return void
   */
  public function addCssFile($name )
  {
    $this->fileStyles[] = $name;
  } // end public function addCssFile */

  /**
   * add a news feed
   *
   * @param string Url eines Rss Feed
   * @return void
   */
  public function addNewsfeed($url )
  {
    $this->rssFeed[] = $url;
  } // end public function addNewsfeed */

  /**
   * @var boolean[optional] $breakOut should the System break out of a frame
   * @return void
   */
  public function setNoFrameload($breakOut = true )
  {
    $this->killFrames = $breakOut;
  }//end public function setBreakOut */

  /**
   * @param string $title ErrorTitle
   * @param string $message ErrorMessage
   * @param int $errorCode ErrorCode
   * @return void
   */
  public function setErrorPage($title , $message , $httpCode = 500 )
  {

    $this->setTemplate( 'error/message' );
    $this->var->content['errorTitle']     = $title;
    $this->var->content['errorMessage']   = $message;
    ///TODO implement Http Error Codes

  }//end public function setErrorPage */

  /**
   * setzen des Urlicons
   *
   * @param string $Icon Pfad zum Icon das in der Url des Browser geladen werden soll
   * @return void
   */
  public function setUrlicon($icon )
  {
    $this->urlIcon = $icon;
  } // end public function setUrlicon */

  /**
   * request the activ icon
   *
   * @param string $Icon Pfad zum Icon das in der Url des Browser geladen werden soll
   * @return void
   */
  public function getUrlicon( )
  {
    return $this->urlIcon;
  } // end public function getUrlico */

  /**
   *
   * @param $status
   */
  public function setHttpStatus($status )
  {
    $this->httpStatus = $status;
  }//end public function setHttpStatus */

  /**
   *
   * @param $status
   */
  public function openWindow($resource )
  {
    $this->openWindow = $resource;
  }//end public function openWindow */

} // end class LibTemplateHtml

