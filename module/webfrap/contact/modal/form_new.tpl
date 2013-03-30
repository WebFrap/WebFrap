<?php 

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm  = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Contact.insert',
  'webfrap-contact-create',
  'post'
);
$cntForm->form();



?>
<fieldset>
  <legend>Message</legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $cntForm->input
          ( 
          	 'Subject', 
          	 'subject', 
            '', 
            array(), 
            array
            (
            	 'size'=>'xxlarge'
              )  
          ); ?>
        </td>
      </tr>
      
      <tr>
        <td colspan="2" >
        
        
        <?php  $cntForm->ratingbar
        ( 
          'Importance', 
          'importance', 
          2,
          array
          ( 
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
          ),
          array(),
          array( 'starParts' => 1 )
        ); ?>
        </td>
      </td>

      <tr>
        <td>
        </td>
        <td valign="bottom" align="right"  >
          <div style="padding-top:15px;" >
            <?php $cntForm->submit( 'Send Message', '$S.modal.close();' ); ?>
          </div>
        </td>
      </tr>
    </table>

</fieldset>