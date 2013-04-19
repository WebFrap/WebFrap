<?php 

$jsonData = <<<JSON

{"test": [ "fuu", "bar", { "didi":"lala" } ] }

JSON;

$jsonTree = new WgtTreeBuilderJson();

echo $jsonTree->renderData( $jsonData, 'test' );
