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
class SDate_Test
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
  public function test_isLeapYear()
  {

    $leapYears = array( 400, 1200, 2000, 1996, 1984 );
    $noLeapYears = array( 200, 2003, 1900, 2001 );

    foreach( $leapYears as $year )
    {
      $this->assertTrue( 'Leapyear check for '.$year.' failed', SDate::isLeapYear($year) );
    }

    foreach( $noLeapYears as $year )
    {
      $this->assertFalse( 'Leapyear check for '.$year.' failed', SDate::isLeapYear($year) );
    }

  }//end public function test_isLeapYear */


} //end abstract class SDate_Test

