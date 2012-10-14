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
class DaidalosDeployDocu_Model
  extends Model
{
  
  /**
   * @var LibProtocolReport
   */
  protected $protocol = null;

  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param array $data
   */
  public function protocol( $data, $opt1 = null, $opt2 = null )
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
  public function syncDocu( )
  {

    $orm        = $this->getOrm();
    $db         = $this->getDb();
    $respsonse  = $this->getResponse();
    
    $repos  = Webfrap::getIncludePaths( 'metadata' );

    $this->protocol = new LibProtocolReport( 'log/report_sync_doku_'.date('YmdHis').'.html' );
    
    $this->protocol->head(array(
      'Type',
      'Key',
      'Entity',
      'Message'
    ));
    
    $this->syncDocu_Root( $orm, $repos  );
    $this->syncDocu_ArchNode( $orm, $repos, 'profile', 'Profiles'  );
    $this->syncDocu_ArchNode( $orm, $repos, 'module', 'Modules'  );
    $this->syncDocu_ArchNode( $orm, $repos, 'service', 'Services'  );
    $this->syncDocu_ArchNode( $orm, $repos, 'entity', 'Entities'  );
    $this->syncDocu_ArchNode( $orm, $repos, 'management', 'Managements'  );
    $this->syncDocu_ArchNode( $orm, $repos, 'role', 'Roles'  );
    $this->syncDocu_ArchNode( $orm, $repos, 'custom', 'Doku'  );


  }//end public function syncDocu */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   */
  public function syncDocu_ArchNode( $orm, $modules, $archKey, $archLabel  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser(); 
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( $archLabel );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( PATH_ROOT.$module.'/data/docu/'.$archKey.'/' );

      $files = $folder->getFilesByEnding('.php');

      foreach( $files as $file )
        include $file;
        
      $folder = new LibFilesystemFolder( PATH_ROOT.$module.'/sandbox/data/docu/'.$archKey.'/' );

      $files = $folder->getFilesByEnding('.php');

      foreach( $files as $file )
        include $file;

    }

  }//end public function syncDocu_ArchNode */
  
  /**
   * @param LibDbOrm $orm
   * @param array $modules
   */
  public function syncDocu_Root( $orm, $modules  )
  {

    $orm  = $this->getOrm();
    $user = $this->getUser(); 
    $respsonse   = $this->getResponse();
    
    $this->protocol->paragraph( 'Doku Root' );

    foreach( $modules as $module )
    {
      $folder = new LibFilesystemFolder( PATH_ROOT.$module.'/data/docu/arch/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;
        
      $folder = new LibFilesystemFolder( PATH_ROOT.$module.'/sandbox/data/docu/arch/' );

      $files = $folder->getFilesByEnding('.php');

      foreach ($files as $file)
        include $file;

    }

  }//end public function syncDocu_Root */


}//end class DaidalosDeployDoku_Model

