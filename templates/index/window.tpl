<?php 

define( 'TPL_START', '<?php echo' );
define( 'TPL_END',   '?>'  );

?>

<div 
  class="box_template wgt-editlayer border" 
  contenteditable="true" 
  id="wgt-edit-field-text" ></div>
<div 
  class="box_template wgt-editlayer number border" 
  contenteditable="true" 
  id="wgt-edit-field-number"  ></div>
<div 
  class="box_template wgt-editlayer" 
  id="wgt-edit-field-select" ></div>
<div 
  class="box_template wgt-editlayer" 
  id="wgt-edit-field-window" ></div>
<div 
  class="box_template wgt-editlayer" 
  id="wgt-edit-field-check" ><input type="checkbox" /></div>
<div 
  class="box_template wgt-editlayer border" 
  contenteditable="true" 
  id="wgt-edit-field-date" style="overflow:hidden;" ><input 
    type="text" 
    class="wcm wcm_list_date" 
    style="border:0px;width:100%;margin:0px;padding:0px;overflow:hidden;" 
    /></div>
<div class="box_template wgt-editlayer"  style="overflow:hidden;" contenteditable="true" id="wgt-edit-field-datetime" ><input 
  type="text" 
  class="wcm wcm_list_date_timepicker" 
  style="border:0px;width:100%;margin:0px;padding:0px;overflow:hidden;" 
  /></div>
<div class="box_template wgt-editlayer border" contenteditable="true" id="wgt-edit-field-money" ><input 
  type="text" 
  style="border:0px;width:100%;margin:0px;padding:0px;" 
  /><button
    class="wgt-button append just-annotate"
    tabindex="-1"  ><i 
      class="icon-money" ></i></button></div>
      
<?php
// TODO move that into a builder class?
$slctBoolean = new WebfrapSearchTypeBoolean_Selectbox();
$slctBoolean->attributes['name'] = 'as[{$pos}][cond]';
$slctBoolean->setId('wgt-select-astype-{$dkey}-{$pos}');

$slctDate = new WebfrapSearchTypeDate_Selectbox();
$slctDate->attributes['name'] = 'as[{$pos}][cond]';
$slctDate->setId('wgt-select-astype-{$dkey}-{$pos}');

$slctId = new WebfrapSearchTypeId_Selectbox();
$slctId->attributes['name'] = 'as[{$pos}][cond]';
$slctId->setId('wgt-select-astype-{$dkey}-{$pos}');

$slctNumeric = new WebfrapSearchTypeNumeric_Selectbox();
$slctNumeric->attributes['name'] = 'as[{$pos}][cond]';
$slctNumeric->setId('wgt-select-astype-{$dkey}-{$pos}');

$slctText = new WebfrapSearchTypeText_Selectbox();
$slctText->attributes['name'] = 'as[{$pos}][cond]';
$slctText->setId('wgt-select-astype-{$dkey}-{$pos}');

$slctTextStrict = new WebfrapSearchTypeTextStrict_Selectbox();
$slctTextStrict->attributes['name'] = 'as[{$pos}][cond]';
$slctTextStrict->setId('wgt-select-astype-{$dkey}-{$pos}');
?>

<script id="wgt-tpl-search-boolean" type="text/html" >
<tr>
	<td class="ao" >
		<select name="as[{$pos}][con]" >
			<option>AND</option>
			<option>OR</option>
		</select>
	</td>
	<td class="field" style="text-align:right;" >
		<input class="field" name="as[{$pos}][field]" type="hidden" value="" />
		<input class="label" readonly="readonly" type="text" value="" />
	</td>
	<td class="not" style="text-align:center;" >
		<input name="as[{$pos}][not]" type="checkbox" />
	</td>
	<td class="cs" style="text-align:center;" >&nbsp;</td>
	<td class="condition" style="text-align:center;" >
		<?php echo $slctBoolean->element(); ?>
	</td>
	<td class="value" style="text-align:left;" ></td>
	<td class="cntrl" style="text-align:right;" >
		<button 
			class="wa_search_add wgt-button" ><i class="icon-plus-sign" ></i></button><button 
				class="wa_remove_line wgt-button" ><i class="icon-remove-sign" ></i></button>
	</td>
</tr>
</script>

<script id="wgt-tpl-search-date" type="text/html" >
<tr>
	<td class="ao" >
		<select name="as[{$pos}][con]" >
			<option>AND</option>
			<option>OR</option>
		</select>
	</td>
	<td class="field" style="text-align:right;" >
		<input class="field" name="as[{$pos}][field]" type="hidden" value="" />
		<input class="label" readonly="readonly" type="text" value="" />
	</td>
	<td class="not" style="text-align:center;" >
		<input name="as[{$pos}][not]" type="checkbox" />
	</td>
	<td class="cs" style="text-align:center;" >&nbsp;</td>
	<td class="condition" style="text-align:center;" >
		<?php echo $slctDate->element(); ?>
	</td>
	<td class="value" style="text-align:left;" >
		<input type="text" />
	</td>
	<td class="cntrl" style="text-align:right;" >
		<button 
			class="wa_search_add wgt-button" ><i class="icon-plus-sign" ></i></button><button 
				class="wa_remove_line wgt-button" ><i class="icon-remove-sign" ></i></button>
	</td>
</tr>
</script>

