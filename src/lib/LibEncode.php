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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibEncode
{
////////////////////////////////////////////////////////////////////////////////
// Static Attributes
////////////////////////////////////////////////////////////////////////////////

  const UTF8 = 'utf-8';

  const ISO_8859_1 = 'ISO-8859-1';

  const ISO_8859_2 = 'ISO-8859-2';

  const ISO_8859_3 = 'ISO-8859-3';

  const ISO_8859_4 = 'ISO-8859-4';

  const ISO_8859_5 = 'ISO-8859-5';

  const ISO_8859_6 = 'ISO-8859-6';

  const ISO_8859_7 = 'ISO-8859-7';

  const ISO_8859_8 = 'ISO-8859-8';

  const ISO_8859_9 = 'ISO-8859-9';

  const ISO_8859_10 = 'ISO-8859-10';

  const ISO_8859_11 = 'ISO-8859-11';

  const ISO_8859_12 = 'ISO-8859-12';

  const ISO_8859_13 = 'ISO-8859-13';

  const ISO_8859_14 = 'ISO-8859-14';

  const ISO_8859_15 = 'ISO-8859-15';

  const ISO_8859_16 = 'ISO-8859-16';

  /**
   * Encoder Objects
   * @var array<LibEncode>
   */
  private static $encoders = array();

////////////////////////////////////////////////////////////////////////////////
// Object Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $from = null;

  /**
   * @var string
   */
  public $to = null;

  /**
   * @var LibI18n
   */
  public $i18n = null;

////////////////////////////////////////////////////////////////////////////////
// static getter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $from
   * @param string $to
   */
  public static function getEncoder( $to, $from = null )
  {

    if( !$from )
      $from = LibEncode::UTF8;

    if( isset( self::$encoders[$from.'-'.$to] ) )

      return self::$encoders[$from.'-'.$to];

    if( $to == $from )
      self::$encoders[$from.'-'.$to] = new LibEncodeDummy();
    else
      self::$encoders[$from.'-'.$to] = new LibEncode( $from, $to );

    return self::$encoders[$from.'-'.$to];

  }//end public static function getEncoder */

  /**
   * @param string $from
   * @param string $to
   */
  public function __construct( $from, $to )
  {

    $this->from = $from;
    $this->to = $to;

    $this->i18n = Webfrap::$env->getI18n();

  }//end public function __construct */

  /**
   * check for hidden redirects in the url
   * @return void
   */
  public function encode( $string )
  {

    if( LibEncode::UTF8 == $this->from )

      return utf8_decode( $string );
    else
      return utf8_encode( $string );

  }//end function function encode */

  /**
   * check for hidden redirects in the url
   * @return void
   */
  public function i18n( $key, $repo, $data = array() )
  {

    if( LibEncode::UTF8 == $this->from )

      return utf8_decode( $this->i18n->l( $key, $repo, $data ) );
    else
      return utf8_encode( $this->i18n->l( $key, $repo, $data ) );

  }//end function function i18n */

}//end class LibEncode
