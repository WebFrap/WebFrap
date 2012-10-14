<fieldset class="wgt-space bw61" >
  <legend>Titles</legend>
  
  <div id="wgt-i18n-list-<?php echo $idPrefix ?>-title" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    <?php 
      echo WgtForm::input
      ( 
        'Title', 
        $idPrefix.'-title-text', 
        '',
        array
        ( 
          'name'  => 'title[text]',
          'class' => 'medium wgte-text'
        )  
      ); 
    ?>
    
    <?php 
      echo WgtForm::decorateInput
      ( 
        'Lang', 
        'wgt-select-'.$idPrefix.'-title-lang', 
        <<<HTML
<select 
      id="wgt-select-{$idPrefix}-title-lang" 
      name="title[lang]" 
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
      foreach( $titles as $lang => $title )
      {
        echo '<li class="lang-'.$lang.'" >'. WgtForm::input
        ( 
          'Lang '.Wgt::icon( 'flags/'.$lang.'.png', 'xsmall', array(), '' ), 
          $idPrefix.'-title-'.$lang, 
          $title, array
          (
            'name'  => $nodeKey.'[title]['.$lang.']',
            'class' => 'medium lang-'.$lang
          ), 
          $formId,
          '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
        ).'</li>';
      }
    ?>
    </ul>
  </div>
  
  <var id="wgt-i18n-list-<?php echo $idPrefix ?>-title-cfg-i18n-input-list" >
  {
    "key":"<?php echo $idPrefix ?>-title",
    "inp_prefix":"<?php echo $nodeKey ?>[title]",
    "form_id":"<?php echo $formId; ?>"
  }
  </var>
  
  </div>
  
</fieldset>