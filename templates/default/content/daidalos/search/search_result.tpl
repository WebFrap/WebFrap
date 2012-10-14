<fieldset>
  <legend>results</legend>

<?php

 $pattern = $this->model->getPattern();
 $replace = '<span class="important" >'.$pattern.'</span>';

 if(!$data = $this->model->getSearchResults())
 {
   echo "<p>found no files for this search</p>";
 }
 else
 {
?>
  <table>
    <thead>
      <tr>
        <th>file</th>
        <th>pos</th>
        <th>value</th>
      </tr>
    </thead>
    <tbody>
<?php

   foreach( $data as $filename => $matches )
   {
     ?>
     <tr>
      <td colspan="3"><?php echo htmlentities($filename);  ?></td>
     </tr>
     <?php
     foreach ( $matches as $pos => $match )
     {
     ?>
      <tr>
        <td></td>
        <td><?php echo htmlentities($pos); ?></td>
        <td><?php echo str_replace($pattern, $replace, htmlentities($match) ) ; ?></td>
      </tr>
     <?php
     }
   }

 }

?>
</tobdy
</table>
</fieldset>