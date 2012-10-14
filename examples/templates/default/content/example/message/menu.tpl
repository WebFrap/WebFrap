<div class="wgt-panel title" >
  <h2>Menu</h2>
</div>

<div class="full" >
<ul>
<?php 
foreach( $VAR->entries as $key => $label )
{
  echo '<li><a href="maintab.php?c=Example.Message.'.$key.'" class="wcm wcm_req_ajax" >'.$label.'</a></li>'.NL;
}
?>
</ul>
</div>