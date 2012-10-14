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
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDate
{

  const SEC_MIN = 60;

  const SEC_HOUR = 3600;

  const MIN_HOUR = 60;

  const HOUR_DAY = 24;

  const DAY_YEAR = 355;

  const DAY_WEEK = 7;

  const WDAY_WEEK = 5;

  const WEEK_MONTH = 4.33;

  const MONTH_YEAR = 12;

  /**
   * change a timestamp to human words
   * @param int $timeStamp
   * @return string
   */
  function humanDate( $timeStamp )
  {

    $formDate = '';
    $now      = time();

    if ( $now > $timeStamp )
    {
      $diff       = round($now  - $timeStamp          );
      $minutes    = round($diff     / self::SEC_MIN   );
      $hours      = round($minutes  / self::MIN_HOUR  );
      $days       = round($hours    / self::HOUR_DAY  );
      $weeks      = round($days     / self::DAY_WEEK  );
      $months     = round($weeks    / self::WEEK_MONTH);
      $years      = round($months   / self::MONTH_YEAR);


      if (($diff < self::SEC_MIN ) || ($minutes <= 1))
        return 'less than 1 minute ago';

      if ($hours == 0)
      {
        return $minutes . ' minutes ago';
      }

      if ($days == 0)
      {
        if ($hours > 1)
        {
          $formDate = $hours . ' hours ago';
        }
        else
        {
          $formDate = '1 hour ago';
        }
      }
      elseif ($weeks == 0)
      {
        if ($days > 1)
        {
          $formDate = $days . ' days ago';
        }
        else
        {
          $formDate = 'Yesterday';
        }
      }
      elseif ($months == 0)
      {
        if ($weeks > 1)
        {
          $formDate = $weeks . ' weeks ago';
        }
        else
        {
          $formDate = 'Last week';
        }
      }
      elseif ( $years == 0 )
      {
        if ($months == 1)
        {
          $formDate = 'Last Month';
        }
        else
        {
          $formDate = $months . ' months ago';
        }
      }
      else
      {
        if ($years == 1)
        {
          $formDate = 'Last year';
        }
        else
        {
          $formDate = $years . ' years ago';
        }

      }
    }
    else
    {

      $diff       = ($timeStamp     - $now            );
      $minutes    = round($diff     / self::SEC_MIN   );
      $hours      = round($minutes  / self::MIN_HOUR  );
      $days       = round($hours    / self::HOUR_DAY  );
      $weeks      = round($days     / self::DAY_WEEK  );
      $months     = round($weeks    / self::WEEK_MONTH);
      $years      = round($months   / self::MONTH_YEAR);


      if ($days == 0)
      {
        $formDate = 'Today';
      }
      elseif ($days == 1)
      {
        $formDate = 'Tomorrow';
      }
      elseif ($weeks == 0)
      {
        $formDate = $days . ' days';
      }
      elseif ($weeks == 1)
      {
        $formDate = 'Next Week';
      }
      elseif ($months == 0)
      {
        $formDate = $weeks . ' weeks';
      }
      elseif ($months == 1)
      {
        $formDate = 'Next Month';
      }
      elseif ($years <= 0)
      {
        $formDate = $months . ' months';
      }
      elseif ($years == 1)
      {
        $formDate = 'Next Year';
      }
      else
      {
        $formDate = 'Over a year';
      }

    }

    return $formDate;
    
  }//end function humanDate
  


} // end LibDateHoliday

