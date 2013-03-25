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
 * de:
 * Die Entity Klasse ist eines der Kernstücke des ORM
 * Eine Entity Objekt repräsentiert genau einen Datensatz aus einer bestimmten
 * Tabelle.
 *
 * Entity Objekten sind für CRUD Operationen gedacht.
 * Wenn du eine größere Anzahl von Einträgen, die noch dazu aus mehr als aus
 * einer Tabelle stammen, laden willst nimm eine Query Klasse und lade die
 * daten als Array
 *
 * @package WebFrap
 * @subpackage Framework
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 * @tag orm, db, abstraction, entity
 *
 */
abstract class Entity implements ArrayAccess
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Position des Validators
   * @var int
   */
  const COL_VALIDATOR = 0;

  /**
   * Key für das required flag
   * @var int
   */
  const COL_REQUIRED  = 1;

  /**
   * the maxvalue / maxsize if exists
   * @var int
   */
  const COL_MAX       = 2;

  /**
   * the minvalue / minsize if exists
   * @var int
   */
  const COL_MIN       = 3;

  /**
   * needs this value a quote in the sql or not?
   * @var int
   */
  const COL_QUOTE     = 4;

  /**
   * flag if the attribute is a search attribute
   * @var int
   */
  const COL_SEARCH     = 5;

  /**
   * is this a pultiple value? an array in the database
   * @var int
   */
  const COL_MULTI     = 6;

  /**
   * the keyname of the main category
   * @var int
   */
  const COL_CATEGORY  = 7;

  /**
   * the default value
   * @var int
   */
  const COL_DEFAULT  = 8;

