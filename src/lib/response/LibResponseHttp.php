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
class LibResponseHttp extends LibResponse
{

  /**
   * type is used for easy chechs what kind of response is active
   * @var string
   */
  public $type = 'http';

  /**
   * type of the view
   * the default type is html
   * @var string
   */
  public $viewType = 'html';

  /**
   * Der vereinfachte Status des Webfrap Systems
   * @var int
   */
  public $wbfState = State::OK;
  
  /**
   * Detailierter Status in HTTP Codes.
   * @var int
   */
  public $httpState = Response::OK;

  /**
   * Interner Redirect
   * @var string
   */
  public $redirectUrl = null;
  
  /**
   * Http Redirect URL
   * @var string
   */
  public $httpRedirect = null;
  
  
  /**
   * Liste der neu zu erstellenden Cookies
   * @var array
   */
  protected $cookies  = array();

  /**
   * default headers prevent caching in the browser
   * @var array
   */
  protected $header   = array
  (
    'cache-control' => "Cache-Control: must-revalidate, post-check=0, pre-check=0",
    //'cache-control' => 'Cache-Control: no-cache, must-revalidate',
    'expires'       => 'Expires: Mon, 26 Jul 1997 05:00:00 GMT'
  );
  

/*//////////////////////////////////////////////////////////////////////////////
// Cookie Verwaltung
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Einen neuen Cookie hinzufügen
   *
   * @param string $cookieName
   * @param string $value
   * @return WgtCookie
   */
  public function addCookie( $cookieName , $value )
  {
    $cookie = new WgtCookie($cookieName, $value );
    $this->cookies[$cookieName] = $cookie;

    return $cookie;
  } // end public function addCookie */

  /**
   * Einen neuen Cookie hinzufügen
   *
   * @param array $name
   * @return boolean
   */
  public function getCookie( $name )
  {

    if(!isset($this->cookies[$name]))
     return null;

    return $this->cookies[$name];

  } // end public function getCookie */


  /**
   * Einenen neuen HTTP _header hinzufügen
   *
   * Folgende Header werden bis jetzt unterstützt
   * <ul>
   *  <li>location (http://www.example.com/)</li>
   *  <li>expires (Mon, 26 Jul 1997 05:00:00 GMT)</li>
   *  <li>last-modified (gmdate("D, d M Y H:i:s") . " GMT")</li>
   *  <li>cache-control ( no-store, no-cache, must-revalidate)</li>
   *  <li>pragma (co-cache)</li>
   *  <li>name (test.pdf)</li>
   *  <li>encoding (binary)</li>
   *  <li>content-type (text/html; charset=UTF-8)</li>
   * </ul>
   *
   * @param string $type Typ des Headers
   * @param string $content Inhalt des Headers falls vorhanden
   * @return void
   */
  public function addHeader( $type,  $content = null )
  {
    switch( $type )
    {

      case 'location':
      { // Header zum umleiten auf eine andere Seite
        $this->header['location'] = 'Location: '.$content;
        break;
      } // ENDE CASE

      // Wann läuft die Gültigkeit des contents aus ? ( Mon, 26 Jul 1997 05:00:00 GMT )
      case 'expires':
      {
        $this->header['expires'] = 'Expires: '.$content;
        break;
      } // ENDE CASE

      // Letze Änderung in der Seite? ( gmdate('D, d M Y H:i:s') . ' GMT' )
      case 'last-modified':
      {
        $this->header['last-modified'] = 'Last-Modified: '.$content;
        break;
      } // ENDE CASE

      //Soll die Seite gecacht werden? ( no-store, no-cache, must-revalidate )
      case 'cache-control':
      {
        $this->header['cache-control'] = 'Cache-Control: '.$content;
        break;
      } // ENDE CASE

      case 'pragma':
      { //Soll die Seite gecacht werden? ( co-cache )
        $this->header['pragma'] = 'Pragma: '.$content;
        break;
      } // ENDE CASE

      case 'http-status':
      { //Fehlermeldung ('HTTP/1.0 404 Not Found');
        $this->header['http-status'] = 'HTTP/1.0 '.$content;
        break;
      } // ENDE CASE

        //Name der beim Download angezeigt wird (downloaded.pdf);
      case 'filename':
      {
        $this->header['filename'] = 'Content-Disposition: attachment; filename=\''.$content.'\'';
        break;
      } // ENDE CASE

        //Name der beim Download angezeigt wird (downloaded.pdf);
      case 'encoding':
      {
        $this->header['encoding'] = 'Content-Transfer-Encoding: '.$content;
        break;
      } // ENDE CASE

      case 'content-type':
      { // ContentType der Seite ( text/html; charset=UTF-8 )

        $this->header['content-type'] = 'Content-Type: '.$content;
        break;
      } // ENDE CASE


    } // ENDE SWITCH

  } // end public function addHeader */


