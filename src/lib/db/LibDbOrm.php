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
class LibDbOrm
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Type der Datenbankverbindung des ORMs
   *
   * @var string
   */
  protected $dbType         = null;

  /**
   * Name der aktiven Datenbank Session in der Conf
   * @var string
   */
  protected $databaseName   = false;

  /**
   * name oft the active database schema
   * @var string
   */
  protected $schema         = false;

  /**
   * the metadata for the entities
   * @var array
   */
  protected $entityMeta     = array();

  /**
   * the object pool for all loaded entities from the database
   *
   * @var array<int:Entity>
   */
  protected $objPool        = array();

  /**
   * an index for the search fields
   *
   * @var array<string:array<entity>>
   */
  protected $searchIndex    = array();

  /**
   * Flag ob der ResourceIndex gespeichert werden soll
   * @var boolean
   */
  protected $saveResourceIndex    = false;

  /**
   * an index for the search fields
   *
   * @var array<string:int>
   */
  protected $resourceIds    = array();

  /**
   *
   * @var array<string>
   */
  protected $tabNameCache   = array();

  /**
   *
   * @var array<string>
   */
  protected $tabColsCache   = array();

  /**
   * the sqlBuilder object
   *
   * @var LibParserSqlAbstract
   */
  public $sqlBuilder         = null;

  /**
   * @var check for non numeric search keys in the cache
   */
  public $useConditionCache = true;

  /**
   * the database connection object
   *
   * @var LibDbConnection
   */
  public $db   = null;

  /**
   * the database connection object
   *
   * @var LibDbConnection
   */
  public $user   = null;

  /**
   * Das Resultset der letzen Query
   * Vorsicht wird bei jeder neuen query überschieben
   *
   * @debug (Debug information)
   * @var LibDbResult
   */
  public $lastResult   = null;

  /**
   * @var array
   */
  public $langIds = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Constructor for the WebFrap ORM Class
   *
   * @param LibDbConnection $db
   * @param string $dbType
   * @param string $dbName
   * @param string $dbSchema
   */
  public function __construct($db, $dbType, $dbName = null, $dbSchema = null)
  {

    $this->db     = $db;
    $this->dbType = $dbType;

    $this->dbName = $dbName;
    $this->schema = $dbSchema;

    $className = 'LibParserSql'.ucfirst($dbType);
    $this->sqlBuilder = new $className('orm_'.$dbType, $db);

  }//end public function __construct */

  /**
   * Destructor
   */
  public function __destruct()
  {
    $this->db = null;
    $this->sqlBuilder = null;
  }//end public function __destruct */

  /**
   * @return string
   */
  public function __toString()
  {
    return 'ORM instance of: '.get_class($this).' db: '.(string) $this->db;
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * create a new criteria object
   *
   * @param string $name name of the Criteria Query
   * @return LibSqlCriteria
   */
  public function newCriteria($name = null)
  {

    if (is_null($name))
      $name = 'tmp';

    return new LibSqlCriteria($name, $this->db);

  }//end public function newCriteria */

  /**
   * create a new entity
   *
   * @param string $type type of the entity
   * @return Entity
   */
  public function newEntity($type)
  {

    $className = ''.$type.'_Entity';

    if (!Webfrap::classLoadable($className))
      throw new LibDb_Exception('Requested notexisting Entity '.$type);

    return new $className(null, array(), $this);

  }//end public function newEntity */

  /**
   * Erstellen eines neuen Evelops für eine bestimmte Entity
   *
   * Envelops werden für das automatische synchronisieren von Daten zwischen
   * verschiendenen Datenquellen verwendet.
   *
   * Eine Entity wird dazu in eine Umschlag gepackt der das Mapping mit der
   * Struktur der entfernten Datenquelle übernimmt
   *
   * @param string $repoName
   * @param string $type
   * @param string $refId
   * @return Entity
   */
  public function newEnvelop($repoName, $type, $refId = null  )
  {

    $envelopName = 'LibEnvelopEntity';

    $className = $type.'_Entity';

    if (!Webfrap::classLoadable($className))
      throw new LibDb_Exception('Requested notexisting Entity '.$type);

    $entity     = new $className(null, array(), $this  );

    $repository = $this->getRepository($repoName);

    $envelop    = new $envelopName($repository, $entity, $refId);

    return $envelop;

  }//end public function newEnvelop */

  /**
   * request the activ sql sqlBuilder
   * @return LibParserSqlAbstract
   */
  public function getParser()
  {
    return $this->sqlBuilder;
  }//end public function getParser */

  /**
   * request the activ sql sqlBuilder
   * @return LibParserSqlAbstract
   */
  public function getQueryBuilder()
  {
    return $this->sqlBuilder;
  }//end public function getQueryBuilder */

  /**
   * @param User $user
   */
  public function setUser( $user )
  {
    $this->user = $user;
  }//end public function setUser */

  /**
   * @return User
   */
  public function getUser()
  {

    if (!$this->user)
      $this->user = Webfrap::$env->getUser();

    return $this->user;

  }//end public function getUser */

/*//////////////////////////////////////////////////////////////////////////////
// Pool Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add an entity object too to entity pool
   *
   * @param string $source Sourcetype of the entity
   * @param int $id
   * @param Entity $entity
   * @return void
   */
  public function addToPool($source,  $id , $entity)
  {

    if (!$id) {
      return;
    }

    if (!isset($this->objPool[$source.'_Entity'])) {
      $this->objPool[$source.'_Entity'] = array();
    }

    if (!isset($this->objPool[$source.'_Entity'][(int)$id])) {
      $this->objPool[$source.'_Entity'][$id] = $entity;
    }

  }//end public function addToPool */

  /**
   * request an entity object from the pool
   * @param string $source
   * @param int $id
   * @return Entity
   */
  public function getFromPool($source , $id)
  {

    if (isset($this->objPool[$source.'_Entity'][$id])) {
      return $this->objPool[$source.'_Entity'][$id];
    }

    return null;

  }//end public function getFromPool */

  /**
   * remove an entity object from the entity pool
   * @param string $source
   * @param int $id
   * @return void
   */
  public function removeFromPool($source, $id)
  {

    if (isset($this->objPool[$source.'_Entity'][$id])) {
      unset($this->objPool[$source.'_Entity'][$id]);
    }

  }//end public function removeFromPool */

  /**
   *
   */
  public function clearCache()
  {

    foreach ($this->objPool as $subPool) {
      foreach ($subPool as $entry) {
        $entry->unload();
      }
    }

    $this->objPool     = array();
    $this->searchIndex = array();

  }//end public function clearCache */

/*//////////////////////////////////////////////////////////////////////////////
// Searchindex Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add an entity object too to entity pool
   *
   * @param string $source Sourcetype of the entity
   * @param int $id
   * @param Entity $entity
   * @return void
   */
  public function addSearchIndex($source, $searchString, $results)
  {

    if (!$searchString)
      return;

    if (!isset($this->searchIndex[$source]))
      $this->searchIndex[$source] = array();

    $this->searchIndex[$source][$searchString] = $results;

  }//end public function addSearchIndex */

  /**
   * Prüfen ob für den Suchstring ein Objekt hinterlegt wurde
   *
   * @param string $source
   * @param string $searchString
   * @return Entity
   */
  public function getSearchIndex($source, $searchString)
  {

    //check if cache is enabled
    if (!$this->useConditionCache)
      return null;

    if (isset($this->searchIndex[$source][$searchString]))
      return $this->searchIndex[$source][$searchString];
    else
      return null;

  }//end public function getSearchIndex */

  /**
   * remove an entity object from the entity pool
   * @param string $source
   * @param int $id
   * @return void
   */
  public function removeSearchIndex($source, $searchString)
  {

    if (isset($this->searchIndex[$source][$searchString]))
      unset($this->searchIndex[$source][$searchString]);

  }//end public function removeSearchIndex */

/*//////////////////////////////////////////////////////////////////////////////
// Access the entity metadata
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $tableName
   * @param array $values
   */
  public function convertTableData($tableName , $values)
  {

    return $this->convertData($tableName, $values);

  }//end public function convertTableData */

  /**
   * Daten zum einfügen in eine Tabelle konvertieren
   *
   * @param string $entityKey
   * @param array $values
   * @param boolean $dropEmptyWhitespace
   * @return array
   */
  public function convertData($entityKey, $values, $dropEmptyWhitespace = true)
  {

    $entityKey = SParserString::subToCamelCase($entityKey);

    if (!isset($this->entityMeta[$entityKey])) {
      if (!$this->loadMetaData($entityKey)) {
        throw new LibDb_Exception(
          'Failed to load the Metadata for Entity: '.$entityKey
        );
      }
    }

    $map = $this->entityMeta[$entityKey]->getValidationData();
    $tmp = array();

    foreach ($values as $key => $value) {
      if (isset($map[$key])) {

        if ($map[$key][Entity::COL_MULTI]) {
          if (!$map[$key][Entity::COL_QUOTE]) {

            if ($value === null || $value === array()) {
              $value = Db::NULL;
            } elseif (is_array($value)) {
              $value = $this->db->dbArrayToString($value);
            } else {
              $array = $this->db->dbStringToArray($value);

              if ($array === array())
                $value = Db::NULL;
              else
                $value = $this->db->dbArrayToString($array);
            }
          } else {
            if (is_array($value)) {

              if ($value == array())
                $value = Db::EMPTY_ARRAY;
              else
                $value = $this->db->dbArrayToString($value);
            } else {

              $array = $this->db->dbStringToArray($value);

              if ($array == array())
                $value = Db::EMPTY_ARRAY;
              else
                $value = $this->db->dbArrayToString($array);
            }
          }
        }

        if ($map[$key][Entity::COL_QUOTE]) {
          if (trim($value) == '' && $dropEmptyWhitespace) {
            $tmp[$key] = Db::NULL;
          } else {
            $tmp[$key] = "'".$this->db->escape($value)."'";
          }
        } else {
          if (trim($value) == '' && $dropEmptyWhitespace) {
            $tmp[$key] = Db::NULL;
          } else {
            $tmp[$key] = $value; // here we need no slashes
          }
        }

      } else {
        throw new LibDb_Exception
        (
          "Tried to request noexisting attribute: {$key} for entity: {$entityKey}"
        );
      }
    }

    return $tmp;

  } // end public function convertData */

  /**
   * @param string $value
   * @return string
   */
  public function escape($value)
  {
    return $this->db->escape($value);
  }//end public function escape */

  /**
   * Metadaten für eine bestimmte Entity laden
   * Die Daten werden über ein leeres Objekt des Entity types ausgelesen
   *
   * @param string $entityKey
   * @return boolean
   */
  protected function loadMetadata($entityKey)
  {

    $className    = $entityKey.'_Entity';

    if (!isset($this->entityMeta[$entityKey])) {

      if (WebFrap::classLoadable($className)) {
        $this->entityMeta[$entityKey] = new $className(null, array(), $this);

        return true;
      } else {
        return false;
      }
    }

    return true;

  }//end protected function loadMetadata */

  /**
   *
   * @param string $entityName
   * @return Entity
   */
  public function getMetadata($entityKey)
  {

    if (!isset($this->entityMeta[$entityKey])) {
      if (!$this->loadMetadata($entityKey)) {
        throw new LibDb_Exception($entityKey.' not exists');
      }
    }

    return $this->entityMeta[$entityKey];

  }//end public function getMetadata */

  /**
   *
   * Get the table name of an entity
   *
   * @param string $entityName
   * @return string
   */
  public function getTableName($entityKey)
  {

    $object = null;

    if (is_object($entityKey)) {
      $object     = $entityKey;
      $entityKey  = $object->getEntityName();
    }

    if (isset($this->tabNameCache[$entityKey])) {
      return $this->tabNameCache[$entityKey];
    } else {

      if (is_null($object)) {
        $className    = $entityKey.'_Entity';

        if (Webfrap::classLoadable($className)) {
          $object = new $className(null, array(), $this) ;
        } else {
          throw new LibDb_Exception('requested table for a nonexisting entity '.$entityKey);
          //$this->tabNameCache[$entityName] = SParserString::camelCaseToSub($entityName);
        }
      }

      /*
      if (!Webfrap::classLoadable($classname))
        $classname = 'Entity'.$entityKey;
      */
      $this->tabNameCache[$entityKey] = $object->getTable();
      $this->tabColsCache[$entityKey] = $object->getQueryCols();

    }

    return $this->tabNameCache[$entityKey];

  }//end public function getTableName */

  /**
   *
   * Get the table name of an entity
   *
   * @param string $entityKey
   * @return string
   */
  public function getTableCols($entityKey)
  {

    if (isset($this->tabColsCache[$entityKey])) {
      return $this->tabColsCache[$entityKey];
    } else {
      $classname    = $entityKey.'_Entity';

      /*
      if (!Webfrap::classLoadable($classname))
        $classname = 'Entity'.$entityKey;
      */

      if (!Webfrap::classLoadable($classname)) {
        throw new LibDb_Exception('requested cols for a nonexisting entity '.$classname);
      } else {
        // cache both
        $tmp = new $classname();
        $this->tabNameCache[$entityKey] = $tmp->getTable();
        $this->tabColsCache[$entityKey] = $tmp->getQueryCols();
      }

    }

    return $this->tabColsCache[$entityKey];

  }//end public function getTableCols */

  /**
   * request the validation data from the dao
   * @param string $entityKey
   * @param array<string> $keys
   * @param boolean $insert
   * @return array<array>
   */
  public function getValidationData($entityKey, $keys, $insert = false)
  {
    $entity = $this->getMetadata($entityKey);

    return $entity->getValidationdata($keys, $insert);

  }//end public static function getValidationData */

  /**
   * @param string $entityKey
   * @param array $keys
   */
  public function getErrorMessages($entityKey, $keys = array())
  {

    $entity = $this->getMetadata($entityKey);

    return $entity->getErrorMessages($keys);

  }//end public function getErrorMessages */

  /**
   * get all cols from an entity
   * @param string $entityKey
   * @param array $categories
   * @return array
   */
  public function getCols($entityKey, $categories = null)
  {

    $entity = $this->getMetadata($entityKey);

    return $entity->getCols($categories);

  }//end public function getCols */

  /**
   *
   * @param string $entityKey
   * @param array $categories
   */
  public function getSearchCols($entityKey , $categories = null)
  {

    $entity = $this->getMetadata($entityKey);

    return $entity->getSearchCols($categories);

  }//end public function getSearchCols */

/*//////////////////////////////////////////////////////////////////////////////
// resource
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $entityKey
   */
  public function getResourceId($entityKey)
  {

    if (!$this->resourceIds)
      $this->loadResourceIdCache();

    if (is_object($entityKey))
      $entityKey = $entityKey->getEntityName();
    elseif (is_array($entityKey))
      $entityKey = $entityKey[0];

    if (isset($this->resourceIds[$entityKey]))
      return $this->resourceIds[$entityKey];

    $this->saveResourceIndex = true;

    if ($resourceId = $this->loadResourceId($entityKey)) {
      $this->resourceIds[$entityKey] = $resourceId;

      return $resourceId;
    } else {
      $resourceId = $this->createResourceId($entityKey);
      $this->resourceIds[$entityKey] = $resourceId;

      return $resourceId;

    }

  }//end public function getResourceId */

  /**
   * @param string $entityKey
   */
  protected function createResourceId($entityKey)
  {

    $meta = $this->getMetadata($entityKey);

    $entity = new WbfsysEntity_Entity(null, array(), $this);
    $entity->name         = $entityKey;
    $entity->description  = $meta->description();
    $entity->access_key   = $meta->getTable();

    $this->insert($entity);

    return $entity->getId();

  }//end public function createResourceId */

  /**
   * @param string $entityKey
   * @return int
   */
  protected function loadResourceId($entityKey)
  {

    $tabKey = $this->getTableName($entityKey);

    $sql = "select rowid from wbfsys_entity where upper(access_key) = upper('".$tabKey."')";

    if (!$result = $this->db->select($sql)->get())
      return null;

    return $result['rowid'];

  }//end public function loadResourceId */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * an orm query
   * makes no real scence to return the results als Entity Objects cause
   * it's not clear if all data is loaded
   * @param LibSqlCriteria $criteria
   * @return LibDbResult
   *
   * @idea: check if its possible to check what type of attribute belongs
   * to wich entity
   *
   */
  public function select($criteria  )
  {

    try {

      if (!$this->db)
        throw new LibDb_Exception('DB object is missing!');

      $result = $this->db->select($this->sqlBuilder->buildSelect($criteria));
      $this->lastResult = $result;

      return $result;

    } catch (LibDb_Exception $e) {
      Debug::console('Failed Criteria : '.$criteria->sql, $criteria);

      return null;
    }

  }//end public function select */

  /**
   * get all dataset from a table
   *
   * @param string $entityName name of the entity
   * @param array $cols the co
   * @param int $limit
   * @return array<Entity>
   */
  public function getAll($entityName, $cols = array(), $limit = null, $offset = null)
  {

    $tableName  = $this->getTableName($entityName);
    $cols       = $this->getTableCols($entityName);

    $criteria   = $this->newCriteria();
    $criteria->select($cols)
      ->from($tableName)
      ->orderBy('rowid')
      ->limit($limit)
      ->offset($offset);

    return $this->fillObjects($entityName.'_Entity', $this->select($criteria)->getAll());

  }//end public function getAll */

  /**
   * get a row by id
   * @param string $entityKey
   * @param int $id
   * @return Entity
   */
  public function get($entityKey, $id  )
  {

    if (!$id)
      return null;

    // check if the entity is allready loaded and in the pool
    if (ctype_digit($id) && $obj = $this->getFromPool($entityKey, $id)) {
      return $obj;
    } elseif (is_object($id)) {
      $id = $id->getId();
    } elseif ($this->useConditionCache &&  $obj = $this->getSearchIndex($entityKey, $id)) {// check if the entity is already in the search index

      return $obj[0];
    }


    $tableName  = $this->getTableName($entityKey);
    $cols       = $this->getTableCols($entityKey);

    $criteria = $this->newCriteria();
    $criteria->select($cols)->from($tableName);

    if (is_numeric($id))
      $criteria->where(' rowid = '.$id);
    else
      $criteria->where($id);

    if (!$result = $this->select($criteria)) {
      throw new LibDb_Exception('Query '.$criteria.' failed');
    }

    $this->lastResult = $result;

    $data = $result->get();

    if (!$data) {
      return null;
    } else {
      $entity =  $this->fillObject($entityKey, $data);

      if ($this->useConditionCache && ctype_digit($id))
        $this->addSearchIndex($entityKey, $id, array($entity));

      return $entity;
    }

  }//end public function get */

 /**
   * Eine Entity anhand des AcessKeys erfragen
   *
   * @param string $entityKey
   * @param int $id
   * @return Entity
   *
   * @throws LibDb_Exception wenn die Entity kein Access Key Attribut besitzt
   *
   */
  public function getByKey($entityKey, $id  )
  {
    return $this->get($entityKey, "upper(access_key) = upper('{$id}')");

  }//end public function getByKey */

 /**
   * Eine Entity anhand des AcessKeys erfragen
   *
   * @param string $entityKey
   * @param int $id
   * @param string|int $lang
   * @return Entity
   *
   * @throws LibDb_Exception wenn die Entity kein Access Key Attribut besitzt
   *
   */
  public function getI18nByKey($entityKey, $id, $lang  )
  {

    $langKey = $lang;
    if (!ctype_digit($lang)) {

      if (isset($this->langIds[$langKey])) {
        $lang = $this->langIds[$langKey];
      } else {
        $lang = $this->getIdByKey('WbfsysLanguage' , $lang);

        if ($lang)
          $this->langIds[$langKey] = $lang;
      }
    }

    if (!$lang) {
      Log::warn('Requested I18n Entity for nonexisting Language '.$langKey);

      return null;
    }

    return $this->get($entityKey, "upper(access_key) = upper('{$id}') and id_lang=".$lang);

  }//end public function getI18nByKey */

 /**
   * Eine Entity anhand des AcessKeys erfragen
   *
   * @param string $entityKey
   * @param array<string> $ids
   * @return array<Entity>
   *
   * @throws LibDb_Exception wenn die Entity kein Access Key Attribut besitzt
   *
   */
  public function getByKeys($entityKey, $ids)
  {

    $where = "UPPER('".implode("'), UPPER('", $ids)."')";

    return $this->getListWhere($entityKey, "upper(access_key) IN({$where})");

  }//end public function getByKeys */

 /**
   * Eine Entity anhand der UUID erfragen
   *
   * @param string $entityKey
   * @param string $id
   * @return Entity
   */
  public function getByUuid($entityKey, $uuid  )
  {
    return $this->get($entityKey, "m_uuid='{$uuid}'");

  }//end public function getByUuid */

 /**
   * Eine Entity anhand der UUID erfragen
   *
   * @param string $entityKey
   * @param string $id
   * @return Entity
   */
  public function getByIds($entityKey, $ids  )
  {

    // keine ids, keine datensätze
    if (!$ids) {
      Log::warn("Called ".__METHOD__.' with empty ids array');

      return array();
    }

    return $this->getListWhere($entityKey, "rowid IN(".implode(',',$ids).")");

  }//end public function getByIds */

  /**
   * Pfadformat: 'id_person:project_task/id_project:project_project',
   * @param string $path
   * @param Entity $sourceEntity
   */
  public function getByPath($path, $sourceEntity)
  {

    $criteria  = $this->newCriteria();
    $paths     = array_reverse(explode('/', $path)) ;

    // ok kleiner phantastic hack
    $actual = explode(':', array_shift($paths));

    $table      = $actual[1];
    $entityKey   = SParserString::subToCamelCase($actual[1]);

    $cols = $this->getTableCols($entityKey);

    $tabCols = array();
    foreach ($cols as $col) {
      $tabCols[] = $actual[1].'.'.$col;
    }

    $criteria->select($tabCols);
    $criteria->from($actual[1]);

    foreach ($paths as $pos => $loadPath) {

      $tmp = explode(':', $loadPath);

      if (isset($tmp[2])) {
        $refId = $tmp[2];
      } else {
        $refId = 'rowid';
      }

      $joinSql = <<<SQL

  JOIN {$tmp[1]}
    ON {$tmp[1]}.{$actual[0]} = {$actual[1]}.rowid

SQL;

      $criteria->join($joinSql);

      $actual = $tmp;

    }
    /*
    $srcTable = $sourceEntity->getTable();

    $joinLast = <<<SQL

  JOIN {$srcTable}
    ON {$srcTable}.{$actual[0]} = {$actual[1]}.rowid

SQL;

    $criteria->join($joinLast);
    */

    $criteria->where(" {$actual[1]}.rowid  = ".$sourceEntity->getData($actual[0]));
    //$criteria->where(" {$table}.rowid  = ".$sourceEntity);

    //$refId = $sourceEntity->{$tmp[0]};

    if (!$result = $this->select($criteria  )) {
      throw new LibDb_Exception('Query '.$criteria.' failed');
    }

    $objects = $this->fillObjects($entityKey.'_Entity', $result->getAll());

    return current($objects);

  }//end public function getByPath */

  /**
   * get a row by id
   * @param string $entityKey
   * @param int $id
   * @param boolean $multi
   * @return Entity
   */
  public function execute($entityKey, $queryKey, $condition, $multi = false  )
  {

    $tmp = explode('::' , $queryKey);

    $class    = ''.$tmp[0].'_Query';
    $classOld = 'Query'.$tmp[0];

    $method = 'data'.ucfirst($tmp[1]);

    ///TODO add some error handling!!
    if (!Webfrap::classLoadable($class)) {
      $class = $classOld;
      if (!Webfrap::classLoadable($class)) {
        throw new LibDb_Exception('tried to call non exising query '.$tmp[0]);
      }
    }

    $query  = new $class();
    $data   = $query->$method($condition);

    if (!$data) {
      return null;
    } else {
      if ($multi) {
        $entities = $this->fillObjects($entityKey.'_Entity', $data);

        return $entities;
      } else {
        $entity =  $this->fillObject($entityKey, $data);
        $this->addSearchIndex($entityKey, $entity->getId(), array($entity));

        return $entity;
      }

    }

  }//end public function execute */

  /**
   * de:
   * methode zum prüfen ob irgendwelche duplicate für den aktuellen eintrag
   * vorhanden sind
   *
   * @polymorph
   * @param string/Entity $entity
   * @param int $uniqeFields
   * @return
   * {
   *   CASE: $returnObjects = false
   *    boolean false wenn duplikate vorhanden sind
   *
   *   CASE: $returnObjects = true
   *    array: Array mit allen Entities aller gefundenen doppelter einträge
   * }
   */
  public function checkUnique($entity, $uniqeFields, $returnObjects = false)
  {

    if (!is_object($entity) || !$entity instanceof  Entity) {
      throw new LibDb_Exception('Invalid Parameter, first parameter must be an entity object');
    }

    $tableName  = $entity->getTable();
    $entityKey  = $entity->getEntityName();

    $criteria   = $this->newCriteria();
    $criteria->select('rowid')->from($tableName);

    $toConvert = array();
    foreach ($uniqeFields as $field) {
      $toConvert[$field] = $entity->$field;
    }

    $converted = $this->convertData($entityKey, $toConvert);

    $criteria->whereKeyHasValue($converted);

    $data = $this->select($criteria  )->getAll();

    if ($returnObjects) {
      if (!$data) {
        return array();
      } else {
        return $this->fillObject($entityKey, $data);
      }
    } else {
      return empty($data);
    }


  }//end public function checkUnique */

  /**
   * de:
   * Zählen der Einträge mit bestimmten Eigenschaften
   *
   * @param string $entityKey
   * @param string $where
   *
   * @return int Die Anzahl der gefunden Einträge
   */
  public function countRows($entityKey, $where = null  )
  {

    $tableName = $this->getTableName($entityKey);

    $criteria = $this->newCriteria();
    $criteria->select('count('.'rowid'.') as anz')->from($tableName)->where($where);

    $data = $this->select($criteria)->get();

    return $data['anz'];

  }//end public function countRows */

  /**
   * get
   * @param string $entityKey
   * @param string $where
   *
   * @return Entity
   */
  public function getWhere($entityKey, $where  )
  {

    $tableName = $this->getTableName($entityKey);
    $tableCols = $this->getTableCols($entityKey);

    $criteria = $this->newCriteria();
    $criteria->select($tableCols)
      ->from($tableName)
      ->where($where);

    if ($result = $this->select($criteria)) {
      $this->lastResult = $result;
      $data = $this->fillObjects($entityKey.'_Entity', $result->getAll());

      if ($data)
        return current($data);
      else
        return null;
    } else {
      return null;
    }

  }//end public function getWhere */

  /**
   * get
   * @param string $entityKey
   * @param string $where
   * @param array $params
   * @param boolean $groupByKey
   *
   * @return array
   */
  public function getListWhere($entityKey, $where, $params = array(), $groupByKey = true  )
  {

    $tableName = $this->getTableName($entityKey);
    $tableCols = $this->getTableCols($entityKey);

    if (!isset($params['limit']))
      $params['limit'] = null;

    if (!isset($params['offset']))
      $params['offset'] = null;

    if (!isset($params['order']))
      $params['order'] = 'rowid';

    if (is_object($where)) {

      $whereData = $where;

      $criteria = $this->newCriteria();
      $criteria->select($tableCols)
        ->from($tableName)
        ->where($where)
        ->orderBy($params['order'])
        ->limit($params['limit'])
        ->offset($params['offset']);

    } else {
      $criteria = $this->newCriteria();
      $criteria->select($tableCols)
        ->from($tableName)
        ->where($where)
        ->orderBy($params['order'])
        ->limit($params['limit'])
        ->offset($params['offset']);

    }

    if ($result = $this->select($criteria)) {
      $this->lastResult = $result;

      if ($groupByKey) {
        return $this->fillObjects($entityKey.'_Entity', $result->getAll());
      } else {
        $tmp = $this->fillObjects($entityKey.'_Entity', $result->getAll());

        return array_values($tmp);
      }
    } else {
      return array();
    }

  }//end public function getListWhere */

  /**
   * get
   * @param string $entityKey
   * @param string $where
   * @param array $cols
   * @param int $limit
   * @param int $offset
   *
   * @return array<Entity>
   */
  public function getRows($entityKey, $where, $cols = array(), $limit = null, $offset = null  )
  {

    $tableName = $this->getTableName($entityKey);

    if (!$cols)
      $cols = $this->getTableCols($entityKey);

    $criteria = $this->newCriteria();
    $criteria->select($cols)
      ->from($tableName)
      ->where($where)
      ->orderBy('rowid')
      ->limit($limit)
      ->offset($offset);

    return $this->select($criteria)->getAll();

  }//end public function getRows */

  /**
   * @param string $entityKey
   * @param string $where
   * @param array $cols
   *
   * @return array<Entity>
   */
  public function getRow($entityKey, $where, $cols = array())
  {

    $tableName = $this->getTableName($entityKey);

    if (!$cols)
      $cols = $this->getTableCols($entityKey);

    $criteria = $this->newCriteria();
    $criteria->select($cols)
      ->from($tableName)
      ->where($where);

    return $this->select($criteria)->get();

  }//end public function getRow */

  /**
   * @param string $entityKey
   * @param int $id
   * @param string $fieldName
   *
   * @return array
   */
  public function getField($entityKey, $id , $fieldName  )
  {
    if (is_numeric($id) && $obj = $this->getFromPool($entityKey, $id))
      return $obj->getData($fieldName);

    $tableName = $this->getTableName($entityKey);

    $criteria = $this->newCriteria();
    $criteria->select($fieldName)->from($tableName);

    if (is_numeric($id))
      $criteria->where('rowid = '.$id);
    else
      $criteria->where($id);

    if (!$result = $this->select($criteria))
      return null;

    $data = $result->get();

    if (!$data)
      return null;

    else
      return isset($data[$fieldName])?$data[$fieldName]:null;

  }//end public function getField */

  /**
   * @param string $entityKey
   * @param string $where
   *
   * @return array<int>
   */
  public function getIds($entityKey,  $where = null)
  {

    $criteria = $this->newCriteria();

    $criteria->select('rowid')
      ->from($this->getTableName($entityKey))
      ->where($where)
      ->orderBy('rowid');

    return $this->select($criteria)->getColumn('rowid');

  }//end public function getIds */

  /**
   * @param string $entityKey
   * @param array int
   *
   * @return array<int>
   */
  public function getIdsByKeys($entityKey, array $keys)
  {

    if (!$keys)
      return array();

    return $this->getIds
    (
      $entityKey,
      "upper(access_key) IN(upper('"
        .implode
        (
          "'), upper('",
          $keys
        )."'))"
    );

  }//end public function getIdsByKeys */

  /**
   * @param string $entityKey
   * @param array int
   *
   * @return array<int>
   */
  public function getIdByKey($entityKey, $key)
  {
    return $this->getId
    (
      $entityKey,
      "upper(access_key) = upper('{$key}')"
    );

  }//end public function getIdsByKeys */

  /**
   * Die Id für einen bestimmten Datensatz erfragen
   *
   * @param string $entityKey key der entity
   * @param string $where where condition
   * @return int
   */
  public function getId($entityKey, $where)
  {

    $criteria = $this->newCriteria();

    $criteria->select('rowid')
      ->from($this->getTableName($entityKey))
      ->where($where);

    return $this->select($criteria)->getField('rowid');

  }//end public function getId */

  /**
   * Die Id für einen bestimmten Datensatz erfragen
   *
   * @param string $entityKey key der entity
   * @param string $where where condition
   * @return int
   */
  public function getI18nId($entityKey, $where, $lang)
  {

      $langKey = $lang;
    if (!ctype_digit($lang)) {

      if (isset($this->langIds[$langKey])) {
        $lang = $this->langIds[$langKey];
      } else {
        $lang = $this->getIdByKey('WbfsysLanguage' , $lang);

        if ($lang)
          $this->langIds[$langKey] = $lang;
      }
    }

    if (!$lang) {
      Log::warn('Requested I18n Entity for nonexisting Language '.$langKey);

      return null;
    }

    $criteria = $this->newCriteria();

    $criteria->select('rowid')
      ->from($this->getTableName($entityKey))
      ->where($where.' and id_lang = '.$lang);

    return $this->select($criteria)->getField('rowid');

  }//end public function getId */

  /**
   * Nur die ID eines Datensatzes über den Access Key erfragen
   *
   * @param string $entityKey
   * @param string $key
   * @param string $lang
   * @return int
   *
   * @throws LibDb_Exception wenn die Entity kein Access Key Attribut besitzt
   *
   */
  public function getI18nIdByKey($entityKey, $key, $lang  )
  {

    $langKey = $lang;
    if (!ctype_digit($lang)) {

      if (isset($this->langIds[$langKey])) {
        $lang = $this->langIds[$langKey];
      } else {
        $lang = $this->getIdByKey('WbfsysLanguage' , $lang);

        if ($lang)
          $this->langIds[$langKey] = $lang;
      }
    }

    if (!$lang) {
      Log::warn('Requested I18n Entity for nonexisting Language '.$langKey);

      return null;
    }

    return $this->getId($entityKey, "upper(access_key) = upper('{$key}') and id_lang=".$lang);

  }//end public function getI18nIdByKey */

  /**
   * method for insert
   * @param Entity $entity
   * @return boolean
   */
  public function save($entity)
  {

    if (!is_object($entity) || !$entity instanceof Entity) {
      Debug::console('invalid data in save', $entity);
      throw new LibDb_Exception('Got invalid data for save!');
    }

    if ($entity->isNew()) {
      return $this->insert($entity);
    } else {
      return $this->update($entity);
    }

  }//end public function save */

  /**
   * de:
   * methode zum erstellen neuer einträge in der datenbank
   *
   * @param Entity $entity
   * @param array $duplicateKeys die keys die verwendet werden müssen um auf
   *   ein duplikat zu prüfen
   * @return Entity
   * @throws LibDb_Exception
   *  - wenn versucht wird eine entity zu übergeben die synchronisiert ist also bereits existiert
   *  - wenn die Datenbank beim erstellen des eintrags einen fehler wirft
   */
  public function insertIfNotExists($entity, $duplicateKeys = array(), $dropEmptyWhitespace = true  )
  {

    if (!$entity)
      throw new LibDb_Exception('insertIfNotExists entity empty');

    $handleArray = false;

    /*
    if (!is_object($entity)) {
      // $keyVal
      $tableName = $this->getTableName($entity);
      $entityKey = $entity;


      $entity = $this->newEntity($entityKey);
      $entity->setAllData($keyVal);

      $handleArray = true;

    } else
    */

    if ($entity instanceof LibSqlCriteria) {
      $keyVal     = $entity->values;
      $tableName  = $entity->table;
      $entityKey  = SParserString::subToCamelCase($entity->table);

      $entity = $this->newEntity($entityKey);
      $entity->setAllData($keyVal);

      $handleArray = true;
    }

    if ($entity->getSynchronized()) {
      Log::warn('Tried to Insert a synchronized Object');

      return $entity;
    }

    $connected = $entity->getConnected();

    foreach ($connected as $key => $conEnt) {
      if (!$this->save($conEnt))
        return null;

      $entity->$key = $conEnt->getId();
    }

    $keyVal     = $entity->getData();
    $tableName  = $entity->getTable();
    $entityKey  = $entity->getEntityName();


    if ($id = $entity->getInsertId()) {
      $keyVal['rowid'] = $id;
    }

    try {


      $userId     = $this->getUser()->getId();
      $timestamp  = SDate::getTimestamp('Y-m-d H:i:s');

      if ($entity->trackCreation()) {
        $keyVal[Db::ROLE_CREATE]  = $userId;
        $keyVal[Db::TIME_CREATED] = $timestamp;
      }

      if ($entity->trackChanges()) {
        $keyVal[Db::ROLE_CHANGE]  = $userId;
        $keyVal[Db::TIME_CHANGED] = $timestamp;
        $keyVal[Db::VERSION] = Db::START_VALUE;
      }

      if ($entity->isSyncable()) {
        $keyVal[Db::UUID]         = Webfrap::uuid();
      }

      $sqlstring = $this->sqlBuilder->buildInsertIfNotExistsQuery(
        $keyVal,
        $tableName,
        $duplicateKeys,
        $dropEmptyWhitespace
      );

      if (isset($keyVal['rowid'])) {

        $newid = $keyVal['rowid'];

        if (!$this->db->create($sqlstring , $tableName)) {
          return null;
        }
      } else {
        if (!$newid = $this->db->insert($sqlstring , $tableName, 'rowid')) {
          return null;
        }
      }

    } catch (LibDb_Exception $exc) {
      return null;
    }

    $entity->setId($newid);
    $entity->synchronized();

    if ($entity->hasIndex())
      $this->saveDsIndex($entity, true);


    if ($handleArray) {
      $this->addToPool($entityKey, $entity->getId(), $entity);
    }

    foreach ($keyVal as $value) {
      if (is_object($value) && !$value instanceof Entity  ) {
        $value->setEntity($entity);
        $value->save();
      }
    }

    return $entity;

  }//end public function insertIfNotExists */

  /**
   * de:
   * methode zum erstellen neuer einträge in der datenbank
   *
   * @param Entity $entity
   * @param array $keyVal
   * @param boolean $dropEmptyWhitespace
   * @return Entity
   */
  public function insert($entity, $keyVal = array(), $dropEmptyWhitespace = true)
  {

    $handleArray = false;

    if (!is_object($entity)) {

      // $keyVal
      $tableName = $this->getTableName($entity);
      $entityKey = $entity;


      $entity = $this->newEntity($entityKey);
      $entity->setAllData($keyVal);

      $handleArray = true;

    } elseif ($entity instanceof LibSqlCriteria) {

      $keyVal     = $entity->values;
      $tableName  = $entity->table;
      $entityKey  = SParserString::subToCamelCase($entity->table);

      $entity = $this->newEntity($entityKey);
      $entity->setAllData($keyVal);

      $handleArray = true;
    }

    if ($entity->getSynchronized()) {

      Debug::console('Tried to Insert a synchronized Object');
      Log::warn('Tried to Insert a synchronized Object');

      return $entity;
    }

    $connected = $entity->getConnected();

    foreach ($connected as $key => $conEnt) {

      if (!$this->save($conEnt)) {
        Debug::console('Failed to save connected element');

        return null;
      }

      $entity->$key = $conEnt->getId();
    }

    $keyVal     = $entity->getData();
    $tableName  = $entity->getTable();
    $entityKey  = $entity->getEntityName();


    if ($id = $entity->getInsertId()) {
      $keyVal['rowid'] = $id;
    }

    try {


      $userId     = $this->getUser()->getId();
      $timestamp  = SDate::getTimestamp('Y-m-d H:i:s');

      if ($entity->trackCreation()) {
        $keyVal[Db::ROLE_CREATE]  = $userId;
        $keyVal[Db::TIME_CREATED] = $timestamp;
      }

      if ($entity->trackChanges()) {
        $keyVal[Db::ROLE_CHANGE]  = $userId;
        $keyVal[Db::TIME_CHANGED] = $timestamp;
        $keyVal[Db::VERSION] = Db::START_VALUE;
      }

      if ($entity->isSyncable()) {
        $keyVal[Db::UUID]         = Webfrap::uuid();
      }

      $sqlstring = $this->sqlBuilder->buildInsert($keyVal, $tableName, $dropEmptyWhitespace);

      if (isset($keyVal['rowid'])) {

        $newid = $keyVal['rowid'];

        if (!$this->db->create($sqlstring , $tableName)) {
          Error::report('Insert failed, got no id from the DBMS');

          return null;
        }
      } else {
        if (!$newid = $this->db->insert($sqlstring , $tableName, 'rowid')) {
          Error::report('Insert failed, got no id from the DBMS');

          return null;
        }
      }

    } catch (LibDb_Exception $exc) {
      return null;
    }

    $entity->setId($newid);
    $entity->synchronized();

    if ($entity->hasIndex())
      $this->saveDsIndex($entity, true);


    $this->addToPool($entityKey, $entity->getId(), $entity);

    foreach ($keyVal as $value) {
      if (is_object($value) && !$value instanceof Entity  ) {
        $value->setEntity($entity);
        $value->save();
      }
    }

    return $entity;

  }//end public function insert */


  /**
   * Einfach eine Entity kopieren, dabei aber die Metadaten und die Rowid leeren.
   * Alternativ kann noch angegeben werden welche Daten genau kopiert werden sollen
   *
   * @param Entity $entity
   * @param array $copyVals
   * @return Entity
   */
  public function copy($entity, $copyVals = array())
  {


    $keyVal     = $entity->getData();
    $entityKey  = $entity->getEntityName();

    $copyNode   = $this->newEntity($entityKey);

    if ($copyNode->trackCreation()) {
      $keyVal[Db::ROLE_CREATE]  = null;
      $keyVal[Db::TIME_CREATED] = null;
    }

    if ($copyNode->trackChanges()) {
      $keyVal[Db::ROLE_CHANGE]  = null;
      $keyVal[Db::TIME_CHANGED] = null;
      $keyVal[Db::VERSION] = null;
    }

    if ($copyNode->isSyncable()) {
      $keyVal[Db::UUID]         = null;
    }

    if ($copyVals) {

      $newData = array();

      foreach ($copyVals as $copyKey) {
        $newData[$copyKey] = isset($keyVal[$copyKey])?$keyVal[$copyKey]:null;
      }

      $copyNode->setAllData($newData);
    } else {

      $copyNode->setAllData($keyVal);
    }

    return $copyNode;

  }//end public function copy */

  /**
   * de:
   * methode zum erstellen neuer einträge in der datenbank
   *
   * @param Entity $entity
   * @return Entity
   */
  public function saveDsIndex($entity, $create = false)
  {

    $keyVal     = $entity->getData();
    $entityKey  = $entity->getEntityName();

    $resourceId = $this->getResourceId($entityKey);

    if (!$resourceId) {
      Debug::console("Control Structure out of sync");
      Log::warn("Control Structure out of sync");

      return;
    }

    $id         = $entity->getId();

    $indexData  = array();

    try {

      // title
      $titleFields = $entity->getIndexTitleFields();
      if ($titleFields) {
        if (count($titleFields) > 1) {
          $titleTmp = array();
          foreach ($titleFields as $field) {
            $titleTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $indexData['title'] = implode(', ', $titleTmp);
        } else {
          $indexData['title'] = isset($keyVal[$titleFields[0]])?$keyVal[$titleFields[0]]:'';
        }
      }

      // key
      $keyFields = $entity->getIndexKeyFields();
      if ($keyFields) {
        if (count($keyFields) > 1) {
          $keyTmp = array();
          foreach ($keyFields as $field) {
            $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $indexData['access_key'] = implode(', ', $keyTmp);
        } else {
          $indexData['access_key'] = isset($keyVal[$keyFields[0]])?$keyVal[$keyFields[0]]:'';
        }
      }

      // description
      $descriptionFields = $entity->getIndexDescriptionFields();
      if ($descriptionFields) {
        if (count($descriptionFields) > 1) {
          $keyTmp = array();
          foreach ($descriptionFields as $field) {
            $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
          }

          $description = implode(', ', $keyTmp);
          $indexData['description'] = mb_substr
          (
            strip_tags($description),
            0,
            250,
            'utf-8'
          );
        } else {
          $indexData['description'] = mb_substr
          (
            strip_tags((isset($keyVal[$descriptionFields[0]])?$keyVal[$descriptionFields[0]]:'')),
            0,
            250,
            'utf-8'
          );
        }
      }


      $indexData['vid']           = $id;
      $indexData['id_vid_entity'] = $resourceId;

      if ($create) {

        if (isset($keyVal[Db::UUID]))
          $indexData[Db::UUID]         = $keyVal[Db::UUID];

        if (isset($keyVal[Db::TIME_CREATED]))
          $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];

        $sqlstring = $this->sqlBuilder->buildInsert($indexData, 'wbfsys_data_index');

        $this->db->insert($sqlstring, 'wbfsys_data_index', 'rowid');

      } else {

        $where = "vid={$id} and id_vid_entity={$resourceId}";

        $sqlstring = $this->sqlBuilder->buildUpdateSql($indexData, 'wbfsys_data_index', $where);
        $res = $this->db->update($sqlstring);

        /* @var $res LibDbPostgresqlResult  */
        if (!$res->getAffectedRows()) {
          if (isset($keyVal[Db::UUID]))
            $indexData[Db::UUID]         = $keyVal[Db::UUID];

          if (isset($keyVal[Db::TIME_CREATED]))
            $indexData[Db::TIME_CREATED] = $keyVal[Db::TIME_CREATED];

          $sqlstring = $this->sqlBuilder->buildInsert($indexData, 'wbfsys_data_index');

          $this->db->insert($sqlstring, 'wbfsys_data_index', 'rowid');
        }


      }

    } catch (LibDb_Exception $exc) {
      return null;
    }

  }//end public function saveDsIndex */

  /**
   * Löschen des Index nachdem ein Datensatz gelöscht wurde
   * @param Entity $entity
   */
  public function removeIndex($entity)
  {

    $keyVal     = $entity->getData();
    $entityKey  = $entity->getEntityName();
    $resourceId = $this->getResourceId($entityKey);
    $id         = $entity->getId();

    $this->db->delete('DELETE FROM wbfsys_data_index where vid = '.$id.' and id_vid_entity = '.$resourceId);

  }//end public function removeIndex */

  /**
   * Löschen des Indexes für eine Tabelle
   * @param string $entityKey
   */
  public function rebuildEntityIndex($entityKey)
  {

    $this->removeIndex($entityKey);

    $resourceId = $this->getResourceId($entityKey);

    $indexData  = array();

    $entity     = $this->newEntity($entityKey);
    $tableName  = $entity->getTable();

    $titleFields  = $entity->getIndexTitleFields();
    $keyFields    = $entity->getIndexKeyFields();
    $descriptionFields = $entity->getIndexDescriptionFields();

    $fields = array_merge(
      array('rowid', Db::UUID, Db::TIME_CREATED),
      $titleFields,
      $keyFields,
      $descriptionFields
    );

    try {

      $rows = $this->db->select('SELECT '.implode(',', $fields).' FROM '.$tableName);

      foreach ($rows as $keyVal) {

        $indexData = array();

        // title
        if ($titleFields) {
          if (count($titleFields) > 1) {
            $titleTmp = array();
            foreach ($titleFields as $field) {
              $titleTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $indexData['title'] = implode(', ', $titleTmp);
          } else {
            $indexData['title'] = isset($keyVal[$titleFields[0]])?$keyVal[$titleFields[0]]:'';
          }
        }

        // key
        if ($keyFields) {
          if (count($keyFields) > 1) {
            $keyTmp = array();
            foreach ($keyFields as $field) {
              $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $indexData['access_key'] = implode(', ', $keyTmp);
          } else {
            $indexData['access_key'] = isset($keyVal[$keyFields[0]])?$keyVal[$keyFields[0]]:'';
          }
        }

        // description
        if ($descriptionFields) {
          if (count($descriptionFields) > 1) {
            $keyTmp = array();
            foreach ($descriptionFields as $field) {
              $keyTmp[] = isset($keyVal[$field])?$keyVal[$field]:'';
            }

            $description = implode(', ', $keyTmp);
            $indexData['description'] = mb_substr
            (
              strip_tags($description),
              0,
              250,
              'utf-8'
            );
          } else {
            $indexData['description'] = mb_substr
            (
              strip_tags((isset($keyVal[$descriptionFields[0]])?$keyVal[$descriptionFields[0]]:'')),
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

        $sqlstring = $this->sqlBuilder->buildInsert($indexData, 'wbfsys_data_index');

        $this->db->create($sqlstring);

      }

    } catch (LibDb_Exception $exc) {

      return null;
    }

  }//end public function removeEntityIndex */

  /**
   * @param string $key
   * @param array $data
   * @param array $returnImports flag ob die importierten datensätze als entity zurückgegeben werden sollen
   */
  public function import($key, $data, $returnImports = false)
  {

    $importedEntities = array();

    foreach ($data as $row) {
      if ($returnImports) {
        $importedEntities[] = $this->insert($key, $row);
      } else {
        $this->insert($key, $row);
      }
    }

    return $importedEntities;

  }//end public function import */

  /**
   * method for insert
   * @param Entity $entity
   * @param int $id
   * @param array $data
   * @return Entity
   */
  public function update($entity , $id = null , $data = array())
  {

    if (is_object($entity)) {

      if ($entity instanceof Entity) {
        if ($entity->getSynchronized())
          return $entity;

        $connected = $entity->getConnected();

        foreach ($connected as $key => $conEnt) {

          Debug::console('connected '.$entity->getTable().' '.$key);

          $this->save($conEnt);

          if (!$entity->$key)
            $entity->$key = $conEnt->getId();
        }


        $id     = $entity->getId();
        $this->addToPool($entity->getEntityName(), $id, $entity);

        if ($entity->trackChanges()) {
           ++$entity->m_version;
          $entity[Db::ROLE_CHANGE]  = $this->getUser()->getId();
          $entity[Db::TIME_CHANGED] = SDate::getTimestamp(I18n::$timeStampFormat);
        }

        $keyVal     = $entity->getData();
        $entityKey  = $entity->getEntityName();
        $tableName  = $entity->getTable();
        $objid      = $entity->getId();

      } elseif ($entity instanceof LibSqlCriteria) {

        if ($res = $this->db->update($this->sqlBuilder->buildUpdate($entity)))
          return $res->getAffectedRows();
        else
          return null;
      }

    } else {

      if (!$id) {
        throw new LibDb_Exception('Update got no id');
      }

      // muss ein array sein
      $objid      = $id;
      $keyVal     = $data;
      $entityKey  = $entity;
      $tableName  = $this->getTableName($entityKey);

    }

    Debug::console('KEYVAL '.$tableName.' '.$objid, $keyVal);

    try {
      if (isset($keyVal['rowid']))
        unset($keyVal['rowid']);


      $sqlstring = $this->sqlBuilder->buildUpdate($keyVal , $tableName, 'rowid', $objid);

      // $values = array(), $table = null , $pk = null , $id = null

      if (!$this->db->update($sqlstring)) {
        Error::report('Failed to update Entity');

        return null;
      }

    } catch (LibDb_Exception $exc) {
      return null;
    }


    if (is_object($entity)) {

      $entity->synchronized();

      $postSave = $entity->getPostSave();
      foreach ($postSave as /* @var Entity $postEntiy */ $postEntiy) {
        // we asume that the entity is allready appended
        $this->save($postEntiy);
      }

      if ($entity->hasIndex())
        $this->saveDsIndex($entity);

      return $entity;

    } else {

      $data['rowid'] = $id;
      $entity = $this->fillObject($entityKey, $data);

      if ($entity->hasIndex())
        $this->saveDsIndex($entity);

      return $entity;
    }


  }//end public function update */


  /**
   * method for insert
   * @param Entity $entity
   */
  public function send($entity  )
  {

    $keyVal     = $entity->getData();
    $tableName  = $entity->getTable();
    $entityKey  = $entity->getEntityName();

    try {


      $userId     = $this->getUser()->getId();
      $timestamp  = SDate::getTimestamp(I18n::$timeStampFormat);

      if ($entity->trackCreation()) {
        $keyVal[Db::ROLE_CREATE]  = $userId;
        $keyVal[Db::TIME_CREATED] = $timestamp;
      }

      if ($entity->trackChanges()) {
        $keyVal[Db::ROLE_CHANGE]  = $userId;
        $keyVal[Db::TIME_CHANGED] = $timestamp;
        $keyVal[Db::VERSION] = Db::START_VALUE;
      }

      $sqlstring = $this->sqlBuilder->buildInsert($keyVal, $tableName);

      $this->db->create($sqlstring);

    } catch (LibDb_Exception $exc) {
      return null;
    }

  }//end public function send */

  /**
   * method for insert
   * @param Entity $entity
   * @param int $id
   *
   * @throws LibDb_Exception
   */
  public function delete($entity, $id = null  )
  {

    if (is_object($entity)   ) {
      if ($entity instanceof Entity) {
        $id           = $entity->getId();
        $entityKey    = $entity->getEntityName();
        //$entity
        $entityTable  = $entity->getTable();
      } elseif ($entity instanceof LibSqlCriteria) {
        $this->db->delete($this->sqlBuilder->buildDelete($entity));

        return;
      }
    } else {
      //$id
      $entityKey = $entity;

      if (!$entity = $this->get($entity, $id)) {
        Message::addWarning('Tried to delete a non existing Dataset');

        return false;
      }

      $entityTable  = $entity->getTable();
    }


    $references = $entity->getAllReferences();

    // Prüfen aller Referenzen um rekursiv löschen zu können
    foreach ($references as $attribute => $ref) {

      if ($attribute == 'rowid') {
        //array('type' => 'oneToOne', 'entity' => 'CorePeople' , 'refId' => 'rowid' , 'delete' => true),
        foreach ($ref as $conRef) {
          if (!$conRef['delete'])
            continue;

          $this->deleteWhere(SParserString::subToCamelCase($conRef['entity']), $conRef['refId'].' = '.$id);

        }
      } else {
        if (!$ref['delete'])
          continue;

        if (!$entity->$attribute)
          continue;

        // Rekursives Löschen
        $this->deleteWhere(SParserString::subToCamelCase($ref['entity']), $ref['refId'].' = '.$entity->$attribute);
      }

    }

    // daten aus dem Data Index entfernen
    if ($entity->hasIndex())
      $this->removeIndex($entity);

    $sqlstring = $this->sqlBuilder->buildDelete($entityTable, 'rowid',  $id);

    $this->db->delete($sqlstring);

    $this->removeFromPool($entityKey, $id);


  }//end public function delete */

  /**
   * methode zum löschen von Datensätzen
   * @param Dbo/array
   * @return boolean
   */
  public function deleteWhere($entityKey, $where)
  {

    $tableName  = $this->getTableName($entityKey);
    $entities   = $this->getListWhere($entityKey, $where);

    foreach ($entities as $entity)
      $this->delete($entity);

  }//end public function deleteWhere */


  /**
   * method to delete all entities from a table
   * and all referencing elementes
   *
   * @param string $entityKey
   * @return void
   */
  public function cleanResource($entityKey)
  {

    $entities = $this->getAll($entityKey);

    foreach ($entities as $entity)
      $this->delete($entity);

  }//end public function cleanResource */


/*//////////////////////////////////////////////////////////////////////////////
// protected inner Logic
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string $entityName
   *
   * @return array
   */
  protected function buildEmptyResult($entityName)
  {

    $result = array();

    foreach ($this->cols as $col)
      $result[$col] = null;

    return $result;

  }//end protected function buildEmptyResult */

  /**
   * @param string  $entityName
   * @param array   $datas
   *
   * @return array
   */
  protected function fillObjects($entityName, $datas)
  {

    if (!Webfrap::classLoadable($entityName))
      throw new LibDb_Exception('Requested nonexisting Entity '.$entityName);

    $pool = array();

    foreach ($datas as $data) {
      $id = $data['rowid'];

      $entity = new $entityName($id, $data, $this);

      $this->addToPool($entityName, $id, $entity);
      $pool[$id] = $entity;
    }

    return $pool;

  }//end protected function fillObjects */

  /**
   * @param string $entityName
   * @param array $data
   */
  protected function fillObject($entityName,  $data)
  {

    $classname    = $entityName.'_Entity';

    if (!Webfrap::classLoadable($classname))
      throw new LibDb_Exception('Requested nonexisting Entity '.$entityName);

    $id     = $data['rowid'];
    $entity = new $classname($id, $data, $this);
    $this->addToPool($classname, $id, $entity);

    return $entity;

  }//end protected function fillObject */

/*//////////////////////////////////////////////////////////////////////////////
// Index
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Speichern des Caches
   */
  public function saveCache()
  {
    $this->saveResourceIdCache();
  }//end public function saveCache */

  /**
   * Laden des Caches für die Entity Ids
   */
  protected function loadResourceIdCache()
  {

    $cacheFile =  PATH_GW.'cache/db_resources/'.$this->db->databaseName.'/'.$this->db->schema.'.php';

    if (file_exists($cacheFile))
      include $cacheFile;

  }//end protected function loadResourceIdCache */

  /**
   * Laden des Caches für die Entity Ids
   */
  protected function saveResourceIdCache()
  {

    // nur speichern wenn der
    if (!$this->saveResourceIndex)
      return;

    $cacheFile =  PATH_GW.'cache/db_resources/'.$this->db->databaseName.'/'.$this->db->schema.'.php';

    $cache = '<?php'.NL;
    $cache .= '$this->resourceIds = array('.NL;

    foreach ($this->resourceIds as $key => $value) {
      $cache .= "'{$key}' => '{$value}',".NL;
    }

    $cache .= ');'.NL;

    SFiles::write($cacheFile, $cache);

  }//end protected function loadResourceIdCache */

/*//////////////////////////////////////////////////////////////////////////////
// Debug Data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return
   */
  public function getDebugDump()
  {
    return 'LIB DB ORM '. count($this->objPool);
  }//end public function getDebugDump */

} //end class LibDbOrm

