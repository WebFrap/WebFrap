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
class LibAclDbBase_Test
  extends LibTestUnit
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
    $this->acl  = new LibAclDb( Webfrap::getActive(), $this->db );
    $this->acl->setDb( $this->db );

    $this->user = User_Stub::getStubObject();
    $this->user->setDb( $this->db );

    $this->populateDatabase();
    $this->acl->setUser( $this->user );

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
    $orm->cleanResource( 'WbfsysText' );
    $orm->cleanResource( 'WbfsysRoleGroup' );
    $orm->cleanResource( 'WbfsysRoleUser' );
    $orm->cleanResource( 'WbfsysSecurityArea' );
    $orm->cleanResource( 'WbfsysSecurityAccess' );
    $orm->cleanResource( 'WbfsysGroupUsers' );

    // clear the cache
    $orm->clearCache();

    // some data
    $textTest = $orm->newEntity( 'WbfsysText' );
    $textTest->access_key = 'text_1';
    $orm->insert( $textTest );

    $textSecret = $orm->newEntity( 'WbfsysText' );
    $textSecret->access_key = 'secret';
    $orm->insert( $textSecret );

    // group roles
    $groupAnnon = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon->name       = 'Test Annon';
    $groupAnnon->access_key = 'test_annon';
    $groupAnnon->level      = 0;
    $orm->insert( $groupAnnon );

    $groupAnnon2 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon2->name       = 'Test Annon 2';
    $groupAnnon2->access_key = 'test_annon_2';
    $groupAnnon2->level      = 0;
    $orm->insert( $groupAnnon2 );

    $groupAnnon3 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon3->name       = 'Test Annon 3';
    $groupAnnon3->access_key = 'test_annon_3';
    $groupAnnon3->level      = 0;
    $orm->insert( $groupAnnon3 );

    $groupAnnon4 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon4->name       = 'Test Annon 4';
    $groupAnnon4->access_key = 'test_annon_4';
    $groupAnnon4->level      = 0;
    $orm->insert( $groupAnnon4 );

    $groupAnnon5 = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupAnnon5->name       = 'Test Annon 5';
    $groupAnnon5->access_key = 'test_annon_5';
    $groupAnnon5->level      = 0;
    $orm->insert( $groupAnnon5 );

    // user roles
    $userAnon = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon->name  = 'test_annon';
    $userAnon->level = 0;
    $orm->insert( $userAnon );

    $userAnon2 = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon2->name  = 'test_annon_2';
    $userAnon2->level = 0;
    $orm->insert( $userAnon2 );

    $userAnon3 = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon3->name  = 'test_annon_3';
    $userAnon3->level = 0;
    $orm->insert( $userAnon3 );

    // security areas
    $areaModTest = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest->access_key       = 'mod-test';
    $areaModTest->id_level_access  = 100;
    $areaModTest->id_level_insert  = 100;
    $areaModTest->id_level_update  = 100;
    $areaModTest->id_level_delete  = 100;
    $areaModTest->id_level_admin   = 100;
    $orm->insert( $areaModTest );

    $areaModTest2 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest2->access_key       = 'mod-test_2';
    $areaModTest2->id_level_access  = 100;
    $areaModTest2->id_level_insert  = 100;
    $areaModTest2->id_level_update  = 100;
    $areaModTest2->id_level_delete  = 100;
    $areaModTest2->id_level_admin   = 100;
    $orm->insert( $areaModTest2 );

    $areaModTest3 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest3->access_key       = 'mod-test_3';
    $areaModTest3->id_level_access  = 100;
    $areaModTest3->id_level_insert  = 100;
    $areaModTest3->id_level_update  = 100;
    $areaModTest3->id_level_delete  = 100;
    $areaModTest3->id_level_admin   = 100;
    $orm->insert( $areaModTest3 );

    $areaModTest4 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest4->access_key       = 'mod-test_4';
    $areaModTest4->id_level_access  = 100;
    $areaModTest4->id_level_insert  = 100;
    $areaModTest4->id_level_update  = 100;
    $areaModTest4->id_level_delete  = 100;
    $areaModTest4->id_level_admin   = 100;
    $orm->insert( $areaModTest4 );

    $areaModTest5 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModTest5->access_key       = 'mod-test_5';
    $areaModTest5->id_level_access  = 100;
    $areaModTest5->id_level_insert  = 100;
    $areaModTest5->id_level_update  = 100;
    $areaModTest5->id_level_delete  = 100;
    $areaModTest5->id_level_admin   = 100;
    $orm->insert( $areaModTest5 );

    $areaEntTest = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest->access_key       = 'entity-test';
    $areaEntTest->id_level_access  = 100;
    $areaEntTest->id_level_insert  = 100;
    $areaEntTest->id_level_update  = 100;
    $areaEntTest->id_level_delete  = 100;
    $areaEntTest->id_level_admin   = 100;
    $areaEntTest->m_parent         = $areaModTest;
    $orm->insert( $areaEntTest );

    $areaEntTest2 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest2->access_key       = 'entity-test_2';
    $areaEntTest2->id_level_access  = 100;
    $areaEntTest2->id_level_insert  = 100;
    $areaEntTest2->id_level_update  = 100;
    $areaEntTest2->id_level_delete  = 100;
    $areaEntTest2->id_level_admin   = 100;
    $areaEntTest2->m_parent         = $areaModTest2;
    $orm->insert( $areaEntTest2 );

    $areaEntTest3 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest3->access_key       = 'entity-test_3';
    $areaEntTest3->id_level_access  = 100;
    $areaEntTest3->id_level_insert  = 100;
    $areaEntTest3->id_level_update  = 100;
    $areaEntTest3->id_level_delete  = 100;
    $areaEntTest3->id_level_admin   = 100;
    $areaEntTest3->m_parent         = $areaModTest3;
    $orm->insert( $areaEntTest3 );

    $areaEntTest4 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest4->access_key       = 'entity-test_4';
    $areaEntTest4->id_level_access  = 100;
    $areaEntTest4->id_level_insert  = 100;
    $areaEntTest4->id_level_update  = 100;
    $areaEntTest4->id_level_delete  = 100;
    $areaEntTest4->id_level_admin   = 100;
    $areaEntTest4->m_parent         = $areaModTest4;
    $orm->insert( $areaEntTest4 );

    $areaEntTest5 = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaEntTest5->access_key       = 'entity-test_5';
    $areaEntTest5->id_level_access  = 100;
    $areaEntTest5->id_level_insert  = 100;
    $areaEntTest5->id_level_update  = 100;
    $areaEntTest5->id_level_delete  = 100;
    $areaEntTest5->id_level_admin   = 100;
    $areaEntTest5->m_parent         = $areaModTest5;
    $orm->insert( $areaEntTest5 );

    // access
    $access1 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $access1->id_group  = $groupAnnon;
    $access1->id_area   = $areaModTest;
    $access1->access_level = Acl::LISTING;
    $this->acl->createAreaAssignment($access1,array(),true);

    $access2 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $access2->id_group  = $groupAnnon2;
    $access2->id_area   = $areaModTest2;
    $access2->access_level = Acl::ACCESS;
    $this->acl->createAreaAssignment($access2,array(),true);

    $access3 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $access3->id_group  = $groupAnnon3;
    $access3->id_area   = $areaModTest3;
    $access3->access_level = Acl::LISTING;
    $this->acl->createAreaAssignment($access3,array(),true);

    $access4 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $access4->id_group  = $groupAnnon;
    $access4->id_area   = $areaEntTest4;
    $access4->access_level = Acl::LISTING;
    $this->acl->createAreaAssignment($access4,array('mod-test_4'),true);

    $access5 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $access5->id_group  = $groupAnnon5;
    $access5->id_area   = $areaEntTest5;
    $access5->access_level = Acl::LISTING;
    $this->acl->createAreaAssignment($access5,array('mod-test_5'),true);

    // user role assignments

    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user = $userAnon;
    $entityGUser->id_group = $groupAnnon;
    $this->acl->createGroupAssignment( $entityGUser );

    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user = $userAnon;
    $entityGUser->id_group = $groupAnnon4;
    $this->acl->createGroupAssignment( $entityGUser );

    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user = $userAnon;
    $entityGUser->id_group = $groupAnnon5;
    $entityGUser->id_area = $areaEntTest5;
    $entityGUser->vid = $textTest;
    $this->acl->createGroupAssignment( $entityGUser );

    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user = $userAnon2;
    $entityGUser->id_group = $groupAnnon2;
    $entityGUser->id_area = $areaModTest2;
    $this->acl->createGroupAssignment( $entityGUser );

    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user = $userAnon3;
    $entityGUser->id_group = $groupAnnon3;
    $entityGUser->id_area = $areaModTest3;
    $entityGUser->vid = $textTest;
    $this->acl->createGroupAssignment( $entityGUser );

  }//end protected function populateDatabase */

