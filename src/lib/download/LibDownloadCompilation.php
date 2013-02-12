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
 * class class LibDownloadCompilation
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDownloadCompilation
  extends LibDownloadAdapter
{

  /**
   */
  public function prepare()
  {

    $request = Request::getActive();

    if ( !$fileName = $request->param( 'file' , 'Filename' ) ) {
      throw new Io_Exception('Invalid File Requested :'. urlencode($fileName) );
    }

    $this->fileName = $fileName;

    $this->fullpath = PATH_GW.'data/genf_compilation/'.$fileName;

  }//end public function prepare */

  /**
   */
  public function download()
  {

    if (file_exists( $this->fullpath )) {
      $this->setHeaderForceDownload( $this->fileName );
      $this->stream($this->fullpath);
    } else {
      $this->setHeaderFileNotFound();
      throw new Io_Exception('File not Found');
    }

  }//end public function download */

} // end class LibDownloadFile
