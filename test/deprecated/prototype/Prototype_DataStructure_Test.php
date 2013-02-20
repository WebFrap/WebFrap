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
class Prototype_Entity_Test extends LibTestUnit
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das Datenbank Objekt der Test Verbindung
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * Das Response Objet für den Zugriff auf die Consolen Ausgabe
   * @var LibResponseHttp
   */
  protected $response = null;

/*//////////////////////////////////////////////////////////////////////////////
// setup & close down
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/lib/test/LibTestUnit::setUp()
   */
  public function setUp()
  {

    $this->db       = Db::getActive();
    $this->response = Response::getActive();

  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// Test Methodes
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
    $this->assertTrue('hasRole test_annon returned false',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test' );
    $this->assertTrue('hasRole test_annon returned false',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test', $textTest );
    $this->assertTrue('hasRole test_annon for text test returned false',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test', $textSecret );
    $this->assertTrue('hasRole test_annon text secret  returned false',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2' );
    $this->assertTrue('hasRole test_annon returned false',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2', $textTest );
    $this->assertTrue('hasRole test_annon for text test returned false',$res);

    $res = $this->acl->hasRole( 'test_annon', 'mod-test_2', $textSecret );
    $this->assertTrue('hasRole test_annon text secret  returned false',$res);

    $res = $this->acl->hasRole( 'fubar' );
    $this->assertFalse('hasRole fubar returned true',$res);

  }//end public function testAccessModule */

} //end class Prototype_Entity_Test

