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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosDeployDatabase_Model
  extends Model
{
  
  /**
   * @var LibProtocolReport
   */
  protected $protocol = null;
  
  /**
   * @var boolean
   */
  protected $syncCol  = false;
  
  /**
   * @var boolean
   */
  protected $forceColSync  = false;
  
  /**
   * @var boolean
   */
  protected $syncTable  = false;

  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param boolean $sync
   */
  public function syncCol( $sync )
  {
    $this->syncCol = $sync;
  }//end public function syncCol */
  
  /**
   * @param boolean $sync
   */
  public function forceColSync( $sync )
  {
    $this->forceColSync = $sync;
  }//end public function forceColSync */
  
  /**
   * @param boolean $sync
   */
  public function syncTable( $sync )
  {
    $this->syncTable = $sync;
  }//end public function syncTable */
  
  /**
   * @param array $data
   */
  public function protocol( $data, $opt1 = null, $opt2 = null, $opt3 = null )
  {
    
    if( $this->protocol )
      $this->protocol->entry( $data );
    
  }//end public function protocol */
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function syncMetadata( $rootPath = PATH_ROOT )
  {

    $orm        = $this->getOrm();
    $db         = $this->getDb();
    $respsonse  = $this->getResponse();
    
    $repos  = Webfrap::getIncludePaths( 'metadata' );

    $this->protocol = new LibProtocolReport( 'log/report_sync_metadata_'.date('YmdHis').'.html' );
    
    $this->protocol->head(array(
      'Type',
      'Key',
      'Entity',
      'Message'
    ));
    
    $deployRevision = $db->nextVal( 'wbf_deploy_revision' );
    
    $this->syncMetadata_SecurityArea( $orm, $repos, $deployRevision, $rootPath );
    $this->syncMetadata_Desktop( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_Profile( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_Role( $orm, $repos, $deployRevision, $rootPath  );

    $this->syncMetadata_Module( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_ModuleCategory( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_ModuleAccess( $orm, $repos, $deployRevision, $rootPath  );

    $this->syncMetadata_Entity( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_EntityRef( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_EntityAccess( $orm, $repos, $deployRevision, $rootPath  );

    $this->syncMetadata_Management( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_ManagementRef( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_ManagementAccess( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_ManagementMaintenance( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_ManagementAcl( $orm, $repos, $deployRevision, $rootPath  );

    $this->syncMetadata_Process( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_Item( $orm, $repos, $deployRevision, $rootPath  );
    $this->syncMetadata_Widget( $orm, $repos, $deployRevision, $rootPath  );

  }//end public function syncMetadata */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_SecurityArea( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Security Area' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/security_area/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/security_area/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }

  }//end public function syncMetadata_SecurityArea */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Module( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Module' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/module/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/module/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_Module */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_ModuleAccess( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Module Access' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/module_access/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/module_access/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_ModuleAccess */


  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_ModuleCategory( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Module Category' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/module_category/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/module_category/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_ModuleCategory */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Entity( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Entity' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/entity/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/entity/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
    }

  }//end public function syncMetadata_Entity */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_EntityAccess( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Entity Access' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/entity_access/' );

      $files = $folder->getFilesByEnding( '.php' );

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/entity_access/' );

      $files = $folder->getFilesByEnding( '.php' );

      foreach ($files as $file)
        include $file;

    }

  }//end public function syncMetadata_EntityAccess */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_EntityRef( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Entity Ref' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/entity_ref/' );

      $files = $folder->getFilesByEnding('.php');

      foreach( $files as $file )
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/entity_ref/' );

      $files = $folder->getFilesByEnding('.php');

      foreach( $files as $file )
        include $file;

    }
  }//end public function syncMetadata_EntityRef */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Management( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Management' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/management/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/management/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_Management */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_ManagementMaintenance( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Management Maintenance' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/management_maintenance/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/management_maintenance/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_ManagementMaintenance */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_ManagementAcl( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Management Acl' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/management_acl/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/management_acl/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_ManagementAcl */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_ManagementAccess( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Management Access' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/management_access/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/management_access/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }

  }//end public function syncMetadata_ManagementAccess */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_ManagementRef( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Management Ref' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/management_ref/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/management_ref/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_ManagementRef */

  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Profile( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Profile' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/profile/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/profile/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_Profile */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Process( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Process' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/process/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/process/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_Process */


  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Role( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();

    $this->protocol->paragraph( 'Role' );
    
    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/role/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/role/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
  }//end public function syncMetadata_Role */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Widget( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Widget' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/widget/' );

      $files = $folder->getFilesByEnding('.php');

      foreach( $files as $file )
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/widget/' );

      $files = $folder->getFilesByEnding('.php');

      foreach( $files as $file )
        include $file;

    }
    
  }//end public function syncMetadata_Widget */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Desktop( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Desktop' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/desktop/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/desktop/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
    
  }//end public function syncMetadata_Desktop */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   * @param int $deployRevision
   * @param string $rootPath
   */
  public function syncMetadata_Item( $orm, $modules, $deployRevision, $rootPath  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();
    $acl  = $this->getAcl();  
    $aclManager  = $acl->getManager();   
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Item' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( $rootPath.$module.'/data/metadata/item/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( $rootPath.$module.'/sandbox/data/metadata/item/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }
    
  }//end public function syncMetadata_Desktop */

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function syncDatabase( $rootPath = PATH_ROOT )
  {
    
    $respsonse  = $this->getResponse();
    $gmods      = Webfrap::getIncludePaths('metadata');

    $dbAdmin    = new LibDbAdminPostgresql( $this->getDb() );

    $allTables = array();
    $tmp = $dbAdmin->getDbTables();

    foreach( $tmp as $tab )
    {
      $allTables[$tab['name']] = $tab['name'];
    }

    foreach( $gmods as $gmod )
    {
      $folder = new LibFilesystemFolder( $rootPath.$gmod.'/data/metadata/structure/postgresql/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

      $folder = new LibFilesystemFolder( $rootPath.$gmod.'/sandbox/data/metadata/structure/postgresql/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
    }

    foreach( $allTables as $tableName  )
    {
      if( $this->syncTable )
      {
        $this->getResponse()->addError( 'Dropped Table: '.$tableName.' cause it was not described in the model' );
        $dbAdmin->dropTable($tableName);
      }
      else 
      {
        $this->getResponse()->addError( 'Table: exists '.$tableName.' but is not described in the model' );
      }
      
    }

  }//end public function syncDatabase */

  /**
   * synchronize the default data from the model with the actual database
   * @param string $rootPath
   */
  public function syncData( $rootPath = PATH_ROOT )
  {

    $orm      = $this->getOrm();
    $response = $this->getResponse();

    $dataPaths = Webfrap::getIncludePaths( 'metadata' );
    foreach( $dataPaths as $dataPath )
    {
      
      $folder = new LibFilesystemFolder( $rootPath.$dataPath.'/data/metadata/data/' );
      $files  = $folder->getFilesByEnding( '.php' );

      foreach( $files as $file )
      {
        
        try
        {
          include $file;
        }
        catch( LibDb_Exception $e )
        {
          $response->addError( $e->getMessage() );
        }

      }
      
      // sandbox
      $folder = new LibFilesystemFolder( $rootPath.$dataPath.'/sandbox/data/metadata/data/' );
      $files  = $folder->getFilesByEnding( '.php' );

      foreach( $files as $file )
      {
        
        try
        {
          include $file;
        }
        catch( LibDb_Exception $e )
        {
          $response->addError( $e->getMessage() );
        }

      }

    }

  }//end public function syncData */

}//end class DaidalosDeploy_Model

