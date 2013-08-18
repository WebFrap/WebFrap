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
 *  $access = new LibAclPermission(16);
 *
 *  if ($access->access)
 *  {
 *    echo 'Zugriff erlaubt';
 *  }
 *
 *  if ($access->admin)
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
class LibAclPermissionList extends LibAclPermission
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
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
  public $calcQuery = null;

  /**
   * Liste der Ids aller gefundener Datensätze
   * @var array()
   */
  public $ids = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter
//////////////////////////////////////////////////////////////////////////////*/

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
   * @param string $profil der namen des Aktiven Profil als CamelCase
   * @param LibSqlQuery $query
   * @param string $context
   * @param array $conditions
   * @param TFlag $params
   */
  public function fetchListIds($profil, $query, $context, $conditions, $params = null  )
  {

    ///TODO Den Pfad auch noch als möglichkeit für die Diversifizierung einbauen

    // sicherheitshalber den String umbauen
    $profil = SFormatStrings::subToCamelCase($profil);
    $context = SFormatStrings::subToCamelCase($context);

    if (method_exists($this, 'fetchList_Profile_'.$profil  )) {
      return $this->{'fetchList_Profile_'.$profil}($query, $conditions, $params);
    } elseif (method_exists($this, 'fetchListDefault'  )) {
      return $this->fetchListDefault($query, $conditions, $params);
    }
    // fallback to the context stuff
    else if (method_exists($this, 'fetchList_'.$context.'_Profile_'.$profil  )) {
      return $this->{'fetchList_'.$context.'_Profile_'.$profil}($query, $conditions, $params);
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

}//end class LibAclPermissionList

