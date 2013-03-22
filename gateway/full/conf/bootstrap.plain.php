<?php
/*@interface.header@*/

if (file_exists('./conf/path.'.$_SERVER['SERVER_NAME'].'.php'))
  include './conf/path.'.$_SERVER['SERVER_NAME'].'.php';
else
  include './conf/path.php';

if (DEBUG)
  error_reporting(E_ALL | E_STRICT);
else
  error_reporting(0);

const PLAIN = 'plain';

include PATH_FW.'src/Webfrap.php';
include PATH_FW.'src/Debug.php';
include PATH_FW.'src/Conf.php';

spl_autoload_register('Webfrap::indexAutoload');
spl_autoload_register('Webfrap::pathAutoload');

// Gateway Path
Webfrap::$autoloadPath[]  = PATH_GW.'src/';

// load only the sources from libs
Webfrap::loadModulePath(true);
//Webfrap::loadLibPath(true);

// Framework Path
Webfrap::$autoloadPath[]  = PATH_FW.'src/';

// set custom handlers
if (defined('WBF_ERROR_HANDLER'))
  set_error_handler(WBF_ERROR_HANDLER);

// clean the logs if in debug mode
if (DEBUG)
  Log::cleanDebugLog();

