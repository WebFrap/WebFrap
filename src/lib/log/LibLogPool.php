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
 * Logappender für die Ausgabe der Logmeldung in die Console
 * @package WebFrap
 * @subpackage tech_core
 */
class LibLogPool
{

  /**
   * flag level Trace
   *
   * @var boolean
   */
  public $logTrace    = false;

  /**
   * flag level Debug
   *
   * @var boolean
   */
  public $logDebug    = false;

  /**
   * flag level Verbose
   *
   * @var boolean
   */
  public $logVerbose  = false;

  /**
   * flag level Config
   *
   * @var boolean
   */
  public $logConfig   = false;

  /**
   * Alle Logappender welche zum Logging benutzt werden sollen
   * @var array<ILogAppender>
   */
  private $logAppender = array();

  /**
   * Zuweißung Module Loglevel
   */
  private $level = array();

  /**
   * Array zum Speichern welche Klassen mit einem Seperaten Loglevel geloggt werden
   */
  private $classLevel = array();

  /**
   * Die geladenen Logappender
   * @var array<ILogAppender>
   */
  private $loadedAppender = array();

  /**
   * Array mit den vorhandenen Logleveln
   * @var array
   */
  /*
  private $logLevel = array
  (
  'TRACE'     => 1,
  'DEBUG'     => 2,
  'VERBOSE'   => 4,
  'CONFIG'    => 8,
  'INFO'      => 16,
  'USER'      => 32,
  'WARN'      => 64,
  'SECURITY'  => 128,
  'ERROR'     => 256,
  'FATAL'     => 512
  );
  */

  private $logLevel = array
  (
    'TRACE'     => 1,
    'DEBUG'     => 2,
    'VERBOSE'   => 4,
    'CONFIG'    => 8,
    'INFO'      => 16,
    'USER'      => 32,
    'WARN'      => 64,
    'SECURITY'  => 128,
    'ERROR'     => 256,
    'FATAL'     => 512
  );

  /**
   * Standard Konstruktor konfiguriert die verschiedenen Logappender
   *
   * @param array $conf Konfigurationsdaten
   */
  public function __construct()
  {
    $this->initialize();
  } // end private function __construct */

  /**
   * Die Callfunktion die das komplette Loggin implementiert
   *
   * @param string  $method Name der aufgerufenen Methode
   * @param array   $arguments Die übergebenen Parameter
   * @return void
   */
  public function __call($method , $arguments)
  {

    //Erst den Methodenamen groß machen
    $method = strtoupper($method);

    // logAppender in alle Logmedien
    foreach ($this->logAppender as $name) {

      $aktLevel =  $this->level[$name];

      foreach ($this->classLevel[$name] as $dname => $level) {
        $datname = $dname . ".php";

        if (preg_match("/".$datname."/", $arguments[0])) {
          $aktLevel =  $this->logLevel[$level];
          break;
        } // Ende If

      } // Ende foreach;

      if (isset($this->logLevel[$method]) && $aktLevel[$this->logLevel[$method]]  ) {
        $mod = $this->loadedAppender[$name];
        $mod->logline
        (
          self::logtime(), // Time
          $method,
          $arguments[0], // File
          $arguments[1], // Line
          $arguments[2], // Message
          $arguments[3]  // Exception
        ); // Meldung
      } // ENDE IF

    } // ENDE FOREACH

  } // end public function __call */

  /**
   * Initialisieren des Logsystems
   *
   * @return void
   */
  public function initialize()
  {

    if (!$conf = Conf::get('log'))
      return;

    // Die logAppendermodue auslesen
    foreach ($conf['activ'] as $appender)
      $this->logAppender[] = $appender;

    // Die Logmodule auslese und die Extensions laden
    foreach ($conf['appender'] as $target => $modul) {

      if (in_array($target , $this->logAppender  )) {

        $class = "LibLog".ucfirst($modul['class']);

        $logMask = $this->parseLoglevel($modul['level']);

        $this->level[$target] = $logMask ;
        $this->classLevel[$target] =  isset($modul['logareas']) ? $modul['logareas'] : array();

        if (WebFrap::loadable($class)  )
          $this->loadedAppender[$target] = new $class($modul);
        else
          throw new WebfrapService_Exception('invalid config');

      } // Ende If
    } // ENDE FOREACH

    if ($this->getTrace()) {
      Log::$levelTrace  = true;
      $this->logTrace   = true;
    } else {
      Log::$levelTrace = false;
    }

    if ($this->getDebug()) {
      Log::$levelDebug  = true;
      $this->logDebug   = true;
    } else {
      Log::$levelDebug = false ;
    }

    if ($this->getVerbose()) {
      Log::$levelVerbose  = true ;
      $this->logVerbose   = true;
    } else {
      Log::$levelVerbose = false;
    }

    if ($this->getConfig()) {
      Log::$levelConfig   = true;
      $this->logConfig    = true;
    } else {
      Log::$levelConfig = false;
    }

  } // end public function initialize */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

// Gette und Setter

