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
class LibParser
{
////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////


  /**
   *
   * @var LibBdlLexer
   */
  protected $lexer     = null;

  /**
   *
   * @var LibBdlRegistry
   */
  protected $registry     = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct()
  {

    $this->loadLexer();
    $this->loadRegistry();

  }//end public function __construct */

  /**
   *
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
   * Enter description here ...
   * @param unknown_type $name
   */
  public function setName( $name )
  {
    $this->registry->name = $name;
  }//end public function setName



  /**
   * @return LibGenfName
   */
  public function getName(  )
  {
    return $this->registry->name;
  }//end public function getName */


  public function setNode( $node )
  {
    $this->registry->node = $node;
  }//end public function setNode

  /**
   * @param string $rawCode
   */
  public function split( $rawCode )
  {

    $this->lexer->split( $rawCode );

  }//end public function parse */

  /**
   *
   */
  public function clean()
  {
    $this->registry->name     = null;
  }//end public function clean */

  /**
   * @return array
   */
  public function getTokens()
  {
    return $this->lexer->getTokens();
  }//end public function getTokens */


  /**
   * @return array
   */
  public function getRawMatches()
  {
    return $this->lexer->getRawMatches();
  }//end public function getRawMatches */


  /**
   * @return array
   */
  public function setPadding( $padding )
  {
    $this->registry->setWsPadding( $padding );
  }//end public function setPadding */

} // end class LibParser







