<?php
/*******************************************************************************
*
* @author      : Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
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
 * Latex rednerer Klasse für das Webfrap Templatesystem
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
 */
abstract class LibDocumentLatex
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Temporärer Name für das erzeugte Latex Dokument
   * @var string
   */
  protected $texFile  = null;

  /**
   * Name des Ordners in dem die ganzen Latex Dateien inlcusive log etc angelegt
   * werden
   * @var string
   */
  protected $tmpFolder = null;

  /**
   * Wenn saveFilename gesetzt wird, wird nach dem erfolgreichen Build des
   * Dokuments das Dokument in den Angegebenen Pfad kopiert
   *
   * @var string
   */
  protected $saveFilename = null;

  /**
   * Die Template Engine
   *
   * @var LibTemplateDocument
   */
  protected $tpl = null;

/*//////////////////////////////////////////////////////////////////////////////
// Build Logik
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzen des Dateinamens der verwendet werden soll, wenn dieses Dokument
   * nicht nur on the fly erzeugt sondern auch gespeichert werden soll.
   *
   * @param string $filename
   */
  public function setSaveFilename( $filename )
  {

    $this->saveFilename = $filename;

  }//end public function setSaveFilename */

  /**
   * @param string $tmpFolder
   */
  public function setTmpFolder( $tmpFolder )
  {

    $this->tmpFolder = $tmpFolder;

  }//end public function setTmpFolder */

  /**
   * @param LibTemplateDocument $tplObject
   */
  public function setTpl( $tplObject )
  {

    $this->tpl = $tplObject;

  }//end public function setTpl */

  /**
   * @param string $texFile
   */
  public function setTexFile( $texFile )
  {

    $this->texFile = $texFile;

  }//end public function setTexFile */


/*//////////////////////////////////////////////////////////////////////////////
// Build Logik
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Bauen eines Texfiles mit der injecteten View
   */
  public function build()
  {

    $this->buildTemplate();
    $this->buildDocument();

  }//end public function build */


  /**
   * Bauen eines Texfiles mit der injecteten View
   */
  public function buildTemplate()
  {

    if (!$this->tmpFolder )
      $this->tmpFolder = PATH_GW.'tmp/latext/'.Webfrap::tmpFolder().'/';

    SFilesystem::mkdir( $this->tmpFolder );

    $this->tpl->buildIndexTemplate( );
    $this->tpl->savePage( $this->tmpFolder.$this->texFile.'.tex' );

  }//end public function buildTemplate */

  /**
   * Bauen des Latex Dokuments
   */
  public function buildDocument()
  {

    $process = new LibSystemProcess(  );

    // -output-directory

    // beachten das alle files absolut eingebunden werden müssen
    // bitte die passenden Konstanten in den Templates dazu verweden

    $process->call
    (
      'pdflatex',
      $this->texFile.'.tex',
      $this->tmpFolder
    );

    if( $this->saveFilename )
    {
      SFilesystem::copy( $this->tmpFolder.$this->texFile.'.tex' ,  $this->saveFilename );
    }

  }//end public function buildDocument */

  /**
   * Das generierte File über die View versenden
   * @param LibTemplateDocument $tpl
   */
  public function sendFile( $tpl = null )
  {

    if (!$tpl )
      $tpl = $this->tpl;

    $file = $this->tpl->sendFile();

    $file->type = 'application/pdf';
    //$file->type = 'text/plain';

    $file->path = $this->tmpFolder.$this->texFile.'.pdf';
    $file->name = $this->texFile.'.pdf';

    /*
    $file->tmp = true;
    $file->tmpFolder = $this->tmpFolder;
    */

  }//end public function sendFile */

  /**
   * Das generierte File über die View versenden
   * @param LibTemplateDocument $tpl
   */
  public function copy( $target )
  {

    SFilesystem::copy( $this->tmpFolder.$this->texFile.'.pdf' ,  $target );

  }//end public function copy */

  /**
   * Die Temporären Daten die beim erstellen des PDFs erstellt wurden löschen
   */
  public function cleanTmp(  )
  {

    SFilesystem::delete( $this->tmpFolder );

  }//end public function cleanTmp */

} // end class LibTemplateLatex

