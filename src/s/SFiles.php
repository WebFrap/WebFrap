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
class SFiles
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /** Verschiebene eines Ordners
   *
   * @param string $oldPos Oldpos Die alte Position des Ordners
   * @param string $newPos Newpos Die neue Position des Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function move( $oldPos , $newPos )
  {
    if(Log::$levelDebug)
      Log::start(  __file__ , __line__ , __method__ , array($oldPos , $newPos) );

    ///FIXME this will not work! change to SFilesystem


  }// end public static function move( $oldPos , $newPos )

  /** Kopieren eines Ordners
   *
   * @param string Oldpos Die alte Position des Ordners
   * @param string Newpos Die neue Position des Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function copy( $oldPos ,$newPos )
  {
    return SFilesystem::copy( $oldPos ,$newPos );
  }//public static function copy */

  /** Delete a File
   *
   * @param string $path Todel Löschen eines Ordners
   * @throws Webfrap_Exception
   * @return array
   */
  public static function delete( $path )
  {

    if( !file_exists( $path ) )
    {
      throw new Io_Exception( $path." not exists" );
    }

    if( is_file( $path ) )
    {
      if( !is_writeable( $path ) )
      {
        throw new Io_Exception( $path." is no writeable" );
      }
      return unlink( $path );
    }
    else 
    {
      throw new Io_Exception( $path." is no file" );
    }


  }//end public static function delete( $path , $isSub = false )

  /** get the filety
   *
   * @param string $fileName name of the file
   * @throws Webfrap_Exception
   * @return array
   */
  public static function getMimeType( $fileName )
  {

    $ending = substr( $fileName , strrpos($fileName,'.') );

    if( isset( EMime::$text[$ending] ) )
    {
      return EMime::$text[$ending];
    }
    else
    {
      return 'application/octet-stream';
    }

  }// end public static function getMimeType */

  /** Funktion zum löschen eines Ordners
   *
   * @param string  $fileName Todel Löschen eines Ordners
   * @param string  $ending Endung der Dateien die gelöscht werden sollen
   *
   * @throws Webfrap_Exception
   * @return array
   */
  public static function checkExtention( $fileName, $ending )
  {

    $lenghtEnding = strlen( $ending ) -1;
    $lenghtFile = strlen( $fileName ) -1;

    $pre = $lenghtFile - $lenghtEnding;

    if( $pre <= 0  )
    {
      return false;
    }// ende if

    if( substr( $fileName, $pre,  $lenghtEnding ) ==  $ending )
    {
      return true;
    }
    else
    {
      return false;
    }

  }// end public static function checkExtention

  /**
   * replace of one or more strings in a file
   *
   * @param string $filename
   * @param string $oldData
   * @param string $newData
   * @throws Webfrap_Exception
   * @return void
   */
  public static function replaceInFile( $fileName ,$oldData ,$newData )
  {

    if( !is_writeable( $fileName ) )
    {
      throw new Io_Exception
      (
        I18n::s
        (
          'The File {@filename@} was not writeable',
          'wbf.message',
          array( 'filename' => $fileName )
        )
      );
    }

    file_put_contents
    (
      $fileName,
      str_replace
      (
        $oldData,
        $newData,
        file_get_contents( $fileName )
      )
    );

  }// end public static function replaceInFile

  /**
   * @param string $fileName
   */
  public static function getRawFilename( $fileName )
  {

    $tmp       = explode('/',$fileName); // remove folders
    $fileName  = array_pop($tmp);

    // test if we found a dot an asume that if we find one it seperates the name
    // from the extension
    if( $pos = strrchr( $fileName , '.') )
    {
      $fname = substr( $fileName , 0 , -strlen($pos) );
      return $fname;
    }
    else
    {
      return $fileName;
    }

  }//end public static function getRawFilename */

  /**
   * @param string $fileName
   * @param string $data
   * @param string $mode
   */
  public static function write( $fileName, $data, $mode = 'w' )
  {

    $folder = self::getPath( $fileName );

    if( !is_file( $folder ) )
    {
      SFilesystem::mkdir( $folder );
    }

    if( !$handle = fopen( $fileName, $mode )  )
      return false;

    $wrote = true;

    flock( $handle, LOCK_EX );
    if( !fwrite( $handle, $data ) )
      $wrote = false;

    flock( $handle, LOCK_UN );
    fclose( $handle );

    return $wrote;

  }//end public static function write */



  /**
   * @param string $fileName
   * @param string $mode
   *
   * @todo use fopen and fread instead of file_get_contents
   */
  public static function read( $fileName, $mode = 'r' )
  {

    if( !$handle = fopen( $fileName, $mode )  )
    {
      return null;
    }

    $data = null;

    flock( $handle, LOCK_SH );
    $data = stream_get_contents( $handle );
    flock( $handle, LOCK_UN );
    fclose( $handle );

    return $data;

  }//end public static function read */

  /**
   * Enter description here...
   *
   * @param string $fileName
   * @param string $delimiter
   * @param string $enclosure
   * @return string
   */
  public static function readCsv( $fileName, $delimiter = ';',  $enclosure = '"'  )
  {

    if( !$handle = fopen( $fileName, 'r' )  )
    {
      return null;
    }

    $data = array();

    flock( $handle, LOCK_SH );
    while ( ($row = fgetcsv( $handle, 0, $delimiter, $enclosure ) ) !== false )
    {
      $data[] = $row;
    }

    flock( $handle, LOCK_UN );
    fclose( $handle );

    return $data;

  }//end public static function readCsv */

  /**
   * @param string $fileName
   * @return string
   */
  public static function get( $fileName )
  {

    if( !file_exists( $fileName ) )
    {
      return null;
    }

    return file_get_contents( $fileName );

  }//end public static function get */

  /**
   * @param string $fileName
   * @param string $data
   * @todo use fopen and fread instead of file_get_contents
   */
  public static function readCache( $fileName  )
  {
    if( !file_exists( $fileName ) || !$handle = fopen( $fileName, 'r' )  )
    {
      return null;
    }

    $data = null;

    flock( $handle, LOCK_SH );
    $data = stream_get_contents( $handle );
    flock( $handle, LOCK_UN );
    fclose( $handle );

    return unserialize($data);

  }//end public static function readCache */

  /**
   * @param string $fileName
   * @param string $data
   *
   */
  public static function writeCache( $fileName ,$data )
  {

    if( !$handle = fopen( $fileName, 'w' )  )
    {
      Log::warn(__file__,__line__,'Failed to write: '.$fileName.' to cache');
      return false;
    }

    $wrote = true;

    flock( $handle, LOCK_EX );
    if( fwrite( $handle, serialize($data) ) === false  )
    {
      $wrote = false;
    }
    flock( $handle, LOCK_UN );
    fclose( $handle );

    if(!$wrote)
      Log::warn(__file__,__line__,'Failed to write: '.$fileName);

    return $wrote;

  }//end public static function writeCache */

  /**
   *
   * @param string $fileName
   * @return string
   */
  public static function getFilename( $fileName )
  {

    $data = pathinfo($fileName);
    return $data['basename'];

  }//end public static function getFilename */

  /**
   *
   * @param string $fileName
   * @return string
   */
  public static function getRealPath( $fileName )
  {

    $data = pathinfo($fileName);
    return realpath($data['dirname']);

  }//end public static function getRealPath */

  /**
   *
   * @param string $fileName
   * @return string
   */
  public static function getRealName( $fileName )
  {
    return realpath($fileName);
  }//end public static function getRealName */


  /**
   *
   * @param string $fileName
   * @return int
   */
  public static function getTimeCreated( $fileName )
  {
    return filectime($fileName);
  }//end public static function getRealName */
  
  /**
   *
   * @param string $fileName
   * @return string
   */
  public static function getPath( $fileName )
  {

    $data = pathinfo($fileName);
    return $data['dirname'];

  }//end public static function getPath */

  /**
   *
   * @param $fileName
   * @return array
   */
  public static function splitFilename( $fileName )
  {

    $data = pathinfo($fileName);
    return array($data['dirname'],$data['basename']);

  }//end public static function splitFilename */

  /**
   * @param string $father
   * @param string $child
   * @return boolean
   */
  public static function isChild( $father , $child )
  {

    return strpos( realpath($child) , realpath($father) ) === 0 ? true:false;

  }//end public static function isChild */

  /**
   * @param string $father
   * @param string $child
   * @return boolean
   */
  public static function getUploadPath( $entityName, $attrName, $id )
  {

    return PATH_GW.'data/uploads/'.$entityName.'/'.$attrName.SParserString::idToPath($id).'/'.$id;

  }//end public static function getUploadPath */

}//end class SFiles


