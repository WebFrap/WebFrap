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
class HelloWorldA_Test
  extends LibTestUnit
{


  /**
   * (non-PHPdoc)
   * @see src/lib/test/LibTestUnit::setUp()
   */
  public function setUp()
  {

  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// access checks
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prüfen auf Access für user has_access
   */
  public function test_hello()
  {

    
    $this->assertFalse( 'False was not false?!', false );
    $this->assertFalse( 'Ok this should fail', true );
    $this->assertTrue( 'This should not fail', true );
    
  }//end public function test_hello */

  
} //end abstract class HelloWorld_Test

