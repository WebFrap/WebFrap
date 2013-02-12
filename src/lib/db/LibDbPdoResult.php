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
class LibDbPdoResult
  extends LibDbResult
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode  = PDO::FETCH_ASSOC;

  /**
   * @var PDOStatement
   */
  protected $result = null;

////////////////////////////////////////////////////////////////////////////////
// Special Queries
////////////////////////////////////////////////////////////////////////////////

  /**
   * delete a statement, is just an ugly compromise
   *
   * @param string $name the name of the statement to delete
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate( )
  {

    $this->dbObject->deallocate( $this->name  );

  } // end public function deallocate */

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery( $values = array()  )
  {

    $this->result->closeCursor();

    $pos = 1;

    foreach ($values as $value) {
      $this->result->bindValue($pos,$value);
      ++$pos;
    }

    return $this->result->execute();

  } // end public function executeQuery( $name,  $values = null, $returnIt = true, $single = false )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction( $values = array(), $getNewId = false )
  {
    $this->result->closeCursor();

    $pos = 1;

    foreach ($values as $value) {
      $this->result->bindValue($pos,$value);
      ++$pos;
    }

    return $this->result->execute();

  } // end public function executeAction */

  /**
   * Auslesen des letzten Abfrageergebnisses
   *
   * @return array
   */
  public function getAll( )
  {
    return $this->result->fetchAll( $this->fetchMode );
  } // end public function getAll */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function get( )
  {
    if ( !$this->row = $this->result->fetch( $this->fetchMode ) ) {
      $this->pos = null;

      return array();
    } else {
      ++ $this->pos;

      return $this->row;
    }

  } // end public function get */

  /**
   * Das Nächste Result Abfragen
   *
   * @param string $key
   * @return array
   */
  public function getColumnMeta( $key )
  {
    return $this->result->getColumnMeta( $key );

  } // end public function getColumnMeta */

  /**
   * Das Nächste Result Abfragen
   *
   * @param string $key
   * @return array
   */
  public function getField( $key )
  {

    if ( !$this->row = $this->result->fetch( $this->fetchMode ) ) {
      $this->pos = null;

      return null;
    } else {
      ++ $this->pos;

      return $this->row[$key];
    }

  } // end public function getField */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function getQSize( )
  {

    if( !$row = $this->result->fetch( $this->fetchMode ) )

      return 0;
    else
      return isset($row['size'])?$row['size']:0;

  } // end public function getQSize */

  /**
   * Das Result der letzten Afrage leeren
   */
  public function freeResult( )
  {

    $this->result->closeCursor();

    return true;

  } // end public function freeResult */

////////////////////////////////////////////////////////////////////////////////
// Getter for Query Metadata
////////////////////////////////////////////////////////////////////////////////

  /**
   * Die Numrows der Letzten Aktion abfragen
   *
   * @return int
   */
  public function getNumRows( )
  {
    return $this->result->rowCount();
  } // end public function getNumRows( )

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows( )
  {
    return $this->result->rowCount();

  } // end public function getAffectedRows */

} //end class LibDbPdoResult
