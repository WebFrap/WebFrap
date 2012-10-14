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
 *
 */
class WbsError
{
////////////////////////////////////////////////////////////////////////////////
// Serializer
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @return String a assembled xml string
   */
  public static function asXml()
  {


    header('Cache-Control: no-cache, must-revalidate'); //Don't Cache!
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //If you cache either, think i'm fkn to old to cache!
    header('Content-Type: text/xml; charset=utf-8'); // hey i'm xml in utf-8!
    header('HTTP/1.1 500 Internal Server Error');

    $service = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>'.NL;
    $service .= '<service type="error" >'.NL;
    $service .= '<error>An error occured!</error>'.NL;
    $service .= '</service>'.NL;

    return $service;

  }//end public function asXml()

  /**
   * @return string a assembled Json string
   */
  public static function asJson()
  {

    header('Cache-Control: no-cache, must-revalidate'); //Don't Cache!
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //If you cache either, think i'm fkn to old to cache!
    header('Content-Type: text/javascript; charset=utf-8'); // hey i'm xml in utf-8!
    header('HTTP/1.1 500 Internal Server Error');

    return '"an error accoured"';
  }//end public function asJson()

  /**
   * @return string a assembled Json string
   *
   */
  public static function asSoap()
  {

    $this->serialized = LibSerializerSoap::getInstance()->serialize($this->data);
    return $this->serialized;
  }//end public function asSoap()


}//end class WbsError

