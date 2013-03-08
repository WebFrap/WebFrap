<?php
class Vacuum_Action extends Action {
	
	/**
	 * Das Umgebungsobjekt.
	 *
	 * @var LibFlowApachemod $env
	 */
	public $env = null;
	
	/**
	 * Datenbankverbindungsobjekt
	 * 
	 * @var unknown
	 */
	public $db = null;
	
	public function __construct($env) {
		if ($env) {
			$this->env = $env;
		} else {
			$this->env = WebFrap::$env;
		}
		
		$this->db = $this->env->getDb ();
	}
	public function trigger_normal($tableName) {
		try {
			$sql = "VACUUM {$tableName}";
			$this->db->query ( $sql );
		} catch ( Exception $e ) {
			
		}
	}
	
	public function trigger_full($tableName) {
	}
	
	public function trigger_verbose($tableName) {
	}
	
	public function trigger_analyze($tableName) {
	}
}

?>