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

  set_time_limit(0);
  error_reporting(E_ALL | E_STRICT);
  date_default_timezone_set( "Europe/Berlin" );

  define( 'NL' , "\n" );

 /**
  * Class CliBase
  * @version alpha 0.1
  * @copyright DominikBonsch <a href="dominik.bonsch@wefrap.de">Dominik Bonsch</a>
  *
  */
class Cli
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/


 /**
  * vorhandene Argumente
  */
  protected $arguments = array();

 /**
  * Unterstütze Kommandos
  */
  protected $actions = array
  (
    "help"   => "help", // Ausgabe der Hilfe
  );

 /**
  * Das Aktuelle Commando
  */
  protected $command = null;


  protected $defaultCommand = null;

 /**
  * Soll das Programm geschwätzig sein?
  */
  protected $verbose = false;

  /**
   *
   * @var string name of the application
   */
  protected $appName = null;

  /**
   *
   * @var unknown_type
   */
  protected $author = null;


  protected $debug = array
  (
    //'verbose' => null,
    //'no_execute' => null,
  );

/*//////////////////////////////////////////////////////////////////////////////
//
// Konstruktoren
//
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * Der Standart Konstruktor
  */
  public function __construct( )
  {

    $this->init();


  } // public function __construct */

  protected function init()
  {

    if( $_SERVER["argc"] <= 1 )
    {
      // Keine Parameter also Hilfe ausgeben
      if(!$this->defaultCommand)
      {
        $this->printHelp( );
        exit(0);
      }
    }

    $this->loadConf();

    for( $nam = 1 ; $nam < $_SERVER["argc"] ; ++$nam )
    {
      if( !$this->isFlag( $_SERVER["argv"][$nam] )  )
      {
        if( !$this->isCommand( $_SERVER["argv"][$nam] ) )
        {
          $this->arguments[] = $_SERVER["argv"][$nam];
        }
      }
    }

    if( isset( $this->arguments["-v"] ) )
    {
      $this->verbose = true;
      echo "Bin geschwätzig...\n";
    }

  }//end protected function init

  /**
   *
   */
  protected function loadConf()
  {

    $confName = '../conf/'.$this->appName.'.conf.php';

    if( file_exists( $confName )  )
      include $confName;

  }//end protected function loadConf */


/*//////////////////////////////////////////////////////////////////////////////
// Main Function
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * Main Method
  * overwrite me
  * @return int
  */
  public function main()
  {

    switch( $this->checkAktion() )
    {

      default:
      {
        $this->printHelp();
      }

    }// ende Switch


  }//end public function main */

/*//////////////////////////////////////////////////////////////////////////////
//
// Commands
//
//////////////////////////////////////////////////////////////////////////////*/


 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function printHelp( )
  {
    echo "Projekt ".$this->appName."\n";
    echo "Author: $this->author\n\n";

    echo "Command:\n";
    echo "count               Rekursives durchzählen aller relevanten Dateien\n";
    echo "help                Ausgabe dieser Hilfe\n";
    echo "\n";

    echo "Parameter:\n";
    echo "path /pfad/file     Das zu durchscannende Projekt\n";
    echo "\n";

    echo "Flags:\n";
    echo "-h                  Ausgabe dieser Hilfe\n";
    echo "-v                  Sei geschwätzig\n";
 }


/*//////////////////////////////////////////////////////////////////////////////
// Hilfsfunktionen
//////////////////////////////////////////////////////////////////////////////*/


 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  * @return bool
  */
  protected function isFlag( $Data )
  {

    if( $Data{0} == "-" )
    {
      $this->arguments[$Data] = true;
      return true;
    }
    else
    {
      return false;
    }

  } // end of member function _panicShutdown

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @since 0.1
  * @return array
  */
  protected function isCommand( $Data )
  {
    $Data = strtolower($Data);

    // first win, everything else must be a attribute
    if($this->command)
      return false;

    if( isset( $this->actions[$Data] ) )
    {
      $this->command = $Data;
      return true;
    }
    else
    {
      return false;
    }

  } //end protected function isCommand */

 /**
  * Testen welche Aktion verwendet werden soll
  *
  * @return String
  */
  protected function checkAktion( )
  {

    if( $this->command )
    {
      return $this->command;
    }
    elseif( $this->defaultCommand  )
    {
      return $this->defaultCommand;
    }
    else
    {
      // Keine Action gefunden, dann die Hilfe ausgeben
      return "help";
    }

  }//end protected function checkAktion */


 /**
  * beenden des Programmes
  *
  * @return void
  */
  protected function errorShutdown( $message )
  {

    echo "\n".$message."\n";
    exit(1);

  }//end protected function suicide

 /**
  * ordentliches beenden des programmes
  * @return void
  */
  protected function shutdown( )
  {
    exit(0);
  }//end protected function shutdown

  /**
   *
   *
   */
  protected function execute( $command )
  {

    if( isset($this->debug['no_execute']) )
    {
      $this->outLn($command);
      return;
    }

    if( isset($this->debug['verbose']) )
      $this->outLn('execute: '.$command);

    return system($command);

  }//end protected function execute

  /**
   *
   */
  protected function outLn( $string )
  {
    echo $string."\n";
  }//end protected function outLn */

  /**
   *
   *
   */
  protected function out( $string )
  {
    echo $string;
  }//end protected function out */

  /**
   *
   *
   */
  protected function write( $file,  $content )
  {

    if( isset($this->debug['no_write']) )
    {
      $this->outLn($content);
      return;
    }

    if( isset($this->debug['verbose']) )
      $this->outLn('write: '.$file);

   return file_put_contents( $file,  $content );

  }//end protected function write */

  /**
   *
   *
   */
  protected function read( $file  )
  {

   return file_get_contents( $file  );

  }//end protected function read */

  /**
   */
  protected function in()
  {
    return trim(fgets(STDIN)); // reads one line from STDIN
  }//end public function in */


}//end class

