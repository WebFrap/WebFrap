<?php
abstract class TimeHandler {
	
	/**
	 *
	 * @var int
	 */
	const CUSTOM = 0;
	
	/**
	 *
	 * @var int
	 */
	const MINUTE = 1;
	
	/**
	 *
	 * @var int
	 */
	const MINUTE_5 = 2;
	
	/**
	 *
	 * @var int
	 */
	const MINUTE_15 = 4;
	
	/**
	 *
	 * @var int
	 */
	const MINUTE_30 = 5;
	
	/**
	 *
	 * @var int
	 */
	const HOUR = 6;
	
	/**
	 *
	 * @var int
	 */
	const HOUR_6 = 7;
	
	/**
	 *
	 * @var int
	 */
	const HOUR_12 = 8;
	
	/**
	 *
	 * @var int
	 */
	const WORK_DAY = 9;
	
	/**
	 *
	 * @var int
	 */
	const WEEK_END = 10;
	
	/**
	 *
	 * @var int
	 */
	const DAY = 11;
	
	/**
	 *
	 * @var int
	 */
	const WEEK_2 = 12;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_START = 13;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_END = 14;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_3_START = 15;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_3_END = 16;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_6_START = 17;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_6_END = 18;
	
	/**
	 *
	 * @var int
	 */
	const YEAR_START = 19;
	
	/**
	 *
	 * @var int
	 */
	const YEAR_END = 20;
	
	/**
	 *
	 * @var int
	 */
	const MONTH_END_WORKDAY = 21;
	private $rules = null;
	private $minuteHandler = null;
	private $hourHandler = null;
	public function checkTime($timestamp) {
	}
}
class MinuteHandler extends TimeHandler {
	public function __construct($rules) {
		$this->rules = $rules;
	}
	public function checkTime($time) {
		$minutes = $time ['minutes'];
		
		foreach ( $this->rules as $rule => $result ) {
			
			if ($rule == 0) {
				echo 'Now: ' . $time ['hours'] . ':' . $time ['minutes'] . '<br>';
				echo 'every minute <br>';
			} else {
				
				if ($minutes % $rule == 0) {
					echo 'Now: ' . $time ['hours'] . ':' . $time ['minutes'] . '<br>';
					echo 'Event: ' . $this->rules [$rule] . ' <br>';
				}
			}
		}
	}
}
class HourHandler extends TimeHandler {
	public function __construct($rules) {
		$this->rules = $rules;
	}
	public function checkTime($time) {
		$minutes = $time ['minutes'];
		$hours = $time ['hours'];
		
		foreach ( $this->rules as $rule => $result ) {
			if ($rule == 0) {
				echo 'Now: ' . $time ['hours'] . ':' . $time ['minutes'] . '<br>';
				echo 'Event every hour <br>';
			} else {
				
				if ($hours % $rule == 0 && $minutes == 15) {
					echo 'Now: ' . $time ['hours'] . ':' . $time ['minutes'] . '<br>';
					echo 'Event: ' . $this->rules [$rule] . ' <br>';
				}
			}
		}
	}
}
class DayHandler extends TimeHandler {
	public function __construct($rules) {
		$this->rules = $rules;
	}
	public function checkTime($time) {
		$minutes = $time ['minutes'];
		$hours = $time ['hours'];
		$day = $time ['wday'];
		
		if ($hours == 4 && $minutes == 22) {
			foreach ( $this->rules as $rule => $result ) {
				if ($day == $rule) {
					var_dump ( $time );
					echo 'Now: ' . $time ['hours'] . ':' . $time ['minutes'] . '<br>';
					echo 'Event: ' . $this->rules [$rule] . ' <br>';
				}
			}
		}
	}
}
class CusomTimeHandler extends TimeHandler {
	public function __construct() {
	}
	public function checkTime($time) {
		$minutes = $time ['minutes'];
		$hours = $time ['hours'];
		$day = $time ['wday'];
		$month = $time ['mon'];
		$year = $time ['year'];
		
		$weekDay = $time ['wday'];
		$monthDay = $time ['mday'];
		$yearDay = $time ['yday'];
		
		// 02:22:**, Jeden Tag
		if ($hours == 2 && $minutes == 22) {
			// Mo alle 2 Wochen
			// ETaskType: Every second week
			if ($weekDay == 1 && (($yearDay / 7) % 2) == 0) {
				$types [] = ETaskType::WEEK_2;
			}
		}
		
		// 05:33:**
		if ($hours == 5 && $minutes == 33) {
			$lastDayOfMonth = date('t', mktime( 0, 0, 0, $month, 1,  $year));
			
			$lastWeekdayOfMonth = date ( 'N', strtotime ( date ( $year . '-' . $month . '-' . $lastDayOfMonth ) ) );
			
			$easter = getdate ( easter_date () );
			$karfreitag = $easter ['mday'] - 2;
			
			if ($lastWeekdayOfMonth == 6) {
				$lastWorkingDay = $lastDayOfMonth - 1;
			} elseif ($lastWeekdayOfMonth == 7) {
				$lastWorkingDay = $lastDayOfMonth - 2;
				if ($lastWorkingDay == $karfreitag && $month == $easter ['mon']) {
					$lastWorkingDay --;
				}
			} else {
				$lastWorkingDay = $lastDayOfMonth;
			}
			
			if ($monthDay == $lastWorkingDay) {
				$types [] = ETaskType::MONTH_END_WORKDAY;
			}
			
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
	}
}

$now = getdate ();

$mHandler = new MinuteHandler ( array (
		0 => TimeHandler::MINUTE,
		5 => TimeHandler::MINUTE_5,
		15 => TimeHandler::MINUTE_15,
		30 => TimeHandler::MINUTE_30 
) );

$hHandler = new HourHandler ( array (
		0 => TimeHandler::HOUR,
		6 => TimeHandler::HOUR_6,
		12 => TimeHandler::HOUR_12 
) );

$dHandler = new DayHandler ( array (
		1 => TimeHandler::WORK_DAY,
		2 => TimeHandler::WORK_DAY,
		3 => TimeHandler::WORK_DAY,
		4 => TimeHandler::WORK_DAY,
		5 => TimeHandler::WORK_DAY,
		6 => TimeHandler::WEEK_END,
		7 => TimeHandler::WEEK_END 
) );

$cHandler = new CusomTimeHandler ();

$start = 1366840800;
$end = 1366927200;

for($i = $start; $i <= $end; $i += 60) {
	$now = getdate ( $i );
	$mHandler->checkTime ( $now );
	$hHandler->checkTime ( $now );
	$dHandler->checkTime ( $now );
	$cHandler->checkTime ( $now );
	echo '<br>';
}

?>