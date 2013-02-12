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
class LibParserRegistry
{
////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var array
   */
  protected $registry     = array();

  /**
   *
   * @var string
   */
  protected $parserType   = null;

  /**
   *
   * @var LibLexer
   */
  protected $lexer        = null;

  /**
   * mapping list for all tokens / classes
   * @var array
   */
  protected $tokenParserClass = array();

  /**
   *
   * @var LibGenfName
   */
  public $name            = null;

  /**
   * the parsed code
   * @var string
   */
  public $ws              = '';

  /**
   * the parsed code
   * @var string
   */
  public $wsFactor        = 2;

  /**
   * the parsed code
   * @var string
   */
  public $wsCount         = 0;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $parserType
   * @param string $lexer
   */
  public function __construct( $parserType, $lexer )
  {

    $this->parserType   = $parserType;
    $this->lexer        = $lexer;
    $this->init();

    // reconnection
    $this->lexer->setRegistry( $this );

  }//end public function __construct */

  /**
   * @param string $key
   */
  public function __get( $key )
  {
    return isset($this->lexer->tokenType[$key])
      ? $this->lexer->tokenType[$key]
      : null;
  }//end public function __get */

  /**
   * @param string $key
   */
  public function tokenName( $key , $strong = false )
  {
    $data = array_search( $key, $this->lexer->tokenType );

    if(!$data)

      return null;

    if ($strong) {
      return "<strong>".strtoupper($data)."</strong>";
    } else {
      return $data;
    }

  }//end public function tokenName */

////////////////////////////////////////////////////////////////////////////////
// getter + setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $tokenKey
   * @return LibSubParser
   */
  public function getTokenParser( $tokenKey )
  {

    if( is_array($tokenKey))
      $tokenKey = $tokenKey[0];

    // well if that happens we maybe have a problem
    // but ca be that we just want to fallback to a default parser
    if ( !isset( $this->tokenParserClass[$tokenKey] ) ) {
      throw new LibParser_Exception('Requested nonextisting Tokenparser : '.$tokenKey);
    }

    return $this->getSubParser( $this->tokenParserClass[$tokenKey] );

  }//end public function getTokenParser */

  /**
   * @param string $key
   */
  public function getSubParser( $key )
  {

    if ( isset( $this->registry[$key] ) ) {
      return $this->registry[$key];
    }

    $className = $this->parserType.$key;

    if ( Webfrap::classLoadable( $className ) ) {
      $subParser            = new $className( $this , $this->lexer );
      $this->registry[$key] = $subParser;

      return $subParser;
    } else {
      throw new LibParser_Exception('Requested nonextisting Subparser Class: '.$className);
    }

  }//end public function getSubParser */

  /**
   * @param string $key
   */
  public function getSubCompiler( $key )
  {

    if ( isset( $this->registry[$key] ) ) {
      return $this->registry[$key];
    }

    $className = $this->parserType.$key;

    if ( Webfrap::classLoadable( $className ) ) {
      $subParser            = new $className( $this, $this->lexer );
      $this->registry[$key] = $subParser;

      return $subParser;
    } else {
      throw new LibParser_Exception( 'Requested nonextisting Subparser Class: '.$className );
    }

  }//end public function getSubCompiler */

  /**
   * @param LibGenfName $name
   */
  public function setName( $name )
  {
    $this->name = $name;
  }//end public function setName */

  /**
   * @return LibGenfName
   */
  public function getName(  )
  {
    return $this->name;
  }//end public function getName */

  /**
   * init method
   */
  protected function init()
  {

  }//end protected function init */

  /**
   *
   */
  public function setWsPadding( $count )
  {
    $this->wsCount = $count;
    $this->ws = str_pad( ' ', ( $this->wsFactor * $this->wsCount ) );
  }//end public function setWsPadding */

  /**
   *
   * Enter description here ...
   */
  public function wsInc()
  {
    ++$this->wsCount;
    $this->ws = str_pad( ' ', ( $this->wsFactor * $this->wsCount ) );
  }//end public function wsInc */

  /**
   *
   * Enter description here ...
   */
  public function wsDec()
  {
    --$this->wsCount;
    $this->ws = str_pad( ' ', ( $this->wsFactor * $this->wsCount ) );
  }//end public function wsDec */

} // end class LibParserRegistry
