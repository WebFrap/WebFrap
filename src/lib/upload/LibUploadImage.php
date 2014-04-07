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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibUploadImage extends LibUploadAdapter
{

    
    /**
     * @var string $thumbPath
     */
    protected $thumbPath = null;

    /**
     * @var string $thumbName
     */
    protected $thumbName = null;

    /**
     * @param string
     */
    public function setThumbPath($thumbPath)
    {
        $this->thumbPath = $thumbPath;
    } // end public function setThumbPath
    
    /**
     * @param string
     */
    public function setThumbName($thumbName)
    {
        $this->thumbName = $thumbName;
    } // end public function setThumbPath
    

    /**
     * @param string $newName
     * @param string $thumbPath
     * @param int $x
     * @param int $y
     */
    public function thumb($newName = null, $thumbPath = null, $x = 100, $y = 100)
    {
        if ($thumbPath) {
            $this->thumbPath = $thumbPath;
        }
        if (!$this->thumbPath) {
            $this->thumbPath = PATH_UPLOADS.'images/thumb/';
        }
        
        if ($newName) {
            $this->thumbName = $newName;
        }
        
        return $this->convert($this->thumbName, $this->thumbPath, $x, $y);
        
    } // end public function copyThumb */
    
    /**
     * @param string $newName            
     * @param string $thumbPath            
     * @param int $x            
     * @param int $y            
     * @return string
     */
    public function convert($newname = null, $newpath = null, $x = 640, $y = 480)
    {
        if ($newpath) {
            $this->newpath = $newpath;
        }
        
        if ($newname) {
            $this->newname = $newname;
        }
        
        if (! $this->newpath) {
            $this->newpath = PATH_UPLOADS.'images/';
        }
        
        if (is_null($this->newname)) {
            $newname = $this->newpath.'/'.$this->oldname;
        } else {
            $newname = $this->newpath.'/'.$this->newname;
        }
        
        // Wenn der Ordner nicht existiert, einfach versuchen zu erstellen
        if (! is_dir($this->newpath)) {
            if (!SFilesystem::mkdir($this->newpath)) {
                throw new LibUploadException('Failed to create Folder: '.$this->newpath);
            }
        }
        
        // Falls der Ordner nicht beschreibbar ist Fehler werfen
        if (! is_writeable($this->newpath)) {
            throw new LibUploadException('Target Folder :  '.$this->newpath.' is not writeable');
        }
        
        
        /* @var $thumb LibImageThumbGd  */
        $thumb = LibImageThumbFactory::getThumb($this->tmpname);
        
        $thumb->resize($newname, $x, $y);
        $this->copies[] = $newname;
        
        return $newname;
        
    } // end public function convert($newname = null)
    
 
} // end class LibUploadImage

