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
 * class ControllerSocket
 * Der Supercontroller für den Serverbetrieb von Webfrapd
 *
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage Mvc
 */
class MvcRouter_Socket
  extends LibFlowApachemod
{

 /**
  * Die Ip des Servers
  */
  protected $serverIp = "0.0.0.0";

 /**
  * Der Port des Servers
  */
  protected $serverDefaultPort = 2667;

 /**
  * Der Port des Servers
  */
  protected $serverSecurePort = 2668;

 /**
  * Der Port des Servers
  */
  protected $serverAdminPort = 2669;

 /**
  * Der Port des Servers
  */
  protected $queueLength = 10;

 /**
  * Der Port des Servers
  */
  protected $serverRunUser = null;

 /**
  * Der Server Socket
  */
  protected $defaultSocket = null;

 /**
  * Der Server Socket
  */
  protected $secureSocket = null;

 /**
  * Der Server Socket
  */
  protected $adminSocket = null;

 /**
  * Das Ordner für die PidDatei
  */
  protected $pidFolder = "tmp/";

 /**
  * Name der ProccessId
  */
  protected $pidFile = "wepfrap.pid";

 /**
  * Soll der Server weiter auf den Ports lauschen oder sterben gehen
  */
  protected $serverStatus = true;

 /**
  * Counter zum zählen der Anzahl Connections
  */
  protected $connectionCounter = true;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected static $instance = null;

  // ***************************************************************************
  // ###########################################################################
  // Start der Methoden
  // ###########################################################################
  // ***************************************************************************

 /**
  * Der Standart Konstruktor
  * @since 0.1
  * @return void
  */
  protected function __construct( )
  {


    if( !$_SERVER['argc'] > 0 )
    {
      $this->arguments = array( );
      return;
    }

    if( isset( $_SERVER['argv'][1] ) )
    {
      $Startpoint = $this->setAktion( $_SERVER['argv'][1] );
    }
    else
    {
      $this->sysStatus['action'] = 'help' ;
      $Startpoint = 1;
    }

    for( $nam = $Startpoint ; $nam < $_SERVER['argc'] ; ++$nam )
    {

      if( !$this->isFlag( $_SERVER['argv'][$nam] )  )
      {

        $Key = $nam;
        ++$nam;

        if( !isset( $_SERVER['argv'][$nam] ) )
        {

          $this->sysStatus['WrongParameter'] = true ;
          return;
        }

        $this->arguments[$_SERVER['argv'][$Key]] = $_SERVER['argv'][$nam];

      }
    }

  } // end of member function __construct


  /** getInstance zum implementieren von Singelton
   *
   * @return object Eine Instanz eines Systemmoduls
   */
  public static function createInstance( )
  {

    // Wenn schon vorhanden dann muss ja nichts mehr erstellt werden
    if( self::$instance )
    {
      return false;
    }

    self::$instance = new ControllerSocket();
    $_SESSION['OBJECTS']['SYS'] = self::$instance;
    return true;

  } // end of member function createInstance

  /**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $_GET Variable
   * @return bool
   */
  public function issetArgument( $Key )
  {

    if( isset( $this->arguments[$Key] ) )
    {
      return true;
    }


    return null;

  } // end public function issetArgument */

/**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string Key Name der zu erfragende $_GET Variable
  * @param int Type der Manipulation der Daten
  * @param bool Urlencodet soll die Variable Urlencodet
  *   order decode zurückgegeben werden
  * @return string
  */
  public function getArgument
  (
    $Key = null ,
    $Type = UDATA_RAW
  )
  {

    if( isset( $this->arguments[$Key] ) )
    {
      return $this->arguments[$Key];
    }
    else
    {
      return null;
    }

  } // end public function getArgument

/**
  * Socket erstellen und an passende Adresse binden
  *
  * @return void
  * @throws WebfrapFlow_Exception
  */
  public function connectServer()
  {

    if ( !$this->defaultSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP ) )
    {

      throw new WebfrapFlow_Exception("Konnte keine Verbindung erstellen");
    }// Ende If

    if
    (! socket_bind
      (
        $this->defaultSocket,
        $this->serverIp ,
        $this->serverDefaultPort
      )
    )
    {

      throw new WebfrapFlow_Exception("Konnte Socket nicht an Ip und Port binden");
    }// Ende if

    if( ( !socket_listen( $this->defaultSocket, $this->queueLength )) )
    {

      throw new WebfrapFlow_Exception("Konnte nicht an Socket lauschen");

    }

    socket_set_option( $this->defaultSocket, SOL_SOCKET, SO_REUSEADDR, 1 );

    if( !is_writeable( $this->pidFolder ) )
    {
      throw new WebfrapFlow_Exception();
    }

    SFiles::write( $this->pidFolder."/".$this->pidFile , posix_getpid() );

  }// end of member function serverConnect

  /**
  * die Serververbindung trennen
  *
  * @return void
  */
  public function disconnectServer()
  {
    if( is_resource($this->defaultSocket) )
    {
      $this->defaultSocket = null;
    }

  }//end public function  disconnectServer

