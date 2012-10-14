
<fieldset>
<legend>User Status</legend>

<p>Main Group: <strong><?php echo $VAR->userGroup ?></strong></p>

<table class="wgt-table" >
<tbody>
<?php

$status = $VAR->userStatus;
foreach( $status  as $key => $value )
{
  echo <<<HTML
  <tr>
    <td>{$key}</td>
    <td>{$value}</td>
  </tr>
HTML;
}

?>
</tbody>
</table>
</fieldset>