/*//////////////////////////////////////////////////////////////////////////////
// role tests
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasRoleModule()
  {

    $this->user->switchUser( 'test_annon' );

    $orm        = $this->db->orm;
    $textTest   = $orm->getByKey( 'WbfsysText', 'text_1' );
    $textSecret = $orm->getByKey( 'WbfsysText', 'secret' );

    $res = $this->acl->hasRole( 'test_annon' );
    $this->assertTrue( 'hasRole test_annon returned false', $res );

    $res = $this->acl->hasRole( 'test_annon', 'mod-test' );
    $this->assertTrue( 'hasRole test_annon returned false', $res );

    $res = $this->acl->hasRole( 'test_annon', 'mod-test', $textTest );
    $this->assertTrue( 'hasRole test_annon for text test returned false', $res );

    $res = $this->acl->hasRole( 'test_annon', 'mod-test', $textSecret );
    $this->assertTrue( 'hasRole test_annon text secret  returned false', $res );

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2' );
    $this->assertTrue( 'hasRole test_annon returned false', $res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2', $textTest );
    $this->assertTrue( 'hasRole test_annon for text test returned false', $res );

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2', $textSecret );
    $this->assertTrue( 'hasRole test_annon text secret  returned false', $res );

    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse( 'hasRole fubar returned true', $res );

  }//end public function testAccessModule */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasAreaRoleModule()
  {

    $this->user->switchUser( 'test_annon_2' );

    $orm        = $this->db->orm;
    $textTest   = $orm->getByKey( 'WbfsysText', 'text_1' );
    $textSecret = $orm->getByKey( 'WbfsysText', 'secret' );

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2' );
    $this->assertTrue('hasRole test_annon_2 returned false',$res);

    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2', $textTest );
    $this->assertTrue('hasRole test_annon_2 for text test returned false',$res);

    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2', $textSecret );
    $this->assertTrue('hasRole test_annon_2 text secret  returned false',$res);

    // testen auf globale rolle
    $res = $this->acl->hasRole( 'test_annon2' );
    $this->assertFalse('hasRole test_annon_2 for: mod-test_2 returned true',$res);

    // testen auf existierende rolle
    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2' );
    $this->assertFalse('hasRole test_annon_2 for: mod-test returned true',$res);

    // testen auf existierende rolle global
    $res = $this->acl->hasRole( 'test_annon' );
    $this->assertFalse('hasRole test_annon_2 for: global returned true',$res);

    // test auf nicht existierend rolle
    $res = $this->acl->hasRole( 'fubar', 'mod-test_2' );
    $this->assertFalse('hasRole fubar for: "mod-test" returned true',$res);

    // test auf nicht existierend rolle global
    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse('hasRole fubar for: global returned true',$res);

  }//end public function testHasAreaRole */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasDatasetRoleModule()
  {

    $this->user->switchUser('test_annon_3');

    $orm = $this->db->orm;
    $textTest   = $orm->getByKey( 'WbfsysText', 'text_1' );
    $textSecret = $orm->getByKey( 'WbfsysText', 'secret' );

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_3', 'mod-test_3', $textTest );
    $this->assertTrue('hasRole test_annon_3 for mod-test and text test returned false',$res);

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_3', 'mod-test_3', $textSecret );
    $this->assertFalse('hasRole test_annon_3 for mod-test and text secret returned true',$res);

    // testen auf globale rolle
    $res = $this->acl->hasRole( 'test_annon_3', 'mod-test_3' );
    $this->assertFalse('hasRole test_annon_3 for mod-test returned true',$res);

    $res = $this->acl->hasRole( 'test_annon_3' );
    $this->assertFalse('hasRole test_annon_3 returned true',$res);

    // test auf nicht existierend rolle
    $res = $this->acl->hasRole( 'fubar', 'mod-test', $textTest );
    $this->assertFalse('hasRole fubar for: "mod-test" and entity returned true',$res);

    $res = $this->acl->hasRole( 'fubar', 'mod-test' );
    $this->assertFalse('hasRole fubar for: "mod-test" returned true',$res);

    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse('hasRole fubar for: global returned true',$res);

  }//end public function testHasAreaRole */

