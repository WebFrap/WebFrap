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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibBuildRepo extends LibBuildAction
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param unknown_type $node
   * @return unknown_type
   */
  public function execute()
  {

    // 'mercurial' ,
    // 'checkout' ,
    // $repoUrl,
    // $repoTmpUrl,
    // $repoUser,
    // $repoPwd

    $type = $this->args[0];
    $action = $this->args[1];

    /*
      $repoUrl = $node[2];
      $checkoutPath = $node[3];
      $repoUser = $node[4];
      $repoPwd = $node[5];
    */

    $className = 'LibBuildRepo'.ucfirst($type);

    if (!Webfrap::classExists($className)) {
      Error::addError('Requested invalid Repo Type: '.$type.'. Please Check you Buildconfiguration.');

      return false;
    }

    $repoObj = new $className();

    if (!method_exists($repoObj , $action)) {
      Error::addError('Requested invalid Repo Action: '.$action.' for Repository: '.$type.'. Please Check you Buildconfiguration.');

      return false;
    }

    return $repoObj->$action();

  }//end public function execute */

} // end class LibGenfBuild

