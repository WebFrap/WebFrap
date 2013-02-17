<h1>Controls</h1>

<label>Liste der Action Typen</label>

<ul class="doc_tree" >
  <li><span>ACTION_PAGING</span>(1), 
    Dieses Element enthält Daten für eine Paging Aktion.
  </li>
  <li><span>ACTION_JS</span>(2), 
    Dieses Element führt on click javascript aus. Das HTML Tag ist ein Button.
  </li>
  <li><span>ACTION_URL</span>(3), 
    Dieses Element ist eine normale URL, kein Ajax Request
  </li>
  <li><span>ACTION_AJAX_GET</span>(4), 
    Dieses Element ist ein normaler Link, der jedoch per Javascript zu einem Ajax Request umgebaut wird, 
    wenn JS vorhanden ist, ansonsten verhält sich das Element wie ein normaler Link.
  </li>
  <li><span>ACTION_CHECKBOX</span>(5), 
    Dieses Control Element ist eine Checkbox. Auf dieser Checkbox liegen
    standardmäßig keine Events, können jedoch bei Bedarf hinzugefügt werden.
  </li>
  <li><span>ACTION_BUTTON_GET</span>(7), 
    Der Link wird als <span class="http_req_type" >GET</span> Request onClick auf das Button Element gelegt.
  </li>
  <li><span>ACTION_DELETE</span>(8), 
    Triggert einen Ajax <span class="http_req_type" >DELETE</span> Request.
  </li>
  <li><span>ACTION_SEP</span>(9), 
    Einfaches Separatorelement um Buttons / Actions zu gruppieren.
  </li>
  <li><span>ACTION_BUTTON_POST</span>(10), 
    Der Button schickt einen POST Request mit einem Databody.
  </li>
  <li><span>ACTION_BUTTON_PUT</span>(11), 
    Der Button schickt einen PUT Request mit einem Databody.
  </li>
  <li><span>ACTION_TRIGGER</span>(12), 
    Es wird eine Action mit dem gerade aktuellen ID als Parameter getriggert.
  </li>
</ul>


<label>Code Example</label>
<?php start_highlight(); ?>

  /**
   * Vorhandene Actions auf Rollenebene
   * Hier ist nur die clean action vorgesehen
   * @var array
   */
  public $actions  = array( 'delete' );

 /**
  * Setzen der nötigen Meta und Control Informationen
  * vor dem eigentlichen Render des Elements
  */
  public function loadUrl()
  {

    $this->url      = array
    (
      'delete'  => array
      (
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Project.Project.delete&amp;objid=',
        'control/clean.png',
        'wcm wcm_ui_tip',
        'wbf.label',
        Acl::DELETE
      ),
      'sep'  => array
      (
        Wgt::ACTION_SEP
      ),
  
    );

  }//end public function loadUrl */

<?php display_highlight( 'php' ); ?>


<label>Custom Access Controls</label>
<?php start_highlight(); ?>

  'adopt'    => array
  (
    Wgt::ACTION_BUTTON_GET,
    'adopt',
    'ajax.php?c=Project.Adopt_Action.trigger&amp;objid=',
    'control/adopt.png',
    'wcm wcm_ui_tip',
    'Adopt',
    Acl::ACCESS,
    Wgt::BUTTON_CHECK => function( $row, $id, $value, $access )
    {
      
      $numUsers = $access->numExplicitUsers( $id, 'project_manager' );
      if( ! $numUsers == 0  )
      {
        return false;
      }
                
      if( !$access->hasRole( 'project_manager' ) )
      {
        return false;
      }
      
      // wenn nicht abgebrochen wurde, kann der action angezeigt werden
      return true;
    }

  ),

<?php display_highlight( 'php' ); ?>




