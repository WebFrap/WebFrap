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
  protected $actPeriod = array();

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
   * Initialisieren eines neuen Periodentypes
   * @param string $key
   */
  public function initNewPeriodType($key)
  {
  
    $orm = $this->getOrm();
  
    $period = $orm->getByKey('WbfsysPeriodType', $key);
  
    if (!$period)
      throw new LibPeriod_Exception('period type not exists','wbf.period',array('type',$key));
  
    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('period type allready initialized','wbf.period',array('type',$key));
    }
  
  }//end public function initNewPeriodType */
  
  /**
   * Initialisieren eines neuen Periodentypes
   * @param string $key
   * 
   * @return 
   */
  public function getPeriodType($key)
  {
  
    $orm = $this->getOrm();

    if (ctype_digit($key)) {
    
      $pType = $orm->get('WbfsysPeriodType', $key);
    } else {
    
      $pType = $orm->getByKey('WbfsysPeriodType', $key);
    }
    
    if (!$pType)
      throw new LibPeriod_Exception('period_type_not_exists', 'wbf.period', array('type',$key));
      
    return $pType;
  
  }//end public function getPeriodType */
  
  /**
   * Id der aktiven Period für eine bestimmten Type erfragen
   *
   * @param string|int $key id des types oder der access_key
   * @param int|array $status liste der status
   * 
   * @return int die id der periode
   *
   * @throws LibPeriod_Exception
   */
  public function getActivePeriod($key, $status = null)
  {
    
    if (is_object($key))
      $key = $key->getId();

    if (isset($this->actPeriod[$key]))
      return $this->actPeriod[$key];
    
    if (!$status)
      $status = array(EWbfsysPeriodStatus::PREPARATION, EWbfsysPeriodStatus::ACTIVE) ;
    
    if ( is_array($status) ) {
      $whereStatus = " IN(".implode(', ',$status).") ";
    } else {
      $whereStatus = " = ".$status;
    }
    
    if (ctype_digit($key)) {
      
      $sql = <<<SQL
SELECT
  period.rowid
FROM wbfsys_period period
WHERE
  period.id_type = {$key}  
    and period.status {$whereStatus};
SQL;
      
    } else {
      
      $sql = <<<SQL
SELECT
  period.rowid
FROM wbfsys_period period
  JOIN wbfsys_period_type type
    ON type.rowid = period.id_type
WHERE
  upper(type.access_key) = upper('{$key}')
  and period.status {$whereStatus};
SQL;
      
    }
    
    $this->actPeriod[$key] = $this->getDb()->select($sql)->getField('rowid');

    if (!$this->actPeriod[$key]){
      throw new LibPeriod_Exception('no active period', 'wbf.period', array('type',$key));
    }

    return $this->actPeriod[$key];

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

    if ( is_object($key) || ctype_digit($key) ){
      
      $sql = <<<SQL
SELECT
  task.actions
FROM wbfsys_period_task task
WHERE
  task.id_type = {$key}
  AND task.event_type = {$type};
SQL;
      
    } else {
      
      $sql = <<<SQL
SELECT
  task.actions
FROM wbfsys_period_task task
  JOIN wbfsys_period_type type
    ON type.rowid = task.id_type
WHERE
  UPPER(type.access_key) = upper('{$key}')
  AND task.event_type = {$type};
SQL;
      
    }
    
    return $this->getDb()->select($sql)->getColumn('actions');

  }//end public function getPeriodActions */


  /**
   * Die nächste Periode eines Types erfragen
   * @param string $key
   *
   * @return int
   */
  public function getNext($pType)
  {

    // valide Perionden sind entweder in Planung oder in Preparation
    $prep = EWbfsysPeriodStatus::PREPARATION;
    $planned = EWbfsysPeriodStatus::PLANNED;

    $sql = <<<SQL
SELECT
  rowid
FROM
  wbfsys_period
WHERE
  date_start IN(
    SELECT min(date_start)
    FROM wbfsys_period 
    WHERE
      status IN({$prep}, {$planned})
        AND id_type = {$pType}
  )
  AND status IN({$prep}, {$planned})
  AND id_type = {$pType}
SQL;

    return $this->getDb()->select($sql)->getField('rowid');

  }//end public function getNext */

  /**
   * Die lezte Periode erfragen
   * @param string $key
   *
   * @return int
   */
  public function getLast($key)
  {

    // valide Perionden sind entweder in Planung oder in Preparation
    $status = EWbfsysPeriodStatus::CLOSED;

    $sql = <<<SQL
SELECT
  period.rowid
FROM
  wbfsys_period
WHERE
  status = {$status}
HAVING
  date_end = max(date_end);
SQL;

    return $this->getDb()->select($sql)->getField('rowid');

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
   * Eine neue Periode zum angegeben Type hinzufügen
   *
   * @param string $key
   * @param int $status
   */
  public function createNext($pType, $status = null)
  {

    $orm = $this->getOrm();

    $period = new WbfsysPeriod_Entity();
    $period->title = $pType->name.' '.date('Y-m-d');
    $period->access_key = $pType->access_key.'_'.date('Y_m_d');
    $period->date_start = date('Y-m-d');
    $period->status = $status;
    $period->id_type = $pType;

    $orm->save($period);
    
    return $period;
    
  }//end public function createNext */
  
  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function initialize($key)
  {
    
    $orm = $this->getOrm();
    
    $pType = $this->getPeriodType($key);
    
    if ($pType->status >= EWbfsysPeriodTypeStatus::ACTIVE){ 
      throw new LibPeriod_Exception('period type allready initialized', 'wbf.period');
    }

    $activePeriod = $this->createNext(
      $pType, 
      EWbfsysPeriodStatus::ACTIVE
    );
    
    
    $this->triggerAction($pType, $activePeriod, EWbfsysPeriodEventType::INITIALIZE );
  
  }//end public function initialize */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function freeze($key)
  {
    
    /// @throws LibPeriod_Exception wenn inkonsistent
    $this->checkConsistency($key);
    
    /// @throws LibPeriod_Exception  wenn keine aktive periode vorhanden ist
    $activePeriod = $this->getActivePeriod($key);
    $pType = $this->getPeriodType($key);
    
    $this->createNext($pType, EWbfsysPeriodStatus::PREPARATION);
    
    $this->updatePeriodStatus($activePeriod, EWbfsysPeriodStatus::FROZEN);

    $this->triggerAction(
      $pType, 
      $activePeriod,  
      EWbfsysPeriodEventType::FREEZE, 
      true
    );

  }//end public function freeze */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function next($key)
  {

    /// @throws LibPeriod_Exception wenn inkonsistent
    $this->checkConsistency($key);

    $pType = $this->getPeriodType($key);
    
    // die aktive periode finden
    $activePeriod = $this->getActivePeriod($pType, array(EWbfsysPeriodStatus::ACTIVE, EWbfsysPeriodStatus::FROZEN));
    $this->closePeriod($activePeriod, EWbfsysPeriodStatus::CLOSED);
    
    
    // die nächste Periode laden
    $nextPeriod = $this->getNext($pType);
    
    // wenn keine vorhanden ist eine erstellen
    if (!$nextPeriod) {
      
      $this->createNext($pType, EWbfsysPeriodStatus::ACTIVE);
    } else {
      
      // die nächste periode aktiv setzen
      $this->updatePeriodStatus($nextPeriod, EWbfsysPeriodStatus::ACTIVE);
    }
    
    $this->triggerAction(
      $pType, 
      array($activePeriod,$nextPeriod),  
      EWbfsysPeriodEventType::SWITCH_NEXT, 
      true
    );

  }//end public function next */


  /**
   * @param string $pType
   * @param int $activePeriod
   * @param int $actionType
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function triggerAction($pType, $activePeriod, $actionType)
  {


    // alle Actions die am Überfang hängen ausführen
    $actions = $this->getPeriodActions($pType, $actionType);

    if ($actions) {
      $executor = new LibAction_Runner($this->env);
      foreach ($actions as $action) {
        $executor->executeByString($action, array($activePeriod));
      }
    }


  }//end public function triggerAction */

  /**
   * @param string $key
   * @param int $activePeriod
   * @param int $status
   * @param int $actionType
   * @param boolean $createNext
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function updatePeriodStatus($activePeriod, $status)
  {
  
    $db = $this->getDb();
  
    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE wbfsys_period set status = {$status} where rowid = {$activePeriod};
SQL;
  
    $db->update($sql);

  
  }//end public function updatePeriodStatus */
  
  /**
   * @param string $key
   * @param int $activePeriod
   * @param int $status
   * @param int $actionType
   * @param boolean $createNext
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function closePeriod($activePeriod, $status)
  {
  
    $db = $this->getDb();
  
    $today = date('Y-m-d');
    
    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE wbfsys_period set status = {$status}, date_end = '{$today}' where rowid = {$activePeriod};
SQL;
  
    $db->update($sql);
  
  }//end public function closePeriod */
  

  /**
   * @param string $key
   * Check auf Consistency
   */
  public function checkConsistency( $key )
  {

    $db = $this->getDb();

    $status = EWbfsysPeriodStatus::PREPARATION;
    $startDate = date('Y-m-d');
    
    if (ctype_digit($key)) {
      
      // periode auf freeze setzen
      $sql = <<<SQL
SELECT
  COUNT(period.rowid) as num
FROM
   wbfsys_period period
WHERE
  period.id_type = {$key}
    AND period.status <= {$status}
    AND period.date_start < '{$startDate}';
      
SQL;
      
    } else {
      
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
    AND date_start < '{$startDate}';
      
SQL;
    }

    $num = $db->select($sql)->getField('num');

    if ($num > 2) {
      throw new LibPeriod_Exception('wbf.period.multiple_periods_in_past');
    }

  }//end public function checkConsistency */

}//end class LibPeriodManager

