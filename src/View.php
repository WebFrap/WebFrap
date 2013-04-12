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
  * Das Ausgabemodul für die Seite
 * @package WebFrap
 * @subpackage tech_core
  */
class View
{
/*//////////////////////////////////////////////////////////////////////////////
// Konstantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * doctype html4 Strict
   */
  const HTML4_STRICT    = 0;

  /**
   * doctype html4 transitional
   */
  const HTML4_TRANS       = 1;

  /**
   * doctype html4 frames
   */
  const HTML4_FRAME       = 2;

  /**
   * doctype xml1 strict
   */
  const XML1_STRICT       = 3;

  /**
   * doctype xml1 transitional
   */
  const XML1_TRANS        = 4;

  /**
   * doctype xml1 frames
   */
  const XML1_FRAME        = 5;

  /**
   * doctype xml1.1 frames
   */
  const XML1_1_STRICT     = 6;
  
  /**
   * HTML 5
   */
  const HTML5     = 7;
  

  /**
   * @param string
   */
  const AJAX        = 'ajax';

  /**
   * @param string
   */
  const JSON        = 'json';

  /**
   * @param string
   */
  const HTML        = 'html';

  /**
   * @param string
   */
  const FRONTEND    = 'frontend';

  /**
   * @param string
   */
  const AREA        = 'area';

  /**
   * @param string
   */
  const WINDOW      = 'window';

  /**
   * @param string
   */
  const SUBWINDOW   = 'window';

  /**
   * @param string
   */
  const MAINTAB     = 'maintab';

  /**
   * @param string
   */
  const MAINWINDOW  = 'mainwindow';

  /**
   * @param string
   */
  const MODAL  = 'modal';

  /**
   * @param string
   */
  const DOCUMENT    = 'document';

  /**
   * @param string
   */
  const SERVICE    = 'service';

  /**
   * @param string
   */
  const BINARY    = 'binary';

  /**
   * @param string
   */
  const PLAIN    = 'plain';

  /**
   * @param string
   */
  const CLI         = 'cli';

  /**
   * the default text content type
   * @var string
   */
  const CONTENT_TYPE_TEXT = 'text/html';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * sollen Informationen zum manipulieren des Menüs mitgeschickt werden
   *
   * @var boolean
   */
  public static $sendMenu = false;

  /**
   * soll die komplette Seite geschickt werden
   *
   * @var boolean
   */
  public static $sendIndex = false;

  /**
   * soll der ajax Body gesendet werden
   *
   * @var boolean
   */
  public static $sendBody = true;

  /**
   * soll der ajax Body gesendet werden
   *
   * @var boolean
   */
  public static $published = false;

  /**
   * name des aktiven themes
   *
   * @var string
   */
  public static $theme = null;

  /**
   * name des aktiven icon themes
   * @var string
   */
  public static $iconTheme = null;

  /**
   * der pfad zum aktuellen theme
   *
   * @var string
   */
  public static $themePath = null;

  /**
   * the web theme path for the browser / client
   * @var string
   */
  public static $themeWeb = null;

  /**
   * the web theme path for the browser / client
   * @var string
   */
  public static $iconsWeb = null;

  /**
   * Name des aktuell aktiven Themes
   * @var string
   */
  public static $webTheme     = null;

  /**
   * Web-Client Pfad zu den Icons im Icon Projekt
   * @var string
   */
  public static $webIcons     = null;

  /**
   * Web-Client Pfad zu den Bildern im Theme Projekt
   * @var string
   */
  public static $webImages    = null;

  /**
   * Mögliche Pfade in denen nach einem Template gesucht werden muss
   * @var array
   */
  public static $templatePath = array();

  /**
   * should headers be blocked?
   *
   * @var boolean
   */
  public static $blockHeader = false;

  /**
   * der typ der zu erstellenden template klasse
   *
   * @var string
   */
  public static $type = null;

  /**
   * der typ der zu erstellenden template klasse
   *
   * @var boolean
   */
  public static $searchPathTemplate = array();

