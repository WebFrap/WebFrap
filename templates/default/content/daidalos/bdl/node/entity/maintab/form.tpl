<?php 

$thisPath = dirname(__FILE__).'/';
$basePath = realpath(dirname(__FILE__).'/../../base/maintab/').'/';


$entity = $VAR->node;
/*@var $entity BdlNodeEntity */

$idPrefix   = 'entity-'.$entity->getName();
$nodeKey    = 'entity';
$formId     = 'wgt-form-bdl_'.$idPrefix;


$iconDel  = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconAdd  = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );
$iconEdit = Wgt::icon( 'control/edit.png', 'xsmall', 'Edit' );

$iconAttrIndex = Wgt::icon( 'daidalos/table/index.png', 'xsmall', 'Index' );
$iconAttrKey = Wgt::icon( 'daidalos/table/key.png', 'xsmall', 'Key' );
$iconAttrRequired = Wgt::icon( 'daidalos/table/required.png', 'xsmall', 'Required' );
$iconAttrUnique = Wgt::icon( 'daidalos/table/unique.png', 'xsmall', 'Unique' );


$labels       = $entity->getLabels();
$shortDescs   = $entity->getShortDesc();
$docus        = $entity->getDocus();



$langs = $this->model->getLanguages();

$langCode = array( '{"i":"0","v":"Select a language"}' );

if( $langs )
{
  foreach( $langs as $lang )
  {
    $langCode[] = '{"i":"'.$lang['id'].'","v":'.json_encode($lang['value']).'}';
  }
}

$langCode = implode( ','.NL, $langCode  );

?>

<var id="select_src-entity-lang" >
[
<?php echo $langCode; ?>
]
</var>

<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_Entity.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
  method="put"
></form>

<div id="<?php echo $this->tabId ?>" class="wcm wcm_ui_tab" >
  <div class="wgt_tab_body" >
    <!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->



  <!-- tab name:default -->
  <div
    class="wgt_tab <?php echo $this->tabId ?>"
    id="<?php echo $this->tabId ?>-tab-base_data"
    title="Base Data"
    
     >


<fieldset class="wgt-space bw61" >
  <legend>Entity Data</legend>
  
  <div class="left bw3" >
    <?php 
    echo WgtForm::input
    ( 
      array
      (
        'Name',
        <<<HTML
Der Name der Entity.<br />
Wird auch der Name in der Datenbank.<br />

Bsp:

entity name: project_task<br />

wird zu:<br />
Datenbank Tabelle: project_task,<br />
Orm Entity: ProjectTask_Entity<br />
Es wird ein Standard Management mit dem Namen project_task angelegt.<br />

etc.
HTML
      ), 
      'entity-name', 
      $entity->getName(), 
      array
      (
        'name'=>'entity[name]'
      ), 
      $formId 
    );  
    
    echo WgtForm::input
    ( 
      array
      (
        'Module',
        <<<HTML
Über Module kann definiert werden in welchem Module eine Entity abgelegt werden soll.
Ist kein Module definiert wird der erste Abschnitt des Namens als Module verwendet.
HTML
      ), 
      'entity-module', 
      $entity->getModule(), 
      array
      (
        'name' => 'entity[module]'
      ), 
      $formId 
    ); 
    ?>
  </div>
  
  <div class="right bw3" >
    <?php 
    echo WgtForm::input
    ( 
      array
      (
        'Table Type',
        <<<HTML
Bestimmt den Typ der Tabelle.
Ohne spezifizierung bekommt jede Tabelle Standard Attribute hinzugefügt.

<ul>
  <li>rowid</li>
  <li>m_uuid</li>
  <li>m_time_created</li>
  <li>m_role_create</li>
  <li>m_time_changed</li>
  <li>m_role_change</li>
  <li>m_version</li>
</ul>

Über den Type der Tabelle kann gesteuert werden welche Attribute hinzugefügt
werden sollen, bzw. ob überhaupt Attribute hinzugefügt werden können.

HTML
      ), 
      'entity-table_type', 
      $entity->getTableType(), 
      array
      (
        'name'=>'entity[table_type]'
      ), 
      $formId 
    );  
    
    echo WgtForm::input
    ( 
      array
      (
        'Architecture Type',
        <<<HTML
Mit dem Architecture Type einer Tabelle kann definiert werden wieviel Code
für diese Tabelle generiert werden soll.<br />
Für einige Tabellen ist es z.B. nicht nötig mehr als eine Entity zu generieren.
HTML
      ), 
      'entity-arch_type', 
      $entity->getArchType(), 
      array
      (
        'name' => 'entity[arch_type]'
      ), 
      $formId 
    ); 
    ?>
  </div>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Labels</legend>
  
  <div id="wgt-i18n-list-entity-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    <?php 
      echo WgtForm::input
      ( 
        'Label', 
        'entity-new-label-text', 
        '',
        array
        ( 
          'name'  => 'label[text]',
          'class' => 'medium wgte-text'
        )  
      ); 
    ?>
    
    <?php 
      echo WgtForm::decorateInput
      ( 
        'Lang', 
        'wgt-select-entity-new-label-lang', 
        <<<HTML
<select 
      id="wgt-select-entity-new-label-lang" 
      name="label[lang]" 
      data_source="select_src-entity-lang"
      class="wcm wcm_widget_selectbox wgte-lang"
        >
        <option>Select a language</option>
    </select>
HTML
      ); 
    ?>

    <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
  </div>
  
  <div class="right bw3" >
    <ul class="wgte-list"  >
    <?php 
      foreach( $labels as $lang => $label )
      {
        echo '<li class="lang-'.$lang.'" >'. WgtForm::input
        ( 
          'Lang '.Wgt::icon( 'flags/'.$lang.'.png', 'xsmall', array(), '' ), 
          'entity-label-'.$lang, 
          $label, array
          (
            'name'  => 'entity[label]['.$lang.']',
            'class' => 'medium lang-'.$lang
          ), 
          $formId,
          '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
        ).'</li>';
      }
    ?>
    </ul>
  </div>
  
  <var id="wgt-i18n-list-entity-label-cfg-i18n-input-list" >
  {
    "key":"entity-label",
    "inp_prefix":"entity[label]",
    "form_id":"<?php echo $formId; ?>"
  }
  </var>
  
  </div>
  
</fieldset>


      <div class="wgt-clear small" ></div>
     
<?php include $thisPath.'list_attributes.tpl' ?>

    </div>

<?php include $thisPath.'tab_references.tpl' ?>
<?php include $thisPath.'tab_ui.tpl' ?>
<?php include $basePath.'tab_shortdesc.tpl' ?>
<?php include $basePath.'tab_docu.tpl' ?>
<?php include $thisPath.'tab_access.tpl' ?>
    



  </div>
</div>

