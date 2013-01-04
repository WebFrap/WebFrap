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
class LibMessagePool
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

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

////////////////////////////////////////////////////////////////////////////////
// Wichtige Resoucen
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var LibDbConnection
   */
  protected $db   = null;
  
  /**
   * @var Base
   */
  protected $env   = null;
  
  /**
   * Klasse über welche die relevanten Adressdaten zu versenden der Nachricht
   * gezogen werden
   * 
   * @var LibMessageAddressloader
   */
  protected $addressModel   = null;
  
////////////////////////////////////////////////////////////////////////////////
// constructor
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param Base $env
   */
  public function __construct( $env = null )
  {

    if( $env )
      $this->env = $env;
    else
      $this->env = Webfrap::$env;
    
  }//end public function __construct */
  
  
////////////////////////////////////////////////////////////////////////////////
// getter + setter für die Resourcen
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return LibDbConnection $db
   */
  public function getDb()
  {
    
    if( !$this->db )
      $this->db = $this->env->getDb();
            
    return $this->db;
    
  }//end public function getDb */
  
  /**
   * @param LibDbConnection $db
   */
  public function setDb( $db )
  {
    $this->db = $db;
  }//end public function setDb */
  

  
////////////////////////////////////////////////////////////////////////////////
// Messaging System
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param string $error
   * @param string $stream
   */
  public function addError( $error, $stream = 'stdout' )
  {

    if( !isset( $this->errors[$stream] ) )
      $this->errors[$stream] = array();
      
    if( DEBUG )
    {
      if( is_array($error) )
        Debug::console( "ERROR: ".implode(NL, $error) );
      else
        Debug::console( "ERROR: ".$error );
    }

    if( is_array( $error ) )
    {
      $this->errors[$stream] = array_merge( $this->errors[$stream], $error );
    }
    else
    {
      $this->errors[$stream][] = $error;
    }

  }//end public function addError */

  /**
   * @param string $stream
   */
  public function resetErrors( $stream = 'stdout' )
  {
    unset($this->errors[$stream]);
  }//end public function resetErrors */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasErrors( $stream = 'stdout' )
  {
    return (isset($this->errors[$stream])) ?true:false;
  }//end public function resetErrors */

  /**
   * @param $stream
   * @return array
   */
  public function getErrors($stream = 'stdout')
  {
    return isset($this->errors[$stream]) ?$this->errors[$stream]:array();
  }//end public function getErrors */

  /**
   * @param $stream
   * @return array
   */
  public function cleanErrors($stream = 'stdout')
  {

    if( isset( $this->errors[$stream] ) )
      unset( $this->errors[$stream] );

  }//end public function cleanErrors */

  /**
   * @param string $warning
   * @param string $stream
   */
  public function addWarning( $warning  , $stream = 'stdout' )
  {
    if( !isset( $this->warnings[$stream] ) )
      $this->warnings[$stream] = array();

    if(is_array( $warning ))
    {
      $this->warnings[$stream] = array_merge( $this->warnings[$stream], $warning );
    }
    else
    {
      $this->warnings[$stream][] = $warning;
    }

  }//end public function addWarning */

  /**
   * @param string $stream
   */
  public function resetWarnings( $stream = 'stdout' )
  {
    unset($this->warnings[$stream]);
  }//end public function resetWarnings */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasWarnings( $stream = 'stdout' )
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
  public function addMessage( $message, $stream = 'stdout' )
  {
    
    if(!isset($this->messages[$stream]))
      $this->messages[$stream] = array();

    if(is_array( $message ))
    {
      $this->messages[$stream] = array_merge( $this->messages[$stream], $message );
    }
    else
    {
      $this->messages[$stream][] = $message;
    }
    
  }//end public function addMessage */

  /**
   * @param string $stream
   */
  public function resetMessages( $stream = 'stdout' )
  {
    
    unset($this->messages[$stream]);
    
  }//end public function resetMessages */

  /**
   * 
   * @param string $stream
   * @return boolean
   */
  public function hasMessages( $stream = 'stdout' )
  {
    
    return isset($this->messages[$stream]) ?true:false;
    
  }//end public function hasMessages */

  /**
   * alle Systemnachrichten aus einem Chanel holen
   * @param string $stream
   * @return array
   */
  public function getMessages( $stream = 'stdout' )
  {
    
    return isset($this->messages[$stream]) ?$this->messages[$stream]:array();
    
  }//end public function getMessages */
  

////////////////////////////////////////////////////////////////////////////////
// State
////////////////////////////////////////////////////////////////////////////////

  /**
   * Ein State Object zum verarbeiten übergeben
   * Es werden Messages, Warnings und Errors soweit vorhanden ausgegelesen
   * 
   * @param State $state
   */
  public function handleState( $state )
  {
    
    if( $state->errors )
      $this->addError( $state->errors );
      
    if( $state->warnings )
      $this->addWarning( $state->warnings );
      
    if( $state->messages )
      $this->addMessage( $state->messages );
    
  }//end public function handleState */

