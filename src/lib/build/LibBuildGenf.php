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
class LibBuildGenf extends LibBuildAction
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

    $action = $this->args[0];

    if (!method_exists($this , $action)) {
      Error::addError('Requested invalid Genf Action: '.$action.'sn . Please Check you Buildconfiguration.');

      return false;
    }

    return $repoObj->$action();

  }//end public function execute */

} // end class LibGenfBuild

