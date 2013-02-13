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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class LibEnvelopUser
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $fullName   = null;
  
  /**
   * @var int
   */
  public $userId   = null;
  
  /**
   * @var string
   */
  public $firstName  = null;
  
  /**
   * @var string
   */
  public $lastName   = null;
  
  /**
   * @var string
   */
  public $userName   = null;
    
  /**
   * @var string
   */
  public $passwd     = null;

  /**
   * @var string
   */
  public $employee   = null;
  
  /**
   * @var string
   */
  public $description   = null;
  
  /**
   * @var string
   */
  public $profile   = null;
  
  /**
   * @var int
   */
  public $level   = null;

  /**
   * @var boolean
   */
  public $inactive   = null;

  /**
   * @var boolean
   */
  public $nonCertLogin = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Lists
//////////////////////////////////////////////////////////////////////////////*/
  

  /**
   * @var array
   */
  public $roles = array();

  /**
   * @var array
   */
  public $profiles = array();

  /**
   * @var array
   */
  public $addressItems = array();

  /**
   * @var array
   */
  public $announcementChannels = array();
  
}//end class LibEnvelopUser

