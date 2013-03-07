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
 *
 * @package WebFrapUnit
 * @subpackage WebFrap
 */
class LibTaskplanner_Test extends LibTestUnit {
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see src/lib/test/LibTestUnit::setUp()
	 */
	public function setUp() {
	} // end public function setUp */
	
	/*
	 * ////////////////////////////////////////////////////////////////////////////// // access checks //////////////////////////////////////////////////////////////////////////////
	 */
	
	/**
	 * Single Tasks finden
	 */
	public function test_findSingleTask() {
		// 00:00, 31.12.2013
		$taskplanner = new LibTaskplanner ( 1362580200 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MINUTE_5,
				ETaskType::MINUTE_15,
				ETaskType::MINUTE_30 
		);
		
		$this->assertEquals ( "00:00, 31.12.2013", $result, $expectedResult );
		
		// 06.03.2013 12:22:00
		$taskplanner = new LibTaskplanner ( 1362568920 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::HOUR,
				ETaskType::HOUR_6,
				ETaskType::HOUR_12 
		);
		
		$this->assertEquals ( "06.03.2013 12:22:00", $result, $expectedResult );
		
		// 22.03.2013 02:22:00
		$taskplanner = new LibTaskplanner ( 1363915320 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::HOUR,
				ETaskType::DAY,
				ETaskType::WORK_DAY 
		);
		
		$this->assertEquals ( "22.03.2013 02:22:00", $result, $expectedResult );
		
		// 03.03.2013 02:22:00
		$taskplanner = new LibTaskplanner ( 1362273720 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::HOUR,
				ETaskType::DAY,
				ETaskType::WEEK_END 
		);
		
		$this->assertEquals ( "03.03.2013 02:22:00", $result, $expectedResult );
		
		// 06.05.2013 02:22:00
		$taskplanner = new LibTaskplanner ( 1363915320 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::HOUR,
				ETaskType::DAY,
				ETaskType::WORK_DAY 
		);
		
		$this->assertEquals ( "06.05.2013 02:22:00", $result, $expectedResult );
		
		// 18.03.2013 02:22:00
		$taskplanner = new LibTaskplanner ( 1363569720 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::HOUR,
				ETaskType::DAY,
				ETaskType::WORK_DAY,
				ETaskType::WEEK_2 
		);
		
		$this->assertEquals ( "18.03.2013 02:22:00", $result, $expectedResult );
		
		// 01.02.2013 05:44:00
		$taskplanner = new LibTaskplanner ( 1359693840 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MONTH_START 
		);
		
		$this->assertEquals ( "01.02.2013 05:44:00", $result, $expectedResult );
		
		// 28.02.2013 05:44:00
		$taskplanner = new LibTaskplanner ( 1362026640 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MONTH_END 
		);
		
		$this->assertEquals ( "28.02.2013 05:44:00", $result, $expectedResult );
		
		// 01.06.2013 05:44:00
		$taskplanner = new LibTaskplanner ( 1370058240 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MONTH_START,
				ETaskType::MONTH_3_START,
				ETaskType::MONTH_6_START 
		);
		
		$this->assertEquals ( "01.06.2013 05:44:00", $result, $expectedResult );
		
		// 30.06.2013 05:44:00
		$taskplanner = new LibTaskplanner ( 1372563840 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MONTH_END,
				ETaskType::MONTH_3_END,
				ETaskType::MONTH_6_END 
		);
		
		$this->assertEquals ( "30.06.2013 05:44:00", $result, $expectedResult );
		
		// 01.01.2013 05:44:00
		$taskplanner = new LibTaskplanner ( 1357015440 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MONTH_START,
				ETaskType::YEAR_START 
		);
		
		$this->assertEquals ( "01.01.2013 05:44:00", $result, $expectedResult );
		
		// 31.12.2013 05:44:00
		$taskplanner = new LibTaskplanner ( 1388465040 );
		$result = $taskplanner->taskTypes;
		$expectedResult = array (
				ETaskType::MINUTE,
				ETaskType::MONTH_END,
				ETaskType::MONTH_3_END,
				ETaskType::MONTH_6_END,
				ETaskType::YEAR_END 
		);
		
		$this->assertEquals ( "31.12.2013 05:44:00", $result, $expectedResult );
	}
}

