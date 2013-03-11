<?php
class Vacuum_Action extends Action {
	
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
	
	public function __construct($env = null, User $user) {
		if ($env) {
			$this->env = $env;
		} else {
			$this->env = WebFrap::$env;
		}
		
		// Sonst könnte ja jeder kommen ...
		
		if ($user->getLevel () < 90) {
			throw new Action_Exception ( "Insufficient accessrights!" );
		} else {
			$this->user = $user;
		}
	}
	
	public function trigger_normal($tableName) {
		try {
			echo "Doing Vacuum";
			
			$db = $this->env->getDb ();
			
			$sql = "VACUUM {$tableName}";
			$db->query ( $sql );
		} catch ( Exception $e ) {
		}
	}
	
	public function trigger_full($tableName) {
	}
	
	public function trigger_verbose($tableName) {
	}
	
	public function trigger_analyze($tableName) {
	}
	
	/*
	 * (non-PHPdoc) @see BaseChild::setUser()
	 */
	public function setUser($user) {
		$this->user = $user;
	}
}

?>