<?php

$db = Webfrap::$env->getDb();

$maskQuery = $db->newQuery( 'ProjectActivityMaskProduct_TableIds' );
$maskIds 	= $maskQuery->fetchIds();

var_dump($maskQuery->getIds());

?>