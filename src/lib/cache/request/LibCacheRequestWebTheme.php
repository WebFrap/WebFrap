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
class LibCacheRequestWebTheme
  extends LibCacheRequest
{
////////////////////////////////////////////////////////////////////////////////
// Attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * the folder where to cache the assembled css files
   * @var string
   */
  protected $folder = 'cache/web_theme/';

  /**
   * the content type for the header
   * @var string
   */
  protected $contentType = 'text/css';

////////////////////////////////////////////////////////////////////////////////
// Methode
////////////////////////////////////////////////////////////////////////////////



  /**
   * @param string $list
   */
  public function publishFile( $file )
  {

    $map = array();
    include PATH_GW.'/conf/include/web_theme/files.map.php';

    if( !isset( $map[$file] )  )
    {
      header('HTTP/1.0 404 Not Found');
      return;
    }

    ob_start();

    include $map[$file];

    $variables = array();

    if( file_exists( PATH_GW.'conf/conf.style.default.php' ) )
      include PATH_GW.'conf/conf.style.default.php';

    $tmpVar = array();
    foreach( $variables as $key => $val  )
      $tmpVar['@{'.$key.'}'] = $val;

    $code = ob_get_contents();
    $code = str_replace( array_keys($tmpVar), array_values($tmpVar),  $code   );
    ob_end_clean();

    $codeEtag = md5($code);

    if( !file_exists( PATH_GW.$this->folder.'/file/' ) )
      SFilesystem::createFolder( PATH_GW.$this->folder.'/file/' );

    file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.plain' ,  $code );
    file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.plain.md5' ,  $codeEtag );

    $encode = function_exists('gzencode') ? !Log::$levelDebug : false;


    if( $encode )
    {

      $encoded      = gzencode( $code );
      $encodedEtag  = md5( $encoded );

      file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.gz' ,  $encoded );
      file_put_contents( PATH_GW.$this->folder.'/file/'.$file.'.gz.md5' ,  $encodedEtag );

    }

    if
    (
      isset($_SERVER['HTTP_ACCEPT_ENCODING'])
        && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
        && DEBUG
    )
    {
      // Tell the browser the content is compressed with gzip
      header ("Content-Encoding: gzip");
      $out  = $encoded;
      $etag = $encodedEtag;
    }
    else
    {
      $out = $code;
      $etag = $codeEtag;
    }

    header('content-type: '. $this->contentType );
    header('ETag: '.$etag );
    header('Content-Length: '.strlen( $out ));
    header('Expires: Thu, 13 Nov 2179 00:00:00 GMT' );
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );

    echo $out;

  }//end public function publishFile */


  /**
   * @param string $list
   */
  public function publishList( $list )
  {

    $theme        = Session::status('activ.theme');
    $layoutType   = Session::status('default.layout');

    /*
    $layoutClass  = 'WgtLayout'.ucfirst($theme);

    if(WebFrap::classLoadable( $layoutClass ))
    {
      $layout = new $layoutClass( $layoutType );
    }
    else
    {
      echo '/* WARNING FAILED TO LOAD THE THEME: '.$layoutClass.' * /'.NL;
      //return;
    }
    */

    /*
    $variables = array();

    if( file_exists( PATH_GW.'conf/conf.style.'.$list.'.php' ) )
      include PATH_GW.'conf/conf.style.'.$list.'.php';
    elseif(  PATH_GW.'conf/conf.style.default.php'  )
      include PATH_GW.'conf/conf.style.default.php';

    $tmpVar = array();
    foreach( $variables as $key => $val  )
      $tmpVar['@{'.$key.'}'] = $val;
    */

    $icons  = View::$webIcons;
    $images = View::$webImages;

    ob_start();

    include PATH_GW.'conf/include/web_theme/'.$list.'.list.php';

    $code = ob_get_contents();
    //$code = str_replace( array_keys($tmpVar) , array_values($tmpVar),  $code   );
    ob_end_clean();

    //$code = JSMin::minify( $code );

    $codeEtag = md5($code);

    if( !file_exists( PATH_GW.$this->folder.'/list/' ) )
      SFilesystem::createFolder( PATH_GW.$this->folder.'/list/'  );

    file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.plain' ,  $code );
    file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.plain.md5' ,  $codeEtag );

    $encode = function_exists('gzencode') ? !DEBUG : false;

    if( $encode )
    {

      $encoded = gzencode( $code );
      $encodedEtag = md5( $encoded );

      file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.gz' ,  $encoded );
      file_put_contents( PATH_GW.$this->folder.'/list/'.$list.'.gz.md5' ,  $encodedEtag );
    }

    if
    (
      isset($_SERVER['HTTP_ACCEPT_ENCODING'])
        && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
        && $encode
    )
    {
      // Tell the browser the content is compressed with gzip
      header ("Content-Encoding: gzip");
      $out = $encoded;
      $etag = $encodedEtag;
    }
    else
    {
      $out = $code;
      $etag = $codeEtag;
    }

    header('content-type: '. $this->contentType  );
    header('ETag: '.$etag );
    header('Content-Length: '.strlen( $out ));
    header('Expires: Thu, 13 Nov 2179 00:00:00 GMT' );
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );

    echo $out;

  }//end public function publishList */

  /**
   * @param string $list
   */
  public function rebuildList( $list )
  {

    if( !file_exists( PATH_GW.'/conf/include/css/'.$list.'.list.php' ) )
      throw new ResourceNotExists_Exception( "Css list {$list}" );

    //$theme        = Session::status('key.theme');
    //$layoutType   = Session::status('default.layout');
    $theme        = 'default';
    $layoutType   = 'full';

    $icons        = WEB_ROOT.'icons/default/';
    $images       = WEB_ROOT.'themes/default/images/';

    $files  = array();
    $minify = true;

    if( function_exists( 'gzencode' ) )
    {
      $encode = true;
    }
    else
    {
      $encode = false;
    }

    Response::collectOutput();
    include PATH_GW.'conf/include/web_theme/'.$list.'.list.php';
    $tmp = Response::getOutput();

    if( file_exists( PATH_GW.'tmp/web_theme/'.$list.'.css' ) )
    {
      SFilesystem::delete( PATH_GW.'tmp/web_theme/'.$list.'.css' );
      SFilesystem::delete( PATH_GW.'tmp/web_theme/'.$list.'.min.css' );
    }

    SFiles::write( PATH_GW.'tmp/web_theme/'.$list.'.css', $tmp );

    system
    (
    	'java -jar '.PATH_WGT.'compressor/yuicompressor.jar "'
        .PATH_GW.'tmp/web_theme/'.$list.'.css" --type css --charset utf-8 -o "'
        .PATH_GW.'tmp/web_theme/'.$list.'.min.css"'
    );

    $code = SFiles::read( PATH_GW.'tmp/web_theme/'.$list.'.min.css' );

    $codeEtag = md5( $code );
    SFiles::write( PATH_GW.$this->folder.'/list/'.$list.'.plain', $code );
    SFiles::write( PATH_GW.$this->folder.'/list/'.$list.'.plain.md5', $codeEtag );


    if( $encode )
    {
      $encoded      = gzencode( $code );
      $encodedSize  = strlen( $encoded );

      SFiles::write( PATH_GW.$this->folder.'/list/'.$list.'.gz' ,  $encoded );
      SFiles::write
      (
        PATH_GW.$this->folder.'/list/'.$list.'.gz.meta' ,
        json_encode( array( 'etag'=> $codeEtag, 'size' => $encodedSize ) )
      );
    }

    SFilesystem::delete( PATH_GW.'tmp/web_theme/'.$list.'.css' );
    SFilesystem::delete( PATH_GW.'tmp/web_theme/'.$list.'.min.css' );

  }//end public function rebuildList */

} // end class LibCacheRequestCss
