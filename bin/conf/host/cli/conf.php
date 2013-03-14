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

/*//////////////////////////////////////////////////////////////////////////////
// Data for Configuration
//////////////////////////////////////////////////////////////////////////////*/

/*
 * Standard System Statis
 */
$this->status->content
(array
(

  'sys.name'        => 'WebFrap',
  'sys.version'     => '0.9',
  'sys.generator'   => 'WebFrap 0.9',
  'sys.admin.name'  => 'admin of the day',
  'sys.admin.mail'  => 'admin@webfrap.de',
  'sys.licence'     => 'BSD',
  'sys.copyright'   => 'WebFrap Net http://webfrap.net',

  'gateway.name'      => 'test',
  'gateway.version'   => '0.9',
  'gateway.licence'   => 'BSD',

  'default.country'   => 'de',
  'default.language'  => 'en',
  'default.timezone'  => 'Europe/Berlin',
  'default.encoding'  => 'utf-8',
  'default.theme'     => 'default',
  'default.layout'    => 'full',

  'activ.country'     => 'de',
  'activ.language'    => 'en',
  'activ.timezone'    => 'Europe/Berlin',
  'activ.encoding'    => 'utf-8',
  'activ.theme'       => 'default',

  'key.js'            => 'default',
  'key.style'         => 'default',
  'key.theme'         => 'default',

  'path.theme'        => PATH_ROOT.'WebFrap_Wgt/themes/default/' ,
  'path.icons'        => PATH_ROOT.'WebFrap_Wgt/icons/default/' ,

  'web.theme'         => WEB_ROOT.'WebFrap_Wgt/themes/default/' ,
  'web.icons'         => WEB_ROOT.'WebFrap_Wgt/icons/default/' ,

  'default.title'     => 'WebFrap test',

  'tripple.desktop'   => 'Webfrap.Desktop.display',
  'tripple.annon'     => 'Webfrap.Desktop.display',
  'tripple.user'      => 'Webfrap.Desktop.display',
  'tripple.admin'     => 'Webfrap.Desktop.display',

  'tripple.login'     => 'Webfrap.Auth.form',

  'ui.listing.numEntries' => array(10,25,50,100,250,500),

  'enable.firephp'    => false,
  //'enable.debugpwd'   => 'hanswurst', // CHANGE ME if enabled

));//end public $status = array

/*
 * Classes that wo
 */
$this->initClasses = array
(
  'Log'       ,
  'I18n'      ,
  'Message'   ,
  'Registry'  ,
  'Response'  ,
  'Request'   ,
  'User'      ,
  'View'      ,
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
      'dbname'    => 'sap_gw_innosuite',
      'dbuser'    => 'sap_gw_innosuite',
      'dbpwd'     => 'sap_gw_innosuite',
      'dbschema'  => 'sap',
      'quote'     => 'single'
    ),
    'admin' => array
    (
      'class'     => 'Postgresql',
      'dbhost'    => 'localhost',
      'dbport'    => '5432',
      'dbname'    => 'sap_gw_innosuite',
      'dbuser'    => 'sap_gw_innosuite',
      'dbpwd'     => 'sap_gw_innosuite',
      'dbschema'  => 'sap',
      'quote'     => 'single'
    ),
    'test' => array
    (
      'class'     => 'Postgresql',
      'dbhost'    => 'localhost',
      'dbport'    => '5432',
      'dbname'    => 'sap_gw_innosuite',
      'dbuser'    => 'sap_gw_innosuite',
      'dbpwd'     => 'sap_gw_innosuite',
      'dbschema'  => 'sap',
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
  'doctype'     => 3,
  'contenttype' => 'text/html',
  'systemplate' => 'default',
  'enable_gzip' => false,

  'index.login' => 'login',
  'head.login'  => 'default',

  'index.annon' => 'full/annon',
  'head.annon'  => 'minimal',

  'index.user'  => 'full/user',
  'head.user'   => 'default',

);//end $this->modules['VIEW'] = array

/*
 * Kofiguration für die View
 */
$this->modules['i18n'] = array
(
  'type'      => 'Php',
  'lang_path' => 'default',
  'lang'      => 'en',
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
  1 => array
  (
    'class'     => 'File',
    'folder'    => PATH_GW.'cache',
    'expire'    => 72000
  ),
);//end $this->modules['cache'] = array

/*
 *
 */
$this->modules['session'] = array
(
  'type'    => 'Php',
  //'path'  => PATH_GW.'tmp/session/',
  'name'    => 'WEBFRAP_TEST'
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
    'CONSOLE',
  ),
  'appender' => array
  (
    'FILE' => array
    (
      'class'     => 'File',
      'level'     => '+VERBOSE',
      'singel'    => true ,
      'logfolder' => 'log/',
      'logfile'   => 'webfrap.log',
      'logroll'   => false ,
      'logrotate' => 10,
      'maxsize'   => 10000,
      'compress'  => 'bz2',
    ),
    'CONSOLE' => array
    (
      'class'     => 'Console',
      'level'     => '+VERBOSE',
    ),
  ),

);//end $this->modules['log'] = array

