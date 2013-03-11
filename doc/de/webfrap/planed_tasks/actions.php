## Actions

<pre><code>
[
	{
		"key":"start",
		"class":"",
		"methode":"",
		"inf":"",
		"params":{
			"p1":"v1"
		}
	},

	{
		"key":"start_error",
		"class":"",
		"methode":"",
		"inf":"",
		"params":{
			"p1":"v1"
		},
		"constraint":{
			"parent": {
				"key":"start",
			  "on":"fail",
			  "value":"array::[1,2,3]"
			}
		},
		"after":{
			"do": "break",
			"success":"break",
			"fail":"break"
		}
	},

	{
		"key":"some_step",
		"class":"",
		"methode":"",
		"inf":"",
		"params":{
			"p1":"v1"
		},
		"constraint":{
			"parent": {
				"key":"start",
			  "on":"success"
			}
		},
		"after":{
			"do": "break",
			"success":"break",
			"fail":"break"
		}
	}
]</code></pre>