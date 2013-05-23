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
 * de:
 *
 * Das User Objekt stellt die nötigen logik bereit um mit den daten des aktuell
 * eigeloggten users zu arbeiten.
 *
 * Zum einen dieverse Statusinformationen, unter anderem ob überhaupt ein Benutzer
 * eingeloggt ist.
 * Weiter persönliche Daten wie der Loginname, das aktuelle Profil des Benutzers etc.
 *
 * Besondere Eigenschaften:
 * Von dieser Klasse kann es nur eine Instanz geben im normalen Betrieb (Ausgenommen tests)
 * Das Objekt dieser Klasse lande in der Session
 * Diese Klasse ist Teil des Bootstraps, daher wird eine static init methode implementiert
 *
 * @package WebFrapwurd
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class User extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes for User Levels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the ultimate level, you can do what you want,
   * you are the developer,
   * the power,
   * the everything,
   * everbody has to f34r your p00w3rfu11 411m19ht
   * .oO(dream on, hrhr)
   * @deprecated
   */
  const LEVEL_DEVELOPER  = 110;

  /**
   * @param int
   *  @deprecated
   */
  const LEVEL_SUPERADMIN = 100;

  /**
   * @param int
   *  @deprecated
   */
  const LEVEL_ADMIN      = 90;

  /**
   * @param int
   * @deprecated
   */
  const LEVEL_DIRECTOR   = 50;

  /**
   * @param int
   * @deprecated
   */
  const LEVEL_AGENT      = 25;

  /**
   * @param int
   * @deprecated
   */
  const LEVEL_CUSTOMER   = 15;

  /**
   * @param int
   * @deprecated
   */
  const LEVEL_GUEST      = 10;

