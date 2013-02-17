<h1>List Acls</h1>

<p>Beschreibung der List Acl Query</p>

<label>Beispiel einer Treetable</label>
<?php start_highlight(); ?>

  /**
   * @param ProjectActivityMaskProduct_Ref_ProjectTask_Treetable_Query $query
   * @param string $condition
   * @param TFlag $rqtContext
   */
  public function fetchListTreetableDefault( $query, $condition, $rqtContext )
  {

    // laden der benötigten Resource Objekte
    $acl  = $this->getAcl();
    $user = $this->getUser();
    $orm  = $this->getDb()->getOrm();

    $userId    = $user->getId();

    // erstellen der Acl criteria und befüllen mit den relevanten cols
    $criteria  = $orm->newCriteria( 'inner_acl' );
    
    $envelop = $orm->newCriteria( );
    $envelop->subQuery = $criteria;
    $envelop->select(array(
      'inner_acl.rowid',
      'max( inner_acl."acl-level" ) as "acl-level"'
    ));
    $query->injectLimit( $envelop, $rqtContext );
    $envelop->groupBy( 'inner_acl.rowid' );

    $criteria->select( array( 'project_task.rowid as rowid' )  );

    if( !$this->defLevel )
    {
    
      $greatest = <<<SQL

  acls."acl-level"

SQL;

      $joinType = ' ';

    }
    else
    {

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
    $query->appendConditions( $criteria, $condition, $rqtContext );
    $query->injectAclOrder( $criteria, $envelop, $rqtContext );
    $query->appendFilter( $criteria, $condition, $rqtContext );

    $criteria->join
    (
      " {$joinType} JOIN
        {$acl->sourceRelation} as acls
        ON
          UPPER(acls.\"acl-area\") IN( UPPER('mod-project'), UPPER('mgmt-project_task') )
            AND acls.\"acl-user\" = {$userId}
            AND acls.\"acl-vid\" = project_task.rowid ",
      'acls'
    );
    
    $tmp         = $orm->select( $envelop );
    $ids       = array();
    $this->ids = array();
    
    foreach( $tmp as $row )
    {
      $ids[$row['rowid']] = (int)$row['acl-level'];
      $this->ids[] = $row['rowid'];
    }
    
    $this->ids = array_keys($ids);
    
    $query->setCalcQuery( $criteria, $rqtContext );
    
    return $ids;

  }//end public function fetchListTreetableDefault */

<?php display_highlight( 'php' ); ?>