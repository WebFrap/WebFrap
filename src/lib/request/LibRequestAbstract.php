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
 * @subpackage Request
 *
 */
abstract class LibRequestAbstract
{

  /**
   *
   * @var LibMessagePool
   */
  protected $messages = null;

  /**
   *
   * @param $messages
   * @return unknown_type
   */
  public function setMessage($messages )
  {
    $this->messages = $messages;
  }//end public function setMessage($messages )


}// end abstract class LibRequestAbstract


