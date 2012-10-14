<div class="wgt-panel title" >
  <h2>Layout Elemente</h2>
</div>

<div class="wgt-panel" >
  <h2>Layout Elemente normales Panel</h2>
</div>


<p>Beispiele für Layouts und Positionierung von Boxen<p>

<!-- 1 col -->

<div class="full" >
  full
</div>

<!-- 2 cols -->

<div class="left half" >
  1/2 1
</div>

<div class="inline half" >
 1/2 2
</div>

<!-- 3 cols -->

<div class="left third" >
 1/3 1
</div>

<div class="inline third" >
 1/3 2
</div>

<div class="inline third" >
 1/3 3
</div>

<!-- 2 cols -->

<div class="left third" >
 1/3 1
</div>

<div class="inline two_thid" >
 2/3 2
</div>

<!-- 4 cols -->

<div class="left fourth" >
 1/4
</div>

<div class="inline fourth" >
 1/4
</div>

<div class="inline fourth" >
 1/4
</div>

<div class="inline fourth" >
 1/4
</div>


<!-- only right -->

<div class="right fourth" >
 1/4
</div>

<!-- danach muss geklärt werden -->
<div class="wgt-clear" ></div>

<div class="left fourth" >
 1/4
</div>

<div class="left fourth" >
 1/4
</div>

<!-- Hier wird ein abstandhalter benötigt der das floating problem fixt -->
<div class="wgt-clear xsmall" ></div>

<!-- Es gibt Abstandhalter -->
<div class="wgt-panel" >
<h2>Abstandhalter</h2>
</div>


<p>Zeile 1</p>
<div class="wgt-clear xsmall" ></div>

<p>Zeile 2</p>
<div class="wgt-clear small" ></div>

<p>Zeile 3</p>
<div class="wgt-clear medium" ></div>


<div class="wgt-panel" >
<h2>Rich Elements</h2>
</div>

<p>
  Ein paar Regeln vorweg.
  Der Hauptknoten eines Elements bekommt IMMER eine einedeutige HTML Id,
  um das Element später adressieren zu können, und vor allem weil viele
  ohne ID einfach die Arbeit verweigern.

  Das die Elemente eine vom User generierte ID erzwingen ist gewollt.
  Der Vergessen der ID zählt mindestens als medium Bug.
</p>

<div class="wgt-clear medium" ></div>
<h3>Tabs</h3>

<div id="wgt-tab-example" class="wcm wcm_ui_tab wgt-border" style="height:300px;" >
  <div id="wgt-tab-example-head" class="wgt_tab_head" ></div>

  <div id="wgt-tab-example-body" class="wgt_tab_body" >

    <div id="tab-fu" title="Fuuuu" class="wgt_tab wgt-tab-example" >
      Fu
    </div>

    <div id="tab-bar" title="BAAAR" class="wgt_tab wgt-tab-example" >

    <!--
      Tabs sind schachtelbar
      Das funktioniert, da jeder Tab in der die id des containers als klasse hat
     -->
    <div id="wgt-tab-example-inner" class="wcm wcm_ui_tab wgt-border" style="height:270px;" >
      <div id="wgt-tab-example-inner-head" class="wgt_tab_head" ></div>

        <div id="wgt-tab-example-inner-body" class="wgt_tab_body" >

          <div id="tab-fu-inner" title="Fuuuu" class="wgt_tab wgt-tab-example-inner" >
            So bin drin wer noch?
          </div>

          <div id="tab-bar-inner" title="BAAAR" class="wgt_tab wgt-tab-example-inner" >
            Der andere Tab
          </div>

        </div>

      </div>

      <!--
       wgt-clear wird benötigt um das floating problem zu beheben.
       Eines der wichtigsten elemente praktisch
       -->
      <div class="wgt-clear xsmall" ></div>
    </div>

  </div>

</div>

<div class="wgt-clear medium" ></div>
<h3>Accordion</h3>

<p> Das Accordion nimmt sich immer die maximal verfübgare breite und höhe</p>

<div style="height:400px;width:50%" >
  <div id="wgt_accordion-example" class="wcm wcm_ui_accordion" >

    <h3><a href="accord1">AC 1</a></h3>
    <div class="ac_body" >
      Inhalt 1
    </div>

    <h3><a href="accord2">AC 2</a></h3>
    <div class="ac_body" >
      Inhalt 2
    </div>

  </div>
  <div class="wgt-clear xsmall" ></div>
</div>

<div class="wgt-clear medium" ></div>
<h3>Tree</h3>