  /**
   * Hinzufügen eines Headers
   * Sicher stellen, dass noch kein Output gesendet wurde, sonst kann der
   * Header nicht gesendet werden
   * @param string $content der Content für den Header
   */
  public function sendHeader( $content )
  {
    
    if (!View::$blockHeader )
    {
      header( $content );
    } else {
      Log::error( "Tried to send header after Output ".$content );
    }
    
  }//end public function sendHeader */
  
  /**
   *
   * @param $redirectUrl
   * @return void
   */
  public function redirect( $redirectUrl )
  {
    $this->redirectUrl = $redirectUrl;
  }//end public function redirect */
  
  /**
   * Den Aktuellen Status des Systems erfragen
   */
  public function getStatus( $key )
  {
    
    if( isset(EHttpStatus::$codes[$key]) ) 
      return EHttpStatus::$codes[$key];
    else
      return EHttpStatus::$codes[500];
      
  }//end public function getStatus */
  
  /**
   * Den Aktuellen Status des Systems erfragen
   */
  public function setStatus( $state )
  {
    
    $this->httpState = $state;
      
  }//end public function setStatus */
  
/*//////////////////////////////////////////////////////////////////////////////
// messages
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   */
  public function addMessage( $message )
  {
    Message::addMessage($message);
  }//end public function addMessage */

  /**
   * @param string $warning
   */
  public function addWarning( $warning )
  {
    Message::addWarning($warning);
  }//end public function addWarning */

  /**
   * @param string $error
   */
  public function addError( $error )
  {
    Message::addError( $error );
  }//end public function addError */

  /**
   * @return boolean
   */
  public function hasErrors( )
  {
    return Message::hasErrors();
  }//end public function hasErrors */

  /**
   * @return boolean
   */
  public function cleanErrors( )
  {
    return Message::hasErrors();
  }//end public function hasErrors */


  /**
   *
   * @param string $message
   * @param string $context
   * @param Entity $entity
   */
  public function protocol( $message, $context, $entity = null, $mask = null )
  {
    Message::getActive()->protocol($message, $context, $entity, $mask );
  }//end public function protocol

  /**
   *
   * @console
   * @param string $console
   *
   */
  public function console( $message, $data = null, $trace = null, $force = false )
  {
    
    Debug::console( $message, $data, $trace, $force );
    
  }//end public function console */

