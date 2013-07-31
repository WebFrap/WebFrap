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
   */
  public function getActivePeriod($key)
  {

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

    return $this->getDb()->select($sql)->getField('rowid');

  }//end public function getActivePeriod */


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

}//end class LibPeriodManager

