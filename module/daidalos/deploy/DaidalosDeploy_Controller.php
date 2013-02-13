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
class DaidalosDeploy_Controller
  extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  protected $options           = array
  (
    'syncmetadata' => array
    (
    ),
    'syncdatabase' => array
    (
    ),
    'syncdata' => array
    (
    ),
    'syncdocu' => array
    (
    ),
  );


/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * sync the metadata inside of the database
   */
  public function service_syncMetadata( $request, $respsonse )
  {

    /* @var $model DaidalosDeployDatabase_Model */
    $model = $this->loadModel( 'DaidalosDeployDatabase' );

    $respsonse->addMessage( 'Start Metadata Sync: '.date('Y-m-d H:i:s') );

    $rootPath = $request->param( 'root_path', Validator::FOLDERNAME )?:PATH_ROOT;
    $respsonse->addMessage( "Using Rootpath ".$rootPath );

    $type = $request->param( 'type', Validator::CNAME );

    $model->syncMetadata( $rootPath, $type );

    $respsonse->addMessage( 'Sucessfully synced Metadata '.date('Y-m-d H:i:s') );

  }//end public function service_syncMetadata */

  /**
   * sync the metadata inside of the database
   */
  public function service_syncDocu( $request, $respsonse )
  {


    $model = $this->loadModel( 'DaidalosDeployDocu' );
    /* @var $model DaidalosDeployDocu_Model */

    $respsonse->addMessage( 'Start Docu Sync: '.date('Y-m-d H:i:s') );

    $model->syncDocu();

    $respsonse->addMessage( 'Sucessfully synced Docu '.date('Y-m-d H:i:s') );

  }//end public function service_syncDocu */


  /**
   * synchronize the database structure
   */
  public function service_syncDatabase( $request, $respsonse )
  {


    $model = $this->loadModel( 'DaidalosDeployDatabase' );
    /* @var $model DaidalosDeployDatabase_Model */

    $syncCol   = $request->param( 'sync_col', Validator::BOOLEAN );
    $deleteCol = $request->param( 'delete_col', Validator::BOOLEAN );
    $syncTable = $request->param( 'sync_table', Validator::BOOLEAN );
    $rootPath  = $request->param( 'root_path', Validator::FOLDERNAME )?:PATH_ROOT;

    if( $deleteCol )
      $model->forceColSync( true );

    $model->syncCol( $syncCol );
    $model->syncTable( $syncTable );

    $respsonse->addMessage( "Start Database Sync" );

    if( $syncTable )
    {
      $respsonse->addMessage( "Try to Sync Tables" );
    }

    if( $syncCol )
    {
      $respsonse->addMessage( "Try to Sync Cols" );
    }

    $respsonse->addMessage( 'Start Table Sync: '.date('Y-m-d H:i:s') );
    $model->syncDatabase( $rootPath );
    $respsonse->addMessage( 'Sucessfully sychronised Tables '.date('Y-m-d H:i:s') );

  }//end public function service_syncDatabase */

  /**
   * synchronize with the data from the modell
   */
  public function service_syncData( $request, $respsonse )
  {

    $rootPath  = $request->param( 'root_path', Validator::FOLDERNAME )?:PATH_ROOT;

    $model = $this->loadModel( 'DaidalosDeployDatabase' );
    /* @var $model DaidalosDeployDatabase_Model */

    $respsonse->addMessage( 'Start Model / Data Sync: '.date('Y-m-d H:i:s') );
    $model->syncData( $rootPath );
    $respsonse->addMessage( 'Sucessfully sychronized Data from the Model '.date('Y-m-d H:i:s') );

  }//end public function service_syncData */

/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/



}//end class DaidalosDeploy_Controller

