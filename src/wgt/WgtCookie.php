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
 * @subpackage tech_core
 */
class WgtCookie
{

  /**
   * @var string the cookie Name
   */
  protected $name    = null;

  /**
   * @var string the value for the cookie
   */
  protected $value   = null;

  /**
   * @var string when should the cookie expire
   */
  protected $expire  = null;

  /**
   * @var string the cookie path
   */
  protected $path    = null;

  /**
   * @var string the domain of the cookie
   */
  protected $domain  = null;

  /**
   * @var int only accepted with ssl?
   */
  protected $secure  = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $name Name of the Cookie
   */
  public function __construct
  (
    $name , $value , $expire = null , $path  = null ,
    $domain  = null , $secure  = null
  )
  {
       $this->name    = $name;
       $this->value   = $value;
       $this->expire  = $expire;
       $this->path    = $path;
       $this->domain  = $domain;
       $this->secure  = $secure;
  }//end public function __construct($name )

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  public function setName($data )
  {
    $this->name = $data;
  }

  public function getName( )
  {
    return $this->name;
  }

  public function setValue($data )
  {
    $this->value = $data;
  }

  public function getValue( )
  {
    return $this->value;
  }

  public function setExpire($data )
  {
    $this->expire = $data;
  }

  public function getExpire( )
  {
    return $this->expire;
  }

  public function setPath($data )
  {
    $this->path = $data;
  }

  public function getPath( )
  {
    return $this->path;
  }

  public function setDomain($data )
  {
    $this->domain = $data;
  }

  public function getDomain( )
  {
    return $this->domain;
  }

  /**
   * @param int $data
   * @return void
   */
  public function setSecure($data )
  {
    $this->secure = $data;
  }

  /**
   * @return int
   */
  public function getSecure( )
  {
    return $this->secure;
  }//end public function getSecure

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function setCookie()
  {
     if (!setcookie
     (
       $this->name ,
       $this->value,
       $this->expire,
       $this->path,
       $this->domain,
       $this->secure
     ))
     {
       Error::addError
       (
           'Wasn\'t able to set Cookie '.$this->name
       );
     }

  }// end public function setCookie

} // end class WgtCookie