/*//////////////////////////////////////////////////////////////////////////////
// Protected Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Saved data repräsentiert den stand der daten in der datenbank
   * diese variable kann dazu verwendet werden einen diff zwischen neuen und
   * daten in der datenbank anzuzeigen
   *
   * Sie wird aber nur bei Bedarf gefüllt
   *
   * saveData enthält nur die Datensätze die auch tatsächlich geändert wurden
   *
   * @var array<string:string>
   */
  protected $savedData      = array();

  /**
   * Array with the data from the database
   * @var array<string:string>
   */
  protected $data           = array();

  /**
   * Die eindeutige ID des Datensatzes in der Datenbank
   * Das ORM geht davon aus, dass die IDs einer globalen sequence entspringen
   * @var int
   */
  protected $id             = null;

  /**
   * flag ob die entity mit der Datenbank synchronisiert wurde
   * @var boolean
   */
  protected $synchronized   = true;

  /**
   * pool for objects that hase to be saved after save
   *
   * @var array<entity>
   */
  protected $postSave       = array();

  /**
   * Pool with all to the entity connected Entities to build a net of entities
   * to save alle connected entities in one way
   * That makes it easier for developers to same the entities in the correct
   * order to solve all dependencies
   *
   * @var array<entity>
   */
  protected $singleRef      = array();

  /**
   * List to be able to connect multiple references
   * @var array<entity>
   */
  protected $multiRef       = array();

  /**
   * Flag to mark if an entity is new and has no id or the data are from
   * the database
   *
   * This flag is important to make i easy to clone existing entities or
   * implement a "just new versioning" storage in the database
   *
   * @var boolean
   */
  protected $isNew      = false;

  /**
   * @var LibI18nPhp
   */
  public $i18n          = null;

  /**
   * Das Orm Objekt mit dem die Entity geladen wurde
   * @var LibDbOrm
   */
  public $orm           = null;
  
  /**
   * Die Temporäre ID
   * @var string
   */
  public $tmpId          = null;

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter
   * @param string $key
   * @param string $value
   */
  public function offsetSet($key, $value)
  {

    $this->setData($key, $value);

  }//end public function offsetSet */

  /**
   * @getter
   * @param string $offset
   * @return string
   */
  public function offsetGet($offset)
  {
    return isset($this->data[$offset])
      ? $this->data[$offset]
      : null;

  }//end public function offsetGet */

  /**
   * @param string $offset
   */
  public function offsetUnset($offset)
  {

    if (isset($this->data[$offset])) {
      $this->synchronized = false;
      $this->savedData[$offset] = $this->data[$offset];
      unset($this->data[$offset]);
    }

  }//end public function offsetUnset */

  /**
   * @param string $offset
   * @return boolean
   */
  public function offsetExists($offset)
  {
    return isset($this->data[$offset])?true:false;
  }//end public function offsetExists */

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param int $id
   * @param string $data
   * @param LibDbOrm $orm
   */
  public function __construct
  (
    $id   = null,
    $data = array(),
    $orm  = null
  ) {

    /// TODO check if its possible to use the id instead of the is new attribute
    if (is_null($id)) {
      $this->isNew  = true;
      $this->fillupDefault();
    } else {
      $this->id     = $id;
    }

    $this->data     = $data;

    if ($orm) {

      if ($orm instanceof LibDbConnection)
        $orm = $orm->getOrm();

      $this->orm = $orm;
    } else {
      $this->orm = Db::getOrm();
    }

  } // end public function __construct */

  /**
   * @return array
   */
  public function __sleep()
  {
    return array(
      'data',
      'savedData',
      'id',
      'isNew',
      'synchronized'
    );

  }//end public function __sleep */

  /**
   * Wakeup methode
   */
  public function __wakeup()
  {
    $this->orm = Db::getOrm();
  }//end public function __wakeup */

  /**
   *
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    
    return $this->offsetGet($key);

  }//end public function __get */

  /**
   *
   * @param string $key
   * @param string $value
   * @return void
   */
  public function __set($key , $value)
  {

    $this->setData($key, $value);

  }//end public function __set */

  /**
   * the to String Method
   * @return string
   */
  public function __toString()
  {
    return ''.$this->id;
  }//end public function __toString */

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {

    if (!$this->i18n)
      $this->i18n = I18n::getActive();

    return $this->i18n;

  }//end public function getI18n */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param string $value
   * @param boolean $empty
   */
  public function retrofit($key, $value, $empty = false  )
  {

    if (is_string($empty)) {
      if (isset($this->data[$key])) {

        if (method_exists($this, $empty)) {
          if ($this->$empty($key, $value)) {
            $this->savedData[$key] = $this->data[$key];
            $this->data[$key]   = $value;
          }
        } else {
          throw new LibDb_Exception("Tried to retrofit with nonexisting check : ".$empty  );
        }

      } else {
        $this->synchronized = false;
        $this->savedData[$key] = null;
        $this->data[$key]   = $value;
      }
    } else {
      // works, cause if value is null, isset returns false
      if (isset($this->data[$key])) {
        if ('' == trim($this->data[$key]) && $empty) {
          $this->synchronized = false;
          $this->savedData[$key] = null;
          $this->data[$key]   = $value;
        }
      } else {
        $this->synchronized = false;
        $this->savedData[$key] = null;
        $this->data[$key]   = $value;
      }
    }

  }//end public function retrofit */

  /**
   * @param string $key
   * @param string $value
   */
  public function upgrade($key, $value)
  {

    if (is_object($value)) {
      $value = $value->getid();
    }

    // works, cause if value is null, isset returns false
    if (isset($this->data[$key])) {
      if ((string) $value !== (string) $this->data[$key]) {
        $this->synchronized    = false;
        $this->savedData[$key] = $this->data[$key];
        $this->data[$key]      = $value;
      }
    } else {
      $this->synchronized = false;
      $this->savedData[$key] = null;
      $this->data[$key]   = $value;
    }

  }//end public function upgrade */

  /**
   * @param string $key
   * @param string $value
   * @param boolean $empty
   */
  public function change($key, $value, $empty = false  )
  {

    // works, cause if value is null, isset returns false
    if (isset($this->data[$key])) {

      if ('' === trim($this->data[$key]) && $empty) {

        $this->savedData[$key] = $this->data[$key];
        $this->data[$key] = trim($value);
        $this->synchronized = false;

        return true;

      }

      return false;

    } else {

      $this->data[$key] = $value;
      $this->savedData[$key] = null;
      $this->synchronized = false;

      return true;
    }

  }//end public function change */

  /**
   * @getter
   * @return string
   * @tag url
   */
  public function toUrl()
  {
    return '<a href="'.static::$toUrl.'&amp;objid='.$this->id.'" >'.$this->text().'</a>';
  }//end public function toUrl */

  /**
   * @return string
   */
  public function text($key = 'text')
  {

    if (!isset(static::$textKeys[$key])) {
      if (!$this->id)
        return '';
      else
        return static::$label.': '.$this->id;
    }

    if (!static::$textKeys[$key]) {
      if (!$this->id)
        return '';
      else
        return static::$label.': '.$this->id;
    } else {
      $keys = static::$textKeys[$key];
    }

    $string = '';

    foreach($keys as $key)
      $string .=  isset($this->data[$key])? $this->data[$key].', ':'';

    return substr($string,0,-2);

  }//end public function text */

  /**
   * @return string
   */
  public function textKeys($key = 'text')
  {

    if (isset(static::$textKeys[$key])) {
      return static::$textKeys[$key];
    } else {
      return null;
    }

  }//end public function textKeys */

  /**
   * @return string
   */
  public function description()
  {
    return static::$description;
  }//end public function description */

  /**
   * @return boolean
   */
  public function trackChanges()
  {
    return static::$trackChanges;
  }//end public function trackChanges */

  /**
   * @return boolean
   */
  public function trackCreation()
  {
    return static::$trackCreation;
  }//end public function trackCreation */

  /**
   * @return boolean
   */
  public function trackDeletion()
  {
    return static::$trackDeletion;
  }//end public function trackDeletion */

  /**
   * @return boolean
   */
  public function isSyncable()
  {
    return static::$isSyncable;
  }//end public function isSyncable */

