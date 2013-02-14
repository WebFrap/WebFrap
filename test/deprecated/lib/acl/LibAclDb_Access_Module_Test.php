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
class LibAclDb_Access_Module_Test extends LibTestUnit
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
    $this->acl->setUser( $this->user );

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
    $orm->cleanResource( 'WbfsysText' );
    $orm->cleanResource( 'WbfsysRoleGroup' );
    $orm->cleanResource( 'WbfsysRoleUser' );
    $orm->cleanResource( 'WbfsysSecurityArea' );
    $orm->cleanResource( 'WbfsysSecurityAccess' );
    $orm->cleanResource( 'WbfsysGroupUsers' );

    // clear the cache
    $orm->clearCache();

    // Ein paar daten in der Datenbank
    $textPublic = $orm->newEntity( 'WbfsysText' );
    $textPublic->access_key = 'text_public';
    $orm->insert( $textPublic );

    $textAccess = $orm->newEntity( 'WbfsysText' );
    $textAccess->access_key = 'text_access';
    $orm->insert( $textAccess );
    
    $textNoAccess = $orm->newEntity( 'WbfsysText' );
    $textNoAccess->access_key = 'text_no_access';
    $orm->insert( $textNoAccess );

    // Gruppen Rollen
    $groupUnrelated = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupUnrelated->name       = 'Unrelated';
    $groupUnrelated->access_key = 'unrelated';
    $groupUnrelated->level      = Acl::DENIED;
    $orm->insert( $groupUnrelated );

    $groupHasAccess = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupHasAccess->name       = 'Has Access';
    $groupHasAccess->access_key = 'has_access';
    $groupHasAccess->level      = Acl::DENIED;
    $orm->insert( $groupHasAccess );

    $groupHasNoAccess = $orm->newEntity( 'WbfsysRoleGroup' );
    $groupHasNoAccess->name       = 'Has no Access';
    $groupHasNoAccess->access_key = 'has_no_access';
    $groupHasNoAccess->level      = Acl::DENIED;
    $orm->insert( $groupHasNoAccess );


    // user roles
    $userAnon = $orm->newEntity( 'WbfsysRoleUser' );
    $userAnon->name  = 'annon';
    $userAnon->level = Acl::DENIED;
    $orm->insert( $userAnon );

    $userHasAccess = $orm->newEntity( 'WbfsysRoleUser' );
    $userHasAccess->name  = 'has_access';
    $userHasAccess->level = Acl::DENIED;
    $orm->insert( $userHasAccess );
    
    $userHasDAccess = $orm->newEntity( 'WbfsysRoleUser' );
    $userHasDAccess->name  = 'has_dataset_access';
    $userHasDAccess->level = Acl::DENIED; 
    $orm->insert( $userHasDAccess );

    $userHasNoAccess = $orm->newEntity( 'WbfsysRoleUser' );
    $userHasNoAccess->name  = 'has_no_access';
    $userHasNoAccess->level = Acl::DENIED;
    $orm->insert( $userHasNoAccess );


    // security areas
    $areaModPublic = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModPublic->access_key       = 'mod-public';
    $areaModPublic->id_level_listing = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_level_access  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_level_insert  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_level_update  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_level_delete  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_level_admin   = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_ref_listing = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_ref_access  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_ref_insert  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_ref_update  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_ref_delete  = User::LEVEL_SUPERADMIN;
    $areaModPublic->id_ref_admin   = User::LEVEL_SUPERADMIN;
    $orm->insert( $areaModPublic );

    $areaModAccess = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModAccess->access_key       = 'mod-has_access';
    $areaModAccess->id_level_listing = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_level_access  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_level_insert  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_level_update  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_level_delete  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_level_admin   = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_ref_listing = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_ref_access  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_ref_insert  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_ref_update  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_ref_delete  = User::LEVEL_SUPERADMIN;
    $areaModAccess->id_ref_admin   = User::LEVEL_SUPERADMIN;
    $orm->insert( $areaModAccess );
    
    $areaModNoAccess = $orm->newEntity( 'WbfsysSecurityArea' );
    $areaModNoAccess->access_key       = 'mod-no_access';
    $areaModNoAccess->id_level_listing = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_level_access  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_level_insert  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_level_update  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_level_delete  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_level_admin   = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_ref_listing = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_ref_access  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_ref_insert  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_ref_update  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_ref_delete  = User::LEVEL_SUPERADMIN;
    $areaModNoAccess->id_ref_admin   = User::LEVEL_SUPERADMIN;
    $orm->insert( $areaModNoAccess );


    // access
    $access1 = $orm->newEntity( 'WbfsysSecurityAccess' );
    $access1->id_group      = $groupHasAccess;
    $access1->id_area       = $areaModAccess;
    $access1->access_level  = Acl::LISTING;
    $this->acl->createAreaAssignment($access1,array(),true);


    // user role assignments
    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user  = $userHasAccess;
    $entityGUser->id_group = $groupHasAccess;
    $entityGUser->id_area  = $areaModAccess;
    $this->acl->createGroupAssignment( $entityGUser );
    
    $entityGUser = $orm->newEntity( 'WbfsysGroupUsers' );
    $entityGUser->id_user  = $userHasDAccess;
    $entityGUser->id_group = $groupHasAccess;
    $entityGUser->id_area  = $areaModAccess;
    $entityGUser->vid      = $textAccess;
    $this->acl->createGroupAssignment( $entityGUser );


  }//end protected function populateDatabase */

  
