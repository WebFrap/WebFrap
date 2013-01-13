<pre><?php

$cache = $this->getCache()->getlevel1();

echo "Got l1 adapter: $cache->type".NL.NL;

echo "set 'key' : 'value 2222'".NL;
$cache->add( 'key', 'value 2222' );

echo "get 'key'".NL;
echo $cache->get('key').NL.NL;


echo "get 'key2'".NL;
echo $cache->get('key2').NL.NL;


?></pre>

