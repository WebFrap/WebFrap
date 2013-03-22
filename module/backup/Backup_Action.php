<?php
class Backup_Action extends Action {
	
	/**
	 * Benutzerobjekt mit dessen Rechten die Aktion ausgeführt wird.
	 *
	 * @var User
	 */
	public $user = null;
	
	/**
	 * Das Umgebungsobjekt.
	 *
	 * @var LibFlowApachemod $env
	 */
	public $env = null;
	
	/**
	 * Pfad zu den Backups
	 *
	 * @var String
	 */
	public $backupPathWin = "C:\\Backup";
	
	/**
	 *
	 * @param LibFlowApachemod $env        	
	 */
	public function __construct($env = null) {
		if ($env) {
			$this->env = $env;
		} else {
			$this->env = WebFrap::$env;
		}
	}
	
	/**
	 * Trigger für das Backup einer einzelnen Tabelle
	 *
	 * @param String $tableName        	
	 */
	public function trigger_table($tableName) {
		echo "Starting Backup of Table " . $tableName . "<br>";
		
		$filename = $tableName . "-backup-" . time () . ".csv";
		
		$path = implode ( '\\', array (
				$this->backupPathWin,
				$filename 
		) );
		
		$db = $this->env->getDb ();
		
		$sql = <<<SQL
		
		COPY {$tableName}
		TO '{$path}'
		CSV HEADER
		
SQL;
		
		$db->query ( $sql );
	}
	
	/**
	 * Trigger für das Backup einer kompletten Datenbank
	 *
	 * @param String $databaseName        	
	 */
	public function trigger_database($databaseName) {
		echo "Starting Backup of Database: " . $databaseName . "<br>";
	}
	
	/**
	 * Trigger für das Backup eines gesamten Servers
	 */
	public function trigger_all() {
		echo "Starting Backup of All Data";
	}
	
	public function trigger_destroyWorld() {
		echo "World destroyed by " . $this->user->getLoginName() . "<br>";
	}
	
	public function trigger_happy($tv) {
		
		$result = null;
		
		if ($tv == 1) {
			echo "# Hier kam <b>true</b> raus <br>";
			$result = true;
		} 
		if ($tv == 0) {
			echo "#Hier kam <b>false</b> raus <br>";
			$result = false;
		}
		
		return $result;
		
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see BaseChild::setUser()
	 */
	public function setUser($user) {
		$this->user = $user;
	}
}

?>