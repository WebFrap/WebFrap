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
 * @lang:de
 *
 * Container zum transportieren von acl informationen.
 *
 * Wird benötigt, da ACLs in der Regel aus mehr als nur einem Zugriffslevel bestehen
 * Weiter ermöglicht der Permission Container einfach zusätzliche Checks
 * mit einzubauen.
 *
 * @example
 * <code>
 *
 *  $access = new LibAclPermission( 16 );
 *
 *  if ($access->access )
 *  {
 *    echo 'Zugriff erlaubt';
 *  }
 *
 *  if ($access->admin )
 *  {
 *    echo 'Wenn du das lesen kannst... Liest du hoffentlich nur das Beispiel hier';
 *  }
 *
 * </code>
 *
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibAclPermission
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * das einfach zugriffslevel für eine besimmte area, bzw das höchste level
   * für eine gruppe von areas
   *
   * Das höchste Level vererbt die Rechte an die jeweils tieferen.
   * > Im Moment können rechte nur erweitert und nicht eingeschränkt werden
   *
   * @var int
   */
  public $level = null;

  /**
   * @lang de:
   * Das Standard Level, dass von den Arearechten kommt
   *
   * @var int
   */
  public $defLevel = null;

  /**
   * @lang de:
   * Basis Level für alle Referenzen die keine eigene Berechtigung haben
   *
   * @var int
   */
  public $refBaseLevel = null;

  /**
   * @lang de:
   * flag zum speichern ob die berechtigungen nur auf teilbereiche zutreffen
   * oder für alle datensätze im abgefragten kontext.
   *
   * Wenn partial auf true ist, bedeutet das, dass Level lediglich das
   * minimal Level ist, der benutzer für Teilbereiche jedoch durchaus höhere
   * Berechtigungen haben kann.
   *
   * Dieses Flag ist nur dann gesetzt wenn der User NUR partiellen Zugriff hat
   *
   * @var boolean
   */
  public $isPartAccess = false;

  /**
   *
   * @var boolean
   */
  public $hasPartAccess = false;

  /**
   * @lang de:
   * Der user ist nur in relation zu bestimmten Datensätzen zugriff auf
   * die Gruppe.
   *
   * Wenn partial auf true ist, bedeutet das, dass Level lediglich das
   * minimal Level ist, der benutzer für Teilbereiche jedoch durchaus höhere
   * Berechtigungen haben kann.
   *
   * Ob Rechte als Partiell gekennzeichnet werden müssen liegt auf an dem maximal
   * notwendigen level.
   * Wenn maximal lesender zugriff benötigt wird, und dieser auch global vorhanden
   * ist muss nichtmehr geprüft werden in welchen teilen der user auch schreiben dürfte
   *
   * Beispiele:
   * User hat nur lese Rechte für eine definierte Menge von Datensätzen einer
   * Tabelle > partial = true
   *
   * Es wird nur lesen benötigt, User hat in realtion zu entity lese rechte, für
   * teile der daten jedoch auch update
   * partial = false, da nur lesen benötigt wird entfällt die notwendigkeit auf
   * einzelprüfungen
   *
   * @var boolea
   */
  public $isPartAssign   = false;

  /**
   * @lang de:
   * Im Gegensatz zu LibAclPermission::$isPartAssign wird diese Flag immer dann gesetzt
   * Wenn der User auf Teile partial Access assigned bekommen hat.
   * Das macht z.B dann Sinn, wenn der User global lesen, aber für manche
   * Einträge zb. mehr rechte hat zb. editieren oder löschen...
   *
   * @var boolean
   */
  public $hasPartAssign = false;

  /**
   * @lang de:
   * Liste der Rollen die der User in relation zu der Area Inne hat
   * @var array
   */
  public $roles     = array();

  /**
   * Relevanten Rollen die bei hasRoleSomewhere gefunden werden würden
   * hasRoleSomewhere wird dann true, wenn ein user irgendwie direkt mit
   * einer security area verknüpft ist, zb nur auf einen Datensatz, auf die ganze
   * Area oder mehrere...
   *
   * @var array
   */
  public $partRoles     = array();

  /**
   * @lang de:
   * Kindelemente in der nächste ebene des Pfades
   * Das spezifischen Level für eine Referen
   *
   * @var array
   *  @format <string key : int access_level>
   */
  public $paths     = array();

  /**
   * @lang de:
   * Liste der aller Access Level, wird in __get verwendet um einfach
   * das level abzufrage
   * @see Acl::$accessLevels
   * @var array
   */
  protected $levels     = array();

  /**
   * @lang de:
   * Frei definierbare Key / Value Paare
   * zum Beschreiben des Zugriffs auf Teilbereiche
   *
   * @var array<string:boolean>
   */
  protected $accessFlags  = array();

  /**
   * Der Haupt Area Pfad zu welchem dieser Permission Container relativ ist
   * @example 'mod-exampl/mgmt-example'
   *
   * @var string
   */
  protected $areaPath  = null;

