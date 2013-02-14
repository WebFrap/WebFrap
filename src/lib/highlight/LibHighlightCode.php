<?php
/*******************************************************************************
*
* @author      : Ralf Kronen <ralf.kronen@webfrap.net>
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
 * @subpackage Developer
 */
class LibHighlightCode extends LibVendorGeshi
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var LibHighlightCode
   */
  public static $instance = null;

  /**
   *
   * @var string
   */
  public $code = null;

  /**
   *
   * @var string
   */
  public $highlighted = null;

  /**
   *
   * @var string
   */
  public $language = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $code
   * @return unknown_type
   */
  public function __construct($code = null , $language = null )
  {
    $this->code = $code;
    $this->language = $language;
  }//end public function __construct($code = null , $language = null )

  /**
   * @param string $code
   */
  public function setCode($code )
  {
    $this->code = $code;
  }//end public function setCode($code )

  /**
   *
   * @param string $language
   */
  public function setLanguage($language )
  {
    $this->language = $language;
  }//end public function setLanguage($language )

  /**
   * @return string
   */
  public function getHighlighted( )
  {
    return $this->highlighted;
  }//end public function setHighlighted( )

  /**
   *
   * @param $code
   * @param $language
   * @return unknown_type
   */
  public function parse($code = null , $language = null )
  {

    if (!$code )  $code = $this->code;
    if (!$language ) $language = $this->language;

    $this->highlighted = $this->highlightCode($code , $language );
    return $this->highlighted;

  }//end public function parse($code = null )

  /**
   *
   * @param $code
   * @param $language
   * @return unknown_type
   */
  public static function highlight($code, $language )
  {

    if (!self::$instance) self::$instance = new LibHighlightCode();
      return self::$instance->parse($code, $language );

  }//end public function parse($code = null )

} // end class LibHighlightCode

