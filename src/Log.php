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
 * class Log
 * Heißt zwar wie eine Systemmodul ist aber streng genommen keins
 * Das Logsystem ist nicht so tief in Webfrap verknüft wie die Standard
 * Module.
 * Theoretisch ist es so recht einfach, das StandardLogsystem durch ein
 * anderes Logsystem zu ersetzen, zb Log4PHP oder ähnliches
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class Log
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  const TRACE     = 1;
  
  const DEBUG     = 2;
  
  const VERBOSE   = 4;
  
  const CONFIG    = 8;
  
  const INFO      = 16;
  
  const USER      = 32;
  
  const WARN      = 64;
  
  const SECURITY  = 128;
  
  const ERROR     = 256;
  
  const FATAL     = 512;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * instance for singleton
   * @var Log
   */
  private static $instance = null;

  /**
   * flag level Trace
   *
   * @var boolean
   */
  public static $levelTrace = false;

  /**
   * flag level Debug
   *
   * @var boolean
   */
  public static $levelDebug = false;

  /**
   * flag level Verbose
   *
   * @var boolean
   */
  public static $levelVerbose = false;

  /**
   * flag level Config
   *
   * @var boolean
   */
  public static $levelConfig = false;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /** GetInstance zum implementieren von Singelton
   *
   * @return LibLogPool
   */
  public static function getInstance( )
  {
    return self::$instance;
  } // end public static function getInstance */

  /** GetInstance zum implementieren von Singelton
   *
   * @return LibLogPool
   */
  public static function getActive( )
  {
    return self::$instance;
  } // end public static function getActive */
  
  /**
   * GetInstance zum implementieren von Singelton
   */
  public static function init( )
  {
    self::$instance = new LibLogPool();
  } // end public static function init */

  /**
   *
   * @return unknown_type
   */
  public static function cleanDebugLog()
  {

    if (!file_exists(PATH_GW.'log') )
      SFilesystem::mkdir(PATH_GW.'log');

    if(defined('WGT_ERROR_LOG'))
      $logFile = WGT_ERROR_LOG;
    else
      $logFile = 'log.html';

    // only the full logs are cleaned, first log stays until the next error
    SFiles::write( PATH_GW.'log/'.$logFile, '' , 'w');

  }

  /**
   * Gibt eine für die Logfiles formatierten String der aktuellen Zeit zurück
   *
   * @return float
   */
  public static function logtime( )
  {
    $time = gettimeofday();
    $logtime =  $time['sec'].".".$time['usec'];

    //$logtime =  date( "Y-m-d H:i:s." ).$time['usec'];
    //$logtime = microtime( true );

    return $logtime;
  }//end public static function logtime */

  /**
   * Statisches Loggen, möglich dank getInstance
   *
   * @return void
   */
  public static function logLine( $level , $file, $Line, $message  )
  {

    if( $log = self::$instance )
    {
      $log->$level( $file, $Line, $message );
    }

  }//end public static function logLine */

  /**
   *
   * @param String $file
   * @param int $Line
   * @param String $method
   * @param mixed $logContent
   * @return  void
   */
  public static function start( $file, $Line , $method , $params = array() , $level = 'debug')
  {

    if (!is_null(self::$instance) )
    {
      $logMessage =  'started function '.$method.'(';

      foreach( $params as $name => $value )
      {
        if( is_scalar($value) )
        {
          $logMessage .= '  '.$name.' => '.$value.' ';
        }
        else
        {
          $logMessage .= ' '.$name.' => '.gettype($value).' ';
        }
      }
      $logMessage .=  ' )';

      self::$instance->$level( $file, $Line,$logMessage,null);

    }
  } //end public static function start */

  /**
   *
   * @param String $file
   * @param int $Line
   * @param String $method
   * @param mixed $logContent
   * @return  void
   */
  public static function startVerbose( $file, $Line , $method , $params = array() )
  {

    if (!is_null(self::$instance) )
    {
      $logMessage =  'started function '.$method.'(';

      foreach( $params as $name => $value )
      {
        if( is_scalar($value) )
        {
          $logMessage .= '  '.$name.' => '.$value.' ';
        }
        else
        {
          $logMessage .= ' '.$name.' => '.gettype($value).' ';
        }
      }
      $logMessage .=  ' )';

      self::$instance->verbose( $file, $Line,$logMessage,null);

    }
  } //end public static function startVerbose */

  /**
   *
   * @param String $file
   * @param int $Line
   * @param String $method
   * @param mixed $logContent
   * @return  void
   */
  public static function startDeprecated( $file, $Line , $method , $params = array() )
  {

    if (!is_null(self::$instance) )
    {
      $logMessage =  'started deprecacted function '.$method.'(';

      foreach( $params as $name => $value )
      {
        if( is_scalar($value) )
        {
          $logMessage .= '  '.$name.' => '.$value.' ';
        }
        else
        {
          $logMessage .= ' '.$name.' => '.gettype($value).' ';
        }
      }
      $logMessage .=  ' )';

      self::$instance->warn( $file, $Line,$logMessage,null);

    }
  } //end public static function startDeprecated */

  /**
   *
   * @param String $file
   * @param int $Line
   * @param String $method
   * @param mixed $logContent
   * @return  void
   */
  public static function startDummy( $file, $Line , $method , $params = array() )
  {

    if (!is_null(self::$instance) )
    {
      $logMessage =  'started dummy function '.$method.'(';

      foreach( $params as $name => $value )
      {
        if( is_scalar($value) )
        {
          $logMessage .= '  '.$name.' => '.$value.' ';
        }
        else
        {
          $logMessage .= ' '.$name.' => '.gettype($value).' ';
        }
      }
      $logMessage .=  ' )';

      self::$instance->warn( $file, $Line,$logMessage,null);

    }
  } //end public static function startDummy */

  /**
   *
   * @param String $file
   * @param int $Line
   * @param String $method
   * @param mixed $logContent
   * @return  void
   */
  public static function startOverride( $file, $Line , $method , $params = array() )
  {

    if (!is_null(self::$instance) )
    {
      $logMessage =  'started the function '.$method.'(';

      foreach( $params as $name => $value )
      {
        if( is_scalar($value) )
        {
          $logMessage .= '  '.$name.' => '.$value.' ';
        }
        else
        {
          $logMessage .= ' '.$name.' => '.gettype($value).' ';
        }
      }
      $logMessage .=  ' ), but this function should be overwritten';

      self::$instance->warn( $file, $Line,$logMessage,null);

    }
  } //end public static function startOverride */

  /**
   * Enter description here...
   *
   * @param string $class
   * @param array $params
   */
  public static function create( $class, $params = array() )
  {

    if( is_object($class))
    {
      $class = get_class($class);
    }

    if (!is_null(self::$instance) )
    {

      if( is_object($class) )
      {
        $class = get_class($class);
      }

      $logMessage = 'created new '.$class.' object with parameters: ';
      if( is_array($params) )
      {
        foreach( $params as $name => $value )
        {
          if( is_scalar($value) )
          {
            $logMessage .= '  '.$name.' => '.$value.' ';
          }
          else
          {
            $logMessage .= ' '.$name.' => '.gettype($value).' ';
          }
        }
      }

      self::$instance->debug( null , null,  $logMessage,null);
    }

  } //end public static function start */

  /**
   * Enter description here...
   *
   * @param unknown_type $file
   * @param unknown_type $Line
   * @param unknown_type $method
   * @param unknown_type $logContent
   */
  public static function end( $file, $Line , $method , $logContent = null )
  {

    if (!is_null( self::$instance) )
    {

    $logMessage = 'end of method '.$method;

      if( is_scalar($logContent) or is_object($logContent) )
      {
        $logMessage .= ' '.$logContent;
      }
      else
      {
        $logMessage .= Debug::dumpToString($logContent);
      }

      self::$instance->debug( $file, $Line, $logMessage,null );
    }
  } //end public static function end */

  /**
   * Enter description here...
   *
   * @param unknown_type $file
   * @param unknown_type $Line
   * @param unknown_type $method
   * @param unknown_type $logContent
   */
  public static function endVerbose( $file, $Line , $method , $logContent = null )
  {

    if (!is_null( self::$instance) )
    {

    $logMessage = 'end of method '.$method;

      if( is_scalar($logContent) or is_object($logContent) )
      {
        $logMessage .= ' '.$logContent;
      }
      else
      {
        $logMessage .= Debug::dumpToString($logContent);
      }

      self::$instance->verbose( $file, $Line, $logMessage,null );
    }
  } //end public static function end */

  /**
   * Enter description here...
   *
   * @param unknown_type $file
   * @param unknown_type $Line
   * @param unknown_type $method
   * @param unknown_type $logContent
   */
  public static function endWarn( $file, $Line , $method , $logContent = null )
  {

    if (!is_null(self::$instance) )
    {
      self::$instance->warn( $file, $Line, 'dissatisfactory end of method '.$method.' cause '.$logContent,null );
    }
  } //end public static function endWarn */



