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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var Model
   */
  protected $model = null;

  /**
   * @var LibTemplate
   */
  protected $view = null;

  /**
   * @var User
   */
  protected $user = null;

  /**
   * @var I18n
   */
  protected $i18n = null;

  /**
   * @var Conf
   */
  protected $conf = null;

  /**
   * Pfad zum Template
   * @var string
   */
  protected $template = null;

  /**
   * @var TDataObject
   */
  protected $var      = null;

  /**
   * @var TDataObject
   */
  protected $element  = null;

  /**
   * Der HTTP status des angefragten Contents
   * @var int
   */
  public $status = 200;

  /**
   * Content wenn das Template schon gerendert wurde
   * @var string
   */
  public $rendered = null;
  
  /**
   * Befindet sich das Template beim Code oder
   * im templates folder?
   *
   * @since 0.9.2
   * @var string
   */
  public $tplInCode      = false;

/*//////////////////////////////////////////////////////////////////////////////
// Abstract Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render()
  {
    return $this->renderTemplate();
  }//end public function render */

  /**
   * @deprecated use render
   * @return string
   */
  public function build()
  {
    return $this->render();
  }//end public function build */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function __construct($view = null  )
  {

    $this->view    = $view;
    $this->var     = new TDataObject();
    $this->element = new TDataObject();

  }//end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->render();
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Model $model
   */
  public function setModel($model)
  {
    $this->model = $model;
  }//end public function setModel */

  /**
   * @param LibTemplate $view
   */
  public function setView($view)
  {
    $this->view = $view;
  }//end public function setView */

  /**
   * @param User $user
   */
  public function setUser($user)
  {
    $this->user = $user;
  }//end public function setUser */

  /**
   * @return User
   */
  public function getUser()
  {

    if (!$this->user)
      $this->user = Webfrap::$env->getUser();

    return $this->user;

  }//end public function getUser */

  /**
   * @param I18n $i18n
   */
  public function setI18n($i18n)
  {
    $this->i18n = $i18n;
  }//end public function setI18n */

  /**
   * @return I18n
   */
  public function getI18n()
  {

    if (!$this->i18n)
      $this->i18n = Webfrap::$env->getI18n();

    return $this->i18n;

  }//end public function getI18n */

  /**
   * @param LibConfPhp $conf
   */
  public function setConf($conf)
  {
    $this->conf = $conf;
  }//end public function setConf */

  /**
   * @return LibConfPhp
   */
  public function getConf()
  {

    if (!$this->conf)
      $this->conf = Webfrap::$env->getConf();

    return $this->conf;

  }//end public function getConf */

  /**
   * de:
   *
   * hinzufügen von Template-Variablen
   *
   * diese Variablen sind im Template später über <?php $VAR ?>
   *
   *
   * @param array $vars
   * @return void
   */
  public function addVars($vars)
  {

    $this->var->content = array_merge($this->var->content, $vars);

  } // end public function addVars  */

  /**
   * add variables in the view namespace
   *
   * @param array/string $key Content $key Einen Array mit Content für die Seite
   * @param string $data Die Daten für ein bestimmtes Feld
   * @return void
   */
  public function addVar($key, $data = null)
  {

    if (is_scalar($key)) {
      $this->var->content[$key] = $data;
    } elseif (is_array($key)) {
      $this->var->content = array_merge($this->var->content, $key);
    }

  } // end public function addVar  */

  /**
   * add variables in the view namespace
   *
   * @param array/string $key Content $key Einen Array mit Content für die Seite
   * @param string $data Die Daten für ein bestimmtes Feld
   * @return void
   */
  public function addElement($key, $data)
  {

    $this->element->content[$key] = $data;

  } // end public function addElement  */

  /**
   * @param string $content
   */
  public function setContent($content)
  {
    $this->rendered = $content;
  }//end public function setContent */

  /**
   * @param string $template
   */
  public function setTemplate($template, $inCode = false)
  {
    $this->template = $template;
    $this->tplInCode = $inCode;
  }//end public function setTemplate */

  /**
   * Methode zum finden des passende Templates
   * Templates können sich an 3 Orten befinden
   * Theme Templates überschreiben dabei Modultemplates und diese wiederrum
   * generierte Theme Templates in Sandbox
   *
   * @param string $file
   * @param string $folder
   * @return string
   */
  public function templatePath($file , $type = 'content')
  {
    // use the webfrap template
    return WebFrap::templatePath( $file , $type, $this->tplInCode);

  }//end public function templatePath */

  /**
   * @param string $template
   * @return string
   */
  public function renderTemplate($template = null, $isCodeTpl = true)
  {

    if (!is_null($this->rendered))
      return $this->rendered;
    
    $this->tplInCode = $isCodeTpl;

    if (!$template)
      $template = $this->template;

    if ($filename = $this->templatePath($template)) {

      $VAR       = $this->var;
      $ELEMENT   = $this->element;

      $I18N      = $this->getI18n();
      $USER      = $this->getUser();
      $CONF      = $this->getConf();

      if (Log::$levelVerbose)
        Log::verbose("Load Index Template: $filename ");

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

    } else {
      Error::report('Index Template does not exist: '.$template);

      ///TODO add some good error handler here
      if (Log::$levelDebug)
        $content = '<p class="wgt-box error">Wrong Template: '.$template.' ('.$filename.')  </p>';
      else
        $content = '<p class="wgt-box error">Wrong Template '.$template.' </p>';

    }

    $this->rendered = $content;

    return $content;

  }//end public function renderTemplate */

  /**
   * @param string $name
   * @param string $alt
   * @param string $size
   * @return string
   */
  public function icon($name, $alt, $size = 'xsmall')
  {
    return Wgt::icon($name, $size, array('alt'=>$alt));

  }//end public function icon */

  /**
   * @param string $name
   * @param string $param
   * @param boolean $flag
   * @return string
   */
  public function image($name, $param, $flag = false)
  {
    return Wgt::image($name, array('alt'=>$param),true);

  }//end public function image */

}//end class WgtTemplate

