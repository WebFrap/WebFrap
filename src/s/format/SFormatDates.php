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
class SFormatDates
{

 /** Einen Formatierten Datumsstring mit dem aktuellen Datum
  * @returns string
  */
  static public function getLogdate(){
    return date( "Y-m-d H:i:s" );
  } // Ende Memberfunction GetLogdate

 /** Formatieren eines Datums zur Ausgabe in der aktuellen Systemsprache
  * @returns string
  */
  static public function formDate($Date ){
    if (trim($Date) == "" ){
      return "";
    }
    $Date = strtotime($Date );
    return date ( "d.m.Y" , $Date );
  }

 /** Formatieren einer Zeit zur Ausgabe in der aktuellen Systemsprache
  * @returns string
  */
  static public function formTime($Time ){
    if (trim($Time) == "" ){
      return "";
    }
    $Time = strtotime($Time );
    return date ( "G.i.s" , $Time );
  }

 /** Formatieren eines Timestamps zur Ausgabe in der aktuellen Systemsprache
  * @returns string
  */
  static public function formTimestamp($Time ){
    if (trim($Time) == "" ){
      return "";
    }
    $Time = strtotime($Time );
    return date ( "d.m.Y G.i.s" , $Time );
  }

 /** Einen Formatierten Datumsstring mit dem aktuellen Datum
  * @returns string
  */
  static public function dateToDb($Date )
  {
    if (trim($Date ) != ""  )
    {
      $parts = explode( "." , $Date  );
      $Date = $parts[2]."-".$parts[1]."-".$parts[0];
    }
    return $Date;
  }

 /** Einen Formatierten Datumsstring mit dem aktuellen Datum
  * @returns string
  */
  public function timestampToDate($Date ){
    $parts = explode( " " , $Date  );

    $Date = $parts[0];
    $Time = $parts[1];

    $parts = explode( "-" , $Date );
    $Date = $parts[2].".".$parts[1].".".$parts[0];

//     $parts = explode( ":" , $Time );
//     $Time = $parts[2].":".$parts[1].".".$parts[0];

    return "$Time $Date";
  }

} // end class SFormatDates


