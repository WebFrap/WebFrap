<div id="wgt-grid-message-mini_list" class="wgt-grid" >
  <var id="wgt-grid-message-mini_list-cfg-grid" >{
    "height":"small",
    "search_form":""
  }</var>
  <table id="wgt-grid-message-mini_list-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
    <thead>
      <tr>
        <th class="pos" >Pos:</th>
        <th style="width:150px;" >Title</th>
        <th style="width:120px;" >Sender</th>
        <th style="width:80px;" >Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $VAR->data as $entry ){

        $senderName = "{$entry['wbfsys_role_user_name']} <{$entry['core_person_lastname']}, {$entry['core_person_firstname']}> ";
        $date = '' != trim($entry['wbfsys_message_m_time_created'])
          ? $this->i18n->date($entry['wbfsys_message_m_time_created'])
          : ' ';
      ?>
      <tr>
        <td class="pos" ></td>
        <td><?php echo $entry['wbfsys_message_title']; ?></td>
        <td><?php echo $senderName; ?></td>
        <td><?php echo $date; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>