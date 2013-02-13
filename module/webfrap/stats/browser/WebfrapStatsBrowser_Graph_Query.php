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
class WebfrapStatsBrowser_Graph_Query
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


    $sql = <<<SQL
  select
    date_trunc('month', usage.m_time_created)::date as period,
    count(usage.m_time_created) as num_browser,
    COALESCE( browser.name, 'unknown' ) || ' ' || COALESCE( bvers.name, '?' ) as browser_label
  FROM
    wbfsys_protocol_usage usage
  LEFT JOIN
  	wbfsys_browser browser
  		ON usage.id_browser = browser.rowid
  LEFT JOIN
  	wbfsys_browser_version bvers
  		ON usage.id_browser_version = bvers.rowid
  	
  where
    usage.m_time_created >= '{$dateStart->format('Y-m-d')}'
    and usage.m_time_created < '{$dateEnd->format('Y-m-d')}'
  group by
    date_trunc('month', usage.m_time_created)::date,
    COALESCE( browser.name, 'unknown' ) || ' ' || COALESCE( bvers.name, '?' )   
    
  order by
    date_trunc('month', usage.m_time_created)::date
  ;
SQL;


    $data = $db->select($sql)->getAll();
    foreach( $data as $row )
    {

      if( !isset($matrix[$row['browser_label']]) )
      {
        foreach( $periods as $period )
        {
          if( !isset( $matrix[$row['browser_label']][$period->format("M")] ) )
            $matrix[$row['browser_label']][$period->format("M")] = 0;
        }
      }
      $matrix[$row['browser_label']][date('M',strtotime($row['period']))] = $row['num_browser'];
      
    }

    $this->data = $matrix;

  }//end public function fetch */


}// end class WebfrapStatsBrowser_Graph_Query

