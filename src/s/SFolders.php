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
class SFolders
{

  /** Verschiebene eines Ordners
   *
   * @param string Oldpos Die alte Position des Ordners
   * @param string Newpos Die neue Position des Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function move( $oldPos, $newPos )
  {
    $sys = Webfrap::getActive();
    $os = substr( 0 , 3 , $sys->getSysStatus('serveros'));

    $cname = IncFolders.$os;

    if ( WebFrap::loadable($cname) ) {

      call_user_func( array($cname , 'move' ) , $oldPos , $newPos  );

      //  call_user_func ( "$cname::Move" , $oldPos , $newPos );
      //  $cname::Move( $oldPos , $newPos  );
      //  IncFoldersLin::move( $oldPos , $newPos  );

    } else {

      throw new WebfrapSys_Exception('Diese Aktion wird für '.'dieser Betriebsystem nicht unterstützt!');
    }

  } // end of member function Move

  /** Kopieren eines Ordners
   *
   * @param string Oldpos Die alte Position des Ordners
   * @param string Newpos Die neue Position des Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function copy( $oldPos, $newPos )
  {

    $sys = Webfrap::getActive();
    $os = substr( 0 , 3 , $sys->getSysStatus('serveros'));

    $cname = IncFolders.$os;

    if ( class_exists($cname) ) {
      call_user_func ( array( $cname  , 'copy' ) , $oldPos , $newPos );
    } else {
      throw new WebfrapSys_Exception('Diese Aktion wird für '.
        'dieser Betriebsystem nicht unterstützt!');
    }

  } // end of member function Copy

  /** Funktion zum löschen eines Ordners
   *
   * @param string Todel Löschen eines Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function delete( $todel )
  {

    SFilesystem::delete($todel);

  }//end public static function delete

  /** Funktion zum löschen eines Ordners
   *
   * @param string Todel Löschen eines Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function rekReplaceStrings
  (
    $Folder,
    $OldString,
    $NewString,
    $Ending
  )
  {

    $Folders = array();

    // auslesen und auswerten
    if ($dh = opendir($Folder)) {
        while ( ( $PotFolder = readdir($dh) ) !== false ) {

            if ($PotFolder != "." and $PotFolder != "..") {

              $FullPath = $Folder."/".$PotFolder ;

              if ( is_file( $FullPath ) ) {
                if ( SFiles::hasEnding( $PotFolder , $Ending )   ) {
                  SFiles::replaceInFile(  $FullPath ,
                                            $OldString ,
                                            $NewString
                                         );
                }// Ende if
              }// Ende if
              if ( is_dir( $FullPath ) ) {

                $Folders[] = $FullPath;
              }
            }
        }
        closedir($dh);
    }// Ende If

    // Seperate rekursion, dass nicht 2000 Ordner aufeinmal offen sind sondern
    // immer nur einer
    foreach ($Folders as $Folder) {
      self::rekReplaceStrings(  $Folder ,
                                $OldString,
                                $NewString,
                                $Ending
                              );
    }

  } // end of member function Delete

  /**
   * method to request a folder content
   *
   * @param string $folder path to folder
   * @param string $fullPath should the method deliver the full path
   * @param string $type what should be deliverd
   * @param array $exclude
   * @param boolean $hidden show also hidden files
   * @return array
   */
  public static function getContent( $folder, $fullPath = true, $type = 'a', $exclude = array(), $hidden = false )
  {

    if ( !is_dir( $folder ) ) {
      throw new Io_Exception($folder.' ist kein existierender Ordner');
    }

    if (!is_readable( $folder )) {
      throw new Io_Exception($folder.' kann nicht zum lesen geöffnet werden');
    }

    // if we deliver the fullpath just overwrite the boolean with the pass
    if ($fullPath) {
      $fullPath = $folder.'/';
    }

    if ($exclude) {
      if ($hidden) {
        return self::getFoldercontentExclude( $folder, $fullPath, $type , $exclude  );
      } else {
        return self::getFoldercontentNohiddenExclude( $folder, $fullPath, $type , $exclude  );
      }

    } else {
      return self::getFolderContent(  $folder, $fullPath, $type, $hidden );
    }

  } // end public static function getFoldercontent( $folder , $hidden = false , $exclude = false  )

