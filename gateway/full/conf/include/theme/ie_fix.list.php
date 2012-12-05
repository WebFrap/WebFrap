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
echo '@charset "utf-8";'.NL;

$path = Session::status('path.theme');

$files = array
(
  // layout
  $path.'theme.css',
);


foreach( $files as $file )
{
  include $file;
  echo NL;
}
