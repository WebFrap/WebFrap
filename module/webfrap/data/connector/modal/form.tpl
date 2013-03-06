<?php

$searchFrom = new WgtFormBuilder(
  $this,
  'ajax.php?c=Webfrap.DataConnector.search',
  'search-data-connetor',
  'get'
);

?>

<?php $searchFrom->form(); ?>

<div class="wgt-panel" ><h2>Data Connector</h2></div>

<fieldset>
  <legend>Search</legend>

  <input
    id="wgt-input-search-free"
    name="free"
    class="large"
   />

</fieldset>