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
class LibAclDbCrud_Test extends LibTestUnit
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
   * @var LibAclDb
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
    $this->user->setDb($this->db );

    $this->acl->setUser($this->user );
    $this->acl->setDb($this->db );

    $this->populateDatabase();


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
    $orm->cleanResource('WbfsysText');
    $orm->cleanResource('WbfsysRoleGroup');
    $orm->cleanResource('WbfsysRoleUser');
    $orm->cleanResource('WbfsysSecurityArea');
    $orm->cleanResource('WbfsysSecurityAccess');
    $orm->cleanResource('WbfsysGroupUsers');
    $orm->cleanResource('WbfsysProfile');

    // clear the cache
    $orm->clearCache();

    // some data
    $textTest = $orm->newEntity( 'WbfsysText' );
    $textTest->access_key = 'text_1';
    $orm->insert($textTest);

    $textSecret = $orm->newEntity( 'WbfsysText' );
    $textSecret->access_key = 'secret';
    $orm->insert($textSecret);

    // profiles
    $profileAdmin = $orm->newEntity( 'WbfsysProfile' );
    $profileAdmin->name       = 'Admin';
    $profileAdmin->access_key = 'admin';
    $orm->insert($profileAdmin);

    $profileUser = $orm->newEntity( 'WbfsysProfile' );
    $profileUser->name       = 'User';
    $profileUser->access_key = 'user';
    $orm->insert($profileUser);

    // group roles
    $groupAnnon = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon->name       = 'Test Annon 1';
    $groupAnnon->access_key = 'test_group_1';
    $groupAnnon->level      = 0;
    $orm->insert($groupAnnon);

    $groupAnnon2 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon2->name       = 'Test Annon 2';
    $groupAnnon2->access_key = 'test_group_2';
    $groupAnnon2->level      = 0;
    $orm->insert($groupAnnon2);

    $groupAnnon3 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon3->name       = 'Test Annon 3';
    $groupAnnon3->access_key = 'test_group_3';
    $groupAnnon3->level      = 0;
    $orm->insert($groupAnnon3);

    $groupAnnon4 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon4->name       = 'Test Annon 4';
    $groupAnnon4->access_key = 'test_group_4';
    $groupAnnon4->level      = 0;
    $orm->insert($groupAnnon4);

    $groupAnnon5 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon5->name       = 'Test Annon 5';
    $groupAnnon5->access_key = 'test_group_5';
    $groupAnnon5->level      = 0;
    $orm->insert($groupAnnon5);

    $groupFail1 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupFail1->name       = 'Test Fail 1';
    $groupFail1->access_key = 'test_fail_1';
    $groupFail1->level      = 0;
    $orm->insert($groupFail1);

    // user roles
    $userAdmin = $orm->newEntity( 'WbfsysRoleUser' );
    $userAdmin->name  = 'admin';
    $userAdmin->level = Acl::ADMIN;
    $userAdmin->profile = $orm->getByKey('WbfsysProfile', 'admin');
    $orm->insert($userAdmin);

    $userAnon = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon->name  = 'test_user_1';
    $userAnon->level = 0;
    $orm->insert($userAnon);

    $userAnon2 = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon2->name  = 'test_user_2';
    $userAnon2->level = 0;
    $orm->insert($userAnon2);

    $userAnon3 = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon3->name  = 'test_user_3';
    $userAnon3->level = 0;
    $orm->insert($userAnon3);


    // security areas
    $areaModTest = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest->access_key       = 'mod-test_1';
    $areaModTest->id_level_access  = 100;
    $areaModTest->id_level_insert  = 100;
    $areaModTest->id_level_update  = 100;
    $areaModTest->id_level_delete  = 100;
    $areaModTest->id_level_admin   = 100;
    $orm->insert($areaModTest);

    $areaModTest2 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest2->access_key       = 'mod-test_2';
    $areaModTest2->id_level_access  = 100;
    $areaModTest2->id_level_insert  = 100;
    $areaModTest2->id_level_update  = 100;
    $areaModTest2->id_level_delete  = 100;
    $areaModTest2->id_level_admin   = 100;
    $orm->insert($areaModTest2);

    $areaModTest3 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest3->access_key       = 'mod-test_3';
    $areaModTest3->id_level_access  = 100;
    $areaModTest3->id_level_insert  = 100;
    $areaModTest3->id_level_update  = 100;
    $areaModTest3->id_level_delete  = 100;
    $areaModTest3->id_level_admin   = 100;
    $orm->insert($areaModTest3);

    $areaModTest4 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest4->access_key       = 'mod-test_4';
    $areaModTest4->id_level_access  = 100;
    $areaModTest4->id_level_insert  = 100;
    $areaModTest4->id_level_update  = 100;
    $areaModTest4->id_level_delete  = 100;
    $areaModTest4->id_level_admin   = 100;
    $orm->insert($areaModTest4);

    $areaModTest5 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest5->access_key       = 'mod-test_5';
    $areaModTest5->id_level_access  = 100;
    $areaModTest5->id_level_insert  = 100;
    $areaModTest5->id_level_update  = 100;
    $areaModTest5->id_level_delete  = 100;
    $areaModTest5->id_level_admin   = 100;
    $orm->insert($areaModTest5);

    $areaEntTest = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest->access_key       = 'entity-test_1';
    $areaEntTest->id_level_access  = 100;
    $areaEntTest->id_level_insert  = 100;
    $areaEntTest->id_level_update  = 100;
    $areaEntTest->id_level_delete  = 100;
    $areaEntTest->id_level_admin   = 100;
    $areaEntTest->m_parent         = $areaModTest;
    $orm->insert($areaEntTest);

    $areaEntTest2 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest2->access_key       = 'entity-test_2';
    $areaEntTest2->id_level_access  = 100;
    $areaEntTest2->id_level_insert  = 100;
    $areaEntTest2->id_level_update  = 100;
    $areaEntTest2->id_level_delete  = 100;
    $areaEntTest2->id_level_admin   = 100;
    $areaEntTest2->m_parent         = $areaModTest2;
    $orm->insert($areaEntTest2);


    $areaEntTest3 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest3->access_key       = 'entity-test_3';
    $areaEntTest3->id_level_access  = 100;
    $areaEntTest3->id_level_insert  = 100;
    $areaEntTest3->id_level_update  = 100;
    $areaEntTest3->id_level_delete  = 100;
    $areaEntTest3->id_level_admin   = 100;
    $areaEntTest3->m_parent         = $areaModTest3;
    $orm->insert($areaEntTest3);

    $areaEntTest4 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest4->access_key       = 'entity-test_4';
    $areaEntTest4->id_level_access  = 100;
    $areaEntTest4->id_level_insert  = 100;
    $areaEntTest4->id_level_update  = 100;
    $areaEntTest4->id_level_delete  = 100;
    $areaEntTest4->id_level_admin   = 100;
    $areaEntTest4->m_parent         = $areaModTest4;
    $orm->insert($areaEntTest4);

    $areaEntTest5 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest5->access_key       = 'entity-test_5';
    $areaEntTest5->id_level_access  = 100;
    $areaEntTest5->id_level_insert  = 100;
    $areaEntTest5->id_level_update  = 100;
    $areaEntTest5->id_level_delete  = 100;
    $areaEntTest5->id_level_admin   = 100;
    $areaEntTest5->m_parent         = $areaModTest5;
    $orm->insert($areaEntTest5);


    $areaMgmtTest1 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaMgmtTest1->access_key       = 'mgmt-test_1';
    $areaMgmtTest1->id_level_access  = 100;
    $areaMgmtTest1->id_level_insert  = 100;
    $areaMgmtTest1->id_level_update  = 100;
    $areaMgmtTest1->id_level_delete  = 100;
    $areaMgmtTest1->id_level_admin   = 100;
    $areaMgmtTest1->m_parent         = $areaEntTest;
    $orm->insert($areaMgmtTest1 );


  }//end protected function populateDatabase */