  /**
   * der typ der zu erstellenden template klasse
   *
   * @var array
   */
  public static $searchPathIndex = array();

/*//////////////////////////////////////////////////////////////////////////////
// Instance
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * ein Template Objekt der aktiven Template Klasse
   * @var LibTemplate
   */
  private static $instance = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic and Magicsimulation
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public static function init()
  {

    $conf               = Conf::get('view');

    self::$theme        = 'default';
    self::$templatePath = PATH_GW.'templates/';

    self::$themePath    = Session::status('path.theme');

    self::$themeWeb     = Session::status('web.theme');
    self::$iconsWeb     = Session::status('web.icons');

    self::$webTheme     = Session::status('web.theme');
    self::$webIcons     = Session::status('web.icons');
    self::$webImages    = Session::status('web.theme').'images/';

    if (!defined('PLAIN')) {
      self::$type = self::$type?:'Html';
      $className  = 'LibTemplate'.ucfirst(self::$type);

      self::$instance = new $className($conf);

      // Setting Head and Index
      if (View::CONTENT_TYPE_TEXT == self::$instance->contentType) {

        $user = User::getActive();

        if ($user->getLogedIn()) {
          self::$instance->setIndex($conf['index.user']);
          self::$instance->setHtmlHead($conf['head.user']);
        } else {
          self::$instance->setIndex($conf['index.annon']);
          self::$instance->setHtmlHead($conf['head.annon']);
        }
      }
    }

  } //end public function init */

  /**
   * @param string $type
   *
   */
  public static function rebase($type)
  {

    $conf               = Conf::get('view');

    self::$theme        = 'default';
    self::$templatePath = PATH_GW.'templates/';

    self::$themePath    = Session::status('path.theme');

    self::$themeWeb     = Session::status('web.theme');
    self::$iconsWeb     = Session::status('web.icons');

    self::$webTheme     = Session::status('web.theme');
    self::$webIcons     = Session::status('web.icons');
    self::$webImages    = Session::status('web.theme').'images/';

    $className         = 'LibTemplate'.$type;
    self::$instance     = new $className($conf);

    Webfrap::$env->setView(self::$instance);
    Webfrap::$env->setTpl(self::$instance);
    Webfrap::$env->getResponse()->setTpl(self::$instance);

    // Setting Head and Index
    if (View::CONTENT_TYPE_TEXT == self::$instance->contentType) {
      $user = User::getActive();

      if ($user->getLogedIn()) {
        self::$instance->setIndex($conf['index.user']);
        self::$instance->setHtmlHead($conf['head.user']);
      } else {
        self::$instance->setIndex($conf['index.annon']);
        self::$instance->setHtmlHead($conf['head.annon']);
      }
    }

  } //end public function init */

  /**
   * clean closedown of the view
   *
   */
  public static function shutdown()
  {
    self::$instance->shutdown();
    self::$instance = null;
  } //end public static function shutdown */

  /**
   * request the activ engine instance
   * @return LibTemplateAjax
   * @deprecated use self::engine instead
   */
  public static function getInstance()
  {
    return self::$instance;
  }//end public function getInstance */

  /**
   * request the activ template engine
   * @return LibTemplateAjax
   */
  public static function engine(  )
  {
    return self::$instance;
  }//end public function engine */

  /**
   * request the active template engine
   * @return LibTemplateAjax
   */
  public static function getActive(  )
  {
    return self::$instance;
  }//end public function getActive */

/*//////////////////////////////////////////////////////////////////////////////
// application logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzen Aktiv Setzen einer neuen View sowie sofortige Rückgabe dieser View
   *
   * @param string $type
   * @return void
   */
  public static function setType($type)
  {
    self::$type = ucfirst($type);
  } // end public static function setType */

  /**
   * @param $file
   * @return unknown_type
   */
  public static function setHtmlHead($file)
  {
    echo self::$instance->setHtmlHead($file  );
  }//end public static function setHtmlHead */

  /**
   * @param $file
   * @param $folder
   * @param $params
   * @return unknown_type
   */
  public static function includeTemplate($file, $folder = null , $params = array())
  {
    echo self::$instance->includeTemplate($file, $folder , $params);
  }//end public static function includeTemplate */

  /**
   * @param string $file ein einfacher filename
   * @param mixed $object irgend ein Object für das potentielle template
   * @return string
   */
  public static function includeFile($file, $object = null)
  {

    ob_start();
    include $file;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  }//end public static function includeFile */

  /**
   * @param $errorMessage
   * @param $errorCode
   * @return unknown_type
   */
  public static function printErrorPage($errorMessage , $errorCode ,$toDump = null)
  {
    if (self::$instance) {
      self::$instance->printErrorPage($errorMessage , $errorCode ,$toDump);
    } else {
      echo $errorMessage.'<br />';
      echo Debug::dumpToString($toDump);
    }

  }//end public static function printErrorPage */

}//end class View

