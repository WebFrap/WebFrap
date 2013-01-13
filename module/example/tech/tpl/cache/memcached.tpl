<?php

/* Create a persistent instance
$mem = new Memcached('story_pool');
$mem->setOption(Memcached::OPT_RECV_TIMEOUT, 1000);
$mem->setOption(Memcached::OPT_SEND_TIMEOUT, 3000);
$mem->setOption(Memcached::OPT_TCP_NODELAY, true);
$mem->addServer('127.0.0.1', 11211);

var_dump( $m->getStats() ); */

/*
$memcache = new Memcache;
$memcache->connect( '127.0.0.1', 11211);

echo $memcache->getServerStatus('127.0.0.1', 11211);

$memcache->add('key','some value');

echo $memcache->get('key');
*/

$cache = $this->getCache()->getLevel1();


$cache->add( 'key', 'value 2222' );

echo $cache->type;
echo $cache->get('key');

?>