<div id="wgt_tree-example"  >
<ul class="wcm wcm_ui_tree" >
  <li class="file" >
    <a href="maintab.php?c=Webfrap.Navigation.explorer" class="wcm wcm_req_win file" ><img src="../WebFrap_Icons_Default/icons/default/xsmall/control/folder.png" alt="Array"  class="icon xsmall" /> Explorer</a>
  </li>
  <li class="folder" >
   <span class="folder" >My Data</span>

    <ul>
            <li class="file" >
    <a href="maintab.php?c=My.Profile.listing" class="wcm wcm_req_win file" ><img src="../WebFrap_Icons_Default/icons/default/xsmall/control/entity.png" alt="Array"  class="icon xsmall" /> My Profile</a>
  </li>
  <li class="file" >
    <a href="maintab.php?c=My.Messages.inbox" class="wcm wcm_req_win file" ><img src="../WebFrap_Icons_Default/icons/default/xsmall/control/entity.png" alt="Array"  class="icon xsmall" /> My Messages</a>
  </li>

  <li class="file" >
    <a href="maintab.php?c=My.Appointments.listing" class="wcm wcm_req_win file" ><img src="../WebFrap_Icons_Default/icons/default/xsmall/control/entity.png" alt="Array"  class="icon xsmall" /> My Appointments</a>
  </li>
  <li class="file" >
    <a href="maintab.php?c=My.Tasks.listing" class="wcm wcm_req_win file" ><img src="../WebFrap_Icons_Default/icons/default/xsmall/control/entity.png" alt="Array"  class="icon xsmall" /> My Tasks</a>
  </li>

    </ul>

  </li>

</ul>
</div>


<div class="wgt-clear medium" ></div>
<h3>Grid</h3>

<p>Beispiel für ein Advanced Grid</p>

<div id="wgt-table-example-grid" class="wgt-grid" >
  <div class="wgt-panel" >
        <input type="text" name="free_search" id="wgt-search-example-grid" class="huge wcm wcm_req_search wgt-no-save asgd-wgt-form-example-grid-search" />

        <button onclick="$R.form('wgt-form-example-grid-search');return false;" class="wgt-button inline" >
          <?php echo $this->icon('control/search.png','Search','xsmall'); ?> Search
        </button>

        <button onclick="$UI.table('table#wgt-table-example-grid-table').cleanFilter();$UI.resetForm('wgt-form-example-grid-search');$R.form('wgt-form-example-grid-search');return false;" title="With this button, you can reset the search, and load the original table." class="wgt-button right" >
          <?php echo $this->icon('control/reset.png','Reset'); ?> Reset
        </button>

              <button
          onclick="$S('#wgt-search-table-project_project_mask_capa-advanced').toggle();$UI.resetForm('wgt-form-example-grid-search');return false;"
          class="wcm wcm_ui_button wcm_ui_info"
          title="Didn't find what you where searching for? Not enought options? Try the advanced Search."
          >
          <?php echo $this->icon('control/show_advanced.png','Advanced'); ?> Advanced Search
        </button>

  </div>

  <table id="wgt-table-example-grid-table" class="wgt-grid wcm wcm_ui_grid" >
    <thead>
      <tr>
        <th style="width:175px" >Name</th>
        <th style="width:175px" >Data</th>
        <th style="width:175px" >Schedule</th>
        <th style="width:175px" >Tasks</th>
        <th style="width:185px;">Nav.</th>
      </tr>
    </thead>
    <tbody>
      <tr class="row1" id="wgt-table-example-grid_row_20005" >
        <td valign="top" >Ein Name</td>
        <td valign="top" >Hallo Welt</td>
        <td valign="top" ><em>start: </em>2010-10-01<br /><em>end: </em>2013-09-30</td>
        <td valign="top" >
        <ul>
          <li><span>Fu</span></li>
          <li><span>bar</span></li>
        </ul>
        </td>
        <td valign="top" style="text-align:center;" class="wcm wcm_ui_buttonset" >
          <button
            onclick="$R.get('maintab.php?c=Project.ProjectMaskCapa.edit&amp;objid=20005');return false;"
            class="wcm wcm_ui_info"
            title="Show" ><?php echo $this->icon('control/show.png','Show'); ?></button>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="wgt-panel wgt-border_top" >
   <div class="right menu"  ><span>found <strong class="wgt-num-entry" >1</strong> entries</span> </div>
   <div class="menu" style="float:left;" style="width:100px;" > </div>

   <div class="menu"  style="text-align:center;margin:0px auto;" >
    <span class="wgt_char_filter" >
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="c=?" > ? </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=A" > A </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=B" > B </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=C" > C </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=D" > D </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=E" > E </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=F" > F </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=G" > G </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=H" > H </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=I" > I </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=J" > J </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=K" > K </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=L" > L </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=M" > M </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=N" > N </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=O" > O </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=P" > P </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=Q" > Q </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=R" > R </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=S" > S </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=T" > T </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=U" > U </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=V" > V </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=W" > W </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=X" > X </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=Y" > Y </a> |
      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=Z" > Z </a> |

      <a class="wcm wcm_req_page wgt-form-example-grid-search" href="b=" ><?php echo $this->icon('control/cancel.png','Clear'); ?></a></span>
    </div>
  </div>

</div>



<!--

Am Boden haben wir immer einen künstlichen Abstandhalter
Der ist gewollt, wenn wir da einen standard abstand reinhauen können wir nämlich
keine elemente der bauen die bis zum bode den ganzen platz einnehmen.
Daher gibts in den Tabs auch keinen standard ausenabstand

 -->
<div class="wgt-clear medium" ></div>