/*//////////////////////////////////////////////////////////////////////////////
// access checks
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testAccessModule()
  {

    $this->user->switchUser('test_annon');

    $orm        = $this->db->orm;
    $textTest   = $orm->getByKey( 'WbfsysText', 'text_1' );
    $textSecret = $orm->getByKey( 'WbfsysText', 'secret' );

    // should be valid
    $res = $this->acl->access( 'mod-test:access' );
    $this->assertTrue( 'access mod-test:access returned false', $res );

    // full access expected
    $res = $this->acl->access( 'mod-test:access', $textTest );
    $this->assertTrue( 'access mod-test:access text test returned false', $res );

    // full access expected
    $res = $this->acl->access( 'mod-test:access', $textSecret );
    $this->assertTrue( 'access mod-test:access secret text returned false', $res );

    // from here all should return false

    // has rights for mod-test but only on access
    $res = $this->acl->access( 'mod-test:insert' );
    $this->assertFalse( 'access mod-test:insert returned true', $res );

    // no rights for existing area
    $res = $this->acl->access( 'mod-test_2:access' );
    $this->assertFalse( 'access mod-test_2:access returned true', $res );

    $res = $this->acl->access( 'mod-test_2:insert' );
    $this->assertFalse( 'access mod-test_2:insert returned true', $res );

    // no rights for nonexisting area
    $res = $this->acl->access( 'not_exists:access' );
    $this->assertFalse( 'access not_exists:access returned true', $res );

    $res = $this->acl->access( 'not_exists:insert' );
    $this->assertFalse( 'access not_exists:insert returned true', $res );

  }//end public function testAccessModule */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testAreaAccessModule()
  {

    $this->user->switchUser( 'test_annon_2' );

    $orm        = $this->db->orm;
    $textTest   = $orm->getByKey( 'WbfsysText', 'text_1' );
    $textSecret = $orm->getByKey( 'WbfsysText', 'secret' );

    // shoule be valid
    $res = $this->acl->access( 'mod-test_2:access' );
    $this->assertTrue('access mod-test_2:access returned false',$res);

    $res = $this->acl->access( 'mod-test_2:insert' );
    $this->assertTrue('access mod-test_2:insert returned false',$res);

    $res = $this->acl->access( 'mod-test_2:access', $textTest );
    $this->assertTrue('access mod-test_2:access text test returned false',$res);

    $res = $this->acl->access( 'mod-test_2:access', $textSecret );
    $this->assertTrue('access mod-test_2:access secret text returned false',$res);

    // from here all should be invalid
    $res = $this->acl->access( 'mod-test_2:update' );
    $this->assertFalse('access mod-test_2:update returned true',$res);

    // no rights for existing area
    $res = $this->acl->access( 'mod-test:access' );
    $this->assertFalse('access mod-test:access returned true',$res);

    $res = $this->acl->access( 'mod-test:insert' );
    $this->assertFalse('access mod-test:insert returned true',$res);

    // no rights for nonexisting area
    $res = $this->acl->access( 'not_exists:access' );
    $this->assertFalse('access not_exists:access returned true',$res);

    $res = $this->acl->access( 'not_exists:insert' );
    $this->assertFalse('access not_exists:insert returned true',$res);

  }//end public function testAccessModule */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testDatasetAccessModule()
  {

    $this->user->switchUser('test_annon_3');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // can access only this one entity
    $res = $this->acl->access( 'mod-test_3:access', $textTest );
    $this->assertTrue('access mod-test_3:access for test text returned false',$res);

    // no access to access secret entity
    $res = $this->acl->access( 'mod-test_3:access', $textSecret );
    $this->assertFalse('access mod-test_3:access for secret text returned true',$res);

    // no rights for existing area
    $res = $this->acl->access( 'mod-test:access' );
    $this->assertFalse('access mod-test:access returned true',$res);

    $res = $this->acl->access( 'mod-test:insert' );
    $this->assertFalse('access mod-test:insert returned true',$res);

    // no rights for nonexisting area
    $res = $this->acl->access( 'not_exists:access' );
    $this->assertFalse('access not_exists:access returned true',$res);

    $res = $this->acl->access( 'not_exists:insert' );
    $this->assertFalse('access not_exists:insert returned true',$res);

  }//end public function testAccessModule */

