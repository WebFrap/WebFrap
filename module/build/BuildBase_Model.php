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
 * @subpackage Core
 */
class BuildBase_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////



  /**
   * @return void
   */
  public function getBuildFile( $key )
  {

    $data = array();

    // includes data
    include PATH_GW.'conf/map/build/projects.php';

    if( isset($data[$key]) )
      return $data[$key][1];
    else
      return false;


  } // end public function getBuildData */



}//end class BuildBase_Model

