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
 * class Db
 * Controller Klasse für die Datenbankabstraktionsebene
 * Dieser Controller ist gleichzeitig noch die Factory Klasse welche neue
 * Datenbankverbindungen erstellen kann.
 * @package WebFrap
 * @subpackage tech_core
 */
class Db
{
    /*//////////////////////////////////////////////////////////////////////////////
    // Const
    //////////////////////////////////////////////////////////////////////////////*/

    /**
     * Name des Haupt Pks
     * @var string
     */
    const PK = WBF_DB_KEY;

    /**
     * Name der Master sequence
     * @var string
     */
    const SEQUENCE = 'entity_oid_seq';

    const VERSION = 'm_version';
    /*
      const CREATOR = 'm_role_create';

      const CREATED = 'm_time_created';
    */

    const TIME_CREATED = 'm_time_created';

    const ROLE_CREATE = 'm_role_create';

    const TIME_CHANGED = 'm_time_changed';

    const ROLE_CHANGE = 'm_role_change';

    const TIME_DELETED = 'm_time_deleted';

    const ROLE_DELETE = 'm_role_delete';

    const UUID = 'm_uuid';

    const START_VALUE = 1;

    const NULL = 'null';

    const NUM_ROWS = 'num_rows';

    const Q_SIZE = 'q_size';

    const EMPTY_ARRAY = '{}';

    /*//////////////////////////////////////////////////////////////////////////////
    // Attributes
    //////////////////////////////////////////////////////////////////////////////*/

    /**
     * @var LibDbConnection
     */
    private static $instance = null;

    /**
     * Connectionpool für den Zugriff auf eine Resource
     * @var array<LibDbConnection>
     */
    private static $connectionPool = array();

    /*//////////////////////////////////////////////////////////////////////////////
    // init and wakeup
    //////////////////////////////////////////////////////////////////////////////*/

    /**
     * Initialisieren der Datenbankverbindungen
     *
     * @return void
     */
    public static function init()
    {
        $conf = Conf::get('db');

        $conf['activ'] = isset($conf['activ']) ? $conf['activ'] : 'default';

        if (!isset($conf['connection'][$conf['activ']])) {
            if (DEBUG) {
                Debug::console('requested non existing database connection ' . $conf['activ'] . '!', $conf);
            }

            throw new LibDb_Exception
            (
                I18n::s
                    (
                        'requested non existing database connection ' . $conf['activ'] . '!',
                        'wbf.error.db_connection_not_exists'
                    )
            );
        }

        self::connectDb($conf['activ'], $conf['connection'][$conf['activ']], true);
    } // end public function init */

    /**
     * schliesen aller aktiven Datenbank Verbindungen
     * @return void
     */
    public static function shutdown()
    {
        // vor dem beenden noch den Cache Speichern
        foreach (self::$connectionPool as $con) {
            $con->saveCache();
        }

        self::closeDatabase();
    }

    //end public static function shutdown */

    /*//////////////////////////////////////////////////////////////////////////////
    // getter and setter
    //////////////////////////////////////////////////////////////////////////////*/

    /**
     * eine neue Criteria erstellen
     * @param string $name
     * @return LibSqlCriteria
     */
    public static function newCriteria($name = null)
    {
        return self::$instance->orm->newCriteria($name);
    }

    //end public static function newCriteria */

    /**
     * @param string $type
     * @return Query
     */
    public static function newQuery($type, $db = null)
    {
        return self::$instance->newQuery($type, $db);
    }

    //end public static function newQuery */

    /**
     * @return LibParserSqlAbstract
     */
    public static function getParser()
    {
        return self::$instance->orm->getParser();
    }

    //end public static function getParser */

    /**
     * @return LibParserSqlAbstract
     */
    public static function getQueryBuilder()
    {
        return self::$instance->orm->getParser();
    }

    //end public static function getQueryBuilder */

    /**
     *
     * @return LibDbOrm
     */
    public static function getOrm()
    {
        if (!self::$instance) {
            self::getActive();
        }

        return self::$instance->getOrm();
    }

    //end public function getOrm */

    /*//////////////////////////////////////////////////////////////////////////////
    // logic
    //////////////////////////////////////////////////////////////////////////////*/

    //end public static function switchDbcon */

    /**
     * Bestimmte Datenbankverbindung schliesen
     *
     * @param string $name name of the database connection to close
     * @return void
     */
    public static function closeDatabase($name = null)
    {
        if ($name) {
            if (isset(self::$connectionPool[$name])) {
                self::$connectionPool[$name]->close();
                unset(self::$connectionPool[$name]);
            }
        } else {
            foreach (self::$connectionPool as $con) {
                $con->close();
            }
            self::$connectionPool = array();
        }
    }

