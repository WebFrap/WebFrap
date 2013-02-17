<h1>Conf</h1>

<p>Hier könnte ihre Dokumentation stehen... Wenn sie endlich jemand schreiben würde...</p>

<label>Hier wäre ein super Platz für ein Codebeispiel</label>
<?php start_highlight(); ?>

/*
 * Kofiguration für die View
 */
$this->modules['cache'] = array
(
  'adapter' => array
  (
    'level1' => array
    (
      'class'     => 'Memcache',
      'server'    => '127.0.0.1',
      'port'      => 11211,
      'expire'    => 120
    ),
    'level2' => array
    (
      'class'     => 'Postgresql',
      'server'    => '127.0.0.1'
      'port'      => 5432,
      'db'				=> "webfrap_cache",
      'schema'		=> 'cache',
      'user'			=> 'user',
      'pwd'       => 'pwd'
      'expire'    => 120
    ),
    'level3' => array
    (
      'class'     => 'File',
      'folder'    => PATH_GW.'cache/',
      'expire'    => 120
    ),
  )
);//end $this->modules['cache'] = array


<?php display_highlight( 'php' ); ?>