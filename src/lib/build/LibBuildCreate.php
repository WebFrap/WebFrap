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
class LibBuildCreate
  extends LibBuildAction
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param unknown_type $node
   * @return unknown_type
   */
  public function execute(  )
  {

    $type         = $this->args[0];
    $action       = $this->args[1];

    /*
      $repoUrl      = $node[2];
      $checkoutPath = $node[3];
      $repoUser     = $node[4];
      $repoPwd      = $node[5];
    */


    $className = 'LibBuildCreate'.ucfirst($type);

    if(!WebFrap::classLoadable($className))
    {
      Error::addError('Requested invalid Create Type: '.$type.'. Please Check you Buildconfiguration.' );
      return false;
    }

    $repoObj = new $className( $this->args );
    return $repoObj->execute();

  }//end public function execute */


} // end class LibBuildCreate

