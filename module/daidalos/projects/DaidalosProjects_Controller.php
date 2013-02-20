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
class DaidalosProjects_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var unknown_type
   */
  protected $callAble = array
  (
    'genmask',
    'listing',
    'build',
    'deploy',
    'clean',
    'syncdatabase',
    'refreshdatabase',
    'createdbpatch',
    'newproject',
    'menu'
  );

  protected $projectPath = null;

/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function menu( )
  {

    if ($this->view->isType( View::WINDOW ) ) {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
      $view->setTitle('Daidalos Module');
    } else {
      $view = $this->view;
    }

    $view->setTemplate( 'menu/modmenu' );

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder' );
    $modMenu->setSource('genf/bdl/modmenu');

  }//end public function menu */

  /**
   * @return void
   */
  public function genMask( )
  {

    if ($this->view->isType( View::WINDOW ) ) {
      $view = $this->view->newWindow('DaidalosGenMask', 'DaidalosGenMask');
    } else {
      $view = $this->view;
    }

    $view->setTitle('Daidalos GenMask');

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder' );
    $modMenu->setSource('genf/bdl/modmenu');

  }//end public function genMask */

  /**
   * @return void
   */
  public function listing()
  {

    // check the acl permissions
    if (!$this->acl->access( array( 'daidalos/projects:access' )  ) ) {
      $this->errorPage( "Permission denied", Response::FORBIDDEN );

      return false;
    }

    // check the access type
    if (!$view = $response->loadView( 'table_daidalos_projects', 'DaidalosProjects' ) )
      return false;

    $view->display($this->getRequest(), $this->getFlags($this->getRequest() )  );

  }//end public function listing */

  /**
   * @return void
   */
  public function build( )
  {

    $view     = $this->getView();
    $request  = $this->getRequest();

    if (!$projectXml = $this->getProjectDescription() )
      return;

    if (!$builder = $this->getBuilder($projectXml )) {
      Error::addError('Failed to load Builder for: '.trim($projectXml->architecture));

      return;
    }

    try {

      $builder->loadProject($projectXml );
      $builder->loadInterpreter();
      $builder->buildTree();

      $cList = $request->param('cartridges', Validator::TEXT );

      if ( '' != trim($cList)  ) {
        $cList = explode( ',', $cList );

        $builder->setCartridgeFilter($cList);
      }

      if ($builder->build() )
        $view->setTitle( 'Successfully created project '.$this->projectPath );
      else
        $view->setTitle( 'Failed to create project '.$this->projectPath );

    } catch ( LibGenf_Exception $exc ) {
      $view->setTitle( 'Error While creating the project: '.$exc->getMessage() );
    }

    Log::info('Finished generation');

    Debug::console( 'MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB',null,null,true );
    Message::addMessage('MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB');

  } // end public function build */

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function deploy( )
  {

    $view     = $this->getView();
    $response = $this->getResponse();

    if (!$projectXml = $this->getProjectDescription() )
      return;

    /* @var $builder LibGenfBuild */
    if (!$builder = $this->getBuilder($projectXml )) {
      $response->addError('Failed to load Builder for: '.trim($projectXml->architecture));

      return;
    }

    try {
      $builder->loadProject($projectXml );

      if ($builder->deploy( ) ) {
        $response->addMessage( 'Successfully deployed project '.$this->projectPath );
        $view->setTitle( 'Successfully deployed project '.$this->projectPath );
      } else {
        $response->addError( 'Failed to deployed project '.$this->projectPath );
        $view->setTitle( 'Failed to deployed project '.$this->projectPath );
      }

    } catch ( LibGenf_Exception $exc ) {
      $view->setTitle( 'Error While creating the project: '.$exc->getMessage() );
    }

    Debug::console( 'MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB',null,null,true );
    $response->addMessage('MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB');

  } // end public function deploy */

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function clean( )
  {

    $view     = $this->getView();
    $response = $this->getResponse();

    if (!$projectXml = $this->getProjectDescription() )
      return;

    if (!$builder = $this->getBuilder($projectXml )) {
      $response->addError( 'Failed to load Builder for: '.trim($projectXml->architecture) );

      return;
    }

    try {
      $builder->loadProject($projectXml );

      $builder->clean();
      $view->setTitle( 'Successfully cleaned project code cache' );

    } catch ( LibGenf_Exception $exc ) {
      $view->setTitle( 'Error while cleaning the project: '.$exc->getMessage() );
    }

  } // end public function clean */

  /**
   * Enter description here...
   *
   */
  public function syncMetadata()
  {

    $view   = $this->getView();

    if (!$projectXml = $this->getProjectDescription() )
      return;

    if (!$builder = $this->getBuilder($projectXml )) {
      Error::addError('Failed to load Builder for: '.trim($projectXml->architecture));

      return;
    }

    try {
      $builder->loadProject($projectXml );
      $builder->loadInterpreter();
      $builder->buildTree( true );

      $builder->syncDatabase();
      $view->setTitle( 'Successfully synchronized the database with the model' );

    } catch ( LibGenf_Exception $exc ) {
      $view->setTitle( 'Failed to synchronize the db cause: '.$exc->getMessage() );
    }

    Debug::console( 'MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB',null,null,true );
    Message::addMessage('MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB');

  }//end public function syncMetadata */

  /**
   * Enter description here...
   *
   */
  public function syncDatabase()
  {

    $view   = $this->getView();

    if (!$projectXml = $this->getProjectDescription() )
      return;

    if (!$builder = $this->getBuilder($projectXml )) {
      Error::addError('Failed to load Builder for: '.trim($projectXml->architecture));

      return;
    }

    try {
      $builder->loadProject($projectXml );
      $builder->loadInterpreter();
      $builder->buildTree( true );

      $builder->syncDatabase();
      $view->setTitle( 'Successfully synchronized the database with the model' );

    } catch ( LibGenf_Exception $exc ) {
      $view->setTitle( 'Failed to synchronize the db cause: '.$exc->getMessage() );
    }

    Debug::console( 'MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB',null,null,true );
    Message::addMessage('MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB');

  }//end public function syncDatabase */

  /**
   * Enter description here...
   *
   */
  public function refreshDatabase()
  {

    $view   = $this->getView();

    if (!$projectXml = $this->getProjectDescription() )
      return;

    if (!$builder = $this->getBuilder($projectXml )) {
      Error::addError('Failed to load Builder for: '.trim($projectXml->architecture));

      return;
    }

    try {
      $builder->loadProject($projectXml );
      $builder->loadInterpreter();
      $builder->buildTree( true );

      $builder->cleanDatabase();
      $builder->syncDatabase();

      $builder->loadProjectDump();

      $view->setTitle( 'Successfully synchronized the database with the model' );

    } catch ( LibGenf_Exception $exc ) {
      $view->setTitle( 'Failed to synchronize the db cause: '.$exc->getMessage() );
    }

    Debug::console( 'MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB', null, null, true );
    Message::addMessage('MAX MEMORY '.round((memory_get_peak_usage() / (1024*1024) )).' MB' );

  }//end public function syncDatabase */

  /**
   * create a patch file to update a database
   *
   */
  public function createDbPatch()
  {

    $view     = $this->getView();
    $request  = $this->getRequest();

    $key  = $request->param('objid', Validator::CKEY ) ;

    $data = $this->model->getProjectMap( );

    if (!isset($data[$key]) ) {
      Message::addError( 'Requested invalid Key: '. $key  );

      return;
    }

    $projectPath = $data[$key][1];

    if (!file_exists($projectPath) ) {
      Message::addError( 'Project: '. $projectPath.' not exists' );

      return;
    }

    if (!$projectXml = simplexml_load_file($projectPath ) ) {
      Message::addError( 'Failed to load Project: '. $projectPath );

      return;
    }

    $version = isset($projectXml['version'])?  trim($projectXml['version']) : ModGenf::GENF_VERSION;
    $version = str_replace( array( '.', ' ' ), array( 'x', '' ) , $version );

    $compilerName = 'LibGenfCompile'.$version;

    $compiler = new $compilerName();

    if ($compiler->createDbPatch($projectXml ) )
      $view->setTitle('Successfully created the database pacth');

  }//end public function createDbPatch */

  /**
   * @return void
   */
  public function newProject()
  {

    if (  $this->view->isType( View::WINDOW ) ) {
      // create a window
      $view = $this->view->newWindow('FormularBdlProject');
      $view->setStatus( 'New Project' );
    } else {
      $view = $this->view;
    }

    $view->setTemplate( 'bdl/FormProject'  );
    $record = new RecordBdlProject( );
    $view->addVar('record',$record);

  }//end public function tableModel */

  /**
   *
   * @param $projectXml
   * @return LibGenfBuild
   */
  protected function getBuilder($projectXml )
  {

    $architecture = ucfirst(trim($projectXml->architecture));
    $builderClass = null;

    if ( isset($projectXml->architecture['version'] ) ) {
      $version = str_replace( array( '.', ' ' ), array( 'x', '' ) , $projectXml->architecture['version'] );

      $builderClass = 'LibGenfBuild'.$architecture.$version;

      if (!WebFrap::classLoadable($builderClass) ) {
        $builderClass = 'LibGenfBuild'.$architecture;

        if (!WebFrap::classLoadable($builderClass) ) {
          $builderClass = 'LibGenfBuild';
        }
      }

    }//if
    else {

      if (!WebFrap::classLoadable($builderClass) ) {
        $builderClass = 'LibGenfBuild'.$architecture;

        if (!WebFrap::classLoadable($builderClass) ) {
          $builderClass = 'LibGenfBuild';
        }
      }

    }//else

    if (Log::$levelDebug)
      Log::debug( 'Load builder with architecture: '.$builderClass );

    return new $builderClass;

  }//end protected function getBuildClass */

  /**
   * @return DOMDocument
   */
  protected function getProjectDescription()
  {

    $request = $this->getRequest();

    if ($pfile = $request->param('pfile', Validator::TEXT)) {
      $projectPath = $pfile;
    } else {

      $key    = $request->param('objid', Validator::CKEY ) ;
      $data   = $this->model->getProjectMap( );

      if (!isset($data[$key]) ) {
        Message::addError( 'Requested invalid Key: '. $key  );

        return;
      }

      $projectPath = $data[$key][1];
    }

    if (!file_exists($projectPath ) ) {
      Message::addError( 'Project: '. $projectPath.' not exists' );

      return;
    }

    if (!$projectXml = simplexml_load_file($projectPath ) ) {
      Message::addError( 'Failed to load Project: '. $projectPath );

      return null;
    }

    $this->projectPath = $projectPath;

    return $projectXml;

  }//end protected function getProjectDescription */

  /**
   *
   */
  public function upload($params = null )
  {

    $request    = $this->getRequest();

    // load the flow flags
    $params       = $this->getFlags($this->getRequest() );
    $params->ajax = true;

    if (!$dump = $request->file( 'project_bdl' ) ) {
      $this->view->message->addError('Missing Project File');

      return false;
    }

    $dump->copy(null, PATH_GW.'data/bdl/projects/upload/'  );

  }//end public function upload */

  /**
   *
   */
  public function delete($params = null )
  {

    $request    = $this->getRequest();

    // load the flow flags
    $params       = $this->getFlags($this->getRequest() );
    $params->ajax = true;

    if (!$objid = $this->request->get('objid',Validator::FILENAME) ) {
      $this->view->message->addError('got no file to delete');
    }

    unlink(PATH_GW.'data/bdl/projects/upload/'.$objid);

  }//end public function delete */

}//end class DaidalosProjects_Controller

