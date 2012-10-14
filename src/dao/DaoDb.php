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
 * Data Access Objekts.
 * Ermöglicht den Zugriff auf belieige Daten
 * @package WebFrap
 * @subpackage tech_core
 */
class DaoDb
  extends Dao
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the database driver object
   *
   * @var LibDbConnection
   */
  protected $db = null;

  /** the collums of the table
   * @var array
   */
  public $cols = array();

  /** name of the table
   * @var string
   */
  public $table = null;

  /** name of the table
   * @var string
   */
  public $tablePk = WBF_DB_KEY;

  /**
   * @var string
   */
  protected $entityName = null;

  /**
   * @var array
   */
  protected $errorMessages = array();

  /**
   * @var array
   */
  protected $references = array();

  /**
   * @var boolean
   */
  protected $chinouFormat = true;

////////////////////////////////////////////////////////////////////////////////
// Magic Functions
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default constructor
   * @param LibDbConnection $db
   * @return void
   */
  public function __construct( LibDbConnection $db = null )
  {
    
    if( $db )
    {
      $this->db = $db;
    }
    else
    {
      // Die Standard Dao im Singleton Interface arbeitet immer mit der
      // Standard Datenverbindung
      // es können auch Über den Konstruktor Daos mit anderen Verbindungen
      // erstellt werden
      $this->db = Webfrap::$env->getDb();
    }

    $this->cols           = $this->db->getQuotesData( $this->table );
    $this->references     = $this->db->getReferences( $this->table );
    $this->errorMessages  = $this->db->getMessages( $this->table );

  }//end  public function __construct( $db = null )

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * Getter für die Cols
   *
   * @return array
   */
  public function getCols( )
  {
    return array_keys( $this->cols );
  } // end of member function getCols

  /**
   * Getter für die Cols
   *
   * @return array
   */
  public function getTable( )
  {
    return $this->table;
  } // end public function getTable( )

 /**
  * Getter für die Cols
  *
  * @return array
  */
  public function getTablePk( )
  {
    return $this->tablePk;
  } // end public function getTablePk( )

  /**
   *
   * @param array $keys
   */
  public function getValidationData( array $keys )
  {

    $data = array();

    foreach( $keys as $key )
    {
      if( !isset( $this->cols[$key] ) )
      {

        Debug::console( get_class($this).'::'.$key , $this->cols  );
        ///TODO add i18n
        throw new LibDb_Exception('asked for wrong Validation data: '.$key . ' in '.get_class($this));
      }
      else
      {
        $data[$key] = $this->cols[$key];
      }
    }

    return $data;

  }//end public function getValidationdata( $keys )

  /**
   * @param string $key
   * @return int
   */
  public function minSize( $key )
  {

    if( !isset( $this->cols[$key] ) )
    {
      Error::report
      (
      'asked for wrong Validation data: '.$key . ' in '.get_class($this)
      );

      return null;
    }

    return $this->cols[$key][3];

  }//end public function getMinSize( $key )

  /**
   * @param string $key
   * @return int
   */
  public function maxSize( $key )
  {

    if( !isset( $this->cols[$key] ) )
    {
      Error::report
      (
      'asked for wrong Validation data: '.$key . ' in '.get_class($this)
      );

      return null;
    }

    return $this->cols[$key][2];

  }//end public function getMaxSize( $key )

  /**
   * @param string $key
   * @return int
   */
  public function required( $key )
  {

    if( !isset( $this->cols[$key] ) )
    {
      Error::report
      (
      'asked for wrong Validation data: '.$key . ' in '.get_class($this)
      );

      return null;
    }

    return $this->cols[$key][1];

  }//end public function getMaxSize( $key )

  /**
   * request the quotes data for an object
   * @param array
   * @return arrayh
   */
  public function getQuotesdata( array $keys = array() )
  {
    return $this->db->getQuotesData($this->table,$keys);
  }//end public function getQuotesdata( $keys = array() )



