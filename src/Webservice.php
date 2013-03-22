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
abstract class Webservice extends Pbase
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * array with the data
   * @var array
   */
  protected $data = array();

  /**
   * name of the Webservice type
   * @var string
   */
  protected $name = null;

  /**
   * @var string
   */
  protected $serialized = null;

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  public function loadError()
  {

    header('HTTP/1.1 500 Internal Server Error');

    $this->data['error'] = 'invalid request';

  }//end public function loadError */

/*//////////////////////////////////////////////////////////////////////////////
// Serializer
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return String a assembled xml string
   */
  public function asXml()
  {

    header('Cache-Control: no-cache, must-revalidate'); //Don't Cache!
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //If you cache either, think i'm fkn to old to cache!
    header('Content-Type: text/xml; charset=utf-8'); // hey i'm xml in utf-8!

    $service = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>'.NL;
    $service .= '<service type="'.$this->name.'" >'.NL;
    foreach ($this->data as $id => $value) {
      $service .= '<object id="objId_'.$id.'">'.NL;
      $service .= $this->buildToXml($value);
      $service .= '</object>'.NL;
    }
    $service .= '</service>'.NL;

    return $service;

  }//end public function asXml */

  /**
   * Enter description here...
   *
   * @param unknown_type $data
   * @return string
   */
  protected function buildToXml($data)
  {
    $xml = '';

    foreach ($data  as $key => $value) {
      if (is_scalar($value)) {
       $xml .= '<'.$key.'>'.$value.'</'.$key.'>'.NL;
      } elseif (is_array($value)) {
        $xml .= '<'.$key.'>'.$this->buildToXml($value).'</'.$key.'>'.NL;
      } elseif (is_object($value) and $value instanceof ISerializeable) {

      }
    }//end foreach($data  as $key => $value)

    return $xml;

  }//end protected function buildToXml */

  /**
   * @return string a assembled Json string
   *
   */
  public function asJson()
  {

    header('Cache-Control: no-cache, must-revalidate'); //Don't Cache!
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //If you cache either, think i'm fkn to old to cache!
    header('Content-Type: application/javascript; charset=utf-8'); // hey i'm xml in utf-8!

    $this->serialized = LibSerializerJson::getActive()->serialize($this->data);

    return $this->serialized;

  }//end public function asJson */

  /**
   * @return string a assembled Json string
   */
  public function asSoap()
  {

    $this->serialized = LibSerializerSoap::getInstance()->serialize($this->data);

    return $this->serialized;

  }//end public function asSoap */

}//end abstract class SysWbs

