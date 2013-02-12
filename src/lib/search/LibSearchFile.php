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
class LibSearchFile
{

  /**
   *
   * @var array
   */
   protected $found = array();

   /**
    * @param array
    */
   protected $endings = array
   (
    '.txt','.bdl','.html',
    '.css','.js','.tpl','.php'
   );

  /**
   * @param string $folder
   * @param string $pattern
   * @param string $ending
   * @param boolean $recursiv
   */
  public function search( $folder, $pattern, $endings = array(), $recursiv = true )
  {

    if( !$endings || !is_array($endings) )
      $endings = $this->endings;

    if ($recursiv) {
      if ( is_array($folder) ) {
        foreach ($folder as $subFolder) {
          $this->searchInFolder( $subFolder, $pattern, $endings );
        }
      } else {
        $this->searchInFolder( $folder, $pattern, $endings );
      }
    } else {
      if ( is_array($folder) ) {
        foreach ($folder as $subFolder) {
          $files = $this->getFilesByEnding( $subFolder, $endings );
          foreach ($files as $file) {
            $this->searchInFile( $subFolder.'/'.$file, $pattern );
          }
        }
      } else {
        $files = $this->getFilesByEnding( $folder, $endings );

        foreach ($files as $file) {
          $this->searchInFile( $folder.'/'.$file, $pattern );
        }
      }

    }

    return $this->found;

  }//end public function search */

  /**
   * @param string $file
   * @param string $pattern
   */
  public function searchInFile( $file, $pattern )
  {

    $fileRows = file($file);

    foreach ($fileRows as $pos => $row) {
      if ( strpos($row, $pattern) ) {
        $this->found[$file][($pos+1)] = $row;
      }
    }

  }//end public function searchInFile */

  /**
   * @param string $file
   * @param string $pattern
   */
  public function searchInFolder( $folder, $pattern, $endings )
  {

    $files = $this->getFilesByEnding( $folder, $endings );

    foreach ($files as $file) {
      $this->searchInFile( $folder.'/'.$file, $pattern );
    }

    $folders = $this->getFolders( $folder );

    foreach ($folders as $subFolder) {
      $this->searchInFolder( $folder.'/'.$subFolder, $pattern, $endings );
    }

  }//end public function searchInFile */

  /**
   * @param string $folder
   * @param string $endings
   */
  public function getFilesByEnding( $folder, $endings )
  {

    $files = array();

    if ( is_dir($folder) && $dh = opendir($folder) ) {
      while ( ($subF = readdir($dh) ) !== false ) {
        if ( $subF[0] != "." and is_file( $folder.'/'.$subF ) ) {
          foreach ($endings as $ending) {
            if ( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending ) {
              $files[$subF] = $subF;
              break;
            }
          }
        }
      }
      closedir($dh);
    }

    return $files;

  }//end public function getFilesByEnding */

  /**
   * @param string $folder
   * @return array
   */
  public function getFolders( $folder )
  {

    $subFolders = array();

    if ( is_dir($folder) && $dh = opendir($folder) ) {
      while ( ($subF = readdir($dh) ) !== false ) {
        if ( $subF[0] != "." and is_dir($folder.'/'.$subF) ) {
          $subFolders[] = $subF;
        }
      }
      closedir($dh);
    }

    return $subFolders;

  }//end public function getFolders */

}//end class LibSearchFile
