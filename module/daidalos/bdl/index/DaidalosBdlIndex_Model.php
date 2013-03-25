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
class DaidalosBdlIndex_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das Modeller Model
   * @var DaidalosBdlModeller_Model
   */
  public $modeller = null;

  /**
   * Liste mit der vohandenen indexern
   * @var [DaidalosBdlIndexer]
   */
  public $indexers = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function syncIndex()
  {

    $repos = $this->modeller->getRepos();

    /*
    'buiz' => array
    (
      'branch' => 'modeller',
      'path' => PATH_ROOT.'WebFrap_42_Business/',
      'description' => ''
    ),
     */

    foreach ($repos as $rep) {
      $this->syncRepoIndex($rep['path']);
    }

  }//end public function syncIndex */

  /**
   * @param string $path
   * @return string
   */
  protected function syncRepoIndex($path)
  {

    $files = $this->getSubModuleFiles($path);

    foreach ($files as $file) {
      $this->syncNodeIndex($file);
    }

  }//end protected function syncRepoIndex */

  /**
   * @param string $path
   * @return string
   */
  protected function syncNodeIndex($fileName)
  {

    $bdlFile = new BdlFile($fileName);

    $type = $bdlFile->guessType();

    if (!$type) {
      Debug::console("Failed to guess type for file: ".$fileName);

      return;
    }

    if (isset($this->indexers[$type])) {
      $this->indexers[$type]->syncIndex($bdlFile);
    } else {

      $indexClass = 'BdlIndex_'.SParserString::subToCamelCase($type);
      if (!Webfrap::classLoadable($indexClass)) {
        Debug::console("Tried to sync index for a non supported node type: ".$type);

        return;
      }

      $this->indexers[$type] = new $indexClass($this->getDb());
      $this->indexers[$type]->syncIndex($bdlFile);

    }

  }//end protected function syncNodeIndex */

  /**
   * @return array
   */
  public function getSubModuleFolders($folders)
  {

    $repoIterator = new LibFilesystemFolder($folders);

    return $repoIterator->getPlainFolders(true);

  }//end public function getSubModuleFolders */

  /**
   * @return array
   */
  public function getSubModuleFiles($folders)
  {

    $repoIterator = new LibFilesystemFolder($folders);

    return $repoIterator->getFilesByEnding('.bdl', false, true);

  }//end public function getSubModuleFiles */

}//end class DaidalosBdlModeller_Model

