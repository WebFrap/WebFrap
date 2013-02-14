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
class LibLexer
  implements Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var array
   */
  protected $catchablePatterns = array();

  /**
   * @var array
   */
  protected $nonCatchablePatterns = array();

  /**
   *
   * @var array
   */
  protected $tokens       = array();

  /**
   * @var array
   */
  protected $rawMatches   = array();

  /**
   * @var LibParserRegistry
   */
  protected $registry    = null;

/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $LibParserRegistry $registry
   */
  public function __construct( $registry = null )
  {
    if( $registry )
      $this->registry  =  $registry;

    $this->loadLexerData();
      
  }//end public function __construct */
  
  /**
   * 
   */
  public function loadLexerData()
  {
    
  }//end public function loadMetaData */


  /**
   * @param LibParserRegistry $registry
   */
  public function setRegistry( $registry )
  {
    $this->registry  =  $registry;
  }//end public function setRegistry */

  /**
   * @param string $key
   */
  public function __get( $key )
  {
    return $this->registry->$key;

  }//end public function __get */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current ()
  {
    return current($this->tokens);
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return key($this->tokens);
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {
    return next($this->tokens);
  }//end public function next */


  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    reset($this->tokens);
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return current($this->tokens)? true:false;
  }//end public function valid */
  


/*//////////////////////////////////////////////////////////////////////////////
// some helper methodes to iterate over the tokens
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * preview the next comming token
   */
  public function preview( $key = null, $skip = false )
  {

    $token = next($this->tokens);
    // set internal pointer back

    if( is_null($key) )
    {
      prev($this->tokens);
      return $token;
    }
    else
    {
      if( $skip )
      {
        if($token[0]==$key)
        {
          return true;
        }
        else
        {
          prev($this->tokens);
          return false;
        }
      }
      else
      {
        prev($this->tokens);
        return ($token[0]==$key);
      }
    }

  }//end public function preview */

  /**
   * go one token back
   */
  public function back()
  {
    return prev($this->tokens);
  }//end public function back */

  /**
   * have a look what the last token was
   */
  public function lookback()
  {
    $token = prev($this->tokens);
    next($this->tokens);

    return $token;

  }//end public function lookback */

  /**
   * @param int $type
   */
  public function expectNext( $type )
  {

    $token = next($this->tokens);

    if(!$token || $type != $token[0] )
    {
      $this->unexpectedToken( $token, $type );
    }

    return $token;

  }//end public function expectNext */

  /**
   * @param $token
   * @param $expected
   * @return array
   */
  public function unexpectedToken( $token, $expected = null, $addInfo = null )
  {

    $message = 'Unexpected '.$this->registry->tokenName($token[0],true).' in line '.$token[2];

    if( $expected )
      $message .= ' expected '.$this->registry->tokenName($expected,true).' instead';

    if( $addInfo )
      $message .= $addInfo;
      
    $message .= ' '.$this->registry->builder->dumpEnv();

    throw new LibParser_Exception($message);

  }//end public function getBodyTokens */

  /**
   * @param int $till
   */
  public function until( $till )
  {

    $token  = $this->next();

    if( false === $token )
      throw new LibParser_Exception( 'Unexpected end of tokens' );

    if( $till != $token[0]   )
    {
      return $token;
    }
    else
    {
      return null;
    }

  }//end public function until */

  /**
   * End of Lexer
   */
  public function eol()
  {
    
    return current($this->tokens)? false:true;
    
  }//end public function eol */
  
  /**
   * reset all tokens
   */
  public function reset()
  {
    reset($this->tokens);
  }//end public function reset */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Countable::count
   */
  public function count()
  {
    return count($this->tokens);
  }//end public function count */


/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $cartridge
   * @return string
   */
  public function split( $raw )
  {
    // real dirty, hrhr but works
    $raw = ' '.$raw;

    // clean old tokens
    $this->tokens = array();
    $this->tokens[] = array(1,'');

    $regex = '/(' .
      implode(')|(', $this->catchablePatterns) . ')|'.
      implode('|', $this->nonCatchablePatterns) . '/i';

    $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
    // PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE

    $this->rawMatches = preg_split( $regex, $raw, -1, $flags);

    $this->createTokens( );

    //if( DEBUG )
    //  Debug::console( 'raw input: ' , $raw);

    //if( DEBUG )
    //  Debug::console( 'created tokens: ' , $this->tokens);

  }//end public function split */

  /**
   * create typed tokens from the raw tokens
   * @param array
   */
  public function createTokens( )
  {

  }//end public function createTokens */

  /**
   *
   */
  public function getTokens()
  {
    return $this->tokens;
  }//end public function getTokens */

  /**
   * @return array
   */
  public function getToken()
  {
    return current($this->tokens);
  }//end public function getToken */

  /**
   * @return array
   */
  public function getRawMatches()
  {
    return $this->rawMatches;
  }//end public function getRawMatches */

  /**
   * @param int $type
   * @param string $value
   */
  public function token( $type , $value, $line )
  {
    return array( $type , $value, $line );
  }//end public function token */


  /**
   * @param int $till
   */
  public function getTokensTill( $till )
  {

    $tokens   = array();
    $proceed  = true;
    
    while( $proceed )
    {

      $token  = $this->next();

      if( false === $token )
        throw new LibParser_Exception( 'PARSER ERROR' );

      $tokens[] = $token;

      if( $till ==  $token[0]   )
        return $tokens;

    }

  }//end protected function getTokensTill */

  /**
   * @param int $left
   * @param int $right
   * @return array<array>
   */
  public function getSurrounded( $left, $right )
  {

    $level    = 0;
    $tokens   = array();
    $proceed  = true;

    $first = $this->next();

    if( $first[0] != $left )
    {
      Debug::console( 'Invalid surounding expected '.$left.' but got '.$first[0] );
      throw new LibParser_Exception( 'Invalid Surounding' );
    }

    $tokens[] = $first;

    while( $proceed )
    {

      $token    = $this->next();

      if( false === $token )
        throw new LibParser_Exception( 'PARSER ERROR' );

      $tokens[] = $token;

      if( $left == $token[0] )
      {
        ++$level;
      }
      elseif( $level && $right == $token[0]  )
      {
        --$level;
      }
      else if (!$level && $right == $token[0] )
      {
        return $tokens;
      }

    }//end while

  }//end protected function getSurrounded */


/*//////////////////////////////////////////////////////////////////////////////
// cleander
//////////////////////////////////////////////////////////////////////////////*/

  public function clean()
  {

    $this->tokens       = array();
    $this->rawMatches   = array();

  }

} // end class LibLexer