/*//////////////////////////////////////////////////////////////////////////////
// Getter for Entity Meta data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Getter für die Cols
   * @param string/array $catKeys if converts to false, always return all fields
   * @return array
   */
  public function getCols($catKeys = null)
  {

    // if converts to false, always return all fields
    if (!$catKeys) {
      return array_keys(static::$cols);
    } elseif (is_scalar($catKeys)) {

      if (!isset(static::$categories[$catKeys])) {
        Error::report('Requested invalid '.$catKeys);

        return array();
      }

      return static::$categories[$catKeys];

    } elseif (is_array($catKeys)  ) {

      $cols = array();

      ///TODO error reporting
      foreach ($catKeys as $cat) {
        if (isset(static::$categories[$cat]))
          $cols = array_merge($cols, static::$categories[$cat]);
      }

      return $cols;

    } else {
      
      Error::report('Requested invalid '.$catKeys);
      return array();
    }

  } // end public function getCols */

  /**
   * Getter für die Cols
   * @param string/array $catKeys if converts to false, always return all fields
   * @return array
   */
  public function getQueryCols($catKeys = null)
  {
    return array_keys(static::$cols);

  } // end public function getCols */

  /**
   * Getter für die Cols
   * @param string/array $catKeys if converts to false, always return all fields
   * @return array
   */
  public function hasCol($colKey)
  {
    return isset(static::$cols[$colKey]);
  }//end public function hasCol */

  /**
   *
   * @param array $categories
   * @return string
   */
  public function getSearchCols($categories = null)
  {

    // if no attributes are given return everything
    if (is_null($categories)) {
      $cols = array_keys(static::$cols);
    } else {

      $cols = array();
      foreach ($categories as $cat) {
        if (isset(static::$categories[$cat]))
          $cols = array_merge($cols, static::$categories[$cat]);
      }

    }

    $searchCols = array();

    foreach ($cols as $col) {
      if (static::$cols[$col][self::COL_SEARCH]   )
        $searchCols[] = $col;
    }

    return $searchCols;

  }//end public function getSearchCols */

  /**
   * Getter für die Cols
   *
   * @return array
   */
  public function getTable()
  {
    return static::$table;
  } // end public function getTable */

  /**
   * Getter für den Basis Domain Node
   *
   * @return DomainNode
   */
  public function getDomainNode()
  {
    return DomainNode::getNode(static::$table);
  } // end public function getDomainNode */

  /**
   * @return string
   */
  public function getEntityName()
  {
    return static::$entityName;
  }//end public function getEntityName */

 /**
  * Getter für die Cols
  *
  * @return string
  */
  public function getTablePk()
  {
    return static::$tablePk;
  } // end public function getTablePk */

 /**
  * check ob die Entity Readonly ist
  * Kann z.B bei Entities für Views vorkommen
  *
  * @return boolean
  */
  public function isRo()
  {
    return static::$readOnly;
  } // end public function isRo */

  /**
   * @param string $key
   * @return int
   */
  public function minSize($key)
  {

    if (!isset(static::$cols[$key])) {
      Error::report
      (
        'asked for wrong Validation data: '.$key . ' in '.get_class($this)
      );

      return null;
    }

    return static::$cols[$key][self::COL_MIN];

  }//end public function getMinSize */

  /**
   * @param string $key
   * @return int
   */
  public function maxSize($key)
  {

    if (!isset(static::$cols[$key])) {
      Error::report
      (
        'asked for wrong Validation data: '.$key . ' in '.get_class($this)
      );

      return null;
    }

    return static::$cols[$key][self::COL_MAX];

  }//end public function getMaxSize */

  /**
   * @param string $key
   * @return int
   */
  public function required($key)
  {

    if (!isset(static::$cols[$key])) {
      Error::report
      (
        'asked for wrong Validation data: '.$key . ' in '.get_class($this)
      );

      return null;
    }

    return static::$cols[$key][self::COL_REQUIRED];

  }//end public function getMaxSize */

  /**
   * @param string $key
   * @return int
   */
  public function defaultValue($key)
  {

    if (!isset(static::$cols[$key])) {
      Error::report
       ('asked for wrong default value data: '.$key . ' in '.get_class($this));

      return null;
    }

    return static::$cols[$key][self::COL_DEFAULT];

  }//end public function getMaxSize */

  /**
   *
   * @param array $keys
   */
  public function getValidationData($keys = null, $insert = false)
  {

    if (!$keys) {
      if ($insert) {
        $cols = static::$cols;
        unset($cols[Db::PK]);

        return $cols;
      } else {
        return static::$cols;
      }
    }

    $data = array();

    foreach ($keys as $key) {
      if (!isset(static::$cols[$key])) {

        Debug::console(get_class($this).'::'.$key , static::$cols  );

        throw new LibDb_Exception
          ('asked for wrong Validation data: '.$key . ' in '.get_class($this));
      } else {
        $data[$key] = static::$cols[$key];
      }
    }

    // if it's insert we never want the PK
    if ($insert && isset($data[Db::PK]))
      unset($data[Db::PK]);

    return $data;

  }//end public function getValidationdata */

  /**
   * @param array $keys
   */
  public function getErrorMessages($keys = array())
  {

    $data = array();

    foreach ($keys as $key) {
      if (isset(static::$messages[$key])) {
        $data[$key] = I18n::s(static::$messages[$key]);
      } else {
        Log::warn('No Error Message for key: '.$key);
      }
    }

    return $data;

  }//end public function getErrorMessages */

