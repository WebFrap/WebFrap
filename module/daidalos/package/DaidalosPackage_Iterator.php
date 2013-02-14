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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosPackage_Iterator extends IoFolderIterator
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var string
   */
  public $fileName = null;
  
  /**
   * @param string $folder
   */
  public function __construct($folder )
  {
    
    $this->folder = $folder;
    
    if ( is_dir($folder ) )
      $this->fRes = opendir($folder);
      
    Debug::console( 'open folder '.$folder );
    
    $this->next();

  }// public function __construct 
  
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
    
    $tmp = null;
    
    do
    {
      
      if (!is_resource($this->fRes ) )
        return null;
      
      $tmp = readdir($this->fRes );
      
      Debug::console('dir '.$tmp);
      
    } while ($tmp && !file_exists($this->folder.'/'.$tmp.'/package.bdl'  ) );
    
    if ($tmp )
    {
      $this->fileName  = $this->folder.'/'.$tmp.'/package.xml';
      $this->current   = new DaidalosPackage_File($this->folder.'/'.$tmp.'/package.bdl' );
    } else {
      $this->fileName  = null;
      $this->current   = null;
    }
    
    return $this->current;
    
  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    
    if (!is_resource($this->fRes ) )
      return null;
    
    rewinddir($this->fRes );
    
    $this->next();
    
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return $this->current ? true:false;
  }//end public function valid */
  
  
  
}//end class DaidalosPackage_Iterator */

