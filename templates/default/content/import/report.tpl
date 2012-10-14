<h2><%=$VAR->title%></h2>

<p><%=$VAR->message%></p>

<div>

  <table class="wgt-table" >
    <thead>
      <tr>
        <th>message</th>
      </tr>
    </thead>
    <tbody>
      <% foreach( $VAR->protocol->message as $message ){ %>
        <tr>
          <td><%=$message%></td>
        </tr>
      <% } %>
    </tbody>
  </table>

</div>