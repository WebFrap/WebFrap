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
 * class LibDownloadAdapter
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class LibDownloadAdapter
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $basePath = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $fileName = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $fullpath = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $bandwith = null;

  /**
   * Enter description here...
   *
   */
  protected function setHeaderFileNotFound()
  {
    header( 'HTTP/1.1 404 Not Found' );
    header( 'Status: 404 Not Found' );
  }//end protected function fileNotFound()

  /**
   * Enter description here...
   *
   */
  protected function setHeaderNoCache()
  {
    header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
    header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
    header( 'Cache-Control: post-check=0, pre-check=0', false );
    header( 'Pragma: no-cache' );
  }

  /**
   * Enter description here...
   *
   */
  protected function setHeaderForceDownload( $filename , $type = null )
  {
    switch ($type) {
      case 'pdf': $ctype='application/pdf'; break;
      case 'xml': $ctype='text/xml'; break;
      case 'exe': $ctype='application/octet-stream'; break;
      case 'zip': $ctype='application/zip'; break;
      case 'doc': $ctype='application/msword'; break;
      case 'xls': $ctype='application/vnd.ms-excel'; break;
      case 'ppt': $ctype='application/vnd.ms-powerpoint'; break;
      case 'gif': $ctype='image/gif'; break;
      case 'png': $ctype='image/png'; break;
      case 'jpeg':
      case 'jpg': $ctype='image/jpg'; break;
      case 'mp3': $ctype='audio/mpeg'; break;
      case 'wav': $ctype='audio/x-wav'; break;
      case 'mpeg':
      case 'mpg':
      case 'mpe': $ctype='video/mpeg'; break;
      case 'mov': $ctype='video/quicktime'; break;
      case 'avi': $ctype='video/x-msvideo'; break;

      default: $ctype='application/force-download';
    }

    header('Content-Description: File Transfer');
    header('Content-Type: '.$ctype);
    header('Content-Disposition: attachment; filename="'.$filename.'"');

  }//end protected function fileNotFound()

  /**
   * Enter description here...
   *
   * @param String $filename
   */
  public function stream( $filename )
  {
    readfile($filename);
  }//end public function stream( $filename )

  /**
   * Enter description here...
   *
   */
  abstract public function prepare();

  /**
   * Enter description here...
   *
   */
  abstract public function download();

} // end abstract class LibDownloadAdapter
