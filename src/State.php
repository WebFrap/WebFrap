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
class State extends TArray
{
/*//////////////////////////////////////////////////////////////////////////////
// Webfrap State
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Status ok
   * @var int
   */
  const OK = 0;
  
  /**
   * Status warn
   * @var int
   */
  const WARN = 1;
  
  /**
   * Status error
   * @var int
   */
  const ERROR = 2;
  
  /**
   * Per definition ist erst mal alles ok
   * @var int
   */
  public $status = State::OK;
  
  /**
   * @var array
   */
  public $errors = array();
  
  /**
   * @var array
   */
  public $messages = array();
  
  /**
   * @var array
   */
  public $warnings = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param boolean
   */
  public function isOk()
  {
    return ( $this->status == State::OK );
  }//end public function isOk */
  
  /**
   * Prüfen ob Fehler hinterlegt wurden
   * @param boolean
   */
  public function hasErrors()
  {
    return $this->errors ?true:false;
    
  }//end public function hasErrors */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   */
  public function addMessage( $message )
  {

    $this->messages[] = $message;
    
  }//end public function addMessage */
  
  /**
   * @param string $warning
   * @param string $warnKey eine flag setzen gegen die gecheckt werden kann
   *   ob an einer bestimmten stelle eine warnung getriggert wurde
   */
  public function addWarning( $warning, $warnKey = null )
  {
    
    if (!$this->status )
      $this->status = State::WARN;
    
    $this->warnings[] = $warning;
    
    if (!is_null($warnKey)  )
      $this->pool[$warnKey] = State::WARN;
    
  }//end public function addWarning */

  /**
   * @param string $error
   * @param string $errorKey eine flag setzen gegen die gecheckt werden kann
   *   ob an einer bestimmten stelle fehler aufgetreten sind
   */
  public function addError( $error, $errorKey = null )
  {
    $this->status = State::ERROR;
    
    $this->errors[] = $error;
    
    if (!is_null($errorKey)  )
      $this->pool[$errorKey] = State::ERROR;
    
  }//end public function addError */
  
  /**
   * @param string $stateKey
   * @param string $state der Status
   */
  public function setKeyState( $stateKey, $state )
  {
    
    $this->pool[$stateKey] = $state;
      
  }//end public function setKeyState */


} // end class State

