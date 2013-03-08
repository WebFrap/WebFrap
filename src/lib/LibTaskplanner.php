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
class LibTaskplanner extends BaseChild {
	
	/**
	 * value from getdata
	 *
	 * @see http://php.net/manual/de/function.getdate.php
	 *
	 * @var array
	 */
	public $now = null;
	
	/**
	 * Die Typen der Tasks welche zu laden sind
	 *
	 * @param
	 *        	array
	 */
	public $taskTypes = array ();
	
	/**
	 * Liste der auszuführenden Tasks.
	 *
	 * @var array
	 */
	public $tasks = array ();
	
	/**
	 * Das Environment Objekt
	 *
	 * @var Base
	 */
	public $env = null;
	
	/**
	 *
	 * @param int:timestamp $now
	 */
	public function __construct($now = null, $env = null) {
		if ($env) {
			$this->env = $env;
		} else {
			$this->env = Webfrap::$env;
		}
		
		$this->load ( $now );
	} // end public function __construct */
	
	/**
	 * Initialisiert den Taskplanner entweder mit einem übergebenen oder dem aktuellen
	 * Timestamp.
	 * Je nach Timestamp werden dann die entsprechenden Tasks in das Array
	 * <code>$taskTypes</code> geladen.
	 *
	 * @param int:timestamp $now        	
	 */
	public function load($now = null) {
		if ($now) {
			$this->now = getdate ( $now );
		} else {
			//$this->now = time ();
			//$this->now = getdate ( $this->now );
			// Ohne Argument nimmt getdate() automatisch die aktuelle Zeit
			$this->now = getdate ( );
		}
				
		$this->taskTypes = $this->setupRequiredTasktypes ( $this->now );
		
		$this->tasks = $this->loadTypedTasks ( $this->taskTypes, date ( 'Y-m-d H:i:00', $now ) );
	}
	
	/**
	 * Bestimmt in Abhängigkeit von <code>$now</code> welche(r) Task(s) gestartet werden müssen.
	 * Tasks die zu den selben Zeitpunkten starten können, werden zeitversetzt gestartet.
	 *
	 * @param Timestamp $now        	
	 * @return Array $types
	 */
	public function setupRequiredTasktypes($now) {
		$seconds = $now ['seconds'];
		$minutes = $now ['minutes'];
		$hours = $now ['hours'];
		$weekDay = $now ['wday'];
		$monthDay = $now ['mday'];
		$yearDay = $now ['yday'];
		$year = $now ['year'];
		$month = $now ['mon'];
		
		$types = array ();
		
		// **:**:00, Jeden Tag
		if ($seconds == 0) {
			
			// ETaskType: Every minute
			$types [] = ETaskType::MINUTE;
			
			if ($minutes % 5 == 0) {
				// ETaskType: Every 5 minutes
				$types [] = ETaskType::MINUTE_5;
			}
			
			if ($minutes % 15 == 0) {
				// ETaskType: Every 15 minutes
				$types [] = ETaskType::MINUTE_15;
			}
			
			if ($minutes % 30 == 0) {
				// ETaskType: Every 30 minutes
				$types [] = ETaskType::MINUTE_30;
			}
		}
		
		// **:22, Jeden Tag
		if ($minutes == 22) {
			
			// ETaskType: Every hour
			$types [] = ETaskType::HOUR;
			
			if ($hours % 6 == 0) {
				// ETaskType: Every 6 hours
				$types [] = ETaskType::HOUR_6;
			}
			
			if ($hours % 12 == 0) {
				// ETaskType: Every 12 hours
				$types [] = ETaskType::HOUR_12;
			}
		}
		
		// 02:22, Jeden Tag
		if ($hours == 2 && $minutes == 22) {
			
			// ETaskType: Every day
			$types [] = ETaskType::DAY;
			
			if ($weekDay > 0 && $weekDay < 6) {
				// ETaskType: Every working day
				$types [] = ETaskType::WORK_DAY;
			}
			
			if ($weekDay == 0 || $weekDay == 6) {
				// ETaskType: Every weekend
				$types [] = ETaskType::WEEK_END;
			}
			
			// Mo alle 2 Wochen
			if ($weekDay == 1 && (($yearDay / 7) % 2) == 0) {
				// ETaskType: Every second week
				$types [] = ETaskType::WEEK_2;
			}
		}
		
		// 05:44
		if ($hours == 5 && $minutes == 44) {
			$lastDayOfMonth = SDate::getMonthDays ( $year, $month );
			
			// Jedes Quartal
			if ($monthDay == 1) {
				// ETaskType: Every month start
				$types [] = ETaskType::MONTH_START;
			} elseif ($monthDay == $lastDayOfMonth) {
				// ETaskType: Every month end
				$types [] = ETaskType::MONTH_END;
			}
			
			// 1. Tag des Monats, alle 3 Monate
			if ($monthDay == 1 && $month % 3 == 0) {
				// ETaskType: Every quater start
				$types [] = ETaskType::MONTH_3_START;
			} elseif ($monthDay == $lastDayOfMonth && $month % 3 == 0) {
				// ETaskType: Every quater end
				$types [] = ETaskType::MONTH_3_END;
			}
			
			// Jedes Halbjahr
			if ($monthDay == 1 && $month % 6 == 0) {
				// ETaskType: Every half year start
				$types [] = ETaskType::MONTH_6_START;
			} elseif ($monthDay == $lastDayOfMonth && $month % 6 == 0) {
				// ETaskType: Every half year end
				$types [] = ETaskType::MONTH_6_END;
			}
			
			// Jahresbeginn
			
			if ($monthDay == 1 && $month == 1) {
				// ETaskType: Every year start
				$types [] = ETaskType::YEAR_START;
			}
			
			// Jahredende
			if ($monthDay == $lastDayOfMonth && $month == 12) {
				// ETaskType: Every year end
				$types [] = ETaskType::YEAR_END;
			}
		}
		
		return $types;
	}
	
	/**
	 *
	 * @param array $status        	
	 * @param string $timeNow        	
	 */
	public function loadTypedTasks($status, $timeNow) {
		$whereType = implode ( ', ', $status );
		$whereStatus = ETaskStatus::OPEN;
				
		$db = $this->env->getDb ();
		
		$tCustom = ETaskType::CUSTOM;
		
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
    (
      task.type IN({$whereType})
        AND  plan.timestamp_start >= '{$timeNow}'
        AND plan.timestamp_end <= '{$timeNow}'
    )
    OR
    (
      task.type = {$tCustom}
        AND task.task_time = '{$timeNow}'
    )

SQL;
		
		return $db->select ( $sql )->getAll ();
	}
}

