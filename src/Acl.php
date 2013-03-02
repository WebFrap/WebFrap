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

if (! defined('ACL_ASSIGNED_SOURCE'))
  define('ACL_ASSIGNED_SOURCE', 'webfrap_acl_assigned_view');

if (! defined('ACL_MAX_PERMISSION'))
  define('ACL_MAX_PERMISSION', 'webfrap_acl_max_permission_view');

if (! defined('ACL_RELATION'))
  define('ACL_RELATION', 'webfrap_inject_acls_view');

if (! defined('ACL_ROLE_RELATION'))
  define('ACL_ROLE_RELATION', 'webfrap_has_arearole_view');

/**
 * @lang de:
 * Basis Klasse für die Access Controll Lists in WebFrap
 * Die Basis Klasse enthält die Hauptinstanz des ACL Objektes für den jeweils
 * aktuellen request.
 *
 * @example aktive acl objekt erfragen
 * <code>
 * $acl = Acl::getActive();
 * </code>
 *
 * @tutorial WebFrap/examples/module/acl/ExampleAcl_Controller.php
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class Acl
{

  /*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   *
   * Keine zugriffsrechte
   *
   * @var int
   */
  const DENIED = 0;

  /**
   * @lang de:
   * Darf Elemente auflisten
   * }
   * @var int
   */
  const LISTING = 1;

  /**
   * @lang de:
   * Lesene operationen sind gestatten, es dürfen jedoch keine änderungen
   * gemacht bzw übernommen werden
   * }
   * @var int
   */
  const ACCESS = 2;

  /**
   * @lang de:
   * der benuzter darf referenzen auf diesen datensatz erstellen
   * }
   * @var int
   */
  const ASSIGN = 4;

  /**
   * @lang de:
   * Der Benutzer darf zusätzlich neuen Datensätze anlegen
   * }
   * @var int
   */
  const INSERT = 8;

  /**
   * @lang de:
   * Der Benutzer darf bestehend Datensätze verändern
   * }
   * @var int
   */
  const UPDATE = 16;

  /**
   * @lang de:
   * der benutzer darf löschen
   * }
   * @var int
   */
  const DELETE = 32;

  /**
   * @lang de:
   * Der Benutzer darf Datensätze sichtbar schalten
   * }
   * @var int
   */
  const PUBLISH = 64;

  /**
   * @lang de:
   * der Benutzer darf metadaten verwalten
   * }
   * @var int
   */
  const MAINTENANCE = 128;

  /**
   * @lang de:
   * Der Benutzer darf rechte vergeben und sonstige administrative Aufgaben
   * durchführen
   * }
   * @var int
   */
  const ADMIN = 256;

  /**
   * @lang de:
   *
   * Datensatzbezogenen Einträge überschreiben lediglich
   * @var boolean
   */
  const ACL_OVERWRITE = true;

  /*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  const ROLE_SOMEWHERE = 'somewhere';

  /**
   * @var string
   */
  const ROLE_DATASET = 'dataset';

  /**
   * @var string
   */
  const OWNER = 'owner';

  /**
   * @var string
   */
  const USER = 'user';

  /**
   * @var string
   */
  const ROLE = 'role';

  /**
   * @var string
   */
  const PROFILE = 'profile';

  /*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   *
   * Liste mit allen vorhandene Zugriffsleveln.
   * Geprüft wird immer auf den maximal wert.
   * Das heißt wenn eine person zb. insert bekommt, erbt sie dadurch
   * auch alle rechte die einen kleineres zugriffslevel benötigen
   * @var array
   */
  public static $accessLevels = array(
    'denied' => 0,
    'listing' => 1,
    'access' => 2,
    'assign' => 4,
    'insert' => 8,
    'update' => 16,
    'delete' => 32,
    'publish' => 64,
    'maintenance' => 128,
    'rights' => 256,
    'admin' => 256
  );

  /**
   * @lang de:
   *
   * Liste mit allen vorhandene Zugriffsleveln.
   * Geprüft wird immer auf den maximal wert.
   * Das heißt wenn eine person zb. insert bekommt, erbt sie dadurch
   * auch alle rechte die einen kleineres zugriffslevel benötigen
   * @var array
   */
  public static $simpleAccessLevels = array(
    'none' => 0,
    'access' => 2,
    'insert' => 8,
    'update_own' => 16,
    'update' => 32,
    'delete_own' => 64,
    'delete' => 128,
    'admin' => 256
  );

  /*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * da in der regel nur ein acls objekt benötigt wird, hält ACL eine referenz
   * auf ein standard objekt vor
   * Auf dieses Objekt wird zurückgegriffen wenn keine anderes Adapter Objekt
   * expliziet übergeben wurde
   * @var LibAclAdapter
   */
  protected static $instance = null;

  /**
   * Standard instance für den ACL Manager
   * @var LibAclManager
   */
  protected static $manager = null;

  /**
   * @lang de:
   * the user level
   * @var array
   */
  protected $level = array();

  /**
   * @var array
   */
  protected $group = array();

  /**
   * @var array
   */
  protected $extend = array();

  /**
   * @var array
   */
  protected $groupCache = array();

  /**
   * @var array
   */
  protected $lists = array();

  /**
   * @var User
   */
  protected $user = null;

  /*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard Konstruktor
   *
   * Der aktive Benutzer wird geladen
   */
  public function __construct()
  {

    $this->user = User::getActive();
  } //end public function __construct

  /*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Init Methode
   * Diese Methode wird im bootstrap aufgerufen und erzeugt eine Standard
   * Instanz für die ACLs
   *
   * Auf diese Standard Instanz wird zugrückgegriffen wenn im Code kein
   * ACL Container expliziet injiziert wurde
   *
   * @param LibFlowApachemod $env
   *
   * @return void
   */
  public static function init($env)
  {

    if (self::$instance)
      return;

    if (! defined('WBF_ACL_ADAPTER')) {
      self::$instance = new LibAclAdapter_Db($env);

      // mit der WBF_NO_ACL Konstante kann ein überprüfen der rechte unterbunden werden
      if (defined('WBF_NO_ACL') && WBF_NO_ACL)
        self::$instance->setDisabled(true);

      return;
    }

    $className = 'LibAclAdapter_' . ucfirst(WBF_ACL_ADAPTER);

    self::$instance = new $className($env);

    // mit der WBF_NO_ACL Konstante kann ein überprüfen der rechte unterbunden werden
    if (defined('WBF_NO_ACL') && WBF_NO_ACL)
      self::$instance->setDisabled(true);

    return;

  } //end public static function init */

  /**
   * statische getter für das standard acl objekt
   *
   * Auf getActive darf nur zugegriffen werden wenn kein Acl objekt direkt
   * übergeben wurde
   *
   * @param LibFlowModapache $env
   *
   * @return LibAclDb
   */
  public static function getActive($env = null)
  {

    if (! self::$instance) {
      if (! $env)
        $env = Webfrap::getActive();

      self::init($env);
    }

    return self::$instance;

  } //end public static function getActive

  /**
   * statische getter für das standard acl objekt
   *
   * Auf getActive darf nur zugegriffen werden wenn kein Acl objekt direkt
   * übergeben wurde
   *
   * @param LibFlowModapache $env
   *
   * @return LibAclDb
   */
  public static function getManager($env = null)
  {

    if (! self::$manager) {
      if (! $env)
        $env = Webfrap::getActive();

      if (! defined('WBF_ACL_ADAPTER')) {
        self::$manager = new LibAclManager_Db($env);
      } else {
        $className = 'LibAclManager_' . ucfirst(WBF_ACL_ADAPTER);
        self::$manager = new $className($env);
      }
    }

    return self::$manager;

  } //end public static function getActive

  /**
   *
   * @param User $user
   */
  public function setUser($user)
  {

    $this->user = $user;
  } //end public function setUser

  /*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   */
  public function loadLists($key)
  {

    if (isset($this->lists[$key]))
      return false;

    $path = null;

    foreach (Conf::$confPath as $rootPath) {
      if (file_exists($rootPath . 'acl/' . $key . '.acl.php')) {
        $path = $rootPath . 'acl/' . $key . '.acl.php';
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

  } //end public function loadLists

  /**
   *
   * @param string $key
   * @param string $access
   * @return boolean
   */
  public function level($key, $access = null)
  {

    $tmp = explode(':', $key);
    $orgKey = $tmp[0];
    $files = explode('/', $tmp[0]);
    $key = $tmp[1];

    if (is_null($access))
      $access = $this->user->getLevel();

    $fullKey = array();

    foreach ($files as $subPath) {

      $fullKey[] = $subPath;
      $file = implode('/', $fullKey);

      if (! isset($this->level[$file][$key]))
        if (! $this->loadLists($file))
          if (! $this->checkLevelExtend($file, $key, $access) && $orgKey == $file)
            return false;

      if (isset($this->level[$file][$key])) {
        if ($this->level[$file][$key] <= $access)
          return true;
      } elseif ($this->checkLevelExtend($file, $key, $access)) {
        return true;
      }

    } //end foreach

    return false;

  } //end public function level

  /**
   *
   * @param string $key
   * @param string $access
   * @return boolean
   */
  public function group($key, $access = null)
  {

    $tmp = explode(':', $key);
    $orgKey = $tmp[0];
    $files = explode('/', $tmp[0]);
    $key = $tmp[1];

    if (is_null($access))
      $access = $this->user->getGroups();

   // check all parentareas and the given area if the rights are valid
    foreach ($files as $subPath) {

      $fullKey[] = $subPath;
      $file = implode('/', $fullKey);

      if (! isset($this->group[$file][$key])) {
        // if this is the original Path an there are no ALCs access ist denied
        if (! $this->loadLists($file) && $orgKey == $file)
          return false;
      }

      //if there are no groupdata end we are in the last file finish here
      if (! isset($this->group[$file][$key]) && ! is_array($this->group[$file][$key]) && $orgKey == $file)
        return false;

      foreach ($access as $role) {
        if (in_array($role, $this->group[$file][$key]))
          return true;
        else if ($this->checkGroupExtend($file, $key, $access))
          return true;
      }

    } //end foreach

    // Wenn nichts gefunden wurde dann ist es automatisch falsch
    //$this->groupCache[$tmp[0]][$tmp[1]] = false;
    return false;

  } //end public function group

  /**
   * @param string $key
   * @param string $entity
   * @return unknown_type
   */
  public function permission($key, $entity = null)
  {

    if (defined('WBF_NO_ACL'))
      return true;

    if ($this->user->getLevel() >= User::LEVEL_FULL_ACCESS)
      return true;

    if (is_array($key)) {

      foreach ($key as $tmpKey) {
        if ($this->level($tmpKey))
          return true;

        if ($this->group($tmpKey))
          return true;
      }

    } else {
      if ($this->level($key))
        return true;

      if ($this->group($key))
        return true;
    }

    return false;

  } //end public function permission

  /**
   *
   * @param $file
   * @param $key
   * @param $level
   *
   * @return boolean
   */
  public function checkLevelExtend($file, $key, $level)
  {

    if (! isset($this->extend[$file][$key]))
      return false;

    foreach ($this->extend[$file][$key] as $key)
      if ($this->level($key, $level))
        return true;

    return false;

  } //end public function checkLevelExtend

  /**
   *
   * @param $path
   * @param $key
   * @param $groups
   * @return unknown_type
   */
  public function checkGroupExtend($path, $key, $groups)
  {

    if (! isset($this->extend[$path][$key]))
      return false;

    foreach ($this->extend[$path][$key] as $extKey)
      if ($this->group($extKey, $groups))
        return true;

    return false;
  } //end public function checkGroupExtend

  /**
   */
  public function debug()
  {

    Debug::console('$this->level', $this->level);
    Debug::console('$this->group', $this->group);
    Debug::console('$this->extend', $this->extend);

  } //end public function debug

}//end class Acl

