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
 * @subpackage tech_core
 */
class WgtSelectboxSessionuserProfiles
  extends WgtSelectboxHardcoded
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   */
  public function load()
  {

    $user = User::getActive();

    $profiles = $user->getProfiles();


    $this->data =  array();

    foreach( $profiles as $key => $profile )
    {
      $this->data[$key] = array( 'value' => ucfirst($profile) );
    }

    $this->activ = $user->getProfileName();

  }//end public function load()


} // end class WgtSelectboxSessionuserProfiles

