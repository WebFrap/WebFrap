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
class LibTemplateCli extends Pbase
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the content type
   * @var string
   */
  public $contentType   = 'text/plain';

  /**
   * @var string
   */
  public $type          = 'cli';

  /**
   * the configuration
   * @var array
   */
  public $conf          = array();

  /**
   * the activ index template
   * @var string
   */
  public $indexTemplate = null;

  /** The main Template
   * @var string
   */
  public $template      = null;

  /** 
   * Flag if the template in the codepath or in the global template path
   * @var boolean
   */
  public $codePath      = false;

  /**
   * @var Model
   */
  public $model = null;

  /**
   * @var TDataObject
   */
  protected $var      = array();

  /**
   * @var TDataObject
   */
  protected $object   = array();

  /**
   * @var LibTemplate
   */
  protected $subView = null;



/*//////////////////////////////////////////////////////////////////////////////
// Template Part
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the contstructor
   * @param array $conf the configuration loaded from the conf
   */
  public function __construct($conf = array() )
  {

    $this->var     = new TDataObject();
    $this->object  = new TDataObject();
    //$this->area    = new TDataObject();
    //$this->funcs   = new TTrait();

    $this->tplConf    = $conf;
    $this->i18n    = I18n::getActive();

    // load response
    $this->getResponse();

    $this->env = Webfrap::getActive();

  }// end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Template Part
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @return string
   */
  public function getType( )
  {
    
    return $this->type;
    
  }//end public function getType */

  /**
   * @param Model $model
   */
  public function setModel($model )
  {
    $this->model = $model;
  }//end public function setModel */

  /**
   * @param string $key
   */
  public function loadView($key )
  {

    $className = $key.'_View';

    if (!Webfrap::loadable($className) )
      throw new LibTemplate_Exception('Requested nonexisting View '.$key );

    $this->subView  = new $className();

    $this->subView->setI18n($this->i18n );
    $this->subView->setUser($this->user );
    $this->subView->setTplEngine($this );
    $this->subView->setView($this );

    return $this->subView;

  }//end public function loadView */


  /**
   * add variables in the view namespace
   *
   * @param array/string $key Content $key Einen Array mit Content für die Seite
   * @param string $data Die Daten für ein bestimmtes Feld
   * @return void
   */
  public function addVar($key, $data = null )
  {

    if ( is_scalar($key) )
    {
      $this->var->content[$key] = $data;
    }
    elseif ( is_array($key) )
    {
      $this->var->content = array_merge($this->var->content, $key );
    }

  } // end public function addVar  */

  /**
   * Content für die Seite hinzufügen
   *
   * @param array/string Content Einen Array mit Content für die Seite
   * @param string Data Die Daten für ein bestimmtes Feld
   * @return WgtItemAbstract
   */
  public function newItem($key, $type  )
  {

    if ( isset($this->object->content[$key]) )
    {
      return $this->object->content[$key];
    }
    elseif ( is_object($type) )
    {
      $this->object->content[$key] = $type;
      return $type;
    } else {

      $className     = $type;

      if (!WebFrap::loadable($className) )
        throw new WgtItemNotFound_Exception( 'Item '.$className.' is not loadable' );

      $object        = new $className($key);
      $object->view  = $this; // add back reference to the owning view
      $object->i18n  = $this->i18n;

      $this->object->content[$key] = $object;

      if (DEBUG)
        Debug::console('Created Item: '.$className .' key: '.$key );

      return $object;

    }

  } // end public function newItem */

  /**
   *
   * @param string $key
   * @param string $type
   * @return WgtInput
   */
  public function newInput($key, $type )
  {

    if ( isset($this->object->content[$key]) )
    {
      return $this->object->content[$key];
    }
    elseif ( is_object($type) )
    {
      $this->object->content[$key] = $type;
      return $type;
    } else {
      $className = 'WgtInput'.ucfirst($type);

      if (!WebFrap::loadable($className) )
      {
        throw new WgtItemNotFound_Exception( 'Class '.$className.' was not found' );
      } else {
        $object = new $className($key);
        $this->object->content[$key] = $object;

        if (DEBUG)
          Debug::console('Created Input: '.$className. ' key '.$key);

        return $object;
      }
    }

  } // end public function newInput */

/*//////////////////////////////////////////////////////////////////////////////
// method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * write
   * @param string $content
   */
  public function write($content )
  {
    $this->response->write($content);
  }//end public function write */

  /**
   * @param string $content
   */
  public function writeLn($content )
  {
    $this->response->writeLn($content);
  }//end public function writeLn */

  /**
   * @param string $content
   */
  public function writeErr($content )
  {
    $this->response->writeErr($content);
  }//end public function writeErr */

  /**
   * @param string $content
   */
  public function writeErrLn($content )
  {
    $this->response->writeErrLn($content);
  }//end public function writeErr */

  /**
   *
   */
  public function printHelp()
  {
    $this->response->writeLn('Help');
  }//end public function printHelp */

  /**
  * @param string $message
  * @param mixed $dump
   */
  public static function printErrorPage($message, $dump )
  {

    $this->response->writeLn($message);
    $this->response->writeLn($dump);
  }//end public function printHelp */

  /**
   * @param string $content
   */
  public function setTitle($content )
  {
    $response = $this->getResponse();
    $response->writeLn($content );
  }//end public function setTitle */

 /**
  *
  * @param string $template
  * @param boolean $inCode
  * @return void
  */
  public function setTemplate($template, $inCode = false  )
  {
    $this->template = $template;
    $this->codePath = $inCode;
  }// end public function setTemplate */

/*//////////////////////////////////////////////////////////////////////////////
// meta informations
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * the design to use
  *
  * @param string/array $type Template Name des Maintemplates
  * @return void
  */
  public function isType($type  )
  {

    if ( is_array($type ) )
    {

      foreach($type as $key )
      {
        if ($this->type === $key )
          return true;
      }

     return false;

    } else {
      return ($this->type === $type);
    }

  }//end public function isType */




} // end class LibTemplateCli */

