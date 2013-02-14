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
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class WebfrapNavigation_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// fetch methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
   * Loading the tabledata from the database
   * 
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchEntriesByKey($key, $params = null )
  {

    if (!$params )
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $key = trim($key);
    
    // prüfen ob mehrere suchbegriffe kommagetrennt übergeben wurden
    if ( strpos($key, ' ' ) )
    {
      
      $where = array();
    
      $parts = explode( ' ', $key );
    
      foreach($parts as $part )
      {
    
        $part = trim($part );
    
        // prüfen, dass der string nicht leer ist
        if ( '' == trim($part ) )
          continue;
    
        $where[] = <<<SQL
    (
      UPPER( name ) like UPPER('%{$part}%')
    )
    
SQL;
    
     }
     
     $where = implode( ' AND ', $where );
    
    } else {
    
     $where = <<<SQL
    (
      UPPER( name ) like UPPER('%{$key}%')
    )
SQL;
    
    }


    $sql = <<<SQL

  SELECT
    access_key as id,
    access_url as url,
    name as value,
    name as label,
    context
  FROM
    wbfsys_mask
  where
{$where}
and ( dset_mask = FALSE or dset_mask is null )
  order by
    name,
    access_key
  LIMIT 17;

SQL;

    $result = $db->select($sql )->getAll();
    
    //  and  dset_mask = FALSE
    
    foreach($result as $row )
    {
      
      $row['url'] = 'maintab.php?c='.$row['url'];
      
      $this->data[] = $row;
    }

  }//end public function fetchEntriesByKey */

} // end class WebfrapNavigation_Query */

