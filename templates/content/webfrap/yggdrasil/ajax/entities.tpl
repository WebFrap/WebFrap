<?php 
$iconEntity = $this->icon( 'control/entity.png', 'Entity' );
$iconEdit = $this->icon( 'control/edit.png', 'Edit' );
$iconMask = $this->icon( 'control/mask_table.png', 'Table' );
?>

<?php foreach( $VAR->entities as $entity ){ ?>
<li id="wgt-tree-webfrap_yggdrasil-entity-<?php echo $entity['rowid'] ?>" class="closed loadable wgt-treenode"  >
  <span class="folder" ><?php echo $iconEntity.' '.$entity['name'] ?></span>
  <a class="wcm wcm_req_mtab" href="maintab.php?c=Wbfsys.Entity.edit&amp;objid=<?php echo $entity['rowid'] ?>" ><?php echo $iconEdit ?></a>
  <a class="wcm wcm_req_mtab" href="maintab.php?c=<?php echo SParserString::subToUrl($entity['access_key']) ?>.listing" ><?php echo $iconMask ?></a>
  <ul></ul>
</li>
<?php } ?>
