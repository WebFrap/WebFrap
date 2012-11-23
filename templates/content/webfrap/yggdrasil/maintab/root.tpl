<?php 
$iconModule = $this->icon( 'control/module.png', 'Module' );
$iconEdit = $this->icon( 'control/edit.png', 'Edit' );
?>

<ul id="wgt-tree-webfrap_yggdrasil" class="wcm wcm_ui_tree bw7" >

<?php foreach( $VAR->modules as $module ){ ?>
<li id="wgt-tree-webfrap_yggdrasil-module-<?php echo $module['rowid'] ?>" class="closed loadable"  >
  <span class="folder" ><?php echo $iconModule.' '.$module['name'] ?></span>
  <a class="wcm wcm_req_mtab" href="maintab.php?c=Wbfsys.Module.edit&amp;objid=<?php echo $module['rowid'] ?>" ><?php echo $iconEdit ?></a>
  <ul></ul>
</li>
<?php } ?>

<var id="wgt-tree-webfrap_yggdrasil-cfg-tree" >
{"url":"ajax.php?c=Webfrap.Yggdrasil.subTree"}
</var>
</ul>
