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

// dirty hack
header("HTTP/1.0 200 OK");

$indexFile = isset($_GET['request'])?strtolower($_GET['request']):'html';

$index = array
(
  'webfrap'    => 'html',
  'html'       => 'html',
  'ajax'       => 'ajax',
  'window'     => 'window',
  'webservice' => 'webservice',
);

if( isset($index[$indexFile]) )
  include $index[$indexFile].'.php';
else
  include 'html.php';