/*//////////////////////////////////////////////////////////////////////////////
// Index Informationen
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * Prüfen ob die Entity einen Index hat
  *
  * @return boolean
  */
  public function hasIndex()
  {
    return isset(static::$index)
      ?static::$index
      :false;

  } // end public function hasIndex */

 /**
  * Getter für die Cols
  *
  * @return string
  */
  public function getIndexNameFields()
  {
    return static::$indexNameFields;
  } // end public function getIndexNameFields */

 /**
  * Getter für die Cols
  *
  * @return string
  */
  public function getIndexTitleFields()
  {
    return static::$indexTitleFields;
  } // end public function getIndexTitleFields */

 /**
  * Getter für die Cols
  *
  * @return string
  */
  public function getIndexKeyFields()
  {
    return static::$indexKeyFields;
  } // end public function getIndexKeyFields */

 /**
  * Getter für die Cols
  *
  * @return string
  */
  public function getIndexDescriptionFields()
  {
    return static::$indexDescriptionFields;
  } // end public function getIndexDescriptionFields */

 /**
  * Getter für die Felder die im Suchindex verwendet werden sollen
  *
  * @return string
  */
  public function getIndexSearchFields()
  {
    return static::$indexSearchFields;
  } // end public function getIndexSearchFields */

 /**
  * Checken ob der Index public oder nur privat ist
  *
  * @return boolean
  */
  public function isIndexPrivate()
  {
    return static::$indexPrivate;
  }// end public function isIndexPrivate */

/*//////////////////////////////////////////////////////////////////////////////
// Track fields
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function getChangedFields()
  {
    return array_keys($this->savedData);
  }//end public function getChangedFields */

  /**
   * @return array
   */
  public function getOldData()
  {
    return $this->savedData;
  }//end public function getOldData */

  /**
   * @return array
   */
  public function getChangedData()
  {

    $tmp  = array();
    $keys = array_keys($this->savedData);

    foreach ($keys as $key) {
      $tmp[$key] = $this->data[$key];
    }

    return $tmp;

  }//end public function getOldData */

