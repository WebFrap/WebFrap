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
class LibAclDbCriteria_Test extends LibTestUnit
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
   * @var LibAclFile
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
    $this->acl->setUser($this->user);
    $this->acl->setDb($this->db);

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

    // clear the cache
    $orm->clearCache();

    // some data
    $text1 = new WbfsysText_Entity;
    $text1->access_key = 'text_1';
    $orm->insert($text1);

    $text2 = new WbfsysText_Entity;
    $text2->access_key = 'text_2';
    $orm->insert($text2);

    $text3 = new WbfsysText_Entity;
    $text3->access_key = 'text_3';
    $orm->insert($text3);

    $text4 = new WbfsysText_Entity;
    $text4->access_key = 'text_4';
    $orm->insert($text4);

    $text5 = new WbfsysText_Entity;
    $text5->access_key = 'text_5';
    $orm->insert($text5);

    // group roles
    $group1 = new WbfsysRoleGroup_Entity;
    $group1->name       = 'Group 1';
    $group1->access_key = 'group_1';
    $group1->level      = 0;
    $orm->insert($group1);

    $group2 = new WbfsysRoleGroup_Entity;
    $group2->name       = 'Group 2';
    $group2->access_key = 'group_2';
    $group2->level      = 0;
    $orm->insert($group2);

    $group3 = new WbfsysRoleGroup_Entity;
    $group3->name       = 'Group 3';
    $group3->access_key = 'group_3';
    $group3->level      = 0;
    $orm->insert($group3);

    $group4 = new WbfsysRoleGroup_Entity;
    $group4->name       = 'Group 4';
    $group4->access_key = 'group_4';
    $group4->level      = 0;
    $orm->insert($group4);

    $group5 = new WbfsysRoleGroup_Entity;
    $group5->name       = 'Group 5';
    $group5->access_key = 'group_5';
    $group5->level      = 0;
    $orm->insert($group5);

    // user roles
    $user1 = new WbfsysRoleUser_Entity;
    $user1->name  = 'user_1';
    $user1->level = 0;
    $orm->insert($user1);

    $user2 = new WbfsysRoleUser_Entity;
    $user2->name  = 'user_2';
    $user2->level = 0;
    $orm->insert($user2);

    $user3 = new WbfsysRoleUser_Entity;
    $user3->name  = 'user_3';
    $user3->level = 0;
    $orm->insert($user3);

    // area
    $areaMod1 = new WbfsysSecurityArea_Entity;
    $areaMod1->access_key       = 'mod-1';
    $areaMod1->id_level_access  = 100;
    $areaMod1->id_level_insert  = 100;
    $areaMod1->id_level_update  = 100;
    $areaMod1->id_level_delete  = 100;
    $areaMod1->id_level_admin   = 100;
    $orm->insert($areaMod1);

    $areaMod2 = new WbfsysSecurityArea_Entity;
    $areaMod2->access_key       = 'mod-2';
    $areaMod2->id_level_access  = 100;
    $areaMod2->id_level_insert  = 100;
    $areaMod2->id_level_update  = 100;
    $areaMod2->id_level_delete  = 100;
    $areaMod2->id_level_admin   = 100;
    $orm->insert($areaMod2);

    // access
    $access1 = new WbfsysSecurityAccess_Entity;
    $access1->id_group  = $group1;
    $access1->id_area   = $areaMod1;
    $access1->access_level  = 2;
    $orm->insert($access1);

    $access2 = new WbfsysSecurityAccess_Entity;
    $access2->id_group  = $group2;
    $access2->id_area   = $areaMod2;
    $access2->access_level  = 1;
    $orm->insert($access2);

    $access3 = new WbfsysSecurityAccess_Entity;
    $access3->id_group  = $group3;
    $access3->id_area   = $areaMod2;
    $access3->access_level  = 4;
    $orm->insert($access3);

    $access4 = new WbfsysSecurityAccess_Entity;
    $access4->id_group  = $group4;
    $access4->id_area   = $areaMod2;
    $access4->access_level  = 1;
    $orm->insert($access4);

    $access5 = new WbfsysSecurityAccess_Entity;
    $access5->id_group  = $group5;
    $access5->id_area   = $areaMod2;
    $access5->access_level  = 4;
    $orm->insert($access5);

    // groupusers
    // user only has access to text1, text2 and text5
    $orm->import
    (
      'WbfsysGroupUsers',
      array(
        array
        (
          'id_user'   =>  $user1,
          'id_group'  =>  $group1,
          'id_area'   =>  $areaMod1,
          'vid'       =>  $text1
        ),
        array
        (
          'id_user'   =>  $user1,
          'id_group'  =>  $group1,
          'id_area'   =>  $areaMod1,
          'vid'       =>  $text2
        ),
        array
        (
          'id_user'   =>  $user1,
          'id_group'  =>  $group1,
          'id_area'   =>  $areaMod1,
          'vid'       =>  $text5
        ),

        array
        (
          'id_user'   =>  $user2,
          'id_group'  =>  $group3,
          'id_area'   =>  $areaMod2
        ),
        array
        (
          'id_user'   =>  $user2,
          'id_group'  =>  $group2,
          'id_area'   =>  $areaMod2,
          'vid'       =>  $text1
        ),
        array
        (
          'id_user'   =>  $user2,
          'id_group'  =>  $group2,
          'id_area'   =>  $areaMod2,
          'vid'       =>  $text5
        ),

        array
        (
          'id_user'   =>  $user3,
          'id_group'  =>  $group4,
          'id_area'   =>  $areaMod2,
          'vid'       =>  $text1
        ),
        array
        (
          'id_user'   =>  $user3,
          'id_group'  =>  $group5,
          'id_area'   =>  $areaMod2,
          'vid'       =>  $text2
        ),
        array
        (
          'id_user'   =>  $user3,
          'id_group'  =>  $group5,
          'id_area'   =>  $areaMod2,
          'vid'       =>  $text5
        ),
      )
    );

  }//end protected function populateDatabase */

