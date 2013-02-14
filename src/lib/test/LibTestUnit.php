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
 * @package WebFrapUnit
 * @subpackage tech_core
 */
abstract class LibTestUnit extends Base
  implements ITest
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Objekt zum sammeln der Reports
   * @var LibTestClassReport
   */
  protected $report = null;

  /**
   * Der aktuelle Klassenname
   * @var string
   */
  protected $className = null;

  /**
   * Der Name der Methode in welcher der Test sich gerade befindet
   * @var string
   */
  protected $methodName = null;

  /**
   * Nicht alle tests können auf jeder Platform ausgeführt werden
   * 
   * Der check ob mit der aktuellen Konfiguration ein test ausgefürht werden 
   * kann wird in setUp durchgeführt
   * 
   * Fehlt zb die Verbindung zu einem Service, oder ist der Code Plattformspezifisch,
   * z.B Windows kann so geskippt werden
   * 
   * @var int
   */
  protected $skipTest = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibTestClassReport $report
   */
  public function __construct($report)
  {
    
    $this->report = $report;
    $this->response = Response::getActive();
    
  }//end public function __construct($report)

/*//////////////////////////////////////////////////////////////////////////////
// Controller
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * 
   */
  public function console($content )
  {
    $this->response->console($content );
  }//end public function console */


  /***
   */
  public function run()
  {

    //$this->className  = get_class ($this );
    //$methodes = get_class_methods ($this->className );

    $reflector = new LibReflectorClass($this );

    $this->className  = $reflector->getName();

    $this->report->addClass($this->className);

    $methodes         = $reflector->getAllMethodNames();

    try
    {
      $this->setUp();
      
      if ($this->skipTest )
      {
        ///TODO Reporting Logik wieder dazu bauen
        return;
      }
      
      foreach($methodes as $method)
      {
        if ( strtolower(substr($method, 0, 4 )) == 'test')
        {
          try
          {
            $this->methodName = $method;
            $this->report->addMethod($this->className, $this->methodName);
            $this->$method();
          }
          catch( LibTestDropMethodException $exc)
          {
            $this->report->addError($this->className, $this->methodName, 0, get_class($exc) .' : '.$exc->getMessage());
          }
        }
      }
      
      $this->tearDown();
      
    }
    catch( LibTestException $exc)
    {
      //$this->report->addError($this->className, $this->methodName, 0, get_class($exc) .' : '.$exc->getMessage());
    }
    catch( Exception $exc)
    {
      //$this->report->addError($this->className, $this->methodName, 0, get_class($exc) .' : '.$exc->getMessage());
    }

  }// end public function run

  /**
   * @return void
   */
  public function setUp()
  {

  }//end public function setUp


  /**
   * @return void
   */
  public function tearDown()
  {

  }//end public function tearDown

