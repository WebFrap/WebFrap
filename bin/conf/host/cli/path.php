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
// Code Pfade
//////////////////////////////////////////////////////////////////////////////*/

/**
 * ROOT Path of the Gateway
 * @var
 */
if (!defined('PATH_GW') )
  define( 'PATH_GW'     , './' );

/**
 * ROOT Path for all Modules, Libs and Gateways
 * @var
 */
define( 'PATH_ROOT'     , '../../' );

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
define( 'PATH_STYLE'    , PATH_ROOT.'WebFrap_Wgt/'  );

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

/*//////////////////////////////////////////////////////////////////////////////
// Web Pfade
//////////////////////////////////////////////////////////////////////////////*/

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
 */
define( 'WEB_ROOT'      , PATH_ROOT );

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
 */
define( 'WEB_GW'        , PATH_GW );

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
define( 'WEB_STYLE'     , WEB_ROOT.'WebFrap_Wgt/' );

/**
 * Root from the activ Style Project
 * @var
 */
define( 'WEB_THEME'     , WEB_ROOT.'WebFrap_Wgt/' );

/**
 * Root from the activ Style Project
 * @var
 */
define( 'WEB_ICONS'     , WEB_ROOT.'WebFrap_Wgt/' );

/**
 * ROOT path for the WebFrap Famework
 * @var
 */
define( 'WEB_WGT'       , WEB_ROOT.'WebFrap_Wgt/' );

/*//////////////////////////////////////////////////////////////////////////////
// Wbf Config
//////////////////////////////////////////////////////////////////////////////*/

/**
 * Which Systemcontroller Should be used
 * @var string
 */
define( 'WBF_CONTROLLER' , 'Cli' );

/**
 * Enter description here ...
 * @var string
 */
define( 'WBF_REQUEST_ADAPTER', 'Cli' );

/**
 * Enter description here ...
 * @var string
 */
define( 'WBF_RESPONSE_ADAPTER', 'Cli' );

/**
 * @var string
 */
define( 'WBF_MESSAGE_ADAPTER', 'Cli' );

/**
 * Which Systemcontroller Should be used
 * @var
 */
define( 'WBF_ACL_ADAPTER' , 'Db' );

/**
 * The Name of the Masterkey for Database entries
 * @var string
 */
define( 'WBF_DB_KEY' , 'rowid' );

/**
 *
 * Enter description here ...
 * @var string
 */
define( 'CONF_KEY' , 'cli' );

/*//////////////////////////////////////////////////////////////////////////////
// constants
//////////////////////////////////////////////////////////////////////////////*/

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

/*//////////////////////////////////////////////////////////////////////////////
// Debug Constantes
//////////////////////////////////////////////////////////////////////////////*/

/**
 * @var boolean
 */
define( 'DEBUG' ,           FALSE  );

/**
 * @var boolean
 */
define( 'DEBUG_CONSOLE' ,   FALSE  );

/**
 * @var boolean
 */
define( 'BUFFER_OUTPUT' ,   false  );

/**
 * @var boolean
 */
define( 'WBF_NO_LOGIN' , true );

/**
 *
 * @var boolean
 */
define( 'WBF_NO_ACL' , true );