/*//////////////////////////////////////////////////////////////////////////////
// access tests
//////////////////////////////////////////////////////////////////////////////*/
  
  
  /**
   * Prüfen auf Access für user has_access
   */
  public function test_hasAcccess_UserAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->access( 'mod-has_access:listing' );
    $this->assertTrue( 'role has_access area: mod-has_access level: listing returned false', $res );

    $res = $this->acl->access( 'mod-has_access:access' );
    $this->assertFalse( 'role has_access area: mod-has_access level: access returned true', $res );
    
    $res = $this->acl->access( 'mod-has_access:admin' );
    $this->assertFalse( 'role has_access area: mod-has_access level: admin returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:listing' );
    $this->assertFalse( 'role has_access area: mod-no_access level: listing returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:access' );
    $this->assertFalse( 'role has_access area: mod-no_access level: access returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:admin' );
    $this->assertFalse( 'role has_access area: mod-no_access level: admin returned true', $res );
    
    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->access( 'mod-has_access:listing', null, true );
    $this->assertTrue( 'role has_access area: mod-has_access, level: listing, check partial returned false', $res );

    $res = $this->acl->access( 'mod-has_access:access', null, true );
    $this->assertFalse( 'role has_access area: mod-has_access, level: access, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-has_access:admin', null, true );
    $this->assertFalse( 'role has_access area: mod-has_access, level: admin, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:listing', null, true );
    $this->assertFalse( 'role has_access area: mod-no_access, level: listing, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:access', null, true );
    $this->assertFalse( 'role has_access area: mod-no_access, level: access, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:admin', null, true );
    $this->assertFalse( 'role has_access area: mod-no_access, level: admin, check partial returned true', $res );
    
  }//end public function test_hasAcccess_UserAccess_RelationToArea */
  
  /**
   * Prüfen auf Access für user has_access
   */
  public function test_hasAcccess_UserNoAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_no_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->access( 'mod-has_access:listing' );
    $this->assertFalse( 'role has_access area: mod-has_access level: listing returned true', $res );

    $res = $this->acl->access( 'mod-has_access:access' );
    $this->assertFalse( 'role has_access area: mod-has_access level: access returned true', $res );
    
    $res = $this->acl->access( 'mod-has_access:admin' );
    $this->assertFalse( 'role has_access area: mod-has_access level: admin returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:listing' );
    $this->assertFalse( 'role has_access area: mod-no_access level: listing returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:access' );
    $this->assertFalse( 'role has_access area: mod-no_access level: access returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:admin' );
    $this->assertFalse( 'role has_access area: mod-no_access level: admin returned true', $res );
    
    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->access( 'mod-has_access:listing', null, true );
    $this->assertFalse( 'role has_access area: mod-has_access, level: listing, check partial returned true', $res );

    $res = $this->acl->access( 'mod-has_access:access', null, true );
    $this->assertFalse( 'role has_access area: mod-has_access, level: access, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-has_access:admin', null, true );
    $this->assertFalse( 'role has_access area: mod-has_access, level: admin, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:listing', null, true );
    $this->assertFalse( 'role has_access area: mod-no_access, level: listing, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:access', null, true );
    $this->assertFalse( 'role has_access area: mod-no_access, level: access, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:admin', null, true );
    $this->assertFalse( 'role has_access area: mod-no_access, level: admin, check partial returned true', $res );
    
  }//end public function test_hasAcccess_UserNoAccess_RelationToArea */
  
  /**
   * Prüfen auf Access für user has_dataset_access
   */
  public function test_hasAcccess_UserDatasetAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_dataset_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->access( 'mod-has_access:listing' );
    $this->assertFalse( 'role has_dataset_access area: mod-has_access level: listing returned true', $res );

    $res = $this->acl->access( 'mod-has_access:access' );
    $this->assertFalse( 'role has_dataset_access area: mod-has_access level: access returned true', $res );
    
    $res = $this->acl->access( 'mod-has_access:admin' );
    $this->assertFalse( 'role has_dataset_access area: mod-has_access level: admin returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:listing' );
    $this->assertFalse( 'role has_dataset_access area: mod-no_access level: listing returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:access' );
    $this->assertFalse( 'role has_dataset_access area: mod-no_access level: access returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:admin' );
    $this->assertFalse( 'role has_dataset_access area: mod-no_access level: admin returned true', $res );
    
    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->access( 'mod-has_access:listing', null, true );
    $this->assertTrue( 'role has_dataset_access area: mod-has_access, level: listing, check partial returned false', $res );

    $res = $this->acl->access( 'mod-has_access:access', null, true );
    $this->assertFalse( 'role has_dataset_access area: mod-has_access, level: access, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-has_access:admin', null, true );
    $this->assertFalse( 'role has_dataset_access area: mod-has_access, level: admin, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:listing', null, true );
    $this->assertFalse( 'role has_dataset_access area: mod-no_access, level: listing, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:access', null, true );
    $this->assertFalse( 'role has_dataset_access area: mod-no_access, level: access, check partial returned true', $res );
    
    $res = $this->acl->access( 'mod-no_access:admin', null, true );
    $this->assertFalse( 'role has_dataset_access area: mod-no_access, level: admin, check partial returned true', $res );
    
  }//end public function test_hasAcccess_UserDatasetAccess_RelationToArea */
  

  
} //end abstract class LibAclDb_AccessModule_Test