/*//////////////////////////////////////////////////////////////////////////////
// role tests entity
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasAreaRoleEntityByMod()
  {

    $this->user->switchUser('test_annon_2');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2/entity-test_2' );
    $this->assertTrue('hasRole test_annon_2 returned false',$res);

    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2/entity-test_2', $textTest );
    $this->assertTrue('hasRole test_annon_2 for text test returned false',$res);

    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2/entity-test_2', $textSecret );
    $this->assertTrue('hasRole test_annon_2 text secret  returned false',$res);

    // testen auf globale rolle
    $res = $this->acl->hasRole( 'test_annon2' );
    $this->assertFalse('hasRole test_annon_2 for: mod-test_2 returned true',$res);

    // testen auf existierende rolle
    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2/entity-test_2' );
    $this->assertFalse('hasRole test_annon_2 for: mod-test returned true',$res);

    // testen auf existierende rolle global
    $res = $this->acl->hasRole( 'test_annon' );
    $this->assertFalse('hasRole test_annon_2 for: global returned true',$res);

    // test auf nicht existierend rolle
    $res = $this->acl->hasRole( 'fubar', 'mod-test_2/entity-test_2' );
    $this->assertFalse('hasRole fubar for: "mod-test" returned true',$res);

    // test auf nicht existierend rolle global
    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse('hasRole fubar for: global returned true',$res);

  }//end public function testHasAreaRole */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasDatasetRoleEntityByMod()
  {

    $this->user->switchUser('test_annon_3');

    $orm = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_3', 'mod-test_3/entity-test_3', $textTest );
    $this->assertTrue('hasRole test_annon_3 for mod-test and text test returned false',$res);

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_3', 'mod-test_3/entity-test_3', $textSecret );
    $this->assertFalse('hasRole test_annon_3 for mod-test and text secret returned true',$res);

    // testen auf globale rolle
    $res = $this->acl->hasRole( 'test_annon_3', 'mod-test_3/entity-test_3' );
    $this->assertFalse('hasRole test_annon_3 for mod-test returned true',$res);

    $res = $this->acl->hasRole( 'test_annon_3' );
    $this->assertFalse('hasRole test_annon_3 returned true',$res);

    // test auf nicht existierend rolle
    $res = $this->acl->hasRole( 'fubar', 'mod-test/entity-test', $textTest );
    $this->assertFalse('hasRole fubar for: "mod-test" and entity returned true',$res);

    $res = $this->acl->hasRole( 'fubar', 'mod-test/entity-test' );
    $this->assertFalse('hasRole fubar for: "mod-test" returned true',$res);

    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse('hasRole fubar for: global returned true',$res);

  }//end public function testHasAreaRole */

