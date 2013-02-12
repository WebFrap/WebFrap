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

include './conf/path.cli.php';

/*
this is the developer configuration!!
for productiv use we recomment to use just the autload function and
the notfounAutoload at the end
*/

error_reporting(E_ALL|E_STRICT);

include PATH_FW.'src/Webfrap.php';
include PATH_FW.'src/Debug.php';
include PATH_FW.'src/Base.php';
include PATH_FW.'src/PBase.php';
include PATH_FW.'src/BaseChild.php';
include PATH_FW.'src/i/ITObject.php';
include PATH_FW.'src/t/TArray.php';
include PATH_FW.'src/t/TDataObject.php';
include PATH_FW.'src/View.php';
include PATH_FW.'src/Conf.php';
include PATH_FW.'src/Log.php';
include PATH_FW.'src/lib/log/LibLogPool.php';
include PATH_FW.'src/Message.php';
include PATH_FW.'src/lib/message/LibMessagePool.php';
include PATH_FW.'src/Request.php';
include PATH_FW.'src/lib/request/LibRequestCli.php';
include PATH_FW.'src/Response.php';
include PATH_FW.'src/lib/LibResponse.php';
include PATH_FW.'src/lib/response/LibResponseCli.php';
include PATH_FW.'src/User.php';
include PATH_FW.'src/lib/LibTemplate.php';
include PATH_FW.'src/I18n.php';
include PATH_FW.'src/lib/i18n/LibI18nPhp.php';
include PATH_FW.'src/Validator.php';
include PATH_FW.'src/lib/LibFlow.php';
include PATH_FW.'src/lib/flow/LibFlowCli.php';

spl_autoload_register('Webfrap::indexAutoload');
spl_autoload_register('Webfrap::pathAutoload');

// the App

// Gateway Path
Webfrap::$autoloadPath[]  = PATH_GW.'src/';
View::$searchPathIndex[]        = PATH_GW.'templates/default/';
View::$searchPathTemplate[]     = PATH_GW.'templates/default/';
I18n::$i18nPath[]         = PATH_GW.'i18n/';
Conf::$confPath[]         = PATH_GW.'conf/';

Webfrap::loadModulePath();
Webfrap::loadGmodPath();

// test
Webfrap::$autoloadPath[]  = PATH_ROOT.'WebFrap_Test/stub/';

// Framework Path
Webfrap::$autoloadPath[]  = PATH_FW.'src/';
Webfrap::$autoloadPath[]  = PATH_FW.'module/';
View::$searchPathIndex[]        = PATH_FW.'templates/default/';
View::$searchPathTemplate[]     = PATH_FW.'templates/default/';
I18n::$i18nPath[]         = PATH_FW.'i18n/';
Conf::$confPath[]         = PATH_FW.'conf/';

if ( !isset( $_GET['c'] ) ) {
  Webfrap::loadClassIndex( 'default' );
} else {
  Webfrap::loadClassIndex( $_GET['c'] );
}

//set_error_handler( 'Webfrap::debugErrorHandler' );
Log::cleanDebugLog();
