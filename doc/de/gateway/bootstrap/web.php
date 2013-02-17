<h1>gateway.bootstrap.normal</h1>

<p>Hier könnte ihre Dokumentation stehen... Wenn sie endlich jemand schreiben würde...</p>

<h3>Hier wäre ein super Platz für ein Codebeispiel</h3>
<?php start_highlight(); ?>

// used to set modes like testmode
if( isset($_GET['wbf_mode']) && ctype_alnum($_GET['wbf_mode']) )
  setcookie( 'wbf_mode', $_GET['wbf_mode'] );

if( isset($_SESSION['sys_mode']) && file_exists('./conf/hosts/'.$_SERVER['SERVER_NAME'].'/path-'.$_COOKIE['wbf_mode'].'.php'))
{
  include './conf/hosts/'.$_SERVER['SERVER_NAME'].'/path-'.$_COOKIE['wbf_mode'].'.php';
}
elseif( file_exists('./conf/hosts/'.$_SERVER['SERVER_NAME'].'/path.php') )
{
  include './conf/hosts/'.$_SERVER['SERVER_NAME'].'/path.php';
}
else
{
  include './conf/path.php';
}

if( DEBUG )
  error_reporting( E_ALL | E_STRICT );
else
  error_reporting( 0 );

// load the bootstrap files where it is shure that they will be embed
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
include PATH_FW.'src/Session.php';
include PATH_FW.'src/lib/session/LibSessionPhp.php';
include PATH_FW.'src/Request.php';
include PATH_FW.'src/lib/request/LibRequestPhp.php';
include PATH_FW.'src/Response.php';
include PATH_FW.'src/lib/LibResponse.php';
include PATH_FW.'src/lib/response/LibResponseHttp.php';
include PATH_FW.'src/User.php';
include PATH_FW.'src/lib/LibTemplate.php';
include PATH_FW.'src/lib/template/LibTemplatePublisher.php';
include PATH_FW.'src/lib/flow/LibFlowApachemod.php';
include PATH_FW.'src/I18n.php';
include PATH_FW.'src/lib/i18n/LibI18nPhp.php';
include PATH_FW.'src/Validator.php';

// extended includes
include PATH_FW.'src/s/SFiles.php';
include PATH_FW.'src/s/parser/SParserString.php';

include PATH_FW.'src/t/TTrait.php';
include PATH_FW.'src/t/TFlowFlag.php';
include PATH_FW.'src/t/TFlag.php';
include PATH_FW.'src/t/TBitmask.php';

include PATH_FW.'src/lib/LibConf.php';

include PATH_FW.'src/Model.php';
include PATH_FW.'src/Controller.php';

// acl
include PATH_FW.'src/lib/acl/LibAclPermission.php';
include PATH_FW.'src/lib/acl/LibAcl_Db_Model.php';
include PATH_FW.'src/lib/acl/LibAclAdapter.php';
include PATH_FW.'src/lib/acl/LibAclDb.php';

// wichtigste input elemente
include PATH_FW.'src/wgt/WgtAbstract.php';
include PATH_FW.'src/wgt/WgtInput.php';
include PATH_FW.'src/wgt/WgtSelectbox.php';
include PATH_FW.'src/wgt/input/WgtInputText.php';
include PATH_FW.'src/wgt/input/WgtInputWindow.php';
include PATH_FW.'src/wgt/input/WgtInputDate.php';
include PATH_FW.'src/wgt/input/WgtInputInt.php';
include PATH_FW.'src/wgt/input/WgtInputNumeric.php';
include PATH_FW.'src/wgt/input/WgtInputTextarea.php';
include PATH_FW.'src/wgt/WgtForm.php';

// listenelement
include PATH_FW.'src/wgt/WgtPanel.php';
include PATH_FW.'src/wgt/menu/WgtMenuBuilder.php';
include PATH_FW.'src/wgt/WgtDropmenu.php';

include PATH_FW.'src/lib/log/LibLogFile.php';

// sql
include PATH_FW.'src/i/ISqlParser.php';
include PATH_FW.'src/lib/sql/LibSqlCriteria.php';
include PATH_FW.'src/lib/sql/LibSqlQuery.php';
include PATH_FW.'src/lib/db/LibDbResult.php';
include PATH_FW.'src/lib/parser/sql/LibParserSqlAbstract.php';
include PATH_FW.'src/lib/db/LibDbOrm.php';
include PATH_FW.'src/lib/db/LibDbConnection.php';

// templatesystem / view
include PATH_FW.'src/lib/template/LibTemplatePresenter.php';
include PATH_FW.'src/lib/template/LibTemplateHtml.php';
include PATH_FW.'src/lib/template/LibTemplateAjax.php';


// register all used autoload methodes
spl_autoload_register('Webfrap::indexAutoload');
spl_autoload_register('Webfrap::pathAutoload');

// extend the auto search pathes for all elements that can be splitet in
// different projects
// first written here has the highest priority

//Webfrap::announceIncludePaths('develop',true);

// Gateway Path
Webfrap::$autoloadPath[]  = PATH_GW.'src/';
View::$searchPathIndex[]    = PATH_GW.'templates/default/';
View::$searchPathTemplate[] = PATH_GW.'templates/default/';
I18n::$i18nPath[]         = PATH_GW.'i18n/';
Conf::$confPath[]         = PATH_GW.'conf/';

// load the modules an libs from the conf
Webfrap::loadModulePath();
Webfrap::loadGmodPath();


// Framework Path
Webfrap::$autoloadPath[]    = PATH_FW.'src/';  // search path for code / classes
Webfrap::$autoloadPath[]    = PATH_FW.'module/';  // search path for code / classes
View::$searchPathIndex[]    = PATH_FW.'templates/default/'; // search path for index templates
View::$searchPathTemplate[] = PATH_FW.'templates/default/'; // searchpath for content templates
I18n::$i18nPath[]           = PATH_FW.'i18n/'; // search path for i18n files
Conf::$confPath[]           = PATH_FW.'conf/'; // search path for configuration files

// load the activ indexes and class files from the conf
if( !isset( $_GET['c'] ) )
{
  Webfrap::loadClassIndex( 'default' );
}
else
{
  Webfrap::loadClassIndex( $_GET['c'] );
}


// set custom handlers

//if( defined( 'WBF_ERROR_HANDLER' ) )
//  set_error_handler( WBF_ERROR_HANDLER );



// clean the logs if in debug mode
if( DEBUG )
  Log::cleanDebugLog();

<?php display_highlight( 'php' ); ?>