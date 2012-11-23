<div id="imap_mailboxes">

<?php
foreach ( $VAR->mailboxes as $mb )
{
  echo '<a href="ajax.php?c=Daidalos.Mail.mbox&mbox='.$mb . '" class = "wcm wcm_req_ajax">'.$mb.'</a><br />';
}

?>
</div>

<div id="imap_mails">
  <table>
    <thead>
    <tr>
    <td>From</td><td>Subject</td><td>Size</td>
    </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<div id="imap_body">
  <div>
  </div>
</div>