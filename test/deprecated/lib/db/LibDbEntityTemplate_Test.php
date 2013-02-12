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
class LibDbEntityTemplate_Test
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

  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// test methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   */
  public function testExists()
  {

    $valName = 'name';

    $entity = $this->orm->newEntity('WbfsysTag');

    $this->assertInstance
    (
        'Expexted an instance of the class WbfsysTag_Entity',
        'WbfsysTag_Entity',
      $entity
    );

    $entity->name = $valName;
    $this->assertEquals('__set or __get on Attribute name failed', $valName, $entity->name);
    $this->assertEquals('__set or getData on Attribute name failed', $valName, $entity->getData('name'));
    $this->assertEquals('__set or getSecure on Attribute name failed', $valName, $entity->getSecure('name'));

  }//end public function testExists */

} //end abstract class LibDbEntityTest
