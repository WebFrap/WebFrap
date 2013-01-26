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
class LibProcess_Default_Test
  extends LibTestUnit
{

  /**
   * @var ProjectTask_Management_Process
   */
  protected $process = null;


  /**
   * (non-PHPdoc)
   * @see src/lib/test/LibTestUnit::setUp()
   */
  public function setUp()
  {

    $this->process = new ProjectTask_Management_Process();


  }//end public function setUp */


/*//////////////////////////////////////////////////////////////////////////////
// role tests
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testChecks()
  {

    $check = $this->process->edgeExists('node1', 'node2');
    $check2 = $this->process->edgeExists('node1', 'node1');

    $this->assertTrue("edgeExists('node1', 'node2') returned false", $check);
    $this->assertFalse("edgeExists('node1', 'node1') returned true", $check2);

  }//end public function testChecks */

  /**
   * voller zugriff erlaubt durch modulrechte
   */
  public function testTrigger1()
  {

    $this->process->setUserRoles( array( 'project_manager' ) );


    $check = false;
    try
    {
      $check = $this->process->trigger('node1', 'node2');
    }
    catch ( Exception $e )
    {
      $this->assertNoReach("Process throws exception ".$e->getMessage() );
    }


    $this->assertTrue("edgeExists('node1', 'node2') returned false", $check);

  }//end public function testChecks */

} //end abstract class LibProcess_Default_Test

