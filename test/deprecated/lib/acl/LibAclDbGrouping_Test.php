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
 * @package WebFrapUnit
 * @subpackage WebFrap
 */
class LibAclDbGrouping_Test extends LibTestUnit
{

  /**
   * the db connection object
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * the db connection object
   * @var User_Stub
   */
  protected $user = null;

  /**
   * @var Acl
   */
  protected $acl = null;

  /**
   * (non-PHPdoc)
   * @see src/lib/test/LibTestUnit::setUp()
   */
  public function setUp()
  {

    $this->db   = Db::connection('test');
    $this->acl  = new LibAclDb();

    $this->user = User_Stub::getStubObject();
    $this->user->setDb($this->db);

    $this->populateDatabase();
    $this->acl->setUser( $this->user );
    $this->acl->setDb( $this->db );

  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// access checks
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  protected function populateDatabase()
  {
    $orm = $this->db->getOrm();

    // first clean the database to make shure to have no interferences
    // from existing data
    /*
    $orm->cleanResource('WbfsysText');
    $orm->cleanResource('WbfsysRoleGroup');
    $orm->cleanResource('WbfsysRoleUser');
    $orm->cleanResource('WbfsysSecurityArea');
    $orm->cleanResource('WbfsysSecurityAccess');
    $orm->cleanResource('WbfsysGroupUsers');

    // clear the cache
    $orm->clearCache();

    // some data
    $textTest = new WbfsysText_Entity;
    $textTest->access_key = 'text_1';
    $orm->insert($textTest);

    // group roles
    $group1 = new WbfsysRoleGroup_Entity;
    $group1->name       = 'Area Manager';
    $group1->access_key = 'area_manager';
    $group1->level      = 0;
    $orm->insert($group1);

    // user roles
    $user1 = new WbfsysRoleUser_Entity;
    $user1->name  = 'area_manager';
    $user1->level = 0;
    $user1->id_role = $group1;
    $orm->insert($user1);
    */


  }//end protected function populateDatabase */

/*//////////////////////////////////////////////////////////////////////////////
// role tests
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasRoleModule()
  {

    $this->user->switchUser('test_annon');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    $res = $this->acl->hasRole( 'test_annon' );
    $this->assertTrue('hasRole test_annon returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test' );
    $this->assertTrue('hasRole test_annon returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test', $textTest );
    $this->assertTrue('hasRole test_annon for text test returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test', $textSecret );
    $this->assertTrue('hasRole test_annon text secret  returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2' );
    $this->assertTrue('hasRole test_annon returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2', $textTest );
    $this->assertTrue('hasRole test_annon for text test returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2', $textSecret );
    $this->assertTrue('hasRole test_annon text secret  returned false, true was exepted',$res);

    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse('hasRole fubar returned true, false was exepted',$res);

  }//end public function testAccessModule */


} //end abstract class LibAclDbGrouping_Test

