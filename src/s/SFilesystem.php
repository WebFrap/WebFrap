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
class SFilesystem
{
/*//////////////////////////////////////////////////////////////////////////////
// public methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $folder
   * @param boolean $rekursiv
   * @param boolean $absolut
   *
   * @return boolean
   */
  public static function createFolder($folder , $rekursiv = true , $absolut = false  )
  {

    if ($absolut)
    {
      $activFolder = '/';
    } else {
      if ($folder[0] == '.' )
        $activFolder = '';
      else
        $activFolder = './';
    }

    if ($rekursiv )
    {
      $folders = explode( '/' , $folder );

      foreach($folders as $tpFolder )
      {
        if (!file_exists($activFolder.$tpFolder ) )
        {

          if (!is_writeable($activFolder) )
          {
            throw new Io_Exception( 'Folder: '.$activFolder.' is not writeable' );
          }

          if (!mkdir($activFolder.$tpFolder) )
          {
            throw new Io_Exception( 'Failed to create folder: '.$activFolder.$tpFolder );
          }

        }

        $activFolder .= $tpFolder.'/';

      }//end foreach($folders as $tpFolder )
    } else {
      if ( is_dir($folder) )
       return true;

      if (!is_writeable($folder) )
      {
        throw new Io_Exception('Folder: '.$folder.' is not writeable');
      }

      if (!mkdir($folder) )
      {
        throw new Io_Exception('Failed to create folder: '.$folder);
      }

      return false;
    }

    return true;

  }//end public static function createFolder */
  
  /**
   * Den Directory Namen aus einem Pfad extrahieren
   * 
   * @param string $fileName
   * @return string
   */
  public static function dirname($fileName )
  {
    
    return dirname($fileName);

  }//end public static function dirname */
  
  /**
   * Den Dateinamen aus Pfaden extrahieren
   * 
   * @param string $fileName
   * @return string
   */
  public static function filename($fileName )
  {
    
    return basename($fileName);

  }//end public static function filename */


  /**
   * @param string $folder
   * @param boolean $rekursiv
   * @param boolean $absolut
   *
   * @return boolean
   */
  public static function mkdir($folder , $rekursiv = true , $absolut = false  )
  {

    if ( '' == trim($folder) )
      throw new Io_Exception( 'Called mkdir with empty folderstring' );
    
    if ($absolut)
    {
      $activFolder = '/';
    } else {
      if ($folder[0] == '.' )
        $activFolder = '';
      else
        $activFolder = './';
    }

    if ($rekursiv )
    {
      $folders = explode( '/' , $folder );

      foreach($folders as $tpFolder )
      {
        if (!file_exists($activFolder.$tpFolder ) )
        {

          if (!is_writeable($activFolder) )
          {
            if (Webfrap::classExists('Io_Exception'))
              throw new Io_Exception('Folder: '.$activFolder.' is not writeable');
            else 
              return false; 
          }

          if (!mkdir($activFolder.$tpFolder) )
          {
            if (Webfrap::classExists('Io_Exception'))
              throw new Io_Exception('Failed to create folder: '.$activFolder.$tpFolder);
            else 
              return false; 
              
          }

        }

        $activFolder .= $tpFolder.'/';

      }//end foreach($folders as $tpFolder )
    } else {
      if ( is_dir($folder) )
       return true;

      if (!is_writeable($folder) )
      {
        if (Webfrap::classExists('Io_Exception'))
          throw new Io_Exception('Folder: '.$folder.' is not writeable');
        else 
          return false; 
        
      }

      if (!mkdir($folder) )
      {
        if (Webfrap::classExists('Io_Exception'))
          throw new Io_Exception('Failed to create folder: '.$folder);
        else 
          return false; 
        
      }

      return false;
    }

    return true;

  }//end public static function mkdir */

  /**
   * extended touch
   * @param string $touch
   * @return boolean
   */
  public static function touch($file )
  {

    if (file_exists($file))
      return touch($file);

    $path     = dirname($file);
    //$filename = filename($file);
    
    //Log::error( "Touch dir: $path file: $file" );

    if (!is_dir($path) )
    {
      if (!self::mkdir($path) )
        return false;
    }

    return touch($file);

  }//end public static function touch */

  /**
   * extended touch
   * @param string $touch
   * @return boolean
   */
  public static function touchFolder($folder )
  {

    if (!file_exists($folder))
      self::mkdir($folder);

  }//end public static function touchFolder */
  
  /**
   * Sicher stellen, dass der Ordner für eine zu erstellende Datei auch
   * existiert
   * 
   * @param string $fileName
   * @return boolean
   */
  public static function touchFileFolder($fileName )
  {
    
    $filePath = dirname($fileName);

    if (!file_exists($filePath) )
      self::mkdir($filePath);

  }//end public static function touchFileFolder */

