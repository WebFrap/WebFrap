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
class SParserString_Test
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
  public function test_arrayToComSepStr()
  {

    $expected = 'a, b, c';
    $data = array( 'a', 'b', 'c' );

    $this->assertSame( 'arrayToComSepStr failed', $expected, SParserString::arrayToComSepStr($data) );
    $this->assertSame( 'arrayToComSepStr empty failed', '', SParserString::arrayToComSepStr(array()) );

  }//end public function test_arrayToComSepStr */


} //end abstract class LibFormatString_Test

