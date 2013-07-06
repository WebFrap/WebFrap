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
class LibTemplateHtml extends LibTemplatePresenter
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
  public $output           = '';

  /**
   * Flag ob die Ausgabe Gzip komprimiert wurde
   * @var boolean
   */
  public $compressed = false;

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
   *
   * @var string
   */
  protected $assembledJsCode     = null;

  /**
   * zusätzliche einzelne CSS Dateien einbinden
   * diese dateien werden direkt über einen absoluten pfade eingebunden
   * und nicht über den minimizer
   * @var array
   */
  protected $fileStyles       = array();

  /**
   * Liste mit themedateien die über theme.php eingebunden werden sollen
   * @var array
   */
  protected $themesLists       = array();

  /**
   * Liste mit Css Dateien die über css.php eingebunden werden sollen
   * @var array
   */
  protected $cssLists       = array();

  /**
   * Liste mit Js Dateien die über js.php eingebunden werden sollen
   * @var array
   */
  protected $jsLists       = array();


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

  /**
   * wall message
   * @var string
   */
  protected $wallMessage       = null;

  /**
   * Soll die Debug Console ausgegeben werden können?
   * @var boolean
   */
  public $debugConsole = true;

/*//////////////////////////////////////////////////////////////////////////////
// magic methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the contstructor
   * @param array $conf the configuration loaded from the conf
   */
  public function __construct($conf = array())
  {
     $this->theme = 'default';

     $doctype     = isset($conf['doctype'])
      ? $conf['doctype']
      : View::XML1_TRANS;

     if (View::$docType) {
       $doctype = View::$docType;
     }

     $this->setDoctype($doctype);

     // Wenn es keinen neuen gibt bleibt alles beim alten
     $this->contentType = isset($conf['contentType'])
      ? $conf['contentType']
      : $this->contentType;

     parent::__construct($conf);

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
  public function setDoctype($doctype)
  {

    switch ($doctype) {

      case View::HTML4_STRICT : {
        $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>';
        break;
      }

      case View::HTML4_TRANS : {
        $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>';
        break;
      }

      case View::HTML4_FRAME : {
        $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
        "http://www.w3.org/TR/html4/frameset.dtd">
<html>';
        break;
      }

      case View::XML1_STRICT : {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }

      case View::XML1_TRANS : {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }

      case View::XML1_FRAME : {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }

      case View::XML1_1_STRICT: {
        $this->doctype = '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        break;
      }

      case View::HTML5: {
        $this->doctype = '<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->';
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
  public function setDefaultMetas($activ = false)
  {
    $this->defMetas = $activ;
  } // end public function setDefaultMetas($activ = false)


  /**
   * setzten einer neuen MainCss Datei zum überschreiben der StandardCss Datei
   *
   * @param string Name Name der neuen Css Datei
   * @return void
   */
  public function setMainCss($name)
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
   *  <li>language (de)</li>
   *  <li>cookie (cookiename=cookiewert; expires=Sun, 01 Jan 2006 00:00:00
   *     GMT; path=/;)</li>
   *  <li>expires (0)</li>
   *  <li>cache-control (no-cache)</li>
   *  <li>pragma (no-cache)</li>
   *  <li>norobots</li>
   *  <li>allrobots</li>
   *  <li>robots (follow,index)</li>
   * </ul>
   *
   * @param string Type Txpe der HTML Metadaten
   * @param string Content Inhalt der Metadaten falls vorhanden
   * @return
   */
  public function addMeta($type,  $content = null)
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
      { // Wann wurde Diese Seite erstellt (content='1 weeks')
        $this->metas[] = '<meta name="revisit-after" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann wurde Diese Seite erstellt (content='#php::QNet Staff - http://www.php-q.net/')
      case 'publisher':
      {
        $this->metas[] = '<meta name="publisher" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      // Copyright (Content='Copyright (c) 2005 meios.de (Dominik Bonsch)')
      case 'copyright':
      {
          $this->metas[] = '<meta name="copyright" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Für wen ist diese Seite bestimmt (content='alle'
      case 'audience':
      {
        $this->metas[] = '<meta name="audience" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // email des Erstellers der Seite (content='ollum@meios.de')
      case 'publisher-email':
      {
        $this->metas[] = '<meta name="publisher-email" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // URL der Seite zum genauen identifizieren (content='http://www.meios.de')
      case 'identifier-url':
      {
        $this->metas[] = '<meta name="identifier-url" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // TITEL der Seite (content='Hallo ich bin der TITEL')
      case 'page-topic':
      {
        $this->metas[] = '<meta name="page-topic" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // um welche Art von Seite handelt es sich (content='Unterseite/Homepage')
      case 'page-type':
      {
        $this->metas[] = '<meta name="page-type" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Http Equive Tags

        // Festlegen des ContentTypes (content='text/html; charset=ISO-8859-1')
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

        // Festlegen des Scripttypes auf der Seite (content='application/javascript')
      case 'script-type':
      {
        $this->metas[] = '<meta http-equiv="content-script-type"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Festlegen des Styletypes auf der Seite (content='text/css')
      case 'style-type':
      {
        $this->metas[] = '<meta http-equiv="content-style-type"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Ein Metarefresh einbauen (content='5; URL=http://de.selfhtml.org/')
      case 'refresh':
      {
        $this->metas[] = '<meta http-equiv="refresh" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

      case 'language':
      { // Die Sprache auf der Seite (content='de')
        $this->metas[] = '<meta http-equiv="content-language" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // setzen eines Cookies per HTML (content='cookiename=cookiewert; expires=Sun, 01 Jan 2006 00:00:00 GMT; path=/;')
      case 'cookie':
      {
        $this->metas[] = '<meta http-equiv="set-cookie"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann ist das Haltbarkeitsdatum des Inhalts abgelaufen (content='0')
      case 'expires':
      {
        $this->metas[] = '<meta http-equiv="expires"  content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann ist das Haltbarkeitsdatum des Inhalts abgelaufen (content='no-cache')
      case 'cache-control':
      {
        $this->metas[] = '<meta http-equiv="cache-control" content="'.$content.'" />'.NL;
        break;
      } // ENDE CASE

        // Wann ist das Haltbarkeitsdatum des Inhalts abgelaufen (content='no-cache')
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
    $metas .= '<meta http-equiv="X-UA-Compatible" value="IE=edge" />'.NL;

    return $metas;

  } //end public function addDefaultMetas  */

  /**
   * Hinzufügen einer JS Datei die als Datei in die Seite eingebunden wird
   *
   * @param string $name Name der Js Datei die eingebunden werden soll
   * @return void
   */
  public function addJsFile($name)
  {
    $this->fileJs[$name] = $name;
  } // end public function addJsFile */

  /**
  * @param string/array $key
  */
  public function addJsItem($key  )
  {

    if (is_array($key)) {
      $this->jsItems     = array_merge($this->jsItems, $key);
    } else {
      $this->jsItems[]   = $key;
    }

  }//end public function addJsItem */

  /**
   *
   * @param string $jsCode
   * @return void
   */
  public function addJsCode($jsCode)
  {
    $this->jsCode[] = $jsCode;
  }//end public function addJsCode */

  /**
   * path to a css file to embed
   *
   * @param string Name Name der CSS Datei die eingebunden werden soll
   * @return void
   */
  public function addCssFile($name)
  {
    $this->fileStyles[] = $name;
  } // end public function addCssFile */

  /**
   * Hinzufügen einer JS Liste
   *
   * @param string $name key der einzubindenten Js Liste
   * @return void
   */
  public function addJsList($name)
  {
    $this->jsLists[$name] = $name;
  } // end public function addJsList */

  /**
   * Hinzufügen einer Theme Liste
   *
   * @param string $name key der einzubindenten Theme Liste
   * @return void
   */
  public function addThemeList($name)
  {
    $this->themesLists[$name] = $name;
  } // end public function addThemeList */

  /**
   * Hinzufügen einer Css Liste
   *
   * @param string $name key der einzubindenten Css Liste
   * @return void
   */
  public function addCssList($name)
  {
    $this->cssLists[$name] = $name;
  } // end public function addCssList */

  /**
   * add a news feed
   *
   * @param string Url eines Rss Feed
   * @return void
   */
  public function addNewsfeed($url)
  {
    $this->rssFeed[] = $url;
  } // end public function addNewsfeed */

  /**
   * @var boolean[optional] $breakOut should the System break out of a frame
   * @return void
   */
  public function setNoFrameload($breakOut = true)
  {
    $this->killFrames = $breakOut;
  }//end public function setBreakOut */

  /**
   * @param string $title ErrorTitle
   * @param string $message ErrorMessage
   * @param int $errorCode ErrorCode
   * @return void
   */
  public function setErrorPage($title , $message , $httpCode = 500)
  {

    $this->setTemplate('error/message');
    $this->var->content['errorTitle']     = $title;
    $this->var->content['errorMessage']   = $message;
    ///TODO implement Http Error Codes

  }//end public function setErrorPage */


  /**
   * set the html content
   *
   * @param string $html
   * @return void
   */
  public function setHtml($html)
  {
    $this->compiled = $html;
  }//end public function setHtml */

  /**
   * setzen des Urlicons
   *
   * @param string $Icon Pfad zum Icon das in der Url des Browser geladen werden soll
   * @return void
   */
  public function setUrlicon($icon)
  {
    $this->urlIcon = $icon;
  } // end public function setUrlicon */

  /**
   * request the activ icon
   *
   * @param string $Icon Pfad zum Icon das in der Url des Browser geladen werden soll
   * @return void
   */
  public function getUrlicon()
  {
    return $this->urlIcon;
  } // end public function getUrlico */

  /**
   * request an icon
   * @return string
   */
  public function icon($name , $alt)
  {
    return Wgt::icon($name,'xsmall',$alt);
  }//end public function icon */

  /**
   *
   * @param $status
   */
  public function setHttpStatus($status)
  {
    $this->httpStatus = $status;
  }//end public function setHttpStatus */

  /**
   *
   * @param $status
   */
  public function openWindow($resource)
  {
    $this->openWindow = $resource;
  }//end public function openWindow */

  /**
   *
   * @param string $message
   */
  public function setWallMessage($message)
  {
    $this->wallMessage = $message;
  }//end public function setWallMessage */


/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function buildBody()
  {

    if ($this->subView && 'page' == $this->subView->type) {
      $this->assembledBody = $this->subView->buildBody();

      return $this->assembledBody;
    }

    if (!empty($this->assembledMainContent) && !$this->indexTemplate) {
      $this->assembledBody = $this->assembledMainContent;

      return $this->assembledBody;
    }

    if ($this->assembledBody)
      return $this->assembledBody;

    if ($filename = $this->templatePath($this->indexTemplate , 'index')) {

      $VAR       = $this->var;
      $ITEM      = $this->object;
      $ELEMENT   = $this->object;
      $AREA      = $this->area;
      $FUNC      = $this->funcs;
      $CONDITION = $this->condition;

      $MESSAGES  = $this->buildMessages();
      $TEMPLATE  = $this->template;
      $CONTENT   = $this->assembledMainContent;

      $JS_CODE   = null;
      if ($this->jsCode) {

        $this->assembledJsCode = '';

        foreach ($this->jsCode as $jsCode) {
          if (is_object($jsCode))
            $this->assembledJsCode .= $jsCode->getJscode();
          else
            $this->assembledJsCode .= $jsCode;
        }

        $JS_CODE = $this->assembledJsCode;
      }

      $I18N      = $this->i18n;
      $USER      = $this->user;
      $CONF      = $this->getConf();

      if (Log::$levelVerbose)
        Log::verbose("Load Index Template: $filename ");

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

    } else {

      Error::report('Index Template does not exist: '.$this->indexTemplate);

      ///TODO add some good error handler here
      if (Log::$levelDebug)
        $content = '<p class="wgt-box error">Wrong Index Template: '.$this->indexTemplate.' ('.$filename.')  </p>';
      else
        $content = '<p class="wgt-box error">Wrong Index Template '.$this->indexTemplate.' </p>';

    }

    $this->assembledBody .= $content;

    return $this->assembledBody;

  }//end public function buildBody */

  /**
   * Ausgabe Komprimieren
   */
  public function compress()
  {

    $this->compressed = true;
    $this->output = gzencode($this->output);

  }//end public function compress */

  /**
   * ETag für den Content berechnen
   * @return string
   */
  public function getETag()
  {
    return md5($this->output);
  }//end public function getETag */

  /**
   * Länge des Contents berechnen
   * @return int
   */
  public function getLength()
  {

    if ($this->compressed)
      return strlen($this->output);
    else
      return mb_strlen($this->output);

  }//end public function getLength */

  /**
   * flush the page
   *
   * @return void
   */
  public function compile()
  {

    $this->buildPage();

    if (DEBUG) {
      ob_start();
      $checkXml = new DOMDocument();

      if ($this instanceof LibTemplateAjax)
        $checkXml->loadXML($this->compiled);
      else
        $checkXml->loadHTML($this->compiled);

      $errors = ob_get_contents();
      ob_end_clean();

      // nur im fehlerfall loggen
      if ('' !== trim($errors)) {

        $this->getResponse()->addWarning('Invalid XML response');

        SFiles::write(PATH_GW.'log/tpl_xml_errors.html', $errors.'<pre>'.htmlentities($this->compiled).'</pre>');
        SFiles::write(PATH_GW.'log/tpl_xml_errors_'.date('Y-md-H-i_s').'.html', $errors.'<pre>'.htmlentities($this->compiled).'</pre>');
      }
    }

    if ($this->keyCachePage) {
      $this->writeCachedPage($this->keyCachePage , $this->compiled);
    }

    $this->output = $this->compiled;


  }//end public function compile */

  /**
   * flush the page
   *
   * @return void
   */
  public function build()
  {

    $this->buildPage();

    return $this->compiled;

  }//end public function build */

  /**
   *
   * @return void
   */
  public function publish()
  {
    //View::$blockHeader = true;
    //echo $this->compiled;
  }

 /**
   * @param string $errorMessage
   */
  public function publishError($errorTitle, $errorMessage = null)
  {

    $user = $this->getUser();

    if (! $this->compiled) {
      if (!$contentTyp = $this->tplConf['contenttype'])
        $contentTyp = 'text/html';

      if (!$charset  = $this->tplConf['charset'])
        $charset = 'utf-8';

      $this->getResponse()->sendHeader('Content-Type:'.$contentTyp.'; charset='.$charset);
    }


    $this->object     = array();

    $this->setIndex('error');
    $this->setTemplate('error/message');


    if (Log::$levelDebug)
      $message = $errorMessage;
    else
      $message = 'An Error Occured';


    $this->addVar(array
    (
      'errorMessage' => $errorMessage,
      'errorTitle'   => $errorTitle,
    ));

    $this->compile();

    View::$blockHeader = true;
    echo $this->compiled;

  }//end public function publishError */

/*//////////////////////////////////////////////////////////////////////////////
// Parser Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  public function buildPage()
  {

    if (trim($this->compiled) != '')
      return;

    // Parsing Data
    try {
      $this->buildBody();
    } catch (Exception $e) {

      $content = ob_get_contents();
      ob_end_clean();

      $this->assembledBody = '<h2>'.$e->getMessage().'</h2><pre>'.$e.'</pre>';
    }

    $this->assembledMessages = $this->buildMessages();

    $this->compiled = $this->doctype;
    $this->compiled .= NL.'<head>'.NL;

    // Den Titel auslesen oder generieren
    if (!is_null($this->title)) {
      $title = $this->title;
    } else {
      $title = Session::status('default.title');
    }

    $this->compiled .= '<title>'.$title.'</title>'.NL;

    // Testen ob die Defaultmetas gesetzt werden sollen
    if ($this->defMetas)
      $this->compiled .= $this->addDefaultMetas();

    $this->compiled .= implode('', $this->metas);

    $keyCss   = $this->keyCss
      ?:Session::status('key.css')
      ?:'default';

    $keyTheme = $this->keyTheme
      ?:Session::status('key.theme')
      ?:'default';

    $keyJs    = $this->keyJs
      ?:Session::status('key.js')
      ?:'default';

    $wgt = WEB_WGT;

    $this->compiled .= <<<HTML

<link type="text/css" href="css.php?l=list.{$keyCss}" rel="stylesheet" />
<link type="text/css" href="theme.php?l=list.{$keyTheme}"  rel="stylesheet" />

HTML;


    //$this->compiled .= $this->htmlHead();

    // Styles als Datei einbinden
    foreach ($this->fileStyles as $style) {
      $this->compiled .= '<link href="'.WEB_THEME."templates/"
        .$this->theme."/style/".$style.".css\" rel=\"stylesheet\" "
        ."type=\"text/css\" />".NL;
    }

    // Testen ob seperat Styleangaben vorhanden sind
    if ($this->embeddedStyles) {
      // Hinzufügen der
      $this->compiled .= "<style type=\"text/css\" >".NL;
      $this->compiled .= implode('',$this->embeddedStyles);
      $this->compiled .= '</style>'.NL;
    }

    // Hinzufügen von Newsfeed Angaben
    foreach ($this->rssFeed as $feed)
      $this->compiled .= '<link rel="alternate" type="application rss+xml" title="'.$feed['title'].'" href="'.$feed['url'].'" />'.NL;

    // Setzen des Urlicons
    if ($this->urlIcon)
      $this->compiled .= '<link rel="shortcut icon" href="'.$this->urlIcon.'" type="image/x-icon" />'.NL;

    // Verhindern das die Seite in einem Framset geladen werden kann.
    if ($this->killFrames)
      $this->compiled .= '<base target="_top" />'.NL;

    if (isset($this->tplConf['base'])) {
      $this->compiled .= '<base href="'.$this->tplConf['base'].'" />'.NL;

    }

    $this->compiled .= '</head>'.NL;
    $this->compiled .= '<body>'.NL;

    //$this->compiled .= '<div id="wgt-page-loader" ><h1>Loading</h1><div></div></div>'.NL;

    $this->compiled .= $this->assembledBody.NL;

    // debug Output anhängen
    if (DEBUG_CONSOLE && $this->debugConsole)
      $this->compiled .= $this->debugConsole(DEBUG_CONSOLE);

    $this->compiled .= <<<HTML

<script type="application/javascript" src="js.php?l=list.core" ></script>
<script type="application/javascript" src="js.php?l=list.{$keyJs}" ></script>
<script type="application/javascript" src="{$wgt}js_src/vendor/tiny_mce/jquery.tinymce.js" ></script>
<script type="application/javascript" src="{$wgt}js_src/vendor/tiny_mce/tiny_mce.js" ></script>

HTML;

/*
 *
<script type="application/javascript" src="{$wgt}js_src/vendor/tiny_mce/jquery.tinymce.js" ></script>
<script type="application/javascript" src="{$wgt}js_src/vendor/tiny_mce/tiny_mce.js" ></script>
<script type="application/javascript" src="{$wgt}js_src/vendor/ckeditor/ckeditor.js" ></script>
<script type="application/javascript" src="{$wgt}js_src/vendor/ckeditor/adapters/jquery.js" ></script>
 */

    // Einbinden der Javascript Dateien
    foreach ($this->fileJs as $script)
      $this->compiled .= '<script type="application/javascript" src="'.WEB_ROOT.$script.'.js"></script>'.NL;

    // platzieren des Javascript Codes
    if ($this->jsCode) {

      $this->assembledJsCode = '';

      foreach ($this->jsCode as $jsCode) {

        if (is_object($jsCode)) {
          $this->assembledJsCode .= $jsCode->getJsCode();
        } else {
          $this->assembledJsCode .= $jsCode;
        }
      }

      $this->compiled .= '<script type="application/javascript" >'.NL.$this->assembledJsCode.'</script>'.NL;
    }

    if ($this->openWindow)
      $this->compiled .= <<<CODE
<script type="application/javascript" >\$S(document).ready(function() {\$R.get('{$this->openWindow}');});</script>
CODE;

    $this->compiled .= '</body>'.NL;
    $this->compiled .= '</html>';

  } // end public function buildPage */

  /**
   * @return string
   */
  public function debugConsole($type = null)
  {

    $console = new WgtDebugConsole();

    return $console->build($type);

  }//end public function debugConsole */

  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return
   */
  protected function buildMessages()
  {

    $messageObject = Message::getActive();

    $html = '';

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if ($errors = $messageObject->getErrors()) {

      $html .= '<div id="wgt-box_error" class="wgt-box error">'.NL;

      foreach ($errors as $error)
        $html .= $error.'<br />'.NL;

      $html .= '</div>';

    } else {

      $html .= '<div style="display:none;" id="wgt-box_error" class="wgt-box error"></div>'.NL;
    }


    // Gibet Systemmeldungen? Wenn ja dann Raus mit
    if ($warnings = $messageObject->getWarnings()) {

      $html .= '<div  id="wgt-box_warning" class="wgt-box warning">'.NL;

      foreach ($warnings as $warn)
        $html .= $warn."<br />".NL;

      $html .= '</div>';
    } else {
      $html .= '<div style="display:none;" id="wgt-box_warning" class="wgt-box warning"></div>'.NL;
    }

    // Gibet Systemmeldungen? Wenn ja dann Raus mit
    if ($messages = $messageObject->getMessages()) {
      $html .= '<div id="wgt-box_message" class="wgt-box message" >'.NL;

      foreach ($messages as $message)
        $html .= $message."<br />".NL;

      $html .= '</div>';
    } else {
      $html .= '<div style="display:none;" id="wgt-box_message" class="wgt-box message"></div>'.NL;
    }

    // Meldungen zurückgeben
    return $html;

  } // end protected function buildMessages */

  /**
   *
   * @param $errorMessage
   * @param $errorCode
   * @return unknown_type
   */
  public function printErrorPage($errorMessage , $errorCode , $toDump = null)
  {

    if (!$filename = $this->templatePath('error/default')) {
      Error::addError('failed to load the body error/default');

      $dump = Debug::dumpToString($toDump);

      $fbMessage = <<<CODE
<h2>Error: $errorCode</h2>
<p>$errorMessage</p>
<p>$dump</p>
CODE;

      echo $fbMessage;

      return;

    }

    $VAR = $this->var;
    $VAR->errorMessage  = $errorMessage;
    $VAR->errorDump     = Debug::dumpToString($toDump);
    $VAR->errorCode     = $errorCode;
    $TITLE              = 'Error';
    $TEMPLATE           = 'errors/http_'.$errorCode;

    ob_start();
    include $filename;
    $content = ob_get_contents();
    ob_end_clean();

    echo $content;

  }//end public function printErrorPage */

  /**
   * Einbinden des HTML Header Abschnitts
   *
   * @param string $template
   * @return string
   * @deprecated use subeare or whatever
   */
  public function htmlHead()
  {

    if (!$this->htmlHead)
      return '';

    if ($filename = $this->templatePath($this->htmlHead, 'html_head')) {
      if (DEBUG)
        Debug::console('Head Template: '. $filename);

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      return $content;
    } else {
      return '';
    }

  }// end public function htmlHead */

} // end class LibTemplateHtml