/*//////////////////////////////////////////////////////////////////////////////
// access checks
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testAccessEntityByMod()
  {

    $this->user->switchUser('test_annon');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // shoule be valid
    $res = $this->acl->access( 'mod-test/entity-test:access' );
    $this->assertTrue('access mod-test:access returned false',$res);

    // full access expected
    $res = $this->acl->access( 'mod-test/entity-test:access', $textTest );
    $this->assertTrue('access mod-test:access text test returned false',$res);

    // full access expected
    $res = $this->acl->access( 'mod-test/entity-test:access', $textSecret );
    $this->assertTrue('access mod-test:access secret text returned false',$res);

    // from here all should return false

    // has rights for mod-test but only on access
    $res = $this->acl->access( 'mod-test/entity-test:insert' );
    $this->assertFalse('access mod-test:insert returned true',$res);

    // no rights for existing area
    $res = $this->acl->access( 'mod-test_2/entity-test_2:access' );
    $this->assertFalse('access mod-test_2:access returned true',$res);

    $res = $this->acl->access( 'mod-test_2/entity-test_2:insert' );
    $this->assertFalse('access mod-test_2:insert returned true',$res);

  }//end public function testAccessEntity */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testAreaAccessEntityByMod()
  {

    $this->user->switchUser('test_annon_2');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // shoule be valid
    $res = $this->acl->access( 'mod-test_2/entity-test_2:access' );
    $this->assertTrue('access mod-test_2:access returned false',$res);

    $res = $this->acl->access( 'mod-test_2/entity-test_2:insert' );
    $this->assertTrue('access mod-test_2:insert returned false',$res);

    $res = $this->acl->access( 'mod-test_2/entity-test_2:access', $textTest );
    $this->assertTrue('access mod-test_2:access text test returned false',$res);

    $res = $this->acl->access( 'mod-test_2/entity-test_2:access', $textSecret );
    $this->assertTrue('access mod-test_2:access secret text returned false',$res);

    // from here all should be invalid

    // has rights for mod-test but only on access
    $res = $this->acl->access( 'mod-test_2/entity-test_2:update' );
    $this->assertFalse('access mod-test_2/entity-test_2:update returned true',$res);

    // no rights for existing area
    $res = $this->acl->access( 'mod-test/entity-test:access' );
    $this->assertFalse('access mod-test/entity-test:access returned true',$res);

    $res = $this->acl->access( 'mod-test/entity-test:insert' );
    $this->assertFalse('access mod-test/entity-testinsert returned true',$res);

  }//end public function testAccessEntity */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testDatasetAccessEntityByMod()
  {

    $this->user->switchUser('test_annon_3');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // can access only this one entity
    $res = $this->acl->access( 'mod-test_3/entity-test_3:access', $textTest );
    $this->assertTrue('access mod-test_3/entity-test_3:access for test text returned false',$res);

    // no access to access secret entity
    $res = $this->acl->access( 'mod-test_3/entity-test_3:access', $textSecret );
    $this->assertFalse('access mod-test_3/entity-test_3:access for secret text returned true',$res);

    // no rights for existing area
    $res = $this->acl->access( 'mod-test/entity-test:access' );
    $this->assertFalse('access mod-test:/entity-testaccess returned true',$res);

    $res = $this->acl->access( 'mod-test/entity-test:insert' );
    $this->assertFalse('access mod-test/entity-test:insert returned true',$res);

    // no rights for nonexisting area
    $res = $this->acl->access( 'not_exists/entity-not_exists:access' );
    $this->assertFalse('access not_exists:access returned true',$res);

    $res = $this->acl->access( 'not_exists/entity-not_exists:insert' );
    $this->assertFalse('access not_exists:insert returned true',$res);

  }//end public function testAccessEntity */

