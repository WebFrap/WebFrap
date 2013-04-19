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
class LibTestClassReport
{

  /**
   * @var array
   */
  public $errors = array();

  /**
   * @var array
   */
  public $tests = array();

  /**
   * @var unknown_type
   */
  protected $response = null;

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   * @param unknown_type $response
   */
  public function __construct($response = null)
  {
    $this->response = $response;
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $className
   */
  public function addClass($className)
  {
    $this->errors[$className] = array();
    $this->tests[$className] = array();

  }//end public function addClass */

  /**
   * @param string $className
   * @param string $methodName
   */
  public function addMethod($className, $methodName)
  {
    $this->errors[$className][$methodName]  = array();
    $this->tests[$className][$methodName]   = 0;

  }//end public function addMethod */

  /**
   * @param string $className
   * @param string $methodName
   * @param string $testName
   */
  public function addTest($className, $methodName)
  {
    ++$this->tests[$className][$methodName];
  }//end public function addTest */

  /**
   * @param string $className
   * @param string $methodName
   * @param int $line
   * @param string $test
   * @param string $message
   */
  public function addError($className, $methodName, $line, $message)
  {
    $this->errors[$className][$methodName][] = array($line, $message);

    $this->response->writeLn("$className::$methodName, $line | $message");

  }//end public function addError */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $testClass
   * @return int
   */
  public function numClassMethodes($testClass)
  {

    if (!isset($this->tests[$testClass]))
      return 0;

    return count($this->tests[$testClass]);

  }//end public function numTestMethodes */

  /**
   * Enter description here...
   *
   * @param string $testClass
   * @return int
   */
  public function numClassTests($testClass)
  {

    if (!isset($this->tests[$testClass]))
      return 0;

    return array_sum($this->tests[$testClass]);

  }//end public function numClassTests */

  /**
   * Enter description here...
   *
   * @param string $testClass
   * @return string
   */
  public function numClassTestsFailed($testClass)
  {

    if (!isset($this->errors[$testClass]))
      return 0;

    $count = 0;

    foreach ($this->errors[$testClass] as $methodes)
        $count += count($methodes);

    return $count;

  }//end public function getNumberClassTestsFailed

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function getNumberClass()
  {
    return count($this->test);
  }//end public function getNumberClass

  /**
   * Enter description here...
   *
   */
  public function numTotalTestRuns()
  {
    $count = 0;

    foreach ($this->tests as $tests)
      $count += array_sum($tests);

    return $count;

  }//end public function getNumberTestRuns

  /**
   *
   * @return unknown_type
   */
  public function numTotalTestRunsFailed()
  {
    $count = 0;

    foreach ($this->errors as $tests)
      foreach ($tests as $methodes)
        $count += count($methodes);

    return $count;

  }//end public function getNumberTestRunsFailed

} //end class LibTestReport

