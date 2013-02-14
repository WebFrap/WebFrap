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
class SFormatFormdata
{

 /** Checkbox für Datenbank aufbereiten
  * @returns string
  */
  static public function checktoDb($vorhanden )
  {
    $vorhanden = (bool)$vorhanden;
    return $vorhanden ? "1" : "0";
  }

 /** Datenbank in Checkbox umbauen
  * @returns string
  */
  static public function dbtoCheck($Num )
  {
    $Num = (bool)$Num;
    return $Num ? "checked=\"checked\"" : "";
  }

} // end of IncFormatFormdata


