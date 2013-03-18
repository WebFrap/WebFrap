<form 
  id="wgt-form-data-selector-search"
  action="ajax.php?c=Webfrap.DataConnector.search&elid=wgt-grid-data-selector-table" ></form>

<div class="wgt-space bw6" >
  <div class="wgt-panel" >
    <div class="left bw2" >
      <h2>Search</h2>
    </div>
    <div class="right" >
      <input type="text" class="xlarge" /><button class="wgt-button append" ><i class="icon-search" ></i></button>
    </div>
  </div>
  <div id="wgt-grid-data-selector" class="wgt-grid" >
    <var id="wgt-grid-data-selector-table-cfg-grid" >{
      "height":"large",
      "search_form":"wgt-form-data-selector-search"
    }</var>
    <table id="wgt-grid-data-selector-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
      <thead>
        <tr>
          <th class="pos" >Pos:</th>
          <th style="width:100px;" >Type</th>
          <th style="width:170px;" >Name</th>
          <th style="width:240px;" >Description</th>
          <th style="width:70px;" >Menu</th>
        </tr>
      </thead>
      <tbody>
  
      </tbody>
    </table>
  </div>

</div>