  /**
   * Die Callfunktion die das komplette Loggin implementiert
   *
   * @return boolean
   */
  public function getTrace()
  {

    foreach ($this->logAppender as $name) {
      $aktLevel =  $this->level[$name];
      if ($aktLevel[$this->logLevel["TRACE"]]  )
       return true;

    } // ENDE FOREACH

    return false;

  }//end public function getTrace */

  /**
   * Die Callfunktion die das komplette Loggin implementiert
   *
   * @return boolean
   */
  public function getDebug()
  {
    foreach ($this->logAppender as $name) {
      $aktLevel =  $this->level[$name];
      if ($aktLevel[$this->logLevel["DEBUG"]])
        return true;

    } // ENDE FOREACH

    return false;
  }//end public function getDebug */

  /**
   * Die Callfunktion die das komplette Loggin implementiert
   *
   * @return boolean
   */
  public function getVerbose()
  {
    foreach ($this->logAppender as $name) {
      $aktLevel =  $this->level[$name];
      if ($aktLevel[$this->logLevel["VERBOSE"]]  )
        return true;

    } // ENDE FOREACH

    return false;
  }//end public function getVerbose */

  /**
   * Die Callfunktion die das komplette Loggin implementiert
   *
   * @return boolean
   */
  public function getConfig()
  {
    foreach ($this->logAppender as $name) {
      $aktLevel =  $this->level[$name];
      if ($aktLevel[$this->logLevel["CONFIG"]]  )
        return true;

    } // ENDE FOREACH

    return false;
  }//end public function getConfig  */

  /**
   * @param string $level
   * @return TBitmask
   */
  public function parseLoglevel($level)
  {

    // remove whitespace
    $level = str_replace(' ', '' , $level  );
    $mask = array();
    $levels = explode(',' , $level);

    foreach ($levels as $pos) {

      if ($pos[0] == '+') {
        $tmp = strtoupper(substr($pos,1));
        $seen = false;

        foreach ($this->logLevel as $key => $value) {

          if ($seen) {
            $mask[$value] = 1;
          } elseif ($key == $tmp) {
            $seen = true;
            $mask[$value] = 1;
          }

        }//end foreach
      } elseif ($pos[0] == '-') {

        $tmp = strtoupper(substr($pos,1));

        if (isset($this->logLevel[$tmp]))
          $mask[$this->logLevel[$tmp]] = 0;

      } else {

        if (strrpos($pos , '-'  )) {
          $tmp    = explode('-', $pos);

          $start  = strtoupper($tmp[0]);
          $end    = strtoupper($tmp[1]);

          $seen   = false;

          foreach ($this->logLevel as $key => $value) {

            if ($key == $end) {
              $mask[$value] = 1;
              break;
            }

            if ($seen) {
              $mask[$value] = 1;
            } elseif ($key == $start) {
              $seen = true;
              $mask[$value] = 1;
            }

          }//end foreach

        } else {
          $pos = strtoupper($pos);

          if (isset($this->logLevel[$pos]))
            $mask[$this->logLevel[$pos]] = 1;
        }
      }
    }

    $logmask = new TBitmask($mask);

    return $logmask;

  }//end public function parseLoglevel */

  /**
   * Enable Debugging during the runtime
   */
  public function enableDebugging()
  {

    $target = 'SESSION';

    Log::$levelDebug    = true;
    $this->logDebug = true;

    $logMask = $this->parseLoglevel('DEBUG-USER,-CONFIG,+SECURITY');

    $this->level[$target] = $logMask ;
    $this->classLevel[$target] =  array();

    if (isset($this->loadedAppender[$target]))
      return true;

    $this->loadedAppender[$target] = new LibLogSession(array());

  }//end public function enableDebugging */

} // end class LibLogPool

