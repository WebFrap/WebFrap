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
class LibDbOrmGetPathTest
  extends LibTestUnit
{

  /**
   * the orm object
   * @var LibDbOrm
   */
  protected $orm = null;

  /**
   * the db connection object
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * (non-PHPdoc)
   * @see src/lib/test/LibTestUnit::setUp()
   */
  public function setUp()
  {

    $this->db = Db::connection('test');
    $this->orm = $this->db->getOrm();

    $this->orm->cleanResource( 'WbfsysRoleUser' );
    $this->orm->cleanResource( 'ProjectProject' );
    $this->orm->cleanResource( 'ProjectTask' );
    $this->orm->cleanResource( 'ProjectTaskUser' );

    // benutzer rolle anlegen
    $wbfsysRoleUser = $this->orm->newEntity( 'WbfsysRoleUser' );
    $wbfsysRoleUser->name = 'User 1';
    $this->orm->insert( $wbfsysRoleUser );

    $wbfsysRoleUser2 = $this->orm->newEntity( 'WbfsysRoleUser' );
    $wbfsysRoleUser2->name = 'User 2';
    $this->orm->insert( $wbfsysRoleUser2 );

    // projekt rolle anlegen
    $projectEntity = $this->orm->newEntity( 'ProjectProject' );
    $projectEntity->name = 'Project 1';
    $this->orm->insert( $projectEntity );

    // tass anlegen
    $projectTask = $this->orm->newEntity( 'ProjectTask' );
    $projectTask->title = 'Task 1';
    $projectTask->id_project = $projectEntity;
    $this->orm->insert( $projectTask );

    $projectTask2 = $this->orm->newEntity( 'ProjectTask' );
    $projectTask2->title = 'Task 2';
    $projectTask2->id_project = $projectEntity;
    $this->orm->insert( $projectTask2 );

    // benutzer task anlegen
    $projectTaskUser = $this->orm->newEntity( 'ProjectTaskUser' );
    $projectTaskUser->id_task = $projectTask;
    $projectTaskUser->id_user = $wbfsysRoleUser;
    $this->orm->insert( $projectTaskUser );

    $projectTaskUser2 = $this->orm->newEntity( 'ProjectTaskUser' );
    $projectTaskUser2->id_task = $projectTask;
    $projectTaskUser2->id_user = $wbfsysRoleUser2;
    $this->orm->insert( $projectTaskUser2 );

    $projectTaskUser3 = $this->orm->newEntity( 'ProjectTaskUser' );
    $projectTaskUser3->id_task = $projectTask2;
    $projectTaskUser3->id_user = $wbfsysRoleUser;
    $this->orm->insert( $projectTaskUser3 );

    $projectTaskUser4 = $this->orm->newEntity( 'ProjectTaskUser' );
    $projectTaskUser4->id_task = $projectTask2;
    $projectTaskUser4->id_user = $wbfsysRoleUser2;
    $this->orm->insert( $projectTaskUser4 );

  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// test methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Testen ob der Pfad funktioniert
   */
  public function test_Path1()
  {

    $path = 'id_user:project_task_user/id_task:project_task/id_project:project_project';

    try {
      $user = $this->orm->get( 'WbfsysRoleUser', "name='User 1'" );

      $projectProject = $this->orm->getByPath( $path, $user );

      $this->assertEquals( 'Hatte 1 Projekt erwartet, aber '.count($projectProject).' bekommen ' , 1, count($projectProject) );
      $projectProject = current($projectProject);
      $this->assertEquals( 'Pathloading failed', 'Project 1', $projectProject->name );
    } catch ( Exception $e ) {
      $this->assertNoReach( $e->getMessage() );
    }

  }//end public function test_Path1 */

  /**
   * Testen ob der Pfad funktioniert
   */
  public function test_Path2()
  {

    $path = 'id_user:project_task_user/id_task:project_task/id_project:project_project';

    try {
      $user = $this->orm->get( 'WbfsysRoleUser', "name='User 2'" );

      $projectProject = $this->orm->getByPath( $path, $user );

      $this->assertEquals( 'Hatte 1 Projekt erwartet, aber '.count($projectProject).' bekommen ' , 1, count($projectProject) );
      $projectProject = current($projectProject);
      $this->assertEquals( 'Pathloading failed', 'Project 1', $projectProject->name );
    } catch ( Exception $e ) {
      $this->assertNoReach( $e->getMessage() );
    }

  }//end public function test_Path2 */

  /**
   * Testen ob der Pfad funktioniert
   */
  public function test_Path3()
  {

    $path = 'id_user:project_task_user/id_task:project_task';

    try {
      $user = $this->orm->get( 'WbfsysRoleUser', "name='User 2'" );

      $projectTasks = $this->orm->getByPath( $path, $user );

      $this->assertEquals( 'Hatte 2 Tasks erwartet, aber '.count($projectTasks).' bekommen ' , 2, count($projectTasks) );
    } catch ( Exception $e ) {
      $this->assertNoReach( $e->getMessage() );
    }

  }//end public function test_Path3 */

} //end abstract class LibDbOrmTest
