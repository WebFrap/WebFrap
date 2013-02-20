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
 * Abstrakte Klasse für Datenbankverbindungen
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class LibDbResult
  implements Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * database connection result
   * @var resource id
   */
  protected $result         = null;

  /**
   * @var LibDbConnection
   */
  protected $dbObject       = null;

  /**
   *
   * @var int
   */
  protected $fetchMode      = null;

  /**
   *
   * @var string
   */
  protected $name           = null;

  /**
   *
   * @var boolean
   */
  protected $single         = false;

  /**
   *
   * @var array
   */
  protected $row            = array();

  /**
   *
   * @var array
   */
  protected $pos            = 0;

  /**
   *
   * @var array
   */
  protected $numRows        = null;

  /**
   * @var int
   */
  protected $numFields     = null;

  /**
   * @var array
   */
  protected $data     = array();

  /**
   * Die Nummer der Query
   * @var int
   */
  public $numQuery = null;

  /**
   * Dauer der Query in sekunden
   * @var int
   */
  public $duration = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Default Constructor
   * creating the connection to the database
   *
   * @param LibDbResult $result
   * @param LibDbConnection $dbObject
   * @param string $name
   */
  public function __construct
  (
    $result,
    $dbObject,
    $name = 'tmp',
    $numQuery = -1,
    $duration = -1
  )
  {

    $this->result   = $result;
    $this->dbObject = $dbObject;
    $this->name     = $name;

    $this->numQuery = $numQuery;
    $this->duration = $duration;

    $this->pos      = 0;

  } // end public function __construct */

  /**
   * destructor
   *
   */
  public function __destruct()
  {
    // discconnect on destruct
    $this->freeResult();
  }//end public function __destruct

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * set at fetch mode for the database
   * @param  string $fetchMode
   * @return void
   */
  public function setFetchMode($fetchMode )
  {
    $this->fetchMode = $fetchMode;

  }//end public function setFetchMode

  /**
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }//end public function getName

  /**
   * @return array
   */
  public function get( )
  {
    return array();
  }//end public function getName

  /**
   * @return array
   */
  public function getAll()
  {
    return array();
  }//end public function getName

  /**
   *
   * @return string
   */
  public function load()
  {

  }//end public function getName

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return array
   */
  public function current()
  {
    return $this->row;
  }//end public function current ()

  /**
   *
   * @return int
   */
  public function key()
  {
    return $this->pos;
  }//end public function key ()

  /**
   *
   * Enter description here...
   * @return array
   */
  public function next()
  {
    return $this->get( );
  }//end public function next ()

  /**
   *
   * Enter description here...
   * @return unknown_type
   */
  public function rewind ()
  {
    $this->row = array();
    $this->pos = 0;
  }//end public function rewind ()

  /**
   * (non-PHPdoc)
   * @see src/lib/db/LibDbResult#valid()
   */
  public function valid ()
  {
    if ( 0 === $this->pos )
      $this->get();

    return !is_null($this->pos);
  }//end public function valid ()

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Zählen wieviele Einträge gefunden wurden
   * @return int
   */
  public function count()
  {
    return $this->getNumRows( );
  }//end public function count()

}//end abstract class LibDbResult

