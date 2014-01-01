<?php
/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @author      : Malte Schirmacher <malte.schirmacher@webfrap.net>
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
class LibSearchDb_EntityIndex
{
    /**
     * @var LibDbOrm
     */
    private $orm = null;

    /**
     * @param  LibDbOrm $orm
     */
    public function __construct(LibDbOrm $orm, $searchBackend = null)
    {
        $this->orm = $orm;
    }

    /**
     * Updates the search index for the given entity
     *
     * @param Entity $entity
     * @param bool $create
     * @return null
     */
    public function updateSearchIndexForEntity(Entity $entity, $create = false)
    {
        $keyVal    = $entity->getData();
        $entityKey = $entity->getEntityName();

        $resourceId = $this->orm->getResourceId($entityKey);

        if (!$resourceId) {
            Debug::console("Control Structure out of sync");
            Log::warn("Control Structure out of sync");

            return;
        }

        $id = $entity->getId();

        $indexData = array();

        try {
            $titleFields       = $entity->getIndexTitleFields();
            $keyFields         = $entity->getIndexKeyFields();
            $descriptionFields = $entity->getIndexDescriptionFields();

            $indexData['title']         = $this->concatenateArrayValues($titleFields, $keyVal);
            $indexData['access_key']    = $this->concatenateArrayValues($keyFields, $keyVal);
            $indexData['description']   = $this->retrieveDescriptionData($descriptionFields, $keyVal);
            $indexData['vid']           = $id;
            $indexData['id_vid_entity'] = $resourceId;

            if ($create) {

                if (isset($keyVal[Db::UUID])) {
                    $indexData[Db::UUID] = $keyVal[Db::UUID];
                }

                if (isset($keyVal[Db::TIME_CREATED])) {
                    $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];
                }

                $sqlString = $this->orm->sqlBuilder->buildInsert($indexData, 'wbfsys_data_index');

                $this->orm->db->insert($sqlString, 'wbfsys_data_index', 'rowid');
            } else {

                $where = "vid={$id} and id_vid_entity={$resourceId}";

                $sqlString = $this->orm->sqlBuilder->buildUpdateSql($indexData, 'wbfsys_data_index', $where);
                $res       = $this->orm->db->update($sqlString);

                /* @var $res LibDbPostgresqlResult */
                if (!$res->getAffectedRows()) {
                    if (isset($keyVal[Db::UUID])) {
                        $indexData[Db::UUID] = $keyVal[Db::UUID];
                    }

                    if (isset($keyVal[Db::TIME_CREATED])) {
                        $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];
                    }

                    $sqlString = $this->orm->sqlBuilder->buildInsert($indexData, 'wbfsys_data_index');

                    $this->orm->db->insert($sqlString, 'wbfsys_data_index', 'rowid');
                }
            }
        } catch (LibDb_Exception $exc) {
            return null;
        }
    }

    /**
     * Removes the given Entity from the search index
     *
     * @param Entity $entity
     */
    public function removeSingleEntityFromSearchIndex(Entity $entity)
    {
        $entityKey  = $entity->getEntityName();
        $resourceId = $this->orm->getResourceId($entityKey);
        $id         = $entity->getId();

        $this->orm->db->delete(
            'DELETE FROM wbfsys_data_index where vid = ' . $id . ' and id_vid_entity = ' . $resourceId
        );
    }

    /**
     * Removes all Entities of the given type from the search index
     * @param $entityKey
     */
    private function removeEntityTypeFromSearchIndex($entityKey)
    {
        $resourceId = $this->orm->getResourceId($entityKey);

        $this->orm->db->delete('DELETE FROM wbfsys_data_index where id_vid_entity = ' . $resourceId);
    }

    /**
     * Regenerates the whole search index for the given entity type
     *
     * @param string $entityKey
     */
    public function rebuildSearchIndex($entityKey)
    {
        $this->removeEntityTypeFromSearchIndex($entityKey);

        $resourceId = $this->orm->getResourceId($entityKey);

        $entity    = $this->orm->newEntity($entityKey);
        $tableName = $entity->getTable();

        $titleFields       = $entity->getIndexTitleFields();
        $keyFields         = $entity->getIndexKeyFields();
        $descriptionFields = $entity->getIndexDescriptionFields();

        $fields = array_merge(
            array('rowid', Db::UUID, Db::TIME_CREATED),
            $titleFields,
            $keyFields,
            $descriptionFields
        );

        try {
            $rows = $this->orm->db->select('SELECT ' . implode(',', $fields) . ' FROM ' . $tableName);

            foreach ($rows as $keyVal) {

                $indexData = array();

                $indexData['title']          = $this->concatenateArrayValues($titleFields, $keyVal);
                $indexData['access_key']     = $this->concatenateArrayValues($keyFields, $keyVal);
                $indexData['description']    = $this->retrieveDescriptionData($descriptionFields, $keyVal);
                $indexData['vid']            = $keyVal['rowid'];
                $indexData['id_vid_entity']  = $resourceId;
                $indexData[Db::UUID]         = $keyVal[Db::UUID];
                $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];

                $sqlstring = $this->orm->sqlBuilder->buildInsert($indexData, 'wbfsys_data_index');

                $this->orm->db->create($sqlstring);
            }
        } catch (LibDb_Exception $exc) {
            return null;
        }
    }

    /**
     * @param $descriptionFields
     * @param $keyVal
     * @return string
     */
    private function retrieveDescriptionData($descriptionFields, $keyVal)
    {
        $indexData = implode(
            ', ',
            $this->concatenateArrayValues($descriptionFields, $keyVal)
        );

        return mb_substr
        (
            strip_tags($indexData),
            0,
            250,
            'utf-8'
        );
    }

    private function concatenateArrayValues(array $keys, array $data)
    {
        return array_filter(
            array_map(
                function ($field) use ($data) {
                    if (isset($keyVal[$field])) {
                        return $keyVal[$field];
                    } else {
                        return false;
                    }
                },
                $keys
            )
        );
    }
}

