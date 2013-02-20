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
 * class class LibDownloadFile
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDownloadFile extends LibDownloadAdapter
{

  /**
   * Enter description here...
   *
   */
  public function prepare()
  {

    $httpRequest = Request::getActive();
    $orm         = Db::getOrm();

    if (!$fid = $httpRequest->param('file' , Validator::INT )) {
      throw new Io_Exception('Invalid File Requested :'. urlencode($fid) );
    }

    if (!$file = $orm->get( 'WbfsysFile', $fid)) {
      throw new Io_Exception('Invalid File Requested');
    }

    if ($filename = $httpRequest->param('filename','raw') ) {
      $this->fileName = $filename;
    } else {
      $this->fileName = $file->getData('name');
    }

    $this->fullpath = PATH_GW.'data/dms/'.$fid[0].'/';
    $this->fullpath .=  isset($fid[1])?$fid[1]:'0';
    $this->fullpath .= '/'.$fid;

  }//end public function download()

    /**
   * Enter description here...
   *
   */
  public function download()
  {

    if ( file_exists($this->fullpath ) ) {
      $this->setHeaderForceDownload($this->fileName );
      $this->stream($this->fullpath);
    } else {
      $this->setHeaderFileNotFound();
      throw new Io_Exception('File not Found');
    }

  }//end public function download */

} // end class LibDownloadFile

