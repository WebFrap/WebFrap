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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Webfrap_Acl_ViewBuilder
  extends DataContainer
{
////////////////////////////////////////////////////////////////////////////////
// run method
////////////////////////////////////////////////////////////////////////////////

  /**
   * 
   */
  public function run()
  {
    
    // explizit admin connection anfordern
    $db = Db::connection( 'admin' );
    $defDb = $this->getDb();
    
    $dbManager = $db->getManager();
    
    $userName = $defDb->dbUser;
    
    if( !$db )
    {
      throw new LibDb_Exception( "No admin connetion defined!" );
    }
    
    $persistentViews = array
    (
      'webfrap_acl_assigned',
      'webfrap_acl_max_permission',
      'webfrap_inject_acls'
    );
    
    foreach( $persistentViews as $pView )
    {
      
      $dropQuery = <<<SQL
drop table {$pView}_pview
SQL;

      $createQuery = <<<SQL
SELECT * INTO {$pView}_pview FROM {$pView}_view
SQL;

      $alterOwnerQuery = <<<SQL
ALTER TABLE {$pView}_pview OWNER TO {$userName}
SQL;
      
      if( $dbManager->tableExists( $pView.'_pview' ) )
      {
        $db->ddlQuery( $dropQuery );
      }
      $db->ddlQuery( $createQuery );
      $db->ddlQuery( $alterOwnerQuery );
      
    }
    
    // indices erstellen
    $db->ddlQuery( "CREATE INDEX webfrap_acl_assigned_p_upper_key ON webfrap_acl_assigned_pview ( (upper(\"acl-area\") ) );" );
    $db->ddlQuery( "CREATE INDEX webfrap_acl_assigned_p_vid_join ON webfrap_acl_assigned_pview ( \"acl-vid\" );" );
    
    $db->ddlQuery( "CREATE INDEX webfrap_inject_acls_p_upper_key ON webfrap_inject_acls_pview ( (upper(\"acl-area\") ) );" );
    $db->ddlQuery( "CREATE INDEX webfrap_inject_acls_vid_join ON webfrap_inject_acls_pview (\"acl-vid\");" );
    
  }//end public function run */

} // end class Webfrap_Acl_ViewBuilder */

