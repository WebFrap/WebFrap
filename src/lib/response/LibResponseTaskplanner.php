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
class LibResponseTaskplanner extends LibResponse
{

  /**
   * @var string
   */
  public $type = 'cli';

  /**
   * @var string
   */
  public $status = null;

  /**
   * write
   * @param string $content
   */
  public function write($content)
  {
    fputs(STDOUT, $content);
  }//end public function write */

  /**
   * @param string $content
   */
  public function writeLn($content)
  {
    fputs(STDOUT, $content.NL);
  }//end public function writeLn */

  /**
   * @param string $content
   */
  public function writeErr($content)
  {
    fputs(STDERR, $content);
  }//end public function writeErr */

  /**
   * @param string $content
   */
  public function writeErrLn($content)
  {
    fputs(STDERR, $content.NL);
  }//end public function writeErr */

  /**
   * write
   * @param string $content
   */
  public function console($content)
  {
    fputs(STDOUT, $content.NL);
  }//end public function console */

  /**
   * write
   * @param string $content
   */
  public function line()
  {
    $this->writeLn('--------------------------------------------------------------------------------');
  }//end public function write */

/*//////////////////////////////////////////////////////////////////////////////
// messages
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @console
   * @param string $message
   */
  public function addMessage($message)
  {
    $this->writeLn($message);
  }//end public function addMessage */

  /**
   *
   * @console
   * @param string $warning
   */
  public function addWarning($warning)
  {
    $this->writeLn($warning);
  }//end public function addWarning */

  /**
   *
   * @console
   * @param string $error
   *
   */
  public function addError($error)
  {
    $this->writeErrLn($error);
  }//end public function addError */

  /**
   *
   * Enter description here ...
   * @param int $status
   */
  public function setStatus($status)
  {
    $this->status =  $status;
  }//end public function setStatus */

  /**
   * flush the page
   *
   * @return void
   */
  public function compile()
  {

    $this->tpl->compile();

  }//end public function compile */

  /**
   * flush the page
   *
   * @return void
   */
  public function publish()
  {

    $this->tpl->publish();

  }//end public function publish */

} // end LibResponseTaskplanner