/*//////////////////////////////////////////////////////////////////////////////
// Die neuen Benutzerlevel
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const LEVEL_PUBLIC_EDIT      = 0;

  /**
   * @var int
   */
  const LEVEL_PUBLIC_ACCESS    = 10;

  /**
   * @var int
   */
  const LEVEL_USER             = 20;

  /**
   * @var int
   */
  const LEVEL_IDENT            = 30;

  /**
   * @var int
   */
  const LEVEL_EMPLOYEE         = 40;

  /**
   * @var int
   */
  const LEVEL_SUPERIOR         = 50;

  /**
   * @var int
   */
  const LEVEL_L4_MANAGER       = 60;

  /**
   * @var int
   */
  const LEVEL_L3_MANAGER       = 70;

  /**
   * @var int
   */
  const LEVEL_L2_MANAGER       = 80;

  /**
   * @var int
   */
  const LEVEL_L1_MANAGER       = 90;

  /**
   * @var int
   */
  const LEVEL_FULL_ACCESS      = 90;

  /**
   * @var int
   */
  const LEVEL_SYSTEM           = 100;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var User
   */
  protected static $instance    = null;

  /**
   * array with all embeded Roles for the user
   *
   * @var array
   */
  protected $groupRoles         = array();

  /**
   * user access level, per default 0
   * for simple access controll based on levels
   * @var int
   */
  protected $userLevel          = 0;

  /**
   * Flag ob der Benutzer zwischen verschiedenen Benutzerprofilen
   * zur Laufzeit wechseln darf
   * @var int
   */
  protected $flagChangeUser          = false;

  /**
   *
   * @var array
   */
  public $userLevels = array(
    'public_edit'     => 0,
    'public_access'   => 10,
    'user'            => 20,
    'ident'           => 30,
    'employee'        => 40,
    'superior'        => 50,
    'l4_manager'      => 60,
    'l3_manager'      => 70,
    'l2_manager'      => 80,
    'l1_manager'      => 90,
    'full_access'     => 90,
  );

  /**
   * name of the main group
   * @var string
   */
  protected $mainGroup          = null;

  /**
   * @var int
   */
  protected $userId             = null;

  /**
   * @var int
   */
  protected $groupId            = null;

  /**
   * @var boolean
   */
  protected $logedIn            = false;

  /**
   * Eine Reihe benutzerbezogerne Daten
   * Standard ist eine minimale Menge für den annonymen benutzer
   * @var array
   */
  protected $userData           = array(
    'firstname' => 'Ano',
    'lastname'  => 'Nymous',
  );

  /**
   * @var array
   */
  protected $links      = array();

  /**
   * @var array
   */
  protected $linked     = array();

  /**
   * @var array
   */
  protected $reference = array();

  /**
   * the full name of the user
   * @var string
   */
  protected $fullName   = null;

  /**
   *
   * @var string
   */
  protected $profile    = null;

  /**
   * de:
   * Der Name des aktiven profiles des Benutzers
   * @var string
   */
  protected $profileName  = 'default';

  /**
   * de:
   * Liste aller Profile doe dem Benutzer zur Verfügung stehen
   * @var array
   */
  protected $profiles   = array(
    'default' => 'Default'
  );

  /**
   * the name that was used for login
   * @var string
   */
  protected $loginName    = null;

  /**
   * the name that was used for login
   * @var string
   */
  protected $flagNoLogin  = false;

  /**
   *
   * @var WbfsysRoleUser_Entity
   */
  public $entity = null;

  /**
   * @var WebFrapAuth_Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Konstruktoren / Derstruktoren Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * Da wir php sind und somit vom aktiven Benutzer im selben Script
   * kaum sinnvoll 2 instanzen geben kann, beschränken wirs doch direkt mal auf
   * nur 1ne
   *
   * protected deshalb um einer von der Userklasse ableitende Testklasse die
   * möglichkeit zu geben zu testzwecken doch mehr als eine instanz erstellen zu
   * können
   * selbiges gillt auch für clone
   * @param BaseChild $env
   */
  public function __construct($userId = null, $env = null)
  {

    if ($env) {
      $this->env = $env;
    } else {
      $this->env = Webfrap::getActive();
    }
    
    if ($userId) {
      
      if (ctype_digit($userId))
        $this->loginById($userId);
      else 
        $this->login($userId);
    }

  }//end protected function __construct */

  /**
   * de:
   * Menschen werden bei uns nicht geclont... MKAY!!!
   *
   * höchstens zum testen mal mit rumspielen, daher protected
   */
  protected function __clone() {}

  /**
   * de:
   * Da das Userobjekt in der Session landet brauchen wir
   */
  public function __wakeup()
  {

    Debug::console('$this->profiles', $this->profiles);
    Debug::console('$this->profileName', $this->profileName);
    Debug::console('$this->userLevel', $this->userLevel);
    Debug::console('$this->groupRoles', $this->groupRoles);

  }//end public function __wakeup */

  /**
   * de:
   * Da das Userobjekt in der Session landet brauchen wir
   */
  public function __sleep()
  {
    return array(
      'groupRoles',
      'userLevel',
      'mainGroup',
      'userId',
      'groupId',
      'logedIn',
      'userData',
      //'links',
      //'linked',
      //'reference',
      'fullName',
      //'profile',
      'profileName',
      'profiles',
      'loginName',
      'flagChangeUser',
      'flagNoLogin'
    );

  }//end public function __wakeup */

  /**
   * @return WebfrapAuth_Model
   */
  public function getAuthModel()
  {

    if (!$this->model)
      $this->model = new WebfrapAuth_Model($this);

    return $this->model;

  }//end public function getAuthModel */

/*//////////////////////////////////////////////////////////////////////////////
// Getter for User Data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return int
   */
  public function getId()
  {

    if ($this->flagNoLogin)
      return 1;

    return $this->userId;

  }//end public function getId */

  /**
   * Erfragen der Entity für den User
   * @return WbfsysRoleUser_Entity
   */
  public function getEntity()
  {

    if ($this->entity)
      return $this->entity;

    $this->entity = $this->getOrm()->get('WbfsysRoleUser', $this->userId);

    return $this->entity;

  }//end public function getEntity */

  /**
   * @param boolean $flag
   */
  public function setNoLogin($flag)
  {
    $this->flagNoLogin = $flag;
  }//end public function setNoLogin */

  /**
   * check if the user has a specific level
   * @param int $check
   * @return boolean
   */
  public function checkLevel($check  )
  {
    return $this->userLevel >= $check ?true:false;
  }//end public function checkLevel */

  /**
   * request the global access level of this user
   * @return int
   */
  public function getLevel()
  {
    return $this->userLevel;
  }//end public function getLevel */

