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
class LibTestEngine
{

  /**
   *
   * @var LibTestEngine
   */
  private static $instance = null;

  /**
   * folderpath to the testfolder
   *
   * @var string
   */
  protected $testFolder = null;

  /**
   *
   * @var LibGenfTestClassReport
   */
  protected $report = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param LibResponse
  */
  public function __construct($response = null  )
  {

    $this->report = new LibTestClassReport($response );

  }//end  protected function __construct */

  /**
   * @return LibTestClassReport
   */
  public function getReport()
  {
    return $this->report;
  }//end public function getReport */

  /**
   * Enter description here...
   * @param string $path
   * @param string $fileName
   */
  public function runSingleTestFile($path, $className )
  {
    include $path;
    $this->testClass($className);

  }//end public function runSingleTestFile */

  /**
   * Enter description here...
   *
   * @param string $fileName
   */
  public function runTestsByFilelist($files )
  {

    foreach($files as $path => $className )
    {
      include $path;
      $this->testClass($className);
    }

  }//end public function runTestFile */


 /**
  * @param string $className
  */
  public function testClass($className  )
  {

    try
    {

      $reflector = new LibReflectorClass($className );

      // Nur Testklassen die ITest und implementieren und nicht Abstract sind
      // können geladen werden
      if ($reflector->implementsInterface('ITest') && !$reflector->isAbstract() )
      {
        $testObj = new $className($this->report );
        $testObj->run();
      } else {
        Error::addError( 'TestClass '.$className.' not exists!' );
        Message::addError( 'Tried to Call Invalid Test: '.$className );
      }

    }
    catch( ClassNotFound_Exception $e )
    {
      Error::addError
      (
      'Class Not Exists: '.$e->getMessage()
      );
      return null;
    }
    catch( Webfrap_Exception $e )
    {
      return null;
    }
    catch( Exception $e )
    {
      return null;
    }

  }//end public function runTestClass */

  /**
   * Enter description here...
   *
   * @param string $foldername
   * @param TArray $report
   */
  public function testFolder($foldername, $report  )
  {

    $folder = new LibFilesystemFolder($foldername );

    foreach($folder->getFilesByEnding('.php',true) as $file )
    {
      $className = $file->getPlainFilename();
      $this->testClass($className, $report  );
    }

    foreach($folder->getFolders() as $folder )
      $this->testFolder($folder->getFoldername(), $report );

  }//end public function testFolder */


} //end abstract class LibTestEngine

