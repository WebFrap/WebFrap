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
 * Class to create simple protocols
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibProtocolFile
{

  /** Die Name der Datei
   */
  private $fileName     = null;

  /** Der Filehandle
   */
  private $handle       = null;

  /** Default constructor
   *  the conf and open a file
   *
   */
  public function __construct($fileName , $accessMode  = 'w')
  {

    $this->fileName = $fileName;

    $folder = dirname($fileName);

    if (!file_exists($folder))
      SFilesystem::createFolder($folder);

    $this->handle = fopen($fileName, $accessMode);

    $this->open();

  } // end public function __construct */

  /**
   *
   */
  public function __destruct()
  {

    $this->close();

    if (is_resource($this->handle))
      fclose($this->handle);

  } // end public function __destruct */

  /** Schreiben der Loglinie in das Logmedium
   *
   * @param string time  Zeitpunkt des Logeintrags
   * @param string level Das Loglevel
   * @param string file Die Datei der Loglinie
   * @param int line Die Zeilennummer
   * @param string message Die eigentliche Logmeldung
   * @return

   */
  public function write($message)
  {

    if (is_resource($this->handle)) {
      // no more race conditions, hope this will perform
      flock($this->handle,LOCK_EX);
      fseek($this->handle, 0 , SEEK_END); // Ans Ende der Dateisetzen
      fputs ($this->handle , $message.NL); // Logmessage schreiben
      flock($this->handle,LOCK_UN);
    }

  } // end public function write */

  /**
   * clear the file
   *
   */
  public function clear()
  {
    $this->handle = fopen($this->fileName , 'w');
  }//end protected function clearFile */

  public function open()
  {

  }

  public function close()
  {

  }

} // end LibProtocolFile

