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
 * class IncTestDates
 * Includeklasse
 */
final class STestDate
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
  */
   private function __construct()
   {
   }

  /**
   * Testen ob das Jahr ein Schaltjahr ist
   *
   * @param string Template Das zu bearbeitende Template
   * @return String
   */
  public static function isLeapYear($Year)
  {

    if ($Year % 4 != 0) {
      return false;
    }
    if ($Year % 100 == 0) {
      return false;
    }

    return true;

  } // end public static function isLeapYear($Year)

  public static function  getMonthLenght($Month , $Year)
  {

    if ($Month > 11) {
      $Month = 0;
      --$Year;
    } elseif ($Month < 0) {
      $Month = 11;
      -- $Year;
    }

    $MonthLenght = array(0 =>  31,
                          1 =>  28,
                          2 =>  31,
                          3 =>  30,
                          4 =>  31,
                          5 =>  30,
                          6 =>  31,
                          7 =>  31,
                          8 =>  30,
                          9 =>  31,
                          10 => 30,
                          11 => 31
                        );

    if (self::isLeapYear($Year) and $Month == 1) {
      return 29;
    } else {
      return $MonthLenght[$Month];
    }

  }//end public static function  getMonthLenght($Month , $Year)

} // end final class STestDate

