
  <form 
    method="put"
    id="wgt-form-webfrap-docu-<?php echo $VAR->entity->access_key ?>-edit"
    action="ajax.php?c=Webfrap.Docu.save&amp;key=<?php echo $VAR->entity->access_key ?>" ></form>

  <fieldset>
    <legend>Doku</legend>
    <div class="full" style="height:600px;width:99%" >
      <textarea  
        name="content"
        class="wcm wcm_ui_wysiwyg asgd-wgt-form-webfrap-docu-<?php echo $VAR->entity->access_key ?>-edit"
        id="wgt-wysiwyg-docu-content-<?php echo $VAR->entity->access_key ?>"
        style="width:99%;height:600px;" ><?php 
    
    if( '' != trim($VAR->entity->content) )
      echo $VAR->entity->content;
    else 
      echo "This Page is still empty. Please add some Content.";
?></textarea>
    </div>
  </fieldset>


<div class="wgt-clear xxsmall">&nbsp;</div>

