<div class="wgt-panel title wgt-border-top" >
  <h2>BDL Projects</h2>
</div>

<div style="height:400px;" >
  <table class="wgt-table bw7"  >
    <thead>
      <tr>
        <th class="pos" style="width:30px;" >Pos:</th>
        <th>Key</th>
        <th>Name</th>
        <th>Title</th>
        <th>Author</th>
        <th>Nav.</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $pos = 1;
  
        foreach( $VAR->projects as $key => $proj )
        {
          
          /* @var $proj BdlProject */
          ?>
          <tr>
            <td class="pos" ><?php echo $pos ?></td>
            <td valign="top" ><?php echo $key; ?></td>
            <td valign="top" ><?php echo $proj['name']; ?></td>
            <td valign="top" ><?php echo $proj['title']; ?></td>
            <td valign="top" ><?php echo $proj->getAuthor(); ?></td>
            <td valign="top" >
              <button class="wgt-button" onclick="$R.get('maintab.php?c=Daidalos.BdlProject.edit&amp;key=<?php echo $key; ?>');" ><?php echo Wgt::icon('control/edit.png','xsmall','Edit'); ?></button>
            </td>
          </tr>
          <?php 
  
          ++$pos;
        }
      ?>
    </tbody>
  </table>
</div>

<div class="wgt-panel title wgt-border-top" >
  <h2>BDL Repositories</h2>
</div>

<table class="wgt-table bw7"  >
  <thead>
    <tr>
      <th class="pos" style="width:30px;" >Pos:</th>
      <th>Key</th>
      <th>Path</th>
      <th>Branch</th>
      <th>Description</th>
      <th>Nav.</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $pos = 1;
      foreach( $VAR->repos as $key => $repo )
      {
        ?>
        <tr>
          <td class="pos" ><?php echo $pos ?></td>
          <td valign="top" ><?php echo $key ?></td>
          <td valign="top" ><?php echo $repo['path'] ?></td>
          <td valign="top" ><?php echo $repo['branch'] ?></td>
          <td valign="top" ><?php echo $repo['description'] ?></td>
          <td valign="top" style="text-align:center;" >
            <button class="wgt-button" onclick="$R.get('maintab.php?c=Daidalos.BdlModules.listing&amp;key=<?php echo $key; ?>');" ><?php echo Wgt::icon('control/mask_table.png','xsmall','Modules'); ?></button>
          </td>
        </tr>
        <?php 

        ++$pos;
      }
    ?>
  </tbody>
</table>