/**
  * Den Server laufen lassen
  *
  * @return void
  */
  public function runServer()
  {
    if(!is_resource($this->defaultSocket) )
    {
      throw new WebfrapFlow_Exception("Habe keine Connection bekommen");
    }

    while( $this->serverStatus )
    {
      echo "Counter: ".$this->connectionCounter."\n";

      // Auf eine Verbindung warten
      if( ( $clientRequest = socket_accept( $this->defaultSocket) ) )
      {
        echo socket_read( $clientRequest, 10240 , PHP_BINARY_READ );
      }

      $HtmlBody = "<html>\n"
        ."<head><title>Webfrapd 404 Not Found</title></head>\n"
        ."<body>\n"
        ."<h1>Webfrapd alpha 0.01</h1>\n"
        ."<h2>Sorry, die Seite konnte nicht gefunden werden</h2>\n"
        ."<p>Ok keine Seite kann gefunden werden, aber ich arbeite dran!</p>"
        ."</body>\n"
        ."</html>";

      $Answer = "HTTP/1.1 404 Not Found\r\n"
        . "Date: " . gmstrftime("%a, %d %h %Y %H:%M:%S GMT") . "\r\n"
        . "Content-Length: " . strlen($HtmlBody) . "\r\n"
        . "Connection: close\r\n"
        . "Content-Type: text/html\r\n\r\n"
        . $HtmlBody;

      socket_write($clientRequest, $Answer, strlen($Answer));

      // Beenden der Verbindung zum Client
      socket_close($clientRequest);

      ++ $this->connectionCounter;

    }// Ende While

  }// end of member function runServer