/*//////////////////////////////////////////////////////////////////////////////
// role tests
//////////////////////////////////////////////////////////////////////////////*/



  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function test_AssignGroupToArea()
  {

    $this->user->switchUser( 'admin' );

    $acl        = $this->acl;
    $orm        = $this->db->orm;

    $assign1 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $assign1->id_area  = $orm->getByKey( 'WbfsysSecurityArea', 'mgmt-test_1' );
    $assign1->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_1' );
    $assign1->access_level  = Acl::ACCESS;
    $acl->createAreaAssignment($assign1, array( 'mod-test_1', 'entity-test_1' ), true );

    $assign2 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $assign2->id_area  = $orm->getByKey( 'WbfsysSecurityArea', 'entity-test_2' );
    $assign2->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_2' );
    $assign2->access_level  = Acl::INSERT;
    $acl->createAreaAssignment($assign2, array( 'mod-test_2' ), true );

    $assign3 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $assign3->id_area  = $orm->getByKey( 'WbfsysSecurityArea', 'mod-test_3' );
    $assign3->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_3' );
    $assign3->access_level  = Acl::DELETE;
    $acl->createAreaAssignment($assign3, array(), true );

  }//end public function test_AssignGroupToArea */


  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function test_AssignUserToGroup()
  {

    $this->user->switchUser( 'admin' );

    $acl        = $this->acl;
    $orm        = $this->db->orm;

    $textTest   = $orm->get( 'WbfsysText', "access_key='text_1'" );
    $textSecret = $orm->get( 'WbfsysText', "access_key='secret'" );

    $assign1 = $orm->newEntity( 'WbfsysGroupUsers' );
    $assign1->id_user  = $orm->get( 'WbfsysRoleUser', "name='test_user_1'" );
    $assign1->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_1' );
    $acl->createGroupAssignment($assign1 );

    $assign2 = $orm->newEntity( 'WbfsysGroupUsers' );
    $assign2->id_user  = $orm->get( 'WbfsysRoleUser', "name='test_user_2'" );
    $assign2->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_1' );
    $assign2->id_area = $orm->getByKey( 'WbfsysSecurityArea', 'mgmt-test_1' );
    $acl->createGroupAssignment($assign2  );

    $assign3 = $orm->newEntity( 'WbfsysGroupUsers' );
    $assign3->id_user  = $orm->get( 'WbfsysRoleUser', "name='test_user_3'" );
    $assign3->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_1' );
    $assign3->id_area = $orm->getByKey( 'WbfsysSecurityArea', 'mgmt-test_1' );
    $assign3->vid = $textTest;
    $acl->createGroupAssignment($assign3  );


    // zuweisung auf entity ebene

    $assign4 = $orm->newEntity( 'WbfsysGroupUsers' );
    $assign4->id_user  = $orm->get( 'WbfsysRoleUser', "name='test_user_1'" );
    $assign4->id_group = $orm->getByKey( 'WbfsysRoleGroup', 'test_group_4' );
    $assign4->id_area = $orm->getByKey( 'WbfsysSecurityArea', 'entity-test_1' );
    $acl->createGroupAssignment($assign4  );


  }//end public function test_AssignGroupToArea */


  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasRoleGlobal()
  {

    $this->user->switchUser( 'test_user_1' );


    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // global has role check
    $hasRole = $this->acl->hasRole( array('test_group_1') );
    $hasnoRole = $this->acl->hasRole( array('test_fail_1') );

    $this->assertTrue( 'Failed: test_user_1 has role test_group_1' , $hasRole );
    $this->assertFalse( 'Failed: test_user_1 has role test_fail_1' , $hasnoRole );

    // global has role check
    $hasRole = $this->acl->hasRole( array('test_group_1') );
    $hasnoRole = $this->acl->hasRole( array('test_group_2') );
    $hasNoAreaRole = $this->acl->hasRole( array('test_group_2') , 'mgmt-test_1' );
    $hasNoDatasetRole = $this->acl->hasRole( array('test_group_2') , 'mgmt-test_1', $textSecret );

    $this->assertTrue( 'Failed: test_user_1 has role test_group_1' , $hasRole );
    $this->assertFalse( 'Failed: test_user_1 has role test_group_2' , $hasnoRole );
    $this->assertFalse( 'Failed: test_user_1 has role test_group_2 for area: mgmt-test_1' , $hasNoAreaRole );
    $this->assertFalse( 'Failed: test_user_1 has role test_group_2 for area: mgmt-test_1 dset: '.$textTest , $hasNoDatasetRole );


    $this->user->switchUser( 'test_user_2' );

    // global has role check
    $hasNoGlobRol1  = $this->acl->hasRole( array('test_group_1') );
    $hasNoGlobRol2  = $this->acl->hasRole( array('test_group_2') );

    $this->assertFalse( 'Failed: test_user_2 has global role test_group_1' , $hasNoGlobRol1 );
    $this->assertFalse( 'Failed: test_user_2 has global role test_group_2' , $hasNoGlobRol2 );

  }//end public function testHasRoleGlobal */


  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasRoleArea()
  {

    $orm        = $this->db->orm;

    $this->user->switchUser( 'test_user_1' );

    $hasNoAreaRole = $this->acl->hasRole( array('test_group_2') , 'mgmt-test_1' );
    $this->assertFalse( 'Failed: test_user_1 has role test_group_2 for area: mgmt-test_1' , $hasNoAreaRole );

    $hasNoDirectRole = $this->acl->hasRole( array('test_group_4') , 'mgmt-test_1' );
    $this->assertFalse( 'Failed: test_user_1 role test_group_4 for area: mgmt-test_1' , $hasNoDirectRole );

    $hasRole = $this->acl->hasRole( array('test_group_4') , 'mod-test_1/entity-test_1>mgmt-test_1' );
    $this->assertTrue( 'Failed: test_user_1 has no role test_group_4 for area: entity-test_1/mgmt-test_1' , $hasRole );

    $hasRole = $this->acl->hasRole( array('test_group_4') , 'entity-test_1/mgmt-test_1' );
    $this->assertTrue( 'Failed: test_user_1 has no role test_group_4 for area: entity-test_1/mgmt-test_1' , $hasRole );

    $hasRole = $this->acl->hasRole( array('test_group_4') , 'entity-test_1' );
    $this->assertTrue( 'Failed: test_user_1 has no role test_group_4 for area: entity-test_1' , $hasRole );

    $this->user->switchUser( 'test_user_2' );

    // global has role check
    $hasNoAccess = $this->acl->hasRole( array('test_group_2') , 'mod-test_2/entity-test_2/mgmt-test_2' );
    $this->assertFalse( 'Failed: test_user_2 has role test_group_2 for mod-test_2/entity-test_2/mgmt-test_2' , $hasNoAccess );

    $hasNoAccess = $this->acl->hasRole( array('test_group_2') , 'mod-test_2/entity-test_2' );
    $this->assertFalse( 'Failed: test_user_2 has role test_group_2 for mod-test_2/entity-test_2' , $hasNoAccess );

    $hasNoAccess = $this->acl->hasRole( array('test_group_2') , 'mod-test_2' );
    $this->assertFalse( 'Failed: test_user_2 has role test_group_2 for mod-test_2' , $hasNoAccess );


    $hasNoAccess = $this->acl->hasRole( array('test_group_1') , 'mod-test_1/entity-test_1' );
    $this->assertFalse( 'Failed: test_user_2 has role test_group_1 for mod-test_1/entity-test_1' , $hasNoAccess );

    $hasNoAccess = $this->acl->hasRole( array('test_group_1') , 'mod-test_1' );
    $this->assertFalse( 'Failed: test_user_2 has role test_group1 for mod-test_1' , $hasNoAccess );

    // access sollte genemigt werden
    $hasAccess = $this->acl->hasRole( array('test_group_1') , 'mod-test_1/entity-test_1/mgmt-test_1' );
    $this->assertTrue( 'Failed: test_user_2 has no role test_group_1 for area: mgmt-test_1' , $hasAccess );

    $hasAccess = $this->acl->hasRole( array('test_group_1') , 'mod-test_1/entity-test_1>mgmt-test_1' );
    $this->assertTrue( 'Failed: test_user_2 has no role test_group_1 for area: mgmt-test_1' , $hasAccess );

    $hasAccess = $this->acl->hasRole( array('test_group_1') , 'mgmt-test_1' );
    $this->assertTrue( 'Failed: test_user_2 has no role test_group_1 for area: mgmt-test_1' , $hasAccess );


  }//end public function testHasRoleArea */


  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasRoleDataset()
  {

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    $this->user->switchUser( 'test_user_3' );

    $hasNoRole = $this->acl->hasRole( array('test_group_1')  );
    $this->assertFalse( 'Failed: test_user_3 has role test_group_1' , $hasNoRole );

    $hasNoRole = $this->acl->hasRole( array('test_group_1') , 'mgmt-test_1' );
    $this->assertFalse( 'Failed: test_user_3 role test_group_1 for area: mgmt-test_1' , $hasNoRole );

    $hasNoRole = $this->acl->hasRole( array('test_group_1') , 'mod-test_1/entity-test_1>mgmt-test_1' );
    $this->assertFalse( 'Failed: test_user_3 has no role test_group_1 for area: entity-test_1/mgmt-test_1' , $hasNoRole );

    $hasNoRole = $this->acl->hasRole( array('test_group_2')  );
    $this->assertFalse( 'Failed: test_user_3 has role test_group_2' , $hasNoRole );

    $hasNoRole = $this->acl->hasRole( array('test_group_2') , 'mgmt-test_1' );
    $this->assertFalse( 'Failed: test_user_3 role test_group_2 for area: mgmt-test_1' , $hasNoRole );

    $hasNoRole = $this->acl->hasRole( array('test_group_2') , 'mod-test_1/entity-test_1>mgmt-test_1' );
    $this->assertFalse( 'Failed: test_user_3 has no role test_group_2 for area: entity-test_1/mgmt-test_1' , $hasNoRole );


    // rolle sollte gefunden werden
    $hasNoRole = $this->acl->hasRole( array('test_group_1') , 'mod-test_1/entity-test_1/mgmt-test_1', $textSecret );
    $this->assertFalse( 'Failed: test_user_1 has no role test_group_1 for area: entity-test_1/mgmt-test_1 dset: '.$textSecret, $hasNoRole );

    $hasNoRole = $this->acl->hasRole( array('test_group_1') , 'mgmt-test_1', $textSecret  );
    $this->assertFalse( 'Failed: test_user_1 has no role test_group_1 for area: mgmt-test_1 dset: '.$textSecret, $hasNoRole );

    // rolle sollte gefunden werden
    $hasRole = $this->acl->hasRole( array('test_group_1') , 'mod-test_1/entity-test_1/mgmt-test_1', $textTest );
    $this->assertTrue( 'Failed: test_user_1 has no role test_group_1 for area: entity-test_1/mgmt-test_1 dset: '.$textTest, $hasRole );

    $hasRole = $this->acl->hasRole( array('test_group_1') , 'mgmt-test_1', $textTest  );
    $this->assertTrue( 'Failed: test_user_1 has no role test_group_1 for area: mgmt-test_1 dset: '.$textTest, $hasRole );

  }//end public function testHasRoleDataset */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testCheckAccess()
  {

    $this->user->switchUser( 'test_user_1' );

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    $access = $this->acl->access( 'mod-test_1/entity-test_1>mgmt-test_1:access' );
    $this->assertTrue( 'User: test_user_1 got no access to area: mod-test_1/entity-test_1>mgmt-test_1:access' , $access);

    $access = $this->acl->access( 'mod-test_1/entity-test_1/mgmt-test_1:access' );
    $this->assertTrue( 'User: test_user_1 got no access to area: mgmt-test_1:access' , $access);

    $access = $this->acl->access( 'mgmt-test_1:access' );
    $this->assertTrue( 'User: test_user_1 got no access to area: mgmt-test_1:access' , $access);

    $noAccess = $this->acl->access( 'mgmt-test_1:admin' );
    $this->assertFalse( 'User: test_user_1 got access to area: mgmt-test_1:admin' , $noAccess);

  }//end public function testCheckAccess */


} //end abstract class LibAclDbBase_Test

