<?php
/*@interface.header@*/


////////////////////////////////////////////////////////////////////////////////
// Data for Configuration
////////////////////////////////////////////////////////////////////////////////

/*
 * Standard System Statis
 */
$this->status->content
(array
(

  'sys.name'        => 'WebFrap',
  'sys.version'     => '0.9',
  'sys.generator'   => 'WebFrap 0.6',
  'sys.admin.name'  => 'admin of the day',
  'sys.admin.mail'  => 'admin@webfrap.net',
  'sys.licence'     => 'BSD',
  'sys.copyright'   => 'S-DB http://s-db.de',

  'gateway.name'      => 'WebFrap',
  'gateway.version'   => '0.1',
  'gateway.licence'   => 'BSD',

  'default.country'   => 'de',
  'default.language'  => 'de',
  'default.timezone'  => 'Europe/Berlin',
  'default.encoding'  => 'utf-8',
  'default.theme'     => 'default',
  'default.icons'     => 'default',
  'default.layout'    => 'full',

  'activ.country'     => 'de',
  'activ.language'    => 'de',
  'activ.timezone'    => 'Europe/Berlin',
  'activ.encoding'    => 'utf-8',
  'activ.theme'       => 'default',

  'key.js'            => 'default',
  'key.style'         => 'default',
  'key.theme'         => 'default',

  'force.url'         => '',

  'path.theme'        => PATH_ROOT.'WebFrap_Wgt/themes/default/' ,
  'path.icons'        => PATH_ROOT.'WebFrap_Wgt/icons/default/' ,

  'web.theme'         => WEB_ROOT.'themes/themes/default/' ,
  'web.icons'         => WEB_ROOT.'icons/icons/default/' ,

  'default.title'         => 'WebFrap',

  'default.action.annon'  => 'Webfrap.Auth.Form',

  'tripple.desktop'     => 'webfrap.netsktop.display',
  'tripple.annon'       => 'webfrap.netsktop.display',
  'tripple.user'        => 'webfrap.netsktop.display',

  'tripple.login'       => 'Webfrap.Auth.Form',
  'tripple.setup'       => 'Webfrap.Base.Setup',

  'enable.firephp'    => false,
  //'enable.debugpwd'   => 'hanswurst', // CHANGE ME if enabled

));//end public $status = array

/*
 * classes that have to be initializes first bevor the system can run
 */
$this->initClasses = array
(
  'Log'       ,  // the logsystem
  'Cache'     ,  // the caching system
  'I18n'      ,  // the i18n text provider
  'Message'   ,  // the message system
  'Registry'  ,  // the main registry to manage global accessable data
  'Response'  ,  // the http request
  'Request'   ,  // the http request
  'Session'   ,  // the session object
  'User'      ,  // the active user object
  'View'      ,  // template enginge
);//end initClasses


/*
 * Kofiguration für die Datenbank Verbindung
 */
$this->modules['db'] = array
(
  'activ'       => 'default',
  'connection'  => array
  (
    'default' => array
    (
      'class'     => 'PostgresqlPersistent',
      'dbhost'    => 'localhost',
      'dbport'    => '5432',
      //'dbname'    => 'webfrap_de',
      'dbname'    => 'your_db',
      'dbuser'    => 'your_user',
      'dbpwd'     => 'your_pwd',
      'dbschema'  => 'production',
      'quote'     => 'single'
    ),
    'admin' => array
    (
      'class'     => 'Postgresql',
      'dbhost'    => 'localhost',
      'dbport'    => '5432',
      //'dbname'    => 'webfrap_de',
      'dbname'    => 'your_db',
      'dbuser'    => 'your_admin_user',
      'dbpwd'     => 'your_admin_pwd',
      'dbschema'  => 'production',
      'quote'     => 'single'
    ),
    'test' => array
    (
      'class'     => 'Postgresql',
      'dbhost'    => 'localhost',
      'dbport'    => '5432',
      'dbname'    => 'your_db',
      'dbuser'    => 'your_test_user',
      'dbpwd'     => 'your_test_pwd',
      'dbschema'  => 'test',
      'quote'     => 'single'
    ),
  )
);//end $this->modules['DBCON'] = array

/*
 * Kofiguration für die View
 */
$this->modules['view'] = array
(
  'charset'     => 'utf-8',
  'doctype'     => 4,
  'contenttype' => 'text/html',
  'systemplate' => 'default',
  'theme'       => 'default',
  'icons'       => 'default',
  'enable_gzip' => false,

  'index.login' => 'full/annon',
  'head.login'  => 'default',

  'index.annon' => 'full/annon',
  'head.annon'  => 'default',

  'index.user'  => 'full/annon',
  'head.user'   => 'default',

);//end $this->modules['VIEW'] = array

/*
 * Kofiguration für die View
 */
$this->modules['i18n'] = array
(
  'type'      => 'Php',
  'lang_path' => 'default',
  'lang'      => 'de',
  'de'        => array
  (
    'short'           => 'de',
    'dateSeperator'   => '.',
    'dateFormat'      => 'd.m.Y',
    'timeFormat'      => 'H:i:s',
    'timeSteperator'  => ':',
    'timeStampFormat' => 'd.m.Y H:i:s',
    'numberMil'       => '.',
    'numberDec'       => ',',
  ),
  'en'        => array
  (
    'short'           => 'en',
    'dateSeperator'   => '-',
    'dateFormat'      => 'Y-m-d',
    'timeFormat'      => 'H:i:s',
    'timeSteperator'  => ':',
    'timeStampFormat' => 'Y-m-d H:i:s',
    'numberMil'       => ',',
    'numberDec'       => '.',
  ),
);//end $this->modules['i18n'] = array

/*
 * Kofiguration für die View
 */
$this->modules['cache'] = array
(
  'adapters' => array(
    1 => array
    (
      'class'     => 'File',
      'folder'    => PATH_GW.'cache/',
      'expire'    => 120
    ),
  )
);//end $this->modules['cache'] = array

/*
 *
 */
$this->modules['session'] = array
(
  'type'    => 'Php',
  //'path'  => PATH_GW.'tmp/session/',
  'name'    => 'WEBFRAP_DEF_GW'
);//end $this->modules['cache'] = array

/*
 *
 */
$this->modules['wgt'] = array
(
  'menu_size'             => 3,
);//end $this->modules['cache'] = array

/*
 *
 */
$this->modules['log'] = array
(
  'activ'     => array
  (
    'FILE',
    //'SESSION',
    //'AJAXCONSOLE',
    //'FIREPHP'
  ),
  'appender' => array
  (
    'FILE' => array
    (
      'class'     => 'File',
      'level'     => '+WARN',
      'singel'    => true ,
      'logfolder' => 'log/',
      'logfile'   => 'webfrap.log',
      'logroll'   => false ,
      'logrotate' => 10,
      'maxsize'   => 10000,
      'compress'  => 'bz2',
    ),
    'DATABASE' => array
    (
      'class'     => 'Database',
      'level'     => 'USER',
      'logtable'  => 'syslog',
    ),
    'SESSION' => array
    (
      'class'     => 'Session',
      'level'     => 'DEBUG-USER,-CONFIG,+SECURITY',
    ),
    'AJAXCONSOLE' => array
    (
      'class'     => 'Ajaxconsole',
      'level'     => 'DEBUG-USER,-CONFIG,+SECURITY',
    ),
  ),

);//end $this->modules['log'] = array