/*//////////////////////////////////////////////////////////////////////////////
// Group data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * return the main group for the user
   * this group hase to be used for the gui components the user will see
   * if there is no clustered view by the group roles
   *
   * @return string
   * @deprecated
   */
  public function getGroup()
  {
    return $this->mainGroup;
  }//end public function getGroup */

  /**
   *
   * @return string
   * @deprecated
   */
  public function getGroupId()
  {
    return $this->groupId;
  }//end public function getMainGroup */

  /**
   * @deprecated
   * @param string
   * @param Entity
   */
  public function hasRole($roleName, $entity = null, $ids = null)
  {

    if (!$this->userId)
      return false;

    if (is_array($roleName)) {

      foreach ($roleName as $roleKey) {
        if (isset($this->groupRoles[$roleKey]))
          return true;
      }

    } else {
      if (isset($this->groupRoles[$roleName]))
        return true;
    }

    // if we got no entity we can stop here
    if (!$entity)
      return false;

    $db     = $this->getDb();
    /* @var $query WebfrapEntityRoles_Query */
    $query  = $db->newQuery('WebfrapEntityRoles');

    if (is_object($entity))
      $entityKey = $entity->getEntityName();
    else
      $entityKey = $entity;

    if (is_array($ids)) {
      // empty array can find nothing
      if (!$ids)
        return false;

      return (boolean) $query->checkRoleByEntityList($this->userId, $entityKey, $ids);

    } else {

      if (!$ids)
        $ids = $entity->getId();

      return (boolean) $query->checkRoleByEntity($this->userId, $entityKey, $ids);

    }

  }//end public function hasRole */

/*//////////////////////////////////////////////////////////////////////////////
// Name
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * Rückgabe des vollen, formatierten Namens der Person.
   * Kann in der Form direkt ausgegeben werden, was auch genau die intention
   * für diese methode ist
   *
   * @return string
   */
  public function getFullName()
  {

    if (!$this->fullName) {

      if (isset($this->userData['lastname'])  && $this->userData['lastname']) {
        $this->fullName = $this->userData['lastname'];
      }

      if (isset($this->userData['firstname']) && $this->userData['firstname']) {
        if ($this->fullName)
          $this->fullName .= ', '.$this->userData['firstname'];
        else
          $this->fullName = $this->userData['firstname'];
      }

    }

    return $this->fullName;

  }//end public function getFullName */

  /**
   * @return string
   */
  public function getLoginName()
  {
    return $this->loginName;
  }//end public function getLoginName */

  /**
   * Enter description here...
   * @param string $key
   * @return string
   */
  public function getData($key = null)
  {
    if (!$key)
      return $this->userData;

    return isset($this->userData[$key]) ? $this->userData[$key] : null ;
  }//end public function getData */

  /**
   * @param Entity $entity
   * @param string $key
   * @return string
   */
  public function getLinkedEntity($entity, $key)
  {

    $orm = $this->getOrm();

    return $orm->get($entity, $key.'='.$this->getId());

  }//end public function getLinkedEntity */

  /**
   * @param Entity $entity
   * @param string $key
   * @return string
   */
  public function getRefEntity($entity,  $key)
  {

    $orm = $this->getOrm();

    return $orm->get($entity, $this->getData($key));

  }//end public function getRefEntity */

