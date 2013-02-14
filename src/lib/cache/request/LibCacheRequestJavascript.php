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
 * @subpackage tech_core/cache
 */
class LibCacheRequestJavascript extends LibCacheRequest
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  protected $folder = 'cache/javascript/';

  /**
   *
   * @var string
   */
  protected $contentType = 'application/javascript';

/*//////////////////////////////////////////////////////////////////////////////
// Methode
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $list
   */
  public function publishFile($file )
  {

    $map = array();
    include PATH_GW.'/conf/include/javascript/files.map.php';

    if (!isset($map[$file] )  )
    {
      header('HTTP/1.0 404 Not Found');
      return;
    }

    $code = file_get_contents($map[$file] );

    $codeEtag = md5($code );

    if (!file_exists( PATH_GW.$this->folder.'/file/' ) )
      SFilesystem::createFolder( PATH_GW.$this->folder.'/file/' );

    file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.plain' ,  $code );
    file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.plain.md5' ,  $codeEtag );

    $encode = function_exists('gzencode') ? !DEBUG : false;

    if ($encode )
    {

      $encoded = gzencode($code );
      $encodedEtag = md5($encoded );

      file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.gz' ,  $encoded );
      file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.gz.md5' ,  $encodedEtag );

    }

    if ( isset($_SERVER['HTTP_ACCEPT_ENCODING'] )
      && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' )
    )
    {
      // Tell the browser the content is compressed with gzip
      header ("Content-Encoding: gzip");
      $out = $encoded;
      $etag = $encodedEtag;
    } else {
      $out = $code;
      $etag = $codeEtag;
    }

    header( 'content-type: application/javascript' );
    header( 'ETag: '.$etag );
    header( 'Content-Length: '.strlen($out ) );
    header( 'Expires: Thu, 13 Nov 2179 00:00:00 GMT' );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );

    echo $out;

  }//end public function publishFile */

  /**
   * @param string $list
   */
  public function publishList($list )
  {

    $files  = array();
    $jsconf = null; // wird im include gesetzt
    $minify = true;

    if
    (
      isset($_SERVER['HTTP_ACCEPT_ENCODING'])
        && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
        && !DEBUG
    )
    {
      $sendEncoded = true;
    } else {
      $sendEncoded = false;
    }

    if ( function_exists('gzencode') )
    {
      $encode = true;
    } else {
      $sendEncoded  = false;
      $encode       = false;
    }

    if ( isset($_GET['encode'] ) && 'false' == $_GET['encode'] )
    {
      $sendEncoded  = false;
    }

    if ($sendEncoded )
    {
      if ( is_file( PATH_GW.$this->folder.'/list/'.$list.'.gz' ) )
      {
        $metadata = json_decode( file_get_contents( PATH_GW.$this->folder.'/list/'.$list.'.gz.meta' ) );

        if ( isset($_SERVER['HTTP_IF_NONE_MATCH'] ) && $_SERVER['HTTP_IF_NONE_MATCH'] == $metadata->etag )
        {
          header("HTTP/1.1 304 Not Modified"); // Browser mitteilen das Seite unverändert
          header("Connection: Close"); // Keep-Alives unterbinden
          exit();
        }

        $this->sendHeader($metadata->etag, $metadata->size, true);
        echo file_get_contents( PATH_GW.$this->folder.'/list/'.$list.'.gz'  );
        exit();
      }
    } else {
      if ( is_file( PATH_GW.$this->folder.'/list/'.$list.'.plain' ) )
      {
        $metadata = json_decode( file_get_contents( PATH_GW.$this->folder.'/list/'.$list.'.plain.meta' ) );

        if ( isset($_SERVER['HTTP_IF_NONE_MATCH'] ) && $_SERVER['HTTP_IF_NONE_MATCH'] == $metadata->etag )
        {
          header("HTTP/1.1 304 Not Modified"); // Browser mitteilen das Seite unverändert
          header("Connection: Close"); // Keep-Alives unterbinden
          exit();
        }

        $this->sendHeader($metadata->etag, $metadata->size, false );
        echo file_get_contents( PATH_GW.$this->folder.'/list/'.$list.'.plain' );
        exit();
      }
    }

    $code = '';
    include PATH_GW.'/conf/include/javascript/'.$list.'.list.php';

    if ($jsconf )
    {
      ob_start();
      include PATH_GW.'/js_conf/conf.js';
      //include $jsconf;
      $code = ob_get_contents();
      ob_end_clean();
    }

    if ($files )
    {
      if (!DEBUG && $minify )
      {

        if (!file_exists( PATH_GW.'cache/jsmin/' ) )
          SFilesystem::createFolder( PATH_GW.'cache/jsmin/' );

        foreach($files as $file )
        {

          $realPath = trim(realpath($file));
          // windows laufwerk fix
          if ($realPath[1] == ':' )
          {
            $realPath = str_replace( '\\', '/', substr($realPath, 2)) ;
          }


          $cacheFile = PATH_GW.'cache/jsmin/'.$realPath;

          try
          {

            if (!file_exists( dirname($cacheFile) ) )
              SFilesystem::createFolder( dirname($cacheFile) );

            if (!file_exists($cacheFile ) )
            {
              system( 'java -jar '.PATH_WGT.'compressor/yuicompressor.jar "'.$file.'" --type js --charset utf-8 -o "'.$cacheFile.'"' );
            }

            //$code .= '/* java java -jar '.PATH_WGT.'compressor/yuicompressor.jar "'.$file.'" --type js --charset utf-8   -o "'.$file.'.min" */'.NL;
            $code .= file_get_contents($cacheFile ).NL;

          }
          catch (Exception $e)
          {
            $code .= '/* '.$e->getMessage().' */'.NL;
          }
        }
      } else {
        foreach($files as $file )
        {
          $code .= file_get_contents($file ).NL;
        }
      }
    }

    /*
    if (!DEBUG && Webfrap::classLoadable('LibVendorJsmin') && $minify )
    {
      $minifier = LibVendorJsmin::getInstance();
      $code     = $minifier->minify($code );
    }
    */

    $etag       = md5($code );
    $plainSize  = strlen($code );

    if (!file_exists( PATH_GW.$this->folder.'/list/' ) )
      SFilesystem::createFolder( PATH_GW.$this->folder.'/list/'  );

    file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.plain' ,  $code );
    file_put_contents
    (
      PATH_GW.$this->folder.'/list/'.$list.'.plain.meta' ,
      json_encode( array( 'etag'=> $etag, 'size'=> $plainSize ) )
    );


    if ($encode )
    {
      $encoded      = gzencode($code );
      $encodedSize  = strlen($encoded );

      file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.gz' ,  $encoded );
      file_put_contents
      (
        PATH_GW.$this->folder.'/list/'.$list.'.gz.meta' ,
        json_encode( array( 'etag'=> $etag, 'size'=> $encodedSize ) )
      );
    }

    if ($sendEncoded )
    {
      $out  = $encoded;
      $size = $encodedSize;

    } else {
      $out  = $code;
      $size = $plainSize;
    }

    $this->sendHeader($etag, $size, $sendEncoded );

    echo $out;

  }//end public function publishList */


  /**
   * @param string $list
   */
  public function rebuildList($list )
  {

    if (!file_exists( PATH_GW.'/conf/include/javascript/'.$list.'.list.php' ) )
      throw new ResourceNotExists_Exception( "Js list {$list}" );

    $files  = array();
    $jsconf = null; // wert wird im include gesetzt
    $minify = true;

    include PATH_GW.'/conf/include/javascript/'.$list.'.list.php';


    if ( function_exists('gzencode') )
    {
      $encode = true;
    } else {
      $encode       = false;
    }

    $code = '';


    if ($jsconf )
    {
      ob_start();
      include PATH_GW.'/js_conf/conf.js';
      //include $jsconf;
      $code = ob_get_contents();
      ob_end_clean();
    }

    if ($files )
    {
      if ($minify )
      {

        if ( file_exists( PATH_GW.'tmp/js_min/' ) )
          SFilesystem::delete( PATH_GW.'tmp/js_min/' );

        SFilesystem::createFolder( PATH_GW.'tmp/js_min/' );

        foreach($files as $file )
        {

          $realPath = trim(realpath($file));
          // windows laufwerk fix
          if ( isset($realPath[1] ) && $realPath[1] == ':' )
          {
            $realPath = str_replace( '\\', '/', substr($realPath, 2)) ;
          }


          $cacheFile = PATH_GW.'tmp/js_min/'.$realPath;

          try
          {

            if (!file_exists( dirname($cacheFile) ) )
              SFilesystem::createFolder( dirname($cacheFile) );

            if (!file_exists($cacheFile ) )
            {
              system( 'java -jar '.PATH_WGT.'compressor/yuicompressor.jar "'.$file.'" --type js --charset utf-8 -o "'.$cacheFile.'"' );
            }

            //$code .= '/* java java -jar '.PATH_WGT.'compressor/yuicompressor.jar "'.$file.'" --type js --charset utf-8   -o "'.$file.'.min" */'.NL;
            $code .= file_get_contents($cacheFile ).NL;

          }
          catch ( Exception $e )
          {
            $code .= '/* '.$e->getMessage().' */'.NL;
          }
        }
      } else {
        foreach($files as $file )
        {
          $code .= file_get_contents($file ).NL;
        }
      }
    }

    $etag       = md5($code );
    $plainSize  = strlen($code );

    if (!file_exists( PATH_GW.$this->folder.'/list/' ) )
      SFilesystem::createFolder( PATH_GW.$this->folder.'/list/'  );

    file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.plain' ,  $code );
    file_put_contents
    (
      PATH_GW.$this->folder.'/list/'.$list.'.plain.meta' ,
      json_encode( array( 'etag'=> $etag, 'size'=> $plainSize ) )
    );

    if ($encode )
    {
      $encoded      = gzencode($code );
      $encodedSize  = strlen($encoded );

      file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.gz' ,  $encoded );
      file_put_contents
      (
        PATH_GW.$this->folder.'/list/'.$list.'.gz.meta' ,
        json_encode( array( 'etag'=> $etag, 'size'=> $encodedSize ) )
      );
    }

    SFilesystem::delete( PATH_GW.'tmp/js_min/' );

  }//end public function rebuildList */

  /**
   *
   * @param string $etag
   * @param string $size
   * @param string $encode
   */
  protected function sendHeader($etag, $size, $encode  )
  {

    // ok alles fein
    header("HTTP/1.1 200 OK");

    if ($encode )
    {
      // Tell the browser the content is compressed with gzip
      header ("Content-Encoding: gzip");
    }

    header('Content-Type: application/javascript');
    header('ETag: '.$etag );
    header('Content-Length: '.$size);
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60 ) . " GMT");
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );

  }//end protected function sendHeader */



} // end class LibCacheRequestJavascript