////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////


  /**
   * get all dataset from a table
   *
   * @param array $cols
   * @param int $limit
   * @param int $offset
   * 
   * @return array/array<Entity>
   */
  public function getAll( array $cols = array('*') , $limit = null, $offset = null )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select($cols)->from($this->table);
    $criteria->orderBy($this->tablePk)->limit($limit)->offset($offset);

    return $this->fillObjects( $this->db->select( $criteria )->getAll() );

  }//end public function getAll */

  /**
   * get a row by id
   * @param int $id
   * @return Entity
   */
  public function get( $id  )
  {

    if( is_numeric($id) && $obj = $this->getFromPool($id) )
      return $obj;

    $criteria = $this->db->newCriteria();
    $criteria->select('*')->from($this->table);

    if( is_numeric($id) )
      $criteria->where($this->tablePk.' = '.$id);
    else
      $criteria->where($id);

    $data = $this->db->select($criteria)->get();

    if( !$data )
      return null;

    else
      return $this->fillObject($data);

  }//end public function get */

  /**
   * @param int $id
   * @param string $fieldName
   */
  public function getField( $id , $fieldName  )
  {

    if( is_numeric($id) && $obj = $this->getFromPool($id) )
      return $obj->getData($fieldName);

    $criteria = $this->db->newCriteria();
    $criteria->select('*')->from($this->table);

    if( is_numeric($id) )
      $criteria->where($this->tablePk.' = '.$id);
    else
      $criteria->where($id);

    $data = $this->db->select($criteria)->get();

    if( !$data )
      return null;

    else
      return $this->fillObject($data)->getData($fieldName);

  }//end public function getField */

  /**
   * get the Number of all Entries
   * @param string $where
   * @return array
   */
  public function countRows( $where = null  )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select('count('.$this->tablePk.')')->from($this->table)->where($where);

    $data = $this->db->select($criteria)->get();
    return $data['anz'];

  }//end public function countRows */

  /**
   * get
   * @param string $where
   * @param array() $cols
   * @param array() $limit
   * @param boolean $asObject
   * @return array
   */
  public function getWhere( $where, $cols = array('*') , $limit = null , $offset = null  )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select($cols)->from($this->table)->where($where);
    $criteria->orderBy($this->tablePk)->limit($limit)->offset($offset);

    return $this->fillObjects( $this->db->select( $criteria )->getAll() );

  }//end public function getWhere */

  /**
   *
   */
  public function getRows( $where, $cols = array('*') , $limit = null , $offset = null  )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select($cols)->from($this->table)->where($where);
    $criteria->orderBy($this->tablePk)->limit($limit)->offset($offset);

    return $this->db->select( $criteria )->getAll();

  }//end public function getRows */

  /**
   */
  public function getRow( $where, $cols = array('*') )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select($cols)->from($this->table)->where($where);

    return $this->db->select( $criteria )->get();

  }//end public function getRow */

  /**
   * Alle Ids von Datensätzen die eine übergebenen Bedingung entsprechen
   * erfragen
   * @return array
   */
  public function getIds(  $where = null )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select($this->tablePk)->from($this->table)->where($where)->oderBy($this->tablePk);

    return $this->select($criteria)->getAll();

  }//end public function getIds()

  /**
   * method for insert
   * @param Dbo/array
   * @return boolean
   */
  public function save( Entity $data )
  {

    if( $data->id and is_numeric( $data->id ) )
      return $this->update($data);

    else
      return $this->insert($data);

  }//end public function save( Entity $data )

  /**
   * method for insert
   * @param Entity
   * @return Entity
   */
  public function insert( $entity )
  {

    if( is_object($entity) and $entity instanceof Entity  )
    {

      if($entity->getSynchronized())
      {
        Log::warn('Tried to Insert a synchronized Object');
        return $entity;
      }

      $connected = $entity->getAllReferences();

      foreach( $connected as $key => $conEnt )
        $entity->$key = $conEnt->save();

      $keyVal = $entity->getData();

    }
    else
    {
      $keyVal = $entity;
    }

    $keyVal = $this->preInsert( $keyVal );

    try
    {

      if( $this->chinouFormat )
      {
        $keyVal['m_version'] = '1';
        $keyVal['m_role_create']  = User::getActive()->getId();
        $keyVal['m_time_created'] = SDate::getTimestamp('Y-m-d h:i:s');

        if(array_key_exists( WBF_DB_KEY, $keyVal ))
          unset($keyVal[WBF_DB_KEY]);

      }

      if( !$newid = $this->db->insert( $keyVal , $this->table , $this->tablePk ) )
      {
        Error::report
        (
        'Der Insert hat keine Id geliefert'
        );
        return null;
      }

    }
    catch( LibDb_Exception $exc )
    {
      return null;
    }

    $this->postInsert( $keyVal );

    $entity->synchronized();

    if( is_object($entity) )
    {
      $entity->setId($newid);
      $this->addToPool( $newid ,$entity );
      return $entity;
    }
    else
    {
      $entity[$this->tablePk] = $newid;
      return $this->fillObject($entity);
    }


  }//end public function insert( $data = null )


  protected function preInsert( $entiy ){ return $entiy; }
  protected function postInsert( $entiy ){ }

  /**
   * method for insert
   * @param Dbo/array
   * @return boolean
   */
  public function update( $entity , $id = null )
  {

    if( is_object($entity) and $entity instanceof Entity  )
    {

      if($entity->getSynchronized())
        return $entity;

      $connected = $entity->getAllReferences();

      foreach( $connected as $key => $conEnt )
        $entity->$key = $conEnt->save();

      $id     = $entity->getId();
      $this->addToPool( $id, $entity );

      ++$entity->m_version;

      $keyVal = $entity->getData();
    }
    else
    {
      // muss ein array sein
      $keyVal = $entity;

      if( !$id )
        return null;
    }

    $keyVal = $this->preUpdate( $id , $keyVal );

    try
    {
      if(isset($keyVal[WBF_DB_KEY]))
        unset($keyVal[WBF_DB_KEY]);

      if( !$this->db->update( $keyVal , $this->table , $this->tablePk , $id ) )
      {
        Error::report('Failed to update Entity');
        return null;
      }

    }
    catch( LibDb_Exception $exc )
    {
      return null;
    }

    $this->postUpdate( $id , $keyVal );

    $entity->synchronized();

    if( is_object($entity) )
    {
      return $entity;
    }
    else
    {
      $data[$this->tablePk] = $id;
      return $this->fillObject($data);
    }


  }//end public function update( $data , $id = null )

  protected function preUpdate( $id, $entiy ){return $entiy;}
  protected function postUpdate( $id, $entiy ){ }

  /**
   * method for insert
   * @param Entity/array
   * @return boolean
   */
  public function delete( $id  )
  {

    $entity = null;

    if( is_object($id) and $id instanceof Entity  )
    {
      ///TODO validieren ob die entity hier nochmal gebraucht werden könnte
      $entity = $id;
      $id = $entity->getId();
    }
    else
    {
      $entity = $this->get($id);
    }

    $this->preDelete($id);

    // Prüfen aller Referenzen um rekursiv löschen zu können

    foreach( $this->references as $attribute => $ref )
    {

      if( $attribute == WBF_DB_KEY )
      {
        //array( 'type' => 'oneToOne', 'entity' => 'CorePeople' , 'refId' => WBF_DB_KEY , 'delete' => true ),
        foreach( $ref as $conRef )
        {
          if(!$conRef['delete'])
            continue;

          $this->deleteRefWhere( $conRef['entity'] , $conRef['refId'].' = '.$id );

        }
      }
      else
      {
        if(!$ref['delete'])
          continue;

        if( !$entity->$attribute )
          continue;

        // Rekursives Löschen
        $this->deleteRefWhere( $ref['entity'] , $ref['refId'].' = '.$entity->$attribute );
      }

    }

    try
    {

      if( !$this->db->delete( $id , $this->table, $this->tablePk  ) )
      {
        Error::report('Failed to delete Entity');
        return false;
      }

    }
    catch( LibDb_Exception $exc )
    {
      return false;
    }

    $this->postDelete( $id );

    $this->removeFromPool($id);
    return true;

  }//end public function delete( $id  )

  protected function preDelete( $id  ){ }
  protected function postDelete( $id  ){ }

  /**
   * methode zum löschen von Datensätzen
   * @param Dbo/array
   * @return boolean
   */
  public function deleteWhere( $where  )
  {

    $criteria = $this->db->newCriteria();
    $criteria->select(WBF_DB_KEY)->from($this->table)->where($where);

    $result = $this->db->select($criteria)->getAll();

    foreach( $result as $todel )
      $this->delete($todel[WBF_DB_KEY]);

  }//end public function deleteWhere

  /**
   * methode zum löschen von Datensätzen
   * @param Dbo/array
   * @return boolean
   */
  public function deleteRefWhere( $entityName ,  $where  )
  {

    $daoName = 'Dao'.$entityName;

    if( Webfrap::classLoadable($daoName) )
    {
      $dao = call_user_func( array($daoName,'getInstance') );
      $dao->deleteWhere( $where );
    }

  }//end public function deleteWhere

  /**
   *
   * @param $data
   * @return unknown_type
   */
  public function newEntity( )
  {

    $name = $this->entityName;
    $entity = new $name( );

    return $entity;

  }//end public function newEntity

