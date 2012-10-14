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
abstract class LibDbPdo
     extends LibDbConnection
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////


  /**
   * save the affeted rows from update or delete queries
   *
   * @var int
   */
  protected $affectedRows     = null;

  /**
   * save the affeted rows from update or delete queries
   *
   * @var int
   */
  protected $numRows     = null;

////////////////////////////////////////////////////////////////////////////////
// Application Logic
////////////////////////////////////////////////////////////////////////////////


    /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param String $sql Ein Aktion Object
   * @return boolean
   * @throws LibDb_Exception
   */
  public function update( $sql, $table = null , $pk = null, $id = null  )
  {

    ++$this->counter ;

    if( is_object( $sql ) )
    {
      if( !$sqlstring = $sql->buildUpdate() )
      {
        throw new LibDb_Exception
        (
          I18n::s('wbf.error.dbFailedToParseUpdateSql')
        );
      }

    }
    elseif( is_string($sql) )
    {
      $sqlstring = $sql;
    }
    elseif( is_array( $sql ) )
    {
      $sqlstring = $this->sqlBuilder->buildUpdate(  $sql, $table, $pk, $id  );
    }
    else
    {

      throw new LibDb_Exception
      (
        I18n::s('wbf.error.dbGotIncompatibleParameters')
      );
    }

    if(Log::$levelDebug)
      Log::debug( __file__ , __line__ , 'SQL:  '.$sqlstring  );

    $this->lastQuery = $sqlstring;

    $this->affectedRows = $this->connection->exec( $sqlstring );

    if( $this->affectedRows === false  )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        'Query Error: '.$this->extractPdoError()
      );
    }

    return $this->affectedRows;

  } // end public function update( $sql  )

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param mixed $sql
   * @return int
   * @throws LibDb_Exception
   */
  public function delete( $sql , $table = null, $pk = null )
  {

    ++$this->counter ;

    if( is_object( $sql ) )
    {
      if( !$sqlstring = $sql->buildDelete() )
      {

        throw new LibDb_Exception
        (
          'Aus dem Sql Object konnte kein Sql generiert werden'
        );
      }
    }
    elseif( is_numeric( $sql ) )
    {
      $sqlstring = $this->sqlBuilder->buildDelete( $table, $pk, $sql );
    }
    elseif( is_string($sql)  )
    {
      $sqlstring = $sql;
    }
    else
    {
      throw new LibDb_Exception
      (
        'Datenbank delete() hat inkompatible Parameter bekommen'
      );
    }

    $this->lastQuery = $sqlstring;

    $this->affectedRows = $this->connection->exec( $sqlstring );

    if( $this->affectedRows === false )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        'Query Error: '.$this->extractPdoError()
      );
    }

    return $this->affectedRows;

  } // end public function delete( $sql )


  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   * @throws LibDb_Exception
   */
  public function prepareSelect( $name,  $sqlstring = null )
  {

    ++$this->counter ;

    if( is_object($name) )
    {
      $this->activObject = $name;

      if(  !$sqlstring = $this->activObject->getSql() )
      {
        if( !$sqlstring = $this->activObject->buildSelect() )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif( trim($name) == '' or trim($sqlstring) == '' )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbIncopatibleParameters')
      );
    }


    if(Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if( !$this->result = $this->connection->prepare( $sqlstring ) )
    {
      throw new LibDb_Exception
      (
        'Query Error: '.$this->extractPdoError()
      );
    }

    $this->prepares[$name] = $this->result;

    $this->result = null;


  } // end public function prepareSelect( $name,  $sqlstring = null )

  /**
   * Ein Insert Statement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return int
   */
  public function prepareInsert( $name,  $sqlstring = null )
  {

    ++$this->counter ;

    if( is_object($name) )
    {
      $this->activObject = $name;

      if(  !$sqlstring = $this->activObject->getSql() )
      {
        if( !$sqlstring = $this->activObject->buildInsert( true ) )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif( trim($name) == '' or trim($sqlstring) == '' )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbIncopatibleParameters')
      );
    }


    if(Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if( !$this->result = $this->connection->prepare( $sqlstring ) )
    {
      throw new LibDb_Exception
      (
        'Query Error: '.$this->extractPdoError()
      );
    }

    $this->prepares[$name] = $this->result;
    $this->result = null;

  } // end public function prepareInsert( $name,  $sqlstring = null )

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @param boolean Send
   * @return int
   */
  public function prepareUpdate( $name,  $sqlstring = null )
  {

    ++$this->counter ;

    if( is_object($name) )
    {
      $this->activObject = $name;

      if(  !$sqlstring = $this->activObject->getSql() )
      {
        if( !$sqlstring = $this->activObject->buildUpdate( true ) )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif( trim($name) == '' or trim($sqlstring) == '' )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbIncopatibleParameters')
      );
    }


    if(Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if( !$this->result = $this->connection->prepare( $sqlstring ) )
    {
      throw new LibDb_Exception
      (
        'Query Error: '.$this->extractPdoError()
      );
    }

    $this->prepares[$name] = $this->result;
    $this->result = null;

  } // end public function prepareUpdate( $name,  $sqlstring = null )

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param string $name
   * @param string $sqlstring
   * @return
   */
  public function prepareDelete( $name,  $sqlstring = null  )
  {


    ++$this->counter ;

    if( is_object($name) )
    {
      $this->activObject = $name;

      if(  !$sqlstring = $this->activObject->getSql() )
      {
        if( !$sqlstring = $this->activObject->buildDelete( ) )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif( trim($name) == '' or trim($sqlstring) == '' )
    {
       // Fehlermeldung raus und gleich mal nen Trace laufen lassen
       throw new LibDb_Exception
       (
         I18n::s('wbf.log.dbIncopatibleParameters')
       );
    }

    if(Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if( !$this->result = $this->connection->prepare( $sqlstring ) )
    {
      throw new LibDb_Exception
      (
        'Query Error: '.$this->extractPdoError()
      );
    }

    $this->prepares[$name] = $this->result;
    $this->result = null;

  } // end public function prepareDelete( $name,  $sqlstring = null  )


  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery( $name,  $values = null, $returnIt = true, $single = false )
  {

    if( is_object($name) )
    {
      $obj      = $name;
      $name     = $obj->getName();
      $values   = $obj->getPrepareValues();
      $single   = $obj->getSingelRow();
    }

    if(Log::$levelTrace)
      Debug::logDump( 'Values for execute: '.$name , $values );

    if( !$this->result = pg_execute( $this->connectionRead, $name, $values ) )
    {
      throw new LibDb_Exception
      (
        'Konnte Execute nicht ausführen: '.pg_last_error()
      );
    }

    if( $returnIt )
    {

      if( !$ergebnis = pg_fetch_all( $this->result ) )
      {
        if(Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Got no Result'  );

        return array();
      }

      if( $single )
      {
        if(Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned SingelRow'  );

        return $ergebnis[0];
      }
      else
      {
        if(Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned MultiRow'  );

        return $ergebnis;
      }
    }
    else
    {
      return true;
    }

  } // end public function executeQuery( $name,  $values = null, $returnIt = true, $single = false )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction( $name,  $values = null, $getNewId = false )
  {

    if( is_object($name) )
    {
      $obj      = $name;
      $name     = $obj->getName();
      $values   = $obj->getPrepareValues();
    }

    if( !$this->result = pg_execute( $this->connectionWrite, $name, $values ) )
    {
      throw new LibDb_Exception
      (
        'Konnte Execute nicht ausführen: '.pg_last_error()
      );
    }

    if( $getNewId or $this->activObject->getNewid() )
    {
      $table = $this->activObject->getTable( );
      if( !$this->result = pg_query
      (
      $this->connection ,
      $sqlstring = 'select currval( \''.strtolower($table).'_'.strtolower($newid).'_seq\' )' )
      )
      {

        throw new LibDb_Exception
        (
          'Konnte die neue Id nicht abfragen'
        );

      }

      if (! $row = pg_fetch_assoc( $this->result ))
      {
        throw new LibDb_Exception
        (
          'Konnte die neue Id nicht lesen'
        );
      }

      return $row['currval'];
    }
    else
    {
      return pg_affected_rows( $this->result );
    }

  } // end of member function executeAction

  /**
   * delete a statement, is just an ugly compromise
   *
   * @param string $name the name of the statement to delete
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate( $name  )
  {

    if( isset( $this->prepares[$name] ) )
    {
      $this->prepares[$name]->closeCursor();
      unset($this->prepares[$name]);
    }

  } // end public function deallocate( $name )

  /**
   * a raw sql query
   *
   * @param   string $sql Pure Sql Query
   * @param   boolean $returnit Should be returned?
   * @param   boolean $single Is a single Row Query
   * @throws  LibDb_Exception
   * @return array
   */
  public function query( $sql, $returnit = true, $single = false )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql, $returnit, $single));

    $this->lastData = array();
    $this->numRows = null;
    $this->result = null;

    if( !$this->result = $this->connection->query( $sql ) )
    {
      throw new LibDb_Exception
      (
        'Query Failed: '. $this->extractPdoError()
      );
    }

    $this->lastData = $this->result->fetchAll( $this->fetchMode );
    $this->numRows = count($this->lastData);

    if( $returnit )
    {

      if( $single )
      {

        if( isset($this->lastData[0]) )
        {

          if(Log::$levelTrace)
            Debug::logDump('Single Row Query: '.$sql , $this->lastData[0] );

          return $this->lastData[0];
        }
      }
      else
      {
        if(Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned MultiRow'  );

        if(Log::$levelTrace)
          Debug::logDump('Multi Row Query: '.$sql , $this->lastData[0] );

        return $this->lastData[0];
      }
    }
    else
    {
      if(Log::$levelDebug)
        Log::debug( __file__ , __line__ , 'Returned NumRows: '.$this->numRows );

      return $this->numRows;
    }

  } // end public function query( $sql, $returnit = true, $single = false )

  /**
   *
   */
  public function exec( $sql  )
  {


    $this->lastData = array();
    $this->numRows  = null;
    $this->result   = null;

    if( !$this->result = $this->connection->exec( $sql ) )
    {
      Error::addError
      (
      'Query Failed: '. $this->extractPdoError() ,
      'LibDb_Exception'
      );
    }


  } // end public function exec( $sql, $returnit = true, $single = false )

  /**
   * execute a sql
   *
   * @param string $sql sql als string
   * @throws  LibDb_Exception
   * @return mixed
   */
  public function crud( $sql , $insertId = null , $table = null )
  {

    if( !$this->result = pg_query( $this->connectionWrite , $sql ) )
    {
      Error::addError
      (
      'Query Failed: '.pg_last_error( $this->connectionWrite ),
      'LibDb_Exception'
      );
    }

    if(!$insertId)
    {
      return pg_affected_rows( $this->result );
    }
    else
    {

      if
      ( !$this->result = pg_query
        (
        $this->connection ,
        'select currval( \''.strtolower($table).'_'.strtolower($insertId).'_seq\' )'
        )
      )
      {

        Error::addError
        (
        I18n::s('failed to get the new id from the sequence'),
        'LibDb_Exception'
        );

      }

      if (!$row = pg_fetch_assoc( $this->result ))
      {
        Error::addError
        (
        I18n::s('failed to get the new id from the sequence'),
        'LibDb_Exception'
        );
      }

      return $row['currval'];
    }

  } // end public function crud */

  /**
   * Enter description here...
   *
   * @param unknown_type $sql
   * @return unknown
   */
  public function ddlQuery( $sql )
  {
    if( !$this->connection->exec( $sql ) )
    {
      return $this->extractPdoError();
    }
    else
    {
      return false;
    }
  }//end public function ddlQuery( $sql )

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows( )
  {
    return $this->result->affectedRows;
  } // end public function getAffectedRows( )

  /**
   * get database notices
   * atm problems to geht notices from the pdo driver
   * @return string
   */
  public function getNotice( )
  {


    // no Notice availabe in pdo?
    return null;

  } // end public function getNotice( )

  /**
   * request the errormessage from the last query
   *
   * @return string
   */
  public function getError( )
  {

    return $this->extractPdoError();
  } // end public function getError( )

  /**
   * start a database transaction
   *
   * @return void
   */
  public function begin( $write = true )
  {


    $this->connection->beginTransaction();

  } // end public function begin( )

  /**
   * rollback a transaction
   *
   * @return void
   */
  public function rollback( $write = true  )
  {


    $this->connection->rollback();

  } // end public function rollback( )

  /**
   * end a successfull transaction
   *
   * @return void
   */
  public function commit( $write = true  )
  {


    $this->connection->commit();

  } // end public function commit( )

  /**
   * send a query to the database
   *
   * @return
   */
  public function logQuery( $sql )
  {
    $this->connection->exec( $sql );
  } // end public function logQuery( $sql )

  /**
   * Den Status des Results Checken
   *
   * @return
   */
  public function checkStatus( )
  {

    return true;

  } // end public function checkStatus( )

  /**
   * close the database connection
   *
   * @return void
   */
  public function dissconnect()
  {

    $this->connection = null;

  } // end public function dissconnect()

  /**
   * set the activ schema
   * we have stupid mysql, that knows no schema
   * @param string Schema Das aktive Schema
   * @return bool
   */
  public function setSearchPath( $schema )
  {

    $this->schema = $schema;

    return true;
  } // end public function setSearchPath( $schema )

  /**
   * add slashes
   *
   * @param res Sql Ein Select Object
   * @return
   */
  public function addSlashes( $value )
  {

    if( get_magic_quotes_gpc() )
    {
      $this->firstStripThenAddSlashes( $value );
    }
    else
    {
      if(is_array($value))
      {
        $tmp = array();
        foreach($value as $key => $data )
        {
          $tmp[$key] = $this->addSlashes( $data );
        }
        $value = $tmp;
      }else
      {
        $value = $this->connection->quote( $value);
      }
    }

    return $value;

  } // end public function addSlashes( $value )

  /**
   * first strip then add slashes
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function firstStripThenAddSlashes( $value )
  {

    if(is_array($value))
    {
      $tmp = array();
      foreach($value as $key => $data )
      {
        $tmp[$key] = $this->firstStripThenAddSlashes( $data );
      }
      $value = $tmp;
    }else
    {

      $value = $this->connection->quote(stripslashes($value));
    }

    return $value;

  } // end protected function firstStripThenAddSlashes( $value )

  /**
   * Enter description here...
   *
   * @param string $table the name of the table
   * @param array  $fields the fieldnames for the quotes
   */
  public function getQuotesData( $table , $fields = array() )
  {

    if( !isset($this->entityMeta[$table]) )
      $this->loadMetadata( $table );

    if(!$fields)
      return $this->entityMeta[$table];

    $tmp = array();

    foreach( $fields as $key => $value )
    {
      if( isset($this->entityMeta[$table][$key]) )
      {
        $tmp[$key] = $this->entityMeta[$table][$key][4];
      }
      else
      {
        Error::addError
        (
        I18n::s('wbf.log.noDataForConvertTableRow',array($table,$key)),
        'LibDb_Exception'
        );
      }
    }

    return $tmp;

  }//end public function getQuotesData( $table , $fields = array() )

  /**
   *
   * @param string $table
   * @param array $fields
   * @return array
   */
  public function getReferences( $table )
  {
    if( !isset($this->entityReferences[$table]) )
      $this->loadMetadata($table);

    return isset($this->entityReferences[$table])
      ?$this->entityReferences[$table]:array();

  }//end public function getReferences

  /**
   * extract the error messages from the pdo error array
   *
   * @param array $error
   * @return string
   */
  protected function extractPdoError( $error = array() )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($error));

    if(!$error)
    {
      $error = $this->connection->errorInfo();
    }

    if(isset($error[2]))
    {
      return $error[2];
    }
    if(isset($error[1]))
    {
      return $error[1];
    }
    return $error[0];

  }//end protected function extractPdoError( $error )

} //end class DbPdo

