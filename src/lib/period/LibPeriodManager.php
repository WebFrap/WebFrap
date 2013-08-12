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
   * @param string|int $key id des types oder der access_key
   * @return int die id der periode
   *
   * @throws LibPeriod_Exception
   */
  public function getActivePeriod($key)
  {

    if (isset($this->periods[$key]))
      return $this->periods[$key];

    $active = EWbfsysPeriodStatus::ACTIVE;
    
    if (ctype_digit($key)) {
      
      $sql = <<<SQL
SELECT
  period.rowid
FROM wbfsys_period period
WHERE
  period.id_type = {$key}  
    and period.status = {$active};
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
  and period.status = {$active};
SQL;
    }
    
    $this->periods[$key] = $this->getDb()->select($sql)->getField('rowid');

    if (!$this->periods[$key]){
      throw new LibPeriod_Exception('wbf.period.no_active_period', array('type',$key));
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
   * Initialisieren eines neuen Periodentypes
   * @param string $key
   */
  public function initNewPeriodType($key)
  {

    $orm = $this->getOrm();

    $period = $orm->getByKey('WbfsysPeriodType', $key);

    if (!$period)
      throw new LibPeriod_Exception('wbf.period.period_type_not_exists', array('type',$key));

    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('wbf.period.period_type_allready_initialized', array('type',$key));
    }

  }//end public function initNewPeriodType */

  /**
   * Die nächste Periode eines Types erfragen
   * @param string $key
   *
   * @return int
   */
  public function getNext($key)
  {

    // valide Perionden sind entweder in Planung oder in Preparation
    $status = EWbfsysPeriodStatus::PREPARATION;

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
  end_date = max(end_date);
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
  public function createNext($key, $status = null)
  {

    $orm = $this->getOrm();

    if (is_null($status))
      $status = EWbfsysPeriodStatus::PLANNED;

    $pType = $orm->getByKey('WbfsysPeriodType', $key);

    if (!$period)
      throw new LibPeriod_Exception('wbf.period.period_type_not_exists', array('type',$key));

    $period = new WbfsysPeriod_Entity();
    $period->date_start = date('Y-m-d');
    $period->status = $status;
    $period->id_type = $pType;

    $orm->save($period);

  }//end public function createNext */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function freeze($key)
  {

    $this->triggerAction($key, EWbfsysPeriodStatus::FROZEN, true);

  }//end public function freeze */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function init($key)
  {

    $this->triggerAction($key, EWbfsysPeriodStatus::ACTIVE, true);

  }//end public function init */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function close($key)
  {

    $this->triggerAction($key, EWbfsysPeriodStatus::CLOSE);

  }//end public function close */


  /**
   * @param string $key
   * @param int $status
   * @param boolean $createNext
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function triggerAction($key, $status, $createNext = false)
  {

    $db = $this->getDb();

    /// @throws LibPeriod_Exception wenn inkonsistent
    $this->checkConsistency( $key );

    /// @throws LibPeriod_Exception  wenn keine aktive periode vorhanden ist
    $activePeriod = $this->getActivePeriod($key);

    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE wbfsys_period set status = {$status} where rowid = {$activePeriod};
SQL;

    $db->update($sql);

    if ($createNext)
      $this->createNext($key, EWbfsysPeriodStatus::IN_PREPARATION);

    // alle Actions die am Überfang hängen ausführen
    $actions = $this->getPeriodActions($key, $status);

    if ($actions) {
      $executor = new LibAction_Runner($this->env);

      foreach ($actions as $action) {
        $executor->executeByString($action, array($activePeriod));
      }
    }


  }//end public function freeze */


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
    AND period.start_date < '{$startDate}';
      
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
    AND start_date < '{$startDate}';
      
SQL;
    }

    $num = $db->select($sql)->getField('num');

    if ($num > 2) {
      throw new LibPeriod_Exception('wbf.period.multiple_periods_in_past');
    }

  }//end public function checkConsistency */

}//end class LibPeriodManager

