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

if (!ENABLE_FIREPHP) {
  include PATH_VENDOR.'FirePHPLibrary/lib/FirePHPCore/FirePHP.class.php';
}

/**
 * @package WebFrap
 * @subpackage tech_core
 */
class LibLogFirephp
  implements LibLogAdapter
{

  /**
   * Enter description here...
   *
   * @var FirePHP
   */
  private $firephp = null;

  /** default constructor
   */
  public function  __construct($conf)
  {
    $this->firephp = FirePHP::getInstance(true);
  }//end public function  __construct */

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception)
  {

    if (View::$blockHeader) return;

    if ($level <=  5) {
      $this->firephp->fb("$time $level $file $line $message", FirePHP::INFO);
    } elseif ($level == 6) {
      $this->firephp->fb("$time $level $file $line $message", FirePHP::WARN);
    } else {
      $this->firephp->fb("$time $level $file $line $message",FirePHP::ERROR);
    }

  } // end public function logline */

} // end class LibLogFirephp

