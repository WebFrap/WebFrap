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
class LibAclAdapter_File
{

  /**
   * singleton instance
   * @var Acl
   */
  protected static $instance    = null;

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
   *
   * @var User
   */
  protected $user               = null;

  /**
   * flag to enable or disable the check for acls
   *
   * this is a helpfull option for testing or debugging
   * don't set to true in productiv systems!
   *
   * @var boolean
   */
  protected $disabled           = false;

/*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param User $user
   */
  public function __construct($user = null )
  {

    if (!$user)
      $user = User::getActive();

    $this->user = $user;
  }//end public function __construct

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return void
   */
  public static function init()
  {
    if ( self::$instance )
      return;

    self::$instance = new Acl();

  }//end public static function init

  /**
   * Interface für das Gateway Singleton
   *
   * @return Acl
   */
  public static function getInstance()
  {
    if (!self::$instance )
      self::init();

    return self::$instance;
  }//end public static function getInstance

  /**
   * Interface für das Gateway Singleton
   *
   * @return Acl
   */
  public static function getActiv()
  {
    if (!self::$instance )
      self::init();

    return self::$instance;
  }//end public static function getActiv

/*//////////////////////////////////////////////////////////////////////////////
// getter and setter methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param User $user
   */
  public function setUser($user )
  {
    $this->user = $user;
  }//end public function setUser

  /**
   * setter class for the user object
   * @param User $user
   */
  public function setDisabled($disabled )
  {
    $this->disabled = $disabled;
  }//end public function setDisabled */

/*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $module
   */
  public function loadLists($key )
  {

    if ( isset($this->lists[$key]) )
      return false;

    $path = null;

    foreach (Conf::$confPath as $rootPath) {
      if ( file_exists($rootPath.'acl/'.$key.'.acl.php' ) ) {
        $path = $rootPath.'acl/'.$key.'.acl.php';
        break;
      }
    }

    if ($path) {
      include $path;
      $this->lists[$key] = true;

      return true;
    } else {
      $this->lists[$key] = false;

      return false;
    }

  }//end public function loadLists

  /**
   *
   * @param $key
   * @param $access
   * @return boolean
   */
  public function level($key , $access = null )
  {

    $tmp = explode(':',$key);
    $orgKey = $tmp[0];
    $files = explode( '/' , $tmp[0] ) ;
    $key = $tmp[1];

    if (is_null($access) )
      $access = $this->user->getLevel();

    $fullKey = array();

    foreach ($files as $subPath) {

      $fullKey[] = $subPath;
      $file = implode('/',$fullKey);

      if (!isset($this->level[$file][$key]) )
        if (!$this->loadLists($file) )
          if (!$this->checkLevelExtend($file, $key , $access  )  && $orgKey == $file )
            return false;

      if ( isset($this->level[$file][$key] )  ) {
        if ($this->level[$file][$key] <= $access )
          return true;
      } elseif ($this->checkLevelExtend($file, $key , $access  ) ) {
        return true;
      }

    }//end foreach

    return false;

  }//end public function level

  /**
   *
   * @param $key
   * @param $access
   * @return boolean
   */
  public function group($key , $access = null )
  {

    $tmp = explode(':',$key);
    $orgKey = $tmp[0];
    $files = explode( '/' , $tmp[0] ) ;
    $key = $tmp[1];

    if (is_null($access) )
      $access = $this->user->getGroups();

    // check all parentareas and the given area if the rights are valid
    foreach ($files as $subPath) {

      $fullKey[] = $subPath;
      $file = implode('/',$fullKey);

      if (!isset($this->group[$file][$key]) ) {
        // if this is the original Path an there are no ALCs access ist denied
        if (!$this->loadLists($file) && $orgKey == $file )
          return false;
      }

      //if there are no groupdata end we are in the last file finish here
      if (!isset($this->group[$file][$key]) && !is_array($this->group[$file][$key]) && $orgKey == $file )
        return false;

      foreach ($access as $role) {
        if ( in_array($role, $this->group[$file][$key] ) )
          return true;
        else  if ($this->checkGroupExtend($file, $key , $access  ) )
          return true;
      }

    }//end foreach

    // Wenn nichts gefunden wurde dann ist es automatisch falsch
    //$this->groupCache[$tmp[0]][$tmp[1]] = false;
    return false;

  }//end public function group


  /**
   *
   * @param $key
   * @return unknown_type
   */
  public function permission($key  )
  {

    if (defined('WBF_NO_ACL'))
      return true;

    if ($this->user->getLevel() >= User::LEVEL_FULL_ACCESS )
      return true;

    if ( is_array($key) ) {

      foreach ($key as $tmpKey) {
        if ($this->level($tmpKey) )
          return true;

        if ($this->group($tmpKey) )
          return true;
      }

    } else {
      if ($this->level($key) )
        return true;

      if ($this->group($key) )
        return true;
    }

    return false;

  }//end public function permission

  /**
   *
   * @param $path
   * @param $key
   * @param $level
   * @return boolean
   */
  public function checkLevelExtend($file, $key, $level )
  {

    if (!isset($this->extend[$file][$key] ))
      return false;

    foreach($this->extend[$file][$key] as $key )
      if ($this->level($key, $level ) )
        return true;

    return false;

  }//end public function checkLevelExtend

  /**
   *
   * @param $path
   * @param $key
   * @param $groups
   * @return unknown_type
   */
  public function checkGroupExtend($path , $key , $groups )
  {
    if (!isset($this->extend[$path][$key] ))
      return false;

    foreach($this->extend[$path][$key] as $extKey )
      if ($this->group($extKey , $groups ) )
        return true;

    return false;
  }//end public function checkGroupExtend

  /**
   *
   * @param $key
   * @param $access
   * @return boolean
   */
  public function debug( )
  {

    Debug::console('$this->level',$this->level);
    Debug::console('$this->group',$this->group);
    Debug::console('$this->extend',$this->extend);

  }//end public function debug

}//end class Acl

