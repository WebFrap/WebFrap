<div class="wgt-panel title" >
  <h2>Request Elements</h2>
</div>

<fieldset class="wgt_pitch" >
  <element>Request Types</element>
  <button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.showRequestType');" >
    Get Request
  </button>

  <button class="wgt-button" onclick="$R.post('ajax.php?c=Example.Ajax.showRequestType',{'key':'value'});" >
    Post Request
  </button>

  <button class="wgt-button" onclick="$R.put('ajax.php?c=Example.Ajax.showRequestType',{'key':'value'});" >
    Put Request
  </button>

  <button class="wgt-button" onclick="$R.del('ajax.php?c=Example.Ajax.showRequestType');" >
    Delete Request
  </button>

</fieldset>

<fieldset class="wgt_pitch" >
  <element>Message & Warning & Error</element>
  <button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.sendMessage');" >
    Send Message
  </button>

  <button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.sendWarning');" >
    Send Warning
  </button>

  <button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.sendError');" >
    Send Error
  </button>
</fieldset>

<!-- breiter abstand  -->
<div class="wgt-clear medium" ></div>

<div class="full" >


<div id="wgt-box-data1" >
Hallo ich bin sinnloser content
</div>

<button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.changeBox1');" >
  Change Box Content
</button>

<button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.boxNewClass');" >
  Add New Class
</button>

<button class="wgt-button" onclick="$R.get('ajax.php?c=Example.Ajax.boxToggleClass');" >
  Toggle Class
</button>

</div>

<br />


<!--
so
<button
  class="wcm wcm_ui_button"
  wgt_request="get:ajax:Example.Ajax.changeBox"
  wgt_icon="control/edit.png" >Example Request</button>
-->

