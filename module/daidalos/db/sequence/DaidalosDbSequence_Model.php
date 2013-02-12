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
class DaidalosDbSequence_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return array Liste aller vorhandenen Sequenzen
   */
  public function getSequences( $schema )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  cl.oid,
  relname,
  pg_get_userbyid(relowner) AS seqowner,
  relacl,
  description
FROM
  pg_class cl
LEFT OUTER JOIN
  pg_description des ON des.objoid=cl.oid
JOIN
  pg_namespace ns
    ON ns.oid = cl.relnamespace

 WHERE
   relkind = 'S'
     AND ns.nspname  = '{$schema}'
 ORDER BY relname

SQL;

    $sql .= ";";

    return $db->select($sql)->getAll();

  }//end public function getSequences */


  /**
   * @return array liste der Views
   * /
  public function getSequences( $schema, $seqName  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  last_value,
  min_value,
  max_value,
  cache_value,
  is_cycled,
  increment_by,
  is_called
FROM {$schema}.{$seqName}

SQL;

    $sql .= ";";

    return $db->select($sql)->getAll();

  }//end public function getSequences */

  /**
   * Owner einer Sequence ändern
   * @param string $sequence
   * @param string $owner
   */
  public function chownSequence( $schema, $seqName, $owner )
  {

    $sql = "ALTER SEQUENCE {$schema}.{$sequence} OWNER TO {$owner}; ";

    return $this->db->exec( $sql );

  }//end public function setTableOwner */

}//end class DaidalosDbView_Model