  /**
   * Prüfen ob der Pfad absolute oder relative ist
   * 
   * @param string $folder
   * @return boolean
   */
  public static function isAbsolute($folder )
  {
    return $folder[0] == '/' ? true:false;
  }//end public static function isAbsolute */

  /** 
   * method that deletes everything it gets rekursivly
   *
   * @param string Folder Der Pfad zum Ordner desse Inhalt man haben möchte
   * @return boolean
   */
  public static function delete($path , $isSub = false )
  {

    // if file not exists just ignore
    if (!file_exists($path))
      return false;

    if ( is_file($path ) )
    {
      if (!is_writeable($path) )
      {
        throw new Io_Exception
        (
          I18n::s
          (
           'file '.$path.' ist not deleteable ',
           'wbf.message.fileNotDeletable',
           array($path)
          )
        );
      }
      return unlink($path);
    }

    if ( is_dir($path ) )
    {
      if (!is_writeable($path ) )
      {
        throw new Io_Exception
        (
          I18n::s
          (
            'Folder '.$path.' ist not deleteable',
            'wbf.message',
            array($path)
          )
        );
      }

      $clean = true;

      // Read all content from folder and delete manual
      if ($dh = opendir($path))
      {
        while ( ($file = readdir($dh) ) !== false )
        {
          $tmpPath = $path;
          if ($file != "." and $file != ".." and $file != ".svn"  )
          {
            if ( is_dir($tmpPath.'/'.$file) )
            {
              // Rekursiv delete folder Content
              if (!self::delete($tmpPath.'/'.$file , true))
                $clean = false;
            }
            else
            {
              if (is_writeable($tmpPath.'/'.$file) )
              {
                if (!unlink($tmpPath.'/'.$file))
                  $clean = false;
              }
              else
              {
                Error::addError
                (
                  I18n::s
                  ( 
                    'File {@file@} is not deleteable.',
                    'wbf.message',
                    array
                    ( 
                      'file' => $tmpPath.'/'.$file
                    ) 
                  ),
                  'Io_Exception'
                );
              }
            }
          }
        }
        closedir($dh);
      }

      return rmdir($path);// Delete Folder at the end
    }

  }//end public static function delete */

  /** method that deletes everything it gets rekursivly
   *
   * @param string Folder Der Pfad zum Ordner desse Inhalt man haben möchte
   * @return boolean
   */
  public static function cleanFolder($path , $isSub = false )
  {

    if (!file_exists($path) )
      return false;

    if ( is_file($path ) )
    {
      if (!is_writeable($path) )
      {
        Error::cachtableError
        (
        I18n::s( 'wbf.message.fileNotDeleteable',array($path) ),
        'Io_Exception'
        );
      }
      return unlink($path);
    }

    if ( is_dir($path ) )
    {
      if (!is_readable($path ) or !is_writeable($path ) )
      {
        Error::cachtableError
        (
        I18n::s( 'wbf.message.folderInvalidRights',array($path) ),
        'Io_Exception'
        );
      }

      $clean = true;

      // Read all content from folder and delete manual
      if ($dh = opendir($path))
      {
        while ( ($file = readdir($dh) ) !== false )
        {
          $tmpPath = $path;
          if ($file != "." and $file != ".." and $file != ".svn"  )
          {
            if ( is_dir($tmpPath.'/'.$file) )
            {
              // Rekursiv delete folder Content
              if (!self::cleanFolder($tmpPath.'/'.$file , true))
                $clean = false;
            }
            else
            {
              if (is_writeable($tmpPath.'/'.$file) )
              {
                if (!unlink($tmpPath.'/'.$file))
                  $clean = false;
              }
              else
              {
                Error::cachtableError
                (
                I18n::s
                (
                  'the file '.$tmpPath.'/'.$file.' is not deleteable ',
                  'wbf.message.fileNotDeleteable',array($tmpPath.'/'.$file)
                ),
                'Io_Exception'
                );
              }
            }
          }
        }
        closedir($dh);
      }

      if ($isSub )
        return rmdir($path);// Delete Folder at the end
      else
        return true;
    }

  }//end public static function delete */

  /** method that deletes everything it gets rekursivly
   *
   * @param string $path
   * @param string $target
   * @param string $isSub
   * @return boolean
   */
  public static function copy($path , $target, $isSub = false )
  {

    if (!file_exists($path) )
    {

      Error::addError
      (
      I18n::s( 'The file: '.$path.' not exists' , 'wbf.message.fileNotExists',array($path) ),
      'Io_Exception'
      );
    }

    if ( is_file($path ) )
    {
      return self::copyFile($path , $target );
    }

    if ( is_dir($path ) )
    {
      return self::copyFolder($path , $target);
    }

    return false;

  }//end public static function copy */

