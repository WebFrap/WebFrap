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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class TestRunner_Model
  extends Model
{


  /**
   * @param string $folderName
   * @return array
   */
  public function getClassFiles( $folderName )
  {

    $testMods = Webfrap::getIncludePaths('test');

    $tmp = array();

    foreach( $testMods as $mod )
    {

      $folder = PATH_ROOT.$mod.'/'.$folderName;

      if( !file_exists( $folder ) )
        continue;

      $folder     = new LibFilesystemFolder( $folder );
      $childFiles = $folder->getFilesByEnding( '_Test.php', false, true );

      $tmp = array_merge( $tmp, $childFiles );

    }

    $files = array();

    foreach( $tmp as $path )
    {
      $files[$path] = substr(basename($path),0, -4);
    }

    return $files;


  }//end public function getClassFiles */

  /**
   * @param string $folderName
   * @return LibTestClassReport
   */
  public function runFolderTest( $folderName )
  {

    $files = $this->getClassFiles($folderName);

    $testRunner = new LibTestEngine( $this->response );
    return $testRunner->runTestsByFilelist( $files );

  }//end public function runFolderTest */

  /**
   * @param string $folderName
   * @return LibTestEngine
   */
  public function createTestEngine(  )
  {

    $testRunner = new LibTestEngine( $this->response );
    return $testRunner;

  }//end public function runFolderTest */


}// end class TestRunner_Model

