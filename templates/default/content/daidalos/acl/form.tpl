<?php

function buildBox( $data )
{

  $code = '';

  foreach( $data as $val )
  {
    $code .= "<option value=\"{$val['id']}\" >{$val['value']}</option>".NL;
  }

  return $code;

}

$body = buildBox( $this->model->getSecurityLevel() );


?>

<div class="wgt-table title" >
  <h2>Update ACLs</h2>
</div>

<fieldset class="wgt-space" >
  <legend>ACLs</legend>

  <form
    class="wcm wcm_req_ajax"
    method="post"
    action="ajax.php?c=Daidalos.Acl.updateAcl"
    id="wgt-form-acl-update" >

    <div class="left half" >
      <div class="wgt-box input" >
        <label class="wgt-label" >Listing</label>
        <div class="wgt-input" >
          <select name="id_listing" class="medium" id="wgt-input-id_listing" >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Access</label>
        <div class="wgt-input" >
          <select name="id_access" class="medium" id="wgt-input-id_access" >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Insert</label>
        <div class="wgt-input" >
          <select name="id_insert" class="medium" id="wgt-input-id_insert" >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Update</label>
        <div class="wgt-input" >
          <select name="id_update" class="medium" id="wgt-input-id_update"  >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Delete</label>
        <div class="wgt-input" >
          <select name="id_delete" class="medium" id="wgt-input-id_delete"  >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Admin</label>
        <div class="wgt-input" >
          <select name="id_admin" class="medium" id="wgt-input-id_admin"  >
          <?php echo $body; ?>
          </select>
        </div>
      </div>
    </div>

    <div class="inline half" >
      <div class="wgt-box input" >
        <label class="wgt-label" >Ref Listing</label>
        <div class="wgt-input" >
          <select name="ref_listing" class="medium" id="wgt-input-ref_listing" >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Ref Access</label>
        <div class="wgt-input" >
          <select name="ref_access" class="medium" id="wgt-input-ref_access" >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Ref Insert</label>
        <div class="wgt-input" >
          <select name="ref_insert" class="medium" id="wgt-input-ref_insert" >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Ref Update</label>
        <div class="wgt-input" >
          <select name="ref_update" class="medium" id="wgt-input-ref_update"  >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Ref Delete</label>
        <div class="wgt-input" >
          <select name="ref_delete" class="medium" id="wgt-input-ref_delete"  >
          <?php echo $body; ?>
          </select>
        </div>
      </div>

      <div class="wgt-box input" >
        <label class="wgt-label" >Ref Admin</label>
        <div class="wgt-input" >
          <select name="ref_admin" class="medium" id="wgt-input-ref_admin"  >
          <?php echo $body; ?>
          </select>
        </div>
      </div>
    </div>

  </form>

  <div class="wgt-clear medium" ></div>

  <div  class="wgt-box full" >
    <button class="wgt-button" onclick="$R.sendForm('wgt-form-acl-update');" >Update Rights</button>
  </div>

</fieldset>

<div class="wgt-table title" >
  <h2>Some more Actions</h2>
</div>

<fieldset class="wgt-space" >
  <legend>Some Actions</legend>

  <ul>
    <li><button
      onclick="$R.get('ajax.php?c=Daidalos.Acl.deactivateAllUsers');"
      class="wgt-button" >Deactivate all Users</button></li>
  </ul>

</fieldset>
