
<div id="tab_my" class="wcm wcm_ui_tab" style="width:99%" >
  <div class="wgt_tab_head" ></div>
  <div class="wgt_tab_body" >

    <div id="my_task" class="wgt_tab" title="my tasks" style="height:250px;overflow:auto;" >

        <fieldset>
          <legend>filter</legend>

          <table>
            <tr>
              <td style="width:100px;" >Ideas <input type="checkbox" /></td>
              <td style="width:100px;" >Projects <input type="checkbox" /></td>
              <td style="width:100px;" >Proposals <input type="checkbox" /></td>
            </tr>

          </table>

        </fieldset>

        <div class="wgt-clear small"></div>

        <%=$tab%>
     </div>

   <div id="my_projects" class="wgt_tab" title="my projects" style="height:250px;overflow:auto;" >
      <%=$tab%>
   </div>

   <div id="my_appointments" title="my appointments" class="wgt_tab" style="height:250px;overflow:auto;" >
      <%=$tab%>
   </div>

   <div id="my_messages" title="my messages" class="wgt_tab" style="height:250px;overflow:auto;" >
      <%=$tab%>
   </div>

   <div id="my_bookmarks" title="my bookmarks" class="wgt_tab" style="height:250px;overflow:auto;" >

      <fieldset>
        <legend>filter</legend>

        <form>
          <input type="text" class="medium" /> <button class="wgt-button" ><%=$I18N->l('search','wfb.label.search')%></button>
        </form>

      </fieldset>

      <div class="wgt-clear small"></div>
      <div style="height:250px;overflow:auto;" ><%=$ITEM->widgetDesktopBookmark%></div>
   </div>

  </div>
</div>

<div class="wgt-clear medium" ></div>

<div id="tab_information" class="wcm wcm_ui_tab" style="width:99%" >
  <div class="wgt_tab_head" ></div>
  <div class="wgt_tab_body" >

   <div id="tab_information_news" class="wgt_tab" title="news" style="height:250px;overflow:auto;" >
      <%=$tab2%>
   </div>
   <div id="tab_information_events" class="wgt_tab" title="events" style="height:250px;overflow:auto;" >
      <%=$tab2%><%=$tab2%>
   </div>

  </div>
</div>

<div class="wgt-clear medium"></div>

