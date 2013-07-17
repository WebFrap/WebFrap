<div id="wgt-formular" >prod(v-price,v-amount)</div>

<table id="some-table" >
	<thead>
	  <tr>
	    <th key="v-price" >Price</th>
	    <th key="v-amount" >Amount</th>
	    <th formula="formula-some-table-v-sum" key="v-sum" >Sum</th>
	  </tr>
  </thead>
  <tbody>
	  <tr>
	    <td>44</td>
	    <td>22</td>
	    <td></td>
	  </tr>
	  <tr>
	    <td>3</td>
	    <td>5</td>
	    <td></td>
	  </tr>
	  <tr>
	    <td>5</td>
	    <td>1</td>
	    <td></td>
	  </tr>
  </tbody>
</table>

<script id="formula-some-table-v-sum" type="text/html" >
valWriter(
	row,
	'v-sum',
	(valReader(row,'v-price')*valReader(row,'v-amount'))
);
</script>

<script>

var tab = $S('#some-table'),
	head = tab.find('thead th'),
	body = tab.find('tbody tr'),
	actions = {},
	idxMap = {},
	ast = {};

var valReader = function(row, key){
	return numeral().unformat(row.find('td:eq('+idxMap[key]+')').text());
};

var valWriter = function(row, key, value){
  row.find('td:eq('+idxMap[key]+')').text(value);
};

var functs = {
	'prod' : function(lv,rv){
		return lv*rv;
	},
	'quot' : function(lv,rv){
		return lv/rv;
	},
	'sub' : function(lv,rv){
		return lv-rv;
	},
	'add' : function(lv,rv){
		return lv+rv;
	}
};

var fParser = function(raw){
	var tkns = raw.split(/([^A-Za-z0-9_\-\'])+/),
		ast = {},
    actual = {};

};



head.each(function(pos,row){

  var key = $S(row).attr('key'),
    formula = $S(row).attr('formula');

	if(formula){
	  actions[key] = new Function('row',formula);
	}


});

body.each(function(pos,row){

  for (var act in actions) {
    if (actions.hasOwnProperty(act)) {
      actions[act](row);
    }
  }


});


</script>

