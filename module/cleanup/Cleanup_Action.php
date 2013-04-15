<?php

class Cleanup_Action extends Action
{

  /**
	 *
	 * @param LibFlowApachemod $env        	
	 */
  public function __construct ($env = null)
  {

    if ($env) {
      $this->env = $env;
    } else {
      $this->env = WebFrap::$env;
    }
  }

  /**
	 * Sucht alle Benutzer ohne aktiven Vertrag und setzt deren Status auf inaktiv.
	 *
	 * @param String $tableName        	
	 */
  public function trigger_inactiveUsers ()
  {
    
  }
}

?>