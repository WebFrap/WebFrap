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
class LibFilesystemFile
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /** Die Fileid (für Verwaltungszwecke)
   * @var int
   */
  protected $fid = null;

  /** Name of the files Folder
   */
  protected $folder = null;

  /** Die Name der Datei
   * @var string
   */
  protected $fileName = null;

  /**
   * @var string
   */
  protected $extension  = null;

  /**
   * @var string
   */
  protected $plainFilename = null;

  /** the owner of the file
   * @var string
   */
  protected $owner = null;

  /** the groupowner
   * @var string
   */
  protected $group = null;

  /** the rights bitmask
   * @var string
   */
  protected $rights = null;

  /** Datum der Letzten Änderung der Datei
   * @var string
   */
  protected $lastChanged = null;

  /** when was the file created
   * @var string
   */
  protected $created = null;

  /** size of the file
   */
  protected $size = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct($folder , $fileName = null)
  {

    if ($fileName) {
      $this->folder = $folder;
      $this->fileName = $fileName;
    } else {
      $this->splitFilename($folder);
    }

  } // end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->filename;
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Name der Datei auslesen
   *
   * @param boolean $full Soll der Ordnerpfad mit ausgegeben werden
   * @return string
   */
  public function getName($full = false)
  {

    if ($full) {
      return str_replace('//','/',$this->folder . '/' . $this->fileName)  ;
    } else {
      return $this->fileName;
    }

  } // end public function getName  */

  /**
   * @return string
   */
  public function getExtension()
  {

    if (is_null($this->extension)) {
      $this->splitExtension();
    }

    return $this->extension;

  }//end public function getExtension  */

  /**
   * @return string
   */
  public function getPlainFilename()
  {
    if (is_null($this->plainFilename)) {
      $this->splitextension();
    }

    return $this->plainFilename;

  }//end public function getPlainFilename  */

  /**
   * Name der Datei auslesen
   *
   * @return string
   */
  public function getFolder()
  {
    return $this->folder;
  } // end public function getFolder  */

  /**
   * Besitzer der Datei auslesen
   *
   * @return string
   */
  public function getOwner()
  {

    if ($this->owner != null) {
      return $this->owner ;
    } else {
      if ($userdata = posix_getpwuid(fileowner($this->folder.'/'.$this->fileName))) {
        $this->owner = $userdata['name'];

        return $this->owner;
      } else {
        return null;
      }
    }

  }//end public function getOwner  */

  /**
   * Neuen Besitzer setzten
   *
   * @param string
   * @return boolean
   */
  public function setOwner($owner)
  {

    if (chown($this->folder . '/'. $this->fileName , $owner)) {

      $this->owner = $owner;

      return true;
    } else {
      return false;
    }

  } // end public function setOwner */

  /**
   * Auslesen der Gruppe
   *
   * @return string
   */
  public function getGroup()
  {

    if ($this->group != null) {
      return $this->group ;
    } else {
      if ($groupdata = posix_getgrgid(filegroup($this->folder. '/' . $this->fileName))) {

        $this->group = $groupdata['name'];

        return $this->group;
      } else {
        return false;
      }
    }

  } // end public function getGroup()

  /**
   * setzen der Gruppe
   *
   * @param string Group Name der Gruppe
   * @return boolean
   */
  public function setGroup($group)
  {

    if (is_string($group) and  chgrp($this->folder . '/'
      . $this->fileName , $group))
    {

      $this->group = $group;

      return true;
    } else {
      return false;
    }

  } // end public function setGroup */

  /**
   * Auslesen der Dateiberechtigungen
   *
   * @return string
   */
  public function getRights()
  {

    if ($this->rights != null) {
      return $this->rights ;
    } else {
      if ($rights = fileperms($this->folder . '/' . $this->fileName)) {
        $this->rights = $rights;

        return $this->rights;
      } else {
        return null;
      }
    }

  } // end public function getRights */

  /**
   * setzen neuer Dateirechte
   *
   * @param string Rights die Dateirechte
   * @return boolean
   */
  public function setRights($rights)
  {

    if (chmod($this->folder . '/' . $this->fileName , $rights)) {
      $this->rights = $rights;

      return true;
    } else {
      return false;
    }

  } // end public function setRights */

  /**
   * Abfragen wann die Datei das letzte mal geändert wurde
   *
   * @return string
   */
  public function getLastchanged()
  {

    if ($this->lastChanged != null) {
      return $this->lastChanged ;
    } else {
      if ($lastchanged = filemtime($this->folder . '/' . $this->fileName)) {
        $this->lastChanged = $lastchanged;

        return $this->lastChanged;
      } else {
        return null;
      }
    }

  } // end public function getLastchanged */

  /**
   * Abfragen der aktuellen Dateigröße
   *
   * @param string Format Das Rückgabeformat
   * @return int
   */
  public function getSize($format = 'kb')
  {

    // well hope php has an optimizer in the opcodecache!
    $calcs = array
    (
      'kb'  => 1024,
      'mb'  => 1049600,
      'gb'  => 1074790400,
      'tb'  => (1074790400*1024),
      'pb'  => (1074790400*1024*1024), // should be enough i think
    );

    $format = strtolower($format);

    if (!isset($calcs[$format])) {
      $faktor = 1024;
    } else {
      $faktor = $calcs[$format];
    }

    if ($this->size != null) {
      return $this->size ;
    } else {
      if ($size = filesize($this->folder . '/' . $this->fileName)) {
        $this->size =  $size;

        return round(($this->size / $faktor),3);
      } else {
        return null;
      }
    }

  }//end public function getSize */

  /**
   * Abfragen der aktuellen Dateigröße
   *
   * @param string Format Das Rückgabeformat
   * @return int
   */
  public function getLines()
  {

    $lines = 0;

    if (!$handle = fopen ($this->folder . '/' . $this->fileName  , "r"))
      return null;

    while (!feof($handle)) {
      fgets($handle, 4096);
      ++ $lines;
    }
    fclose($handle);

    return $lines;

  }//end public function getLines */

  /**
   * @param string $target the targetname to copy
   * @return boolean
   */
  public function copy($target)
  {

    $data = SParserString::splitFilename($target);

    if (trim($data['folder'])!= '' and !file_exists($data['folder'])) {
      SFilesystem::createFolder($data['folder']);
    }

    if (is_writeable($data['folder'])) {
      return copy($this->folder.'/'.$this->fileName , $target);
    } else {
      Error::report
      (
      'target folder for copy is not writeable: '.$data['folder']
      );

      return false;
    }
  }//end public function copy */

  /**
   * @param string $target the targetname to copy
   * @return boolean
   */
  public function move($target)
  {

    if (is_writeable($this->folder.'/'.$this->filename)) {
      if ($this->copy($target)) {
        $this->delete();

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }

  }//end public function move */

  /**
   * Enter description here...
   *
   */
  public function delete()
  {

    if (is_writeable($this->folder.'/'.$this->filename)) {
      return unlink($this->folder.'/'.$this->filename);
    } else {
      Error::report
      (
        'no enough rights to delete: '.$this->folder.'/'.$this->filename
      );

      return false;
    }

  }//end public function delete */

/*//////////////////////////////////////////////////////////////////////////////
// protected Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $fullFilename
   */
  protected function splitFilename($fullFilename)
  {

    $folderEnd      = strrpos($fullFilename, '/');
    $this->folder   = substr($fullFilename , 0, $folderEnd).'/';
    $this->fileName = substr($fullFilename , ($folderEnd+1));

  }//end protected function splitFilename */

  /**
   *
   * @return unknown_type
   */
  protected function splitExtension()
  {

    ///TODO check if wie don't have any extension
    $fEnd                 = strrpos($this->fileName, '.');
    $this->extension      = substr($this->fileName , ($fEnd + 1));
    $this->plainFilename  = substr($this->fileName , 0 , $fEnd);

  }//end protected function splitExtension */

} // end class LibFilesystemFile

