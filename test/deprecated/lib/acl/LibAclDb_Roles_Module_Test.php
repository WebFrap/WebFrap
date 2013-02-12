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
class LibAclDb_Roles_Module_Test
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
// hasRole tests
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Prüfen mit dem user: has_access
   * User hat Teilberechtigungen in Relation zu area
   */
  public function test_hasRole_UserAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->hasRole( 'has_access' );
    $this->assertFalse( 'hasRole has_access returned true', $res );

    // prüfen aif globale mitgliedschaft bei keiner vorhandenen mitgliedschaft
    $res = $this->acl->hasRole( 'has_no_access' );
    $this->assertFalse( 'hasRole has_no_access returned true', $res );
    
    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access' );
    $this->assertTrue( 'hasRole has_access area: mod-has_access returned false', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->hasRole( 'has_access', 'mod-has_no_access' );
    $this->assertFalse( 'hasRole has_access to area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->hasRole( 'has_access', 'mod-not_exists' );
    $this->assertFalse( 'hasRole has_access to area: mod-has_no_access  returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, 
    // keine mitgliedschaft in der gruppe, gruppe nicht mit area verbunden
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_access' );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, existierende area 
    $res = $this->acl->hasRole( 'not_exists', 'mod-has_access' );
    $this->assertFalse( 'hasRole not_exists to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, nicht existierende area 
    $res = $this->acl->hasRole( 'not_exists', 'mod-not_exists' );
    $this->assertFalse( 'hasRole not_exists to area: mod-not_exists  returned true', $res );
        
    // prüfung in relation zur area und einem datensatz
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden 
    // kein link zum datensatz berechtigung wird jedoch über area geerbt
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access', $textAccess );
    $this->assertTrue( 'hasRole has_access area: mod-has_access entity: text_access returned false', $res );

    // prüfen auf mitgliedschaft in relation zur area, keine mitgliedschaft, keine rechte
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_access', $textAccess );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_access entity: text_access returned true', $res );
    
  }//end public function test_hasRole_UserAccess_RelationToArea */

  
  /**
   * Prüfen mit dem user: has_no_access
   * Alle Security Checks müssen false zurückgeben
   */
  public function test_hasRole_UserNoAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_no_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->hasRole( 'has_access' );
    $this->assertFalse( 'hasRole has_access returned true', $res );

    // prüfen aif globale mitgliedschaft bei keiner vorhandenen mitgliedschaft
    $res = $this->acl->hasRole( 'has_no_access' );
    $this->assertFalse( 'hasRole has_no_access returned true', $res );
    
    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access' );
    $this->assertFalse( 'hasRole has_access area: mod-has_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->hasRole( 'has_access', 'mod-has_no_access' );
    $this->assertFalse( 'hasRole has_access to area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->hasRole( 'has_access', 'mod-not_exists' );
    $this->assertFalse( 'hasRole has_access to area: mod-has_no_access  returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, 
    // keine mitgliedschaft in der gruppe, gruppe nicht mit area verbunden
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_access' );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, existierende area 
    $res = $this->acl->hasRole( 'not_exists', 'mod-has_access' );
    $this->assertFalse( 'hasRole not_exists to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, nicht existierende area 
    $res = $this->acl->hasRole( 'not_exists', 'mod-not_exists' );
    $this->assertFalse( 'hasRole not_exists to area: mod-not_exists  returned true', $res );
        
    // prüfung in relation zur area und einem datensatz
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden 
    // kein link zum datensatz berechtigung wird jedoch über area geerbt
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access', $textAccess );
    $this->assertFalse( 'hasRole has_access area: mod-has_access entity: text_access returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, keine mitgliedschaft, keine rechte
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_access', $textAccess );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_access entity: text_access returned true', $res );
    
  }//end public function test_hasRole_UserNoAccess_RelationToArea */
  
  
  /**
   * Prüfen mit dem user: has_dataset_access
   * User hat Teilberechtigungen in Relation zum datensatz text_access
   */
  public function test_hasRole_UserDatasetAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_dataset_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->hasRole( 'has_access' );
    $this->assertFalse( 'hasRole has_access returned true', $res );

    // prüfen aif globale mitgliedschaft bei keiner vorhandenen mitgliedschaft
    $res = $this->acl->hasRole( 'has_no_access' );
    $this->assertFalse( 'hasRole has_no_access returned true', $res );
    
    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nur in relation zum datensatz text_access
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access' );
    $this->assertFalse( 'hasRole has_access area: mod-has_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->hasRole( 'has_access', 'mod-has_no_access' );
    $this->assertFalse( 'hasRole has_access to area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->hasRole( 'has_access', 'mod-not_exists' );
    $this->assertFalse( 'hasRole has_access to area: mod-has_no_access  returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, 
    // keine mitgliedschaft in der gruppe, gruppe nicht mit area verbunden
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_access' );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, existierende area 
    $res = $this->acl->hasRole( 'not_exists', 'mod-has_access' );
    $this->assertFalse( 'hasRole not_exists to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, nicht existierende area 
    $res = $this->acl->hasRole( 'not_exists', 'mod-not_exists' );
    $this->assertFalse( 'hasRole not_exists to area: mod-not_exists  returned true', $res );
        
    // prüfung in relation zur area und einem datensatz
    
    // prüfen auf mitgliedschaft in relation zum datensatz, ist die einzige vorhandene verknüpfung
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access', $textAccess );
    $this->assertTrue( 'hasRole has_access area: mod-has_access entity: text_access returned false', $res );

    // prüfen auf mitgliedschaft in relation zum datensatz, diese relation ist nicht vorhanden
    $res = $this->acl->hasRole( 'has_access', 'mod-has_access', $textNoAccess );
    $this->assertFalse( 'hasRole has_access to area: mod-has_access entity: text_no_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zum datensatz, keine relation vorhanden
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_access', $textAccess );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_access entity: text_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zum datensatz, keine relation vorhanden
    $res = $this->acl->hasRole( 'has_no_access', 'mod-has_no_access', $textAccess );
    $this->assertFalse( 'hasRole has_no_access to area: mod-has_no_access entity: text_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zum datensatz, rolle existiert nicht
    $res = $this->acl->hasRole( 'not_exists', 'mod-has_access', $textAccess );
    $this->assertFalse( 'hasRole not_exists to area: mod-has_access entity: text_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zum datensatz, area existiert nicht
    $res = $this->acl->hasRole( 'has_access', 'mod-not_exists', $textAccess );
    $this->assertFalse( 'hasRole has_access to area: mod-not_exists entity: text_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zum datensatz, weder rolle noch area existieren
    $res = $this->acl->hasRole( 'not_exists', 'mod-not_exists', $textAccess );
    $this->assertFalse( 'hasRole not_exists to area: mod-not_exists entity: text_access returned true', $res );
    
  }//end public function test_hasRole_UserDatasetAccess_RelationToArea */
  
/*//////////////////////////////////////////////////////////////////////////////
// hasRoleSomewhere tests
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Prüfen mit dem user: has_access
   * User hat Teilberechtigungen in Relation zu area
   */
  public function test_hasRoleSomewhere_UserAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->hasRoleSomewhere( 'has_access' );
    $this->assertTrue( 'hasRoleSomewhere has_access returned false', $res );

    // prüfen aif globale mitgliedschaft bei keiner vorhandenen mitgliedschaft
    $res = $this->acl->hasRoleSomewhere( 'has_no_access' );
    $this->assertFalse( 'hasRoleSomewhere has_no_access returned true', $res );
    
    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-has_access' );
    $this->assertTrue( 'hasRoleSomewhere has_access area: mod-has_access returned false', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-has_no_access' );
    $this->assertFalse( 'hasRoleSomewhere has_access to area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-not_exists' );
    $this->assertFalse( 'hasRoleSomewhere has_access to area: mod-has_no_access  returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, 
    // keine mitgliedschaft in der gruppe, gruppe nicht mit area verbunden
    $res = $this->acl->hasRoleSomewhere( 'has_no_access', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere has_no_access to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, existierende area 
    $res = $this->acl->hasRoleSomewhere( 'not_exists', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere not_exists to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, nicht existierende area 
    $res = $this->acl->hasRoleSomewhere( 'not_exists', 'mod-not_exists' );
    $this->assertFalse( 'hasRoleSomewhere not_exists to area: mod-not_exists  returned true', $res );

    
  }//end public function test_hasRoleSomewhere_UserAccess_RelationToArea */

  
  /**
   * Prüfen mit dem user: has_no_access
   * Alle Security Checks müssen false zurückgeben
   */
  public function test_hasRoleSomewhere_UserNoAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_no_access' );

    // prüfen auf globale mitgliedschaft bei nur relativer mitgliedschaft
    $res = $this->acl->hasRoleSomewhere( 'has_access' );
    $this->assertFalse( 'hasRoleSomewhere has_access returned true', $res );

    // prüfen aif globale mitgliedschaft bei keiner vorhandenen mitgliedschaft
    $res = $this->acl->hasRoleSomewhere( 'has_no_access' );
    $this->assertFalse( 'hasRoleSomewhere has_no_access returned true', $res );
    
    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere has_access area: mod-has_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-has_no_access' );
    $this->assertFalse( 'hasRoleSomewhere has_access to area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-not_exists' );
    $this->assertFalse( 'hasRoleSomewhere has_access to area: mod-has_no_access  returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, 
    // keine mitgliedschaft in der gruppe, gruppe nicht mit area verbunden
    $res = $this->acl->hasRoleSomewhere( 'has_no_access', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere has_no_access to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, existierende area 
    $res = $this->acl->hasRoleSomewhere( 'not_exists', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere not_exists to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, nicht existierende area 
    $res = $this->acl->hasRoleSomewhere( 'not_exists', 'mod-not_exists' );
    $this->assertFalse( 'hasRoleSomewhere not_exists to area: mod-not_exists  returned true', $res );

    
  }//end public function test_hasRoleSomewhere_UserNoAccess_RelationToArea */
  
  
  /**
   * Prüfen mit dem user: has_dataset_access
   * User hat Teilberechtigungen in Relation zum datensatz text_access
   */
  public function test_hasRoleSomewhere_UserDatasetAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_dataset_access' );

    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nur in relation zum datensatz text_access
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-has_access' );
    $this->assertTrue( 'hasRoleSomewhere has_access area: mod-has_access returned false', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-has_no_access' );
    $this->assertFalse( 'hasRoleSomewhere has_access to area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->hasRoleSomewhere( 'has_access', 'mod-not_exists' );
    $this->assertFalse( 'hasRoleSomewhere has_access to area: mod-has_no_access  returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, 
    // keine mitgliedschaft in der gruppe, gruppe nicht mit area verbunden
    $res = $this->acl->hasRoleSomewhere( 'has_no_access', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere has_no_access to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, existierende area 
    $res = $this->acl->hasRoleSomewhere( 'not_exists', 'mod-has_access' );
    $this->assertFalse( 'hasRoleSomewhere not_exists to area: mod-has_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in nicht vorhandener gruppe, nicht existierende area 
    $res = $this->acl->hasRoleSomewhere( 'not_exists', 'mod-not_exists' );
    $this->assertFalse( 'hasRoleSomewhere not_exists to area: mod-not_exists  returned true', $res );
   
    
  }//end public function test_hasRoleSomewhere_UserDatasetAccess_RelationToArea */
  
  
/*//////////////////////////////////////////////////////////////////////////////
// getRoles test
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prüfen mit dem user: has_access
   * User hat Teilberechtigungen in Relation zu area
   */
  public function test_getRoles_UserAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden
    $res = $this->acl->getRoles( 'mod-has_access' );
    $this->assertRolesEqual( 'getRoles area: mod-has_access returned wrong roles', $res, array('has_access') );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->getRoles( 'mod-has_no_access' );
    $this->assertEmpty( 'getRoles has_access to area: mod-has_no_access was not empty', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->getRoles( 'mod-not_exists' );
    $this->assertEmpty( 'getRoles area: mod-has_no_access was not empty', $res );


    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden 
    // kein link zum datensatz berechtigung wird jedoch über area geerbt
    $res = $this->acl->getRoles(  'mod-has_access', $textAccess );
    $this->assertRolesEqual( 'getRoles area: mod-has_access entity: text_access returned wrong roles', $res, array('has_access') );

    // prüfen auf mitgliedschaft in relation zur area auf eine entity die keine verbindung zu mod-has_access hat
    $res = $this->acl->getRoles( 'mod-has_access', $textNoAccess );
    $this->assertRolesEqual( 'getRoles area: mod-has_access entity: text_no_access was not empty', $res, array('has_access')  );
    
  }//end public function test_getRoles_UserAccess_RelationToArea */

  
  /**
   * Prüfen mit dem user: has_no_access
   * Alle Security Checks müssen false zurückgeben
   */
  public function test_getRoles_UserNoAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_no_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );


    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden
    $res = $this->acl->getRoles( 'mod-has_access' );
    $this->assertEmpty( 'getRoles area: mod-has_access returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->getRoles( 'mod-has_no_access' );
    $this->assertEmpty( 'getRoles area: mod-has_no_access  returned true', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->getRoles( 'mod-not_exists' );
    $this->assertEmpty( 'getRoles area: mod-has_no_access  returned true', $res );

    // prüfung in relation zur area und einem datensatz
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft vorhanden 
    // kein link zum datensatz berechtigung wird jedoch über area geerbt
    $res = $this->acl->getRoles(  'mod-has_access', $textAccess );
    $this->assertEmpty( 'getRoles area: mod-has_access entity: text_access returned true', $res );

    // prüfen auf mitgliedschaft in relation zur area, keine mitgliedschaft, keine rechte
    $res = $this->acl->getRoles( 'mod-has_access', $textNoAccess );
    $this->assertEmpty( 'getRoles area: mod-has_access entity: text_no_access returned true', $res );
    
  }//end public function test_getRoles_UserNoAccess_RelationToArea */
  
  
  /**
   * Prüfen mit dem user: has_dataset_access
   * User hat Teilberechtigungen in Relation zum datensatz text_access
   */
  public function test_getRoles_UserDatasetAccess_RelationToArea()
  {

    $this->user->switchUser( 'has_dataset_access' );
    
    $textAccess   = $this->db->orm->getByKey( 'WbfsysText', 'text_access' );
    $textNoAccess = $this->db->orm->getByKey( 'WbfsysText', 'text_no_access' );

    
    // prüfung in relation zur area
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nur in relation zum datensatz text_access
    $res = $this->acl->getRoles( 'mod-has_access' );
    $this->assertEmpty( 'getRoles area: mod-has_access was not empty', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, mitgliedschaft nicht vorhanden
    $res = $this->acl->getRoles( 'mod-has_no_access' );
    $this->assertEmpty( 'getRoles area: mod-has_no_access was not empty', $res );
    
    // prüfen auf mitgliedschaft in relation zur area, area existiert nicht
    $res = $this->acl->getRoles( 'mod-not_exists' );
    $this->assertEmpty( 'getRoles area: mod-has_no_access was not empty', $res );

        
    // prüfung in relation zur area und einem datensatz
    
    // prüfen auf mitgliedschaft in relation zum datensatz, ist die einzige vorhandene verknüpfung
    $res = $this->acl->getRoles( 'mod-has_access', $textAccess );
    $this->assertRolesEqual( 'getRoles area: mod-has_access entity: text_access returned wrong roles', $res, array('has_access') );

    // prüfen auf mitgliedschaft in relation zum datensatz, diese relation ist nicht vorhanden
    $res = $this->acl->getRoles( 'mod-has_access', $textNoAccess );
    $this->assertEmpty( 'getRoles area: mod-has_access entity: text_no_access was not empty', $res );

    // prüfen auf mitgliedschaft in relation zum datensatz, area existiert nicht
    $res = $this->acl->getRoles( 'mod-not_exists', $textAccess );
    $this->assertEmpty( 'getRoles area: mod-not_exists entity: text_access was not empty', $res );
    
    // prüfen auf mitgliedschaft in relation zum datensatz, weder rolle noch area existieren
    $res = $this->acl->getRoles( 'mod-not_exists', $textNoAccess );
    $this->assertEmpty( 'getRoles area: mod-not_exists entity: text_access was not empty', $res );
    
  }//end public function test_getRoles_UserDatasetAccess_RelationToArea */

  
} //end abstract class LibAclDb_RolesModule_Test

