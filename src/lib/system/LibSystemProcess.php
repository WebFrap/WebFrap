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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSystemProcess
{

  /**
   * Die Prozess Resource
   * @var Resource
   */
  protected $proc   = null;

  /**
   *
   * @var string
   */
  protected $stdin  = null;

  /**
   *
   * @var string
   */
  protected $stdout  = null;

  /**
   *
   * @var string
   */
  protected $stderr  = null;

  /**
   * first simple call method
   * @param string $command
   * @param string $params
   */
  public function call($command , $params = null, $execPath = null)
  {

    $actFolder = null;

    if ($execPath) {
      $actFolder = getcwd();
      chdir($execPath);
    }

    $result = '';

    if (is_array($params))
      $params = implode(' ', $params);

    if ($params)
      $command .= ' '.escapeshellcmd($params);

    if ($proc = popen("({$command})2>&1","r")) {
      while (!feof($proc))
        $result .= fgets($proc, 1000);

      pclose($proc);
    }

    if (DEBUG)
      Debug::console($command , $result);

    if ($actFolder)
      chdir($actFolder);

    return $result;

  }//end public function call */

  /**
   * first simple call method
   * @param string $command
   * @param string $params
   */
  public function callAsRoot($command , $params = null)
  {

    $result = '';

    if ($params)
      $command .= ' '.escapeshellcmd($params);

    if ($proc = popen("({$command})2>&1","r")) {
      while (!feof($proc))
        $result .= fgets($proc, 1000);

      pclose($proc);
    }

    if (DEBUG)
      Debug::console($command , $result);

    return $result;

  }//end public function call */

  /**
   *
   */
  public function open($command , $params = null, $env = null  )
  {

    $spec = array
    (
       0 => array("pipe", "r"),  // stdin pipe for reading input
       1 => array("pipe", "w"),  // stdout pipe for standard output
       2 => array("pipe", "w")   // stderr pipe for errors
    );

    if (is_array($params))
      $params = implode(' ', $params);

    if ($params)
      $command .= ' '.escapeshellcmd($params);

    $this->proc = proc_open($command ,$spec, $pipes, null, $env);

    if (!is_resource($this->proc)) {
      return false;
    } else {
      $this->stdin  = $pipes[0];
      $this->stdout = $pipes[1];
      $this->stderr = $pipes[2];

      return true;
    }

    //stream_set_blocking($this->stderr, 0);
    //stream_set_blocking($this->stdin, 0);
    //stream_set_blocking($this->stdout, 0);

    //fclose($this->stdin);
    //fclose($this->stdout);

  }//end public function open */

  /**
   *
   */
  public function readLine()
  {

    if (feof($this->stdout))
      return null;

    return fgets($this->stdout, 1024);

  }//end public function readLine */

  /**
   *
   */
  public function read()
  {

    $content = stream_get_contents($this->stdout);
    fclose($this->stdout);

    return $content;

  }//end public function read */

  /**
   *
   */
  public function readError()
  {
    return stream_get_contents($this->stderr);

  }//end public function read */

  /**
   * @param string
   */
  public function write($content)
  {
    return fputs($this->stdin, $content, 1024);
  }//end public function write */

  /**
   * Beenden des Programmes
   */
  public function close()
  {
    return proc_close($this->proc);
  }//end public function close */

} // end class LibSystemProcess

