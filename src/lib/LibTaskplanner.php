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
 * Taskplanner
 *
 * @package WebFrap
 * @subpackage taskplanner
 */
class LibTaskplanner extends BaseChild
{

  /**
	 * Aktueller Unix Timestamp
	 *
	 * @var int
	 */
  public $currentTimestamp = null;

  /**
	 * Aktuelles Datum als Array
	 *
	 * @var array
	 */
  public $currentDate = null;

  /**
	 * Die Typen der Tasks welche zu laden sind. Siehe ETaskType
	 *
	 * @var	array
	 */
  public $taskTypes = array();

  /**
	 * Liste der auszuführenden Tasks.
	 *
	 * @var array
	 */
  public $tasks = null;

  /**
	 * Das Environment Objekt
	 *
	 * @var LibFlowApachemod
	 */
  public $env = null;

  /**
	 * Konstruktor.
	 * @param LibFlowApachemod $env
	 * @param int $currentTimestamp Timestamp
	 */
  public function __construct ($env = null, $currentTimestamp = null)
  {

    if ($env) {
      $this->env = $env;
    } else {
      $this->env = Webfrap::$env;
    }
    
    if ($currentTimestamp) {
      $this->currentTimestamp = $currentTimestamp;
    } else {
      $this->currentTimestamp = time();
    }
    
    $this->load();
  }

  /**
	 * Initialisiert den Taskplanner und ermittelt welche Typen von Tasks laufen sollen.
	 *
	 * @param int $currentTimestamp Timestamp
	 */
  public function load ()
  {

    $this->currentDate = getdate($this->currentTimestamp);
    
    $this->taskTypes = $this->setupRequiredTasktypes($this->currentDate);
    
    $this->tasks = $this->loadTypedTasks($this->taskTypes, date('Y-m-d H:i:00', $this->currentTimestamp));
  }

