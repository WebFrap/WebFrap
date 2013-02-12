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
 * @package WebFrapUnit
 * @subpackage tech_core
 */
class LibTestDataContainer
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Das Datenbank Objekt der Test Verbindung
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * Das ORM Objekt
   * @var LibDbOrm
   */
  protected $orm = null;

  /**
   * Pool mit den Entities
   * @var array<Entity>
   */
  protected $pool = array();

////////////////////////////////////////////////////////////////////////////////
// Static Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  protected static $actualDate = null;

  /**
   * @var string
   */
  protected static $actualTimestamp = null;

  /**
   * @var string
   */
  protected static $actualTime = null;

  /**
   * @var string
   */
  protected static $actualUnixts = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibDbConnection $db
   */
  public function __construct( $db )
  {

    $this->db   = $db;
    $this->orm  = $db->getOrm();

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// getter + setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $key
   * @return Entity
   */
  public function getRefObject( $key )
  {

    if( !$this->pool )

      return null;

    $poolSize = count( $this->pool );

    // mit modulo sicher stellen, dass egal bei welchem key immer ein object gefunden wird
    // so lange
    return $this->pool[($key%$poolSize)];

  }//end public function getRefObject */

////////////////////////////////////////////////////////////////////////////////
// Static Getter for default data
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $pos
   * @return string
   */
  public static function getActualDate( $pos = null )
  {

    if (!$pos) {
      $add = 0;
    } else {
      $add = 24 * 60 * 60 * $pos;
    }

    if( !self::$actualUnixts )
      self::$actualUnixts = time();

    if( !self::$actualDate )
      self::$actualDate = date( 'Y-m-d', self::$actualUnixts + $add  );

    return self::$actualDate;

  }//end public static function getActualDate */

  /**
   * @param int $pos
   * @return string
   */
  public static function getActualTimestamp( $pos = null )
  {

    if (!$pos) {
      $add = 0;
    } else {
      $add = 24 * 60 * 60 * $pos;
    }

    if( !self::$actualUnixts )
      self::$actualUnixts = time();

    if( !self::$actualTimestamp )
      self::$actualTimestamp = date( 'Y-m-d H:i:s', (self::$actualUnixts + $add)  );

    return self::$actualTimestamp;

  }//end public static function getActualTimestamp */

  /**
   * @param int $pos
   * @return string
   */
  public static function getActualTime( $pos = null )
  {

    if (!$pos) {
      $add = 0;
    } else {
      $add = 60 * 60 * $pos;
    }

    if( !self::$actualUnixts )
      self::$actualUnixts = time();

    if( !self::$actualTime )
      self::$actualTime = date( 'H:i:s', (self::$actualUnixts + $add) );

    return self::$actualTime;

  }//end public static function getActualTime */

////////////////////////////////////////////////////////////////////////////////
// Populate Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * Methode zum befüllen der Datebank mit Testdaten
   */
  public function populate()
  {

  }//end public function populate */

  /**
   * Methode zum befüllen der Datebank mit Testdaten
   */
  public function populateAsReference()
  {

  }//end public function populateAsReference */

} //end class LibTestDataContainer
