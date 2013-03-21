<h2>Tree</h2>

<div id="some-tree-box" class="wcm wcm_ui_tree" >
  <ul id="some-tree"  >
    <li id="some-tree-1" ><strong>Fubar</strong></li>
    <li id="some-tree-2" ><a href="maintab.php?c=Webfrap.Navigation.explorer"  >222</a>
      <ul>
        <li id="some-tree-2-1" >222.1</li>
        <li id="some-tree-2-2" >222.2</li>
        <li id="some-tree-2-3" >222.3</li>
        <li id="some-tree-2-4" >222.4</li>
      </ul>
    </li>
    <li id="some-tree-3" >333</li>
    <li id="some-tree-4" >444</li>
  </ul>
</div>


<script>
$S(document).ready(function(){
  $S('#some-tree-1 strong').bind('click',function(){
    alert('alert');
  });
});


</script>