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
class LibTemplateHtmlError
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var int
   */
  protected static $errorCode = '500';

  /**
   * Enter description here...
   *
   * @var string
   */
  protected static $errorMessage = null;

  /**
   * Enter string here...
   *
   * @var string
   */
  protected static $title = 'An Error occured';

  /**
   * Enter description here...
   *
   * @var string
   */
  protected static $index = 'error_plain';

  /**
   * Enter description here...
   *
   * @var string
   */
  protected static $template = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * name of the index
   *
   * @param string $index
   */
  public static function setIndex($index )
  {

    self::$index = $index;
  }//end public static function setIndex */

  /**
   * name of the template
   *
   * @param string $template
   */
  public static function setTemplate($template, $inCode = false )
  {

    self::$template = $template;

  }//end  public static function setTemplate */

/*//////////////////////////////////////////////////////////////////////////////
// Print Error Pages
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $errorMessage
   * @param int $errorCode
   */
  public static function printErrorPageXml($errorMessage , $errorCode = null )
  {

    self::$errorMessage = $errorMessage;

    if ($errorCode) {
      self::$errorCode = $errorCode;
    }

    $filename = $this->templatePath( self::$index , 'index' );

    if ( file_exists($filename ) and is_readable($filename) ) {

      $TITLE         = self::$title;
      $ERROR_MESSAGE = self::$errorMessage;
      $ERROR_CODE    = self::$errorCode;
      $TEMPLATE      = 'errors/xml_'.$errorCode;

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      echo $content;
    } else {
      Error::addError
      (
      'failed to load the body'
      );

      echo '<service><error>!FATAL ERROR!: '.$errorMessage.'</error></service>';
    }

  }//end public static function printErrorPage */

  /**
   * Enter description here...
   *
   * @param string $errorMessage
   * @param int $errorCode
   */
  public static function printErrorPage($errorMessage , $errorCode = null , $data = null )
  {

    self::$errorMessage = $errorMessage;

    if ($errorCode) {
      self::$errorCode = $errorCode;
    }

    $filename = $this->templatePath( self::$index , 'index' );

    if ( file_exists($filename ) and is_readable($filename) ) {

      $TITLE         = self::$title;
      $ERROR_MESSAGE = self::$errorMessage;
      $ERROR_CODE    = self::$errorCode;
      $TEMPLATE      = 'errors/http_'.$errorCode;
      $MESSAGE       = $data;

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      echo $content;
    } else {
      Error::addError
      (
      'failed to load the body'
      );
      echo '<h1>!FATAL ERROR! failed to load index !FATAL ERROR!</h1>';
    }

  }//end public static function printErrorPage */

  /**
   * Enter description here...
   *
   * @param string $template
   * @return string
   */
  public static function includeBody($template )
  {

    if (!$filename = $this->bodyPath($template)) {
      Error::addError('failed to load the body template: '.$template );

      return '<p class="wgt-box error">failed to load the body</p>';
    }

    if ( file_exists($filename ) and is_readable($filename) ) {

      $TITLE         = self::$title;
      $ERROR_MESSAGE = self::$errorMessage;
      $ERROR_CODE    = self::$errorCode;

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      return $content;
    } else {
      Error::addError
      (
      'failed to load the body'
      );

      return '<p style="errorMessage">failed to load the error Body '.$template.' </p>';
    }

  }// end public static function includeBody */

} // end class ViewHtmlError