  /**
	 * Bestimmt in Abhängigkeit von <code>$currentDate</code> welche Typen von Tasks gestartet werden müssen.
	 * Tasks die zu den selben Zeitpunkten starten können, werden zeitversetzt gestartet.
	 *
	 * @param int $currentDate Timestamp
	 * @return array $types
	 */
  public function setupRequiredTasktypes ($currentDate)
  {

    $minutes = $currentDate['minutes'];
    $hours = $currentDate['hours'];
    $weekDay = $currentDate['wday'];
    $monthDay = $currentDate['mday'];
    $yearDay = $currentDate['yday'];
    $year = $currentDate['year'];
    $month = $currentDate['mon'];
    
    $types = array();
    
    // Die Tasks im Bereich von Minuten können zu jeder Sekunde laufen. 
    // Damit können verzögerungen besser ausgeglichen werden und $types ist niemals leer.
    

    // ETaskType: Every minute
    $types[] = ETaskType::MINUTE;
    
    // ETaskType: Every 5 minutes
    if ($minutes % 5 == 0) {
      $types[] = ETaskType::MINUTE_5;
    }
    
    // ETaskType: Every 15 minutes
    if ($minutes % 15 == 0) {
      $types[] = ETaskType::MINUTE_15;
    }
    
    // ETaskType: Every 30 minutes
    if ($minutes % 30 == 0) {
      $types[] = ETaskType::MINUTE_30;
    }
    
    // **:11:**, Jeden Tag
    if ($minutes == 11) {
      
      // ETaskType: Every hour
      $types[] = ETaskType::HOUR;
      
      // ETaskType: Every 6 hours
      if ($hours % 6 == 0) {
        $types[] = ETaskType::HOUR_6;
      }
      
      // ETaskType: Every 12 hours
      if ($hours % 12 == 0) {
        $types[] = ETaskType::HOUR_12;
      }
    }
    
    // 02:22:**, Jeden Tag
    if ($hours == 2 && $minutes == 22) {
      
      // ETaskType: Every day
      $types[] = ETaskType::DAY;
      
      // ETaskType: Every working day
      if ($weekDay > 0 && $weekDay < 6) {
        $types[] = ETaskType::WORK_DAY;
      }
      
      // ETaskType: Every weekend
      if ($weekDay == 0 || $weekDay == 6) {
        $types[] = ETaskType::WEEK_END;
      }
      
      // Mo alle 2 Wochen
      // ETaskType: Every second week
      if ($weekDay == 1 && (($yearDay / 7) % 2) == 0) {
        $types[] = ETaskType::WEEK_2;
      }
    }
    
    // 05:33:**
    if ($hours == 5 && $minutes == 33) {
      $lastDayOfMonth = SDate::getMonthDays($year, $month);
      
      $lastWeekdayOfMonth = date('N', strtotime(date($year . '-' . $month . '-' . $lastDayOfMonth)));
      
      $easter = getdate(easter_date());
      $karfreitag = $easter['mday'] - 2;
      
      if ($lastWeekdayOfMonth == 6) {
        $lastWorkingDay = $lastDayOfMonth - 1;
      } elseif ($lastWeekdayOfMonth == 7) {
        $lastWorkingDay = $lastDayOfMonth - 2;
        if ($lastWorkingDay == $karfreitag && $month == $easter['mon']) {
          $lastWorkingDay --;
        }
      } else {
        $lastWorkingDay = $lastDayOfMonth;
      }
      
      if ($monthDay == $lastWorkingDay) {
        $types[] = ETaskType::MONTH_END_WORKDAY;
      }
      
      // Jedes Quartal
      if ($monthDay == 1) {
        // ETaskType: Every month start
        $types[] = ETaskType::MONTH_START;
      } elseif ($monthDay == $lastDayOfMonth) {
        // ETaskType: Every month end
        $types[] = ETaskType::MONTH_END;
      }
      
      // 1. Tag des Monats, alle 3 Monate
      if ($monthDay == 1 && $month % 3 == 0) {
        // ETaskType: Every quater start
        $types[] = ETaskType::MONTH_3_START;
      } elseif ($monthDay == $lastDayOfMonth && $month % 3 == 0) {
        // ETaskType: Every quater end
        $types[] = ETaskType::MONTH_3_END;
      }
      
      // Jedes Halbjahr
      if ($monthDay == 1 && $month % 6 == 0) {
        // ETaskType: Every half year start
        $types[] = ETaskType::MONTH_6_START;
      } elseif ($monthDay == $lastDayOfMonth && $month % 6 == 0) {
        // ETaskType: Every half year end
        $types[] = ETaskType::MONTH_6_END;
      }
      
      // Jahresbeginn
      

      if ($monthDay == 1 && $month == 1) {
        // ETaskType: Every year start
        $types[] = ETaskType::YEAR_START;
      }
      
      // Jahredende
      if ($monthDay == $lastDayOfMonth && $month == 12) {
        // ETaskType: Every year end
        $types[] = ETaskType::YEAR_END;
      }
    }
    
    return $types;
  }

  /**
	 * Ermittelt die zum Zeitpunkt <code>$currentDate</code> zu startenden Tasks.
	 * @param array $taskTypes ETaskType
	 * @param array $currentDate
	 * @return array
	 */
  public function loadTypedTasks ($taskTypes, $currentDate)
  {

    $whereType = implode(', ', $taskTypes);
    
    $whereStatus = ETaskStatus::OPEN;
    
    $tCustom = ETaskType::CUSTOM;
    
    $db = $this->getDb();
    
    $sql = <<<SQL
SELECT
  plan.rowid as plan_id,
  plan.actions as plan_actions,
  task.rowid as task_id,
  task.actions as task_actions

FROM
  wbfsys_task_plan as plan

JOIN
  wbfsys_planned_task task
    ON plan.rowid = task.vid

WHERE
    task.status = {$whereStatus}
    AND
	(
		task.type IN({$whereType})
		AND '{$currentDate}' BETWEEN plan.timestamp_start AND plan.timestamp_end
	)
	OR
	(
		task.type = {$tCustom}
		AND task.task_time = '{$currentDate}'
     )
SQL;
    
    return $db->select($sql)->getAll();
  }
}