<?php
/*******************************************************************************
*
* @author      : Malte Schirmacher <malte.schirmacher@webfrap.net>
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
class LibConnector_Message_Adapter
{  
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Die Serveraddresse
   * @var string
   */
  public $server = null;
  
  /**
   * Der Serverport
   * @var string
   */
  public $port   = null;
  
  /**
   * Benutzername
   * @var string
   */
  public $userName = null;
  
  /**
   * Passwort
   * @var string
   */
  public $password = null;
  
  /**
   * @var boolean
   */
  public $useSsl = true;
  
  /**
   * @var boolean
   */
  public $useTls = true;
  
  /**
   * @var boolean
   */
  public $allowPrivateSigned = true;
  
  /**
   * Anzahl der Verbindungsversuche
   * @var int
   */
  public $tries = 1;
  
////////////////////////////////////////////////////////////////////////////////
// protected attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Resource
   * @var string
   */
  protected  $resource = null;
  
  /**
   * Error Object zum sammeln von Fehlermeldungen
   * @var Error
   */
  protected $error = null;
  
////////////////////////////////////////////////////////////////////////////////
// getter + setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return the $server
   */
  public function getServer() 
  {
    return $this->server;
  }

  /**
   * @return the $port
   */
  public function getPort() 
  {
    return $this->port;
  }

  /**
   * @return the $userName
   */
  public function getUserName() 
  {
    return $this->userName;
  }

  /**
   * @return the $password
   */
  public function getPassword() 
  {
    return $this->password;
  }

  /**
   * @param string $server
   */
  public function setServer($server) 
  {
    $this->server = $server;
  }

  /**
   * @param string $port
   */
  public function setPort($port) 
  {
    $this->port = $port;
  }

  /**
   * @param string $userName
   */
  public function setUserName($userName) 
  {
    $this->userName = $userName;
  }

  /**
   * @param string $password
   */
  public function setPassword($password) 
  {
    $this->password = $password;
  }
  
  /**
   * @return the $useSsl
   */
  public function getUseSsl() 
  {
    return $this->useSsl;
  }

  /**
   * @return the $allowPrivateSigned
   */
  public function getAllowPrivateSigned() 
  {
    return $this->allowPrivateSigned;
  }

  /**
   * @param boolean $useSsl
   */
  public function setUseSsl($useSsl) 
  {
    $this->useSsl = $useSsl;
  }

  /**
   * @param boolean $allowPrivateSigned
   */
  public function setAllowPrivateSigned($allowPrivateSigned) 
  {
    $this->allowPrivateSigned = $allowPrivateSigned;
  }

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Zusammenbauen eines connection strings
   * 
   * @param string the address
   */
  public function buildConnectionAddress() 
  {
    return null;
  }//end public function buildConnectionAddress */
  
  
////////////////////////////////////////////////////////////////////////////////
// Error handling
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $message
   */
  public function addError( $message )
  {
    
    if( !$this->error )
      $this->error = new ErrorContainer();
      
    $this->error->addMessage();
    
  }//end public function addError */
  
  /**
   * @return boolean
   */
  public function hasError()
  {
    
    return isset( $this->error );
    
  }//end public function hasError */
  
  /**
   * @return boolean
   */
  public function getError()
  {
    return $this->error;
  }//end public function getError */
  
}//end class LibConnector_Message_Adapter