    //end public static function closeDatabase */

    /**
     * Die Datenbank  Verbindungsdaten einer Datebank erfragen
     *
     * @param string $key Key Name der Datenbankverbindung derern Daten man möchte
     * @param string $connectionConf
     * @param boolean $activ
     * @return LibDbConnection
     */
    public static function connectDb($key, $connectionConf = null, $activ = false)
    {
        if (!$connectionConf) {
            $conf = Conf::get('db');

            if (!isset($conf['connection'][$key])) {
                if (DEBUG) {
                    Debug::console('requested non existing database connection ' . $key . '!', $conf);
                }

                throw new LibDb_Exception
                (
                    I18n::s
                        (
                            'requested non existing database connection ' . $key . '!',
                            'wbf.error.db_connection_not_exists'
                        )
                );
            }

            $connectionConf = $conf['connection'][$key];
        }

        $classname = 'LibDb' . $connectionConf['class'];

        // Erstellen des Aktiven Objects
        if (class_exists($classname)) {

            $connection = new $classname($connectionConf);
            self::$connectionPool[$key] = $connection;

            if ($activ) {
                self::$instance = $connection;
            }
        } else {
            throw new LibDb_Exception
            (
                'tried to load nonexisting database connection'
            );
        }

        return $connection;
    }

    //end public static function connectDb */

    /**
     * Die Datenbank  Verbindungsdaten einer Datebank erfragen
     *
     * @param string $key Key Name der Datenbankverbindung derern Daten man möchte
     * @param string $connectionConf
     * @param boolean $activ
     * @return LibDbConnection
     */
    public static function getLoggerConnection($key, $connectionConf = null)
    {
        if (!$connectionConf) {
            $conf = Conf::get('db');

            if (!isset($conf['connection'][$key])) {
                throw new LibDb_Exception(I18n::s('requested non existing database connection'));
            }

            Debug::console($key, $conf['connection']);

            if (!isset($conf['connection'][$key])) {
                Error::addVisualError('No Connection with the key: ' . $key . ' exists');

                return null;
            }

            $connectionConf = $conf['connection'][$key];
        }

        $classname = 'LibDb' . $connectionConf['class'] . 'Logger';

        // Erstellen des Aktiven Objects
        if (class_exists($classname)) {

            $connection = new $classname($connectionConf);
            self::$connectionPool[$key] = $connection;
        } else {
            throw new LibDb_Exception('tried to load nonexisting database connection');
        }

        return $connection;
    }

    //end public static function connectDb */

    /*//////////////////////////////////////////////////////////////////////////////
    // logic
    //////////////////////////////////////////////////////////////////////////////*/

    /**
     * @param string $key
     */
    public static function toArray($data)
    {
        return self::$instance->dbArrayToArray($data);
    }

    //end public static function toArray */

    /**
     * @param string $key
     */
    public static function toChain($data)
    {
        $array = self::$instance->dbArrayToArray($data);

        return implode(';', $array);
    }

    //end public function toChain */

    /*//////////////////////////////////////////////////////////////////////////////
    // Static Logic rquire instance
    //////////////////////////////////////////////////////////////////////////////*/

    /**
     *
     * @return LibDbConnection
     */
    public static function getInstance()
    {
        self::$instance ? : self::init();

        return self::$instance;
    }

    //end public static function getInstance */

    /**
     *
     */
    public static function getActive()
    {
        self::$instance ? : self::init();

        return self::$instance;
    }

    //end public static function getActive */

    /**
     *
     * @param string $type
     * @param boolean $optional
     * @return LibDbConnection
     * @throws LibDb_Exception
     */
    public static function connection($type, $optional = false)
    {
        if ($optional && !self::connectionExists($type)) {
            return null;
        }

        if (!isset(self::$connectionPool[$type])) {
            self::connectDb($type);
        }

        return self::$connectionPool[$type];
    }

    //end public static function connection */

    /**
     * @param string $type
     */
    public static function connectionExists($type)
    {
        $conf = Conf::get('db');

        return isset($conf['connection'][$type]);
    }

    //end public static function connectionExists */

    /**
     * @param scalar/array $value
     */
    public static function addSlashes($value)
    {
        self::$instance ? : self::init();

        return self::$instance->escape($value);
    }

    //end public static function addSlashes */

    /**
     * Enter description here...
     *
     * @param scalar/array $value
     */
    public static function stripNaddSlashes($value)
    {
        self::$instance ? : self::init();

        return self::$instance->stripNaddSlashes($value);
    }
    //end public static function stripNaddSlashes */

} // end class Db

