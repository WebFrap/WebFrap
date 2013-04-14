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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageLoader
{

  /**
   * @var LibDbConnection $db
   */
  public $db = null;

  /**
   * @param LibDbConnection $db
   */
  public function __construct( $db, $user )
  {

    $this->db = $db;
    $this->user = $user;

  }//end public function __construct */


  /**
   * @param array $list
   */
  public function messagesExists( array $list )
  {

    $sql = <<<SQL
SELECT
  rowid,
  message_id
FROM

SQL;


  }//end public function messagesExists */


} // end LibMessageLoader

