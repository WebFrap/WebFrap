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
 *
 * @package WebFrapUnit
 * @subpackage WebFrap
 */
class LibFlowTaskplanner_Test extends LibTestUnit
{

  public function setUp ()
  {

    $this->db = Db::connection('test');
    
    $this->user = User_Stub::getStubObject();
    $this->user->setDb($this->db);
  }

  public function test_first ()
  {
   
    $taskPlan = new LibTaskplanner(WebFrap::$env, 1395846000);
    
    $flow = new LibFlowTaskplanner();
    $flow->main();
  }
}