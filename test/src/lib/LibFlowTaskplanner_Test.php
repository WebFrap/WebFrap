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
class LibFlowTaskplanner_Test extends LibTestUnit {
	public function setUp() {
	}
	public function test_first() {
		$flowTaskplanner = new LibFlowTaskplanner ();
		
		$test = <<<JSON
[
    {
        "key" : "a",
        "class" : "Backup",
        "method" : "happy",
		"inf" : "entity",
        "params":{
            "id" : "1
		"
        }
    }
]
JSON;
		$json = json_decode ( $test );
		$flowTaskplanner->tasks = $json;
		$flowTaskplanner->service_run();
	}
}