/*//////////////////////////////////////////////////////////////////////////////
// role tests
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testHasAreaRoleEntity()
  {

    $this->user->switchUser('test_annon');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // testen auf rolle in relation zu mod-test
    $res = $this->acl->hasRole( 'test_annon_4', 'mod-test_4/entity-test_4' );
    $this->assertTrue('hasRole test_annon_2 returned false',$res);

    $res = $this->acl->hasRole( 'test_annon_4', 'mod-test_4/entity-test_4', $textTest );
    $this->assertTrue('hasRole test_annon_2 for text test returned false',$res);

    $res = $this->acl->hasRole( 'test_annon_4', 'mod-test_4/entity-test_4', $textSecret );
    $this->assertTrue('hasRole test_annon_2 text secret  returned false',$res);

    // testen auf existierende rolle
    $res = $this->acl->hasRole( 'test_annon_2', 'mod-test_2/entity-test_2' );
    $this->assertFalse('hasRole test_annon for: "mod-test_2/entity-test_2" returned true',$res);

    // test auf nicht existierend rolle
    $res = $this->acl->hasRole( 'fubar', 'mod-test_2/entity-test_2' );
    $this->assertFalse('hasRole fubar for: "mod-test_2/entity-test_2" returned true',$res);

  }//end public function testHasAreaRole */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testDatasetAccessEntity()
  {

    $this->user->switchUser('test_annon');

    $orm        = $this->db->orm;
    $textTest   = $orm->get('WbfsysText',"access_key='text_1'");
    $textSecret = $orm->get('WbfsysText',"access_key='secret'");

    // can access only this one entity
    $res = $this->acl->access( 'mod-test_5/entity-test_5:access', $textTest );
    $this->assertTrue('access mod-test_5/entity-test_5:access for test text returned false',$res);

    // no access to access secret entity
    $res = $this->acl->access( 'mod-test_5/entity-test_5:access', $textSecret );
    $this->assertFalse('access mod-test_5/entity-test_5:access for secret text returned true',$res);

    // no access without entity
    $res = $this->acl->access( 'mod-test_5/entity-test_5:access' );
    $this->assertFalse('access mod-test_5/entity-test_5:access returned true',$res);

    $res = $this->acl->access( 'entity-test_5:access' );
    $this->assertFalse('access entity-test_5:access returned true',$res);

  }//end public function testAccessModule */

} //end abstract class LibAclDbBase_Test
