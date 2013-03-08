<?php
class Backup_Action extends Action {
	
	/**
	 * Benutzer mit dessen Rechten die Aktion ausgeführt wird.
	 * @var User
	 */
	public $user = null;
	
	/**
	 * Das Umgebungsobjekt.
	 * @var LibFlowApachemod $env
	 */
	public $env = null;
	
	/**
	 * Pfad zu den Backups
	 * @var String
	 */
	public $backupPathWin = "C:\\Backup";
	
	/**
	 * 
	 * @param LibFlowApachemod $env
	 */
	public function __construct($env) {
		if ($env) {
			$this->env = $env;
		} else {
			$this->env = WebFrap::$env;
		}
	}
	public function trigger_table($tableName) {
		echo "Starting Backup of Table " . $tableName . "<br>";
		
		$filename = $tableName . "-backup-" . time() . ".csv";
		
		$path = implode('\\', array($this->backupPathWin, $filename));
		
		$db = $this->env->getDb();
		
		$sql = <<<SQL
		
		COPY sap.wbfsys_planned_task
		TO '{$path}'
		CSV HEADER
		
SQL;
		$db->query($sql);
		
		
	}
	public function trigger_database($databaseName) {
		echo "Starting Backup of Database: " . $databaseName . "<br>";
	}
	public function trigger_all() {
		echo "Starting Backup of All Data";
	}
	public function setUser($user) {
		$this->use = $user;
		
		echo "User set to" . $this->user;
	}
}

?>