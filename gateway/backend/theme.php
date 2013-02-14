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


define('WGT_ERROR_LOG','log.theme.html');
include './conf/bootstrap.plain.php';

Webfrap::$indexCache = 'cache/autoload_theme/';

if(isset($_GET['l']))
{
  $tmp      = explode('.',$_GET['l']);

  $type     = $tmp[0];
  $id       = $tmp[1];

  if (!ctype_alnum($type) )
    $type = 'list';

  if (!ctype_alnum($id) )
    $id = 'default';

}
else
{
  $type     = 'list';
  $id       = 'default';
}

Webfrap::loadClassIndex( $type.'/'.$id );

$webfrap  = Webfrap::init();
Webfrap::$autoloadPath[]  = View::$themePath.'src/';
$cache    = new LibCacheRequestTheme();

if( isset($_GET['clean']) )
  $cache->clean();

if( 'file' == $type )
{
  if (!$cache->loadFileFromCache( $id ) )
    $cache->publishFile( $id );
}
else // default ist eine liste
{
  if (!$cache->loadListFromCache( $id ) )
    echo $cache->publishList( $id );
}