////////////////////////////////////////////////////////////////////////////////
// protected inner Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Zusammenbauen des Limit und Offset Teils der Query
   *
   * @param string $limit
   * @return String
   */
  protected function buildLimits( $limit , $offset )
  {

    $sql = '';

    if( $limit )
      $sql .= ' LIMIT '.$limit;

    if(isset( $offset ))
      $sql .= ' OFFSET '.$offset;

    return $sql;

  }//end protected function buildLimits

  /**
   * IN SQL Condition anhand eines arrays von IDs zusammenbauen
   *
   * @param array $ids
   * @return string
   */
  protected function buildWhereIds( array $ids)
  {

    $sql = ' '.$this->tablePk.' IN( '.implode(',',$ids).' )';
    
    return $sql;

  }//end protected function buildWhereIds

  /**
   * build the where conditions to a and linked where condition sql string
   *
   * @param array $cond
   * @return string
   */
  protected function buildWhere( array $cond )
  {
    
    return implode( ' ', $cond);
    
  }//end protected function buildWhere

  /**
   * build the where conditions to a and linked where condition sql string
   *
   * @param array $cond
   * @return string
   */
  protected function buildCheckWhere( $cond )
  {

    $sql = '';

    // if we have no exists condition we create
    if(!$this->existCondition)
      return null;

    $tmp = array();

    foreach( $this->existCondition as $tpKey )
      if( isset( $cond[$tpKey] )  )
        $tmp[$tpKey] = $cond[$tpKey];

    // If we have no matchable data we can't check
    // if this happens, you got maybee big bullshit and forgot to validate
    if(!$tmp)
      return null;

    $cond = $this->db->convertData( $this->table , $tmp );

    //  assembly the key's and values with and
    foreach( $cond as $key => $field )
    {

      if( $field == 'null' )
        $sql .= ' '.$key.' is null and ';

      else
        $sql .= ' '.$key.' = '.$field.' and ';
    }

    // return without the last and
    return substr( $sql , 0 , -4).')';

  }//end protected function buildCheckWhere

  /**
   * Einen Leere Datensatz für eine Entity erzeugen.
   * Es wird ein Array mit Key Value Paaren erzeugt in dem alle Values leer sind
   *
   * @return array<string:null>
   */
  protected function buildEmptyResult()
  {

    $result = array();

    foreach( $this->cols as $col )
      $result[$col] = null;

    return $result;

  }//end protected function buildEmptyResult

  /**
   * Das Datenbank Result in Entity Objekte packen
   *
   * @param array $datas
   * @return array
   */
  protected function fillObjects( $datas )
  {

    $pool = array();

    foreach( $datas as $data )
    {
      $id = $data[$this->tablePk];

      $entity = new $this->entityName();
      $entity->addData($data);
      $entity->setId($id);

      $this->addToPool($id,$entity);
      $pool[$id] = $entity;
    }

    return $pool;

  }//end protected function fillObjects */

  /**
   * Einen Datensatz in Arrayform in ein Passendes Entity Objekt packen
   * 
   * @param $data
   * @return Entity
   */
  protected function fillObject( $data )
  {

    $id = $data[$this->tablePk];

    $name = $this->entityName;
    $entity = new $name( $id , $data );
    $this->addToPool($id,$entity);

    return $entity;

  }//end protected function fillObject */


