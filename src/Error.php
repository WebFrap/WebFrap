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
 * de:
 * Hilfsklasse zum behandeln von Fehlern,
 * Wir hauptsächlich als Container für die Fehlercodes verwendet
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 * @author domnik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class Error
{
/*//////////////////////////////////////////////////////////////////////////////
// Error Codes
// ein paar standard fehlercodes
// Die Fehlercodes orientieren sich maßgeblich an den HTTP Statuscodes
// können jedoch ohne Probleme auch auf andere Rückgabe Module als HTTP
// angewendet werden
// @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   *  Missing relevant parts of the request like the objid
   * @var int
   */
  const INVALID_REQUEST = 400;
  
  /**
   *  Missing relevant parts of the request like the objid
   * @var int
   */
  const INVALID_REQUEST_MSG = 'This request was invalid.';
  
  /**
   *  The syntax of the request was not understood by the server.
   * @var int
   */
  const BAD_REQUEST = 400;
  
  /**
   *  The syntax of the request was not understood by the server.
   * @var int
   */
  const BAD_REQUEST_MSG = 'Sorry, the system could not understand your request.';

  /**
   * The request needs user authentication
   * @var int
   */
  const NOT_AUTHORIZED = 401;
  
  /**
   * The request needs user authentication
   * @var int
   */
  const NOT_AUTHORIZED_MSG = 'Authorization required to access this resource.';

  /**
   * The user has no permission to do what ever he tried to do
   * @var int
   */
  const FORBIDDEN = 403;

  /**
   * The user has no permission to do what ever he tried to do
   * @var int
   */
  const FORBIDDEN_MSG = 'Your don\'t own the nessecary permission to access or manipulate this resource.';

  /**
   * Requested resource not exists
   * @var int
   */
  const NOT_FOUND = 404;
  
  /**
   * Requested resource not exists
   * @var int
   */
  const NOT_FOUND_MSG = 'Sorry, the requested resource not exists.';

  /**
   * The Request method is not allowed for this request
   * @var int
   */
  const METHOD_NOT_ALLOWED = 405;
  
  /**
   * The Request method is not allowed for this request
   * @var int
   */
  const METHOD_NOT_ALLOWED_MSG = 'The requested service does not allow your used HTTP Method.';

  /**
   * de:
   * {
   *   Prozess konnte nicht beendet werden, da ein konflikt aufgetreten ist
   *   Wird zb. bei Unique Exceptions verwendet, oder wenn es beim speichern
   *   zu race conditions gekommen ist.
   * }
   * @var int
   */
  const CONFLICT = 409;
  
  
  /**
   * Der Request wurde nicht ausgeführt da constraints dies verhindert haben
   * @var int
   */
  const PRECONDITION_FAILED = 412;
  
  /**
   * Der Request des Clients kann nicht ausgeführt werden, da dieser in seiner
   * Region illegal wäre
   * @var int
   */
  const LEGAL_CONFLICT = 451;

  /**
   * en:
   * {
   *   valid request but internal failure in by handling it
   * }
   * @var int
   */
  const INTERNAL_ERROR = 500;
  
  /**
   * @var string
   */
  const INTERNAL_ERROR_MSG = 'Sorry, something went wrong. Please try again. If persists contact the support.';

  /**
   * en:
   * is used when some standard defines functionallity which is not yet
   * implemented
   *
   * de:
   * Was auch immer angefragt wurd ist leider nicht oder noch nicht implementiert
   *
   * @var int
   */
  const NOT_IMPLEMENTED = 501;
  
  /**
   * @var string
   */
  const NOT_IMPLEMENTED_MSG = 'Sorry, the requested configuration is not yet implemented.';


////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * en:
   *  the error message
   * de:
   *  Die Fehlermeldung als String
   *
   * @var string
   */
  public $message   = null;

  /**
   *  Die Fehlermeldung als String
   *
   * @var string
   */
  public $debugMessage   = null;
  
  /**
   * de:
   * Der Fehler Type
   * @see Error Constanten
   * @var string
   */
  public $errorKey   = Response::INTERNAL_ERROR;

  /**
   *
   * @var array
   */
  protected $errorTrace     = null;

  /**
   *
   * @var string
   */
  protected $file           = null;

  /**
   *
   * @var line
   */
  protected $line           = null;

  /**
   *
   * @var mixed
   */
  protected $coreDump       = null;

  /**
   * data for the last error
   *
   * @var TDataObject
   */
  protected static $lastError = null;

////////////////////////////////////////////////////////////////////////////////
// constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * de:
   * erstellen eines neuen Fehlers
   * 
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   * @param mixed $toDump
   */
  public function construct( $message, $debugMessage = null, $errorKey = Response::INTERNAL_ERROR, $toDump = null )
  {

    if( is_object($message) && $message instanceof Webfrap_Exception  )
    {
      $this->message      = $message->getMessage();
      $this->debugMessage = $message->getDebugMessage();
      $this->errorKey     = $message->getErrorKey();
    }
    else 
    {
      $this->message      = $message;
      $this->debugMessage = $debugMessage;
      $this->errorKey     = $errorKey;
    }
    
  }//end public function construct */

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getMessage()
  {
    return $this->message;
  }//end public function getMessage */
  
  /**
   * @return string
   */
  public function getDebugMessage()
  {
    return $this->debugMessage;
  }//end public function getDebugMessage */

  /**
   * @return int
   * @deprecated
   */
  public function getCode()
  {
    return $this->errorKey;
  }//end public function getCode */
  
  /**
   * @return int
   */
  public function getErrorKey()
  {
    return $this->errorKey;
  }//end public function getErrorKey */

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////


  /**
   * add an error to the system
   * @param string $message Die Fehlermeldung
   * @param mixed optional $toDump Variable zum Dumpen
   * @return Error
   * @deprecated Exceptions bitte direkt werfen, diese funktion bringt keinen Mehrwert
   *    erhöht aber unsinniger weise die laufzeitabstraktion
   */
  public static function report( $message, $toDump = null )
  {

    $metadata = Debug::getCallposition();

    $file = isset($metadata['file'])?$metadata['file']:'unkown file';
    $line = isset($metadata['line'])?$metadata['line']:'unkown line';

    self::$lastError            = new TDataObject();
    self::$lastError->file      = $file;
    self::$lastError->line      = $line;
    self::$lastError->message   = $message;
    self::$lastError->toDump    = $toDump;

    $trace = Debug::backtraceToTable( );

    Debug::console( 'ERROR: '.$file.' '.$line.': '.$message , $toDump, $trace  );

    if($toDump)
    {
      $message .= Debug::getDump( $toDump );
    }

    // eine Debugtrace ausgeben wenn auf Tracing geschaltet ist
    $message .= Debug::backtrace( );

    Log::error( $message );

    return self::$lastError;

  }//end public static function report */



  /**
   * add an error to the system
   * @param string $message Die Fehlermeldung
   * @param string optional $exception Was für ein Typ Exception soll geworfen
   * werden
   * @param mixed optional $toDump Variable zum Dumpen
   * @throws Exception
   * @return void
   */
  public static function addError( $message, $exception = null, $toDump = null )
  {

    $metadata = Debug::getCallposition();

    $file = isset($metadata['file'])?$metadata['file']:'unkown file';
    $line = isset($metadata['line'])?$metadata['line']:'unkown line';

    self::$lastError            = new TDataObject();
    self::$lastError->file      = $file;
    self::$lastError->line      = $line;
    self::$lastError->message   = $message;
    self::$lastError->exception = $exception;
    self::$lastError->toDump    = $toDump;

    // if theres a exeption the exception handels the output of the errors
    if( $exception )
    {
      if( WebFrap::loadable($exception) )
      {
        throw new $exception($message);
      }
      else
      {
        throw new WebfrapFlow_Exception
        (
          'Thrown nonexisting exception: '.$exception.' with message: '.$message
        );
      }
    }
    else // else we have to handle the error output
    {

      if(!$toDump)
        $toDump = $metadata;

      Debug::console( 'ERROR: '.$file.' '.$line.': '.$message , $toDump );

      Log::error(  $file , $line , $message );

      // eine Debugtrace ausgeben wenn auf Tracing geschaltet ist
      if(Log::$levelTrace)
      {
        Debug::logDebugTrace( $message );
        if($toDump)
        {
          if(Log::$levelDebug)
            Debug::appendLogDump( $toDump );
        }
      }
    }

    return self::$lastError;

  }//end public static function addError */


  /**
   * add an error to the system
   * @param string $message Die Fehlermeldung
   * @param string optional $exception Was für ein Typ Exception soll geworfen
   * werden
   * @param mixed optional $toDump Variable zum Dumpen
   * @throws Exception
   * @return void
   */
  public static function addVisualError( $message, $exception = null, $toDump = null )
  {

    $metadata = Debug::getCallposition();
    $file = $metadata['file'];
    $line = $metadata['line'];

    self::$lastError = new TDataObject();
    self::$lastError->file    = $file;
    self::$lastError->line    = $line;
    self::$lastError->message = $message;
    self::$lastError->exception = $exception;
    self::$lastError->toDump  = $toDump;

    Message::addError($message);

    // if theres a exeption the exception handels the output of the errors
    if( $exception )
    {
      if( WebFrap::loadable($exception) )
      {
        throw new $exception($message);
      }
      else
      {
        throw new WebfrapFlow_Exception
        (
          'Thrown nonexisting exception: '.$exception.' with message: '.$message
        );
      }
    }
    else // else we have to handle the error output
    {
      Debug::console( 'ERROR: '.$file.' '.$line.' '.$message , $toDump );
      Log::error(  $file , $line , $message );

      // eine Debugtrace ausgeben wenn auf Tracing geschaltet ist
      if(Log::$levelTrace)
      {
        Debug::logDebugTrace( $message );
        if($toDump)
        {
          if(Log::$levelDebug)
            Debug::appendLogDump( $toDump );
        }
      }
    }

  }//end public static function addError */

  public static function addWarning( $message,  $toDump = null )
  {

    $metadata = Debug::getCallposition();
    $file = $metadata['file'];
    $line = $metadata['line'];

    // if theres a exeption the exception handels the output of the errors
    if(!$toDump)
      $toDump = $metadata;
    else
      Debug::console('TRACE for: '.$message,$metadata);

    Debug::console( 'WARN: '.$file.' '.$line.': '.$message , $toDump );

    Log::warn(  $file , $line , $message );


  }//end public static function addWarning */

  /**
   * Die Daten aus einer Exception in Fehlerkonsole und das logging schreiben
   *
   * @param string $message Die Fehlermeldung
   * @param string optional $exception Was für ein Typ Exception soll geworfen
   * werden
   * @return void
   */
  public static function addException( $message, $exception = null  )
  {
    
    if( is_object($message) )
    {
      $exception = $message;
      $message   = $exception->getMessage();
    }
      
      

    $backTrace  = $exception->getTraceAsString();
    $metadata   = $backTrace[1];
    $file       = $metadata['file'];
    $line       = $metadata['line'];

    if( Log::$levelTrace )
      Debug::console( get_class($exception).': '.$file.' '.$line.' : '.$message, $backTrace );
    else
      Debug::console( get_class($exception).': '.$file.' '.$line.' : '.$message, $backTrace  );

    Log::error(  $file , $line , $message );

  }//end public static function addError */

  /**
   * @param $message
   * @param $exception
   * @param $toDump
   */
  public static function cachtableError( $message , $exception = null, $toDump = null )
  {

    $caller = Debug::getCallerPosition( true );

    $file = $caller['file'];
    $line = $caller['line'];

    Debug::console( 'ERROR: '.$file.' '.$line.' '.$message , $toDump );

    Log::error(  $file , $line , $message );

    // eine Debugtrace ausgeben wenn auf Tracing geschaltet ist
    if(Log::$levelDebug)
      Debug::logDebugTrace( $message );

    if( $toDump )
    {
      if(Log::$levelDebug)
        Debug::appendLogDump( $toDump );

    }

    self::$lastError = new TDataObject();
    self::$lastError->file    = $file;
    self::$lastError->line    = $line;
    self::$lastError->message = $message;
    self::$lastError->exception = $exception;
    self::$lastError->toDump  = $toDump;

    if( $exception )
    {
      if( WebFrap::loadable($exception) )
      {
        throw new $exception($message);
      }
      else
      {
        throw new WebfrapFlow_Exception
        (
        'Thrown nonexisting exception: '.$exception.' with message: '.$message
        );
      }
    }

  }//end public static function addError */

  /** Hinzufügen eines Fehlers
   * @param string $message Die Fehlermeldung
   * @param mixed optional $toDump Variable zum Dumpen
   * @throws Exception
   * @return void
   */
  public static function addFatalError(  $message ,  $toDump = null )
  {

    $caller = Debug::getCallerPosition( true );

    $file = $caller['file'];
    $line = $caller['line'];

    Log::logLine( 'fatal' , $file , $line , $message );

    self::$lastError = new TDataObject();
    self::$lastError->file      = $file;
    self::$lastError->line      = $line;
    self::$lastError->message   = $message;
    //self::$lastError->exception = $exception;
    self::$lastError->toDump    = $toDump;

    // eine Debugtrace ausgeben wenn auf Tracing geschaltet ist
    if(Log::$levelTrace)
      Debug::logDebugTrace( $message );

    if($toDump)
    {
      if(Log::$levelDebug)
       Debug::appendLogDump( $toDump );
    }

    throw new WebfrapFlow_Exception($message);

  }//end public static function addFatalError */

  /**
   * Enter description here...
   *
   * @param string $file
   * @param int $line
   * @param string $message
   */
  public static function errorLog( $file ,  $line , $message )
  {
    if(Log::$levelTrace)
      Debug::logDebugTrace( $message );

    Log::logLine( 'error' , $file , $line , $message );

  }//end public static function errorLog */

  /**
   * @param $name
   * @param $file
   * @param $line
   * @param $message
   */
  public static function errorLogAt( $name, $file , $line , $message )
  {

    if( $log = Log::factoryGet( $name ));
    {

      if($log->logTrace)
        Debug::logDebugTrace( $message );

      $log->error( $file , $line , $message );
    }

  }//end public static function errorLogAt */

  /**
   * Enter description here...
   *
   * @param String $file
   * @param int $line
   * @param String $message
   * @return void
   */
  public static function fatalErrorLog($file , $line ,$message)
  {
    if(Log::$levelTrace)
      Debug::logDebugTrace( $message );

    Log::logLine( 'fatal' , $file , $line , $message );

  }//end public static function fatalErrorLog */

  /**
   * @param $toDump
   * @return void
   */
  public static function appendErrorDump( $toDump )
  {

    Debug::appendLogDump( $toDump );

  }//end public static function appendErrorDump */

  /**
   * @param $toDump
   * @return void
   * /
  public static function coreDump( $toDump )
  {

    Debug::appendLogDump( $toDump );

  }//end public static function coreDump */

  /**
   * Enter description here...
   *
   * @return TDataObject
   */
  public static function getLastError()
  {
    return self::$lastError;
  }//end public function getLastError */

  /**
   * Enter description here...
   *
   * @return void
   */
  public static function resetLastError()
  {
    self::$lastError = null;
  }//end public function resetLastError */

}//end class Error
