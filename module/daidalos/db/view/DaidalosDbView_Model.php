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
 * @package WebFrap
 * @subpackage Core
 */
class DaidalosDbView_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Liste der Views
   * @var string
   */
  public $wbfViews = array
  (
    'view_person_role', 
    'view_user_role_contact_item',
    'view_employee_person_role',
    
    'webfrap_load_area_permission_view',
    'webfrap_load_dataset_permission_view',
    'webfrap_acl_group_permission_view',
    'webfrap_acl_area_access_view',
    'webfrap_acl_level_global_asgd_view',

    'webfrap_inject_acls_view',
    'webfrap_has_arearole_view',
    'webfrap_acl_permission_view',
    'webfrap_acl_assigned_view',
    'webfrap_acl_max_permission_view',
  );
  
  /**
   * Name der Datenbank
   * @var string
   */
  public $dbName = null;
  
  /**
   * Name des Schemas
   * @var string
   */
  public $schemaName = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $dbName
   * @return array liste der Views 
   */
  public function getViews( $schema )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
SELECT 
c.oid, 
c.xmin, 
c.relname as view_name, 
pg_get_userbyid(c.relowner) AS viewowner,
na.nspname as schema_name,  
c.relacl, 
description, 
pg_get_viewdef(c.oid, true) AS definition
  FROM pg_class c
  LEFT OUTER JOIN pg_description des ON (des.objoid=c.oid and des.objsubid=0)
  JOIN pg_namespace na ON na.oid = c.relnamespace
 WHERE ((c.relhasrules AND (EXISTS (
           SELECT r.rulename FROM pg_rewrite r
            WHERE ((r.ev_class = c.oid)
              AND (bpchar(r.ev_type) = '1'::bpchar)) ))) OR (c.relkind = 'v'::char))
   AND na.nspname = '{$schema}'
 ORDER BY relname

SQL;

    $sql .= ";";
    
    return $db->select( $sql )->getAll();
    
  }//end public function getViews */

  /**
   * @param string $dbName
   * @return Details der View
   */
  public function getViewDetails( $schema, $viewName )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
SELECT 
  att.*, 
  def.*, 
  pg_catalog.pg_get_expr(def.adbin, def.adrelid) AS defval, 
  CASE  WHEN att.attndims > 0 THEN 1 ELSE 0 END AS isarray, 
  format_type(ty.oid,NULL) AS typname, 
  format_type(ty.oid,att.atttypmod) AS displaytypname, 
  tn.nspname as typnspname, 
  et.typname as elemtypname,
  cl.relname, 
  na.nspname, 
  att.attstattarget, 
  description, 
  cs.relname AS sername, 
  ns.nspname AS serschema,
  (
    SELECT count(1) FROM pg_type t2 WHERE t2.typname=ty.typname) > 1 AS isdup, indkey,
      CASE 
        WHEN EXISTS( SELECT inhparent FROM pg_inherits WHERE inhrelid=att.attrelid )
        THEN att.attrelid::regclass
         ELSE NULL
      END 
    AS inhrelname,
  EXISTS(SELECT 1 FROM  pg_constraint WHERE conrelid=att.attrelid AND contype='f' AND att.attnum=ANY(conkey)) As isfk
  FROM pg_attribute att
  JOIN pg_type ty ON ty.oid=atttypid
  JOIN pg_namespace tn ON tn.oid=ty.typnamespace
  JOIN pg_class cl ON cl.oid=att.attrelid
  JOIN pg_namespace na ON na.oid=cl.relnamespace
  LEFT OUTER JOIN pg_type et ON et.oid=ty.typelem
  LEFT OUTER JOIN pg_attrdef def ON adrelid=att.attrelid AND adnum=att.attnum
  LEFT OUTER JOIN pg_description des ON des.objoid=att.attrelid AND des.objsubid=att.attnum
  LEFT OUTER JOIN (pg_depend JOIN pg_class cs ON objid=cs.oid AND cs.relkind='S') ON refobjid=att.attrelid AND refobjsubid=att.attnum
  LEFT OUTER JOIN pg_namespace ns ON ns.oid=cs.relnamespace
  LEFT OUTER JOIN pg_index pi ON pi.indrelid=att.attrelid AND indisprimary
 WHERE cl.relname = '{$viewName}'
   and na.nspname = '{$schema}'
   AND att.attisdropped IS FALSE
 ORDER BY att.attnum

SQL;

    $sql .= ";";
    
    return $db->select($sql)->getAll();
    
  }//end public function getViewDetails */
  
  
/*//////////////////////////////////////////////////////////////////////////////
// WebFrap Special Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Löschen aller Wbf Views
   * @param string $schema
   */
  public function dropWbfViews( $schema )
  {
    
    $dbAdmin = $this->getDb()->getManager();
    
    foreach( $this->wbfViews as $viewName )
    {
      
      if( $dbAdmin->viewExists( $viewName ) )
        $dbAdmin->dropView( $viewName );
    }
    
  }//end public function dropWbfViews */
  
  /**
   * Löschen aller Wbf Views
   * @param string $schema
   */
  public function createWbfViews( $schema )
  {
    
    $db = $this->getDb();
    
    $db->exec( file_get_contents( PATH_FW.'data/ddl/postgresql/acl.views.sql' ) );
    $db->exec( file_get_contents( PATH_FW.'data/ddl/postgresql/sys.views.sql' ) );
    
  }//end public function createWbfViews */
  

}//end class DaidalosDbView_Model