////////////////////////////////////////////////////////////////////////////////
// EX DBO CRUD Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Eine Entity erstellen
   *
   * @return Entity
   */
  public function create()
  {

    // no action if we have no data
    if(!$this->data)
      return true;

      
    try
    {

      $insert = $this->db->newQuery( $this->table.'Insert' );
      $insert->setTable( $this->table );
      $insert->setNewid( $this->tablePk );

      if( $this->chinouFormat )
      {
        $this->data['m_version'] = '1';
        $this->data['m_creator'] = User::getActive()->getId();
        $this->data['m_created'] = SDate::getTimestamp('Y-m-d h:i:s');
      }

      $insert->setValues( $this->data );

      if( !$this->db->create( $insert ) )
      {
        Error::report
        (
        'Failed to Create'
        );
        return null;
      }

    }
    catch( LibDb_Exception $exc )
    {
      return null;
    }

    return $this->data[WBF_DB_KEY];

  }//end public function create

  /**
   *
   * @return void
   */
  public function loadMessages()
  {

  }//end public function loadMessages

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param array $keys
   */
  public function getErrorMessages( $keys )
  {

    $data = array();

    foreach( $keys as $key )
    {
      if(isset( $this->errorMessages[$key] ) )
      {
        $data[$key] = $this->errorMessages[$key];
      }
      else
      {
        Log::warn
        (
        __file__,__line__,
        I18n::s( 'no error messages for: '.$key, 'wbf.log.messageNotExists',array($key) )
        );
      }
    }

    return $data;

  }//end public function getErrorMessages

}//end class Dao

