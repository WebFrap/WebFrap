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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class SetupDatabase_Consistency extends DataContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run(  )
  {

    $this->systemUsers();

  }//end public function run */

  
  /**
   * 
   */
  protected function systemUsers()
  {
    
    $orm = $this->getOrm();
    $request = $this->getRequest();
    
    $userLib = new LibUser( $this );
    
    $user = new LibEnvelopUser();
  
    $user->userName  = 'system';
    $user->firstName = 'gaia';
    $user->lastName  = 'olymp';
    
    $user->passwd  = '☯kqU✈m92✇.Pdw+73HW☮d!2§ÄaV°;-)';
    $user->level   = User::LEVEL_SYSTEM;
    $user->profile = 'default';
    $user->description  = 'Der System User';
    $user->inactive     = false;
    $user->nonCertLogin = false;
    
    $user->addressItems[] = array( 'mail', 'system@'.$request->getServerName() );
    
    $userLib->createUser( $user );

    
  }//end protected function systemUsers */

 
  
}//end class SetupDatabase_Consistency

