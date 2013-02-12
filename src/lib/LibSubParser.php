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
class LibSubParser
{
////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var LibParserRegistry
   */
  protected $registry   = null;

  /**
   *
   * @var LibBdlLexer
   */
  protected $lexer      = null;


  /**
   * @var Tarray
   */
  protected $flag      = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibParserRegistry $registry
   * @param LibLexer $lexer
   */
  public function __construct( $registry ,  $lexer )
  {

    $this->registry     = $registry;
    $this->lexer        = $lexer;

    $this->flag         = new TArray();

  }//end public function __construct */

  /**
   * @param string $key
   */
  public function __get( $key )
  {
    return $this->registry->$key;
  }//end public function __get */

  /**
   * @param LibGenfName $name
   */
  public function setName( $name )
  {
    $this->registry->setName($name);
  }//end public function setName */

  /**
   * @return LibGenfName
   */
  public function getName(  )
  {
    return $this->registry->getName();
  }//end public function getName */

  /**
   * @return string
   */
  public function line( $code )
  {
    return $this->registry->ws.$code.NL;
  }//end public function line */


  /**
   * @return sline
   */
  public function sLine( $code )
  {
    return $this->registry->ws.$code;
  }//end public function line */

  /**
   * @return string
   */
  public function cLine( $code )
  {
    return $code.NL;
  }//end public function cline */

  /**
   * @return string
   */
  public function nl(  )
  {
    return NL;
  }//end public function cline */

  /**
   * @return string
   */
  public function string( $code )
  {
    return '"'.$code.'"';
  }//end public function string */

  /**
   *
   * Enter description here ...
   */
  public function wsInc(  )
  {
    $this->registry->wsInc();
  }//end public function wsInc */

  /**
   *
   * Enter description here ...
   */
  public function wsDec(  )
  {
    $this->registry->wsDec();
  }//end public function wsDec */

} // end class LibParser







