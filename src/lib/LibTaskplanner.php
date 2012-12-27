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
  * Taskplanner
  * @package WebFrap
  * @subpackage taskplanner
  */
class LibTaskplanner
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * value from getdata
   * @see http://php.net/manual/de/function.getdate.php
   * 
   * @var array
   */
  public $now = null;
  
  
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * bestimmen welche tasktypen getriggert werden müssen
   * @param array $now
   * @return array
   */
  public function load( )
  {
    
    $this->now = getdate();
    $taskTypes = $this->setupRequiredTasktypes( $this->now );
    
  }//end public function load */


  /**
   * bestimmen welche tasktypen getriggert werden müssen
   * @param array $now
   * @return array
   */
  public function setupRequiredTasktypes( $now )
  {
    
    $types = array( ETaskType::MINUTE );
    
    // minuten und stündlich
    if( 0 == $now['minutes'] )
    {
      $types[] = ETaskType::HOUR;
      $types[] = ETaskType::MINUTE_30;
      $types[] = ETaskType::MINUTE_15;
      $types[] = ETaskType::MINUTE_5;
    }
    elseif( 0 === $now['minutes'] % 30 )
    {
      $types[] = ETaskType::MINUTE_30;
      if( 0 === $now['minutes'] % 15 )
      {
        $types[] = ETaskType::MINUTE_15;
        if( 0 === $now['minutes'] % 5 )
        {
          $types[] = ETaskType::MINUTE_5;
        }
      }
    }
    
    if( 0 === $now['hours'] % 12 )
    {
      $types[] = ETaskType::HOUR_12;
      if( 0 === $now['hours'] % 6 )
      {
        $types[] = ETaskType::HOUR_6;
      }
    }
    
    // nachts um 3:15 werden task mit einer periode > 1 Tag getriggert
    // sicherheitsabstand für den fall einer zeitumstellung
    if( 15 == $now['minutes'] && 3 === $now['hours'] )
    {
      
      // daily
      $types[] = ETaskType::DAY;
      
      // wochen
      if( 0 == $now['wday']  )
      {
        $types[] = ETaskType::WEEKEND_END;
        
        if( 0 == round($now['yday'] / 7) % 2 ) // jeden 2ten sonntag
        {
          $types[] = ETaskType::WEEK_2;
        }
        
      }
      elseif( 6 < $now['wday'] ) // nur false für samstag
      {
        $types[] = ETaskType::WORK_DAY;
      }

    }
    
    // Monate lassen wir um 2:20 enden, keine kollision mit zeitumstellung
    // und wir wollen ja nicht alles auf einmal triggern
    if( 15 == $now['minutes'] && 2 === $now['hours'] )
    {

      // monate
      $monthNumDays = SDate::getMonthDays($now['year'], $now['mon']);
      if( $monthNumDays == $now['mday'] ) // monatsende
      {
        $types[] = ETaskType::MONTH_END;
        
        if( 0 == $now['mon'] % 6  )
        {
          $types[] = ETaskType::MONTH_6_END;
          
          if( 0 == $now['mon'] % 3  )
          {
            $types[] = ETaskType::MONTH_3_END;
          }
          
        }
      }
      elseif( 1 == $now['mday']  )
      {
        if( 0 == $now['mon'] % 6  )
        {
          $types[] = ETaskType::MONTH_6_START;
          
          if( 0 == $now['mon'] % 3  )
          {
            $types[] = ETaskType::MONTH_3_START;
          }
        }
      }
    }
    
    // Jahre lassen wir um 23:59 enden, keine kollision mit zeitumstellung
    // wenig risiko auf viel lasst
    if
    ( 
      12 == $now['mon'] 
        && 31 == $now['mday'] 
        && 23 === $now['hours'] 
        && 59 == $now['minutes'] 
    )
    {
      $types[] = ETaskType::YEAR_END;
    }
    elseif( 1 == $now['mon'] 
        && 2 == $now['mday'] 
        && 1 === $now['hours'] 
        && 15 == $now['minutes']  )
    {
      $types[] = ETaskType::YEAR_START;
    }
    
    return $types;
    
  }//end public function setupRequiredTasktypes */
  
}//end class LibTaskplanner