  /**
   * Enter description here...
   *
   * @param string $folder
   * @param string $fullPath
   * @param string $type
   * @return array
   */
  public static function getFolderContent( $folder, $fullPath, $type , $hidden = false )
  {

    $files = array();

    if ($hidden) {
      if ($dh = opendir($folder)) {
        while ( ($file = readdir($dh) ) !== false ) {
          if ($file != '.' and  $file != '..') {
            if ($type=='a') {
               $files[] = $fullPath.$file;
            } elseif ( $type=='f' and is_file($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            } elseif ( $type=='d' and is_dir($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            }
          }
        }//end while ( ($file = readdir($dh) ) !== false )
        closedir($dh);
      }//end if ($dh = opendir($folder))
    }//end if($hidden)
    else {
      if ($dh = opendir($folder)) {
        while ( ($file = readdir($dh) ) !== false ) {
          if ($file[0] != '.') {
            if ($type=='a') {
               $files[] = $fullPath.$file;
            } elseif ( $type=='f' and is_file($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            } elseif ( $type=='d' and is_dir($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            }
          }
        }//end while ( ($file = readdir($dh) ) !== false )
        closedir($dh);
      }//end if ($dh = opendir($folder))
    }//end else($hidden)

    return $files;

  } // end public static function getFoldercontentNohidden( $folder )

  /**
   * Enter description here...
   *
   * @param unknown_type $folder
   * @param unknown_type $fullPath
   * @param unknown_type $type
   * @param unknown_type $excludes
   * @return unknown
   */
  public static function getFolderContentExclude( $folder , $fullPath, $type , $excludes )
  {

    $files = array();

    if ($dh = opendir($folder)) {
      while ( ($file = readdir($dh) ) !== false ) {
        $break = false;

        if ($file != '.' and $file != '..') {

          foreach ($excludes as $exclude => $negator) {

            $data = explode(':',$exclude,2);
            if (!count($data) == 2) {
              Log::warn(__file__,__line__,'Got invalid exclude: '.$exclude);
              continue;
            }

            $key = $data[0];
            $value = $data[1];

            switch ( strtolower($key) ) {
              case 'begin':
              {
                // Sind Anfang und Exclude identisch?
                if ( substr(  $file  , 0 , strlen($value) ==  $value )) {
                  $break = true;
                }
                break;
              }// Ende Case
              case 'contains':
              {
                if ( stripos($file , $value ) ) {
                  $break = true;
                }
                break;
              }// Ende Case
              case 'end':
              {
                // Sind Ende und Exclude identisch?
                $length = strlen($value);
                if ( substr(  $file  ,(0-$length) ,$length ) ==  $value ) {
                  $break = true;
                }
                break;
              } // Ende Case
            } // Ende Switch

            if ($break) {
              break;
            }

          }// Ende Foreach

          if ((!$break and !$negator) or ($break and $negator)) {
            if ($type=='a') {
               $files[] = $fullPath.$file;
            } elseif ( $type=='f' and is_file($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            } elseif ( $type=='d' and is_dir($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            }
          }//end if(!$break)
        }//en if( $file != '.' and $file != '..' )
      }//end while ( ($file = readdir($dh) ) !== false )
      closedir($dh);
    }

    return $files;

  } // end public static function getFoldercontentExclude( $folder , $excludes )

  /**
   * Enter description here...
   *
   * @param unknown_type $folder
   * @param unknown_type $fullPath
   * @param unknown_type $type
   * @param unknown_type $excludes
   * @return array
   */
  public static function getFolderContentNohiddenExclude( $folder, $fullPath, $type, $excludes )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($folder, $fullPath, $type, $excludes));

    $files = array();

    if ($dh = opendir($folder)) {
      while ( ($file = readdir($dh) ) !== false ) {

        $break = false;

        if ($file[0] != '.') {

          foreach ($excludes as $exclude => $negator) {

            $data = explode(':',$exclude,2);

            if (!count($data) == 2) {
              Log::warn(__file__,__line__,'Got invalid exclude: '.$exclude);
              continue;
            }

            $key = $data[0];
            $value = $data[1];

            switch ( strtolower($key) ) {
              case 'begin':
              {
                // Sind Anfang und Exclude identisch?
                if ( substr($file,0,strlen($value) )==  $value ) {
                  $break = true;
                }
                break;
              }// Ende Case

              case 'contains':
              {
                $string = $value;
                if ( stripos($file , $value ) ) {
                  $break = true;
                }
                break;
              }// Ende Case

              case 'end':
              {
                // Sind Ende und Exclude identisch?
                $length = strlen($value);
                $start = strlen($file) - $length;
                if ( substr($file,$start,$length) ==  $value ) {
                  $break = true;
                }
                break;
              } // Ende Case

            } // Ende Switch

            if ($break) {
              break;
            }

          }// Ende Foreach

          if ((!$break and !$negator) or ($break and $negator) ) {
            if ($type=='a') {
               $files[] = $fullPath.$file;
            } elseif ( $type=='f' and is_file($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            } elseif ( $type=='d' and is_dir($folder.'/'.$file) ) {
              $files[] = $fullPath.$file;
            }

          }//end if(!$break)

        }//end if( $file[0] != '.' )

      }//end while ( ($file = readdir($dh) ) !== false )

      closedir($dh);

    }

    return $files;

  } // end public static function getFoldercontentNohiddenExclude( $folder , $excludes )

} // end class SFolders
