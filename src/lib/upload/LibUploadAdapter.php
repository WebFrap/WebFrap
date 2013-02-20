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
abstract class LibUploadAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /** identifikationsname im FILES Array
   * @var string
   */
  protected $ident = null;

  /**
   * Der ursprüngliche Name der Datei vor dem hochladen
   *  @var string
   */
  protected $oldname = null;

  /**
   * Der Name der Tempdatei in der das Bild gespeichert wurde
   *  @var string
   */
  protected $tmpname = null;

  /**
   * Der neue Name den das Bild bekommen soll
   *  @var string
   */
  protected $newname = null;

  /**
   * Der Ordner in den das Bild kopiert oder verschoben werden soll
   *  @var string
   */
  protected $newpath = null;

  /**
   * Typ der Hochgeladenen Datei
   *  @var string
   */
  protected $type = null;

  /**
   * Größe der hochgeladenen Datei
   *  @var string
   */
  protected $size = null;

  /**
   * Maximal erlaubte Dateigröße
   *  @var int
   */
  protected $maxSize = null;

  /**
   * Potentielle Fehlermeldungen
   * @var string
   */
  protected $error = null;

  /**
   * List der Kopien die erstellt wurden
   * @var array
   */
  protected $copies = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Speichern aller Relevater Daten für die Hochgeladene Datei
   * Der Konstruktor testet ob die Datei unseren Erwartungen entspricht.
   * Wenn ja kann Sie weitervrerarbeitet werden ansonsten wird sie direkt gelöscht
   *
   * @param string $ident Name des upgloadeten Files
   * @param string $newpath
   * @param string $newname
   * @param string $maxSize
   */
  public function __construct($data , $newpath = null , $newname = null , $maxSize = null )
  {

    if ( is_array($data) ) {
      $this->oldname  = $data['name'];
      $this->tmpname  = $data['tmp_name'];
      $this->type     = $data['type'];
      $this->size     = $data['size'];
      $this->error    = $data['error'];
    } else {
      throw new LibUploadException( 'Requested a non existing Upload' );
    }

    $this->newpath = $newpath;
    $this->newname = $newname;
    $this->maxSize = ($maxSize != null) ? ($maxSize * 1024) : null ;

  } // end public function __construct($ident , $newpath = null , $newname = null , $maxSize = null )

  /**
   *
   */
  public function __destruct( )
  {

    if ( file_exists($this->tmpname ) )
      unlink($this->tmpname );

  } // end public function __destruct( )

  /**
   *
   * Enter description here ...
   */
  public function __toString()
  {
    return $this->getNewname( );
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzten des neuen Dateinamens
   *
   * @param string $name
   * @return void
   */
  public function setNewname($name )
  {

    if ( is_string($name ) ) {
      $this->newname = $name;
    }

  } // end public function setNewname($name )

  /**
   * Abfragen des neuen Dateinamens
   *
   * @param string $name
   * @return void
   */
  public function getNewname( )
  {

    if ($this->newname) {
      return $this->newname;
    } else {
      return $this->oldname;
    }

  } // end public function getNewname( )

  /**
   * Setzten des Pfades in den die Datei kopiert werden soll
   *
   * @param string $path
   * @return void
   */
  public function setNewPath($path )
  {
    $this->newpath = $path;
  } // end public function setNewPath($path )

  /**
   * Abfragen des neuen Pfades der Datei
   *
   * @return string
   */
  public function getNewpath( )
  {
    if (!isset($this->newpath ) ) {
      return $this->newpath;
    } else {
      return false;
    }
  } // end public function getNewpath( )

  /**
   * Setzen der Maximalgröße
   *
   * @param int $size
   * @return void
   */
  public function setMaxSize($size )
  {

    if ( is_int($size) )
      $this->maxSize = $size * 1024;
    else
      return false;

  } // end public function setMaxSize($size )

  /**
   * Abfragen der Maximalen Größe
   *
   * @return int
   */
  public function getMaxSize( )
  {
    if ($this->maxSize != null) {
      return $this->maxSize;
    }

    return false;
  } // end public function getMaxSize( )

  /**
   * Abfragen des identnamens
   *
   * @return string
   */
  public function getIdent( )
  {
    return $this->ident;

  } // end public function getIdent( )

  /**
   * Den Originalnamen erfragen
   *
   * @return string
   */
  public function getOldname( )
  {
    return $this->oldname;
  } // end public function getOldname( )

  /**
   * request actual path of the uploaded file
   *
   * @return string
   */
  public function getTempname( )
  {
    return $this->tmpname;
  } // end public function getTempname */

  /**
   * Die Größe der Datei erfragen
   *
   * @return string
   */
  public function getSize( )
  {
    return $this->size;
  } // end public function getSize( )

  /**
   * Testen ob die Datei nicht größer als die Maximalgröße ist
   *
   * @return boolean
   */
  public function checkSize( )
  {
    if ($this->maxSize == null )
      return true;

    if ($this->size < $this->maxSize  )
      return true;

    return false;
  } // end public function checkSize( )

  /**
   * Abfragen ob es Fehler gab
   *
   * @return boolean
   */
  public function getError( )
  {

    if (trim($this->error ) != "" )
      return $this->error;
    else
      return null;

  } // end public function getError( )

  /**
   * Den Dateityp abfragen
   *
   * @return string
   */
  public function getFiletype( )
  {
    return $this->type;
  } // end public function getFiletype( )

  /**
   * Md5 hash der Datei abfragen
   *
   * @return string
   */
  public function getChecksum( )
  {
    return md5_file($this->tmpname);
  }//end public function getChecksum */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * copy the uploaded File
   *
   * @param string $newName
   * @param string $newPath
   *
   * @return string
   */
  public function copy($newName = null, $newPath = null )
  {

    if (!$newPath) {
      if (!$this->newpath) {
        $this->newpath = PATH_FILES.'data/dms/';
      }
    } else {
      $this->newpath = $newPath;
    }

    if ($newName) {
      $this->newname = $newName;
    }

    if (is_null($this->newname ) ) {
      $newName = $this->newpath.'/'.$this->oldname;
    } else {
      $newName = $this->newpath.'/'.$this->newname;
    }

    // Wenn der Ordner nicht existiert, einfach versuchen zu erstellen
    if (!is_dir($this->newpath ) ) {
      if (!SFilesystem::createFolder($this->newpath ) ) {
        throw new LibUploadException('Failed to create target folder: '.$this->newpath);
      }
    }

    if (!is_writeable($this->newpath )  ) {
      throw new LibUploadException('Target Folder: '.$this->newpath.' ist not writeable');
    }

    if (!copy($this->tmpname , $newName  ) ) {
      throw new LibUploadException( 'Was not able to copy the file '.$this->tmpname.' to the new target: '.$newName );
    }

    $this->copies[] = $newName;

    return $newName;

  }//end public function copy */

  /**
   *
   */
  public function clean()
  {

    foreach ($this->copies as $copy) {
      if (!unlink($copy  )) {
        Error::addError
        (
          'Failed to clean: '. $copy
        );
      }
    }

  }//end public function clean */

} // end abstract class LibUploadAdapter