/*//////////////////////////////////////////////////////////////////////////////
// Static logging
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * @param $file
   * @param $line
   * @param $message
   * @return unknown_type
   */
  public static function trace( $file, $line = null, $message = null, $exception = null )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->trace( $file, $line, $message, $exception );
    }

  }//end public static function trace */

  /**
   *
   * @param $file
   * @param $line
   * @param $message
   * @return unknown_type
   */
  public static function debug( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance)  )
    {
      self::$instance->debug( $file, $line, $message, $exception );
    }

  }//end public static function debug */

  /**
   *
   * @param $file
   * @param $line
   * @param $message
   * @return unknown_type
   */
  public static function verbose( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->verbose( $file, $line, $message, $exception );
    }

  }//end public static function verbose */
  
  /**
   *
   * @param $toDump
   */
  public static function dumpVerbose( $toDump )
  {

    $pos = Debug::getCallposition();

    $file = $pos['file'];
    $line = $pos['line'];

    if (!is_null(self::$instance) )
    {
      self::$instance->verbose( $file, $line, Debug::dumpToString($toDump,true) );
    }

  }//end public static function dumpVerbose */

  /**
   *
   * @param $file
   * @param $line
   * @param $message
   * @return unknown_type
   */
  public static function config( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->config( $file, $line, $message, $exception );
    }

  }//end public static function config */

  /**
   *
   * @param $file
   * @param $line
   * @param $message
   * @return unknown_type
   */
  public static function user( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->user( $file, $line, $message, $exception );
    }

  }//end public static function user */

  /**
   *
   * @param $file
   * @param $line
   * @param $message
   * @return unknown_type
   */
  public static function info( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->info( $file, $line, $message, $exception );
    }

  }//end public static function info */

  /**
   * Statisches Loggen, möglich dank getInstance
   *
   * @return void
   */
  public static function warn( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->warn( $file, $line, $message, $exception );
    }

  }//end public static function warn */

  /**
   * Statisches Loggen, möglich dank getInstance
   *
   * @return void
   */
  public static function error( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->error( $file, $line, $message, $exception );
    }

  }//end public static function error */

  /**
   * Statisches Loggen, möglich dank getInstance
   *
   * @return void
   */
  public static function fatal( $file, $line = null, $message = null, $exception = null  )
  {

    if( func_num_args() < 3 )
    {
      $pos = Debug::getCallposition();

      $message = $file;
      $file = $pos['file'];
      $line = $pos['line'];
    }

    if (!is_null(self::$instance) )
    {
      self::$instance->fatal( $file, $line, $message, $exception );
    }

  }//end public static function fatal */

} // end class Log

