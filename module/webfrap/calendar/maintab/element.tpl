<!-- Menu left -->
<div 
  style="position:absolute;top:0px;left:0px;bottom:0px;width:199px;overflow:auto;" 
  class="wgt-border-right" >

<div class="wgt-panel" ><h2>Calendar List</h2></div>
  <div id="wgt-tree-message-navigation" >
    <ul id="wgt-tree-message-navigation-tree" class="wgt-tree wgt-space" >
      
      <li><input
        type="checkbox"
        name="channel[inbox]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Global Calendar</strong></a></li>
      <li><input
        type="checkbox"
        name="channel[inbox]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Company Calendar</strong></a></li>
      <li><input
        type="checkbox"
        name="channel[inbox]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Team Calendar</strong></a></li>
      <li><input
        type="checkbox"
        name="channel[inbox]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Personal Calendar</strong></a></li>
        
      <li>
        <h3>Role Calendar <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></h3>
        <ul>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::MESSAGE ?>"
            class="fparam-wgt-form-webfrap-groupware-search" /> Staff </li>
            
        </ul>
      </li>
      
      <li>
        <h3>Data Calendar <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></h3>
        <ul>
          <li>
            <h4>Projects</h4>
            <ul>
              <li><input
                type="checkbox"
                name="aspect[]"
                value="<?php echo EMessageAspect::MESSAGE ?>"
                class="fparam-wgt-form-webfrap-groupware-search" /> Staff </li>
            </ul>
          </li>
          <li>
            <h4>Events</h4>
            <ul>
              <li><input
                type="checkbox"
                name="aspect[]"
                value="<?php echo EMessageAspect::MESSAGE ?>"
                class="fparam-wgt-form-webfrap-groupware-search" /> Staff </li>
            </ul>
          </li>
            
        </ul>
      </li>
        
    </ul>
  </div>
</div>

<!-- Main Content / calendar -->
<div 
  style="position:absolute;top:0px;left:200px;right:0px;bottom:0px;padding:15px;overflow:auto;" >

    <form id="wgt-form-calendar-webfrap-main" action="ajax.php?Webfrap.Calendar.search" method="GET" ></form>
  
    <div
      class="wcm wcm_ui_calendar"
      id="wgt-calendar-webfrap-main" style="width:950px;height:600px;"  ></div>

</div>