/*//////////////////////////////////////////////////////////////////////////////
// Listen Daten
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Anzahl der Auffindbaren Datensätze in einer Liste ohne Limit
   *
   * @var int
   */
  public $sourceSize = null;

  /**
   * Query Objekt zum ermitteln der Tatsächlichen Anzahl auffindbarer Elemente
   * @var LibSqlQuery
   */
  public $calcQuery  = null;

  /**
   * Laden der Rollen relativ zu den Entries
   * @var LibAclRoleContainer
   */
  public $entryRoles = null;

  /**
   * Laden der expliziten Rollen relativ zu den Entries
   * @var LibAclRoleContainer
   */
  public $entryExplicitRoles = null;

  /**
   * Anzahl der User welche eine bestimmte Rolle relativ zu einem Datensatz
   * haben
   * @var LibAclRoleContainer
   */
  public $numExplicitUsers = null;

/*//////////////////////////////////////////////////////////////////////////////
// resources
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de
   * Der aktive ACL Adapter
   *
   * @var LibAclDb
   */
  protected $acl = null;

  /**
   * Die aktive Datenbankverbindung
   *
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * Das aktive Benutzer Objekt
   *
   * @var User
   */
  protected $user = null;

  /**
   * @var LibResponseHttp
   */
  protected $response = null;

  /**
   * @var Base
   */
  protected $env = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang:de
   * Einfacher Konstruktor,
   * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
   *
   * @param int   $level das zugriffslevel
   * @param array $level array as named parameter access_level,partial
   * {
   *    @see LibAclPermission::$level
   * }
   *
   * @param int $refLevel
   * {
   *   @see LibAclPermission::$refBaseLevel
   * }
   */
  public function __construct
  (
    $level = null,
    $refBaseLevel = null,
    $env = null
  )
  {

    Debug::console( "new ".get_class($this ).' access container' );

    if (!$env) {
      $env = Webfrap::$env;
    }

    $this->env = $env;

    $this->levels = Acl::$accessLevels;

    if (!is_null($level ) )
      $this->setPermission($level, $refBaseLevel );

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter for ACLs
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibDbConnection
   */
  public function getDb()
  {

    if (!$this->db )
      $this->db = $this->env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * @return LibDbOrm
   */
  public function getOrm()
  {

    if (!$this->db )
      $this->db = $this->env->getDb();

    return $this->db->getOrm();

  }//end public function getOrm */

  /**
   * @param LibDbConnection $db
   */
  public function setDb($db )
  {

    $this->db = $db;

  }//end public function setDb */

  /**
   * @return LibAclDb
   */
  public function getAcl()
  {

    if (!$this->acl )
      $this->acl = $this->env->getAcl();

    return $this->acl;

  }//end public function getAcl */

  /**
   * @param LibAclDb $acl
   */
  public function setAcl($acl )
  {

    $this->acl = $acl;

  }//end public function setAcl */

  /**
   * @return User
   */
  public function getUser()
  {

    if (!$this->user )
      $this->user = $this->env->getUser();

    return $this->user;

  }//end public function getUser */

  /**
   * @param User $user
   */
  public function setUser($user )
  {

    $this->user = $user;

  }//end public function setUser */

  /**
   * @return LibResponseHttp
   */
  public function getResponse()
  {

    if (!$this->response )
      $this->response = $this->env->getResponse();

    return $this->response;

  }//end public function getResponse */

/*//////////////////////////////////////////////////////////////////////////////
// Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang:de
   * Setzen der Permissions
   *
   * @param int   $level das zugriffslevel
   * @param array $level array as named parameter access_level,partial
   * {
   *   @see LibAclPermission::$level
   * }
   *
   * @param int $refLevel
   * {
   *   @see LibAclPermission::$refBaseLevel
   * }
   */
  public function setPermission
  (
    $level,
    $refBaseLevel = null
  )
  {

    if ( is_array($level ) ) {
      if ( array_key_exists( 'acl-level', $level ) ) {

        // zuweisung der rechte für die gruppe
        $this->isPartAccess   = isset($level['access-is-partial'])
          ? (int) $level['access-is-partial']  == 1
          : false;

        $this->hasPartAccess  = isset($level['access-has-partial'])
          ? (int) $level['access-has-partial']  == 1
          : false;

        // zugehörigkeit zur gruppe
        $this->isPartAssign   = isset($level['assign-is-partial'])
          ? (int) $level['assign-is-partial']  == 1
          : false;

        $this->hasPartAssign  = isset($level['assign-has-partial'])
          ? (int) $level['assign-has-partial']  == 1
          : false;

        $this->level    = (int) $level['acl-level'];

        //if (!$this->isPartAssign )
        $this->defLevel = (int) $level['acl-level'];

      } else {
        $this->level    = Acl::DENIED;
        $this->defLevel = Acl::DENIED;

        Debug::console( 'Wrong Input Format for LibAclPermission::setPermission, acl-level is missing! Fallback to denied!',$level,true );
        throw new LibAcl_Exception( 'Wrong Input Format for LibAclPermission::__construct, acl-level is missing!');
      }

    } else {

      $this->level     = (int) $level;

      //TODO CHECK THAT!
      //if (!$this->isPartAssign )
        $this->defLevel  = (int) $level;

      if (!is_null($refBaseLevel ) )
        $this->refBaseLevel = (int) $refBaseLevel;

    }

    if (DEBUG) {
      Debug::console
      (
        "Init Acl Container: ".get_class($this )
        ." isPartAccess: ".($this->isPartAccess ?'true':'false')
        ." hasPartAccess: ".($this->hasPartAccess ?'true':'false')
        ." isPartAssign: ".($this->isPartAssign ?'true':'false')
        ." hasPartAssign: ".($this->hasPartAssign ?'true':'false')
        ." level: ".$this->level
        ." defLevel: ".$this->defLevel
        ." refBaseLevel: ".$this->refBaseLevel
      );
    }

  }//end public function setPermission */

  /**
   * @lang:de
   * Updaten der Permissions
   *
   * @param int   $level das zugriffslevel
   * @param array $level array as named parameter access_level,partial
   * {
   *   @see LibAclPermission::$level
   * }
   *
   * @param int $refLevel
   * {
   *   @see LibAclPermission::$refBaseLevel
   * }
   */
  public function updatePermission
  (
    $level,
    $refBaseLevel = null
  )
  {

    if ( is_array($level) ) {
      if ( isset($level['acl-level']) ) {

        if ($this->level < (int) $level['acl-level'] )
           $this->level  = (int) $level['acl-level'];

        if ( isset($level['access-is-partial']) && (int) $level['access-is-partial']  == 1 )
          $this->isPartAccess = true;

        if ( isset($level['access-has-partial']) && (int) $level['access-has-partial']  == 1 )
          $this->hasPartAccess = true;

        if ( isset($level['assign-is-partial']) && (int) $level['assign-is-partial']  == 1 )
          $this->isPartAssign = true;

        if ( isset($level['assign-has-partial']) && (int) $level['assign-has-partial']  == 1 )
          $this->hasPartAssign = true;

        if (!$this->isPartAssign) {
          if ($this->defLevel < (int) $level['acl-level'] )
             $this->defLevel  = (int) $level['acl-level'];
        }

        if ($this->defLevel < (int) $level['acl-level'] )
           $this->defLevel  = (int) $level['acl-level'];

      }
    } else {

      if ($this->level < (int) $level )
       $this->level  = (int) $level;

      if (!$this->isPartAssign) {
        if ($this->defLevel < (int) $level )
         $this->defLevel  = (int) $level;
      }

      if ($this->defLevel < (int) $level )
        $this->defLevel  = (int) $level;

      if (!is_null($refBaseLevel) &&  $this->refBaseLevel < (int) $refBaseLevel )
        $this->refBaseLevel = (int) $refBaseLevel;

    }

    if (DEBUG) {
      Debug::console
      (
        "Update Acl Container: ".get_class($this )
        ." isPartAccess: ".($this->isPartAccess ?'true':'false')
        ." hasPartAccess: ".($this->hasPartAccess ?'true':'false')
        ." isPartAssign: ".($this->isPartAssign ?'true':'false')
        ." hasPartAssign: ".($this->hasPartAssign ?'true':'false')
        ." level: ".$this->level
        ." defLevel: ".$this->defLevel
        ." refBaseLevel: ".$this->refBaseLevel
      );
    }

  }//end public function updatePermission */

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang:de
   *
   * gibt einfach das level als string mit, um das einbinden des
   * containers zu erleichtern
   *
   * @return string das level als string
   */
  public function __toString()
  {
    return (string) $this->level;
  }//end public function __toString */

  /**
   * @lang:de
   *
   * Einfache Abfrage des Access Levels
   *
   * @return boolean
   */
  public function __get($key )
  {

    $key = strtolower($key );

    if (!isset($this->levels[$key] ) )
      return false;

    if ( Log::$levelDebug )
      Debug::console("access: $key : $this->level >= {$this->levels[$key]} ");

    return ($this->level >= $this->levels[$key] )?true:false;

  }//end public function __get */

  /**
   * access ist analog zu __get
   *
   * @return boolean
   */
  public function access($key )
  {

    if ( is_numeric($key) ) {
      return ($this->level >= $key )?true:false;
    } else {

      $key = strtolower($key );

      if (!isset($this->levels[$key] ) )
        return false;

      if ( Log::$levelDebug )
        Debug::console("access: $key : $this->level >= {$this->levels[$key]} ");

      return ($this->level >= $this->levels[$key] )?true:false;
    }

  }//end public function access */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzen der Rollen
   *
   * @param array $roles
   */
  public function setRoles($roles )
  {

    $this->roles = array();

    foreach ($roles as $role) {
      $this->roles[$role] = $role;
    }

  }//end public function setRoles */

  /**
   * Setzen der Rollen
   *
   * @return array
   */
  public function getRoles(  )
  {
    return $this->roles;

  }//end public function getRoles */

  /**
   * Ergänzen der Rollen
   *
   * @param array $roles
   */
  public function addRoles($roles )
  {

    foreach ($roles as $role) {
      $this->roles[$role] = $role;
    }

  }//end public function addRoles */

  /**
   * Ergänzen der Rollen
   *
   * @param array $roles
   */
  public function addRole($role )
  {

    $this->roles[$role] = $role;

  }//end public function addRole */

  /**
   * @lang de:
   * Erfragen ob der Benutzer in einer bestimmten Rolle ist
   *
   * @param string $roleName
   * @return boolean
   */
  public function hasRole($roleName )
  {

    if ( func_num_args() > 1 )
      $roleName = func_get_args();

    if ( is_array($roleName ) ) {

      Debug::console( "HAS ROLE: REQ: ".implode( ', ',$roleName  ).' ROLES;  '.implode( ', ',$this->roles  ) );

      foreach ($roleName as $role) {
        if ( in_array($role, $this->roles) )
          return true;
      }

      return false;

    } else {
      Debug::console( "HAS ROLE: REQ: ".$roleName.' ROLES;  '.implode( ', ',$this->roles  ) );

      return in_array($roleName, $this->roles );
    }

  }//end public function hasRole */

  /**
   * @param int $dataset
   * @param array|string $role
   * @return boolean
   */
  public function hasExplicitRole($dataset, $role )
  {

    if (!$this->entryExplicitRoles )
      return false;

    return $this->entryExplicitRoles->hasRole($dataset, $role );

  }//end public function hasExplicitRole */

  /**
   * @param int $dataset
   * @param array|string $role
   * @return int
   */
  public function numExplicitUsers($dataset, $role )
  {

    if (!$this->numExplicitUsers )
      return false;

    return $this->numExplicitUsers->getNum($dataset, $role );

  }//end public function numExplicitUsers */

/*//////////////////////////////////////////////////////////////////////////////
//  partielle rollen
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * prüfen ob eine Benutzer zumindest irgendwie ein relatives Gruppenmitglied
   * ist.
   *
   * Relativ bedeutet in relation zu einem Datensatz oder zu einer Security-Area
   *
   * @param string $roleName
   * @return boolean
   */
  public function hasRoleSomewhere($roleName )
  {

    if ( is_array($roleName ) ) {

      foreach ($roleName as $role) {
        if ( in_array($role, $this->partRoles) )
          return true;
      }

      return false;

    } else {
      return in_array($roleName, $this->partRoles );
    }

  }//end public function hasRoleSomewhere */

  /**
   * Ergänzen der Rollen
   *
   * @param array $roles
   */
  public function addRolesSomewhere($roles )
  {

    foreach ($roles as $role) {
      $this->partRoles[$role] = $role;
    }

  }//end public function addRolesSomewhere */

  /**
   * Ergänzen der Rollen
   *
   * @param array $roles
   */
  public function addRoleSomewhere($role )
  {

    $this->partRoles[$role] = $role;

  }//end public function addRoleSomewhere */

/*//////////////////////////////////////////////////////////////////////////////
//  path
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   *
   * @param string $key
   * @param int $access
   * @return boolean
   */
  public function checkRefAccess($key, $access )
  {

    if (!isset($this->paths[$key] ) ) {
      return ($this->refBaseLevel >= $access );
    } else {
      return ($this->paths[$key] >= $access );
    }

  }//end public function checkRefAccess */

  /**
   * @lang de:
   *
   * @param string $key
   * @return boolean
   */
  public function getPathLevel($key )
  {
    return isset($this->paths[$key] )
      ? $this->paths[$key]
      : $this->refBaseLevel;

  }//end public function getPathLevel */

  /**
   * Einfacher Setter für das Pathlevel
   *
   * @param string $key
   * @param int $level
   * @return boolean
   */
  public function setPathLevel($key, $level )
  {

    $this->paths[$key] = $level;

  }//end public function setPathLevel */

  /**
   * Erweitert das Level auf einem Pfad.
   * Wenn der Pfad nicht existiert wird er angelegt,
   * wenn er existiert dann angepasst wenn das neue level größer
   * als das bereits vorhandene ist
   *
   * @param string $key
   * @param int $level
   */
  public function extendPathLevel($key, $level )
  {

    if (!isset($this->paths[$key] ) ) {
      $this->paths[$key] = $level;
    } else {
      if ($this->paths[$key] < $level) {
        $this->paths[$key] = $level;
      }
    }

  }//end public function extendPathLevel */

/*//////////////////////////////////////////////////////////////////////////////
// Arbeiten mit den Keys
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Keys einfach überschreiben
   * @param array $flags
   */
  public function setAccessFlags( array $flags )
  {
    $this->accessFlags = $flags;
  }//end public function setAccessFlags */

  /**
   * check if the person has access to this area
   * @param string $key
   */
  public function hasAccess($key )
  {
    if (!isset($this->accessFlags[$key] ) )
      return false;

    return $this->accessFlags[$key];
  }//end public function hasAccess */

/*//////////////////////////////////////////////////////////////////////////////
// Loader Method, automatisches Mapping des richtigen Loaders passend zum
// aktiven Profil. Über die Profile kann, das laden optimiert werden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard lade Funktion für den Access Container
   * Mappt die Aufrufe auf passene Profil loader soweit vorhanden.
   *
   * @param string $profil der namen des Aktiven Profil als CamelCase
   * @param TFlag $params
   * @param Entity $entity
   */
  public function load($profil, $params, $entity = null  )
  {

    ///TODO Den Pfad auch noch als möglichkeit für die Diversifizierung einbauen

    if ( is_object($profil) )
      $profil = $profil->getProfileName();

    // sicherheitshalber den String umbauen
    $profil = SParserString::subToCamelCase($profil);

    if ( method_exists($this, 'load_Profile_'.$profil  ) ) {
      $this->{'load_Profile_'.$profil}($params, $entity );
    } else {
      $this->loadDefault($params, $entity );
    }

  }//end public function load */

  /**
   * Standard lade Funktion für den Access Container
   * Mappt die Aufrufe auf passene Profil loader soweit vorhanden.
   *
   * @param string $profil der namen des Aktiven Profil als CamelCase
   * @param LibSqlQuery $query
   * @param string $context
   * @param TFlag $params
   * @param Entity $entity
   */
  public function fetchListIds($profil, $query, $context, $params, $entity = null  )
  {

    ///TODO Den Pfad auch noch als möglichkeit für die Diversifizierung einbauen

    // sicherheitshalber den String umbauen
    $profil   = SParserString::subToCamelCase($profil );
    $context  = ucfirst( strtolower($context ) );

    if ( method_exists($this, 'fetchList_'.$context.'_Profile_'.$profil  ) ) {
      return $this->{'fetchList_'.$context.'_Profile_'.$profil}($query, $params, $entity );
    } else {
      return $this->{'fetchList'.$context.'Default'}($query, $params, $entity );
    }

  }//end public function fetchListIds */

  /**
   * Erfragen der tatsächlichen Anzahl gefundener Elemente, wenn kein Limit
   * gesetzt worden wäre
   *
   * Zu diesem Zweck muss leider eine 2te Query ausgeführt werden die ohne
   * Limit ein Count auf die Anzahl Elemente ausführt
   *
   * @return int
   */
  public function getSourceSize()
  {

    if (is_null($this->sourceSize)) {

      if (!$this->calcQuery )
        return null;

      if ( is_string($this->calcQuery ) ) {
        if ($res = $this->getDb()->select($this->calcQuery ) ) {
          $tmp = $res->get();

          if (!isset($tmp[Db::Q_SIZE])) {

            if (Log::$levelDebug)
              Debug::console('got no Db::Q_SIZE');

            $this->sourceSize = 0;
          } else {
            $this->sourceSize = $tmp[Db::Q_SIZE];
          }

        }
      } else {
        if ($res = $this->getDb()->getOrm()->select($this->calcQuery ) ) {
          $tmp =  $res->get();
          if (!isset($tmp[Db::Q_SIZE])) {

            if (Log::$levelDebug)
              Debug::console('got no Db::Q_SIZE');

            $this->sourceSize = 0;
          } else {
            $this->sourceSize = $tmp[Db::Q_SIZE];
          }
        }
      }

    }

    return $this->sourceSize;

  }//end public function getSourceSize */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $area
   * @param array $id
   * @param array $roles die relevanten Rollen
   */
  public function loadEntryRoles($area, $id, $roles = array() )
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $entryRoles = $acl->getRoles($area, $id, $roles );

    // dafür sorgen, das für alle ids zumindest ein leerer array vorhanden ist
    // bzw, dass potentiell vorhandenen rollen sauber gemerged werden
    foreach ($id as $id) {

      if ( isset($entryRoles[$id] ) ) {
        if (!isset($this->entryRoles[$id] ) )
          $this->entryRoles[$id] = $entryRoles[$id];
        else
          $this->entryRoles[$id] = array_merge($this->entryRoles[$id], $entryRoles[$id] );
      } else {
        if (!isset($this->entryRoles[$id] ) )
          $this->entryRoles[$id] = array();
      }

    }

  }//end public function loadEntryRoles */

  /**
   * @param string $area
   * @param array $id
   * @param array $roles die relevanten Rollen
   */
  public function loadEntryExplicitRoles($area, $id, $roles = array() )
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $entryExplicitRoles = $acl->getRolesExplicit($area, $id, $roles );

    if (!$this->entryExplicitRoles) {
      $this->entryExplicitRoles = $entryExplicitRoles;
    } else {
      $this->entryExplicitRoles->merge($entryExplicitRoles );
    }

  }//end public function loadEntryExplicitRoles */

  /**
   * @param string $area
   * @param array $id
   * @param array $roles die relevanten Rollen
   */
  public function loadNumExplicitUsers($area, $id, $roles = array() )
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $entryExplicitRoles = $acl->getNumUserExplicit($area, $id, $roles );

    if (!$this->numExplicitUsers) {
      $this->numExplicitUsers = $entryExplicitRoles;
    } else {
      $this->numExplicitUsers->merge($entryExplicitRoles );
    }

  }//end public function loadNumExplicitUsers */

}//end class LibAclPermission

