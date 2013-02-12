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
abstract class LibTestGui
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var int
   */
  public static $testId     = 0;

  /**
   * @var int
   */
  public static $anzTests   = 0;

  /**
   * @var int
   */
  public static $failedTests = 0;

  /**
   * @var int
   */
  public static $anzClass   = 0;

  /**
   * @var array
   */
  protected $failedMethod   = array();

  /**
   * the fake view object
   *
   * @var LibTemplatePhp
   */
  protected $view = null;

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $outputPool = array();

////////////////////////////////////////////////////////////////////////////////
// Magic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct( )
  {

      ++ self::$anzClass;

    $this->view = new LibTemplateHtml();

  }//end public function __construct

////////////////////////////////////////////////////////////////////////////////
// getter and Setter Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   */
  public function getOutput()
  {
    return $this->outputPool;
  }//end public function getOutput()

////////////////////////////////////////////////////////////////////////////////
// Controller
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function run( $view )
  {

    $reflector = new LibReflectorClass($this);

    $this->className = $reflector->getName();
    $methodes = $reflector->getAllMethodNames();

    $this->setUp();
    foreach ($methodes as $method) {
      if ( strtolower(substr( $method, 0, 4 )) == 'test' ) {
        try {
          $this->view->cleanParser(true);
          $this->$method( );
          $this->failedMethod[$method] = false;
          $this->outputPool['method: '.$method] = $this->view->build();
        } catch ( LibTestException $exc ) {
          $this->failedMethod[$method] = $exc->getMessage();
        }
      }
    }
    $this->tearDown();

    return $this->failedMethod;

  }// end public function run()

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

////////////////////////////////////////////////////////////////////////////////
// Tests
////////////////////////////////////////////////////////////////////////////////

  /**
   * the only test method
   * @param string $message
   */
  protected function failed( $message  )
  {

    ++self::$anzTests;
    ++self::$failedTests;
    throw new LibTestException( $message );

  }//end protected function failed

  /**
   * @return void
   */
  protected function success( )
  {

    ++self::$anzTests;
  }//end protected function success

} //end abstract class LibTestGui
