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
class LibDocumentPdf extends LibVendorFpdf
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Name des Ordners in dem die ganzen Latex Dateien inlcusive log etc angelegt
   * werden
   * @var string
   */
  protected $tmpFolder = null;
  
  /**
   * Temp Filename
   * @var string
   */
  protected $tmpFile = null;

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
  public function setSaveFilename($filename )
  {

    $this->saveFilename = $filename;

  }//end public function setSaveFilename */

  /**
   * @param string $tmpFolder
   */
  public function setTmpFolder($tmpFolder )
  {

    $this->tmpFolder = $tmpFolder;

  }//end public function setTmpFolder */
  
  /**
   * @param string $tmpFile
   */
  public function setTmpFile($tmpFile )
  {

    $this->tmpFile = $tmpFile;

  }//end public function setTmpFile */
  
  /**
   * @param LibTemplate $tpl
   */
  public function setTpl($tpl )
  {

    $this->tpl = $tpl;

  }//end public function setTpl */

/*//////////////////////////////////////////////////////////////////////////////
// Build Logik
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Bauen eines Texfiles mit der injecteten View
   */
  public function build()
  {

    $this->buildDocument();
    
    if (!file_exists($this->tmpFolder) )
      SFilesystem::mkdir($this->tmpFolder );
    
    $this->Output($this->tmpFolder.'/'.$this->tmpFile );

  }//end public function build */

  /**
   * Bauen des Latex Dokuments
   */
  public function buildDocument()
  {
    

  }//end public function buildDocument */

  /**
   * Das generierte File über die View versenden
   * @param LibTemplateDocument $tpl
   */
  public function sendFile($tpl = null )
  {

    if (!$tpl )
      $tpl = $this->tpl;

    $file = $this->tpl->sendFile();

    $file->type = 'application/pdf';
    //$file->type = 'text/plain';

    $file->path = $this->tmpFolder.$this->tempFile.'.pdf';
    $file->name = $this->tempFile.'.pdf';

    /*
    $file->tmp = true;
    $file->tmpFolder = $this->tmpFolder;
    */

  }//end public function sendFile */

  /**
   * Das generierte File über die View versenden
   * @param LibTemplateDocument $tpl
   */
  public function copy($target )
  {

    SFilesystem::copy($this->tmpFolder.$this->tempFile.'.pdf' ,  $target );

  }//end public function copy */

  /**
   * Die Temporären Daten die beim erstellen des PDFs erstellt wurden löschen
   */
  public function cleanTmp(  )
  {

    SFilesystem::delete($this->tmpFolder.$this->tempFile );

  }//end public function cleanTmp */

} // end class LibTemplateLatex

