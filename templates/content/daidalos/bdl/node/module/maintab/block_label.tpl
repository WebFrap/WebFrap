<fieldset class="wgt-space bw61" >
  <legend>Labels</legend>
  
  <div id="wgt-i18n-list-<?php echo $idPrefix ?>-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    <?php 
      echo WgtForm::input
      ( 
        'Label', 
        'module-new-label-text', 
        '',
        array
        ( 
          'name' => 'label[text]',
          'class' => 'medium wgte-text'
        )  
      ); 
    ?>
    
    <?php 
      echo WgtForm::decorateInput
      ( 
        'Lang', 
        'wgt-select-'.$idPrefix.'-new-label-lang', 
        <<<HTML
<select 
      id="wgt-select-{$idPrefix}-new-label-lang" 
      name="label[lang]" 
      data_source="select_src-{$idPrefix}-lang"
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
          $idPrefix.'-label-'.$lang, 
          $label, array
          (
            'name' => $nodeKey.'[label]['.$lang.']',
            'class' => 'medium lang-'.$lang
          ), 
          $formId,
          '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
        ).'</li>';
      }
    ?>
    </ul>
  </div>
  
  <var id="wgt-i18n-list-<?php echo $idPrefix ?>-label-cfg-i18n-input-list" >
  {
    "key":"<?php echo $idPrefix ?>-label",
    "inp_prefix":"<?php echo $nodeKey ?>[label]",
    "form_id":"<?php echo $formId; ?>"
  }
  </var>
  
  </div>
  
</fieldset>