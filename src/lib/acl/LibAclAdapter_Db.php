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
 * @lang de:
 *
 * Der Datenbank Adapter für die ACLs
 *
 * @package WebFrap
 * @subpackage tech_core
 *
 * @todo die queries müssen noch in query objekte ausgelagert werden
 *
 */
class LibAclAdapter_Db extends LibAclAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $sourceAssigned = ACL_ASSIGNED_SOURCE;

  /**
   * @var string
   */
  public $sourceMaxPermission = ACL_MAX_PERMISSION;

  /**
   * @var string
   */
  public $sourceRelation = ACL_RELATION;

  /**
   * @var string
   */
  public $roleRelation = ACL_ROLE_RELATION;

  /**
   * Das Modell zum laden der benötigten Daten
   * @var LibAcl_Db_Model
   */
  protected $model = null;

  /**
   * Liste mit Root Containern
   * @var LibAclRoot[]
   */
  protected $rootContainers = array();

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Getter mit Autocreate für das ACL Modell
   *
   * @return LibAcl_Db_Model
   */
  public function getModel()
  {

    if ($this->model) {
      return $this->model;
    }

    $this->model = new LibAcl_Db_Model($this);

    $cache = $this->getCache()->getLevel1();

    if ($cache) {
      $this->model->setAclCache($cache);
    }

    return $this->model;

  }//end public function getModel */

  /**
   * @param LibDbConnection $db
   */
  public function setDb($db)
  {

    $this->db = $db;

    $model = $this->getModel();
    $model->setDb($db);

  }//end public function setDb */

  /**
   * @param User $user
   */
  public function setUser($user)
  {

    $this->user = $user;

    $model = $this->getModel();
    $model->setUser($user);

  }//end public function setUser */

