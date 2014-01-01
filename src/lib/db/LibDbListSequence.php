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
 * @subpackage
 */
class LibDbListSequence
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibDbConnection
   */
  protected $db = null;


/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibDbConnection $db
   */
  public function __construct($db)
  {

    $this->db = $db;

  }//end public function __construct */

  /**
   * @param string $sourceKey
   * @param string $dsetKey
   */
  public function nextVal($sourceKey, $dsetKey)
  {

    $sql = <<<SQL
  SELECT
    cval
  FROM {$sourceKey} where ckey = '{$dsetKey}';
SQL;


    $sql = <<<SQL
  UPDATE
    {$sourceKey}
  SET cval = cval +1
  WHERE
    ckey = '{$dsetKey}';
SQL;

  }//end public function nextVal */



  /**
   * @param string $sourceKey
   * @param string $dsetKey
   */
  public function createSequ($sourceKey, $dsetKey)
  {

    $sql = <<<SQL
  SELECT
    cval
  FROM {$sourceKey} where ckey = '{$dsetKey}';
SQL;


    $sql = <<<SQL
  UPDATE
    {$sourceKey}
  SET cval = cval +1
  WHERE
    ckey = '{$dsetKey}';
SQL;

  }//end public function nextVal */


} // end class LibDbListSequence