  /** method that deletes everything it gets rekursivly
   *
   * @param string $path
   * @param string $target
   * @param string $isSub
   * @return boolean
   */
  public static function replace($path , $target, $isSub = false )
  {

    if (!is_readable($path))
    {
      Error::addError
      (
        I18n::s( 'The file: '.$path.' not exists' , 'wbf.message.fileNotExists',array($path) ),
        'Io_Exception'
      );
    }

    $success = false;

    if ( is_file($path ) )
    {
      $success = self::copyFile($path , $target );
    }

    if ( is_dir($path ) )
    {
      $success = self::copyFolder($path , $target);
    }

    if ($success )
    {
      return self::delete($path , $isSub   );
    }

  }//end public static function replace */

  /** method that deletes everything it gets rekursivly
   *
   * @param string $path
   * @param string $target
   * @param string $isSub
   * @return boolean
   */
  public static function merge($path , $target, $isSub = false )
  {

    if (!file_exists($path) )
    {
      Error::addError
      (
      I18n::s( 'Die Datei '.$path.' existiert nicht', 'wbf.message.fileNotExists',array($path) ),
      'Io_Exception'
      );
    }

    if ( is_file($path ) )
      return self::mergeFile($path , $target );

    if ( is_dir($path ) )
      return self::mergeFolder($path , $target);

    return false;

  }//end public static function merge */

  /** method that deletes everything it gets rekursivly
   *
   * @param string $path
   * @param string $target
   * @param string $isSub
   * @return boolean
   */
  public static function retrofit($path , $target, $isSub = false )
  {

    if (!file_exists($path))
    {
        Error::addError
        (
        I18n::s( 'Die Datei '.$path.' existiert nicht', 'wbf.message.fileNotExists',array($path) ),
        'Io_Exception'
        );
    }

    if ( is_file($path ) )
      return self::mergeFile($path , $target );

    if ( is_dir($path ) )
      return self::mergeFolder($path , $target);

    return false;

  }//end public static function merge */



  /**
   * Enter description here...
   * @param string $path
   * @param string $target
   *
   */
  public static function copyFolderContent($path , $target)
  {

    $status = true;

    if (!is_readable($path ) )
    {
      Error::addError
      (
        I18n::s( 'wbf.message.folderInvalidRights',array($path) ),
        'Io_Exception'
      );
    }

    if (!file_exists($target) )
      if (!mkdir($target))
        $status = false;

    if (!is_dir($target) )
    {
      Error::addError
      (
        "Invalide Pfadangabe: ".$path,
        //I18n::s( 'wbf.message.targetIsNoFolder',array($path) ),
        'Io_Exception'
      );
    }

    if (!is_writeable($target)  )
    {
      Error::addError
      (
        "Ungenügende Rechte für Pfadangabe: ".$path,
        //I18n::s( 'wbf.message.targetInvalidRights',array($path) ),
        'Io_Exception'
      );
    }

    $folder = SParserString::getPathFileName($path);

    // Read all content from folder and delete manual
    if ($dh = opendir($path))
    {
      while ( ($file = readdir($dh) ) !== false )
      {
        $tmpPath = $path;
        if ($file != "." and $file != ".." and $file != ".svn"  )
        {

          if ( is_file($path.'/'.$file) )
          {
            if (!self::copyFile($path.'/'.$file , $target.'/'.$file ));
              $status = false;

            continue;
          }
          else
          {
            if (!self::copyFolder($path.'/'.$file , $target.'/'.$file))
              $status = false;
          }

        }
      }//end while
      closedir($dh);
    }//end if

    return true;

  }//end protected function copyFolderContent */
  
  /**
   * @param string $folder
   * @return int
   */
  public static function getFolderSize($folder )
  {
    
    if (!file_exists($folder ) )
      return 0;
    
    Response::collectOutput();
    $data = explode( "\t", system( "du -hs ".$folder ) ) ;
    Response::getOutput();
    
    return $data[0];
    
  }
  
  /**
   * @param string $folder
   * @return int
   */
  public static function countFiles($folder )
  {
    
    if (!file_exists($folder ) )
      return 0;
    
    Response::collectOutput();
    $data = system( "find ".$folder." -type f | wc -l " );
    Response::getOutput();
    
    return $data;
    
  }//end public static function countFiles */

