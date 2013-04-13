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
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $rawTokens = array();

  /**
   * @var array
   */
  protected $operators = array(
    '+',
    '-',
    '!',
    '>',
    '<',
    '>=',
    '<=',
    '=',
  );

  /**
   * @var array
   */
  public $stringToken = array();

  /**
   * @var array
   */
  public $numberToken = array();

  /**
   * @var array
   */
  public $tags = array();

  /**
   * @var array
   */
  public $users = array();

  /**
   * @var array
   */
  public $dates = array();

/*//////////////////////////////////////////////////////////////////////////////
// init methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string $searchString
   */
  public function analyse( $searchString )
  {

    /* string
hans wurst #test "#test nochwas" @dominik
     */

    $this->rawTokens = explode(' ', $searchString);

    $lastValue = '';

    foreach( $this->rawTokens as $token ){

      $token = trim($token);

      if( '' === $token )
        continue;

      $fC = $token[0];
      $op = null;

      if ( $token[1] )
      $op = isset($token[1])?;

      if ( '@' === $fC ){
        $this->users[] = $token;
      } else if( '#' === $fC ){
        $this->tags[] = $token;
      } else if( '>' === $fC || '<' === $fC){
        $this->tags[] = $token;
      } else {


        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $token)) {
          $this->dates =
        }

      }




    }


  }//end public function analyse */


  protected function isOperator()
  {

  }


} // end class LibSearchParser