/*//////////////////////////////////////////////////////////////////////////////
// Profil Methode
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter User::$profileName string $profileName
   * @param string $profileName
   */
  public function setProfileName($profileName)
  {
    $this->profileName = $profileName;
  }//end public function setProfileName */

  /**
   * @getter User::$profileName string $profileName
   * @return string
   */
  public function getProfileName()
  {
    return $this->profileName;
  }//end public function getProfileName */

  /**
   * @getter User::$profileName string $profileName
   * @return string
   */
  public function getProfileLabel()
  {

    $profile = $this->getProfile();

    return $profile->label;

  }//end public function getProfileLabel */

  /**
   * Prüfen ob das aktive profile in einer definierten liste vorhanden ist
   * @return boolean
   */
  public function activeProfileIn($keys  )
  {
    return in_array($this->profileName, $keys);

  }//end public function activeProfileIn */

  /**
   * de:
   * Erfragen des Profil Objektes für den aktuellen Benutzer
   *
   * Das Profilobjekt wird on demand erstellt.
   * Relevant ist dass der Profilname auf eine exitsierende Klasse verweist
   *
   * Wenn die Klasse nicht existiert fällt das System automatisch auf das Default
   * Profil zurück um einen undefinierte Situation zu vermeiden
   *
   * @return Profile
   */
  public function getProfile()
  {

    if (!$this->profile) {

      if (!isset($this->profiles[$this->profileName])) {
        $this->profileName  = 'default';
        $this->profile      = new ProfileDefault();

        return $this->profile;
      }

      $classname = 'Profile'.SParserString::subToCamelCase($this->profileName);

      if (Webfrap::classLoadable($classname)) {
        $this->profile = new $classname();
      } else {
        $this->profileName  = 'default';
        $this->profile      = new ProfileDefault();
      }

    }

    return $this->profile;

  }//end public function getProfile */

  /**
   * check if an user has a specific profil
   * @param string array $key
   * @return string
   */
  public function hasProfile($key)
  {

    if (is_array($key)) {

      foreach ($key as $pKey) {
        if (isset($this->profiles[$pKey]))
          return true;
      }

      return false;

    } else {
      return isset($this->profiles[$key]);
    }

  }//end public function hasProfile */

  /**
   * check if an user has a specific profil
   * @return string
   */
  public function switchProfile($key)
  {

    // if the user does not have the profile stop here
    if (!isset($this->profiles[$key])) {
      Debug::console('profile: '.$key.' not exists');

      return false;
    }

    $classname = 'Profile'.SParserString::subToCamelCase($key);

    // change the profil if the new exists
    if (Webfrap::classLoadable($classname)) {
      $this->profile      = new $classname();
      $this->profileName  = $key;

      return true;
    } else {
      Debug::console('profile class: '.$classname.' not exists');

      return false;
    }

    // else just keep the old profile
    return false;

  }//end public function hasProfile */

  /**
   * check if an user has a specific profil
   * @return array
   */
  public function getProfiles()
  {
    return $this->profiles;

  }//end public function getProfiles */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes for Singleton
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BaseChild $env
   * @return boolean
   */
  public static function init($env)
  {

    if (!isset($_SESSION['SYS_USER'])) {
      self::$instance = new User(null,$env);

      if (defined('WBF_NO_LOGIN') &&  WBF_NO_LOGIN)
        self::$instance->setNoLogin(true);

      $_SESSION['SYS_USER'] = self::$instance;

      return true;
    } else {
      // Wiederherstellen der Instance aus dem Nirvana
      self::$instance = $_SESSION['SYS_USER'];
      self::$instance->setEnv($env);

      return false;
    }

  } // end public static function init */

  /**
   * @return User
   */
  public static function getInstance()
  {
    return self::$instance;
  }//end public static function getInstance */

  /**
   * @return User
   */
  public static function getActive()
  {
    return self::$instance;
  }//end public static function getActive */

/*//////////////////////////////////////////////////////////////////////////////
// Grouproles
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * getter for the embeded Roles
   *
   * @return array
   */
  public function getGroups()
  {
    return $this->groupRoles;
  }//end public function getGroups */