/*//////////////////////////////////////////////////////////////////////////////
// Getter und Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @return boolean
   */
  public function isNew()
  {
    return $this->isNew;
  }//end public function getIsNew */

  /**
   * @param boolean $new
   */
  public function setIsNew($new = true)
  {
    $this->isNew = $new;
  }//end public function setIsNew */

  /**
   * @param string $url
   */
  public function setToUrl($url)
  {
    $this->toUrl = $url;
  }//end public function setToUrl */

  /**
   * @return string
   */
  public function getToUrl()
  {
    return $this->toUrl;
  }//end public function getToUrl */

  /**
   * set the dbo Id
   *
   * @param int $id Die zu setzende Objektid
   * @param boolean $new Die zu setzende Objektid
   *
   * @throws LibDb_Exception
   */
  public function setId($id , $new = false)
  {

    Debug::console('set id entity: '.$this->getTable().' id: '.$id , $id);

    if (!is_numeric($id)) {
      throw new LibDb_Exception
      (
        I18n::s
        (
          'Got invalid error ID {@id@}',
          'wbf.message',
          array('id' => $id)
        )
      );
    }

    $this->synchronized = false;

    $this->id     = $id   ;
    $this->isNew  = $new  ;

  } // public public function setId */

  /**
   *
   */
  public function resetId()
  {

    Debug::console('called reset?');

    $this->id = null ;
  } // end public function resetId */

  /**
   * Abfragen der Eintragsid
   *
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }//end public function getId  */


  /**
   * Abfragen der Eintragsid
   *
   * @return int
   */
  public function getInsertId()
  {

    if ($this->isNew)
      return $this->id;
    else
      return null;

  } // end public function getId  */

  /**
   * abfragen ob synchronized ist
   *
   * @return boolean
   */
  public function getSynchronized()
  {
    return $this->synchronized;
  } // end public function getSynchronized */

  /**
   * @param Entity | User $user
   * @return boolean
   */
  public function isOwner($user)
  {

    if ($this->m_role_create == $user->getId())
      return true;
    else
      return false;

  }//end public function isOwner */

  /**
   * abfragen ob synchronized ist
   *
   * @return boolean
   */
  public function synchronized($sync = true)
  {

    // wenn synchronisiert gibt es logischwerweise keinen diff mehr
    // zwischen der datenbank und dem objekt
    if ($sync)
      $this->savedData = array();

    $this->synchronized = $sync;

  } // end public function synchronized */

  /**
   *
   * @param string $key
   * @param Entity $entity
   * @return void
   */
  public function connect($key , $entity)
  {
    $this->singleRef[$key] = $entity;
  }//end public function connect */

  /**
   *
   * @param string $key
   * @param Entity $entity
   * @return void
   */
  public function append($key , $entity)
  {
    $this->multiRef[$key][$entity->getId()] = $entity;
  }//end public function append */

  /**
   *
   * @param string $key
   * @return Entity
   */
  public function getReference($key)
  {
    return isset(static::$references[$key])
      ? static::$references[$key]
      : null;

  }//end public function getReference */

  /**
   * @getter
   * @return array<string:Entity>
   */
  public function getAllReferences()
  {
    return static::$references;
  }//end public function getAllReferences */

  /**
   * @getter
   * @param string $key
   * @param boolean $empty wenn true wird ein leeres Entity Objekt vom erwarteten type zurückgegeben
   * @return Entity
   */
  public function followLink($key, $empty = false)
  {

    Debug::console('FOLLOW link '.$key.' in '.static::$table);

    if (!isset(static::$links[$key])) {
      throw new LibDb_Exception('Tried fo follow nonexisting link '.$key);
    }

    /*
    if (!$this->id) {
      throw new LibDb_Exception('Tried to follow a link on a nonloaded entity '.$key);
    }
    */

    if (!isset($this->data[$key]) || !$this->data[$key]) {
      Debug::console('no data to follow for key '.$key);

      if ($empty) {
        $newObj = $this->orm->newEntity(SParserString::subToCamelCase(static::$links[$key]));
        $this->{$key} = $newObj;

        return $newObj;
      } else {
        return null;
      }
    }

    $entityId = $this->getData($key);

    if (is_object($entityId))
      return $entityId;

    $entity = $this->orm->get(SParserString::subToCamelCase(static::$links[$key]), $entityId);

    if ($entity) {
      $this->{$key} = $entity;

      return $entity;
    } elseif ($empty) {
      $newObj = $this->orm->newEntity(SParserString::subToCamelCase(static::$links[$key]));
      $this->{$key} = $newObj;

      return $newObj;
    } else {
      return null;
    }

  }//end public function followLink */

  /**
   * Besitzer der Entity
   * @param boolean $id
   * @return WbfsysRoleUser_Entity
   */
  public function owner($id = null)
  {

    if ($id) {
      return $this->followLink('m_role_create');
    } else {
      return $this->m_role_create;
    }

  }//end public function owner */

  /**
   * @getter
   * @return array<string:Entity>
   */
  public function getConnected()
  {
    return $this->singleRef;
  }//end public function getConnected */

  /**
   * @getter
   * @return array<array<scalar(int/uuid):Entity>>
   */
  public function getAppends()
  {
    return $this->multiRef;
  }//end public function getAppends */

  /**
   * @getter
   * @return array<array<scalar(int/uuid):Entity>>
   */
  public function getPostSave()
  {
    return $this->postSave;
  }//end public function getPostSave */

  /**
   * setzen der Default werte
   */
  public function fillupDefault()
  {
    foreach (static::$cols as $key => $col) {
      if ( '' != $col[self::COL_DEFAULT]) {
        $this->data[$key] = $col;
      }
    }

  }//end public function fillupDefault */

  /**
   * Laden der Target Entity
   * @param string $key
   * @param boolean $enforceEntity
   */
  public function getRefNode($key, $enforceEntity = false)
  {

    if (!isset(static::$links[$key]))
      throw new LibDb_Exception("Requested a target object for a non linked attribute ".$key);

    $entityKey = SParserString::subToCamelCase(static::$links[$key]);
    $className = $entityKey.'_Entity';

    if (! WebFrap::classLoadable($className))
      throw new LibDb_Exception("Target Entity {$className}  for attribute ".$key.' not exists!');

    // wenn der wert null ist, dann kann auch keine target Entity geladen werden
    if (!isset($this->data[$key]) || !$this->data[$key]) {
      if ($enforceEntity) {
        return new $className();
      } else {
        return null;
      }
    }

    return $this->orm->get($entityKey, $this->data[$key]);

  }//end public function getRefNode */

