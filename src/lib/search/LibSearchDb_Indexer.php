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
 * @subpackage tech_core
 */
class LibSearchDb_Indexer
{

  /**
   * @var LibDbOrm
   */
  protected $orm = null;

  /**
   * @param  LibDbOrm $orm
   */
  public function __construct( $orm )
  {
    $this->orm = $orm;
  }//end public function __construct */

  /**
   * de:
   * methode zum erstellen neuer einträge in der datenbank
   *
   * @param Entity $entity
   * @return Entity
   */
  public function saveDsIndex( $entity, $create = false )
  {

    $keyVal     = $entity->getData();
    $entityKey  = $entity->getEntityName();

    $resourceId = $this->orm->getResourceId( $entityKey );
    $id         = $entity->getId();

    $indexData  = array();

    try {

      // name
      $nameFields = $entity->getIndexNameFields();
      if ($nameFields) {
        if ( count($nameFields) > 1 ) {
          $nameTmp = array();
          foreach ($nameFields as $field) {
            $nameTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $indexData['name'] = implode( ', ', $nameTmp );
        } else {
          $indexData['name'] = isset($keyVal[$nameFields[0]])?$keyVal[$nameFields[0]]:'';
        }
      }

      // title
      $titleFields = $entity->getIndexTitleFields();
      if ($titleFields) {
        if ( count($titleFields) > 1 ) {
          $titleTmp = array();
          foreach ($titleFields as $field) {
            $titleTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $indexData['title'] = implode( ', ', $titleTmp );
        } else {
          $indexData['title'] = isset($keyVal[$titleFields[0]])?$keyVal[$titleFields[0]]:'';
        }
      }

      // key
      $keyFields = $entity->getIndexKeyFields();
      if ($keyFields) {
        if ( count($keyFields) > 1 ) {
          $keyTmp = array();
          foreach ($keyFields as $field) {
            $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $indexData['access_key'] = implode( ', ', $keyTmp );
        } else {
          $indexData['access_key'] = isset($keyVal[$keyFields[0]])?$keyVal[$keyFields[0]]:'';
        }
      }

      // description
      $descriptionFields = $entity->getIndexDescriptionFields();
      if ($descriptionFields) {
        if ( count($descriptionFields) > 1 ) {
          $keyTmp = array();
          foreach ($descriptionFields as $field) {
            $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $description = implode( ', ', $keyTmp );
          $indexData['description'] = mb_substr
          (
            strip_tags( $description ),
            0,
            250,
            'utf-8'
          );
        } else {
          $indexData['description'] = mb_substr
          (
            strip_tags( (isset($keyVal[$descriptionFields[0]])?$keyVal[$descriptionFields[0]]:'') ),
            0,
            250,
            'utf-8'
          );
        }
      }

      $indexData['vid']           = $id;
      $indexData['id_vid_entity'] = $resourceId;

      if ($create) {

        $indexData[Db::UUID]         = $keyVal[Db::UUID];
        $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];

        $sqlstring = $this->orm->sqlBuilder->buildInsert( $indexData, 'wbfsys_data_index' );
        $this->orm->db->create( $sqlstring, 'wbfsys_data_index', 'rowid' );

      } else {

        $where = "vid={$id} and id_vid_entity={$resourceId}";
        $sqlstring = $this->orm->sqlBuilder->buildUpdateSql( $indexData, 'wbfsys_data_index', $where );
        $this->orm->db->update( $sqlstring );

      }

    } catch ( LibDb_Exception $exc ) {
      return null;
    }

  }//end public function saveDsIndex */

  /**
   * Löschen des Index nachdem ein Datensatz gelöscht wurde
   * @param Entity $entity
   */
  public function removeIndex( $entity )
  {

    $keyVal     = $entity->getData();
    $entityKey  = $entity->getEntityName();
    $resourceId = $this->orm->getResourceId($entityKey);
    $id         = $entity->getId();

    $this->orm->db->delete( 'DELETE FROM wbfsys_data_index where vid = '.$id.' and id_vid_entity = '.$resourceId );

  }//end public function removeIndex */

  /**
   * Löschen des Index nachdem ein Datensatz gelöscht wurde
   */
  public function removeEntityIndex( $entityKey )
  {

    $resourceId = $this->orm->getResourceId($entityKey);

    $this->orm->db->delete( 'DELETE FROM wbfsys_data_index where id_vid_entity = '.$resourceId );

  }//end public function removeEntityIndex */

  /**
   * Löschen des Index nachdem ein Datensatz gelöscht wurde
   */
  public function removeFullIndex(  )
  {

    $this->orm->db->delete( 'DELETE FROM wbfsys_data_index');

  }//end public function removeFullIndex */

  /**
   * Löschen des Indexes für eine Tabelle
   * @param string $entityKey
   */
  public function rebuildEntityIndex( $entityKey )
  {

    $this->removeEntityIndex( $entityKey );

    $resourceId = $this->orm->getResourceId( $entityKey );

    $indexData  = array();

    $entity     = $this->orm->newEntity( $entityKey );
    $tableName  = $entity->getTable();

    $nameFields   = $entity->getIndexNameFields();
    $titleFields  = $entity->getIndexTitleFields();
    $keyFields    = $entity->getIndexKeyFields();
    $descriptionFields = $entity->getIndexDescriptionFields();

    $fields = array_merge
    (
      array( 'rowid', Db::UUID, Db::TIME_CREATED ),
      $nameFields,
      $titleFields,
      $keyFields,
      $descriptionFields
    );

    try {

      $rows = $this->orm->db->select('SELECT '.implode(',', $fields).' FROM '.$tableName );

      foreach ($rows as $keyVal) {

        $indexData = array();

        // name
        if ($nameFields) {
          if ( count($nameFields) > 1 ) {
            $nameTmp = array();
            foreach ($nameFields as $field) {
              $nameTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $indexData['name'] = implode( ', ', $nameTmp );
          } else {
            $indexData['name'] = isset($keyVal[$nameFields[0]])?$keyVal[$nameFields[0]]:'';
          }
        }

        // title
        if ($titleFields) {
          if ( count($titleFields) > 1 ) {
            $titleTmp = array();
            foreach ($titleFields as $field) {
              $titleTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $indexData['title'] = implode( ', ', $titleTmp );
          } else {
            $indexData['title'] = isset($keyVal[$titleFields[0]])?$keyVal[$titleFields[0]]:'';
          }
        }

        // key
        if ($keyFields) {
          if ( count($keyFields) > 1 ) {
            $keyTmp = array();
            foreach ($keyFields as $field) {
              $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $indexData['access_key'] = implode( ', ', $keyTmp );
          } else {
            $indexData['access_key'] = isset($keyVal[$keyFields[0]])?$keyVal[$keyFields[0]]:'';
          }
        }

        // description
        if ($descriptionFields) {
          if ( count($descriptionFields) > 1 ) {
            $keyTmp = array();
            foreach ($descriptionFields as $field) {
              $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $description = implode( ', ', $keyTmp );
            $indexData['description'] = mb_substr
            (
              strip_tags( $description ),
              0,
              250,
              'utf-8'
            );
          } else {
            $indexData['description'] = mb_substr
            (
              strip_tags( (isset($keyVal[$descriptionFields[0]])?$keyVal[$descriptionFields[0]]:'') ),
              0,
              250,
              'utf-8'
            );
          }
        }

        $indexData['vid']            = $keyVal['rowid'];
        $indexData['id_vid_entity']  = $resourceId;

        $indexData[Db::UUID]         = $keyVal[Db::UUID];
        $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];

        $sqlstring = $this->orm->sqlBuilder->buildInsert( $indexData, 'wbfsys_data_index' );

        $this->orm->db->create( $sqlstring );

      }

    } catch ( LibDb_Exception $exc ) {
      return null;
    }

  }//end public function removeEntityIndex */

}//end class LibSearchDb_Indexer
