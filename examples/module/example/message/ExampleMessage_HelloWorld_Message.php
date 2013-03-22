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
 * @subpackage ModExample
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class ExampleMessage_HelloWorld_Message extends LibMessageStack
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Subjekt der Nachricht
   * @var string
   */
  public $subject = 'Hello World';

  /**
   * Subjekt der Nachricht
   * @var string
   */
  public $htmlMaster = 'index';

  /**
   * Subjekt der Nachricht
   * @var string
   */
  public $htmlTemplate = 'example/message/hello_world';

  /**
   * Die Kannäle über welcher die Nachricht verschickt werden soll
   * @var array
   */
  public $channels = array('mail');

}//end class ExampleMessage_HelloWorld_Message

