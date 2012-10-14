<h2>Result for your query</h2>
<table>
<tbody>
<?php 

foreach( $VAR->data as $row )
{
  echo "<tr>".NL;
  echo "<td>".implode( '</td><td>', $row )."</td>".NL;
  echo "</tr>".NL;
}

?>
</tbody>
</table>