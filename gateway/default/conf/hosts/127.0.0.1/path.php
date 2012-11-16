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


////////////////////////////////////////////////////////////////////////////////
// Code Pfade
////////////////////////////////////////////////////////////////////////////////

/**
 * ROOT Path of the Gateway
 * @var
 */
if( !defined('PATH_GW') )
  define( 'PATH_GW'     , './' );

/**
 * path for tmp files
 * @var string
 */
define( 'PATH_TMP'     , PATH_GW.'tmp/' );

/**
 * ROOT Path for all Modules, Libs and Gateways
 * @var
 */
define( 'PATH_ROOT'     , '../' );

/**
 * Root Path of the WebFrap Framework
 * @var
 */
define( 'PATH_FW'       , PATH_ROOT.'WebFrap/' );

/**
 * Path for all files
 * @var
 */
define( 'PATH_FILES'    , PATH_GW );

/**
 * Source Path to the style
 * @var
 */
define( 'PATH_THEME'    , PATH_ROOT.'WebFrap_Wgt/'  );

/**
 * Source Path to the style
 * @var
 */
define( 'PATH_ICONS'    , PATH_ROOT.'WebFrap_Wgt/'  );

/**
 * Source path to the webfrap wgt
 * @var
 */
define( 'PATH_WGT'      , PATH_ROOT.'WebFrap_Wgt/' );

////////////////////////////////////////////////////////////////////////////////
// Web Pfade
////////////////////////////////////////////////////////////////////////////////

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
 */
define( 'WEB_ROOT'      , '../' );

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
 */
define( 'WEB_GW'        , './' );

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
 */
define( 'WEB_FILES'     , WEB_GW );


/**
 * Root from the activ Style Project
 * @var
 */
define( 'WEB_THEME' , WEB_ROOT.'WebFrap_Wgt/' );

/**
 * Root from the activ Style Project
 * @var
 */
define( 'WEB_ICONS' , WEB_ROOT.'WebFrap_Wgt/' );

/**
 * ROOT path for the WebFrap Famework
 * @var
 */
define( 'WEB_WGT'   , WEB_ROOT.'WebFrap_Wgt/'  );



////////////////////////////////////////////////////////////////////////////////
// Wbf Config
////////////////////////////////////////////////////////////////////////////////

/**
 * Which Systemcontroller Should be used
 * @var
 */
define( 'WBF_CONTROLLER' , 'Apachemod' );

/**
 * Which Systemcontroller Should be used
 * @var
 */
define( 'WBF_RESPONSE_ADAPTER' , 'Http' );

/**
 * Which Systemcontroller Should be used
 * @var
 */
define( 'WBF_ACL_ADAPTER' , 'Db' );

/**
 * db key
 * @var
 */
define( 'WBF_DB_KEY' , 'rowid' );

/**
 *
 * Enter description here ...
 * @var unknown_type
 */
define( 'CONF_KEY' , '127.0.0.1' );

/**
 * @var string
 */
define( 'WBF_MESSAGE_SEND' , 'Stub' );

/**
 * db key
 * @var
 */
//define( 'WBF_ERROR_HANDLER' , 'Webfrap::debugErrorHandler' );

/**
 *
 * Enter description here ...
 * @var unknown_type
 */
//define( 'X509_KEY_NAME', 'SSL_CLIENT_S_DN_CN');

/**
 *
 * Enter description here ...
 * @var unknown_type
 */
//define( 'X509_DEF_USER', 'admin');

////////////////////////////////////////////////////////////////////////////////
// constants
////////////////////////////////////////////////////////////////////////////////


/**
 * @var
 */
define( 'NL' , "\n" );

/**
 * @var
 */
define( 'TEMP_SEP' , "~#&~" );

/**
 * @var
 */
define( 'P_S' , PATH_SEPARATOR );

/**
 * @var
 */
define( 'D_S' , '/' );


////////////////////////////////////////////////////////////////////////////////
// Developer constantes, NEVER USE IN PRODUCTION SYSTEMS!!! NEVER EVER!!!
////////////////////////////////////////////////////////////////////////////////

/**
 * @var boolean
 */
//define( 'MODE_MAINTENANCE' , true  );

/**
 * Debugausgabe aktivieren
 * @var boolean
 */
define( 'DEBUG' ,  true  );

/**
 * Ausgabe der Debug Console im Browser
 * @var boolean
 */
define( 'DEBUG_CONSOLE' ,  true  );

/**
 * Wenn true, wird die komplette ausgabe mit ob_start abgefangen
 * Das ermöglicht es z.B noch in den Templates header zu setzen
 * @var boolean
 */
define( 'BUFFER_OUTPUT' ,  false  );

/**
 * Wenn True wird nicht geprüft ob der Benutzer eingeloggt ist
 * @var boolean
 */
define( 'WBF_NO_LOGIN' , false );

/**
 * Wenn True wird die Prüfung auf ACLs deaktiviert
 * @var boolean
 */
define( 'WBF_NO_ACL' , true );
