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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageCli
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  protected $errors   = array();

  /**
   *
   * @var array
   */
  protected $warnings = array();

  /**
   *
   * @var array
   */
  protected $messages = array();


/*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string $error
   * @param string $stream
   */
  public function addError($error, $stream = 'stdout' )
  {

    if (!isset($this->errors[$stream]))
      $this->errors[$stream] = array();

    if (is_array($error ))
    {
      echo 'ERROR: '.implode( NL.'ERROR: ', $error ).NL;
      $this->errors[$stream] = array_merge($this->errors[$stream], $error );
    } else {
      echo 'ERROR: '.$error.NL;
      $this->errors[$stream][] = $error;
    }

  }//end public function addError */

  /**
   * @param string $stream
   */
  public function resetErrors($stream = 'stdout')
  {
    unset($this->errors[$stream]);
  }//end public function resetErrors */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasErrors($stream = 'stdout')
  {
    return isset($this->errors[$stream]) ?true:false;
  }//end public function resetErrors */

  /**
   *
   * @param $stream
   * @return array
   */
  public function getErrors($stream = 'stdout')
  {
    return isset($this->errors[$stream]) ?$this->errors[$stream]:array();
  }//end public function getErrors */

  /**
   * @param string $warning
   * @param string $stream
   */
  public function addWarning($warning  , $stream = 'stdout' )
  {

    if (!isset($this->warnings[$stream]))
      $this->warnings[$stream] = array();

    if (is_array($warning ))
    {
      echo 'WARNING: '.implode( NL.'WARNING: '. $warning ).NL;
      $this->warnings[$stream] = array_merge($this->warnings[$stream], $warning );
    } else {
      echo 'WARNING: '.$warning.NL;
      $this->warnings[$stream][] = $warning;
    }

  }//end public function addWarning */

  /**
   * @param string $stream
   */
  public function resetWarnings($stream = 'stdout' )
  {
    unset($this->warnings[$stream]);
  }//end public function resetWarnings */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasWarnings($stream = 'stdout')
  {
    return isset($this->warnings[$stream]) ?true:false;
  }//end public function hasWarnings */

  /**
   * @param string $stream
   * @return array
   */
  public function getWarnings($stream = 'stdout')
  {
    return isset($this->warnings[$stream]) ?$this->warnings[$stream]:array();
  }//end public function getWarnings */


  /**
   * @param string $message
   * @param string $stream
   */
  public function addMessage($message, $stream = 'stdout' )
  {

    if (!isset($this->messages[$stream]))
      $this->messages[$stream] = array();

    if (is_array($message ))
    {
      echo 'MESSAGE: '.implode( NL.'MESSAGE: ', $message ).NL;
      $this->messages[$stream] = array_merge($this->messages[$stream], $message );
    } else {
      $this->messages[$stream][] = $message;
      echo 'MESSAGE: '.$message.NL;
    }
  }//end public function addMessage */

  /**
   * @param string $stream
   */
  public function resetMessages($stream = 'stdout' )
  {
    unset($this->messages[$stream]);
  }//end public function resetMessages */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasMessages($stream = 'stdout' )
  {
    return isset($this->messages[$stream]) ?true:false;
  }//end public function hasWarnings */

  /**
   * alle Systemnachrichten aus einem Chanel holen
   * @param string $stream
   * @return array
   */
  public function getMessages($stream = 'stdout' )
  {
    return isset($this->messages[$stream]) ?$this->messages[$stream]:array();
  }//end public function getMessages */


  /**
   * @param string $message
   * @param string $context
   * @param Entity $entity
   */
  public function protocol($message, $context, $entity = null )
  {

    $orm = Db::getOrm();

    if ($entity )
    {
      if ( is_array($entity ) )
      {
        $resourceId = $orm->getResourceId($entity[0] );
        $entityId   = $entity[1];
      } else {
        $resourceId = $orm->getResourceId($entity );
        $entityId   = $entity->getId();
      }

    } else {
      $resourceId = null;
      $entityId   = null;
    }

    $protocol = new WbfsysProtocolMessage_Entity();
    $protocol->message = $message;
    $protocol->context = $context;
    $protocol->vid     = $entityId;
    $protocol->id_vid_entity  = $resourceId;

    $orm->send($protocol );

  }

} // end WbfMessagePool