/*//////////////////////////////////////////////////////////////////////////////
// role tests
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testInject1()
  {

    $this->user->switchUser('user_1');

    $orm        = $this->db->orm;

    $ids        = $orm->getIds('WbfsysText');

    $criteria = $orm->newCriteria();

    $criteria->select(array(
    'wbfsys_text.access_key',
    ))->from('wbfsys_text');

    $this->acl->injectAcls($criteria,'mod-1');

    $data = $orm->select($criteria)->getAll();

    $this->assertEquals('Es wurden 3 Datensätze erwartet', 3, count($data));

  }//end public function testAccessModule */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testInject2()
  {

    $this->user->switchUser('user_2');

    $orm        = $this->db->orm;

    $ids        = $orm->getIds('WbfsysText');

    $criteria = $orm->newCriteria();

    $criteria->select(array(
    'wbfsys_text.access_key',
    ))->from('wbfsys_text');

    $this->acl->injectAcls($criteria,'mod-2');

    $data = $orm->select($criteria)->getAll();

    $this->assertEquals('Es wurden 5 Datensätze erwartet', 5, count($data));

  }//end public function testAccessModule */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testInject3()
  {

    $this->user->switchUser('user_3');

    $orm        = $this->db->orm;

    $ids        = $orm->getIds('WbfsysText');

    $criteria = $orm->newCriteria();

    $criteria->select(array(
    'wbfsys_text.access_key',
    ))->from('wbfsys_text');

    $this->acl->injectAcls($criteria,'mod-2');

    $data = $orm->select($criteria)->getAll();

    $this->assertEquals('Es wurden 3 Datensätze erwartet', 3, count($data));

  }//end public function testAccessModule */

} //end abstract class LibAclDbCriteria_Test

