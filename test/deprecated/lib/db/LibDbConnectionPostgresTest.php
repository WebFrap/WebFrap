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
class LibDbConnectionPostgresTest extends LibTestUnit
{

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
  public function testDummy()
  {

  }//end public function testDummy */

} //end abstract class LibDbOrmTest

