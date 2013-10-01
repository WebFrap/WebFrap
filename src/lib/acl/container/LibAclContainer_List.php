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
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibAclContainer_List extends LibAclPermission
{

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
  public $calcQuery = null;

  /**
   * Liste der Ids aller gefundener Datensätze
   * @var array()
   */
  public $ids = array();

  /**
   * @var string
   */
  protected $aclKey = null;

  /**
   * @var string
   */
  protected $aclQuery = null;

  /**
   * @var string
   */
  protected $aclAreas = null;

  /**
   * @var string
   */
  protected $srcName = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @lang:de
   * Einfacher Konstruktor,
   * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
   *
   * @param string $aclKey
   * @param string $aclQuery
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
  public function __construct(
      $env,
      $level = null,
      $refBaseLevel = null
  ) {


    $this->env = $env;
    $this->levels = Acl::$accessLevels;

    if (!is_null($level))
      $this->setPermission($level, $refBaseLevel);

  }//end public function __construct */

  /**
   * getter für die ids
   * @return array
  */
  public function getIds()
  {
    return $this->ids;
  }//end public function getIds */

  /**
   * @param int $dataset
   * @param array|string $role
   * @return boolean
   */
  public function hasEntryRole($dataset, $role = null)
  {

    if (!$this->entryRoles)
      return false;

    return $this->entryRoles->hasRole($dataset, $role);

  }//end public function hasEntryRole */

  /**
   * @param int $dataset
   * @param array|string $role
   * @return boolean
   */
  public function hasExplicitRole($dataset, $role)
  {

    if (!$this->entryExplicitRoles)
      return false;

    return $this->entryExplicitRoles->hasRole($dataset, $role);

  }//end public function hasExplicitRole */

  /**
   * @param int $dataset
   * @param array|string $role
   * @return int
   */
  public function numExplicitUsers($dataset, $role)
  {

    if (!$this->numExplicitUsers)
      return false;

    return $this->numExplicitUsers->getNum($dataset, $role);

  }//end public function numExplicitUsers */

  /*//////////////////////////////////////////////////////////////////////////////
   // Methodes
   //////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard lade Funktion für den Access Container
   * Mappt die Aufrufe auf passene Profil loader soweit vorhanden.
   *
   * @param LibSqlQuery $query
   * @param string $context
   * @param array $conditions
   * @param TFlag $params
   */
  public function fetchListIds($query, $context, $conditions, $params = null  )
  {

    ///TODO Den Pfad auch noch als möglichkeit für die Diversifizierung einbauen

    // sicherheitshalber den String umbauen
    $context = SFormatStrings::subToCamelCase($context);

    if (method_exists($this, 'fetchListDefault')) {
      return $this->fetchListDefault($query, $conditions, $params);
    } else {
      return $this->{'fetchList'.$context.'Default'}($query, $conditions, $params);
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

      if (!$this->calcQuery)
        return null;

      if (is_string($this->calcQuery)) {

        if ($res = $this->getDb()->select($this->calcQuery)) {
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

        if ($res = $this->getDb()->getOrm()->select($this->calcQuery)) {
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

  /**
   * @param string $area
   * @param array $ids
   * @param array $roles die relevanten Rollen
   */
  public function loadEntryRoles($area, $ids, $roles = array())
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $entryRoles = $acl->getRoles($area, $ids, $roles);

    // dafür sorgen, das für alle ids zumindest ein leerer array vorhanden ist
    // bzw, dass potentiell vorhandenen rollen sauber gemerged werden
    foreach ($ids as $id) {

      if (isset($entryRoles[$id])) {
        if (!isset($this->entryRoles[$id]))
          $this->entryRoles[$id] = $entryRoles[$id];
        else
          $this->entryRoles[$id] = array_merge($this->entryRoles[$id], $entryRoles[$id]);
      } else {
        if (!isset($this->entryRoles[$id]))
          $this->entryRoles[$id] = array();
      }

    }

  }//end public function loadEntryRoles */

  /**
   * @param string $area
   * @param array $ids
   * @param array $roles die relevanten Rollen
   */
  public function loadEntryExplicitRoles($area, $ids, $roles = array())
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $entryExplicitRoles = $acl->getRolesExplicit($area, $ids, $roles);

    if (!$this->entryExplicitRoles) {
      $this->entryExplicitRoles = $entryExplicitRoles;
    } else {
      $this->entryExplicitRoles->merge($entryExplicitRoles);
    }

  }//end public function loadEntryExplicitRoles */

  /**
   * @param string $area
   * @param array $ids
   * @param array $roles die relevanten Rollen
   */
  public function loadNumExplicitUsers($area, $ids, $roles = array())
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $entryExplicitRoles = $acl->getNumUserExplicit($area, $ids, $roles);

    if (!$this->numExplicitUsers) {
      $this->numExplicitUsers = $entryExplicitRoles;
    } else {
      $this->numExplicitUsers->merge($entryExplicitRoles);
    }

  }//end public function loadNumExplicitUsers */



  /**
   * @param TFlag $params
   * @param Entity $entity
   */
  public function loadDefault($params, $entity = null)
  {

    // laden der mvc/utils adapter Objekte
    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();
    $orm = $this->getOrm();

    $entityId = null;
    if (is_object($entity))
      $entityId = $entity->getId();
    else
      $entityId = $entity;

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if (is_null($params->aclRoot) || 1 == $params->aclLevel) {
      $params->isAclRoot = true;
      $params->aclRoot = $this->aclKey;
      $params->aclRootId = $entityId; // die aktive entity ist der root
      $params->aclKey = $this->aclKey;
      $params->aclNode = $this->aclKey;
      $params->aclLevel = 1;
    }

    $areaId = $acl->resources->getAreaId($this->aclKey);

    // eventuellen check Code vorab laden, erweitert die rollen
    $backPaths = $acl->getPathJoinLevels($areaId);

    // impliziete Rechtevergabe
    foreach ($backPaths as $backPath) {
    
      $pathRoles = explode(',', $backPath['groups']);
    
      // prüfen ob der user die Rolle hat
      $hasRole = $acl->hasRoleSomewhere(
        $pathRoles,
        $backPath['target_area_key']
      );
    
      // wenn der user gruppenmitglied ist die neuen level setzen
      if ($hasRole && (int)$backPath['access_level'] >= Acl::INSERT) {
        $this->implicitInsert = true;
        $this->hasPartAssign = true;
      }
    
    }

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen berechtigungen
    if ($params->isAclRoot) {

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->injectDsetRoles(
        $this,
        $this->aclAreas,
        $entity
      );

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->injectDsetLevel(
        $this,
        $this->aclAreas,
        $this->roles,
        $entity,
        $this->loadReferences // rechte für die referenzen mitladen
      );

    } else {

      $acl->injectDsetRootPermission(
        $this, // sich selbst als container mit übergeben
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclNode,
        $entity
      );

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $acl->injectDsetPathPermission(
        $this, // sich selbst als container mit übergeben
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclKey,
        $params->refId,
        $params->aclNode,
        $entity,
        $this->loadReferences // rechte für die referenzen mitladen
      );

    }

    $this->loadCustom($params, $entity);
    
  }//end public function loadDefault */

  /**
   * @param TFlag $params
   * @param Entity $entity
   */
  public function loadCustom($params, $entity = null)
  {
  
  }//end public function loadCustom */
  
  /**
   * @param LibSqlQuery $query
   * @param string $condition
   * @param TFlag $params
   */
  public function fetchListDefault($query, $condition, $params)
  {
    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();
    $user = $this->getUser();
    $orm = $this->getDb()->getOrm();

    $userId = $user->getId();
    $mainAreaId = $acl->resources->getAreaId($this->aclKey);
    $pathJoins = $acl->getPathJoins($mainAreaId);

    // erstellen der Acl criteria und befüllen mit den relevanten cols
    $criteria = $orm->newCriteria('inner_acl');

    $envelop = $orm->newCriteria();
    $envelop->subQuery = $criteria;
    $envelop->select(array(
      'inner_acl.rowid',
      'max(inner_acl."acl-level") as "acl-level"'
    ));
    $query->injectLimit($envelop, $params);
    $envelop->groupBy('inner_acl.rowid');
    $envelop->where('"acl-level" > 0'); // alle ausblenden für die es keine berechtigung gibt

    $criteria->select(array($this->srcName.'.rowid as rowid'));

    if (is_null($this->defLevel)) {
      $this->defLevel = 0;
    }

    if (!$this->isPartAssign) {
      $joinType = ' LEFT ';
    }


    $query->setTables($criteria);
    $query->appendConditions($criteria, $condition, $params  );
    if ($query->extendedConditions) {
      $query->renderExtendedConditions($criteria, $query->extendedConditions);
    }
    $query->injectAclOrder($criteria, $envelop, $params);
    $query->appendFilter($criteria, $condition, $params);


    $pathConditions = array();
    if ($pathJoins) {

      foreach ($pathJoins as $pathJoin) {

        $groupIds = $acl->resources->getGroupIds(explode(',', $pathJoin['groups']));

        if ($groupIds) {

          $groupCond = implode(",", $groupIds);

        $pathConditions[] = <<<SUB_COND
      (
        back_acls."acl-id_area" = {$pathJoin['id_target_area']}
        AND ( back_acls."acl-vid" = {$this->srcName}.{$pathJoin['ref_field']} OR back_acls."acl-vid" is null )
        AND back_acls."acl-group" IN( {$groupCond} )
      )
SUB_COND;

        }

      }
    }

    if ($pathConditions) {

      $pathConditions = implode( ' OR ', $pathConditions );

      $criteria->join(
        <<<SQL
{$joinType} JOIN webfrap_area_user_level_view  acls ON
    acls."acl-user" = {$userId}
    AND acls."acl-area" IN({$this->aclQuery})
    AND ( acls."acl-vid" = {$this->srcName}.rowid OR acls."acl-vid" is null )

  LEFT JOIN wbfsys_security_backpath back_path
    ON back_path.id_area = {$mainAreaId}

  LEFT JOIN webfrap_area_user_level_view as back_acls ON
    back_path.id_target_area = back_acls."acl-id_area"
    AND back_acls."acl-user" = {$userId}
    AND(
      {$pathConditions}
    )

SQL
        ,'acls'
      );

    } else {

      $criteria->join(
        <<<SQL
LEFT JOIN webfrap_area_user_level_view  acls ON
    acls."acl-user" = {$userId}
    AND acls."acl-area" IN({$this->aclQuery})
    AND ( acls."acl-vid" = {$this->srcName}.rowid OR acls."acl-vid" is null )
SQL
        ,'acls'
      );

    }


    if ($pathConditions) {

      $greatest = <<<SQL

  greatest(
    {$this->defLevel},
    acls."acl-level",
    case when back_acls."acl-id_area" is null
     then 0
    else
     back_path.access_level
    end
  ) as "acl-level"

SQL;

    } else {

      $greatest = <<<SQL

  greatest(
    {$this->defLevel},
    acls."acl-level"
  ) as "acl-level"

SQL;

    }

    $criteria->selectAlso($greatest);

    $tmp = $orm->select($envelop);
    $ids = array();
    $this->ids = array();

    foreach ($tmp as $row) {
      $ids[$row['rowid']] = (int)$row['acl-level'];
      $this->ids[] = $row['rowid'];
    }

    $query->setCalcQuery($envelop, $params, 'inner_acl.rowid');

    return $ids;

  }//end public function fetchListDefault */

}//end class LibAclPermissionList

