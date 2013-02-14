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
class LibResponseContext
{

  /**
   * @var LibResponseCli
   */
  private $response = null;
  
  /**
   * Anzahl der Notices im Kontext
   * @var int
   */
  public $hasNotice = 0;
  
  /**
   * Anzahl der Warnings im Kontext
   * @var int
   */
  public $hasWarning = 0;
  
  /**
   * Anzahl der Errors im Kontext
   * @var int
   */
  public $hasError = 0;
  
/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/
 
  /**
   * @param LibResponseAdapter $response
   */
  public function __construct($response )
  {
    $this->response = $response;
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// messages
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   */
  public function addMessage($message )
  {
    
    ++$this->hasNotice;
    $this->response->addMessage($message );
    
  }//end public function addMessage */

  /**
   * @param string $warning
   */
  public function addWarning($warning )
  {
    
    ++$this->hasWarning;
    $this->response->addWarning($warning );
    
  }//end public function addWarning */
  

  /**
   * @param string $error
   *
   */
  public function addError($error )
  {
    
    ++$this->hasError;
    $this->response->addError($error );

  }//end public function addError */
  
  /**
   * Nur eine Warning triggern wenn value null ist
   * @param string $warning
   * @param var $value
   */
  public function addWarningIfNull($warning, $value )
  {
    
    if (is_null($value ) )
    {
      ++$this->hasWarning;
      $this->response->addWarning($warning );
    }
    
  }//end public function addWarningIfNull */

  
  /**
   * Nur eine Error triggern wenn value null ist
   * @param string $warning
   * @param var $value
   */
  public function addErrorIfNull($error, $value )
  {
    
    if (is_null($value ) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function addErrorIfNull */
  
  /**
   * Einen Error triggern wenn value null ist
   * @param string $warning
   * @param var $value
   */
  public function assertNull($error, $value )
  {
    
    if (!is_null($value ) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertNull */
  
  /**
   * Nur einen Error triggern wenn value nicht null ist
   * @param string $warning
   * @param var $value
   */
  public function assertNotNull($error, $value )
  {
    
    if (is_null($value ) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertNotNull */
  
  /**
   * Einen Error triggern wenn andere characters als zahlen vorhanden sind
   * 
   * @todo negative int beachten
   * 
   * @param string $warning
   * @param var $value
   */
  public function assertInt($error, $value, $signed = false )
  {

    if (!ctype_digit($value ) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertInt */
  
  /**
   * Einen Error triggern wenn value null ist
   * @param string $warning
   * @param var $value
   */
  public function assertEmpty($error, $value )
  {
    
    if ( '' != trim($value ) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertEmpty */
  
  /**
   * Nur einen Error triggern wenn value nicht null ist
   * @param string $warning
   * @param var $value
   */
  public function assertNotEmpty($error, $value )
  {
    
    if ( is_array($value ) )
    {
      if ( empty($value ) )
      {
        ++$this->hasError;
        $this->response->addError($error );
      }
    } else {
      if ( '' == trim($value ) )
      {
        ++$this->hasError;
        $this->response->addError($error );
      }
    }
    
  }//end public function assertNotEmpty */
  
  /**
   * Nur einen Error triggern wenn value größer als refvalue ist
   * @param string $error
   * @param var $value
   * @param var $refValue
   */
  public function assertBigger($error, $value, $refValue )
  {
    
    if (!is_null($value ) &&  ((int)$value < (int)$refValue) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertBigger */
  
  /**
   * Nur einen Error triggern wenn value größer als refvalue ist
   * @param string $error
   * @param var $value
   * @param var $refValue
   */
  public function assertSmaller($error, $value, $refValue )
  {
    
    if (!is_null($value ) &&  ((int)$value > (int)$refValue) )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertSmaller */
  
  /**
   * Einen Error triggern wenn beide Werte nicht gleich sind
   * @param string $error
   * @param var $value
   * @param var $refValue
   */
  public function assertEquals($error, $value, $refValue )
  {
    
    if ($value !== $refValue )
    {
      ++$this->hasError;
      $this->response->addError($error );
    }
    
  }//end public function assertEquals */

}// end LibResponseResponse

