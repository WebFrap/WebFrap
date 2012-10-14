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
class LibTemplateJson
  extends LibTemplateHtml
{
////////////////////////////////////////////////////////////////////////////////
// Public Methodes
////////////////////////////////////////////////////////////////////////////////


  /**
   *
   * @var string
   */
  public $type         = 'json';

  /**
   *
   * @var string
   */
  public $contentType = 'text/json';

  /**
   *
   * @var array
   */
  protected $data = array
  (
    'head' => array(),
    'body' => null
  );


////////////////////////////////////////////////////////////////////////////////
// Parser Funktionen
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param array $data
   */
  public function setDataBody( $data )
  {
    $this->data['body'] = $data;
  }//end public function setDataBody */

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

    $this->buildMessages();

    $this->compiled = json_encode($this->data);

  } // end public function buildPage */


  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return void
   */
  protected function buildMessages( )
  {

    $pool = $this->getMessage();

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if( $errors = $pool->getErrors() )
    {
      foreach( $errors as $error )
      {
        $this->data['head']['messages']['error'][] = $error;
      }
    }

    if( $warnings = $pool->getWarnings() )
    {
      foreach( $warnings as $warn )
      {
        $this->data['head']['messages']['warning'][] = $warn;
      }
    }


    if( $messages = $pool->getMessages() )
    {
      foreach( $messages as $message )
      {
        $this->data['head']['messages']['message'][] = $message;
      }
    }


  } // end protected function buildMessages */


} // end class LibTemplateAjax */

