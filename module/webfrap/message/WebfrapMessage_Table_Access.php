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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMessage_Table_Access
  extends LibAclPermission
{

  /**
   * @param TFlag $params
   * @param WbfsysMessage_Entity $entity
   */
  public function loadDefault( $params, $entity = null )
  {

    // laden der benötigten Resource Objekte
    $acl = $this->getAcl();

    $this->level = Acl::DELETE;

  }//end public function loadDefault */

  /**
   * @param LibSqlQuery $query
   * @param string $condition
   * @param TFlag $params
   */
  public function fetchListTableDefault( $query, $condition, $params )
  {

    // laden der benötigten Resource Objekte
    $acl  = $this->getAcl();
    $user = $this->getUser();
    $orm  = $this->getDb()->getOrm();

    $userId    = $user->getId();

    // erstellen der Acl criteria und befüllen mit den relevanten cols
    $criteria  = $orm->newCriteria();

    $criteria->select( array( 'wbfsys_message.rowid as rowid' )  );

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

    $criteria->selectAlso( $greatest  );

    $query->setTables( $criteria );
    $query->appendConditions( $criteria, $condition, $params  );
    $query->checkLimitAndOrder( $criteria, $params );
    $query->appendFilter( $criteria, $condition, $params );

    $criteria->join
    (
      " {$joinType} JOIN
        {$acl->sourceRelation} as acls
        ON
          UPPER(acls.\"acl-area\") IN( UPPER('mod-wbfsys'), UPPER('mgmt-wbfsys_message') )
            AND acls.\"acl-user\" = {$userId}
            AND acls.\"acl-vid\" = wbfsys_message.rowid ",
      'acls'
    );

    $tmp = $orm->select( $criteria );
    $ids = array();

    foreach ($tmp as $row) {
      $ids[$row['rowid']] = $row['acl-level'];
    }

    $query->setCalcQuery( $criteria, $params );

    return $ids;

  }//end public function fetchListTableDefault */

}//end class WbfsysMessage_Widget_Access
