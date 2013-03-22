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
class LibArchiveZip extends LibArchive
{

  /**
   * @var int
   */
  const MAX_FILES = 1000;

  /**
   * @var int
   */
  const MAX_ARCH_FILES = 60000;

  /**
   * @var int
   */
  const MODE_NORMAL = 1;

  /**
   * @var int
   */
  const MODE_HUGE = 2;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Archive Klasse
   * @var ZipArchive
   */
  protected $mainResource = null;

  /**
   * Die Archive Klasse
   * @var ZipArchive
   */
  protected $resource = null;

  /**
   * Der Dateiname des ZIP Archives
   * @var string
   */
  protected $fileName = null;

  /**
   * @var int
   */
  protected $writeCounter = 0;

  /**
   * @var int
   */
  protected $hugeCounter = 0;

  /**
   * @var int
   */
  protected $iteration = 1;

  /**
   * @var int
   */
  protected $mode = self::MODE_NORMAL;

  /**
   * @var int
   */
  protected $hugeTempFoder = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $fileName Name des Archives
   * @param int $mode normal oder huge file mode
   * @param boolean $ro readonly?
   */
  public function __construct($fileName, $mode = self::MODE_NORMAL, $ro = false  )
  {

    $this->fileName = $fileName;
    $this->mode     = $mode;

    SFilesystem::touchFileFolder($fileName);

    if (self::MODE_NORMAL == $mode) {
      $this->resource = new ZipArchive();
      $opened = $this->resource->open($fileName, ZipArchive::CREATE);
    } else {
      $this->hugeTempFoder = Webfrap::tmpFolder(true);
      SFilesystem::mkdir($this->hugeTempFoder);

      $this->mainResource  = new ZipArchive();
      $this->mainResource->open($this->fileName, ZipArchive::CREATE);

      $this->resource = new ZipArchive();
      $opened = $this->resource->open($this->hugeTempFoder.$this->iteration, ZipArchive::CREATE);
    }

    if ($opened !== true) {
      throw new LibArchive_Exception('Failed to open Archive '.$fileName.' code '.$opened);
    }

  }//end public function __construct */

  /**
   *
   */
  public function tmpSave()
  {
    $this->writeCounter = 0;

    $this->resource->close();
    $this->resource = new ZipArchive();

    if (self::MODE_NORMAL == $this->mode) {
      $this->resource->open($this->fileName);
    } else {
      $this->resource->open($this->hugeTempFoder.$this->iteration);
    }

  }//end public function tmpSave */

  /**
   *
   */
  public function closeSubArchive()
  {

    $this->writeCounter = 0;
    $this->hugeCounter  = 0;

    $this->resource->close();

    $this->mainResource->addFile($this->hugeTempFoder.$this->iteration, '/'.$this->iteration);
    ++$this->iteration;

    $this->resource = new ZipArchive();
    $this->resource->open($this->hugeTempFoder.$this->iteration, ZipArchive::CREATE);

  }//end public function closeSubArchive */

  /**
   */
  public function __destruct()
  {

    //$this->resource->close();

  }//end public function __construct */

  /**
   * Schliesen des Archives
   */
  public function close()
  {

    if (self::MODE_HUGE == $this->mode) {
      $this->resource->close();

      $this->mainResource->addFile($this->hugeTempFoder.$this->iteration, '/'.$this->iteration);
      $this->mainResource->close();

      // temporären ordner löschen
      SFilesystem::delete($this->hugeTempFoder);
    } else {
      return $this->resource->close();
    }

    $this->iteration = 1;
    $this->writeCounter = 0;
    $this->hugeCounter = 0;

  }//end public function close */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Einen Ordner dem Archive hinzufügen
   * @param string $folderName
   * @param string $relativePath
   */
  public function addFolder($folderName, $relativePath = null)
  {

    $files = new IoFileIterator($folderName);

    if ($relativePath)
      $relativePath = '/'.$relativePath;

    foreach ($files as $file) {

      if (!file_exists($file)) {
        Debug::console("Tried to add nonexisting file: $file to archive");
        continue;
      }

      if ($this->resource->addFile($file, $relativePath.$file)) {

        if ($this->writeCounter >= self::MAX_FILES) {
          $this->tmpSave();
        }

        if (self::MODE_HUGE == $this->mode) {
          if ($this->hugeCounter >= self::MAX_ARCH_FILES) {
            $this->closeSubArchive();
          }
          ++$this->hugeCounter;
        }

        ++$this->writeCounter;

      }
    }

  }//end public function addFolder */

  /**
   * Eine Datei dem Ordner hinzufügen
   * @param string $fileName
   * @param string $innerName
   */
  public function addFile($fileName, $innerName = null)
  {

    if ($this->writeCounter >= self::MAX_FILES) {
      $this->tmpSave();
    }

    if (self::MODE_HUGE == $this->mode) {
      if ($this->hugeCounter >= self::MAX_ARCH_FILES) {
        $this->closeSubArchive();
      }
      ++$this->hugeCounter;
    }
    ++$this->writeCounter;

    if (!$innerName)
      $innerName = $fileName;

    if (!file_exists($fileName)) {
      Debug::console("Tried to add nonexisting file: $fileName to archive");

      return;
    }

    $this->resource->addFile($fileName, $innerName);

  }//end public function addFolder */

  /**
   * Hinzufügen eine Metadatei
   * @param string $fileName
   * @param string $innerName
   */
  public function addMetaFile($fileName, $innerName = null)
  {

    ++$this->writeCounter;

    if (!$innerName)
      $innerName = $fileName;

    if (!file_exists($fileName)) {
      Debug::console("Tried to add nonexisting file: $fileName to archive.");

      return;
    }

    if ($this->mainResource) {
      $this->mainResource->addFile($fileName, $innerName);
    } else {
      $this->resource->addFile($fileName, $innerName);
    }

  }//end public function addMetaFile */

  /**
   * Extrahieren einer Metadatei
   * @param string $src
   * @param string $innerName
   */
  public function extractMetaFile($src, $target  )
  {

    SFilesystem::touchFileFolder($src);

    if ($this->mainResource) {
      $this->mainResource->extractTo($target, array($src));
    } else {
      $this->resource->extractTo($target, array($src));
    }

  }//end public function extractMetaFile */

/*//////////////////////////////////////////////////////////////////////////////
// Unpack Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Entpacken des Archives
   * @param string $targetFolder
   */
  public function unpack($targetFolder = './')
  {

    if ($this->mode == self::MODE_HUGE) {
      $this->hugeTempFoder = Webfrap::tmpFolder(true);
      SFilesystem::mkdir($this->hugeTempFoder);

      $this->mainResource->extractTo($this->hugeTempFoder);

      $archives = new IoFileIterator($this->hugeTempFoder);

      foreach ($archives as $archive) {

        // metadaten überspringen
        if (strpos($archive, '.bdl'))
          continue;

        $archRes = new ZipArchive();
        $archRes->open($archive);
        $archRes->extractTo($targetFolder);
        $archRes->close();
      }

      SFilesystem::delete($this->hugeTempFoder);

    } else {
      $this->resource->extractTo($targetFolder);
    }

  }//end public function unpack */

} // end class LibArchiveZip

