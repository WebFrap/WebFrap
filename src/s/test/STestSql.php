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
final class STestSql
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct() {}

  /** Funktion zum testen was für einen Art SQL String man vor sich hat
   *
   * @param string PotFolder Die potentielle Pfadangabe
   * @return array

   */
  public static function guesType($sqlString , $dbType)
  {

    switch ($dbType) {
      case 'postgresql':
      {
        return self::guesTypePostgresql($sqlString);
        break;
      }

      case 'mysql':
      {
        return self::guesTypeMysql($sqlString);
        break;
      }

      default:
      {
        return false;
      }
    }

  } // end of member function GuesType

  /** Funktion zum testen was für einen Art SQL String man vor sich hat
   *
   * @param string PotFolder Die potentielle Pfadangabe
   * @return array
   */
  public static function guesTypePostgresql($sqlString)
  {

    $types = array(array('SELECT INTO', 'DDL'), // define a new table from the results of a query

                    array('SELECT', 'SEL'), // retrieve rows from a table or view
                    array('UPDATE', 'DML'), // update rows of a table
                    array('INSERT', 'DML'), // create new rows in a table
                    array('DELETE', 'DML'), // delete rows of a table

                    array('CREATE' ,   'DDL'), // erstellen von Objekten
                    array('ALTER' ,    'DDL'), // ändern eines Objektes
                    array('REVOKE',    'DDL'), // remove access privileges
                    array('GRANT',     'DDL'), // define access privileges
                    array('TRUNCATE',  'DDL'), // empty a table or set of tables
                    array('SET',       'SQL'), // change a run-time parameter
                    array('DROP',      'DDL'), // löschen von Objekten

                    array('BEGIN' ,    'SQL'),  //start a transaction block
                    array('COMMIT' ,   'SQL'), //commit the current transaction
                    array('ROLLBACK',  'SQL'), // abort the current transaction

                    array('PREPARE',   'SQL'), // prepare a statement for execution
                    array('EXECUTE',   'SQL'), // execute a prepared statement
                    array('DEALLOCATE','SQL'), // deallocate a prepared statement
                    array('EXPLAIN',   'SEL'), // show the execution plan of a statement

                    array('ABORT' ,    'SQL'),
                    array('ANALYZE' ,  'SQL'), //collect statistics about a database
                    array('CHECKPOINT','SQL'), //force a transaction log checkpoint
                    array('CLOSE' ,    'SQL'), //close a cursor
                    array('CLUSTER' ,  'SQL'), //cluster a table according to an index
                    array('COMMENT' ,  'SQL'), //define or change the comment of an object
                    array('COPY' ,     'DDL'), // copy data between a file and a table
                    array('DECLARE',   'SQL'), // define a cursor
                    array('END',       'SQL'), // commit the current transaction
                    array('FETCH',     'SQL'), // retrieve rows from a query using a cursor
                    array('LISTEN',    'SQL'), // listen for a notification
                    array('LOAD',      'SQL'), // load or reload a shared library file
                    array('LOCK',      'SQL'), // lock a table
                    array('MOVE',      'SQL'), // position a cursor
                    array('NOTIFY',    'SQL'), // generate a notification
                    array('REINDEX',   'DDL'), // rebuild indexes
                    array('RELEASE',   'SQL'), //
                    array('RESET',     'SQL'), // restore the value of a run-time parameter to the default value
                    array('SAVEPOINT', 'SQL'), // define a new savepoint within the current transaction
                    array('SHOW',      'SEL'), // show the value of a run-time parameter
                    array('START',     'SQL'), // start a transaction block
                    array('UNLISTEN',  'SQL'), // stop listening for a notification
                    array('VACUUM',    'SQL') // garbage-collect and optionally analyze a database
                  );

    foreach ($types as $type) {
      $strlen = strlen($type[0]);

      if (strtoupper(substr(trim($sqlString) , 0 , $strlen)) == $type[0]  ) {
        return $type[1];
      }
    }

    return 'SQL';

  } // end  public static function guesTypePostgresql($sqlString)

  /** Funktion zum testen was für einen Art SQL String man vor sich hat
   *
   * @param string PotFolder Die potentielle Pfadangabe
   * @return array
   */
  public static function guesTypeMysql($sqlString)
  {

    $types = array(array('SELECT INTO', 'DDL'), // define a new table from the results of a query

                    array('SELECT', 'SEL'), // retrieve rows from a table or view
                    array('UPDATE', 'DML'), // update rows of a table
                    array('INSERT', 'DML'), // create new rows in a table
                    array('DELETE', 'DML'), // delete rows of a table

                    array('CREATE' ,   'DDL'), // erstellen von Objekten
                    array('ALTER' ,    'DDL'), // ändern eines Objektes
                    array('REVOKE',    'DDL'), // remove access privileges
                    array('GRANT',     'DDL'), // define access privileges
                    array('TRUNCATE',  'DDL'), // empty a table or set of tables
                    array('SET',       'SQL'), // change a run-time parameter
                    array('DROP',      'DDL'), // löschen von Objekten

                    array('BEGIN' ,    'SQL'),  //start a transaction block
                    array('COMMIT' ,   'SQL'), //commit the current transaction
                    array('ROLLBACK',  'SQL'), // abort the current transaction

                    array('PREPARE',   'SQL'), // prepare a statement for execution
                    array('EXECUTE',   'SQL'), // execute a prepared statement
                    array('DEALLOCATE','SQL'), // deallocate a prepared statement
                    array('EXPLAIN',   'SEL'), // show the execution plan of a statement

                    array('ABORT' ,    'SQL'),
                    array('ANALYZE' ,  'SQL'), //collect statistics about a database
                    array('CHECKPOINT','SQL'), //force a transaction log checkpoint
                    array('CLOSE' ,    'SQL'), //close a cursor
                    array('CLUSTER' ,  'SQL'), //cluster a table according to an index
                    array('COMMENT' ,  'SQL'), //define or change the comment of an object
                    array('COPY' ,     'DDL'), // copy data between a file and a table
                    array('DECLARE',   'SQL'), // define a cursor
                    array('END',       'SQL'), // commit the current transaction
                    array('FETCH',     'SQL'), // retrieve rows from a query using a cursor
                    array('LISTEN',    'SQL'), // listen for a notification
                    array('LOAD',      'SQL'), // load or reload a shared library file
                    array('LOCK',      'SQL'), // lock a table
                    array('MOVE',      'SQL'), // position a cursor
                    array('NOTIFY',    'SQL'), // generate a notification
                    array('REINDEX',   'DDL'), // rebuild indexes
                    array('RELEASE',   'SQL'), //
                    array('RESET',     'SQL'), // restore the value of a run-time parameter to the default value
                    array('SAVEPOINT', 'SQL'), // define a new savepoint within the current transaction
                    array('SHOW',      'SEL'), // show the value of a run-time parameter
                    array('START',     'SQL'), // start a transaction block
                    array('UNLISTEN',  'SQL'), // stop listening for a notification
                    array('VACUUM',    'SQL') // garbage-collect and optionally analyze a database
                  );

    foreach ($types as $type) {
      $strlen = strlen($type[0]);

      if (strtoupper(substr(trim($sqlString) , 0 , $strlen)) == $type[0]  ) {
        return $type[1];
      }
    }

    return 'SQL';

  } // end  public static function guesTypePostgresql($sqlString)

  /**
   * @param string $sql
   * @return boolean
   */
  public static function isSelectQuery($sql)
  {
    return true;
  }// public function isSelectQuery

  /**
   * @param string $sql
   * @return boolean
   */
  public static function isInsertQuery($sql)
  {
    return true;
  }//end public static function isInsertQuery($sql)

  /**
   * @param string $sql
   * @return boolean
   *
   */
  public static function isUpdateQuery($sql)
  {
    return true;
  }//end public static function isUpdateQuery($sql)

  /**
   * @param string $sql
   * @return boolean
   */
  public static function isDeleteQuery($sql)
  {
    return true;
  }//end public static function isDeleteQuery($sql)

} // end final class STestSql

