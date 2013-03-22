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
class LibFlowTaskplanner_Test extends LibTestUnit
{

  public function setUp ()
  {

  }

  public function test_first ()
  {

    $taskPlan = new LibTaskplanner(WebFrap::$env, 1395846000);
    
    $flow = new LibFlowTaskplanner();
    
    $orm = $this->getOrm();
    
    $title = "Testn";
    $action = '[{"key" : "start","class" : "Backup","method" : "happy","inf" : "entity","params":{"id" : "1" }}]';
    $flags = '{"flags":{"advanced":false,"by_day":false,"is_list":false},"trigger_time":"2013-03-23 00:00","months":[],"days":[],"hours":[],"minutes":[],"monthWeeks":[],"weekDays":[],"taskList":[],"type":0,"status":0}';
    $id = 230;
    
    $db = $this->getDb();
    
    $plan = <<<SQL
INSERT INTO wbfsys_task_plan (title, flag_series, series_rule, actions, id_user, timestamp_end, rowid)
VALUES (
        {$title},
        false,
        {$flags},
        {$action},
        8266134,
        {$id}
SQL;
    
    $db->insert($plan, 'wbfsys_task_plan', 'rowid');
  }
}