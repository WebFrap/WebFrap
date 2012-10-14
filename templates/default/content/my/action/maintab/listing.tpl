<form
  method="post"
  accept-charset="utf-8"
  class="<?php echo $VAR->formClass?>"
  id="<?php echo $VAR->formId?>"
  action="<?php echo $VAR->formAction?>" ></form>

<div id="wgt-form-my_task-table-crud" style="display:none" >

  <div class="wgt-panel title" >
    <button class="wgt-button wgtac_create" ><?php echo $this->icon('control/save.png','Create');  ?> Create</button>
    <button class="wgt-button wgtac_cancel" ><?php echo $this->icon('control/close.png','Cancel');  ?> Cancel</button>
  </div>
    
  <!-- Tab Details -->
  <div  class="wgt_tab <?php echo $this->tabId?>" 
    id="<?php echo $this->id?>_tab_my_task_details"
    title="<?php echo $I18N->l('Task','wbfsys.task.label')?>"  >
    
  <fieldset class="wgt-space" >
    <legend>
      <span onclick="$S('#wgt-box-my_task-default').iconToggle(this);">
        <?php echo Wgt::icon('control/opened.png','xsmall',$I18N->l('Open','wbf.label'))?>
      </span>
      Default
    </legend>
    <div id="wgt-box-my_task-default" >
      <?php echo $ITEM->inputMyTaskVid?>

      <?php echo $ITEM->inputMyTaskIdVidEntity?>

      <div class="left full" >
        <?php echo $ITEM->inputMyTaskTitle?>
      </div>
      <div class="left half" >
        <?php echo $ITEM->inputMyTaskIdStatus?>
        <?php echo $ITEM->inputMyTaskProgress?>
        <?php echo $ITEM->inputMyTaskMParent?>
        <?php echo $ITEM->inputMyTaskHttpUrl?>
      </div>
      <div class="inline half" >
        <?php echo $ITEM->inputMyTaskIdType?>
        <?php echo $ITEM->inputMyTaskPriority?>
        <?php echo $ITEM->inputMyTaskIdPrincipal?>
        <?php echo $ITEM->inputMyTaskIdResponsible?>
      </div>
  
      <div class="wgt-clear small">&nbsp;</div>
      
    </div>
  </fieldset>

  <fieldset class="wgt-space" >
    <legend>
      <span onclick="$S('#wgt-box-my_task-description').iconToggle(this);">
        <?php echo Wgt::icon('control/opened.png','xsmall',$I18N->l('Open','wbf.label'))?>
      </span>
      Description
    </legend>
    <div id="wgt-box-my_task-description" >
    <div class="left half" >
    </div>
    <div class="inline half" >
    </div>
    <div class="left full" >
      <?php echo $ITEM->inputMyTaskDescription?>
    </div>

      <div class="wgt-clear small">&nbsp;</div>
    </div>
  </fieldset>

  <fieldset class="wgt-space" >
    <legend>
      <span onclick="$S('#wgt-box-my_task-meta').iconToggle(this);">
        <?php echo Wgt::icon('control/opened.png','xsmall',$I18N->l('Open','wbf.label'))?>
      </span>
      Meta
    </legend>
    <div id="wgt-box-my_task-meta" style="display:none" >
    <div class="left half" >
      <?php echo $ITEM->inputMyTaskMRoleChange?>
      <?php echo $ITEM->inputMyTaskMTimeChanged?>
      <?php echo $ITEM->inputMyTaskRowid?>
    </div>
    <div class="inline half" >
      <?php echo $ITEM->inputMyTaskMUuid?>
      <?php echo $ITEM->inputMyTaskMVersion?>
      <?php echo $ITEM->inputMyTaskMRoleCreate?>
      <?php echo $ITEM->inputMyTaskMTimeCreated?>
    </div>

      <div class="wgt-clear small">&nbsp;</div>
    </div>
  </fieldset>

  </div>

  <div class="wgt-clear small">&nbsp;</div>
  
  <div class="wgt-panel title wgt-border-top" >
    <h2><?php echo $I18N->l( 'Overview', 'wbf.label' )?></h2>
  </div>

</div>





    <form
    method="post"
    accept-charset="utf-8"
    class="<?php echo $VAR->searchFormClass?>"
    id="<?php echo $VAR->searchFormId?>"
    action="<?php echo $VAR->searchFormAction?>" >

    <div id="wgt-search-table-my_task-advanced"  style="display:none" >

    <div class="wgt-panel title" >
      <h2><?php echo $I18N->l('Advanced Search','wbf.label')?></h2>
    </div>


      <div id="wgt_tab-table-my_task-search" class="wcm wcm_ui_tab"  >
        <div id="wgt_tab-table-my_task-search-head" class="wgt_tab_head" ></div>

        <div class="wgt_tab_body" >

          <div
          class="wgt_tab wgt_tab-table-my_task-search"
          id="wgt_tab-my_task-search-default"
          title="Default" >
           <div class="left full" >
          <?php echo $ITEM->inputMyTaskSearchTitle?>
        </div>
        <div class="left half" >
          <?php echo $ITEM->inputMyTaskSearchHttpUrl?>
        </div>
        <div class="inline half" >
          <?php echo $ITEM->inputMyTaskSearchIdStatus?>
          <?php echo $ITEM->inputMyTaskSearchIdType?>
        </div>

          <div class="wgt-clear xxsmall">&nbsp;</div>
        </div>


          <div
            class="wgt_tab wgt_tab-table-my_task-search"
            id="wgt_tab-table-my_task-search-meta"
            title="Meta" >

            <div class="left half" >
              <?php echo $ITEM->inputMyTaskSearchMRoleCreate?>
              <?php echo $ITEM->inputMyTaskSearchMTimeCreatedBefore?>
              <?php echo $ITEM->inputMyTaskSearchMTimeCreatedAfter?>
              <div class="box_border" >&nbsp;</div>
            </div>

            <div class="inline half" >
              <?php echo $ITEM->inputMyTaskSearchMRoleChange?>
              <?php echo $ITEM->inputMyTaskSearchMTimeChangedBefore?>
              <?php echo $ITEM->inputMyTaskSearchMTimeChangedAfter?>
            </div>

            <div class="left half" >&nbsp;</div>

            <div class="inline half" >
              <?php echo $ITEM->inputMyTaskSearchMUuid?>
              <?php echo $ITEM->inputMyTaskSearchMRowid?>
            </div>

          </div>

        </div>

      </div>

      <div class="wgt-clear xxsmall">&nbsp;</div>

    </div>

  </form>




  <?php echo $ITEM->tableMyTask; ?>

  <div class="wgt-clear xsmall">&nbsp;</div>


<script type="text/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ITEM->$jsItem->jsCode?>
<?php } ?>
</script>
