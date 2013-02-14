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
abstract class Wbservice
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * array with the data
   *
   * @var array
   */
  protected $data       = array();

  /**
   * name of the Webservice type
   *
   * @var string
   */
  protected $name       = null;

  /**
   *
   * @var string
   */
  protected $serialized = null;

  /**
   *
   * @var LibRequestHttp
   */
  protected $request    = null;

  /**
   *
   * @var LibI81nPhp
   */
  protected $i18n       = null;

  /**
   *
   * @var LibAclPhp
   */
  protected $acl        = null;

  /**
   *
   * @var LibDbConnection
   */
  protected $db         = null;

  /**
   *
   * @var User
   */
  protected $user       = null;

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/



  public function setRequest($request)
  {
    $this->request = $request;
  }//end public function setRequest */

  public function setDb($db )
  {
    $this->db = $db;
  }//end public function setDb */

  public function setI18n($i18n )
  {
    $this->i18n = $i18n;
  }//end public function setI18n */

  public function setAcl($acl )
  {
    $this->acl = $acl;
  }//end public function setAcl */

  public function setUser($user )
  {
    $this->user = $user;
  }//end public function setUser */


  public function getRequest(  )
  {
    if (!$this->request)
      $this->request = Request::getActive();

    return $this->request;
  }//end public function getRequest */

  public function getDb(  )
  {
    if (!$this->db)
      $this->db = Db::getActive();

    return $this->db;
  }//end public function getDb */

  public function getI18n(  )
  {
    if (!$this->i18n)
      $this->i18n = I18n::getActive();

    return $this->i18n;
  }//end public function getI18n */

  public function getAcl(  )
  {
    if (!$this->acl)
      $this->acl = Acl::getActive();

    return $this->acl;
  }//end public function getAcl */

  /**
   * @return User
   */
  public function getUser(  )
  {
    if (!$this->user)
      $this->user = User::getActive();

    return $this->user;
  }//end public function getUser */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return unknown_type
   */
  public function loadError()
  {
    header('HTTP/1.1 500 Internal Server Error');
    $this->data['error'] = 'invalid request';
  }//end public function loadError

/*//////////////////////////////////////////////////////////////////////////////
// Serializer
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return String a assembled xml string
   */
  public function asXml()
  {

    //Don't Cache!
    header('Cache-Control: no-cache, must-revalidate');

    //If you cache either, think i'm fkn to old to cache!
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

    // hey i'm xml in utf-8!
    header('Content-Type: text/xml; charset=utf-8');

    $service = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>'.NL;
    $service .= '<service type="'.$this->name.'" >'.NL;
    foreach($this->data as $id => $value )
    {
      $service .= '<object id="objId_'.$id.'">'.NL;
      $service .= $this->buildToXml($value);
      $service .= '</object>'.NL;
    }
    $service .= '</service>'.NL;

    return $service;

  }//end public function asXml()



  /**
   * @return string a assembled Json string
   *
   */
  public function asJson()
  {

    header('Cache-Control: no-cache, must-revalidate'); //Don't Cache!
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //If you cache either, think i'm fkn to old to cache!
    header('Content-Type: application/javascript; charset=utf-8'); // hey i'm xml in utf-8!

    $this->serialized = LibSerializerJson::getInstance()->serialize($this->data);
    return $this->serialized;

  }//end public function asJson()



}//end abstract class SysWbs

