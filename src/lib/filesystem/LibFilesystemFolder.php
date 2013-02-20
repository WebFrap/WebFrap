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
class LibFilesystemFolder
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /** Folder in dem die Datei gespeichert war
   * @var string
   */
  protected $folder = null;

  /**
   * @var string
   */
  protected $activFolder = null;

  /** Besitzer der Datei
   */
  protected $owner = null;

  /** Gruppe der Datei
   */
  protected $group = null;

  /** Rechte der Datei
   */
  protected $rights = null;

  /** Datum der Letzten Änderung der Datei
   */
  protected $lastChanged = null;

  /** Status ob die Datei zwischen letzten Speichern und jetzt geändert wurde
   */
  protected $changed = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $folder
   */
  public function __construct($folder )
  {

    if ( Log::$levelVerbose )
      Log::create( get_class($this) , array($folder) );

    $this->folder = $folder;

  } // end of member function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->folder;
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function getName( )
  {
    return $this->folder;
  } // end public function getName */

  /**
   * @return string
   */
  public function getFoldername( )
  {
    return $this->folder;
  } // end public function getFoldername */

  /**
   * get the owner of the folder
   *
   * @return string
   */
  public function getOwner( )
  {

    if ($this->owner != null) {
      return $this->owner ;
    } else {
      if ($userdata = posix_getpwuid(fileowner($this->folder ))) {
        $this->owner = $userdata['name'];

        return $this->owner;
      } else {
        return null;
      }
    }

  } // end public function getOwner */

  /**
   * Neuen Besitzer setzten
   *
   * @return boolean
   */
  public function setOwner($owner )
  {
    return chown($this->folder , $owner );

  } // end public function setOwner */

  /**
   * Auslesen der Gruppe
   *
   * @return string
   */
  public function getGroup( )
  {

    if ($this->group != null) {
      return $this->group ;
    } else {
      if ($groupdata = posix_getgrgid( filegroup($this->folder )) ) {
        $this->group = $groupdata['name'];

        return $this->group;
      } else {
        return null;
      }
    }
  } // end public function getGroup */

  /**
   *
   * @param string Group Name der Gruppe
   * @return boolean
   */
  public function setGroup($group )
  {

    if ( chgrp($this->folder  , $group ) ) {
      $this->group = $group;

      return true;
    } else {
      return false;
    }

  } // end public function setGroup */

  /**
   *
   * @return string
   */
  public function getRights( )
  {
    if ($this->rights != null) {
      return $this->rights ;
    } else {
      if ($rights = fileperms($this->folder ) ) {
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
   * @param string $rights
   * @return bool
   */
  public function setRights($rights )
  {

    if ( chmod($this->folder . '/' . $this->fileName , $rights ) ) {
      $this->rights = $rights;

      return true;
    } else {
      return false;
    }

  } // end public function setRights */

  /** Abfragen wann die Datei das letzte mal geändert wurde
   *
   * @return string
   */
  public function getLastchanged( )
  {

    if ($this->lastChanged != null) {
      return $this->lastChanged ;
    } else {
      if ($lastchanged = filemtime($this->folder ) ) {
        $this->lastChanged = $lastchanged;

        return $this->lastChanged;
      } else {
        return null;
      }
    }

  } // end public function getLastchanged */

  /**
   * @param boolean $asObject
   */
  public function getFolders($asObject = true )
  {

    $folders = array();

    if ($asObject) {
      if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {
          if ($subF[0] != "." and is_dir($this->folder.'/'.$subF) ) {
            $folders[] = new LibFilesystemFolder($this->folder.'/'.$subF);
          }
        }
        closedir($dh);
      }
    } else {
      if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {
          if ($subF[0] != "." and is_dir($this->folder.'/'.$subF) ) {
            $folders[] = $this->folder.'/'.$subF;
          }
        }
        closedir($dh);
      }
    }

    return $folders;

  }//end public function getFolders */

  /**
   *
   */
  public function getPlainFolders($sortAsc = null )
  {

      $folders = array();

      if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {
          if ($subF[0] != "." and is_dir($this->folder.'/'.$subF) ) {
            $folders[] = $subF;
          }
        }
        closedir($dh);
      }

      if (is_null($sortAsc) )
        return $folders;

      if ($sortAsc )
        asort($folders );
      else
        arsort($folders );

      return $folders;

  }//end public function getPlainFolders */

  /**
   * @param boolean $asObject
   * @return array<String>/array<LibFilesystemFile>
   */
  public function getFiles($asObject = true )
  {

    $files = array();

    if ($asObject) {
      if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {
          if ($subF[0] != "." and !is_dir($this->folder.'/'.$subF ) ) {
            $files[$subF] = new LibFilesystemFile($this->folder.'/'.$subF );
          }
        }
        closedir($dh);
      }
    }//end if ($asObject )
    else {
      if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {
          if ($subF[0] != "." and is_file($this->folder.'/'.$subF ) ) {
            $files[$subF] = $this->folder.'/'.$subF;
          }
        }
        closedir($dh);
      }
    }//end else($asObject )

    ksort($files);

    return $files;

  }//end public function getFiles */

  /**
   * get all files by a given ending
   *
   *
   * @param string $ending
   * @param boolean $asObject
   * @param boolean $rekursiv
   * @param array $files all allready existing files
   * @param string $folder all allready existing files
   *
   * @return array
   */
  public function getFilesByEnding
  (
    $ending,
    $asObject = false,
    $rekursiv = false,
    $files = array(),
    $folder = null
  )
  {

    // key = full filename with path
    // for better sorting, check if thats necessary
    if (!$folder )
      $folder = $this->folder;

    if ($asObject) {
      if (  is_dir($folder) && $dh = opendir($folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {
          if ($subF == "." ||  $subF == ".." )
            continue;

          if ( is_file($folder.'/'.$subF ) ) {
            if ( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending ) {
              $files[$folder.'/'.$subF] = new LibFilesystemFile($folder.'/'.$subF );
            }
          } elseif ($rekursiv  && is_dir($folder.'/'.$subF )  ) {
            $files = $this->getFilesByEnding($ending, $asObject, $rekursiv, $files, $folder.'/'.$subF.'/'  );
          }

        }
        closedir($dh);
      }
    } else {
      if ( is_dir($folder ) && $dh = opendir($folder) ) {
        while ( ($subF = readdir($dh) ) !== false ) {

          if ($subF == "." ||  $subF == ".." )
            continue;

          if (  is_file($folder.'/'.$subF ) ) {
            if ( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending ) {
              $files[$folder.'/'.$subF] = $folder.'/'.$subF;
            }
          } elseif ($rekursiv  && is_dir($folder.'/'.$subF )  ) {
            $files = $this->getFilesByEnding($ending, $asObject, $rekursiv, $files, $folder.'/'.$subF.'/'  );
          }

        }
        closedir($dh);
      }
    }

    ksort($files );

    return $files;

  }//end public function getFilesByEnding */

  /**
   * @param boolean $asObject
   */
  public function getPlainFiles($sortAsc = null )
  {

    $files = array();

    if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
      while ( ($subF = readdir($dh) ) !== false ) {
        if ($subF[0] != "." and is_file($this->folder.'/'.$subF ) ) {
          $files[$subF] = $subF;
        }
      }
      closedir($dh);
    }

    if (is_null($sortAsc ) )
      return $files;

    if ($sortAsc )
      ksort($files );
    else
      krsort($files );

    return $files;

  }//end public function getPlainFiles( )

  /**
   *
   */
  public function getPlainFilesByEnding($ending )
  {

    $files = array();

    if ( is_dir($this->folder) && $dh = opendir($this->folder) ) {
      while ( ($subF = readdir($dh) ) !== false ) {
        if ($subF[0] != "." and is_file($this->folder.'/'.$subF ) ) {
          if ( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending ) {
            $files[$subF] = $subF;
          }
        }
      }
      closedir($dh);
    }

    ksort($files);

    return $files;

  }//end public function getPlainFilesByEnding($ending )

  /**
   * @return string
   */
  public function getActivFolder()
  {

    if (is_null($this->activFolder) ) {
      $folder = trim($this->getFoldername());

      if ($folder[(strlen($folder)-1)] == '/')
        $folder = substr($folder, 0, -1 );

      $add = ($folder[0] == '/' or $folder[0] == '.')  ? 1 : 0;

      $folderEnd = strrpos($folder, '/' ) + $add;
      $this->activFolder = substr($folder , $folderEnd );
    }

    return $this->activFolder;

  }//end public function getActivFolder */

} // end class LibFilesystemFolder

