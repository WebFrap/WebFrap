<h1>Standard Checkliste zum für Softwaretests vor dem Deployment</h1>

<?php 

$level = array(
  0  => 'Perfect',
  1  => 'Typo',
  2  => 'Layout',
  4  => 'Domain',
  8  => 'Warning',
  16  => 'Tech Error',
);

$browsers = array
(
  'FF'  => 'Firefox', 
  'IE'  => 'Internet Explorer', 
  'CHR' => 'Chrome', 
  'CHRL' => 'Chromeless', 
  'OP'   => 'Opera', 
  'SAF'  => 'Safari', 
);

$checks = array
(
  'CRUD'  => array
  ( 
    'create_default' => array
    ( 
      'Ein Non-Custom Create Form aufrufen', 
      'Fehlermeldungen, Schreibfehler, verschobenes Layout', 
    ),
  ),
  'Table'  => array
  ( 
    'maintab_list_def' => array
    ( 
      '', 
      '', 
    ),
  )
);

?>


<table class="doc_grid" style="width:800px;border:1px solid silver;" >
  <thead>
    <tr>
      <th style="width:150px;" >Key.</th>
      <th style="width:370px;" >Desc.</th>
      <th style="width:200px;" >Fail.</th>
      <th style="width:80px;" >FF/IE/CHR/CHRL/OP/SAF</th>
    </tr>
  </thead>
  <tbody>
    <!-- CRUD Mask -->
    <tr class="head" >
      <td colspan="3" style="text-align:left;" >CRUD</td>
    </tr>
    <tr>
      <td >Create Default</td>
      <td>Ein Non-Custom Create Form aufrufen</td>
      <td>Fehlermeldungen, Schreibfehler, verschobenes Layout</td>
      <td class="centered" >
        <input type="checkbox" name="ff[crud][def_create]" />
        <input type="checkbox" name="ff[crud][def_create]" />
      </td>
    </tr>
    <tr>
      <td>Insert Default</td>
      <td>Insert </td>
      <td class="centered" ><input type="checkbox" name="crud[def_insert]" /></td>
    </tr>
    <tr>
      <td >Edit Default</td>
      <td>Ein Standard Edit Form aufrufen</td>
      <td class="centered" ><input type="checkbox" name="crud[def_edit]" /></td>
    </tr>
    <tr>
      <td>Update Default</td>
      <td>Von den Standard Edit Form aus speichern</td>
      <td class="centered" ><input type="checkbox" name="crud[insert]" /></td>
    </tr>
    <tr class="head" >
      <td colspan="3" style="text-align:left;" >Table</td>
    </tr>
    <tr class="head" >
      <td colspan="3" style="text-align:left;" >Table Ref</td>
    </tr>
    <tr class="head" >
      <td colspan="3" style="text-align:left;" >Treetable</td>
    </tr>
    <tr class="head" >
      <td colspan="3" style="text-align:left;" >Treetable Ref</td>
    </tr>
  </tbody>
</table>


