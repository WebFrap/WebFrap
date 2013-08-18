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
 *
 */
class LibParserDocHtml
{
/*//////////////////////////////////////////////////////////////////////////////
// Output File Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /** The master template
   * @var string
   */
  protected $theme = 'default';

  /** The Index
   * @var string
   */
  protected $indexTemplate = 'plain';

  /** The main Template
   * @var string
   */
  protected $template = null;

  /**
   * @var string
   */
  protected $title = null;

  /**
   * @var array
   */
  protected $var = array();

  /**
   * @var array
   */
  protected $object = array();

  /**
   * @var array
   */
  protected $objectHtml = array();

  /**
   * @var string
   */
  protected $assembledBody = '';

  /**
   * @var string
   */
  protected $assembledMessages = null;

  /**
   * @var boolean
   */
  protected $compiled = false;

/*//////////////////////////////////////////////////////////////////////////////
// magic methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return
   */
  public function __construct()
  {

     $this->var = new TDataObject();
     $this->object = new TDataObject();
     $this->objectHtml = new TDataObject();

     $wbf = Webfrap::getActive();

     if ($theme = $wbf->getSysStatus('systemplate')) {
       $this->theme = $theme;
     } else {
       $this->theme = 'default';
     }

   }// end public function __construct

/*//////////////////////////////////////////////////////////////////////////////
// Getter und Setter
//////////////////////////////////////////////////////////////////////////////*/

   /**
    * Name des zu verwendenten Templates festlegen
    *
    * @param string $template Name des Maintemplates
    * @return void
    */
   public function setTheme($template)
   {

     $this->theme = $template;

   } // end of member function settheme

   /**
    * setzen des zu verwendenten Indexes
    *
    * @param string Index Name des Indextemplates
    * @return bool
    */
   public function setIndex($index = 'default')
   {
     if (Log::$levelDebug)
      Log::start(__file__ , __line__ , __method__,array($index));

     $this->indexTemplate = $index;

   } // end of member function setIndex

   /**
    *
    */
   public function setTemplate($template , $folder = null)
   {
     if (Log::$levelDebug)
      Log::start(__file__ , __line__ , __method__,array($template , $folder));

     $sub = is_null($folder) ? '' : $folder.'/';

     $this->template = $sub.$template;

   }// end public function setTemplate

  /**
   * Content für die Seite hinzufügen
   *
   * @param array/string Content Einen Array mit Content für die Seite
   * @param string Data Die Daten für ein bestimmtes Feld
   * @return void
   */
  public function addVar($key, $data = null)
  {
     if (Log::$levelDebug)
      Log::start(__file__ , __line__ , __method__,array($key, $data));

    if (is_scalar($key)) {
      $this->var->content[$key] = $data;
    } elseif (is_array($key)) {
      $this->var->content = array_merge($this->var->content, $key);
    }

  } // end of member function addVar

  /**
   * Content für die Seite hinzufügen
   *
   * @param array/string Content Einen Array mit Content für die Seite
   * @param string Data Die Daten für ein bestimmtes Feld
   * @return WgtItemAbstract
   */
  public function addItem($key, $type , $subtype = 'Item')
  {
    if (Log::$levelDebug)
      Log::start(__file__ , __line__ , __method__,array($key, $type , $subtype));

    if (isset($this->object->content[$key])) {
      return $this->object->content[$key];
    } else {
      $className = 'Wgt'.ucfirst($subtype).ucfirst($type);

      if (!WebFrap::classExists($className)) {
        throw new WgtItemNotFound_Exception
        (
        'Class '.$className.' was not found'
        );
      } else {
        $object = new $className($key);
        $this->object->content[$key] = $object;

        return $object;
      }
    }

  } // end of member function addItem

  /**
   *
   */
  public function setItem($key, $type , $subtype = 'Item')
  {

    if (is_object($type)) {
      $this->object->content[$key] = $type;

      return true;
    } else {
      $className = 'Wgt'.ucfirst($subtype).ucfirst($type);

      if (!class_exists($className)) {
        throw new WgtItemNotFound_Exception
        (
        'Class '.$className.' was not found'
        );
      } else {
        $object = new $className($key);
        $this->object->content[$key] = $object;

        return $object;
      }
    }

  } // end of member function setItem

  /**
   *
   */
  public function includeBody($template)
  {

    $filename = TEMPLATE_PATH.'modules/'.$template.'.tpl';

    if (file_exists($filename) and is_readable($filename)) {
      $TITLE = $this->title;
      $VAR = $this->var;
      $ITEM = $this->objectHtml;
      $ELEMENT = $this->objectHtml;
      $WGI = $this->object;
      $LANG = I18n::getDefault();

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      return $content;
    } else {
      Error::report('failed to load the body');

      return '<p style="errorMessage">failed to load the body '.$filename.'</p>';
    }

  }// end public function includeTemplate

  /**
   *
   */
  public function includeTemplate($template, $folder = null)
  {

    $sub = is_null($folder) ? 'base/' : $folder.'/';

    $filename = TEMPLATE_PATH.'modules/'.$sub.$template.'.tpl';

    if (file_exists($filename) and is_readable($filename)) {

      $VAR = $this->var;
      $ITEM = $this->objectHtml;
      $WGI = $this->object;
      $LANG = I18n::getDefault();

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      return $content;
    } else {
      return '<p style="errorMessage">The requested template does not exist.</p>';
    }

  }// end public function includeTemplate

  /**
   *
   */
  public function buildObjects()
  {

    foreach ($this->object->content as $key => $object) {
      if (is_object($object)) {
        $this->objectHtml->content[$key] = $object->toHtml();
      }
    }

  }//end public function buildObjects

  /**
   *
   */
  public function cleanView()
  {

    $this->template = null;
    $this->mainCaption = null;
    $this->var = array();
    $this->object = array();
    $this->objectHtml = null;
    $this->assembledBody = '';

  }// end cleanView

  /**
   * @return void
   */
  public function build()
  {

    $filename = TEMPLATE_PATH.'index/'.$this->indexTemplate.'.tpl';

    $this->buildObjects();

    if (file_exists($filename)) {

      $VAR = $this->var;
      $ITEM = $this->objectHtml;
      $WGI = $this->object;
      $TEMPLATE = $this->template;
      $LANG = I18n::getDefault();

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

    } else {
      Error::report
      (
        'Index Template does not exist: '.$filename
      );

      $content = '<p style="errorMessage">Wrong Index Template</p>';
    }

    $this->assembledBody = $content;

    return  $this->assembledBody;

  }//end public function build

} // end class LibParserDocHtml