<script id="wgt-tpl-search-id" type="text/html" >
<tr>
	<td class="ao" >
		<select name="as[{$pos}][con]" >
			<option>AND</option>
			<option>OR</option>
		</select>
	</td>
	<td class="field" style="text-align:right;" >
		<input class="field" name="as[{$pos}][field]" type="hidden" value="" />
		<input class="label" readonly="readonly" type="text" value="" />
	</td>
	<td class="not" style="text-align:center;" >
		<input name="as[{$pos}][not]" type="checkbox" />
	</td>
	<td class="cs" style="text-align:center;" >
	</td>
	<td class="condition" style="text-align:center;" >
		<?php echo $slctId->element(); ?>
	</td>
	<td class="value" style="text-align:left;" >
		<input type="text" />
	</td>
	<td class="cntrl" style="text-align:right;" >
		<button 
			class="wa_search_add wgt-button" ><i class="icon-plus-sign" ></i></button><button 
				class="wa_remove_line wgt-button" ><i class="icon-remove-sign" ></i></button>
	</td>
</tr>
</script>

<script id="wgt-tpl-search-numeric" type="text/html" >
<tr>
	<td class="ao" >
		<select name="as[{$pos}][con]" >
			<option>AND</option>
			<option>OR</option>
		</select>
	</td>
	<td class="field" style="text-align:right;" >
		<input class="field" name="as[{$pos}][field]" type="hidden" value="" />
		<input class="label" readonly="readonly" type="text" value="" />
	</td>
	<td class="not" style="text-align:center;" >
		<input name="as[{$pos}][not]" type="checkbox" />
	</td>
	<td class="cs" style="text-align:center;" >
	</td>
	<td class="condition" style="text-align:center;" >
		<?php echo $slctNumeric->element(); ?>
	</td>
	<td class="value" style="text-align:left;" >
		<input type="text" />
	</td>
	<td class="cntrl" style="text-align:right;" >
		<button 
			class="wa_search_add wgt-button" ><i class="icon-plus-sign" ></i></button><button 
				class="wa_remove_line wgt-button" ><i class="icon-remove-sign" ></i></button>
	</td>
</tr>
</script>

<script id="wgt-tpl-search-text" type="text/html" >
<tr>
	<td class="ao" >
		<select name="as[{$pos}][con]" >
			<option>AND</option>
			<option>OR</option>
		</select>
	</td>
	<td class="field" style="text-align:right;" >
		<input class="field" name="as[{$pos}][field]" type="hidden" value="" />
		<input class="label" readonly="readonly" type="text" value="" />
	</td>
	<td class="not" style="text-align:center;" >
		<input name="as[{$pos}][not]" checked="checked" type="checkbox" />
	</td>
	<td class="cs" style="text-align:center;" >
		<input name="as[{$pos}][cs]" checked="checked" type="checkbox" />
	</td>
	<td class="condition" style="text-align:center;" >
		<?php echo $slctText->element(); ?>
	</td>
	<td class="value" style="text-align:left;" >
		<input name="as[{$pos}][value]" type="text" />
	</td>
	<td class="cntrl" style="text-align:right;" >
		<button 
			class="wa_search_add wgt-button" ><i class="icon-plus-sign" ></i></button><button 
				class="wa_remove_line wgt-button" ><i class="icon-remove-sign" ></i></button>
	</td>
</tr>
</script>

<script id="wgt-tpl-search-text_strict" type="text/html" >
<tr>
	<td class="ao" >
		<select name="as[{$pos}][con]" >
			<option>AND</option>
			<option>OR</option>
		</select>
	</td>
	<td class="field" style="text-align:right;" >
		<input class="field" name="as[{$pos}][field]" type="hidden" value="" />
		<input class="label" readonly="readonly" type="text" value="" />
	</td>
	<td class="not" style="text-align:center;" >
		<input name="as[{$pos}][not]" type="checkbox" />
	</td>
	<td class="cs" style="text-align:center;" >
		<input name="as[{$pos}][cs]" type="checkbox" />
	</td>
	<td class="condition" style="text-align:center;" >
		<?php echo $slctTextStrict->element(); ?>
	</td>
	<td class="value" style="text-align:left;" >
		<input type="text" />
	</td>
	<td class="cntrl" style="text-align:right;" >
		<button 
			class="wa_search_add wgt-button" ><i class="icon-plus-sign" ></i></button><button 
				class="wa_remove_line wgt-button" ><i class="icon-remove-sign" ></i></button>
	</td>
</tr>
</script>


<div id="wgt_progress_bar" style="display:none;position:absolute;left:50%;top:400px;" >
  <?php echo Wgt::image('wgt/loader.gif',array('alt'=>'progress'),true); ?>
</div>

<div id="wgt_template_container" style="display:none;" class="meta" >

  <div id="wgt_template_tab_container"  >
    <div class="wgt-container-controls">
      <div class="wgt-container-buttons"></div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container" >&nbsp;</div>
        </div>
      </div>
    </div>
  </div>

  <div id="wgt_template_tab_head" >
    <span class="tab ui-corner-top" >
      <span class="label" ><a></a></span>
    </span>
  </div>

  <div id="wgt-template-dialog" >
    <div title="{$title}" >
      <p>{$message}</p>
    </div>
  </div>

  <div id="dialogTemplate" class="template window ui-corner-all" >
    <div class="content"></div>
    <div class="wgt-container-buttons"><button class="standard template"></button></div>
    <button class="close" title="Close Window">X</button>
    <div class="wgt-window-layer inactive"></div>
  </div>

  <div id="wgtidFileUpload" class="meta" >
    <iframe id="wgtidFrameUpload" name="fileUpload" ></iframe>
  </div>

</div>

<div id="wgt_data_container" class="meta" ></div>
<div id="wgt_tmp_container" class="meta" ></div>
<div id="wgt-context-container" style="display:none;" ></div>