  /**
   * @param string $folder
   * @return int
   */
  public static function timeChanged($folder )
  {
    
    if (!file_exists($folder ) )
      return '';

    return date ( "Y-m-d H:i:s", filemtime($folder ) );
    
  }//end public static function countFiles */

/*//////////////////////////////////////////////////////////////////////////////
// protected methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $path
   * @param unknown_type $target
   * @return unknown
   */
  protected static function copyFile($path , $target )
  {
    if (!is_readable($path) )
    {
      throw new Io_Exception(I18n::s( 'wbf.message.fileNotReadable',array($path) ));
    }

    self::touchFolder( SParserString::getFileFolder($target)  );

    return copy($path , $target);

  }//end protected function copyFile */

  /**
   * Enter description here...
   *
   */
  protected static function copyFolder($path , $target)
  {

    $status = true;

    if (!is_readable($path ) )
    {
      Error::addError
      (
        I18n::s( 'wbf.message.folderInvalidRights',array($path) ),
        'Io_Exception'
      );
    }

    if (!file_exists($target) )
      if (!mkdir($target))
        $status = false;

    if (!is_dir($target) )
    {
      Error::addError
      (
        "Pfad ist kein Verzeichnis: ".$path,
        //I18n::s( 'wbf.message.targetIsNoFolder',array($path) ),
        'Io_Exception'
      );
    }

    if (!is_writeable($target)  )
    {
      Error::addError
      (
        "Invalide Rechte für Pfad: ".$path,
        //I18n::s( 'wbf.message.targetInvalidRights',array($path) ),
        'Io_Exception'
      );
    }

    $folder = SParserString::getPathFileName($path);

    // Read all content from folder and delete manual
    if ($dh = opendir($path))
    {
      while ( ($file = readdir($dh) ) !== false )
      {
        $tmpPath = $path;
        if ($file != "." and $file != ".." and $file != ".svn"  )
        {

          if ( is_file($path.'/'.$file) )
          {
            if (!self::copyFile($path.'/'.$file , $target.'/'.$file ));
              $status = false;

            continue;
          }
          else
          {
            if (!self::copyFolder($path.'/'.$file , $target.'/'.$file))
              $status = false;

          }
        }
      }//end while
      
      closedir($dh);
    }//end if


    return true;

  }//end protected function copyFolder */

  /**
   * Enter description here...
   *
   * @param string $path
   * @param string $target
   * @return boolean
   */
  protected static function mergeFile($path , $target )
  {

    if (!is_readable($path) )
    {
      Error::addError
      (
        I18n::s( 'wbf.message.fileNotReadable',array($path) ),
        'Io_Exception'
      );
    }

    if (!is_writeable( SParserString::getFileFolder($target) ) )
    {
      Error::addError
      (
        I18n::s( 'wbf.message.folderNotWriteable',array($target) ),
        'Io_Exception'
      );
    } else {
      if (!file_exists($target ) )
        return copy($path , $target);

      else
        return true;
    }

  }//end protected function mergeFile */

  /**
   * @param string $path
   * @param string $target
   *
   */
  protected static function mergeFolder($path, $target )
  {

    $status = true;

    if (!is_readable($path ) )
    {
      
      throw new Io_Exception
      (
        I18n::s
        ( 
          'Folder Invalid Rights {@folder@}', 
          'wbf.message',
          array( 'folder' => $path ) 
        )
      );
    }

    if (!file_exists($target) )
      if (!mkdir($target) )
        $status = false;

    if (!is_dir($target) )
    {
      Error::addError
      (
        "Invalide Pfadangabe: ".$path,
        //I18n::s( 'wbf.message.targetIsNoFolder',array($path) ),
        'Io_Exception'
      );
    }

    if (!is_writeable($target)  )
    {
      Error::addError
      (
        "Invalide Rechte für Pfad: ".$path,
        //I18n::s( 'wbf.message.targetInvalidRights',array($path) ),
        'Io_Exception'
      );
    }

    $folder = SParserString::getPathFileName($path);

    // Read all content from folder and delete manual
    if ($dh = opendir($path) )
    {
      
      while ( ($file = readdir($dh) ) !== false )
      {
        $tmpPath = $path;
        if ($file != "." and $file != ".." and $file != ".svn"  )
        {

          if ( is_file($path.'/'.$file) )
          {
            if (!self::mergeFile($path.'/'.$file , $target.'/'.$file ));
              $status = false;

            continue;
          }
          else
          {
            if (!self::mergeFolder($path.'/'.$file , $target.'/'.$file))
              $status = false;

          }
        }
      }//end while
      
      closedir($dh);
    }//end if

    return true;

  }//end protected function mergeFolder */


}// end class SFilesystem
