<h3>Export Table: <?php echo $VAR->table?></h3>
<pre>
<?php

foreach( $VAR->data as $data )
{

  $tmp = array();

  foreach( $data as $key => $col )
  {
    $tmp[$key] = addslashes($col);
  }

  echo "insert into ".$VAR->table.' ('.implode( array_keys($tmp),', ' ).") values ( '".implode( $tmp ,"', '" )."');".NL;
}

?>
</pre>