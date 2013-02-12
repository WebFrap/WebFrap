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
class LibTemplateMail
  extends LibTemplateHtml
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var string
   */
  public $type         = 'mail';

  /**
   * standardaction ist das ersetzten des Inhalts eines Elements
   * @var string
   */
  public $action       = 'html';

  /**
   * standardaction ist das ersetzten des Inhalts eines Elements
   * @var string
   */
  public $position     = null;

  /**
   * die aktuell vorhandene Standard View
   * @var LibTemplateAjax
   */
  public $view          = null;

////////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * set the html content
   *
   * @param string $html
   * @return void
   */
  public function setContent( $html )
  {
    $this->compiled = $html;
  }//end public function setContent */

////////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the page
   *
   * @return string the assembled page
   */
  public function build( $template = null , $PARAMS = array() )
  {

    if( $this->compiled )

      return $this->compiled;

    if(!$template)
      $template = $this->template;

    if ( !$filename = $this->templatePath( $template  ) ) {

      Error::report
      (
      'Failed to load the template :'.$template
      );

      if( Log::$levelDebug )

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

  } // end public function build */

  /**
   * @return void
   */
  public function compile(){}

  /**
   * @return void
   */
  public function publish(){}

  /**
   *
   */
  protected function buildMessages(){}

} // end class LibTemplateMail
