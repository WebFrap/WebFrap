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
class LibDbCriteriaTest extends LibTestUnit
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

  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// test methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   */
  public function testInsert()
  {

    $orm = $this->db->getOrm();

    $insertCriteria = $orm->newCriteria();

    $insertCriteria->table('wbfsys_text')
      ->values(array
      (
        'access_key' => 'barfu',
        'content'    => 'some content'
      ));

    $entityNew = $orm->insert($insertCriteria);

    $this->assertInstance('Insert hat keine Entity zurückgegeben', 'Entity', $entityNew);

    $entity = $orm->get('WbfsysText',"access_key='barfu'");

    $this->assertInstance('Neuer Datensatz scheint nicht vorhanden zu sein', 'Entity', $entity);

    $this->assertEquals('Daten scheinen nicht geschrieben worden sein', $entity->content, 'some content'  );

  }//end public function testInsert */

  /**
   *
   * Enter description here ...
   */
  public function testUpdate()
  {

    $orm = $this->db->getOrm();

    try {

      $updateCriteria = $orm->newCriteria();

      $updateCriteria->table('wbfsys_text')
        ->values(array
        (
          'access_key' => 'fubar_new',
          'content'    => 'new content'
        ))
        ->where("access_key='barfu'");

      $num = $orm->update($updateCriteria);

      $this->assertEquals('Update hat mehr oder weniger als einen eintrag geändert', 1, $num);

      $entity = $orm->get('WbfsysText',"access_key='fubar_new'");

      $this->assertInstance('Neuer Datensatz scheint nicht vorhanden zu sein', 'Entity', $entity);

      $this->assertEquals('Daten scheinen nicht geschrieben worden sein', $entity->content, 'new content'  );

    } catch (LibDb_Exception $e) {
      $this->assertNoReach('Update has thrown Exception '.$e->getMessage());
    }

  }//end public function testUpdate */

  /**
   *
   * Enter description here ...
   */
  public function testDelete()
  {

    $orm = $this->db->getOrm();

    $deleteCriteria = $orm->newCriteria();

    $deleteCriteria->table('wbfsys_text')
      ->where("access_key='fubar_new'");

    // should return the affected rows
    $num = $orm->delete($deleteCriteria);

    $this->assertEquals('Delete mehr oder weniger als einen Eintrag gelöscht', 1, $num);

  }//end public function testDelete */

} //end abstract class LibDbCriteriaTest