/**
  * Den Server laufen lassen
  *
  * @return void
  */
  public function runServer_orig()
  {

    if(!is_resource($this->defaultSocket) )
    {
      throw new WebfrapFlow_Exception("Habe keine Connection bekommen");
    }

    while( $this->serverStatus )
    {

      // Auf eine Verbindung warten
      if( ( $clientRequest = socket_accept( $this->defaultSocket) ) )
      {

          $ClientHeader = socket_read($clientRequest, 10240 , PHP_BINARY_READ );
          echo $ClientHeader;

        // Vor'm Weitermachen den Prozess zuerst ablösen!
        //
        // pcntl_fork() liefert immer -1 im Falle eines Fehlers,
        // 0 wenn wir das Kind sind,
        // und eine ProzessID beim Erfolg.
        // Also sind wir das Kind wenn PID > 0 ist
        $pid = pcntl_fork();

        if($pid == 0) {

          // IP-Adresse des Clients in $PEER_NAME speichern
          //socket_getpeername( $clientRequest, $PEER_NAME );

          // handler.php soll sich von diesen Headern bedienen
          $ClientHeader = socket_read($clientRequest, 10240);

          echo $ClientHeader;

          // Source-File-ID holen (entferne alle Slashes
          $SrcId = str_replace( "/" ,NULL,
                      substr( $ClientHeader, 4,
                        strpos( $ClientHeader, " HTTP/" ) -4
                      )
                    );


//           if(is_md5($SrcId) AND is_readable( "$DIR_SRC/$SrcId.php" )) {
//
//             $fp = fopen("$DIR_INF/$SrcId.inf", "r");
//             $ftype = rtrim(fgets($fp));
//             $fsize = rtrim(fgets($fp));
//             fclose($fp);
//
//             $serverHeader = "HTTP/1.0 200 OK\r\n"
//               . "Date: " . gmstrftime("%a, %d %h %Y %H:%M:%S GMT") . "\r\n"
//               . "Server: Webfrapd aplha 0.1\r\n"
//               . "Content-Length: $fsize\r\n"
//               . "Connection: close\r\n"
//               . "Content-Type: $ftype\r\n\r\n";
//
//
//             socket_write($clientRequest, $serverHeader, strlen($serverHeader));
//
//
//             $fp = fopen("$DIR_SRC/$SrcId.php", "r");
//             while(!feof($fp)) {
//
//               $buf = fread($fp, 4096);
//               if(!socket_write($clientRequest, $buf, strlen($buf)))
//                 break;
//
//             }
//             fclose($fp);
//
//           } else {

            $HtmlBody = "<html>\n"
              ."<head><title>404 Not Found</title></head>\n"
              ."<body>\n"
              ."<pre>\n"
              ."<font size=4><b>404 - Not Found</b></font>\n"
              ."The requested Source file (<b>$SrcId</b>) was not found on this server.\n"
              ."</pre>\n"
              ."</body>\n"
              ."</html>";

            $Answer = "HTTP/1.1 404 Not Found\r\n"
              . "Date: " . gmstrftime("%a, %d %h %Y %H:%M:%S GMT") . "\r\n"
              . "Content-Length: " . strlen($HtmlBody) . "\r\n"
              . "Connection: close\r\n"
              . "Content-Type: text/html\r\n\r\n"
              . $HtmlBody;

            socket_write($clientRequest, $Answer, strlen($Answer));

          }
          // Beenden der Verbindung zum Client
          socket_close($clientRequest);
//         }
//         else if($pid > 0) {
//           socket_close($clientRequest);
//         }

      }// Ende test auf Valide Verbindung


      ++ $this->connectionCounter;

    }// Ende While

  }// end of member function runServer

/**
  * Ausführen der Mainapp nachdem alle Basisaktionen abgelaufen sind , sprich
  *
  * @since 0.1
  * @return

  * @author Dominik Bonsch <a href="db@kresolutions.com">db@kresolutions.com</a>
  */
  public function main()
  {

    // Main Lässt erst mal den Server laufen
    $this->connectServer();
    $this->runServer();
    $this->disconnectServer();

    return;
    
  } // end public function main()

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @since 0.1
  * @return array
  */
  protected function isFlag( $data )
  {

    if( $data{0} == "-" )
    {
      $this->arguments[$data] = true;
      return true;
    }
    else
    {
      return false;
    }

  } // end protected function isFlag( $data )

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @since 0.1
  * @return int
  */
  protected function setAktion( $data )
  {

    if( $data{0} != "-" )
    {
      $this->sysStatus["action"] = $data;
      return 2;
    }
    else
    {
      return 1;
    }

  } // end protected function setAktion( $data )

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return array
  * @override
  */
  protected function panicShutdown( $LastMessage )
  {

    echo "Fatal Error, System died :-((\n\n";

    echo $LastMessage."\n";

    session_destroy();
    exit();

  } // end protected function panicShutdown( $LastMessage )

} // end class ControllerSocket

