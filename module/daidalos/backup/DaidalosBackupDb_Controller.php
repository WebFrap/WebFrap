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
class DaidalosBackupDb_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'table',
    'form',
    'backup'
  );


////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////


  /**
   * @return void
   */
  public function table( )
  {


    $params = $this->getFlags( $this->getRequest() );

    $view = $response->loadView('table_maintenance_backup', 'DaidalosBackupDb');

    $model = $this->loadModel('DaidalosBackupDb');
    $view->setModel($model);

    $view->displayListing( $params );


  }//end public function table */

  /**
   * @return void
   */
  public function backup( )
  {

    // check if the request type is WINDOW, if not return an error page
    if( !$this->view->isType(View::AJAX) )
    {
      $this->errorPage
      (
        $this->i18n->l
        (
          'Invalid viewtype',
          'wbf.message.invalidViewType'
        ),
        $this->i18n->l
        (
          'This request is only valid for window requests',
          'wbf.message.requestMustBeWindow'
        )
      );
      return false;
    }

    $request = $this->getRequest();;

    $objid = $request->get('objid',Validator::CNAME);

    $db   = Db::getActive();
    $conf = Conf::get('db');

    $dbConf = $conf['connection'][$objid];

    /*
      'class'     => 'PostgresqlPersistent',
      'dbhost'    => 'localhost',
      'dbport'    => '5432',
      //'dbname'    => 'webfrap_de',
      'dbname'    => 'db_name',
      'dbuser'    => 'db_user',
      'dbpwd'     => 'db_pwd',
      'dbschema'  => 'schema',
      'quote'     => 'single' // single|multi
     */





  }//end public function table */


}//end class DaidalosBackupDb_Controller

