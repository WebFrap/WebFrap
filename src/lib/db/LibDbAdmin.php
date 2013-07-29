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
 * @subpackage ModDeveloper
 */
class LibDbAdmin
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * @var string
  */
  const COL_NAME       = 'col_name';

  /**
  * @var string
  */
  const COL_DEFAULT    = 'col_default';

  /**
  * @var string
  */
  const COL_NULL_ABLE  = 'col_null_able';

  /**
  * @var string
  */
  const COL_TYPE       = 'col_type';

  /**
  * @var string
  */
  const COL_LENGTH     = 'col_length';

  /**
  * @var string
  */
  const COL_PRECISION  = 'col_precision';

  /**
  * @var string
  */
  const COL_SCALE      = 'col_scale';

  /**
  * @var string
  */
  const INDEX_TYPE      = 'index';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibDbConnection
   */
  protected $db         = null;

  /**
   *
   * @var string
   */
  protected $dbName     = null;

  /**
   *
   * @var string
   */
  protected $schemaName = null;

  /**
   *
   * @var string
   */
  protected $tableName  = null;

  /**
   *
   * @var string
   */
  protected $owner      = null;

  /**
   * @var boolean flag
   * if this this flag is true, the system creates a patch
   */
  protected $createPatch = false;

  /**
   * the sql patch string with all changes for the database
   * @var string
   */
  protected $sqlPatch   = '';

  /**
   * @var boolean flag
   * if this this flag is true, the database will be synced
   */
  protected $syncDb     = true;

  /**
   * if false all tables just use one single sequence
   * @var boolean
   */
  protected $muliSeq    = false;

  /**
   *
   * @var array<LibDbAdmin(*)>
   */
  private static $metaPool = array();

/*//////////////////////////////////////////////////////////////////////////////
// mapp data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array<string:string>
   */
  public $nameMapping = array();

  /**
   *
   * @var array
   */
  public $invertMapping   = array();

  /**
   *
   * @var array<string>
   */
  public $multiple = array();

  /**
   * @var array<string:string>
   */
  public $quotesMap = array();

  /**
   *
   * @var array<string:string>
  */
  public $typeValidMap  = array(
    'boolean'   => 'boolean'  ,
    'bytea'     => 'bytea'  ,
    'integer'   => 'int'      ,
    'int2'      => 'smallint' ,
    'smallint'  => 'smallint' ,
    'bigint'    => 'bigint' ,
    'int8'      => 'bigint' ,
    'numeric'   => 'numeric'  ,
    'text'      => 'text'     ,
    'varchar'   => 'text'     ,
    'char'      => 'text'     ,
    'date'      => 'date'     ,
    'time'      => 'time'     ,
    'timestamp' => 'timestamp',
    'uuid'      => 'uuid'     ,
  );

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $type
   * @return LibDbAdmin
   */
  public static function getInstance($type = null)
  {

    if (!$type) {

    	if (!isset(self::$metaPool['parent']))
        self::$metaPool['parent'] = new LibDbAdmin();

      return self::$metaPool['parent'];

    } else {

      $type = ucfirst($type);

      if (!isset(self::$metaPool[$type])) {
        $className = 'LibDbAdmin'.$type;
        self::$metaPool[$type] = new $className();
      }

      return self::$metaPool[$type];
    }

  }//end public static function getInstance */

  /**
   * @param LibDbConnection $db
   */
  public function __construct($db = null)
  {

    if ($db) {
      $this->db           = $db;

      $this->dbName       = $db->getDatabaseName();
      $this->schemaName   = $db->getSchemaName();
    }

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Getter && Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $dbName
   * @return void
   */
  public function setDbName($dbName)
  {
    $this->dbName = $dbName;
  }//end public function setDbName */

  /**
   * @param string $schemaName
   * @return void
   */
  public function setSchemaName($schemaName)
  {

    $this->schemaName = $schemaName;

  }//end public function setSchemaName */

  /**
   * @param string $schemaName
   * @return void
   */
  public function setSearchpath($schemaName)
  {

    if ($this->createPatch)
      $this->sqlPatch .= 'SET search_path = "'.$schemaName.'", pg_catalog; '.NL;

    if ($this->syncDb  )
      $this->db->setSearchPath($schemaName);

    $this->schemaName = $schemaName;

  }//end public function setSchemaName */

  /**
   * @param string $tableName
   * @return void
   */
  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }//end public function setTableName */

  /**
   * @param string $owner
   * @return void
   */
  public function setOwner($owner)
  {
    $this->owner = $owner;
  }//end public function setOwner */

  /**
   * @param boolean $sync
   */
  public function setSyncFlag($sync = true)
  {
    $this->syncDb = $sync;
  }//end public function setSyncFlag */

  /**
   * @param boolean $patch
   * @return void
   */
  public function setPatchFlag($patch = true)
  {
    $this->createPatch = $patch;
  }//end public function setPatchFlag */

  /**
   *
   * @return string
   */
  public function getPatch()
  {
    return $this->sqlPatch;
  }//end public function getPatch */

  /**
   *
   * @param string $flag
   */
  public function setMultiSeq($flag = true)
  {

    $this->muliSeq = $flag;
  }//end public function setMultiSeq */

  /**
   * @return array
   */
  public function getMultiple()
  {
    return $this->multiple;
  }//end public function getMultiple */

  /**
   * @return array
   */
  public function getQuotesMap()
  {
    return $this->quotesMap;
  }//end public function getQuotesMap */

  /**
   * @return array
   */
  public function getNameMapping()
  {
    return $this->nameMapping;
  }//end public function getNameMapping */

  /**
   * @return array
   */
  public function getTypeVaild()
  {
    return $this->typeVaild;
  }//end public function getTypeVaild */

} // end class LibDbAdmin

