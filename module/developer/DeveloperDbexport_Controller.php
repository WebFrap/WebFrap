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
 * @subpackage ModDeveloper
 */
class DeveloperDbexport_Controller
  extends Controller
{

  /**
   * @var string the default Action
   */
  protected $defaultAction = 'listentity';

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $callAble = array
  (
  'listentity','exportentitysql','recreatedatabase','createdump'
  );

////////////////////////////////////////////////////////////////////////////////
// Der Controller
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $action
   */
  public function run( $action = null )
  {


    if(!$this->checkAction( $action ))
    {
      return;
    }

    $this->defaultRun( );



  }//end public function run

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   */
  public function listEntity()
  {

    $request = $this->getRequest();

    if( $this->view->isType( View::WINDOW ) )
    {
     $view = $this->view->newWindow('TableDeveloperDbexport', 'Default');
    }
    else
    {
     $view = View::getActive();
    }

    $view->setTemplate( 'ListEntity' , 'developer' );
    $view->addUrl
    (
      'actionSearchCoreEntity',
      'maintab.php?mod=Developer&mex=Dbexport&do=listEntity'
    );

    FormCoreEntity::createSearchForm( $view );

    $inputSubmit = $view->addForm( 'inputSubmit' , 'Input' );
    $inputSubmit->addAttributes
    (array(
      'type'  => 'submit',
      'class' => 'wgtButton submit',
      'title' => I18n::s('core.entity.tpl.titleSubmitSearch'  ),
      'value' => I18n::s('core.entity.tpl.textSubmitSearch'  ),
    ));

    $tableCoreEntity = $view->newItem('tableCoreEntity' ,'TableDeveloperEntity');


    if( $name = Request::post( 'search_coreentity' , 'cname' , 'name'  ) )
    {
      $condition = ' core_entity.name like \'%'.$name.'%\' ';
    }

    $collection = new CollectionCoreEntity();
    $collection->collect
    (
      $condition,
      $request->param('order','Quoted'),
      $request->param('limit','Int'),
      $request->param('start','Int')
    );
    $tableCoreEntity->addData($collection);

  }//end public function listEntity()

  /**
   * Enter description here...
   *
   */
  public function exportEntitySql()
  {

    $request = $this->getRequest();

    if( $this->view->isType( View::WINDOW )  )
    {
      $view = $this->view->newWindow('TableDeveloperEntityExport', 'Default');
    }
    else
    {
      $view = $this->view;
    }


    $entity = $request->param( 'entity', 'Cname' );
    $dao    = Db::getDao($entity);

    $quotes = $dao->getQuotesdata();

    $sql = '';
    foreach( $dao->getAll( array('*') , false ) as $row )
    {
      $sql .= SParserSql::arrayToInsert( $row , $entity , $quotes , 'webfrap' );
    }

    $view->setTemplate( 'SqlEntity' , 'developer' );
    $view->addVar( 'sql' , $sql );

  }//end public function exportEntitySql()

  /**
   * Enter description here...
   *
   */
  public function recreateDatabase()
  {

     if( $this->view->isType( View::WINDOW )  )
     {
       $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
     }
     else
     {
       $view = $this->view;
     }

    $view->setTemplate( 'MenuModmenu' , 'base' );
    $modMenu = $view->newItem
    (
    'modMenu' ,
    'MenuDeveloperModmenu'
    );


    SFilesystem::cleanFolder( PATH_GW.'cache/entity_cache/');

    $db = Db::getActive();


    if($error = $db->ddlQuery('DROP SCHEMA webfrap cascade;'))
    {
      $this->sys->addError('Failed to delete Schema: '.$error );
      return;
    }

    if($error = $db->ddlQuery(SFiles::read(PATH_GW.'data/ddl/postgresql/FullDump.sql')))
    {
      $this->sys->addError('Failed to recreate the Database: '.$error);
    }
    else
    {
      $this->sys->addMessage('Sucessfully recreated Database');
    }


  }//end public function listEntity()

  /**
   * @return void
   */
  public function FormDatabaseData( )
  {

    $this->view->setTemplate( 'FormDatabaseExport' , 'developer' );


    $inputDbtyp = $this->view->newInput( 'inputDbtyp', 'Input' );
    $inputDbtyp->addAttributes
    (array(
    'type'  => 'text',
    'name'  => 'db[dbtype]',
    'class' => 'large'
    ));

    $inputDbname = $this->view->newInput( 'inputDbname', 'Input' );
    $inputDbname->addAttributes
    (array(
    'type'  => 'text',
    'name'  => 'db[dbname]',
    'class' => 'large'
    ));

    $inputUsername = $this->view->newInput( 'inputUsername', 'Input' );
    $inputUsername->addAttributes
    (array(
    'type'  => 'text',
    'name'  => 'db[dbuser]',
    'class' => 'large'
    ));

    $inputPassword = $this->view->newInput( 'inputPassword', 'Input' );
    $inputPassword->addAttributes
    (array(
    'type'  => 'password',
    'name'  => 'db[dbpwd]',
    'class' => 'large'
    ));

    $buttonSubmit = $this->view->newInput( 'buttonSubmit', 'Input' );
    $buttonSubmit->addAttributes
    (array(
    'type'  => 'submit',
    'class' => 'wgtInputSubmit',
    'value' => 'export tables'
    ));


    $tableTables = $this->view->newInput( 'tableTables', 'Input' );
    $tableTables->addAttributes
    (array(
    'name'  => 'db[tables]',
    'class' => 'large'
    ));


  } // end public function FormDatabaseData

  /**
   * Enter description here...
   *
   */
  public function createCvsfromTable()
  {

    $this->view->setTemplate( 'PageCreatedCsv' , 'developer' );

    $data = $this->request->post('db');

    $data['dbhost']   = 'localhost';
    $data['dbport']   = '5432';
    $data['dbschema'] = 'jshopjboss';

    if( isset( $data['dbtype'] ))
    {
      $className = 'Db'.ucfirst($data['dbtype']);
    }

    $db = new $className($data);

    $tables = explode( ';' , $data['tables']  );

    $tdata = array();

    foreach( $tables as $table )
    {
      $select = "select * from $table";
      $tdata[$table] = $db->select($select);
    }


    $this->view->addVar( 'csvData' ,  $tdata );

  }//end public function createCvsfromTable()

  public function createDump()
  {

    View::$sendBody = false;

    $metaModel = PATH_GW.'data/metamodels/ChinouMetaModel.xml';

    $dump = new LibDbDeveloperCreatePgTestdata();

    $dump->setSchema( 'ramses_test' );
    $dump->setMetaModell($metaModel);

    $dump->generateSqlScript();

    SFiles::write( PATH_GW.'data/ddl/TestDataDump.sql' ,$dump->getDdl() );

  }//end public function createDump()

} // end class MexDeveloperDbexport

