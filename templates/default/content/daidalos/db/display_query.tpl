<?php 

$buildHead = function( $row )
{
  $keys = array_keys($row);
  
  $code = '<thead><tr><th>Pos</th>'.NL;
  
  foreach( $keys as $key )
  {
    $code .= "<th>{$key}</th>".NL;
  }
  
  $code .= '</tr></thead>'.NL;
  
  return $code;
}

?>

<div class="wgt-panel title" >
  <h3>Query Tester</h3>
</div>

<form 
  id="wgt-form-query-tester"
  method="post"
  action="maintab.php?c=Daidalos.Db.Query" >
  
  <div class="wgt-panel" >
    <div class="left" >
      <label>Saved Queries</label>
      <select name="use_query" class="large" ></select>
    </div>
    <div class="inline" style="width:30px;" >&nbsp;|&nbsp;</div>
    <div class="inline" >
      <label>Save Query: </label>
      <input type="checkbox" name="save_query_flag" />
      <label>Key: <strong>*</strong></label>
      <input type="text" class="large" name="query_name" />
    </div>
  </div>
  <textarea class="full large-height" name="query" ><?php echo $VAR->query ?></textarea>

  <div class="wgt-panel" >
    <div class="left" >
      <button class="wgt-button" onclick="$R.form('wgt-form-query-tester');" >Execute</button>
    </div>
    <div class="inline" style="width:30px;" >&nbsp;|&nbsp;</div>
    <div class="inline" >
      <label>Render as: </label>
      <label>Html </label><input type="radio" name="render" value="html" checked="true" />
      <label>CVS </label><input type="radio" name="render" value="cvs" />
      <label>Excel </label><input type="radio" name="render" value="excel" />
    </div>
  </div>
</form>
<div class="wgt-clear medium" ></div>



<?php if( $VAR->result ){ ?>

<div class="wgt-clear large" >&nbsp;</div>

<fieldset class="nearly_full" >
  <legend>Result</legend>
  
  <table class="wgt-table full" >

  <?php 
  
    $body = '<tbody>';
    $head = null;
    
    
    foreach( $VAR->result as $pos => $row )
    {
      
      if( !$head )
        $head = $buildHead( $row );
        
      $body .= '<tr>'.NL;
      $body .= '<td>'.$pos.'</td>'.NL;
      foreach( $row as $col )
      {
        $body .= "<td>{$col}</td>".NL;
      }
      
      $body .= '</tr>'.NL;

    }
    
    echo $head;
    echo $body;
    
  ?>
  </tbody>
</table>
  
</fieldset>
<?php } ?>


