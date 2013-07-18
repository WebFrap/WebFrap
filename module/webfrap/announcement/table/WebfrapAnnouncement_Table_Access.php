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
 * Acl Rechte Container über den alle Berechtigungen geladen werden
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapAnnouncement_Table_Access extends LibAclPermission
{
  /**
   * @param TFlag $params
   * @param WbfsysAnnouncement_Entity $entity
   */
  public function loadDefault($params, $entity = null)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if (is_null($params->aclRoot) || 1 == $params->aclLevel  ) {
      $params->isAclRoot     = true;
      $params->aclRoot       = 'mgmt-wbfsys_announcement';
      $params->aclRootId     = null;
      $params->aclKey        = 'mgmt-wbfsys_announcement';
      $params->aclNode       = 'mgmt-wbfsys_announcement';
      $params->aclLevel      = 1;
    }

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen
    // berechtigungen
    if ($params->isAclRoot) {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->getPermission
      (
        'mod-wbfsys>mgmt-wbfsys_announcement',
        null,
        true,     // keine Kinder laden
        $this     // dieses objekt soll als container verwendet werden
      );
    } else {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $acl->getPathPermission
      (
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclKey,
        $params->refId,
        $params->aclNode,
        null,
        true,  // keine kinder laden
        $this  // sich selbst als container mit übergeben
      );
    }

  }//end public function loadDefault */

  /**
   * @param WbfsysAnnouncement_Table_Query $query
   * @param string $condition
   * @param TFlag $params
   */
  public function fetchListTableDefault($query, $condition, $params)
  {

    // laden der mvc/utils adapter Objekte
    $acl  = $this->getAcl();
    $user = $this->getUser();
    $orm  = $this->getDb()->getOrm();

    $userId    = $user->getId();

    // erstellen der Acl criteria und befüllen mit den relevanten cols
    $criteria  = $orm->newCriteria();

    $criteria->select(array('wbfsys_announcement.rowid as rowid')  );

    if (!$this->defLevel) {
      $greatest = <<<SQL

  acls."acl-level"

SQL;

      $joinType = ' ';

    } else {

      $greatest = <<<SQL

  greatest
  (
    {$this->defLevel},
    acls."acl-level"
  ) as "acl-level"

SQL;

      $joinType = ' LEFT ';

    }

    $criteria->selectAlso($greatest  );

    $query->setTables($criteria);
    $query->appendConditions($criteria, $condition, $params  );
    $query->checkLimitAndOrder($criteria, $params);
    $query->appendFilter($criteria, $condition, $params);

    $criteria->join
    (
      " {$joinType} JOIN
        {$acl->sourceRelation} as acls
        ON
          UPPER(acls.\"acl-area\") IN(UPPER('mod-wbfsys'), UPPER('mgmt-wbfsys_announcement'))
            AND acls.\"acl-user\" = {$userId}
            AND acls.\"acl-vid\" = wbfsys_announcement.rowid ",
      'acls'
    );

    $tmp = $orm->select($criteria);
    $ids = array();

    foreach ($tmp as $row) {
      $ids[$row['rowid']] = $row['acl-level'];
    }

    $query->setCalcQuery($criteria, $params);

    return $ids;

  }//end public function fetchListTableDefault */

}//end class WbfsysAnnouncement_Table_Access