  /**
   * @lang de:
   *
   *   ist eine Adapter Methode welche versucht automatisch
   *   das passende ViewObjekt, basierende auf der Anfrage, zu erstellen
   *
   * @see <a href="http://127.0.0.1/wbf/doc/de/index.php?page=architecture.gateway.interfaces" >Doku WebFrap Gateway Interfaces</a>
   *
   * @example
   * <code>
   *  $view = $this->loadView( 'exampleEditForm', 'ExampleDomain' );
   *
   *  if (!$view )
   *  {
   *    $this->invalidAccess
   *    (
   *      $response->i18n->l
   *      (
   *        'The requested View not exists',
   *        'wbfsys.error'
   *      );
   *    );
   *    return false;
   *  }
   * </code>
   *
   * @param string $key schlüssel zum adressieren des view objektes,
   *  wird teils auch in client verwendet
   *
   * @param string $class
   *  der domainspezifische name der view klasse
   *
   * @param string $displayMethod
   *  Die display Methode, welche auf der View erwartet wird,
   *  Wenn die Methode nicht existiert wird null zurückgegeben
   *
   * @param string $viewType
   *   Type der View festpinnen
   *
   * @param string $throwError
   *   Eine Exception werfen wenn die View nicht existiert
   *
   * @return LibTemplate
   *  gibt ein Objekt der Template Klasse zurück,
   *  oder null wenn die Klasse, oder die angefragte Methode, nicht existieren
   *
   */
  public function loadView
  (
    $key,
    $class,
    $displayMethod = null,
    $viewType = null,
    $throwError = true
  )
  {

    
    /* @var $tplEngine LibTemplate   */
    $tplEngine  = $this->getTplEngine();
    $request    = $this->getRequest();

    if (!$viewType )
      $viewType =  $tplEngine->type;

    try
    {

      // alle views bekommen zumindest den request und die response injiziter
      switch( $viewType )
      {
        case View::FRONTEND:
        {
          $view = $tplEngine->loadView( $class.'_Frontend' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Frontend' );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        case View::AJAX:
        {
          $view = $tplEngine->loadView( $class.'_Ajax'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Ajax' );

          $view->setRequest( $request );
          $view->setResponse( $this );

          return $view;
          break;
        }
        case View::MAINTAB:
        {
          // use maintab view
          $view = $tplEngine->newMaintab( $key, $class );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        case View::HTML:
        {
          $view = $tplEngine->loadView( $class.'_Html' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Html' );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        case View::JSON:
        {
          $view = $tplEngine->loadView( $class.'_Json'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Json' );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        case View::MODAL:
        {
          $view = $tplEngine->loadView( $class.'_Modal'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Modal' );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        case View::SERVICE:
        {
          $view = $tplEngine->loadView( $class.'_Service'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Service' );

          $view->setRequest( $request );
          $view->setResponse( $this );

          return $view;
          break;
        }
        case View::AREA:
        {
          $view = $tplEngine->getMainArea( $key, $class.'_Area'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Area' );

          $view->setRequest( $request );
          $view->setResponse( $this );

          return $view;
          break;
        }
        case View::CLI:
        {
          $view = $tplEngine->loadView( $class.'_Cli' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Cli' );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        case View::DOCUMENT:
        {
          $view = $tplEngine->loadView( $class.'_Document' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod, $viewType.':: '.$class.'_Document' );

          $view->setRequest( $request );
          $view->setResponse( $this );
          return $view;
          break;
        }
        default:
        {
          return $this->handleNonexistingView( $throwError, $displayMethod, $viewType );
        }
      }

    }
    catch( LibTemplate_Exception $e )
    {
      ///TODO besseres error handling implementieren
      $this->addError( 'Error '.$e->getMessage() );
      return $this->handleNonexistingView( $throwError, $displayMethod, $viewType );
    }
    
  }//end public function loadView */

  /**
   * @param boolean $throwError
   * @param string $displayMethod
   * @param string $viewName
   * @throws InvalidRequest_Exception
   */
  protected function handleNonexistingView( $throwError, $displayMethod = null, $viewName = null )
  {

    Debug::dumpFile('missing view '.$viewName, $viewName);
    
    if( $throwError )
    {

      $response = $this->getResponse();

      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist
      
      if( $displayMethod )
      {
        throw new InvalidRequest_Exception
        (
          'The requested Outputformat '.$viewName.' is not implemented for action: '.$displayMethod.'!',
          Response::NOT_IMPLEMENTED
        );
      }
      else
      {
        throw new InvalidRequest_Exception
        (
          'The requested Outputformat '.$viewName.' is not implemented for this action! '.Debug::backtrace(),
          Response::NOT_IMPLEMENTED
        );
      }
      
    }

    return null;

  }//end protected function handleNonexistingView */

/*//////////////////////////////////////////////////////////////////////////////
// output
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * flush the page
   *
   * @return void
   */
  public function compile( )
  {

    $this->tpl->compile();

  }//end public function compile */
  
  /**
   * flush the page
   *
   * @return void
   */
  public function publish( )
  {

    if( in_array( $this->tpl->type, array('binary','document') )  )
    {
      $this->publishBinary();
    }
    else
    {
      $this->publishText();
    }
    

  }//end public function publish */

  
  /**
   * flush the page
   *
   * @return void
   */
  public function publishText( )
  {

    // Umleiten der Anfrage auf eine andere URL
    // Zb wenn der Zugriff auf das System über eine andere als die Hauptdomain kommt
    if( $this->httpRedirect )
    {
      $this->sendHeader( 'HTTP/1.1 308 Permanent Redirect' );
      $this->sendHeader( 'Location: '.$this->httpRedirect  );
      flush();
      return;
    }
    
    $conf = $this->getConf();

    // nur wenn kein Content Type header explizit gesetzt wurde
    if(!isset($this->header['content-type']))
    {
      
      if (!$charset  = $this->tpl->tplConf['charset'] )
      {
        if (!$charset  = $conf->status('encoding') )
          $charset = 'utf-8';
      }

      $this->sendHeader( 'Content-Type:'.$this->tpl->contentType.'; charset='.$charset );
    }
    
    $this->sendHeader( 'HTTP/1.1 '.$this->getStatus( $this->httpState ) );

    // Abschicken der Header die gesetzt wurden
    foreach( $this->header as $header)
      $this->sendHeader( $header );
      
    $this->sendHeader( 'X-UA-Compatible: IE=edge' );

    foreach( $this->cookies as /* @var WgtCookie $cookie */ $cookie )
      $cookie->setCookie();

    // ok wenn wir kein tpl haben dann by by
    if (!$this->tpl )
    {
      View::$blockHeader = true;
      echo "<html><head></head><body>empty</body></html>";
      flush();
      return;
    }
      
    $this->tpl->compile( );

    if
    (
      isset($_SERVER['HTTP_ACCEPT_ENCODING'])
        && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
        && function_exists('gzencode')
        && Session::status('WBF_GZIP_OUTPUT')
    )
    {
      // Tell the browser the content is compressed with gzip
      $this->sendHeader( "Content-Encoding: gzip" );
      $this->tpl->compress();
    }

    // $this->sendHeader("Cache-Control: pre-check=0");
    // $this->sendHeader("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    // $this->sendHeader("Pragma: ");
    // $this->sendHeader("Expires: ");

    $this->sendHeader( 'ETag: '.$this->tpl->getETag() );
    $this->sendHeader( 'Content-Length: '.$this->tpl->getLength() );
    
    View::$blockHeader = true;
    
    echo $this->tpl->output;
    flush();

  }//end public function publishText */
  
  /**
   * flush the page
   *
   * @return void
   */
  public function publishBinary( )
  {
    

    // Umleiten der Anfrage auf eine andere URL
    // Zb wenn der Zugriff auf das System über eine andere als die Hauptdomain kommt
    if( $this->httpRedirect )
    {
      $this->sendHeader( 'HTTP/1.1 308 Permanent Redirect' );
      $this->sendHeader( 'Location: '.$this->httpRedirect  );
      flush();
      return;
    }
    
    if( $this->tpl->file )
    {
      
      if( $this->tpl->file->type )
        $contentType = $this->tpl->file->type;
      elseif( $this->tpl->contentType )
        $contentType = $this->tpl->contentType;
      else
        $contentType = 'application/octet-stream' ;
        

      $this->sendHeader( 'Content-Type: '.$contentType );
      $this->sendHeader( 'Content-Disposition: attachment;filename="'.urlencode($this->tpl->file->name).'"' ); 
      //Content-Disposition: inline:  schick nicht file, sondern schick link auf file aufm server
      $this->sendHeader( 'ETag: '.$this->tpl->getETag() );
      $this->sendHeader( 'Content-Length: '.$this->tpl->getLength() );

      //header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
      //header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Datum in der Vergangenheit
      //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      $this->sendHeader( 'Expires: 0' );
      $this->sendHeader( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
      $this->sendHeader( 'Pragma: public' );
      
    } else {
      if (!$charset  = $this->tpl->tplConf['charset'] )
        $charset = 'utf-8';

      $this->sendHeader( 'Content-Type:'.$this->tpl->contentType.'; charset='.$charset );

      if
      ( isset( $_SERVER['HTTP_ACCEPT_ENCODING'] )
          && strstr( $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' )
          && function_exists( 'gzencode' )
          && Session::status( 'WBF_GZIP_OUTPUT' )
      )
      {
        // Tell the browser the content is compressed with gzip
        $this->sendHeader( "Content-Encoding: gzip" );
        $this->tpl->compress();
      }

      $this->sendHeader( 'Cache-Control: no-cache, must-revalidate' ); // HTTP/1.1
      $this->sendHeader( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Datum in der Vergangenheit
      $this->sendHeader( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
      $this->sendHeader( 'ETag: '.$this->tpl->getETag() );
      $this->sendHeader( 'Content-Length: '.$this->tpl->getLength() );
    }
    
    
    View::$blockHeader = true;
    
    if( $this->tpl->file )
    {
      readfile( $this->tpl->file->path );
      if( $this->tpl->file->tmp )
      {
        if( $this->tpl->file->tmpFolder )
        {
          SFilesystem::delete( $this->tpl->file->tmpFolder );
        }
        else
        {
          unlink( $this->tpl->file->path );
        }
      }
    }
    else
    {
      echo $this->tpl->output;
      flush();
    }

  }//end public function publishBinary */

} // end LibResponseHttp

