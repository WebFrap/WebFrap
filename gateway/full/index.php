<?php
/*@interface.header@*/

$indexFile = isset($_GET['request'])?strtolower($_GET['request']):'html';

$index = array
(
  'webfrap'    => 'html',
  'html'       => 'html',
  'ajax'       => 'ajax',
  'window'     => 'window',
  'webservice' => 'webservice',
);

if (isset($index[$indexFile]))
  include $index[$indexFile].'.php';
else
  include 'html.php';

