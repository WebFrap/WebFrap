
  <div id="wbf-body">

    <div id="wbf-ui-panel" class="ui-widget-header" >
      <div class="wgt-menu" >

        <div class="wgt-piece left" style="width:600px;overflow:hidden;" >

        <div class="inline" >
          <a href="./setup.php" style="border:0px;" >
            <img src="<?php echo View::$webImages ?>wgt/header.png" alt="header"  />
          </a>
        </div>
        <div class="inline" >
          <img src="<?php echo View::$webImages ?>wgt/menu.separator.png" alt="sep"  />
        </div>
        <div class="inline" style="padding-top:3px;padding-left:5px;padding-right:5px;"  >
         <h2>SETUP</h2>
        </div>

        <div class="inline" >
          <img src="<?php echo View::$webImages ?>wgt/menu.separator.png" alt="sep"  />
        </div>

        <div class="right" >
          <img src="<?php echo View::$webImages ?>wgt/bg_panel_changeover.png" alt="header"  />
        </div>

        </div>

        <div id="wbf-maintab_bar" class="bar" >
          <div id="wgt-maintab-head" ></div>
        </div>

    </div>

  </div>


  <div id="wbf-menu">
    <div id="wbf-menu-panel">
      <span class="close-accordion"  >
      <b>&lt;&lt;</b>
       </span>
    </div>
    <div id="wbf-inner-menu" >
      <div class="wcm wcm_ui_accordion" >
        <h3><a href="dashboard">Dashboard</a></h3>
        <div class="ac_body" >
          <div id="wgt_tree_"  >
            <ul class="wcm wcm_ui_tree" >
              <li class="file" >
                <a href="maintab.php?c=Webfrap.Setup.start" class="wcm wcm_req_win file" >
                  <img src="../WebFrap_Icons_Default/icons/default/xsmall/control/folder.png" alt="Array"  class="icon xsmall" />
                  Start
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div id="wbf-content">

    <!-- page -->
    <div  id="wbf-inner-content" >
    <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE)) ?>
    </div>
    <!-- end page -->

  </div>

  <div id="wbf-footer-history" >
    <table>
      <thead class="ui-widget-header ui-state-active" >
        <th class="footer_status">Status</th>
        <th class="footer_time">Time</th>
        <th class="footer_message">Message</th>
      </thead>
      <tbody class="ui-widget-content" ></tbody>
    </table>
  </div>

  <div id="wbf-footer" class="wcm wcm_mwin_footer" >
    <table id="footer_status"  >
      <tbody>
        <tr>
          <td class="footer_status" ></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

<?php echo $this->includeTemplate( 'window' , 'index' ) ?>
