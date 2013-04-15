<?php

class Cleanup_Action extends Action
{

  /**
   * Response Objekt für Logging etc.
   * @var LibResponseCollector
   */
  public $response = null;

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
	 */
  public function trigger_inactiveUsers ()
  {

    $db = $this->getDb();
    
    $sql = <<<SQL
SELECT DISTINCT rowid FROM view_compliance_employees
  WHERE current_date NOT BETWEEN c_start AND c_end
    AND rowid NOT IN (SELECT rowid FROM view_compliance_employees WHERE current_date BETWEEN c_start AND c_end)
SQL;
    
    $result = $db->select($sql);
    $count = $result->count();
    $ids = $result->getColumn("rowid");
    
    $inactiveIds = implode(", ", $ids);
    
    $this->response->addWarning("Disabling " . $count . " Users");
    
    $this->response->addMessage("Disabled User IDs: " . $inactiveIds);
    
    $sql = <<<SQL
UPDATE wbfsys_role_user
SET inactive = true
WHERE id_employee IN ({$inactiveIds})
SQL;
    
    //$db->update($sql);
    
  }

  /**
   * (non-PHPdoc)
   *
   * @see BaseChild::setUser()
   */
  public function setUser ($user)
  {

    $this->user = $user;
  }

  /**
   * @param LibResponseCollector $response
   */
  public function getResponse ()
  {

    return $this->response;
  }

  /**
   * @param LibResponseCollector $response
   */
  public function setResponse ($response)
  {

    $this->response = $response;
  }
}

?>