/*//////////////////////////////////////////////////////////////////////////////
// getter methodes for the data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string / array $category
   * @return array
   */
  public function getCategoryData($category)
  {

    $data = array();

    if (is_string($category)) {

      if (!isset(static::$categories[$category])  ) {
        throw new LibDb_Exception('Tried to fetch data from a nonexisting category '.$category);
      }

      $cats = static::$categories[$category];

      foreach ($cats as $key) {
        if (array_key_exists($key, $this->data)) {
          $data[$key] = $this->data[$key];
        }
      }
    } else {

      foreach ($category as $catKey) {
        if (! isset(static::$categories[$catKey])  ) {
          throw new LibDb_Exception('Tried to fetch data from a nonexisting category '.$catKey);
        }

        $cats = static::$categories[$catKey];

        foreach ($cats as $key) {
          if (array_key_exists($key, $this->data)) {
            $data[$key] = $this->data[$key];
          }
        }
      }

    }

    return $data;

  }//end public function getCategoryData */

  /**
   * Abfragen von vorhandenen Daten
   *
   * @param string $key Name des angfragten Werts
   * @param boolean $preTab
   *
   * @return string
   */
  public function getData($key = null, $preTab = false)
  {

    if (is_string($key)) {
      if (array_key_exists($key, $this->data)) {
        return $this->data[$key];
      } else {
        return null;
      }

    } elseif ($key && is_array($key)) {

      $data = array();
      if ($preTab) {
        if (is_string($preTab)) {
          foreach ($key as $name) {
            if (array_key_exists($name, $this->data)) {
              $data[$preTab.'_'.$name] = $this->data[$name];
            } else {
              $data[$preTab.'_'.$name] = null;
            }
          }
        } else {
          foreach ($key as $name) {
            if (array_key_exists($name, $this->data)) {
              $data[static::$table.'_'.$name] = $this->data[$name];
            } else {
              $data[static::$table.'_'.$name] = null;
            }
          }
        }
      } else {
        foreach ($key as $name) {
          if (array_key_exists($name , $this->data)) {
            $data[$name] = $this->data[$name];
          } else {
            $data[$name] = null;
          }
        }
      }

      return $data;
    } else {
      if (array_key_exists(Db::PK  , $this->data))
        unset($this->data[Db::PK]);

      if ($preTab) {

        $data = array();

        if (is_string($preTab)) {
          foreach($this->data as $key => $value)
            $data[$preTab.'_'.$key] = $value;

          $data[$preTab.'_'.Db::PK] = $this->id ;
        } else {
          foreach($this->data as $key => $value)
            $data[static::$table.'_'.$key] = $value;

          $data[static::$table.'_'.Db::PK] = $this->id ;
        }

        return $data;
      } else {
        return $this->data;
      }

    }

  } // end public function getData */

  /**
   * Abfragen von vorhandenen Daten
   *
   * @param string $preTab Name des angfragten Werts
   * @return string
   */
  public function getAllData($preTab = null  )
  {

    $data = array();
    $colKeys = array_keys(static::$cols);

    if ($preTab) {
      
      foreach ($colKeys as $key) {
        $data[$preTab.'_'.$key] = isset($this->data[$key])
          ? $this->data[$key]
          : null;
      }

      $data[$preTab.'_rowid'] = $this->id;
      
    } else {
      
      foreach ($colKeys as $key) {
        $data[static::$table.'_'.$key] = isset($this->data[$key])
          ? $this->data[$key]
          : null;
      }

      $data[static::$table.'_rowid'] = $this->id;
    }

    return $data;

  }// end public function getAllData */

  /**
   *
   * @param string $key
   * @param string $value
   */
  public function setData($key, $value)
  {

      if (is_object($value)) {
      // muss auf false gesetzt werden, da der wert der Entity
      // sich ändern könnte und auf dieser beim save auch ein save getriggert
      // werden muss
      $this->synchronized = false;
      if ($value instanceof Entity) {
        if ('rowid' === $key) {
          
          $this->postSave[] = $value; ///TODO checken ob das nicht lieber eine Exception sein sollte
        
        } else {
          
          $this->singleRef[$key] = $value;

          if (!isset($this->data[$key])) {
            
            $this->savedData[$key] = null;
            $this->data[$key] = $value;
          } else {
            // wenn neu können wir auf jeden fall von einer Änderung ausgehen
            if ($value->isNew() || $this->data[$key] !== (string) $value) {
              
              $this->savedData[$key] = $this->data[$key];
              $this->data[$key] = $value;
            }
          }

        }
      } else {

        if (!isset($this->data[$key])) {
          
          $this->savedData[$key] = null;
          $this->data[$key] = $value;
        } else {
          
          $this->savedData[$key] = $this->data[$key];
          $this->data[$key] = $value;
        }

        // kann zB ein Upload Element sein, dass die ID des hochgeladenen Files zurückgibt
        $value->setEntity($this);
        $this->postSave[] = $value;

      }
    } else {

      if (!isset($this->data[$key])) {
        
        $this->synchronized    = false;
        $this->savedData[$key] = null;
        $this->data[$key]      = $value;
      } elseif ($this->data[$key] !== (string) $value) {
        
        $this->synchronized    = false;
        $this->savedData[$key] = $this->data[$key];
        $this->data[$key]      = $value;
      }

    }

  }//end public function setData */

  /**
   * @param array $data
   */
  public function setAllData($data  )
  {

    foreach ($data as $key => $value) {
      $this->setData($key, $value);
    }

  }//end public function setAllData */

  /**
   * @param string $key
   * @param boolean $preTab
   *
   * @return string
   */
  public function getSecure($key = null, $preTab = false)
  {

    if (is_string($key)) {
      if (array_key_exists($key, $this->data))
        return Validator::sanitizeHtml($this->data[$key]);

      else
        return null;
    } elseif ($key and is_array($key)) {

      $data = array();

      if ($preTab) {
        foreach ($key as $name) {
          if (array_key_exists($name, $this->data))
            $data[static::$table.'_'.$name] = Validator::sanitizeHtml($this->data[$name]);

          else
            $data[static::$table.'_'.$name] = null;
        }
      } else {
        foreach ($key as $name) {
          if (array_key_exists($name, $this->data))
            $data[$name] = Validator::sanitizeHtml($this->data[$name]);

          else
            $data[$name] = null;
        }
      }

      return $data;

    } else {

      if (array_key_exists(Db::PK , $this->data))
        unset($this->data[Db::PK]);

      if ($preTab) {
        $data = array();

        foreach($this->data as $key => $value)
          $data[static::$table.'_'.$key] =  Validator::sanitizeHtml($value);

        $data[static::$table.'_'.Db::PK] = $this->id ;

        return $data;
      } else {
        return $this->data;
      }

    }

  }//end public function getSecure */

  /**
   * Abfragen von vorhandenen Daten
   *
   * @param string $key Key Name des angfragten Werts
   * @param function $function
   *
   * @return string
   */
  public function getFormated($key, $function  )
  {

    if (isset($this->data[$key])) {
      $data = $function($this->data[$key]);

      if (is_array($function)) {
        foreach($function as $func)
          $data = $func($data);
      } else {
        $data = $function($data);
      }

      return $data;
    } else {
      return null;
    }

  }// end public function getFormated */

  /**
   * @param string $key
   * @return float
   */
  public function isEmpty($key)
  {

    if (isset($this->data[$key]))
      return (''==trim($this->data[$key]));
    else
      return true;

  }// end public function isEmpty */

  /**
   * @param string $key
   * @return float
   */
  public function getMoney($key)
  {

    // if theres no i18n fetch the default
    $i18n = $this->getI18n();

    if (isset($this->data[$key]))
      return $i18n->number($this->data[$key], 2);
    else
      return null;

  }// end public function getMoney */

  /**
   * @param string $key
   * @return int
   */
  public function getInt($key)
  {

    if (isset($this->data[$key]))
      return (int) $this->data[$key];
    else
      return 0;

  } // end public function getInt */

  /**
   * @param string $key
   * @return boolean
   */
  public function getBoolean($key)
  {

    if (isset($this->data[$key]) && ('f' !=  $this->data[$key] && 'FALSE' !=  $this->data[$key]  )  )
      return true;
    else
      return false;

  } // end public function getBoolean */

  /**
   * @param string $key
   * @return string.html
   */
  public function getHtml($key  )
  {

    if (isset($this->data[$key]))
      return $this->data[$key] ;
    else
      return null;

  } // end public function getHtml */

  /**
   * @param string key
   * @return float
   */
  public function getNumeric($key)
  {

    // if theres no i18n fetch the default
    $i18n = $this->getI18n();

    if (isset($this->data[$key]))
      return $i18n->number($this->data[$key], 2);
    else
      return null;

  } // end public function getNumeric */

  /**
   * @param string $key
   * @return array
   */
  public function getArray($key)
  {

    if (isset($this->data[$key]))
      return Db::getActive()->dbArrayToArray($this->data[$key]);
    else
      return null;

  } // end public function getArray */

  /**
   * @param string $key
   */
  public function getArrayString($key)
  {

    if (isset($this->data[$key])) {
      $array = Db::getActive()->dbArrayToArray($this->data[$key]);

      if (is_null($array))
        return null;

      return implode(';' , $array)  ;
    } else {
      return null;
    }

  } // end public function getArray */

  /**
   * @param string $key
   * @param string $format
   */
  public function getDate($key , $format = null  )
  {

    // if theres no i18n fetch the default
    $i18n = $this->getI18n();

    if (isset($this->data[$key]))
      return $i18n->date($this->data[$key]);
    else
      return null;

  }//end public function getDate */

  /**
   * @param string $key
   */
  public function getTime($key)
  {

    // if theres no i18n fetch the default
    $i18n = $this->getI18n();

    if (isset($this->data[$key]))
      return $i18n->time($this->data[$key]);
    else
      return null;

  }//end public function getTime */

  /**
   * @param string $key
   */
  public function getTimestamp($key)
  {

    // if theres no i18n fetch the default
    $i18n = $this->getI18n();

    if (isset($this->data[$key]))
      return $i18n->timestamp($this->data[$key]);
    else
      return null;

  }//end public function getTimestamp */

  /**
   * @param string $key
   */
  public function getChecked($key)
  {

    if (isset($this->data[$key]) && $this->data[$key]  )
      return ' checked="checked" ';
    else
      return '';

  }//end public function getChecked */

  /**
   * add or overwrite data in the dbo
   *
   * @param string $key Schlüsselname
   * @param string $value Die Daten
   *
   * @return bool
   * @throws LibDb_Exception
   */
  public function addData($key,  $value = null)
  {

    $this->synchronized = false;

    if (is_array($key)) {

      if (array_key_exists(Db::PK , $key)) {
        // set the id if not yet setted
        if (!$this->id && $key[Db::PK])
          $this->id = $key[Db::PK];

        unset($key[Db::PK]);
      }

      foreach ($key as $keyId => $tValue) {

        if (is_object($tValue)) {
          $tValue->setEntity($this);
          $this->postSave[] = $tValue;
        }

        $this->data[$keyId] = $tValue;
      }

      return true;

    } elseif (is_string($key) and $key != Db::PK  ) {

      if (is_object($value)) {
        $value->setEntity($this);
        $this->postSave[] = $value;
      }

      $this->data[$key] = $value;

      return true;

    }
    /*
    else if (is_object($key) and $key instanceof Entity  ) {
      $this->data = array_merge($this->data , $key->getData());

      if (isset($this->data[Db::PK]))
        unset($this->data[Db::PK]);

      return true;
    }
    */
    else {
      Error::report(
        I18n::s(
          'Got invalid data: {@data@}',
          'wbf.error',
          array(
            'data' => Debug::dumpToString(array($key,$value))
          )
        ),
        $key
      );

      return false;
    }

  } // end public function addData */

/*//////////////////////////////////////////////////////////////////////////////
// checks
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param string $value
   */
  public function bigger($key, $value)
  {
    ///TODO implement me
    return false;

  }//end public function bigger */

  /**
   * @param string $key
   * @param string $value
   */
  public function smaller($key, $value)
  {
    ///TODO implement me
    return false;

  }//end public function smaller */

/*//////////////////////////////////////////////////////////////////////////////
// clear and unload
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function clear()
  {

    $this->synchronized = true;
    $this->id           = null;
    $this->newId        = null;
    $this->data         = array();
    $this->savedData    = array();
    $this->singleRef    = array();
    $this->multiRef     = array();

  }//end public function clear */

  /**
   * kompletter dissconnect der entity
   * @return void
   */
  public function unload()
  {

    $this->synchronized = true;
    $this->id           = null;
    $this->newId        = null;
    $this->data         = array();
    $this->savedData    = array();
    $this->orm          = null;

    $this->singleRef    = array();
    $this->multiRef     = array();
    $this->i18n         = null;

  }//end public function clear */

}//end abstract class Entity */

