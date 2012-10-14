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
class DaidalosBackupDb_Model
  extends Model
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
  public function getConnections( )
  {

    //$db   = $this->getDb();

    $conf = $this->getConf();

    $data = $conf->getConf('db');

    return isset($data['connection'])?$data['connection']:array();



  }//end public function getConnections */

  /**
   * @return void
   */
  public function backup( $conf  )
  {


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


}//end class DaidalosBackupDb_Model

