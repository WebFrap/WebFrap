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
 * Template Areas ermöglichen das Ersezten von HTML Blöcken im Browser anhand
 * von JQery kompatiblen Selectoren.
 * @see http://api.jquery.com/category/selectors/
 *
 * @example
 * set content direct
 * <code>
 * // create new area from the active view
 * $area = $view->newArea( 'keyToIdentifyAreaInTheTpl' );
 * $area->action = 'html';
 * $area->position = '#jueryId';
 * $area->setContent('<p>new content if the node with the id: jueryId</p>');
 * <code>
 *
 * @example
 * use as template container
 * <code>
 * // create new area from the active view
 * $area = $view->newArea( 'keyToIdentifyAreaInTheTpl' );
 * $area->action = 'html';
 * $area->position = '#jueryId';
 *
 * // here you have all possibilities from LibTemplate
 * $area->setTemplate('some/template');
 * $area->addVar('some','Var');
 * <code>
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Dominik Alexander Bonsch <dominik.bonsch@webfrap.net>
 */
class LibTemplateAreaView extends LibTemplateHtml
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * type wird intern verwendet
   * DONT CHANGE as long you don't know what the hell you are doing
   * @var string
   */
  public $type         = 'area';

  /**
   * Aktion ist das Ersetzten des Inhalts eines Elements
   * mögliche Aktionen
   * <ul>
   *  <li>append: append the content at the and of the node / nodes</li>
   *  <li>prepend: prepend the content at the and of the node / nodes</li>
   *  <li>replace:  replace the node / nodes</li>
   *  <li>value: set as value in an input/textarea/select</li>
   *  <li>html: replace the inner html</li>
   *  <li>addClass: add content as class</li>
   *  <li>before: put the content before node / nodes</li>
   *  <li>after: put the content after node / nodes</li>
   *  <li>eval: eval content as javascript</li>
   * <ul>
   * @see also Project:WebFrap_Wgt/js_src/wgt/request/handler/HandlerArea.js
   *
   * @var string
   */
  public $action       = 'html';

  /**
   * ein jquery kompatibler selector
   * @see http://api.jquery.com/category/selectors/
   * @var string
   */
  public $position     = null;

  /**
   * prüft ob ein bestimmter selector nodes zurück gibt
   * wenn ja wird der content entsprechend der gesetzten action ausgewertet
   *
   * ein jquery kompatibler selector
   * @see http://api.jquery.com/category/selectors/
   * @var string
   */
  public $check     = null;

  /**
   * negiert den check,
   * wenn checkNot True ist und ein check Selector vorhanden
   * ist, wird content nur dann platziert/ausgeführt wenn der check selector
   * keine nodes findet
   *
   * @var string
   */
  public $checkNot  = false;

  /**
   * die aktuell vorhandene Standard View
   * @var LibTemplateAjax
   */
  public $view      = null;


/*//////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $position
   * @param string $content
   * @param string $action
   */
  public function __construct($position = null, $content = null, $action = 'html' )
  {

    $this->position = $position;
    $this->action   = $action;

    $this->setContent($content );

    parent::__construct();

  }//end public function __construct */

  /**
   * set the html content
   *
   * @param string $html
   * @return void
   */
  public function setContent($html )
  {
    $this->compiled = $html;
  }//end public function setContent */

  /**
   *
   * @return string
   */
  public function getAction()
  {
    return $this->action;
  }//end public function getAction */

  /**
   *
   * @param $action
   * @return string
   */
  public function setAction($action )
  {
    $this->action = $action;
  }//end public function setAction */

  /**
   *
   * @return string
   */
  public function getPosition()
  {
    return $this->position;
  }//end public function getPosition */

  /**
   *
   * @param $action
   * @return string
   */
  public function setPosition($position )
  {
    $this->position = $position;
  }//end public function setPosition */

  /**
   * @return string
   */
  public function getCheck()
  {
    return $this->check;
  }//end public function getCheck */

  /**
   * @param $check
   * @return string
   */
  public function setCheck($check )
  {
    $this->check = $check;
  }//end public function setCheck */


  /**
   * @return boolean
   */
  public function getCheckNot()
  {
    return $this->checkNot;
  }//end public function getCheckNot */


  /**
   * @param boolean $check
   * @return void
   */
  public function setCheckNot($check )
  {
    $this->checkNot = $check;
  }//end public function setCheck */

/*//////////////////////////////////////////////////////////////////////////////
// Proxy Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * delegate js code in the parent view
   * @see LibTemplate::addJsCode
   */
  public function addJsCode($jsCode)
  {
    $this->parent->addJsCode($jsCode);
  }//end public function addJsCode */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the page
   * @param string $template
   * @param array $PARAMS
   * @return string the assembled page
   */
  public function build($template = null , $PARAMS = array() )
  {

    if ($this->compiled )
      return $this->compiled;

    if (!$template)
      $template = $this->template;

    if (!$filename = $this->templatePath($template  ) ) {

      Error::report
      (
        'Failed to load the template :'.$template
      );

      if ( Log::$levelDebug )
        return "<p class=\"wgt-box error\">Template: $template not exists.</p>";
      else
        return '<p class="wgt-box error">Error Code: 42</p>';

    }

    $VAR       = $this->var;
    $ITEM      = $this->object;
    $ELEMENT   = $this->object;
    $FUNC      = $this->funcs;

    $I18N      = $this->i18n;
    $USER      = $this->user;

    ob_start();
    include $filename;
    $content = ob_get_contents();
    ob_end_clean();

    $this->compiled = $content;

    return $this->compiled;

  } // end public function build


  /**
   * @param string $template
   * @param array $PARAMS
   * @return string
   */
  public function render($template = null , $PARAMS = array() )
  {
    return $this->build($template, $PARAMS );

  }//end public function render */

  /**
   * Parser
   * @param string $template
   * @param array $PARAMS
   * @return String
   */
  public function embed($template , $PARAMS = array() )
  {

    if ($this->compiled )
      echo $this->compiled;

    if (!$filename = $this->templatePath($template ) ) {

      Error::report( 'Failed to load the template :'.$template );

      if ( Log::$levelDebug )
        echo "<p class=\"wgt-box error\">Template: $template not exists.</p>";
      else
        echo '<p class="wgt-box error">Error Code: 42</p>';

      return;
    }

    if ( file_exists($filename ) and is_readable($filename) ) {

      $VAR       = $this->var;
      $ITEM      = $this->object;
      $ELEMENT   = $this->object;
      $FUNC      = $this->funcs;
      $I18N      = $this->i18n;
      $USER      = $this->user;

      ob_start();
      include $filename;
      $this->compiled = ob_get_contents();
      ob_end_clean();

      echo $this->compiled;
    } else {
      echo '!!!template not exists!!!';
    }

  } // end public function embed

  /**
   *
   * @return void
   */
  public function compile(){}

  /**
   *
   */
  protected function buildMessages(){}

} // end class LibTemplateArea

