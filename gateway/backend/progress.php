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

if (!function_exists('apc_fetch')) {
  header("HTTP/1.1 501 Not Implemented");
  echo json_encode('not_available');
  exit;
}

if (isset($_GET['key'])) {
  $status = apc_fetch('upload_'.$_GET['key']);
  echo json_encode($status);
} else {
  echo json_encode('null');
}
