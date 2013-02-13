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
class LibDbEmptyResult
  extends LibDbResult
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode  = PGSQL_ASSOC;

/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc      = PGSQL_ASSOC;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum        = PGSQL_NUM;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth       = PGSQL_BOTH;


/*//////////////////////////////////////////////////////////////////////////////
// Special Queries
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * 
   */
  public function __construct()
  {
    
  }
  

  /**
   * Löschen eines Ausführplans in der Datenbank
   *
   * @param string Name Name der Abfrage die gelöscht werden soll
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate( )
  {

  }// end public function deallocate( )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery( $values = array() )
  {
    return array();
  }// end public function executeQuery( $values = array() )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction( $values = array(), $getNewId = false )
  {
    return null;
  }// end public function executeAction( $values = array(), $getNewId = false )


  /**
   * Auslesen des letzten Abfrageergebnisses
   *
   * @param int $Mode
   * @return array
   */
  public function getAll( )
  {

    return array();

  }// end public function getAll( $mode = null )

  /**
   * Alle Felder einer Column auslesen
   *
   * @param string $colName
   * @return array
   */
  public function getColumn( $colName )
  {

    return array();

  }// end public function getColumn */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function get( )
  {

    return array();

  }// end public function get */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function getField( $key )
  {

    return null;

  }// end public function getField */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function load( )
  {

  }// end public function load */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function getQSize( )
  {
    return 0;
  }// end public function getRow */

  /**
   * Das Result der letzten Afrage leeren
   */
  public function freeResult( )
  {
    return true;
  }// end public function clearResult */

/*//////////////////////////////////////////////////////////////////////////////
// Getter for Query Metadata
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Numrows der Letzten Aktion abfragen
   *
   * @return int
   */
  public function getNumRows( )
  {
    return 0;
  }// end public function getNumRows */

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows( )
  {
    return 0;
  }// end public function getAffectedRows */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return array
   */
  public function current()
  {
    return null;
  }//end public function current ()

  /**
   *
   * @return int
   */
  public function key()
  {
    return null;
  }//end public function key ()

  /**
   * @return array
   */
  public function next()
  {
    return null;
  }//end public function next ()

  /**
   *
   * @return null
   */
  public function rewind ()
  {
  }//end public function rewind ()

  /**
   * (non-PHPdoc)
   * @see src/lib/db/LibDbResult#valid()
   */
  public function valid ()
  {
    return false;
  }//end public function valid ()

} //end class LibDbPostgresqlResult

