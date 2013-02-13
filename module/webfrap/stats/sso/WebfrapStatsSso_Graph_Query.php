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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @licence BSD
 */
class WebfrapStatsSso_Graph_Query
  extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// query elements table
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param date $start
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $start )
  {

    $db     = $this->getDb();

    $matrix = array();

    $dateStart  = new DateTime( $start );
    $dateEnd    = new DateTime( $start );
    $dateEnd->add(new DateInterval('P1Y'));

    $interval   = new DateInterval('P1M');
    $periods    = new DatePeriod( $dateStart, $interval , $dateEnd );

    // fillup
// date_trunc('month', usage.m_time_created)::date as period,
// date_trunc('month', usage.m_time_created)::date,

    $sql = <<<SQL
  select

    count(usage.flag_sso) as num_sso,
    coalesce(flag_sso,false) as flag_sso
  FROM
    wbfsys_protocol_usage usage
  	
  where
    usage.m_time_created >= '{$dateStart->format('Y-m-d')}'
    and usage.m_time_created < '{$dateEnd->format('Y-m-d')}'
  group by
    coalesce(flag_sso,false) 
    
  ;
SQL;

    $data = $db->select($sql)->getAll();
    foreach( $data as $row )
    {
      $matrix[$row['flag_sso']] = $row['num_sso'];
    }
    
    Debug::dumpFile('sso_dump.html', $matrix);

    $this->data = $matrix;

  }//end public function fetch */


}// end class WebfrapStatsBrowser_Graph_Query