/*//////////////////////////////////////////////////////////////////////////////
// login / logout / change pwd
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $username
   * @param int $userId
   * @return
   */
  protected function loadUserData($username, $userId = null)
  {

    // mal was prüfen
    $orm       = $this->getOrm();
    $response  = $this->getResponse();
  
    if ($userId) {
      try {
        if (!$authRole = $orm->get('WbfsysRoleUser', $userId)) {
          $response->addError('User '.$userId.' not exists');

          return false;
        }
      } catch (LibDb_Exception $exc) {
        $response->addError('Error in the query to fetch the data for user: '.$userId);

        return false;
      }  
      
      $username = $authRole->name;
      $this->loginName = $authRole->name;
      
    } else {
      if (is_object($username)) {
        $authRole        = $username;
      } else {
        try {
          if (!$authRole = $orm->get('WbfsysRoleUser', "UPPER(name) = UPPER('{$username}')")) {
            $response->addError('User '.$username.' not exists');
  
            return false;
          }
        } catch (LibDb_Exception $exc) {
          $response->addError('Error in the query to fetch the data for user: '.$username);
  
          return false;
        }
      }
    }

    $this->entity    = $authRole;

    $this->userData  = $authRole->getData();
    $this->userId    = $authRole->getId();
    $this->userLevel = (int) $authRole->getData('level');

    if ($authRole->profile) {
      $this->profileName = $authRole->profile;
      $this->profiles[$authRole->profile] = SParserString::subToName($this->profileName);
    }

    if (WebFrap::classLoadable('CorePerson_Entity')) {
      if ($person = $orm->get('CorePerson', $authRole->id_person))
        $this->userData = array_merge($this->userData, $person->getData());
    }

    if (isset($this->userData['lastname'])  && $this->userData['lastname']) {
      $this->fullName = $this->userData['lastname'];
    } else {
      $this->fullName = null;
    }

    if (isset($this->userData['firstname']) && $this->userData['firstname']) {
      if ($this->fullName)
        $this->fullName .= ', '.$this->userData['firstname'];
      else
        $this->fullName = $this->userData['firstname'];
    }

    return true;

  }//end protected function loadUserData */

  /**
   * load all roles
   *
   */
  protected function loadGroupRoles()
  {

    $db = $this->getDb();

    /// TODO add this in an external datasource
    // Load User Rights
    $sql = 'SELECT
        wbfsys_role_group.rowid,
        wbfsys_role_group.m_parent,
        wbfsys_role_group.name ,
        wbfsys_role_group.access_key ,
        wbfsys_role_group.level
      from
        wbfsys_role_group
      join
        wbfsys_group_users on wbfsys_role_group.rowid = wbfsys_group_users.id_group
      where
        wbfsys_group_users.id_user = '.$this->userId.'
          and wbfsys_group_users.id_area is null
          and wbfsys_group_users.vid is null
        ';

    $roles = $db->select($sql);

    foreach ($roles as $role) {

      $this->groupRoles[$role['access_key']] = $role['rowid'];

      if ($role['level'] > $this->userLevel)
        $this->userLevel = $role['level'];

      // if we have a parent load him
      if ($role['m_parent'])
        $this->loadGroupParents($role['m_parent']);

    }//end foreach */

  }//end protected function loadGroupRoles */

  /**
   * load assigned profiles
   * @todo dringend in eigene query auslagern
   */
  protected function loadUserProfiles()
  {

    $db = $this->getDb();

    /// TODO add this in an external datasource
    // Load User Rights
    $sql = 'SELECT
        wbfsys_profile.name,
        wbfsys_profile.access_key
      FROM
        wbfsys_profile
      JOIN
        wbfsys_user_profiles
        ON wbfsys_profile.rowid = wbfsys_user_profiles.id_profile
      WHERE
        wbfsys_user_profiles.id_user = '.$this->userId.'
      ORDER BY
        wbfsys_profile.name';

    $roles = $db->select($sql);

    foreach ($roles as $role) {
      $kPey = trim($role['access_key']);

      if (trim($role['name']) == '') {
        $this->profiles[$kPey] = SParserString::subToName($role['access_key']);
      } else {
        $this->profiles[$kPey] = $role['name'];
      }

    }//end foreach */

    // wenn keine gruppen vorhanden sind müssen auch keine gruppenprofile
    // geladen werden
    if (!count($this->groupRoles))
      return;

    /// TODO add this in an external datasource
    // Load User Rights
    $sql = 'SELECT
        wbfsys_profile.name ,
        wbfsys_profile.access_key
      from
        wbfsys_profile
      join
        wbfsys_group_profiles on wbfsys_profile.rowid = wbfsys_group_profiles.id_profile
      where
        wbfsys_group_profiles.id_group IN('.implode(', ',$this->groupRoles).') ';

    $roles = $db->select($sql);

    foreach ($roles as $role) {
      $kPey = trim($role['access_key']);
      $this->profiles[$kPey] = SParserString::subToCamelCase($role['access_key']);
    }//end foreach */

  }//end protected function loadUserProfiles */

  /**
   * Enter description here...
   *
   * @param int $idParent
   * @todo dringend in eigene query auslagern
   * @return void
   */
  protected function loadGroupParents($idParent)
  {

    $db = $this->getDb();

    // Load User Rights
    $sql = 'SELECT
        rowid,
        name ,
        profile,
        m_parent,
        access_key,
        level
      from
        wbfsys_role_group
      where
        rowid = '.$idParent;

    if (!$role = $db->select($sql , true, true  ))
      return;

    $this->groupRoles[$role['access_key']] = $role['rowid'];

    if ($role['level'] > $this->userLevel) {
      $this->userLevel = $role['level'];
    }

    if ($role['profile']) {
      $kPey = trim($role['profile']);
      $this->profiles[$kPey] = SParserString::subToCamelCase($kPey);
    }

    // if we have a parent load him
    if ($role['m_parent']) {
      $this->loadGroupParents($role['m_parent']);
    }

  }//end protected function loadGroupParents */

