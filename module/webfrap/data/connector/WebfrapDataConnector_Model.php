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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapDataConnector_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $request WebfrapDataConnector_Search_Request 
   */
  public function search( $searchRqt )
  {
    
    $orm = $this->getOrm();
    
    $tokens = explode(':', $searchRqt->free);

    $type = null;
    $searchValue = null;

    if (isset($tokens[1])){
      $type = $tokens[0];
      $searchValue = $tokens[1];
    } else {
      $searchValue = $tokens[0];
    }

    $criteria = $orm->newCriteria();

    $criteria->select(<<<SQL
  idx.rowid,
  idx.title,
  idx.access_key as key,
  idx.description,
  idx.vid,
  ent.name as entity_name,
  ent.access_key as entity_key
SQL
   , true );

    $criteria->from('wbfsys_data_index idx');

    $criteria->join(<<<SQL
	JOIN wbfsys_entity ent on ent.rowid = idx.id_vid_entity
SQL
    );

    $criteria->where(<<<SQL
(to_tsvector('english', idx.title) @@ to_tsquery( 'english', '{$searchValue}')
   OR UPPER(idx.title) like UPPER( '{$searchValue}%' ))
SQL
    );

    if ( $type ){
      $criteria->join(<<<SQL
	JOIN wbfsys_entity_alias al on al.id_entity = idx.id_vid_entity
SQL
      );

      $criteria->where(<<<SQL
	UPPER(al.name) like UPPER( '{$type}%' )
SQL
      );
    }

    $criteria->orderBy( 'title asc' );
    $criteria->limit(50);


    return $orm->select($criteria);
    
    
  }//end public function search */

}//end class WebfrapDataConnector_Model */

