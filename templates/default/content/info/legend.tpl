<?php 

$iconAdd = $this->icon( 'control/add.png', 'Add' );
$iconBookmark = $this->icon( 'control/bookmark.png', 'Bookmark' );
$iconDelete = $this->icon( 'control/delete.png', 'Delete' );

?>

<fieldset>
  <legend>Icons</legend>

  <table class="wgt-table" >
    <thead>
      <tr>
        <th style="width:30px;" >Icon</th>
        <th style="width:220px;" >Desc</th>
        <th style="width:10px;" >&nbsp;</th>
        <th style="width:30px;" >Icon</th>
        <th style="width:220px;" >Desc</th>
        <th style="width:10px;" >&nbsp;</th>
        <th style="width:30px;" >Icon</th>
        <th style="width:220px;" >Desc</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align:center;" ><?php echo $iconAdd; ?></td>
        <td>Add a new Entry</td>
        <td>&nbsp;</td>
        <td style="text-align:center;" ><?php echo $iconBookmark; ?></td>
        <td>Create a new Bookmark</td>
        <td>&nbsp;</td>
        <td style="text-align:center;" ><?php echo $iconDelete; ?></td>
        <td>Delete an Entry</td>
      </tr>
      
<!-- 
      <tr>
        <td style="text-align:center;" ></td>
        <td></td>
        <td>&nbsp;</td>
        <td style="text-align:center;" ></td>
        <td></td>
        <td>&nbsp;</td>
        <td style="text-align:center;" ></td>
        <td></td>
      </tr>
 -->
    </tbody>
  </table>
  
</fieldset>