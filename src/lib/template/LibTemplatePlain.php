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
 * empty implementation
 * @package WebFrap
 * @subpackage tech_core
 */
class LibTemplatePlain
  extends LibTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type         = 'plain';

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * js code an die parent view durchreichen
   *
   */
  public function addJsCode( $jsCode )
  {
    $this->tplEngine->addJsCode( $jsCode );
  }//end public function addJsCode */

  /**
   *
   */
  public function setIndex( $index = 'default' )
  {
    $this->tplEngine->setIndex($index);
  }//end public function setIndex */

  /**
   * @param string $template
   * @param string $template
   */
  public function setTemplate( $template, $inCode = false )
  {
    $this->tplEngine->setTemplate( $template, $inCode );
  }//end public function setTemplate */

  /**
   * @param string $key
   * @param mixed $data
   */
  public function addVar( $key, $data = null)
  {
    $this->tplEngine->addVar( $key, $data );
  }//end public function addVar */

  /**
   * @param array $vars
   */
  public function addVars( $vars )
  {
    $this->tplEngine->addVars( $vars );
  }//end public function addVars */

  /**
   *
   * @return void
   */
  public function build(){}

  /**
   *
   * @return void
   */
  public function compile(){}

  /**
   *
   * @return void
   */
  public function publish(){}

  /**
   *
   */
  protected function buildMessages(){}

} // end class LibTemplateDocument
