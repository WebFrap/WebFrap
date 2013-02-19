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
 * Webfrap Access Controll
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibAclAdapter extends BaseChild
{

  /**
   * the user level
   * @var array
   */
  protected $level              = array();

  /**
   *
   * @var array
   */
  protected $group              = array();

  /**
   *
   * @var array
   */
  protected $extend             = array();

  /**
   *
   * @var array
   */
  protected $groupCache         = array();

  /**
   *
   * @var array
   */
  protected $lists              = array();


  /**
   * flag to enable or disable the check for acls
   *
   * this is a helpfull option for testing or debugging
   * don't set to true in productiv systems!
   *
   * @var boolean
   */
  protected $disabled           = false;

  /**
   * available Access Levels
   * @var array
   */
  protected $levels             = array();
  
  /**
   * Der Datenbank manager
   * @var LibAclManager
   */
  protected $manager             = null;
  
  /**
   * Der ACL Reader
   * @var LibAclReader
   */
  protected $reader             = null;

/*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibFlowApachemod $env
   */
  public function __construct($env = null  )
  {

    $this->levels = Acl::$accessLevels;
    
    if (!$env )
      $env = Webfrap::getActive();
    
    $this->env    = $env;
    
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter class for the user object
   * @param boolean $disabled
   */
  public function setDisabled($disabled )
  {
    $this->disabled = $disabled;
  }//end public function setDisabled */


}//end class LibAclAdapter