/*//////////////////////////////////////////////////////////////////////////////
// Tests
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   * @param boolean $boolean
   */
  protected function assertTrue($message , $boolean)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (!$boolean)
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);
      return false;
    }

    return true;

  }//end protected function assertTrue

  /**
   * @param string $message
   * @param boolean $boolean
   */
  protected function assertFalse($message , $boolean)
  {

    $this->report->addTest($this->className, $this->methodName );

    if ($boolean)
    {

      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, "Reason: ".$message);

      return false;
    }

    return true;

  }//end protected function assertFalse

  /**
   * @param string $message
   * @param object $dat1
   * @param object $dat2
   */
  protected function assertEquals($message , $dat1 , $dat2)
  {

    $this->report->addTest($this->className, $this->methodName );

    if ($dat1 != $dat2)
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }

    return true;

  }//end protected function assertEquals

  /**
   * @param string $message
   * @param object $dat1
   * @param object $dat2
   */
  protected function assertNotEquals($message , $dat1 , $dat2){

    $this->report->addTest($this->className, $this->methodName );

    if ($dat1 == $dat2)
    {

      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }

    return true;

  }//end protected function assertNotEquals

  /**
   * @param string $message
   * @param object $dat1
   */
  protected function assertNull($message , $dat1)
  {

    $this->report->addTest($this->className, $this->methodName );
    if (!is_null($dat1))
    {

      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertNull
  
  /**
   * @param string $message
   * @param object $dat1
   */
  protected function assertEmpty($message , $dat1 )
  {

    $this->report->addTest($this->className, $this->methodName );

    if (!empty($dat1 ) )
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    
    return true;

  }//end protected function assertEmpty

  /**
   * @param string $message
   * @param object $dat1
   */
  protected function assertNotNull($message , $dat1)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (is_null($dat1))
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertNotNull

  /**
   * @param string $message
   * @param object $dat1
   * @param object $dat2
   */
  protected function assertSame($message , $dat1 , $dat2)
  {

    $this->report->addTest($this->className, $this->methodName );

    if ($dat1 !== $dat2)
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertSame

  /**
   * @param string $message
   * @param object $dat1
   * @param object $dat2
   */
  protected function assertNotSame($message , $dat1 , $dat2)
  {

    $this->report->addTest($this->className, $this->methodName );
    if ($dat1 === $dat2)
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertNotSame

  /**
   * @param string $message
   * @param object $dat1
   * @param object $dat2
   */
  protected function assertSameClass($message , $dat1 , $dat2)
  {

    $this->report->addTest($this->className, $this->methodName );
    if (  get_class($dat1) != get_class($dat2))
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertSameClass

  /**
   * @param string $message
   * @param object $dat1
   * @param object $dat2
   */
  protected function assertNotSameClass($message , $dat1 , $dat2)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (  get_class($dat1) == get_class($dat2))
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertNotSameClass

  /**
   * @param string $message
   */
  protected function assertNoReach($message)
  {


    $this->report->addTest($this->className, $this->methodName );

    $trace = debug_backtrace();
    $testName = $trace[0]['function'];
    $line = $trace[0]['line'];

    $this->report->addError($this->className, $this->methodName, $line, $message);

    return false;

  }//end protected function assertNoReach

  /**
   * Einen Fehler zum Report hinzufügen
   * @param string $message
   */
  protected function failed($message )
  {

    $this->report->addTest($this->className, $this->methodName );

    $trace = debug_backtrace();
    $testName = $trace[0]['function'];
    $line = $trace[0]['line'];

    $this->report->addError($this->className, $this->methodName, $line, $message);

    return false;

  }//end protected function failed

  /**
   * @return void
   */
  protected function success()
  {
    
    $this->report->addTest($this->className, $this->methodName );
    return true;
    
  }//end protected function success

  /**
   * @param string $message
   * @param array $array
   */
  protected function assertArray($message , $array)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (  !is_array($array))
    {

      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];
      $this->report->addError($this->className, $this->methodName, $line, $message);
      return false;
    }
    return true;

  }//end protected function assertArray

  /**
   * @param string $message
   * @param string $string
   */
  protected function assertString($message , $string)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (!is_string($string))
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];
      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertString

  /**
   * @param string $message
   * @param int    $zahl
   */
  protected function assertInt($message , $zahl)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (!is_int($zahl))
    {

      $trace = debug_backtrace();

      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];
      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertInt

  /**
   * @param string $message
   * @param int    $zahl
   */
  protected function assertNumeric($message , $zahl)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (  !is_numeric($zahl))
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];
      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertNumeric($message , $zahl)

  /**
   * @param string $message
   * @param string $instance
   * @param object $object
   */
  protected function assertInstance($message , $instance , $object)
  {

    $this->report->addTest($this->className, $this->methodName );

    if (  ! $object instanceof $instance)
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];
      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertInstance

/*//////////////////////////////////////////////////////////////////////////////
// Architektur Assertions
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param string $message
   * @param array $roles
   * @param array $checkRoles
   */
  protected function assertRolesEqual($message , $roles , $checkRoles )
  {

    $this->report->addTest($this->className, $this->methodName );

    if ( array_values($roles) !== $checkRoles )
    {
      $trace = debug_backtrace();
      $testName = $trace[0]['function'];
      $line = $trace[0]['line'];

      $this->report->addError($this->className, $this->methodName, $line, $message);

      return false;
    }
    return true;

  }//end protected function assertRolesEqual

} //end abstract class LibTestUnit

