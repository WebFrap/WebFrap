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
 * @subpackage tech_core/cache
 */
class LibCacheRequest
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $folder = null;

  /**
   * @var string
   */
  protected $contentType = null;


/*//////////////////////////////////////////////////////////////////////////////
// Methode
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Einen 404er Header ausgeben, um dem Client mitzuteilen das die Angefragte
   * Resource nicht existiert
   *
   * @return void
   */
  public function notFound()
  {
    header('HTTP/1.0 404 Not Found');
  }//end public function notFound


  /**
   * @param string $list
   */
  public function loadFileFromCache( $file )
  {

    if( isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) )
    {

      $etag = $_SERVER['HTTP_IF_NONE_MATCH'];

      if
      (
        isset($_SERVER['HTTP_ACCEPT_ENCODING'])
          && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
          && function_exists( 'gzencode' )
      )
      {
        $fileName = PATH_GW.$this->folder.'/file/'.$file.'.gz';
        $etagName = PATH_GW.$this->folder.'/file/'.$file.'.gz.md5';
      }
      else
      {
        $fileName = PATH_GW.$this->folder.'/file/'.$file.'.plain';
        $etagName = PATH_GW.$this->folder.'/file/'.$file.'.plain.md5';
      }

      if( file_exists( $fileName ) )
      {
        $saveTag = file_get_contents( $etagName );
        if( $saveTag == $etag )
        {
          ob_end_clean();
          header('ETag: '.$etag );
          header('HTTP/1.0 304 Not Modified');
          exit(0);
        }
      }//end if( file_exists( PATH_GW.'cache/css/'.$list.'css' ) )

    }
    else
    {

      if( file_exists( PATH_GW.$this->folder.'/file/'.$file ) )
      {

        if( isset($_SERVER['HTTP_ACCEPT_ENCODING'])
          && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') )
        {
          // Tell the browser the content is compressed with gzip
          header ("Content-Encoding: gzip");
          $out  = file_get_contents(  PATH_GW.$this->folder.'/file/'.$file.'.gz' );
          $etag = file_get_contents(  PATH_GW.$this->folder.'/file/'.$file.'.gz.md5' );
        }
        else
        {
          $out  = file_get_contents(  PATH_GW.$this->folder.'/file/'.$file.'.plain' );
          $etag = file_get_contents(  PATH_GW.$this->folder.'/file/'.$file.'.plain.md5' );
        }

        header('content-type: '.$this->contentType );
        header('ETag: '.$etag );
        header('Content-Length: '.strlen( $out ));
        header('Expires: Thu, 13 Nov 2179 00:00:00 GMT' );
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );

        echo $out;
        return true;

      }//end if

    }//end else

  }//end public function loadListFromCache */

  /**
   * @param string $list
   */
  public function loadListFromCache( $list )
  {

    if( DEBUG )
      return false;

    if( isset($_SERVER['HTTP_IF_NONE_MATCH'])  )
    {

      $etag = $_SERVER['HTTP_IF_NONE_MATCH'];

      if
      (
        isset($_SERVER['HTTP_ACCEPT_ENCODING'])
          && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
          && function_exists( 'gzencode' )
      )
      {
        $fileName = PATH_GW.$this->folder.'/list/'.$list.'.gz';
        $etagName = PATH_GW.$this->folder.'/list/'.$list.'.gz.md5';
      }
      else
      {
        $fileName = PATH_GW.$this->folder.'/list/'.$list.'.plain';
        $etagName = PATH_GW.$this->folder.'/list/'.$list.'.plain.md5';
      }


      if( file_exists( $fileName ) )
      {
        $saveTag = file_get_contents( $etagName );

        if( $saveTag == $etag )
        {

          header('ETag: '.$etag );
          header('HTTP/1.0 304 Not Modified');
          return true;
        }

      }//end if( file_exists( PATH_GW.'cache/css/'.$list.'css' ) )

      return false;

    }//end if( isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) )
    else
    {


      if
      (
        isset($_SERVER['HTTP_ACCEPT_ENCODING'])
          && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
          && function_exists( 'gzencode' )
      )
      {
        // Tell the browser the content is compressed with gzip
        header ("Content-Encoding: gzip");
        $fileName = PATH_GW.$this->folder.'/list/'.$list.'.gz' ;
        $cEtagFile = PATH_GW.$this->folder.'/list/'.$list.'.gz.md5' ;
      }
      else
      {
        $fileName = PATH_GW.$this->folder.'/list/'.$list.'.plain';
        $cEtagFile = PATH_GW.$this->folder.'/list/'.$list.'.plain.md5';
      }

      if( file_exists( $fileName ) )
      {

        $out = file_get_contents( $fileName );
        $cEtag = file_get_contents( $cEtagFile );

        header('content-type: '.$this->contentType );
        header('ETag: '.$cEtag );
        header('Content-Length: '.strlen( $out ));
        header('Expires: Thu, 13 Nov 2179 00:00:00 GMT' );
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );

        echo $out;
        return true;

      }//end if

    }//end else

    return false;

  }//end public function loadListFromCache */

  /**
   * Den Request Cache leeren. Es werden alle gecachten Listen und Files gelöscht
   * @return void
   */
  public function clean()
  {

    SFilesystem::cleanFolder(  PATH_GW.$this->folder.'/list/' );
    SFilesystem::cleanFolder(  PATH_GW.$this->folder.'/file/' );

  }//end public function clean

} // end class LibCacheRequest