////////////////////////////////////////////////////////////////////////////////
// Protocol
////////////////////////////////////////////////////////////////////////////////
  
  /**
   *
   * @param string $message
   * @param string $context
   * @param Entity $entity
   * @param string $mask
   */
  public function protocol( $message, $context, $entity = null, $mask = null  )
  {

    $orm = $this->getDb()->getOrm();

    if( $entity )
    {
      if( is_array($entity) )
      {
        $resourceId = $orm->getResourceId($entity[0]);
        $entityId   = $entity[1];
      }
      else if( is_string($entity) )
      {
        $resourceId = $orm->getResourceId($entity);
        $entityId   = null;
      }
      else
      {
        $resourceId = $orm->getResourceId($entity);
        $entityId   = $entity->getId();
      }

    }
    else
    {
      $resourceId = null;
      $entityId   = null;
    }

    $protocol = new WbfsysProtocolMessage_Entity();
    $protocol->message = $message;
    $protocol->context = $context;
    $protocol->vid     = $entityId;
    $protocol->id_vid_entity  = $resourceId;
    $protocol->mask = $mask;

    $orm->send( $protocol );

  }//end public function protocol */
  
////////////////////////////////////////////////////////////////////////////////
// Messages
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param LibMessageEnvelop $message
   * 
   * @throws LibMessage_Exception
   * 
   */
  public function send( $message )
  {

    // alle relevanten empfänger laden
    $addressModel  = $this->getAddressModel();
    
    // die addresierten Channel laden
    $channels      = $this->getMessageChannels( $message );
    
    foreach( $channels as $channel )
    {
      $receivers     = $addressModel->getReceivers( $message->getReceivers(), $channel->type  );
      $channel->send( $message, $receivers );
    }

  }//end public function send */
  
  
  /**
   * @return LibMessageAddressloader
   */
  public function getAddressModel( )
  {
    
    if( !$this->addressModel )
      $this->addressModel = new LibMessageAddressloader();
      
    return $this->addressModel;
    
  }//end public function getAddressModel */
  
  /**
   * @param array $groups
   * @param string $type
   * @param string $area
   * @param Entity $entity
   * 
   * @return array<LibMessageReceiver>
   */
  public function getGroupUsers( $groups, $type, $area = null, $entity = null )
  {
    
    if( !$this->addressModel )
      $this->addressModel = new LibMessageAddressloader();
      
    $receiver = new LibMessage_Receiver_Group
    ( 
      $groups,
      $area,
      $entity
    );
      
    return $this->addressModel->getGroupUsers( $receiver, $type );
    
  }//end public function getGroupUsers */
  
  /**
   * @param array $groups
   * @param string $type
   * @param string $area
   * @param Entity $entity
   * 
   * @return array<LibMessageReceiver>
   */
  public function getDsetUsers( $entity, $type, $area = null )
  {
    
    if( !$this->addressModel )
      $this->addressModel = new LibMessageAddressloader();
      
    $receiver = new LibMessage_Receiver_Group
    ( 
      null,
      $area,
      $entity
    );
      
    return $this->addressModel->getGroupUsers( $receiver, $type );
    
  }//end public function getDsetUsers */
  
  
  /**
   * @param array<LibMessageReceiver> $receivers
   * @param string $type
   * 
   * @return array<LibMessageReceiver>
   */
  public function getReceivers( $receivers, $type = Message::CHANNEL_MAIL )
  {
    
    if( !$this->addressModel )
      $this->addressModel = new LibMessageAddressloader();
      
    return $this->addressModel->getReceivers( $receivers , $type  );
    
  }//end public function getReceivers */
  
  /**
   * 
   * Alle Nachrichtenkanäle laden über welche die Nachricht verschickt werden soll
   * 
   * @param LibMessageEnvelop $message
   * 
   * @return array<LibMessageChannel>
   * 
   * @throws LibMessage_Exception wenn einer der angefragten Message Channel nicht existiert
   */
  public function getMessageChannels( $message )
  {
    
    $channelObjects = array();
    
    $channelKeys = $message->getChannels();

    foreach ( $channelKeys as $key )
    {
      $chan = Webfrap::newObject( "LibMessageChannel".ucfirst($key) );
      
      if( $chan )
      {
        $channelObjects[$key] = $chan;
      }
      else 
      {
        throw new LibMessage_Exception( "The requested Message Channel ".ucfirst($key).' not exists!' );
      }
      
    }
    
    return $channelObjects;
    
  }//end public function getMessageChannels */
  
}// end LibMessagePool

