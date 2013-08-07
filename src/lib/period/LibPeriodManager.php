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
 * @package WebFrap
 * @subpackage tech_core
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibPeriodManager extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $periods = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param PBase
   */
  public function __construct($env = null)
  {

    if (!$env)
      $env = Webfrap::$env;

    $this->env = $env;

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Id der aktiven Period für eine bestimmten Type erfragen
   *
   * @param string $key
   * @return int
   * 
   * @throws LibPeriod_Exception
   */
  public function getActivePeriod($key)
  {
    
    if (isset($this->periods[$key]))
      return $this->periods[$key];

    $active = EWbfsysPeriodStatus::ACTIVE;

    $sql = <<<SQL
SELECT
  period.rowid
FROM wbfsys_period period
  JOIN wbfsys_period_type type
    ON type.rowid = period.id_type
WHERE
  upper(type.access_key) = upper('{$key}')
  and period.status = {$active};
SQL;

    $this->periods[$key] = $this->getDb()->select($sql)->getField('rowid');
    
    if (!$this->periods[$key]){
      throw new LibPeriod_Exception( 'There is no period type: '.$key );
    }
    
    return $this->periods[$key];

  }//end public function getActivePeriod */
  
  /**
   * Die Actions für einen bestimmten Periodenübergang auslesen
   *
   * @param string $key
   * @param int EWbfsysPeriodStatus $type
   * 
   * @return array
   */
  public function getPeriodActions($key, $type)
  {

    $sql = <<<SQL
SELECT
  wbfsys_period_task.actions
FROM wbfsys_period_task task
  JOIN wbfsys_period_type type
    ON type.rowid = task.id_type
WHERE
  upper(type.access_key) = upper('{$key}')
  AND task.event_type = {$type};
SQL;
  
    return $this->getDb()->select($sql)->getColumn('actions');
  
  }//end public function getPeriodActions */


  /**
   * 
   */
  public function initNewPeriodType($key)
  {

    $orm = $this->getOrm();

    $period = $orm->getByKey('WbfsysPeriodType', $key);

    if (!$period)
      throw new LibPeriod_Exception('Got key '.$key.' to initialize, however this period type does not exist.' );

    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('The period type '.$key.' is allready initialized');
    }


  }//end public function initNewPeriodType */
  
  /**
   * Eine neie Periode starten
   * @param string $key
   */
  public function getNext($key)
  {
  
    $db = $this->getDb();
    
    $status = EWbfsysPeriodStatus::PREPARATION;

    // periode auf freeze setzen
    $sql = <<<SQL
SELECT
  period.rowid
FROM 
  wbfsys_period
WHERE 
  status <= {$status}
HAVING 
  start_date = min(start_date);
SQL;
    
    $db->update($sql);
    
    return $this->getDb()->select($sql)->getField('rowid');
  
  }//end public function getNext */

  /**
   * Eine neie Periode starten
   * @param string $key
   */
  public function createNext($key, $status = null)
  {
    
    $orm = $this->getOrm();
  
    if (is_null($status))
      $status = EWbfsysPeriodStatus::PLANNED;
  
    $period = $orm->getByKey('WbfsysPeriodType', $key);
  
    if (!$period)
      throw new LibPeriod_Exception('Got key '.$key.' to initialize, however this period type does not exist.' );
  
    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('The period type '.$key.' is allready initialized');
    }
    
    $period = new WbfsysPeriod_Entity();
    $period->date_start = date('Y-m-d');
    $period->status = $status;
  
  }//end public function createNext */
  
  /**
   *
   */
  public function getLast($key)
  {
  
    $orm = $this->getOrm();
  
    $period = $orm->getByKey('WbfsysPeriodType', $key);
  
    if (!$period)
      throw new LibPeriod_Exception('Got key '.$key.' to initialize, however this period type does not exist.' );
  
    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('The period type '.$key.' is allready initialized');
    }
  
  }//end public function getLast */
  
  /**
   *
   */
  public function getBetween($key, $start, $end)
  {
  
    $orm = $this->getOrm();
  
    $period = $orm->getByKey('WbfsysPeriodType', $key);
  
    if (!$period)
      throw new LibPeriod_Exception('Got key '.$key.' to initialize, however this period type does not exist.' );
  
    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('The period type '.$key.' is allready initialized');
    }
  
  }//end public function getBetween */
  
  /**
   * @param string $key
   */
  public function freeze($key)
  {
  
    $db = $this->getDb();
    $activePeriod = $this->getActivePeriod($key);
    $freeze = EWbfsysPeriodStatus::FROZEN;
    
    // alle Actions die am Überfang hängen ausführen
    $actions = $this->getPeriodActions($key, EWbfsysPeriodStatus::FROZEN);
    
    $executor = new LibAction_Runner($this->env);
    
    foreach ($actions as $action) {
      $executor->executeByString($action);
    }
    
    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE wbfsys_period set status = {$freeze} where rowid = {$activePeriod};
SQL;
    
    $db->update($sql);
    
  
    $this->createNext($key);
    
  }//end public function freeze */
  
  /**
   * @param string $key
   */
  public function next($key)
  {
  
    $db = $this->getDb();
    $activePeriod = $this->getActivePeriod($key);
    $freeze = EWbfsysPeriodStatus::FREEZE;
  
    // alle Actions die am Überfang hängen ausführen
    $actions = $this->getPeriodActions($key, EWbfsysPeriodStatus::FROZEN);
  
    $executor = new LibAction_Runner($this->env);
  
    foreach ($actions as $action) {
      $executor->executeByString($action);
    }
  
    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE wbfsys_period set status = {$freeze} where rowid = {$activePeriod};
SQL;
  
    $db->update($sql);
  
  
  }//end public function next */
  
  /**
   * @param string $key
   * Check auf Consistency
   */
  public function checkConsistency( $key )
  {
    
    $db = $this->getDb();
    
    $status = EWbfsysPeriodStatus::PREPARATION;
    $startDate = date('Y-m-d');
    
    // periode auf freeze setzen
    $sql = <<<SQL
SELECT 
  COUNT(period.rowid) as num
FROM
   wbfsys_period period
JOIN
    wbfsys_period_type type ON type.rowid = period.id_type
WHERE 
  UPPER(wbfsys_period_type.access_key) = UPPER('{$key}')
    AND status <= {$status}
    AND start_date < '{$startDate}';

SQL;
    
    $num = $db->select($sql)->getField('num');
    
    if ($num > 2) {
      throw new LibPeriod_Exception('');
    }
    
  }//end public function checkConsistency */
  
}//end class LibPeriodManager

