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

/** class LibLogFile
 * Die Extention des Logsystem um Lodateien schreiben zu können,
 * sowie um Logdatei verwalten zu können
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibLogFile
  implements LibLogAdapter
{

  /** Die Maximale Größe der Logdatei in kb
   *
   * @var int
   */
  private $maxSize;

  /** Sollen alte Logstände gesichert werden
   *
   * @var int
   */
  private $logRotate;

  /** Vortlaufendes Logging oder Logs anhängen
   *
   * @var boolean
   */
  private $singleRun;

  /** Wieviele alte Logstände sollen gesichert werden
   */
  private $logRoll;

  /** Sollen die gesicherten Logfiles comprimiert werden
   *
   * @var string
   */
  private $compress;

  /** Der Typ der Compression der verwendet werden sollen
   *
   * Möglich sind:
   * <ul>
   * <li>zip</li>
   * <li>gz</li>
   * <li>bz2</li>
   * <ul>
   * @var string type der compression
   */
  private $compressType = null;

  /** Folder in dem die Datei gespeichert wird
   */
  private $folder       = null;

  /** Die Name der Datei
   */
  private $fileName     = null;

  /** Der Filehandle
   */
  private $handle       = null;

  /** accessmode of the file
   */
  private $accessMode   = null;

  /** Actual Size of the Logfile
   */
  private $size         = null;

  /** Default constructor
   * parse the conf and open a file
   *
   */
  public function __construct($conf)
  {

    // Parsen der Konfiuration
    $this->parseConf($conf);

    if ($this->singleRun)
      $this->accessMode = 'w';
    else
      $this->accessMode = 'a' ;

    if (!file_exists($this->folder))
      SFilesystem::createFolder($this->folder);

    $this->handle = fopen($this->folder."/".$this->fileName, $this->accessMode);

  } // end public function __construct */

  /**
   *
   */
  public function __destruct()
  {
    if (is_resource($this->handle))
      fclose($this->handle);
  } // end public function __destruct */

  /** Aktion beim deserialisieren
   *
   * @return
   */
  public function __wakeup()
  {

    // Testen ob die Maximale Loggröße erreicht wurde
    if (!$this->checkSize()) {
      // Wenn Ja mal rotieren lassen
      $this->rotateLog();
    }

    // create a file handle if not yet created by cleaner method
    if (is_null($this->handle)) {
      $this->handle = fopen($this->folder ."/".$this->fileName , $this->accessMode) ;
    }

  } // end public function __wakeup */

  /** Abfragen der aktuellen Dateigröße
   *
   * @param string Format Das Rückgabeformat
   * @return int
   */
  public function getSize($format = 'kb')
  {

    if ($this->size != null) {
      return $this->size ;
    } else {
      if ($size = filesize($this->folder . "/" . $this->fileName)) {
        $this->size =  $size;

        switch ($format) {
          case 'kb':
          {
            return floor($this->size / 1024);
            break;
          }
          case 'mb':
          {
            return floor($this->size / (1024*1024));
            break;
          }
          case 'gb':
          {
            return floor($this->size / (1024*1024*1024));
            break;
          }
          case 'tb':
          {
            return floor($this->size / (1024*1024*1024*1024));
            break;
          }
          default:
          {
            return $this->size;
            break;
          }
        }

      } else {
        return false;
      }
    }

  } // end public function getSize */

  /** Schreiben der Loglinie in das Logmedium
   *
   * @param string time  Zeitpunkt des Logeintrags
   * @param string level Das Loglevel
   * @param string file Die Datei der Loglinie
   * @param int line Die Zeilennummer
   * @param string message Die eigentliche Logmeldung
   * @return

   */
  public function logline($time, $level, $file, $line, $message, $exception)
  {

    if (is_resource($this->handle)) {
      // no more race conditions, hope this will perform
      flock($this->handle,LOCK_EX);
      fseek($this->handle, 0 , SEEK_END); // Ans Ende der Dateisetzen
      fputs ($this->handle , $time."\t".$level."\t".$file."\t".$line."\t".$message.NL); // Logmessage schreiben
      flock($this->handle,LOCK_UN);
    }

  } // end public function logline */

  /**
   * Testen ob Maximale Größe der Logdatei erreicht wurde
   *
   * @return bool
   */
  protected function checkSize()
  {
    if ($this->getSize('kb') > $this->maxSize  )
      return false;
    else
      return true;

  } // end protected function checkSize */

  /**
   * Logrotation durchführen
   *
   * @return bool
   */
  protected function rotateLog()
  {

    if ($this->logRoll) {

      $fillelist = array();
      // Auslesen des Folders
      if (is_dir($this->folder)) {
        if ($dh = opendir($this->folder)) {
          while (($file = readdir($dh)) !== false) {
            if (is_numeric($file{0}))
              $fillelist[] = $file;
          }
          closedir($dh);
        }
      }

      // Testen mit was für Dateitypen wir es zu tun haben, bzw endung ermitteln
      if ($this->compress) {
        $oldfilename = '_' . $this->fileName . '.' . $this->compressType ;
      } else {
        $oldfilename = '_' . $this->fileName;
      }

      // Testen ob eine alte Datei gelöscht werden muss
      if (count($fillelist) > $this->logRotate) {
        $todel = 2143148400; // 30.11.2037 ;-)
        foreach ($fillelist as $file) {

          $filedate = explode("_" , $file);
          $filedate = (float) $filedate[0];

          if ($filedate <  $todel   )
            $todel = $filedate;

        } // Ende Foreach

        if ($todel != '2143148400' and file_exists( $this->folder.$todel.$oldfilename))
          unlink($this->folder.$todel.$oldfilename  );

      }

      // generieren des neuen Timestamps für das alte Logfile
      $pretime = explode(',' , microtime(true) , 1);
      $pretime = $pretime[0];

      copy($this->folder.$this->fileName ,
            $this->folder .  $pretime . '_' . $this->fileName   );

      //Die Logdatei leeren
      $this->clearFile();

      // Testen ob Files comprimiert werden sollen
      if ($this->compress) {
        switch ($this->compressType) {
          case 'bz2':
          {
            exec('bzip2 -z -5 '.$this->folder.$pretime.'_'.$this->fileName);
            break;
          }
          case 'gz':
          {
            exec('gzip -5 '.$this->folder.$pretime.'_'.$this->fileName);
            break;
          }
          case 'zip':
          {
            exec('zip -5 '.$this->folder.$pretime.'_'.$this->fileName.'.zip '.$this->folder. $pretime.'_'. $this->fileName);

            unlink($this->folder.$pretime.'_'.$this->fileName);
            break;
          }

          default:
          {
            throw new Io_Exception(I18n::s('wbf.error.requestUnsupportedCompression'));
            break;
          }
        } // Ende Switch
      } // Ende if ($this->compress)
    } // Ende If
    else {
      // Wir haben keine Mehrfachen Logrotation Backups

      // Testen mit was für Dateitypen wir es zu tun haben, bzw endung ermitteln
      if ($this->compress) {
        $oldfilename = "Last_".$this->fileName.".".$this->compressType;
      } else {
        $oldfilename = "Last_".$this->fileName;
      }

      if (file_exists($this->folder . $oldfilename)) {
        unlink($this->folder .  $oldfilename);
      }

      copy($this->folder . $this->fileName ,
            $this->folder . $oldfilename   );
      //Die Logdatei leeren
      $this->clearFile();
    }

      // Testen ob Files comprimiert werden sollen
      if ($this->compress) {
        switch ($this->compressType) {
          case 'bz2':
          {
            exec('bzip2 -z -5 ' . $oldfilename);
            break;
          }
          case 'gz':
          {
            exec('gzip -5 ' . $oldfilename);
            break;
          }
          case 'zip':
          {
            exec('zip -5 ' . $oldfilename . '.zip ' . $oldfilename);
            unlink($this->folder .  $pretime . '_' . $this->fileName);
            break;
          }

          default:
          {
            throw new Io_Exception(I18n::s('wbf.error.requestUnsupportedCompression'));
            break;
          }

        } // Ende Switch
      } // Ende if ($this->compress)

  } // end protected function rotateLog */

  /**
   * clear the file
   *
   */
  protected function clearFile()
  {
    $this->handle = fopen($this->folder . $this->fileName , 'w');
  }//end protected function clearFile */

  /**
   * parse the conf object
   *
   * @return bool
   */
  protected function parseConf($conf)
  {

    /*
      'singel'    => 'true',
      'logfolder' => 'log/',
      'logfile'   => 'webfrap.log',
      'logroll'   =>  false ,
      'logrotate' => '10',
      'maxsize'   => '10000',
      'compress'  => 'bz2',
     */

    $this->fileName     =   $conf['logfile'];
    $this->folder       =   PATH_GW.$conf['logfolder'];
    $this->maxSize      =   $conf['maxsize'];
    $this->logRotate    =   $conf['logrotate'] - 1;
    $this->logRoll      =   $conf['logroll'];
    $this->compress     =   isset($conf['compress'])?true:false;;
    $this->compressType =   isset($conf['compress'])?$conf['compress']:null;
    $this->singleRun    =   $conf['singel'] ;

  } // end protected function parseConf */

} // end LibLogFile

