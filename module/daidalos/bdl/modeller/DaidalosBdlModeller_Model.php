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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlModeller_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $key = null;

  /**
   * Der Name des aktuell geöffneten bdl files
   * @var string
   */
  public $bdlFileName = null;

  /**
   * Der DOM Node des aktuell geöffneten bdl files
   * @var BdlFile
   */
  public $bdlFile = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string
   * @return array
   */
  public function setKey( $key )
  {

    $this->key = $key;

  }//end public function setKey */

  /**
   * @return array
   */
  public function getProjects()
  {
    $conf = $this->getConf();

    $repoPath = $conf->getResource( 'bdl', 'project_repo' );

    $repoIterator = new LibFilesystemFolder( $repoPath );

    $reposPaths = $repoIterator->getPlainFolders();

    $repos = array();

    foreach ($reposPaths as $repo) {
      $repos[$repo] = new BdlProject( $repoPath.'/'.$repo.'/Project.bdl' );
    }

    return $repos;

  }//end public function getProjects */

  /**
   * @return array
   */
  public function getRepos()
  {

    $conf = $this->getConf();

    return $conf->getResource( 'bdl', 'core_repos' );

  }//end public function getRepos */

  /**
   * @return array
   */
  public function getModulePath()
  {

    $conf = $this->getConf();

    $repos = $conf->getResource( 'bdl', 'core_repos' );

    return $repos[$this->key]['path'];

  }//end public function getSubModulePath */

  /**
   * @param string
   * @return array
   */
  public function loadFile( $fileName )
  {

    if( $this->bdlFile )

      return null;

    $conf     = $this->getConf();
    $modPath  = $this->getModulePath();

    $this->bdlFile = new BdlFile( $modPath.$fileName );
    $this->bdlFileName = $fileName;

  }//end public function loadFile */

  /**
   * @param string
   * @return array
   */
  public function guessFileType( $fileName )
  {

    if( $this->bdlFile )

      return $this->bdlFile->guessType();

    $conf     = $this->getConf();
    $modPath  = $this->getModulePath();

    $this->bdlFile = new BdlFile( $modPath.$fileName );
    $this->bdlFileName = $fileName;

    return $this->bdlFile->guessType();

  }//end public function guessFileType */

  /**
   * @param string
   * @return array
   */
  public function save(  )
  {

    $this->bdlFile->save();

  }//end public function save */

}//end class DaidalosBdlModeller_Model
