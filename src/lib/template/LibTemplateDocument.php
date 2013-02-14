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
class LibTemplateDocument extends LibTemplatePresenter
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * content type is undefined
   * must be set in the system
   * @var string
   */
  public $contentType     = null;

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type          = 'document';

  /**
   * the activ index template
   * @var string
   */
  public $indexTemplate = 'document';
  
  /**
   * @var boolean
   */
  public $compressed = false;

  /**
   * Komavar objekt das verwendet wird wenn mit Latex Dokumente generiert werden
   * @var LibDocumentLatexKomavar
   */
  protected $komavar    = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   */
  public function loadView( $key )
  {

    $className   = $key.'_View';

    if (!Webfrap::classLoadable( $className ) )
      $className = 'View'.$key;

    if (!Webfrap::classLoadable( $className ) )
      throw new LibTemplate_Exception('Requested nonexisting View: '.$key );

    $this->subView  = new $className( );

    $this->subView->setI18n( $this->i18n );
    $this->subView->setUser( $this->user );
    $this->subView->setTplEngine( $this );
    $this->subView->setView( $this );
    $this->subView->setParent( $this );

    return $this->subView;

  }//end public function loadView */

  /**
   * @return LibTemplateDataFile
   */
  public function sendFile( )
  {

    if (!$this->file )
      $this->file = new LibTemplateDataFile( );

    return $this->file;

  }//end public function sendFile

  /**
   * @return LibTemplateDataFile
   */
  public function getFile()
  {

    return $this->file;

  }//end public function getFile */

  /**
   * @param LibDocumentLatexKomavar $komavar
   */
  public function setKomavar( $komavar )
  {

    $this->komavar = $komavar;

  }//end public function setKomavar */

  /**
   * @return LibTemplate
   */
  public function getSubView()
  {
    return $this->subView;
  }//end public function getSubView */


  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  public function buildPage( )
  {

    if( trim($this->compiled) != '' )
      return;

    // Parsing Data
    $this->buildBody();

    $this->compiled = $this->assembledBody.NL;

  } // end public function buildPage */


  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  protected function buildMessages( )
  {
    // ignore messages
    return '';

  } // end public function buildMessages */
  

  /**
   * Ausgabe Komprimieren
   */
  public function compress()
  {
    
    if( $this->file )
      return;
    
    $this->compressed = true;
    $this->output = gzencode($this->output);
    
  }//end public function compress */
  
  /**
   * ETag für den Content berechnen
   * @return string
   */
  public function getETag()
  {
    if( $this->file )
    {
      return md5_file($this->file->path);
    } else {
      return md5( $this->output );
    }
    
  }//end public function getETag */
  
  /**
   * Länge des Contents berechnen
   * @return int
   */
  public function getLength()
  {
    
    if( $this->file )
    {
      return filesize( $this->file->path );
    } else {
      if( $this->compressed )
        return strlen( $this->output );
      else
        return mb_strlen( $this->output );
    }
    

  }//end public function getLength */
  

  /**
   * flush the page
   *
   * @return void
   */
  public function compile( )
  {

    if (!$this->file )
    {
      $this->buildPage( );
      $this->output = $this->compiled;
    }


  }//end public function compile */


} // end class LibTemplateDocument