/*//////////////////////////////////////////////////////////////////////////////
// login / logout / change pwd
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * en:
   * Login assumes that the user is allready authentificated and verificated
   * Login only loads the userdata and groupdata from the database
   *
   * de:
   *
   *
   * @param string $username
   * @return boolean
   */
  public function login($username)
  {

    if (is_object($username))
      $this->loginName = $username->name;
    else
      $this->loginName = $username;

    $this->profiles    = array('default' => 'Default');
    $this->groupRoles  = array();

    if (!$this->loadUserData($username)) {
      $response = $this->getResponse();
      $response->addError('Failed to login user: '.$this->loginName);

      return false;
    }

    $this->loadGroupRoles();
    $this->loadUserProfiles();

    $this->logedIn   = true;

    return true;

  }//end public function login */
  
  /**
   * en:
   * Login assumes that the user is allready authentificated and verificated
   * Login only loads the userdata and groupdata from the database
   *
   * de:
   *
   *
   * @param string $username
   * @return boolean
   */
  public function loginById($id)
  {

    $this->profiles    = array('default' => 'Default');
    $this->groupRoles  = array();

    if (!$this->loadUserData(null,$id)) {
      $response = $this->getResponse();
      $response->addError('Failed to login user: '.$id);

      return false;
    }

    $this->loadGroupRoles();
    $this->loadUserProfiles();

    $this->logedIn   = true;

    return true;

  }//end public function login */

  /**
   * Login assumes that the user is allready authentificated and verificated
   * Login only loads the userdata and groupdata from the database
   * @return boolean
   */
  public function reload()
  {

    $this->userData  = array();
    $this->userId    = null;
    $this->userLevel = null;

    $this->groupRoles = array();
    $this->groupId    = null;
    $this->profiles   = array();

    if (!$this->loadUserData($this->loginName)) {
      $response = $this->getResponse();
      $response->addError('failed to reload user: '.$this->loginName);

      return false;
    }

    $this->loadGroupRoles();
    $this->loadUserProfiles();

    return true;

  }//end public function reload */

  /**
   *
   */
  public function singleSignOn()
  {

    // check if X509 key is defined
    if (!defined('X509_KEY_NAME'))
      return;

    if (defined('X509_DEF_USER'))
      $_SERVER[X509_KEY_NAME] = X509_DEF_USER;

    $auth = new LibAuth($this, 'Sslcert');

    if ($auth->login()) {
      $this->login($auth->getUsername());

      $model = $this->getAuthModel();
      $model->protocolLogin($this, true);

    }

  }//end public function singleSignOn */

  /**
   * de:
   * Der Name sagts eingentlich.
   * Der Benutzer wird vom System abgemeldet. Die Daten im Userobjekt
   * werden zurückgesetzt und die session gelöscht
   * @return void
   */
  public function logout()
  {

    $this->clean();
    Session::destroy();

  }//end public function logout */

  /**
   * de:
   * Alle Date zurücksetzen. Kommt einem Logout gleich, die Session selbst
   * bleibt jedoch erhalten.
   *
   * Wird in Logout und chnageUser verwendet.
   */
  public function clean()
  {

    $this->userData     = array(
      'firstname' => 'Ano',
      'lastname'  => 'Nymous',
    );

    $this->roupRoles    = array();
    $this->userId       = null;
    $this->groupId      = null;
    $this->userLevel    = null;
    $this->logedIn      = false;

  }//end protected function clean */

  /**
   * de:
   * Abfragen ob der aktuelle User Annonyme oder eingeloggt ist.
   *
   * @return boolean true wenn eingeloggt
   */
  public function getLogedIn()
  {

    if ($this->flagNoLogin)
      return true;

    return $this->logedIn;

  }//end public function getLogedIn */

  /**
   * de:
   * Einfacher  Weg das Passwort für den aktuell angemldeten Benutzer zu
   * ändern.
   * Mit dieser Methode kann sicher gestellt werden, dass der User nur sein
   * eigenens Passwort ändern kann
   *
   * @param string $pwd
   * @return boolean
   */
  public function changePasswd($pwd)
  {

    $id = $this->getId();

    // gut also wenn wir keine ID bekommen dann mal ganz schnell stop hier
    if (!$id)
      return false;

    $orm = $this->getOrm();

    return $orm->update(
      'WbfsysRoleUser',
      $id,
      array(
        'password'    =>  SEncrypt::passwordHash($pwd),
        'change_pwd'  =>  ''
      )
    );

  }//end public static function changePasswd */

  /**
   * de:
   * Simple Methode um den aktuell angemeldetet user zu ändern
   * Wird beim Entwickeln immer mal wieder benötigt
   *
   * @param string $pwd
   * @return boolean
   */
  public function changeUser($username)
  {

    $this->clean();
    $this->login($username);

  }//end public function changeUser */

}//end class User

