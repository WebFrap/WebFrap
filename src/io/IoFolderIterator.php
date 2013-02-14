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
class IoFolderIterator
  implements Iterator
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /** Folder in dem die Datei gespeichert war
   * @var string
   */
  protected $folder = null;
  

  /** Folder in dem die Datei gespeichert war
   * @var string
   */
  protected $fRes = null;
  
  protected $current = null;

  /**
   * @var string
   */
  protected $activFolder = null;


/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $folder
   */
  public function __construct( $folder )
  {
    
    $this->folder = $folder;
    
    if( is_dir($folder) )
      $this->fRes = opendir($folder);

  }// public function __construct 
  
  /**
   */
  public function __desctruct( )
  {

    $this->close();

  }//end public function __desctruct */
  
  /**
   */
  public function close( )
  {
    
    if( is_resource( $this->fRes ) )
      closedir( $this->fRes );

  }//end public function __desctruct */

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
   * @param boolean $asObject
   */
  public function getFolders( $asObject = true )
  {

    $folders = array();

    if($asObject)
    {
      while ( ($subF = readdir($this->fRes) ) !== false )
      {
        if( $subF[0] != "." and is_dir($this->folder.'/'.$subF) )
        {
          $folders[] = new IoFolderIterator( $this->folder.'/'.$subF);
        }
      }
    }
    else
    {
      while ( ($subF = readdir($this->fRes) ) !== false )
      {
        if( $subF[0] != "." and is_dir($this->folder.'/'.$subF) )
        {
          $folders[] = $this->folder.'/'.$subF;
        }
      }
    }

    return $folders;

  }//end public function getFolders */

  /**
   *
   */
  public function getPlainFolders( $sortAsc = null )
  {

    $folders = array();

    while ( ($subF = readdir($this->fRes) ) !== false )
    {
      if( $subF[0] != "." and is_dir($this->folder.'/'.$subF) )
      {
        $folders[] = $subF;
      }
    }
      
    if( is_null($sortAsc) )
      return $folders;
      
    if( $sortAsc )
      asort( $folders );
    else 
      arsort( $folders ); 
      
    return $folders;

  }//end public function getPlainFolders */

  /**
   * @param boolean $asObject
   * @return array<String>/array<IoFile>
   */
  public function getFiles( $asObject = true )
  {

    $files = array();

    if( $asObject )
    {
      while ( ($subF = readdir($this->fRes) ) !== false )
      {
        if( $subF[0] != "." and !is_dir( $this->folder.'/'.$subF ) )
        {
          $files[$subF] = new IoFile( $this->folder.'/'.$subF );
        }
      }
    }//end if( $asObject )
    else
    {
      while ( ($subF = readdir($this->fRes) ) !== false )
      {
        if( $subF[0] != "." and is_file( $this->folder.'/'.$subF ) )
        {
          $files[$subF] = $this->folder.'/'.$subF;
        }
      }
    }//end else( $asObject )

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


    if($asObject)
    {
      if(  is_dir($folder) && $dh = opendir($folder) )
      {
        while ( ($subF = readdir($dh) ) !== false )
        {
          if( $subF == "." ||  $subF == ".." )
            continue;

          if( is_file( $folder.'/'.$subF ) )
          {
            if( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending )
            {
              $files[$folder.'/'.$subF] = new IoFile( $folder.'/'.$subF );
            }
          }
          else if( $rekursiv  && is_dir( $folder.'/'.$subF )  )
          {
            $files = $this->getFilesByEnding( $ending, $asObject, $rekursiv, $files, $folder.'/'.$subF.'/'  );
          }

        }
        closedir($dh);
      }
    }
    else
    {
      if( is_dir( $folder ) && $dh = opendir($folder) )
      {
        while ( ($subF = readdir($dh) ) !== false )
        {

          if( $subF == "." ||  $subF == ".." )
            continue;

          if(  is_file( $folder.'/'.$subF ) )
          {
            if( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending )
            {
              $files[$folder.'/'.$subF] = $folder.'/'.$subF;
            }
          }
          else if( $rekursiv  && is_dir( $folder.'/'.$subF )  )
          {
            $files = $this->getFilesByEnding( $ending, $asObject, $rekursiv, $files, $folder.'/'.$subF.'/'  );
          }

        }
        closedir($dh);
      }
    }

    ksort( $files );

    return $files;

  }//end public function getFilesByEnding */

  /**
   * @param boolean $asObject
   */
  public function getPlainFiles( $sortAsc = null )
  {

    $files = array();

    if( is_dir($this->folder) && $dh = opendir($this->folder) )
    {
      while ( ($subF = readdir($dh) ) !== false )
      {
        if( $subF[0] != "." and is_file( $this->folder.'/'.$subF ) )
        {
          $files[$subF] = $subF;
        }
      }
      closedir($dh);
    }
    
    
    if( is_null( $sortAsc ) )
      return $files;
      
    if( $sortAsc )
      ksort( $files );
    else 
      krsort( $files ); 

    return $files;

  }//end public function getPlainFiles( )

  /**
   *
   */
  public function getPlainFilesByEnding( $ending )
  {

    $files = array();

    if( is_dir($this->folder) && $dh = opendir($this->folder) )
    {
      while ( ($subF = readdir($dh) ) !== false )
      {
        if( $subF[0] != "." and is_file( $this->folder.'/'.$subF ) )
        {
          if( substr($subF , -(strlen($ending)), strlen($ending) ) == $ending )
          {
            $files[$subF] = $subF;
          }
        }
      }
      closedir($dh);
    }

    ksort($files);

    return $files;

  }//end public function getPlainFilesByEnding( $ending )

  /**
   * @return string
   */
  public function getActivFolder()
  {

    if( is_null($this->activFolder) )
    {
      $folder = trim($this->getFoldername());

      if($folder[(strlen($folder)-1)] == '/')
        $folder = substr( $folder, 0, -1 );

      $add = ($folder[0] == '/' or $folder[0] == '.')  ? 1 : 0;

      $folderEnd = strrpos( $folder, '/' ) + $add;
      $this->activFolder = substr( $folder , $folderEnd );
    }

    return $this->activFolder;

  }//end public function getActivFolder */
  
/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current ()
  {
    
    return $this->current;
    
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return $this->current;
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {
    $this->current = readdir( $this->fRes );
    
    return $this->current;
  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    rewinddir($this->fRes);
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return $this->current ? true:false;
  }//end public function valid */

} // end class LibFilesystemFolder

