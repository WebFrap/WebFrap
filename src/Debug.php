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
 *
 */
class Debug
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var int Lines of assembled Code
   */
  protected static $loc = 0;

  /**
   * Enter description here...
   *
   * @var array
   */
  protected static $incFiles = 0;

  /**
   *
   * @var array
   */
  protected static $console = array();

  /**
   *
   * @var array
   */
  protected static $traces = array();

  /**
   *
   * @var array
   */
  protected static $dumps = array();

  /**
   *
   * @var array
   */
  protected static $files = array();

  /**
   *
   * @var array
   */
  protected static $callCounter = array();

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $message
   */
  public static function logDebugTrace($message = null  )
  {
    // Der Trace Session anhängen

    if (!DEBUG)
      return null;

    if ($message)
      self::$traces[] = "<p>$message</p>\n".Debug::backtrace();
    else
      self::$traces[] = Debug::backtrace();

  }//end public static function logDebugTrace */

  /**
   * Enter description here...
   *
   * @param mixed $toDump
   */
  public static function appendLogDump($toDump   )
  {

    if (!DEBUG)
      return null;

    // Der Trace Session anhängen
    if (Log::$levelTrace) {
      self::$dumps[count(self::$traces) -1] .=
        "<h4>Dump:</h4><pre>".self::dumpToString($toDump)."</pre>";
    }

  }//end public static function appendLogDumpt */

  /**
   * Enter description here...
   *
   * @param string $message
   * @param mixed $toDump
   */
  public static function logDump($message , $toDump   )
  {

    if (!DEBUG)
      return null;

    // Der Trace Session anhängen
    self::$dumps[] = array
    (
      'message'=> $message,
      'dump' => "<pre>".self::dumpToString($toDump)."</pre>"
    );

  }//end public static function logDump  */

  /**
   * @param string $file
   */
  public static function logFile($file   )
  {

    if (!DEBUG)
      return null;

    self::$files[] = $file;
  }//end public static function logFile */

  /**
   * Enter description here...
   *
   * @param unknown_type $message
   */
  public static function debugDie($message = null , $dump = null)
  {

    if (!DEBUG)
      return null;

    echo '<pre>'.self::backtrace().'</pre>';
    echo self::output($dump , $message);
    exit;

  }//end public static function debugDie */

  /**
   * Enter description here...
   *
   * @param string $message
   * @param mixed $data
   */
  public static function end($message  )
  {

    if (!DEBUG)
      return null;

    $metadata = Debug::getCallposition();

    $file = isset($metadata['file'])?$metadata['file']:'unkown file';
    $line = isset($metadata['line'])?$metadata['line']:'unkown line';

    throw new Debug_Exception('Debug Stop: '.$message .' file: '.$file.' line: '.$line);

  }//end public static function end */

  /** Ausgabe eines Debugtraces
  * @param mixed $varToDump Variable die gedumpt werden soll
  * @param String $title Der Title des Dumps
  * @return  String
  */
  public static function output($varToDump , $title = 'anon dump')
  {

    if (!DEBUG)
      return null;

    ob_start();
    var_dump($varToDump);
    $dump = ob_get_contents();
    ob_end_clean();

    return "<pre><h2>DEBUG DUMP: ".strtoupper($title)."</h2>\n$dump\n</pre>";

  }//end public static function output */

  /**
   *
   * @param $toDump
   * @return unknown_type
   */
  public static function xmlPath($child)
  {

    if (!DEBUG)
      return null;

    $path = '';
    //$stack = array();

    $parents = $child->xpath('./ancestor::*');

    foreach ($parents as $node) {

      $nodeName = $node->getName();

      $path .= $node->getName();

      if (in_array($nodeName, array('entity','ref','management','widget')))
        $path .= '[@name="'.$node['name'].'"]';

      $path .= '/';
    }

    $path .= $child->getName();

    return $path;

  }//end public static function xmlPath */

  /**
   *
   * @param $toDump
   * @return unknown_type
   */
  public static function dump($toDump)
  {

    if (!DEBUG)
      return null;

    return '<pre>'.self::dumpToString($toDump).'</pre>';
  }//end public static function dump */

  /**
   * Debug Funktion um eine Variable in eine datei zu dumpen
   *
   * @param string $fileName
   * @param mixed $toDump
   */
  public static function dumpFile($fileName, $toDump, $forceFull = false)
  {

    if (!DEBUG)
      return null;

    $dumpPath = PATH_GW.'tmp/';

    if (!file_exists($dumpPath.$fileName.'.dump'))
       SFilesystem::touchFileFolder($dumpPath.$fileName.'.dump');

    if (is_string($toDump)) {
      file_put_contents($dumpPath.$fileName.'.dump', 'string: '.$toDump);
    } else {
      file_put_contents($dumpPath.$fileName.'.dump', self::dumpToString($toDump, $forceFull));
    }

  }//end public static function dump */

 /**
  * Ausgabe eines Debugtraces
  *
  * @param mixed $toDump Variable die gedupmt werden soll
  * @return String
  */
  public static function getDump($toDump)
  {

    if (!DEBUG)
      return null;

    ob_start();
    var_dump($toDump);
    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  }//end public static function getDump */

 /**
  * Ausgabe eines Debugtraces
  * @param mixed $toDump Variable die gedupmt werden soll
  * @return String
  */
  public static function dumpToString($toDump, $force = false)
  {

    if (!DEBUG)
      return null;

    /**/
    if ($force) {
      ob_start();
      var_dump($toDump);
      $content = ob_get_contents();
      ob_end_clean();

      return $content;
    }

    if (is_object($toDump)) {
      if ($toDump instanceof DOMNode) {
        if (Log::$levelDebug) {
          $toDump = simplexml_import_dom($toDump);
          $content = 'DOMNode: '.htmlentities($toDump->asXml());
        } else {
          $content = 'DOMNode '.$toDump->nodeName;
        }
      } elseif ($toDump instanceof SimpleXmlElement) {
        if (Log::$levelDebug) {
          $toDump = simplexml_import_dom($toDump);
          $content = 'DOMNode: '.htmlentities($toDump->asXml());
        } else {
          $content = 'SimpleXmlElement: ';
        }
      } elseif ($toDump instanceof Webfrap_Exception) {
        $content = $toDump->dump();
      } elseif ($toDump instanceof Exception) {
        $content = 'Exception: '.get_class($toDump).' '.$toDump->getMessage();
      } elseif (method_exists($toDump , 'getDebugDump')) {
        $className = get_class($toDump);
        $content = self::dumpToString($toDump->getDebugDump());
      } else {

        $content = 'Object: '.get_class($toDump);
        /*
        if (Log::$levelDebug) {
          ob_start();
          var_dump($toDump);
          $content = ob_get_contents();
          ob_end_clean();
        } else {
          $content = 'Object: '.get_class($toDump);
        }
        */
      }
    } elseif (is_array($toDump)) {

      if (Log::$levelDebug) {
        $content = self::rawDump($toDump);
      } elseif (Log::$levelVerbose) {
        $content = 'array: size: '.count($toDump).' keys: '.implode(array_keys($toDump),',').NL;

        foreach ($toDump as $key => $data) {
          $content .= '@attr['.$key.']'.Debug::dumpToString($data).';';
        }
      } else {
        $content = 'array: size: '.count($toDump).' keys: '.implode(array_keys($toDump),',').NL;
      }

    } elseif (is_scalar($toDump)) {
      $content = 'scalar: size: '.strlen((string) $toDump).NL;
      $content .= $toDump;

    } else {

      if (Log::$levelDebug) {
        ob_start();
        var_dump($toDump);
        $content = ob_get_contents();
        ob_end_clean();
      } else {
        $content = 'GOT Whatever to dump: '.gettype($toDump);
      }

    }

    return $content;

  }//end public static function dumpToString */

  /**
   * Ausgabe eines Debugtraces
   * @param mixed $toDump Variable die gedupmt werden soll
   * @return String
   */
  public static function rawDump($toDump)
  {

    if (!DEBUG)
      return null;

    ob_start();
    var_dump($toDump);
    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  }//end public static function rawDump */

  /** Ausgabe eines Debugtraces
  * @param mixed $toDump Variable die gedupmt werden soll
  * @return String
  */
  public static function dumpFull($toDump)
  {

    if (!DEBUG)
      return null;

    if (is_object($toDump)) {
      if ($toDump instanceof DOMNode) {
        if (Log::$levelDebug) {
          $toDump = simplexml_import_dom($toDump);
          $content = 'DOMNode: '.htmlentities($toDump->asXml());
        } else {
          $content = 'DOMNode '.$toDump->nodeName;
        }
      } elseif ($toDump instanceof SimpleXmlElement) {
        if (Log::$levelDebug) {
          $toDump = simplexml_import_dom($toDump);
          $content = 'DOMNode: '.htmlentities($toDump->asXml());
        } else {
          $content = 'SimpleXmlElement: ';
        }
      } elseif ($toDump instanceof Webfrap_Exception) {
        $content = $toDump->dump();
      } elseif ($toDump instanceof Exception) {
        $content = 'Exception: '.get_class($toDump).' '.$toDump->getMessage();
      } elseif (method_exists($toDump , 'getDebugDump')) {
        $className = get_class($toDump);
        $content = self::dumpToString($toDump->getDebugDump());
      } else {
        ob_start();
        var_dump($toDump);
        $content = ob_get_contents();
        ob_end_clean();
      }
    } elseif (is_array($toDump)) {

      $content = 'array: size: '.count($toDump).NL;

      foreach ($toDump as $key => $data) {
        $content .= '@attr['.$key.']'.Debug::dumpFull($data).';';
      }

    } elseif (is_scalar($toDump)) {
      $content = 'scalar: size: '.strlen((string) $toDump).NL;
      $content .= $toDump;
    } else {

      if (Log::$levelDebug) {
        ob_start();
        var_dump($toDump);
        $content = ob_get_contents();
        ob_end_clean();
      } else {
        $content = 'GOT Whatever to dump: '.gettype($toDump);
      }

    }

    return $content;

  }//end public static function dumpToString */

  /**
   * Enter description here...
   *
   * @param unknown_type $anz
   * @deprecated
   * /
  public static function addLoc($anz)
  {
    self::$loc += $anz;
    ++self::$incFiles;
  }//end public static function addLoc */

  /**
   * Enter description here...
   *
   * @return unknown
   * @deprecated
   * /
  public static function getLoc()
  {
    return self::$loc;
  }//end public static function getLoc */

  /**
   *
   * @return unknown_type
   * @deprecated
   */
  public static function getFiles()
  {
    return self::$files;
  }//end public static function getFiles */

  /**
   *
   * @return unknown_type
   */
  public static function getIncludedFiles()
  {
    return array_merge(get_included_files()) ;
  }//end public static function getIncludedFiles */

  /**
   * Enter description here...
   *
   * @return array
   * @deprecated
   */
  public static function getNumIncFiles()
  {
    return self::$incFiles;
  }//end public static function getNumIncFiles */

 /** Ausgabe eines Debugtraces als String
  *
  * @param boolean $asArray Soll der Datentype als Array oder String
  *   zurückgegeben  werden
  * @return mixed
  */
  public static function backtrace($asArray = false)
  {
    $backTrace = debug_backtrace();

    $trace = '';

    if ($asArray) {
      $trace = array();
      foreach ($backTrace as $trss) {
        if (isset($trss['file']))
          $trace[] = $trss['file'].' : '.(isset($trss['function'])?$trss['function']:null).' : '.$trss['line'] .NL;
      }
    } else {
      $trace = '';
      foreach ($backTrace as $trss) {
        if (isset($trss['file']))
          $trace .= $trss['file'].' : '.(isset($trss['function'])?$trss['function']:null).' : '.$trss['line'] .NL;
      }
    }

    return $trace;

  }//end public static function backtrace */

  /**
   * @param array
   * @return dump the backtrace in a better readable format
   */
  public static function backtraceToTable($traces = null)
  {

    if (!$traces)
      $traces = debug_backtrace();

    array_shift($traces);

    $table = '<table class="wgt-table error" >';
    $table .= <<<CODE
<thead>
  <tr>
    <th>Pos</th>
    <th>File</th>
    <th>Line</th>
    <th>Called</th>
    <th>Args</th>
  </tr>
</thead>
<tbody>
CODE;

    foreach ($traces as $key => $value) {

      /*
        'file' => string '/var/www/WorkspaceWebFrap/WebFrap/src/lib/LibTemplate.php' (length=74)
        'line' => int 1005
        'function' => string 'include' (length=7)
       */

      $table .= '<tr><td>'.$key.'</td>';

      $table .= '<td>'.(isset($value['file'])?$value['file']:'?').'</td>';
      $table .= '<td>'.(isset($value['line'])?$value['line']:'?').'</td>';

      if (!isset($value['class'])) {
        $table .= '<td>'.$value['function'].'</td>';
      } else {
        $table .= '<td>'.$value['class'].$value['type'].$value['function'].'</td>';
      }

      if (!isset($value['args'])) {
        $table .= '<td></td>';
      } else {

        $table .= '<td>
        <table>
          <thead>
            <tr>
              <th>pos</th>
              <th>type</th>
              <th>value</th>
            </tr>
          </thead>
          <tbody>
              ';

        foreach ($value['args'] as $numArg => $argValue) {
          $type = gettype($argValue);

          $table .='<tr>';
          $table .='<td>'.$numArg.'</td>';
          $table .='<td>'.$type.'</td>';

          if (is_scalar($argValue)) {
            if (is_string($argValue)) {
              $table .='<td>'.htmlentities($argValue).'</td>';
            } else {
              $table .='<td>'.$argValue.'</td>';
            }

          } elseif (is_array($argValue)) {
            $table .='<td>size:'.count($argValue).'</td>';
          } elseif (is_object($argValue)) {

            if ($argValue instanceof DOMNode) {
              if (method_exists($argValue,'hasAttribute') && $argValue->hasAttribute('name')) {
                $table .='<td>DOMNode: '.$argValue->nodeName.' name: '.$argValue->getAttribute('name').'</td>';
              } else {
                $table .='<td>DOMNode: '.$argValue->nodeName.'</td>';
              }

            } else {
              $table .='<td>class: '.get_class($argValue).'</td>';
            }

          } else {
            $table .='<td></td>';
          }

          $table .='</tr>';
        }

        $table .='</tbody></table>';
      }

    }

    $table .= '</tbody></table>';

    return $table;

  }//end public function backtraceToTable */

  /**
   *
   * @return unknown_type
   */
  public static function getCallerPosition($asArrary = false)
  {

    $backTrace = debug_backtrace();
    $meth = $backTrace[2];
    $line = $backTrace[1];

    if ($asArrary)
      return array('file' => $meth['file'] , 'line' => $line['line']  );
    else
      return $meth['file'].' : '.$line['line'];

  }//end public static function getCallerPosition */

  /**
   * 
   */
  public static function getCaller($level = 2)
  {

    $backTrace = debug_backtrace();
    $meth = $backTrace[$level];

    if (isset($meth['class']))
      return $meth['class'].'::'.$meth['function'].' : '.$meth['line'];

    else
      return $meth['function'].' : '.$meth['line'];

  }//end public static function getCaller */

  /**
   *
   */
  public static function getCallposition()
  {

    $backTrace = debug_backtrace();

    return isset($backTrace[2])?$backTrace[2]:'??';

  }//end public static function getCallposition */

  /**
   * Enter description here...
   *
   * @param string $message
   * @param mixed $data
   * @deprecated
   * /
  public static function debugConsole($message , $data = null)
  {

    $entry = array();
    $entry[] = $message;

    if (is_scalar($data)) {
      $entry[] = $data;
    } else {
      $entry[] = Debug::dumpToString($data);
    }

    self::$console[] = $entry;

    self::logDump($message , $data);

  }//end public static function debugConsole */

  /**
   * Enter description here...
   *
   * @param string $message
   * @param mixed $data
   * @param string $trace
   */
  public static function console($message, $data = null, $trace = null, $force = false)
  {

    if (!$force) {
      if (!DEBUG && !DEBUG_CONSOLE)
        return;
    }

    if (defined('STDOUT'))
      fputs(STDOUT, 'DEBUG: '.$message.NL);

    if (!file_exists(PATH_GW.'log')) {
      if (!class_exists('SFilesystem'))
        include PATH_FW.'src/s/SFilesystem.php';

      SFilesystem::mkdir(PATH_GW.'log');
    }

    if (defined('WBF_CONSOLE_LOG'))
      $logFile = WBF_CONSOLE_LOG;
    else
      $logFile = 'console.html';

    $entry = array();
    $entry[0] = $message;

    if ($trace === true)
      $trace = Debug::backtrace();

    if (is_scalar($data)) {
      $entry[1] = $data.(string) $trace;
    } else {
      $entry[1] = Debug::dumpToString($data, $force).(string) $trace;
    }

    //SFiles::write(PATH_GW.'log/'.$logFile, 'MESSAGE: '.$message, 'a');
    //SFiles::write(PATH_GW.'log/'.$logFile, $entry[1], 'a');

    if (DEBUG_CONSOLE) {
      self::$console[] = $entry;
    }

    if ('cli' === View::$type)
      echo $message.NL;

    // need to check
    if (DEBUG) {
      self::logDump($message , $data);
    }

  }//end public static function console */

  /**
   * Console with debug trace
   * @param string $message
   * @param mixed $data
   * @param boolean $force enforce a full dump
   */
  public static function tconsole($message, $data = null, $force = false)
  {
    return self::console($message, $data, true, $force);

  }//end public static function tconsole */

  /**
   * Enter description here...
   *
   * @param string $message
   * @param mixed $data
   */
  public static function point($key , $data = null  )
  {

    if (!DEBUG)
      return null;

    self::$callCounter[$key][] = true;

    $entry = array();
    $entry[] = 'POINT: '.$key.': '.count(self::$callCounter[$key]) ;

    if (is_scalar($data)) {
      $dump = $data.' called by '.self::backtraceToTable();
    } else {
      $dump = Debug::dumpToString($data).' called by '.self::backtraceToTable();
    }

    $entry[] = $dump;

    if (DEBUG_CONSOLE) {
      self::$console[] = $entry;
    }

    if (DEBUG) {
      self::logDump($key , $data);
    }

  }//end public static function point */

  /**
   * Enter description here...
   *
   * @param string $message
   * @param mixed $data
   */
  public static function resetPoint($key   )
  {

    self::$callCounter[$key] = array();

  }//end public static function resetPoint */

  /**
   * Enter description here...
   * @return string
   */
  public static function consoleHtml()
  {

    if (!DEBUG)
      return null;

    $html = '';

    $time = time();

    if (DEBUG) {
      $renderDur = Webfrap::getDuration(Webfrap::$scriptStart);
      $html .= '<h3>Render Duration: '.$renderDur.'</h3>';
      ++$time;

      $renderDur = Webfrap::$env->getDb()->queryTime;
      $html .= '<h3>DB Duration: '.$renderDur.'</h3>';
      ++$time;
    }

    foreach (self::$console as $entry) {
      $html .= '<h3 onclick="$S(\'#wgtIdDebug_'.trim($time).'\').toggle()" style="cursor:pointer;" >'.Validator::sanitizeHtml($entry[0]).'</h3>';
      $html .= '<pre style="display:none;" id="wgtIdDebug_'.trim($time).'" >'.$entry[1].'</pre>';
      ++$time;
    }

    SFiles::write(PATH_GW.'tmp/debug_dump.html', $html);

    return $html;

  }//end public static function consoleHtml */

  /**
   * speichern der console in eine datei
   */
  public static function consoleSave()
  {

    if (!DEBUG)
      return null;

    $html = '';

    $time = time();

    foreach (self::$console as $entry) {
      $html .= 'ENTRY: '.$time.' '.$entry[0].NL;
      $html .= $entry[1];
      ++$time;
    }

    SFiles::write(PATH_GW.'log/console.log' , $html);

  }//end public static function consoleHtml */

  /**
   *
   * @return void
   */
  public static function  publishDebugdata()
  {
    $_SESSION['TRACES'] = self::$traces;
    $_SESSION['DUMPS'] = self::$dumps;
    $_SESSION['FILES'] = self::getIncludedFiles();
  }//end public static function  publishDebugdata */

  /**
   *
   * @return void
   */
  public static function clean()
  {

    $_SESSION['TRACES'] = array();
    $_SESSION['DUMPS'] = array();
    $_SESSION['FILES'] = array();
    $_SESSION['SCREENLOG'] = array();
    $_SESSION['PHPLOG'] = array();
    $_SESSION['BUFFERD_OUT'] = null;

  }//end public static function clean */

}//end class Debug

