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
class LibTemplateAjax
  extends LibTemplateHtml
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var string
   */
  public $type          = 'ajax';

  /**
   * @lang de:
   *
   * Adresse für eine Weiterleitung über das Ajax Interface im Client
   * @var string
   */
  public $redirectUrl   = null;

  /**
   *
   * @var string
   */
  public $contentType   = 'text/xml';


  /**
   * serialized json data
   * @var string
   */
  public $jsonData      = null;

  /**
   * @var string
   */
  public $returnType    = 'json';

/*//////////////////////////////////////////////////////////////////////////////
// Protected Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the assembled actions
   *
   * @var string
   */
  protected $assembledActions = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $redirectUrl
   * @return void
   */
  public function redirect( $redirectUrl )
  {

    $this->redirectUrl = $redirectUrl;

  }//end public function redirect */

  /**
   * @param string $jsonData
   */
  public function setJsonData( $jsonData )
  {

    $this->jsonData = $jsonData;

  }//end public function setJsonData */

  /**
   * @param string $jsonData
   */
  public function setRawJsonData( $jsonData )
  {

    $this->jsonData = json_encode( $jsonData );

  }//end public function setRawJsonData */

  /**
   * @param string $jsonData
   * @param string $type
   */
  public function setReturnData( $jsonData, $type  )
  {

    $this->returnType = $type;
    $this->jsonData   = $jsonData;

  }//end public function setReturnData */

/*//////////////////////////////////////////////////////////////////////////////
// Buildr Funktionen
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  public function buildPage( )
  {

    if( $this->compiled )
      return;

    $this->compiled = '';
    $this->output   = '';

    Log::verbose( 'Start building the Page' );

    $this->compiled = $this->buildBody( );

  }//end public function buildPage */


  /**
   * @return string
   */
  public function buildWindows()
  {

    $html = '';

    foreach( $this->windows as $window )
    {
      $html .= $window->build();
    }

    return $html;

  }//end public function buildWindows()

  /**
   * include the main part of the page in the index
   *
   * @param string $template
   * @param string $content
   * @return string
   */
  public function includeBody( $template, $content = null )
  {

    if( !$filename = $this->bodyPath( $template ) )
    {
      Error::addError('failed to load the body template: '.$template );
      return '<p class="wgt-box error">failed to load the body</p>';
    }

    $TITLE     = $this->title;

    $VAR       = $this->var;
    $AREA      = $this->area;
    $FUNC      = $this->funcs;
    $ITEM      = $this->object;

    $I18N      = $this->i18n;
    $USER      = $this->user;

    // Build the page hehe
    ob_start();
    include $filename;
    $content = ob_get_contents();
    ob_end_clean();
    //\ Build the page hehe

    return $content;

  }// end public function includeBody */

  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return string
   */
  protected function buildMessages( )
  {

    $pool = Message::getActive();

    $html = '';

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if( $errors = $pool->getErrors() )
    {
      $html .= '<error><![CDATA['.NL;

       foreach( $errors as $error )
        $html .= $error.'<br />'.NL;

      $html .= ']]></error>';
    }

    if( $warnings = $pool->getWarnings() )
    {
      $html .= '<warning><![CDATA['.NL;

      foreach( $warnings as $warn )
        $html .= $warn."<br />".NL;

      $html .= ']]></warning>';
    }


    if( $messages = $pool->getMessages() )
    {
      $html .= '<message><![CDATA['.NL;

       foreach( $messages as $message )
          $html .= $message.'<br />'.NL;

      $html .= ']]></message>'.NL;
    }

    // Meldungen zurückgeben
    return $html;

  } // end protected function buildMessages */


  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return string
   */
  protected function buildWallmessage( )
  {

    $html = '';

    if( $this->wallMessage )
    {
      $html .= '<wall_message><![CDATA['.NL;
      $html .= $this->wallMessage;
      $html .= ']]></wall_message>'.NL;
    }

    // Meldungen zurückgeben
    return $html;

  } // end protected function buildWallmessage */

  /**
   * build the body
   * @return string
   *
   */
  public function buildBody( )
  {

    if( $filename = Webfrap::templatePath( 'ajax', 'index' ) )
    {

      if( $this->jsCode )
      {

        $this->assembledJsCode = '';

        foreach( $this->jsCode as $jsCode )
        {
          if( is_object($jsCode) )
            $this->assembledJsCode .= $jsCode->getJsCode();
          else
            $this->assembledJsCode .= $jsCode;
        }

      }


      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();


      $this->assembledBody = $content;
    }
    else
    {
      Error::addError('failed to load the body');

      $this->assembledBody = file_get_contents
      (
        PATH_FW.'templates/index/ajax_failed.tpl'
      );

    }

    return $this->assembledBody;


  }// end public function buildBody */

  /**
   *
   * @return string
   */
  public function buildIndex( )
  {

    if( $filename = Webfrap::templatePath( $this->indexTemplate, 'index' ) )
    {

      if( Log::$levelVerbose )
        Log::verbose(__file__ , __line__, 'Parsing index: '.$filename );

      if( DEBUG )
        Debug::console( 'Parsing index: '.$filename );

      $stop      = true; // block
      $VAR       = $this->var;
      $FUNC      = $this->funcs;
      $ITEM      = $this->object;
      $AREA      = $this->area;

      $MESSAGES  = '';
      $TEMPLATE  = $this->template;
      $FOOTER    = $this->footer;

      $I18N      = $this->i18n;
      $USER      = $this->user;
      $URL       = $this->url;

      ob_start();
      include $filename;

      $content = ob_get_contents();
      ob_end_clean();

    }
    else
    {
      Error::addError( 'Index Template not exists: '.$filename );

      if( Log::$levelDebug )
        $content = '<p class="wgt-box error">Wrong Index Template: '.$filename.' </p>';
      else
        $content = '<p class="wgt-box error">Wrong Index Template</p>';

    }

    $this->assembledBody = $content;

    return $this->assembledBody;

  }//end public function buildIndex */



}//end class LibTemplateAjax */

