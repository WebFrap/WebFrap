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
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSession_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'switchprofile'
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return void
   */
  public function switchProfile( )
  {

    $profile = $this->getRequest()->get('profile',Validator::CNAME);

    $user = $this->getUser();

    if( $user->hasProfile($profile) )
    {
      $user->switchProfile($profile);
    }




  } // end public function menu */



}//end class ControllerWebfrapSession

