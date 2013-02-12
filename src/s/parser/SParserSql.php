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
final class SParserSql
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /**
   * Enter description here...
   *
   * @param unknown_type $arr
   * @return unknown
   */
  public static function arrayToInsert( $data , $tabName, $quotes , $schema = null )
  {

    $keys   = '';
    $values = '';

    foreach ($data as $key => $value) {
      $keys .= $key.',';

      if ( is_null($value) ) {
        $values .= 'null,';
      } elseif ( trim($value) == '' ) {
        $values .= 'null,';
      } elseif ($data[$key]) {
        $values .= "'".Db::addSlashes($value)."',";
      } else {
        $values .= "$value,";
      }
    }

    if ($keys != '') {
      $keys = substr($keys,0,-1);
      $values = substr($values,0,-1);
    }

    if ($schema) {
       $tabName = $schema.'.'.$tabName;
    }

    return 'INSERT INTO '.$tabName.' ( '.$keys.' ) VALUES ( '.$values.' ); '.NL;

  }//end public static function arrayToInsert( $data , $tabName, $quotes )

}// end class SParserString
