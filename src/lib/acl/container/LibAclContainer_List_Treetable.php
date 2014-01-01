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
class LibAclContainer_List_Treetable extends LibAclContainer_List
{

  protected $refFieldName = null;
  
  /**
   * @param LibSqlQuery $query
   * @param string $condition
   * @param TFlag $params
   */
  public function injectFetchChildAcls($query, $parentIds, $condition, $params)
  {
  
    // direkt einen leere aray zurückgeben wenn keine ids datensätze geladen
    // werden sollen
    if (!$parentIds)
      return array();
  
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
    //$query->appendConditions($criteria, $condition, $params);
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
  
    $criteria->where( $this->srcName.'.'.$this->refFieldName.' in('.implode(',',$parentIds).')');
  
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
  
  }//end public function injectListAcls */
  
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
  public function fetchChildrenIds($context, $query, $ids, $conditions, $params = null  )
  {
  
    return $this->injectFetchChildAcls($query, $ids, $conditions, $params);
  
  }//end public function fetchChildrenIds */
  
  public function fetchListDefault($query, $condition, $params)
  {
    return $this->injectListAcls($query, $condition, $params);
  }
  
  
  public function fetchChildrenDefault($query, $parentIds, $condition, $params)
  {
    return $this->injectFetchChildAcls($query, $parentIds, $condition, $params);
  }

}//end class LibAclContainer_List_Treetable

