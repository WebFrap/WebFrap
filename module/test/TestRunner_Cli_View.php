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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class TestRunner_Cli_View
  extends LibTemplateCli
{

  /**
   */
  public function displayHelp(  )
  {

    $out = $this->getResponse();

    $out->writeLn( 'Hi this is the help. Sorry you have to help yourself!' );

  }//end public function displayHelp */

  /**
   * @param string $folder
   */
  public function displayFolder( $folder  )
  {

    $out = $this->getResponse();
    $this->model->setResponse( $out );

    $engine = $this->model->createTestEngine();
    $report = $engine->getReport();

    if ( strpos($folder, ',') ) {
      $folders = explode( ',',  $folder  );
    } else {
      $folders = array( $folder );
    }

    foreach ($folders as $folder) {
      $files = $this->model->getClassFiles( $folder );

      $out->writeLn( 'Run Test in Folder: '.$folder );

      foreach ($files as $path => $className) {

        $out->line();
        $out->writeLn('TEST: '.$className );

        $engine->runSingleTestFile( $path, $className );

        $numTests    = $report->numClassTests($className);
        $failedTests = $report->numClassTestsFailed($className);

        if (!$numTests || !$failedTests) {
          $complete = 100;
        } else {
          $complete = number_format(100 -(( $failedTests / $numTests ) * 100),2);
        }

        $out->writeLn( '  Num. Methodes: '.$report->numClassMethodes($className) );
        $out->writeLn( '  Num. Tests: '.$numTests );
        $out->writeLn( '  Failed. Tests: '.$failedTests );
        $out->writeLn( '  Complete: '.$complete.' %' );

      }
    }

    $out->writeLn( 'Performed Tests: ' );

  }//end public function displayFolder */

  /**
   *
   */
  public function displayFile( $file )
  {

    $out = $this->getResponse();
    $this->model->setResponse( $out );

    $out->writeLn( 'Run Test in File: '.  $file );

    $engine = $this->model->createTestEngine();
    $report = $engine->getReport();

    $className = SParserString::getClassNameFromPath( $file );

    $engine->runSingleTestFile( $file, $className  );

    $numTests = $report->numClassTests($className);
    $failedTests = $report->numClassTestsFailed($className);

    if (!$numTests || !$failedTests) {
      $complete = 100;
    } else {
      $complete = number_format(100 -(( $failedTests / $numTests ) * 100),2);
    }

    $out->line();
    $out->writeLn('TEST: '.$className );
    $out->writeLn('  Num. Methodes: '.$report->numClassMethodes($className) );
    $out->writeLn('  Num. Tests: '.$numTests );
    $out->writeLn('  Failed. Tests: '.$failedTests );
    $out->writeLn('  Complete: '.$complete.' %');

  }//end public function displayFile */

} // end class ImportIspcats_Subwindow
