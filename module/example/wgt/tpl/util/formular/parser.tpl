<div id="wgt-formular" >prod(v-price,v-amount)</div>

<table id="some-table" >
	<thead>
	  <tr>
	    <th key="price" recalc="true" >Price</th>
	    <th key="amount" recalc="true" >Amount</th>
	    <th formula="formula-some-table-sum" key="sum" >Sum</th>
	  </tr>
  </thead>
  <tbody>
	  <tr>
	    <td value="44" >44</td>
	    <td value="33" >33</td>
	    <td></td>
	  </tr>
	  <tr>
	    <td value="4" >4</td>
	    <td value="2" >2</td>
	    <td></td>
	  </tr>
	  <tr>
	    <td value="5" >5</td>
	    <td value="1" >1</td>
	    <td></td>
	  </tr>
  </tbody>
</table>

<script id="formula-some-table-sum" type="text/html" >
valWriter(
	row,
	'sum',
	(valReader(row,'price')*valReader(row,'amount'))
);
</script>

<script>

var tab = $S('#some-table'),
	head = tab.find('thead th'),
	body = tab.find('tbody tr'),
	actions = {},
	idxMap = {},
	recalcMap = {};

var valReader = function(row, key){

	return row.find('td:eq('+idxMap[key]+')').attr('value');
};

var valWriter = function(row, key, value){
  row.find('td:eq('+idxMap[key]+')').text(value);
  console.log( "write key: "+key+" value:"+value );
};

var tabParent = tab.parent();
tab.detach();

head.each(function(pos,row){

	row = $S(row),
		key = row.attr('key'),
		formula = row.attr('formula');

  if(key){
	  idxMap[key] = pos;
  }

  if(row.attr('recalc')){
    recalcMap[pos] = true;
  }

	if(formula){
	  actions[key] = new Function('row',$S('#'+formula).text());
	}


});

body.each(function(pos,row){

  for (var act in actions) {
    if (actions.hasOwnProperty(act)) {
      console.log('act '+act);
      actions[act]($S(row));
    }
  }


});

tabParent.append(tab);


</script>

