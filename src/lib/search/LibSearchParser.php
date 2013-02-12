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
class LibSearchParser
  extends LibParser
{
////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var LibSearchLexer
   */
  protected $lexer      = null;

  /**
   *
   * @var LibBdlSst
   */
  protected $sst      = null;

  /**
   * the parsed code
   * @var string
   */
  protected $parsed     = null;

////////////////////////////////////////////////////////////////////////////////
// init methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibGenfBuild $builder
   */
  public function __construct(  )
  {

    $this->loadLexer();
    $this->loadSst();
    $this->loadRegistry();

  }//end public function __construct */

  /**
   * load the lexer
   */
  public function loadLexer()
  {

  }//end public function loadLexer */

  /**
   *
   */
  public function loadRegistry()
  {

  }//end public function loadRegistry */

  /**
   *
   */
  public function loadSst()
  {

  }//end public function loadSst */

  /**
   *
   */
  public function cleanWorkspace()
  {

    $this->registry->name     = null;
    $this->registry->context  = null;
    $this->registry->node     = null;

  }//end public function clean */

  /**
   *
   */
  public function clean()
  {

    $this->registry->name     = null;
    $this->registry->context  = null;
    $this->registry->node     = null;

  }//end public function clean */

////////////////////////////////////////////////////////////////////////////////
// parser method
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $rawCode
   */
  public function parse( $rawCode ){ return ''; }

} // end class LibBdlParser
