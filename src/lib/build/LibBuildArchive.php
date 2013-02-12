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
class LibBuildArchive
  extends LibBuildAction
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @return boolean
   */
  public function execute(  )
  {

    $type         = $this->args[0];
    $action       = $this->args[1];


    $className = 'LibBuildArchive'.ucfirst($type);

    if(!WebFrap::classLoadable($className))
    {
      Error::addError('Requested invalid Archive Type: '.$type.'. Please Check you Buildconfiguration.' );
      return false;
    }

    $repoObj = new $className();

    if( !method_exists( $repoObj , $action ) )
    {
      Error::addError('Requested invalid Archive Action: '.$action.' for Archive: '.$type.'. Please Check you Buildconfiguration.' );
      return false;
    }

    return $repoObj->$action( $node );

  }//end public function execute */


} // end class LibBuildArchive