/*//////////////////////////////////////////////////////////////////////////////
// public interface
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibFlowApachemod $env
   * @param LibDbConnection $db
   */
  public function __construct($env = null, $db = null)
  {

    $this->levels = Acl::$accessLevels;

    if (!$env)
      $env = Webfrap::getActive();

    $this->env = $env;
    $this->db = $db;

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibAclManager_Db
   */
  public function getManager()
  {

    if ($this->manager)
      return $this->manager;

    $this->manager = new LibAclManager_Db($this);

    return $this->manager;

  }//end public function getManager */

  /**
   * @return LibAclManager_Db
   */
  public function getReader()
  {

    if ($this->reader)
      return $this->reader;

    $this->reader = new LibAclReader_Db($this);

    return $this->reader;

  }//end public function getReader */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @lang de:
   *
   * das zugriffslevel des aktiven benutzers für die übergebenen security
   * areas abfragen
   *
   * die entity ist optional.
   * Wenn ein entity objekt mitübergeben wird prüft die abfrage ob der
   * benutzer auch rechte in relation zu dem per entity übergebenen datensatz
   * hat
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2>mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security areas</a>
   * }
   *
   * @param Entity $entity Das Entity Objekt
   * @param boolean $loadRoles sollen die Rollen auch geladen werden?
   * @param LibAclPermission $container Der Container in welchen die Daten sollen kann mit übergeben werden
   * @param boolean $extend
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function injectDsetRoles(
    $container,
    $key,
    $entity = null
  ) {

    if (DEBUG)
      Debug::console("injectDsetRoles {$key}");

    // resources
    $model = $this->getModel();

    // sicher stellen, dass vorhanden
    $checkAreas = $model->extractWeightedKeys($key);

    $container->addRoles($model->loadUserRoles($checkAreas, $entity));

    return $container;

  }//end public function injectDsetRoles */

  /**
   * @lang de:
   *
   * das zugriffslevel des aktiven benutzers für die übergebenen security
   * areas abfragen
   *
   * die entity ist optional.
   * Wenn ein entity objekt mitübergeben wird prüft die abfrage ob der
   * benutzer auch rechte in relation zu dem per entity übergebenen datensatz
   * hat
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param LibAclPermission $container Der Container in welchen die Daten sollen kann mit übergeben werden
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2>mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security areas</a>
   * }
   *
   * @param Entity $entity Das Entity Objekt
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function injectDsetLevel(
    $container,
    $key,
    $roles,
    $entity = null,
    $loadRefs = false
  ) {

    if (DEBUG)
      Debug::console("injectDsetLevel {$key}");

    // resources
    $user = $this->getUser();
    $userLevel = $user->getLevel();
    $model = $this->getModel();

    $areaKeys = $model->extractWeightedKeys($key);

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {
      $container->setPermission(Acl::ADMIN, Acl::ADMIN);
      return $container;
    }

    $permission = $model->loadAreaGroupPermission($areaKeys, $roles);
    $areaLevels = $model->extractAreaAccessLevel($areaKeys);

    // prüfen ob das area level größer ist als als die permission
    if (!isset($permission['acl-level'])) {
      $permission['acl-level'] = $areaLevels['access'];
    } elseif ($areaLevels['access'] > $permission['acl-level']) {
      $permission['acl-level'] = $areaLevels['access'];
    }

    if (!isset($permission['ref-level'])) {
      $permission['ref-level'] = $areaLevels['ref'];
    } elseif ($areaLevels['ref'] > $permission['ref-level']) {
      $permission['ref-level'] = $areaLevels['ref'];
    }

    $globalLevel = $model->loadGloalPermission($areaKeys);

    if ($globalLevel) {
      if ($globalLevel > $permission['acl-level'])
        $permission['acl-level'] = $globalLevel;

      $permission['assign-is-partial'] = false;
    }

    Debug::console('updatePermission $permission',$permission, false,true);

    $container->updatePermission($permission);

    return $container;

  }//end public function injectDsetLevel */

  /**
   * @lang de:
   * Das Zugriffslevel auf die übergebene Area, sowie alle zugriffslevel
   * auf die Referenzen welche auf den übergeben Datensatz verweisen
   * auslesen.
   *
   * @todo besser kommentieren
   * @param string $root access_key der root security_area
   * @param int    $rootId rowid des datensatze von dem der pfad ausgeht
   * @param int    $level position in der area hirachie
   * @param string $parentKey access_key der parent security_area
   * @param int    $parentId rowid der
   *
   * @param LibAclPermission $container
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function injectDsetPathPermission(
    $container,
    $root,
    $rootId,
    $level,
    $parentKey,
    $parentId,
    $nodeKey,
    $refEntity = null,
    $loadChildren = false
  ) {

    Debug::console(
      "injectDsetPathPermission(root: $root, rootId: $rootId, level: $level, "
      ."parentKey: $parentKey, parentId: $parentId, modeKey: $nodeKey, refEntity: $refEntity)"
    );

    $user = $this->getUser();
    $model = $this->getModel();


    if (!$rootNode = $model->getAreaNode($root)) {
      Debug::console("Keine Id für Area {$root} bekommen");
      return $container;
    }

    if ('mgmt' == substr($rootNode->parent_key,0,4))
      $whereRootArea = array($root, $rootNode->parent_key);
    else
      $whereRootArea = $root;

    $roles = $model->loadUserRoles($whereRootArea, $rootId);

      // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {

      $container->setPermission(Acl::ADMIN, Acl::ADMIN);
      $container->addRoles($roles);

      return $container;
    }

    ///FIXME sh
    // das aktuelle sh ist dass der pfad zum rootnode
    // nicht direkt geprüft wird
    // das muss noch eingebaut werden
    $permission = $model->loadAccessPathNode(
      $root, // wird benötigt um den passenden startpunkt zu finden
      $rootId, // die rowid der root area
      $level, // das level in dem wir uns aktuell befinden
      $parentKey, // parent wird benötigt da es theoretisch auf dem gleichen level mehrere nodes des gleichen types geben kann
      $parentId, // die id des parent nodes
      $nodeKey, // der key des aktuellen reference node
      $container->roles // gruppen rollen in denen der user sich relativ zum rootnode befinden
    );

    $areaLevels = $model->extractAreaAccessLevel(array($parentKey));

    // prüfen ob das area level größer ist als als die permission
    if (!isset($permission['acl-level'])) {
      $permission['acl-level'] = $areaLevels['access'];
    } elseif ($areaLevels['access'] > $permission['acl-level']) {
      $permission['acl-level'] = $areaLevels['access'];
    }

    if (!isset($permission['ref-level'])) {
      $permission['ref-level'] = $areaLevels['ref'];
    } elseif ($areaLevels['ref'] > $permission['ref-level']) {
      $permission['ref-level'] = $areaLevels['ref'];
    }

    if (DEBUG)
      Debug::console(
        "acl-level ".(isset($permission['acl-level'])?$permission['acl-level']:'not set').' areaLevel '
        .implode(', ',$areaLevels). ' pkey: '.$parentKey
      );

    if (!isset($permission['acl-level'])) {
      $permission['acl-level'] = Acl::DENIED;
    }

    $container->addRoles($roles);
    $container->updatePermission($permission);

    if ($loadChildren) {
      // der aktuelle node ist zugleich auch der rootnode
      $path = $model->loadAccessPathChildren($root, $nodeKey, $container->roles, $level+1);
      $container->paths = $path;

      if (DEBUG)
        Debug::console("Container PATH ", $container->paths);
    }

    if (DEBUG)
      Debug::console(
          "getPathPermission level: {$container->level}  defLevel: {$container->defLevel}  "
          ."refBaseLevel: {$container->refBaseLevel} roles: ".implode(', ',$container->roles). ' pkey: '.$parentKey
    );

    return $container;

  }//end public function injectDsetPathPermission */



  /**
   * @param LibAclPermission $container
   * @param string $aclRoot
   * @param string $aclRootId
   * @param string $aclLevel
   * @param string $aclNode
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function injectDsetRootPermission(
    $container,
    $aclRoot,
    $aclRootId,
    $aclLevel,
    $aclNode,
    $entity = null
  ) {

    if (DEBUG)
      Debug::console("injectDsetRootPermission {$aclRoot} {$aclRootId}");

    // checken ob rechte über den rootcontainer bis hier her vereerbt
    // werden sollen
    try {
      $rootContainer = $this->getRootContainer($aclRoot);

      $rootPerm = $rootContainer->getRefAccess($aclRootId, $aclLevel, $aclNode);

      if ($rootPerm) {
        if (!$container->defLevel || $rootPerm['level'] > $container->defLevel) {
          $container->defLevel = $rootPerm['level'];
        }
        if (!$container->level || $rootPerm['level'] > $container->level) {
          $container->level = $rootPerm['level'];
        }
      }

      if ($rootPerm['roles']) {
        $container->roles = array_merge($container->roles, $rootPerm['roles']);
      }

    } catch (LibAcl_Exception $e) {

    }

    return $container;

  }//end public function injectDsetLevel */

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/


  /**
   * @lang de:
   * Methode zum prüfen ob ein Benutzer rechte auf eine bestimmte Area hat.
   *
   * Besonderheit, hier wird der key noch in der area mit übergeben
   * @param string $key
   * {
   *  @example mod-example/entiy-hello_world>mgmt-hello_world:access
   * }
   *
   * @param Entity $entity Wenn eine Entity übergeben wird, wird geprüft ob ein zugriff
   *  relativ zu der gegebenen Entity erlaubt ist
   *
   * @param boolean $partital mit partial wird definiert ob es reicht partiellen
   *  zugriff auf etwas zu haben, wenn partial false ist müssen komplette zugriffsrechte
   *  vorhanden sein.
   *
   *  Partial wird zB. bei Menüpunkten benötigt
   *
   *
   * @return boolean
   */
  public function access($key, $entity = null, $partial = false)
  {

    if ($this->disabled)
      return true;

    $user = $this->getUser();

    if ($user->checkLevel(User::LEVEL_FULL_ACCESS))
      return true;

    $model = $this->getModel();

    $tmp = explode(':', $key);

    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = $model->extractWeightedKeys($tmp[0]);

    // access is das level das übergeben wurde
    $access = $tmp[1];

    $areaLevel = $model->extractAreaAccessLevel($paths);
    $level = $model->loadAreaAccess($paths, $entity, $partial);

    // prüfen ob das area level größer ist als als die permission
    if ($areaLevel['access'] && $areaLevel['access'] > $level) {
      $level = $areaLevel['access'];
    }

    if (is_null($level))
      return false;

    // erst mal prüfen ob direkter zugriff möglich ist
    if (!is_null($level) && $level >= $this->levels[$access])
      return true;

    // tja das war nun wohl nix
    return false;

  }//end public function access */

  /**
   * @lang de:
   *
   * das zugriffslevel des aktiven benutzers für die übergebenen security
   * areas abfragen
   *
   * die entity ist optional.
   * Wenn ein entity objekt mitübergeben wird prüft die abfrage ob der
   * benutzer auch rechte in relation zu dem per entity übergebenen datensatz
   * hat
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2>mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security areas</a>
   * }
   *
   * @param Entity $entity Das Entity Objekt
   * @param array $roles sollen die Rollen auch geladen werden?
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function getLevel(
    $key,
    $entity = null,
    $roles = array()
  ) {

    if (DEBUG)
      Debug::console("getLevel {$key}");

    $user = $this->getUser();
    $userLevel = $user->getLevel();
    $model = $this->getModel();

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {
      return Acl::ADMIN;
    }

    // den key verarbeiten
    $tmp = explode(':', $key);

    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = $model->extractWeightedKeys($key);

    $areaLevels = $model->extractAreaAccessLevel($paths, $entity);
    $permission = $model->loadAreaLevel($paths, $entity, $roles);

    // prüfen ob das area level größer ist als als die permission
    if (!$permission) {
      return $areaLevels['access'];
    } elseif ($areaLevels['access'] > $permission) {
      return $areaLevels['access'];
    }

    return $permission;

  }//end public function getLevel */

  /**
   * Wir bei Referenzen verwendet um die Rechte von einem Root Container laden zu können
   *
   * @param $key string den Rootcontainer erfragen
   * @return LibAclRoot
   */
  public function getRootContainer($key)
  {

    Debug::console('request root container '.$key);

    if (isset($this->rootContainers[$key]))
      return $this->rootContainers[$key];

    $containerName = SParserString::subToCamelCase(substr($key, 5)).'_Crud_Access_Root';

    if (!Webfrap::classExists($containerName))
      throw new LibAcl_Exception("Requested nonexisting Root Container ".$containerName);

    $this->rootContainers[$key] = new $containerName($this);

    return $this->rootContainers[$key];

  }//end public function getRootContainer */

  /**
   * checks if a use has the permission for a given area
   *
   * @param string $key
   * @param array/entity $ids
   * @return boolean
   */
  public function getPermissions($key, $ids)
  {

    if ($this->disabled)
      return true;

    $user = $this->getUser();

    $userLevel = $user->getLevel();

    if ($userLevel >= User::LEVEL_FULL_ACCESS)
      return true;

    $model = $this->getModel();

    $keyData = $model->extractKeys($key);
    $key = $keyData[0];

    if ($data = $model->loadUserAreaPermissions($key)) {

      $tmp = array();

      foreach ($ids as $id) {
        $tmp[] = array_merge($data, array('rowid' => $id));
      }

      return $tmp;

    } elseif (!$ids) {
      return array();
    }

  }//end public function getPermissions */



  /**
   * @lang de:
   *
   * das zugriffslevel des aktiven benutzers für die übergebenen security
   * areas abfragen
   *
   * die entity ist optional.
   * Wenn ein entity objekt mitübergeben wird prüft die abfrage ob der
   * benutzer auch rechte in relation zu dem per entity übergebenen datensatz
   * hat
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2>mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security areas</a>
   * }
   *
   * @param Entity $entity Das Entity Objekt
   * @param boolean $loadRoles sollen die Rollen auch geladen werden?
   * @param LibAclPermission $container Der Container in welchen die Daten sollen kann mit übergeben werden
   * @param boolean $extend
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function getPermission(
    $key,
    $entity = null,
    $loadRoles = false,
    $container = null,
    $extend = false
  ) {

    if (!$container)
      $container = new LibAclPermission;

    if (DEBUG)
      Debug::console("getPermission {$key}");

    // resources
    $user = $this->getUser();
    $userLevel = $user->getLevel();
    $model = $this->getModel();

    // sicher stellen, dass vorhanden
    $roles = array();
    $checkAreas = array();


    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = $model->extractWeightedKeys($key);


    // rollen müssen immer geladen werden
    if ($loadRoles){
      $roles = $model->loadUserRoles($paths, $entity);
      $container->addRoles($roles);
    }

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {

      $container->setPermission(Acl::ADMIN, Acl::ADMIN);
      return $container;
    }

    // standard check
    $areaLevels = $model->extractAreaAccessLevel($paths, $entity);
    $permission = $model->loadAreaPermission($paths, $entity);

    // prüfen ob das area level größer ist als als die permission
    if (!isset($permission['acl-level'])) {
      $permission['acl-level'] = $areaLevels['access'];
    } elseif ($areaLevels['access'] > $permission['acl-level']) {
      $permission['acl-level'] = $areaLevels['access'];
    }

    if (!isset($permission['ref-level'])) {
      $permission['ref-level'] = $areaLevels['ref'];
    } elseif ($areaLevels['ref'] > $permission['ref-level']) {
      $permission['ref-level'] = $areaLevels['ref'];
    }

    $globalLevel = $model->loadGloalPermission($paths);

    if ($globalLevel) {
      if ($globalLevel > $permission['acl-level'])
        $permission['acl-level'] = $globalLevel;

      $permission['assign-is-partial'] = false;
    }

    // sollen die permissions im container erweitert werden?
    if ($extend) {

      $container->updatePermission($permission);

    } else {// wenn nicht werden vorhandene permissions überschrieben

      $container->setPermission($permission);

    }

    return $container;

  }//end public function getPermission */

  /**
   * @lang de:
   *
   * das zugriffslevel des aktiven benutzers für die übergebenen security
   * areas abfragen
   *
   * die entity ist optional.
   * Wenn ein entity objekt mitübergeben wird prüft die abfrage ob der
   * benutzer auch rechte in relation zu dem per entity übergebenen datensatz
   * hat
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2>mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security areas</a>
   * }
   *
   * @param Entity $entity Das Entity Objekt
   * @param boolean $loadRoles sollen die Rollen auch geladen werden?
   * @param LibAclPermission $container Der Container in welchen die Daten sollen kann mit übergeben werden
   * @param boolean $extend
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function getListPermission(
    $key,
    $entity = null,
    $loadRoles = false,
    $container = null,
    $extend = false
  ) {

    if (!$container)
      $container = new LibAclPermission;

    if (DEBUG)
      Debug::console("getPermission {$key}");

    $user = $this->getUser();
    $userLevel = $user->getLevel();
    $model = $this->getModel();

    // den key verarbeiten
    $tmp = explode(':', $key);

    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = explode('>', $tmp[0]);

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {
      $container->setPermission(Acl::ADMIN, Acl::ADMIN);

      if (count($paths) > 1) {
        $parentAreas = explode('/', $paths[0]);
        $mainAreas = explode('/', $paths[1]);

        // rollen müssen immer geladen werden
        if ($loadRoles)
          $roles = $model->loadUserRoles(array_merge($parentAreas,$mainAreas), $entity);

      } else {
        $parentAreas = null;
        $mainAreas = explode('/', $paths[0]);

        // rollen müssen immer geladen werden
        if ($loadRoles)
          $roles = $model->loadUserRoles($mainAreas, $entity);
      }

      if ($loadRoles)
        $container->roles = $roles;

      return $container;
    }

    $checkAreas = array();

    // standard check
    if (count($paths) > 1) {
      $parentAreas = explode('/', $paths[0]);
      $mainAreas = explode('/', $paths[1]);

      $checkAreas = array_merge($parentAreas, $mainAreas);

      if ($loadRoles)
        $roles = $model->loadUserRoles($checkAreas, $entity);

      $areaLevel = $model->extractAreaAccessLevel($checkAreas, $entity);

    } else {
      $parentAreas = null;
      $mainAreas = explode('/', $paths[0]);

      $checkAreas = $mainAreas;

      if ($loadRoles)
        $roles = $model->loadUserRoles($checkAreas, $entity);

      $areaLevel = $model->extractAreaAccessLevel($checkAreas, $entity);

    }

    $permission = $model->loadAreaPermission($checkAreas, $entity);

    // prüfen ob das area level größer ist als als die permission
    if ($areaLevel['access']) {
      if (!isset($permission['acl-level'])) {
        $permission['acl-level'] = $areaLevel['access'];
      } elseif ($areaLevel['access'] > $permission['acl-level']) {
        $permission['acl-level'] = $areaLevel['access'];
      }
    }

    $globalLevel = $model->loadGloalPermission($checkAreas);

    if ($globalLevel) {
      if ($globalLevel > $permission['acl-level'])
        $permission['acl-level'] = $globalLevel;

      $permission['assign-is-partial'] = false;
    }

    if ($extend) {
      if ($loadRoles)
        $container->addRoles($roles);

      $container->updatePermission($permission);

    } else {

      if ($loadRoles)
        $container->setRoles($roles);

      $container->setPermission($permission);
    }

    return $container;

  }//end public function getListPermission */

  /**
   * @lang de:
   * Das Zugriffslevel auf die übergebene Area, sowie alle zugriffslevel
   * auf die Referenzen welche auf den übergeben Datensatz verweisen
   * auslesen.
   *
   * Da Referenzen nur im Editmode sinn machen ist die entity hier nicht optional
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2/mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security Areas</a>
   * }
   *
   *
   * @param Entity $entity
   * @param boolean $loadChildren sollen die Rechte für die referenzen mitgeladen werden
   * @param LibAclPermission $container
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function getFormPermission(
    $key,
    $entity,
    $loadChildren = true,
    $container = null
  ) {

    if (!$container)
      $container = new LibAclPermission();

    $user = $this->getUser();
    $model = $this->getModel();

    // den key verarbeiten
    $tmp = explode(':', $key);

    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = explode('>', $tmp[0]);

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {
      $container->setPermission(Acl::ADMIN, Acl::ADMIN);

      if (count($paths) > 1) {
        $parentAreas = explode('/', $paths[0]);
        $mainAreas = explode('/', $paths[1]);

        // rollen müssen immer geladen werden
        $roles = $model->loadUserRoles(array_merge($parentAreas, $mainAreas), $entity);

      } else {
        $parentAreas = null;
        $mainAreas = explode('/', $paths[0]);

        // rollen müssen immer geladen werden
        $roles = $model->loadUserRoles($mainAreas, $entity);
      }

      $container->roles = $roles;

      return $container;
    }

    // ansonsten normales laden
    if (count($paths) > 1) {

      $parentAreas = explode('/', $paths[0]);
      $mainAreas = explode('/', $paths[1]);

      $allAreas = array_merge($parentAreas, $mainAreas);

      $roles = $model->loadUserRoles($allAreas, $entity);
      $areaLevel = $model->extractAreaAccessLevel($allAreas);
      $areaRefLevel = $model->extractAreaRefAccessLevel($allAreas);

    } else {

      $parentAreas = null;
      $mainAreas = explode('/', $paths[0]);
      $allAreas = $mainAreas;

      $roles = $model->loadUserRoles($mainAreas, $entity);
      $areaLevel = $model->extractAreaAccessLevel($mainAreas);
      $areaRefLevel = $model->extractAreaRefAccessLevel($mainAreas);
    }

    $permission = $model->loadAreaPermission($allAreas, $entity);

    // prüfen ob das area level größer ist als als die permission
    if ($areaLevel) {
      if (!isset($permission['acl-level'])) {
        $permission['acl-level'] = $areaLevel;
      } elseif ($areaLevel  >  $permission['acl-level']) {
        $permission['acl-level'] = $areaLevel;
      }
    }

    $globalLevel = $model->loadGloalPermission($allAreas);

    if ($globalLevel) {
      if ($globalLevel > $permission['acl-level'])
        $permission['acl-level'] = $globalLevel;

      $permission['assign-is-partial'] = false;
    }

    if (DEBUG)
      Debug::console("SET PERMISSION ",$permission);

    $container->setPermission($permission);
    $container->roles = $roles;

    Debug::console('GOT ROLES '.implode(', ', $roles));

    if ($loadChildren) {

      array_shift($allAreas);

      // der aktuelle node ist zugleich auch der rootnode
      $path = $model->loadAccessPathChildren($allAreas, $allAreas, $roles, 2);
      $container->paths = $path;

      if (DEBUG)
        Debug::console("CONTAINER PATH ",$container->paths);
    }

    $container->refBaseLevel = $areaRefLevel;

    if ($areaLevel)
      $container->defLevel = $areaLevel;

    return $container;

  }//end public function getFormPermission */

  /**
   * @lang de:
   * Das Zugriffslevel auf die übergebene Area, sowie alle zugriffslevel
   * auf die Referenzen welche auf den übergeben Datensatz verweisen
   * auslesen.
   *
   * Da Referenzen nur im Editmode sinn machen ist die entity hier nicht optional
   *
   * wenn die constante WFB_NO_LOGIN auf true definiert wurde gibt diese
   * methode immer true zurück
   * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=debug.constants" >Debug Flags</a>
   *
   * @param string $key
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2/mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security Areas</a>
   * }
   *
   *
   * @param Entity $entity
   * @param boolean $loadChildren sollen die Rechte für die referenzen mitgeladen werden
   * @param LibAclPermission $container
   *
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function getDsetRefPermissions
  (
    $key,
    $entity,
    $container = null
)
  {

    if (!$container)
      $container = new LibAclPermission();

    $user = $this->getUser();
    $model = $this->getModel();

    // den key verarbeiten
    $tmp = explode(':', $key);

    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = explode('>', $tmp[0]);

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {
      $container->setPermission(Acl::ADMIN, Acl::ADMIN);

      return $container;
    }

    // ansonsten normales laden
    if (count($paths) > 1) {

      $parentAreas = explode('/', $paths[0]);
      $mainAreas = explode('/', $paths[1]);

      $allAreas = array_merge($parentAreas, $mainAreas);

      $roles = $model->loadUserRoles($allAreas, $entity);
      $areaRefLevel = $model->extractAreaRefAccessLevel($allAreas);

    } else {

      $parentAreas = null;
      $mainAreas = explode('/', $paths[0]);
      $allAreas = $mainAreas;

      $roles = $model->loadUserRoles($mainAreas, $entity);
      $areaRefLevel = $model->extractAreaRefAccessLevel($mainAreas);
    }

    array_shift($allAreas);

    // der aktuelle node ist zugleich auch der rootnode
    $path = $model->loadAccessPathChildren($allAreas, $allAreas, $roles, 2);
    $container->paths = $path;

    if (DEBUG)
      Debug::console("CONTAINER PATH ",$container->paths);

    $container->refBaseLevel = $areaRefLevel;

    return $container;

  }//end public function getDsetRefPermissions */

  /**
   * @lang de:
   * Das Zugriffslevel auf die übergebene Area, sowie alle zugriffslevel
   * auf die Referenzen welche auf den übergeben Datensatz verweisen
   * auslesen.
   *
   * @todo besser kommentieren
   * @param string $root access_key der root security_area
   * @param int    $rootId rowid des datensatze von dem der pfad ausgeht
   * @param int    $level position in der area hirachie
   * @param string $parentKey access_key der parent security_area
   * @param int    $parentId rowid der
   *
   * @param LibAclContainer $container
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   */
  public function getPathPermission
  (
    $root,
    $rootId,
    $level,
    $parentKey,
    $parentId,
    $nodeKey,
    $refEntity = null,
    $loadChildren = true,
    $container = null
)
  {

    Debug::console
    (
      "getPathPermission(root: $root, rootId: $rootId, level: $level, "
      ."parentKey: $parentKey, parentId: $parentId, modeKey: $nodeKey, refEntity: $refEntity)"
   );

    if (!$container) {
      $container = new LibAclPermission();
    }

    if ($this->disabled) {
      $container->setPermission(Acl::ADMIN, Acl::ADMIN);

      return $container;
    }

    $user = $this->getUser();
    $model = $this->getModel();

    if (!$rootNode = $model->getAreaNode($root)) {
      Debug::console("Keine Id für Area {$root} bekommen");

      return $container;
    }

    if ('mgmt' == substr($rootNode->parent_key,0,4))
      $whereRootArea = array($root, $rootNode->parent_key);
    else
      $whereRootArea = $root;

    $roles = $model->loadUserRoles($whereRootArea, $rootId);

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {

      $container->setPermission(Acl::ADMIN, Acl::ADMIN);
      $container->roles = $roles;

      return $container;
    }

    ///FIXME securiy hole
    // der aktuelle schwachpunkt ist dass der pfad zum rootnode
    // nicht direkt geprüft wird
    // das muss noch eingebaut werden
    $permission = $model->loadAccessPathNode
    (
      $root,      // wird benötigt um den passenden startpunkt zu finden
      $rootId,    // die rowid der root area
      $level,     // das level in dem wir uns aktuell befinden
      $parentKey, // parent wird benötigt da es theoretisch auf dem gleichen level mehrere nodes des gleichen types geben kann
      $parentId,  // die id des parent nodes
      $nodeKey,   // der key des aktuellen reference node
      $roles      // gruppen rollen in denen der user sich relativ zum rootnode befinden
   );

    $areaLevel = $model->extractAreaAccessLevel(array($parentKey));
    $areaRefLevel = $model->extractAreaRefAccessLevel(array($parentKey));

    // prüfen ob das area level größer ist als als die permission
    if ($areaLevel) {
      if (!isset($permission['acl-level'])) {
        $permission['acl-level'] = $areaLevel;
      } elseif ($areaLevel  >  $permission['acl-level']) {
        $permission['acl-level'] = $areaLevel;
      }
    }

    if (DEBUG)
      Debug::console(
        "acl-level ".(isset($permission['acl-level'])?$permission['acl-level']:'not set').' areaLevel '
        .$areaLevel. ' pkey: '.$parentKey
     );

    // einfach zurückschreiben, ist per definition bei existenz der gültige wert
    if (isset($permission['acl-level'])) {
      $areaLevel = $permission['acl-level'];
    }

    if (!isset($permission['acl-level'])) {
      $permission['acl-level'] = Acl::DENIED;
    }

    $container->setPermission($permission);
    $container->roles = $roles;

    if ($loadChildren) {
      // der aktuelle node ist zugleich auch der rootnode
      $path = $model->loadAccessPathChildren($root, $nodeKey, $roles, $level+1);
      $container->paths = $path;

      if (DEBUG)
        Debug::console("Container PATH ", $container->paths);

    }

    $container->refBaseLevel = $areaRefLevel;

    if ($areaLevel)
      $container->defLevel = $areaLevel;

    if (DEBUG)
      Debug::console(
        "getPathPermission level: {$container->level}  defLevel: {$container->defLevel}  "
        ."refBaseLevel: {$container->refBaseLevel} roles: ".implode(', ',$container->roles). ' pkey: '.$parentKey
     );

    return $container;

  }//end public function getPathPermission */

  /**
   * @lang de:
   * Das Zugriffslevel auf die übergebene Area, sowie alle zugriffslevel
   * auf die Referenzen welche auf den übergeben Datensatz verweisen
   * auslesen.
   *
   * @todo besser kommentieren
   * @param string $root access_key der root security_area
   * @param int    $rootId rowid des datensatze von dem der pfad ausgeht
   * @param int    $level position in der area hirachie
   * @param string $parentKey access_key der parent security_area
   * @param int    $parentId rowid der
   *
   * @param LibAclContainer $container
   * @return LibAclPermission Permission Container mit allen nötigen Informationen
   *
   * /
  public function setPermissionByLevel
  (
    $areaKey,
    $container = null
)
  {

    if (!$container) {
      $container = new LibAclPermission();
    }

    if ($this->disabled) {
      $container->setPermission(Acl::ADMIN, Acl::ADMIN);

      return $container;
    }

    $user = $this->getUser();
    $model = $this->getModel();

    if (!$rootNode = $model->getAreaNode($areaKey)) {
      Debug::console("Keine Id für Area {$areaKey} bekommen");

      return $container;
    }

    if ('mgmt' == substr($rootNode->parent_key,0,4))
      $whereRootArea = array($areaKey, $rootNode->parent_key);
    else
      $whereRootArea = $areaKey;

    $roles = $model->loadUserRoles($whereRootArea, $rootId);

    // wenn die acls deaktiviert sind, rückgabe mit global admin
    // wenn der user vollen accees hat, rückgabe gloabl admin
    if ( $this->disabled || $user->getLevel() >= User::LEVEL_FULL_ACCESS) {

      $container->setPermission(Acl::ADMIN, Acl::ADMIN);
      $container->roles = $roles;

      return $container;
    }

    $areaLevel = $model->extractAreaAccessLevel(array($parentKey));
    $areaRefLevel = $model->extractAreaRefAccessLevel(array($parentKey));

    if (!$container->refBaseLevel || $areaRefLevel >  $container->refBaseLevel)
      $container->refBaseLevel = $areaRefLevel;

    if ($areaLevel)
      $container->defLevel = $areaLevel;

    return $container;

  }//end public function getPathPermission */

  /**
   * @lang en:
   * check if the user has a given role
   *
   * this function should only be used for security checks, don't use roles
   * to show diffrent ui elements
   *
   * therefore use the profiles
   *
   * @lang de:
   * Methode zum prüfen ob ein User für eine bestimmten Context eine bestimmte
   * Rolle hat.
   *
   * @param string/array $roleKey
   *
   * @param string $keys def: null,
   *  Ein oder mehrere mit "/" getrennte Areas
   *
   * @param int/Entity $entity def: null,
   *  Ein Entity Objekt oder eine Rowid wenn die Rolle relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @param boolean $loadAllRoles alle rollen laden, da es später mehr checks gibt
   *
   * @return boolean
   */
  public function hasRole($roleKey, $keys = null, $entity = null, $loadAllRoles = true)
  {

    if ($this->disabled)
      return true;

    $model = $this->getModel();

    if ($keys) {
      $keyData = $model->extractWeightedKeys($keys);
    } else {
      $keyData = null;
    }

    return $model->loadRole($roleKey, $keyData, $entity, $loadAllRoles);

  }//end public function hasRole */


  /**
   * @lang de:
   * Methode zum auslesen in welchen Rollen ein User in Relation
   * zu einer Area oder einem Datensatz ist.
   *
   * Es werden nur direkte Assignments beachtet, partial wird ignoriert
   *
   * @param string $keys
   * {
   *   die gewünschten security areas,
   *   wenn mehr als eine area übergeben wird gewinnt jeweils das höchste access level
   *   egal auf welcher area es sich befindet
   *
   *   @example 'mod-area'  single area
   *   @example 'mod-area/mgmt-area/mgmt-area' path like area
   *   @example 'mgmt-area1/mgmt-area2/mgmt-area3' gruppe von masken
   *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=acls.security_areas" >Security Areas</a>
   * }
   *
   * @param int/Entity $entity def: null,
   *  Ein Eintity Objekt oder eine Rowid wenn die Rolle Relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @return array
   *  Ein Array mit den AccessKeys und rowids aller gefundenen gruppen
   */
  public function getRoles($keys = null, $entity = null, $asArray = false)
  {

    $model = $this->getModel();

    if ($keys) {
      $keyData = $model->extractWeightedKeys($keys);
    } else {
      $keyData = null;
    }

    if (is_array($entity) && !$asArray) {
      $data = new LibAclRoleContainer($model->loadUserDsetRoles($keyData, $entity));
    } else {
      $data = $model->loadUserRoles($keyData, $entity);
    }

    return $data;

  }//end public function getRoles */


  /**
   *
   * @lang de:
   * Methode zum prüfen ob ein User irgendwo mitglied in einer bestimmten rolle
   * ist, egal ob nun in relation zu einer security area oder gloabl
   *
   * @param string/array $roleKey
   *
   * @param string $keys def: null,
   *  Ein oder mehrere mit "/" getrennte Areas
   *
   * @param int/Entity $entity def: null,
   *  Ein Eintity Objekt oder eine Rowid wenn die Rolle Relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @return boolean
   */
  public function hasRoleSomewhere($roleKey, $keys = null)
  {

    if ($this->disabled)
      return true;

    $model = $this->getModel();

    if ($keys) {
      $keyData = $model->extractWeightedKeys($keys);
    } else {
      $keyData = null;
    }

    return $model->loadRoleSomewhere($roleKey, $keyData);

  }//end public function hasRoleSomewhere */

  /**
   *
   * @lang de:
   * Methode zum prüfen ob ein User irgendwo mitglied in einer bestimmten rolle
   * ist, egal ob nun in relation zu einer security area oder gloabl
   *
   * @param string/array $roleKey
   *
   * @param string $keys def: null,
   *  Ein oder mehrere mit "/" getrennte Areas
   *
   * @param int/Entity $entity def: null,
   *  Ein Eintity Objekt oder eine Rowid wenn die Rolle Relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @return boolean
   */
  public function hasRoleExplicit($roleKey, $keys, $entity)
  {

    if ($this->disabled)
      return true;

    $model = $this->getModel();
    $keyData = $model->extractWeightedKeys($keys);

    return $model->loadRoleExplicit($roleKey, $keyData, $entity);

  }//end public function hasRoleExplicit */

  /**
   *
   * @lang de:
   * Methode zum prüfen ob ein User irgendwo mitglied in einer bestimmten rolle
   * ist, egal ob nun in relation zu einer security area oder gloabl
   *
   * @param string/array $roleKey
   *
   * @param string $keys def: null,
   *  Ein oder mehrere mit "/" getrennte Areas
   *
   * @param int/Entity $entity def: null,
   *  Ein Eintity Objekt oder eine Rowid wenn die Rolle Relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @return LibAclRoleContainer
   */
  public function getRolesExplicit($keys, $entity, $roleKey, $asArray = false)
  {

    $model = $this->getModel();

    if ($keys) {
      $keyData = $model->extractWeightedKeys($keys);
    } else {
      $keyData = null;
    }

    if (is_array($entity) && !$asArray) {
      $data = new LibAclRoleContainer($model->loadUserDsetExplicitRoles($keys, $entity, $roleKey));
    } else {
      $data = $model->loadUserDsetExplicitRoles($keys, $entity, $roleKey);
    }

    return $data;

  }//end public function getRolesExplicit */

  /**
   *
   * @lang de:
   * Methode zum prüfen ob ein User irgendwo mitglied in einer bestimmten rolle
   * ist, egal ob nun in relation zu einer security area oder gloabl
   *
   * @param string/array $roleKey
   *
   * @param string $keys def: null,
   *  Ein oder mehrere mit "/" getrennte Areas
   *
   * @param int/Entity $entity def: null,
   *  Ein Eintity Objekt oder eine Rowid wenn die Rolle Relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @return LibAclRoleContainer
   */
  public function getNumUserExplicit($keys, $entity, $roleKey, $asArray = false)
  {

    $model = $this->getModel();

    if (is_array($entity) && !$asArray) {
      $data = new LibAclRoleContainer($model->loadNumUserExplicit($keys, $entity, $roleKey));
    } else {
      $data = $model->loadNumUserExplicit($keys, $entity, $roleKey);
    }

    return $data;

  }//end public function getNumUserExplicit */

  /**
   * Laden aller UserIds welche eine bestimmte Rolle haben
   *
   * @param string/array $roleKey
   *
   * @param string $keys def: null,
   *  Ein oder mehrere mit "/" getrennte Areas
   *
   * @param int/Entity $entity def: null,
   *  Ein Eintity Objekt oder eine Rowid wenn die Rolle Relativ zu einer Area
   *  ausgelesen werden soll
   *
   * @return array
   */
  public function getExplicitUsers($keys, $entity, $roleKey, $groupFormat = null)
  {

    $model = $this->getModel();
    return $model->loadExplicitUsers($keys, $entity, $roleKey, $groupFormat);

  }//end public function getExplicitUsers */


  /**
   * Laden der Anzahl von Rollenzuweisungen auf eine gegebene Area
   * mit oder ohne Relation zu einem Datensatz
   *
   * @param array $areaKeys die access_keys der zu prüfenden access areas
   *
   * @param Entity|[int] $entity Entity Object, rowid oder liste von Rowids
   *
   * @param string|[string] $roleKey Die zu erfragenden Rollen
   *
   * @param boolean $asArray Soll das Ergebnis als Container oder als Array zurückgegeben werden?
   *
   * @return LibAclRoleContainer
   */
  public function countDsetRoleAssignments($areaKeys, $entity, $roleKey = null, $global = false, $asArray = false)
  {

    $model = $this->getModel();

    if ($areaKeys) {
      $keyData = $model->extractWeightedKeys($areaKeys);
    } else {
      $keyData = null;
    }

    $ids = array();

    if (is_array($entity))
      $ids = $entity;
    elseif (is_object($entity))
      $ids = array($entity->getId());
    else
      $ids = array($entity);

    if (!$asArray) {
      $data = new LibAclRoleContainer($model->countAreaRoles($keyData, $ids, $roleKey, $global));
    } else {
      $data = $model->countAreaRoles($keyData, $ids, $roleKey, $global);
    }

    return $data;

  }//end public function countDsetRoleAssignments */


  /**
   * de:
   * methode zum injizieren von acl abfragen in eine criteria
   *
   * @param LibSqlCriteria $criteria das criteria objekt in welches die abfrage
   *  auf dir rechte injiziert werden sollen
   *
   * @param string $keys der oder die keys über welche die rechte injiziert
   *  werden sollen
   *
   * @param boolean $extend gibt an ob die query die rechte nur ergänzend verwenden
   *  soll, oder ob nur die einträge geladen werden sollen für die es auch rechte gibt
   *
   * @param int $defaultLevel, mit diesem parameter wird ein default level für Datensätze übergeben,
   *  welche keine datensatz spezifisches level haben
   *
   * @param string/array $mainSource Mainsource gibt an zu welcher Tabelle
   *   die ACLs in relation positioniert werden müssen
   *
   * @throws LibAcl_Exception wenn kein Benutzer im ACL objekt vorhanden ist
   *  oder keine valide userid zurückgegeben wird können wir an dieser
   *  stelle nicht weiter machen und brechen das mosernd ab
   */
  public function injectListingAcls($criteria, $keys, $extend = false, $defaultLevel = null, $mainSource = null)
  {

    // injizieren der ACL Abfrage in die query
    $this->injectAclCheck($criteria, $keys, $extend, $mainSource);

    if (!is_null($defaultLevel)) {
      $criteria->selectAlso('COALESCE(acls."acl-level"::text, \''.$defaultLevel.'\') as "acl-level"');
    } else {
      $criteria->selectAlso('acls."acl-level"');
    }

  }//end public function injectListingAcls */

  /**
   * de:
   * methode zum injizieren von acl abfragen in eine criteria
   *
   * @param LibSqlCriteria $criteria das criteria objekt in welches die abfrage
   *  auf dir rechte injiziert werden sollen
   *
   * @param string $keys der oder die keys über welche die rechte injiziert
   *  werden sollen
   *
   * @param boolean $extend gibt an ob die query die rechte nur ergänzend verwenden
   *  soll, oder ob nur die einträge geladen werden sollen für die es auch rechte gibt
   *
   * @param string/array $mainSource Mainsource gibt an zu welcher Tabelle
   *  die ACLs in relation positioniert werden müssen
   *
   * @throws LibAcl_Exception wenn kein Benutzer im ACL objekt vorhanden ist
   *  oder keine valide userid zurückgegeben wird können wir an dieser
   *  stelle nicht weiter machen und brechen das mosernd ab
   */
  public function injectAclCheck($criteria, $keys, $extend = false, $mainSource = null)
  {

    $user = $this->getUser();

    // für die area keys wird kein level benötigt, lediglich eine liste
    // der zu prüfenden areas
    $tmp = explode(':', $keys);

    // es kann sein, dass ein benutzer nur partiellen zugriff auf eine area hat
    // das bedeuted, er darf zwar in den bereich, aber für alle kinder darin
    // müssen die kinder nochmal gesondert geprüft werden
    $paths = explode('>', $tmp[0]);

    if (count($paths) > 1) {

      $areas = explode('/', $paths[0]);
      $partialAreas = explode('/', $paths[1]);
    } else {

      $areas = null;
      $partialAreas = explode('/', $paths[0]);
    }

    // wenn kein user vorhanden ist kommen wir hier gerade nicht weiter
    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $areaKeys = "'".implode("', '",$partialAreas)."'" ;

    /// TODO prüfen ob das so überhaupt sinn macht
    if ($mainSource) {

      if (is_array($mainSource)) {

        $tmp = array();
        foreach ($mainSource as $src) {
          $tmp[] = "{$mainSource}";
        }

        $mainSource = "AND acls.\"acl-vid\" IN(".implode(', ', $tmp).")";

      } else {

        $mainSource = "AND acls.\"acl-vid\" = {$mainSource}";
      }
    } else {

      $mainSource = "AND acls.\"acl-vid\" = {$criteria->table}.rowid";
    }

    $joinSql = '';

    // wenn extend true ist heißt das, dass die datensatzbezogenen acls
    // lediglich die im datensatz anpassen sollen, datensätze für die
    // es keine datensatz bezogenen acls gibt sollen aber trotzdem geladen
    // werden
    // werden wert
    if ($extend)
      $joinSql = ' LEFT ';

    $sourceRelation = ACL_RELATION;

    $joinSql .= <<<SQL
  JOIN
    {$sourceRelation} as acls
    ON
      acls."acl-area" IN({$areaKeys})
        AND acls."acl-user" = {$userId}
        {$mainSource}

SQL;

    $criteria->joinAcls($joinSql);

  }//end public function injectAcls */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Erstellen eines neuen Gruppen / Secarea assignment
   *
   * @param string $areaKeys
   */
  public function getAreaIds($areaKeys)
  {

    // laden der mvc/utils adapter Objekte
    $model = $this->getModel();

    return $model->getAreaIds($areaKeys);

  }//end public function getAreaIds */

  /**
   * Erstellen eines neuen Gruppen / Secarea assignment
   *
   * @param string $areaKeys
   */
  public function getAreaId($areaKey)
  {

    // laden der mvc/utils adapter Objekte
    $model = $this->getModel();

    return $model->getAreaId($areaKey);

  }//end public function getAreaId */

  /**
   * de:
   * Debug Daten in die Console pushen
   */
  public function debug()
  {

  }//end public function debug */

}//end class LibAclDb

