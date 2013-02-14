<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
* 
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


/**
 * Kallender Element für den Desktop
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtElementMyData extends WgtAbstract
{
  
  /**
   * @var User
   */
  public $user = null;
  
  /**
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * @return string
   */
  public function render( $params = null )
  {
    
    $user    = User::getActive();
    $db      = Db::getActive();
    $orm     = $db->getOrm();
    
    $userNode   = $orm->get( 'WbfsysRoleUser', $user->getId()  );
    $personNode = $orm->get( 'CorePerson', $userNode->id_person  );
    
    
    $iconDel     = $this->icon( 'control/delete.png', 'Delete' );
    $iconUpload  = $this->icon( 'control/upload.png', 'Upload' );
    
    $userForm = new WgtFormBuilder
    (
      'ajax.php?c=Webfrap.MyProfile.updateData', 
      null,
      'user_profile',
      'post',
      false
    );
    
    $cItemForm = new WgtFormBuilder
    (
      'ajax.php?c=Webfrap.MyProfile.updateData', 
      null,
      'user_profile_contact_item',
      'post',
      false
    );
    
    
    /*
     * Profile
     */
    $selectboxProfile = new WgtSelectboxSessionuserProfiles('userprofile');
    $selectboxProfile->load();

    $selectboxProfile->addAttributes
    (array(
      'name'    =>  'switch_profile',
      'id'      =>  'wgt-panel-switch-profile',
      'class'   =>  'medium',
      'onchange'  => '$R.redirect( \'index.php\',{c:\'Webfrap.Profile.change\',profile:$S(\'#wgt-panel-switch-profile\').val()} );'
    ));
    $codeSelectboxProfile = WgtForm::decorateElement( 'Profile', 'wgt-panel-switch-profile', $selectboxProfile ); 
    
    /*
     * UI theme
     */
    $slctUiTheme = new WgtSelectboxUiThemeSwitcher('ui_theme');
    $slctUiTheme->load();

    $slctUiTheme->addAttributes
    (array(
      'name'    =>  'switch_ui_theme',
      'id'      =>  'wgt-panel-switch-ui_theme',
      'class'   =>  'medium',
      'onchange'  => '$R.redirect( \'index.php\',{c:\'Webfrap.Profile.change\',profile:$S(\'#wgt-panel-switch-ui_theme\').val()} );'
    ));
    $codeSlctUiTheme = WgtForm::decorateElement( 'UI Theme', 'wgt-panel-switch-ui_theme', $slctUiTheme ); 
    
    /*
     * Icon theme
     */
    $slctIconTheme = new WgtSelectboxIconThemeSwitcher('icon_theme');
    $slctIconTheme->load();

    $slctIconTheme->addAttributes
    (array(
      'name'    =>  'switch_icon_theme',
      'id'      =>  'wgt-panel-switch-icon_theme',
      'class'   =>  'medium',
      'onchange'  => '$R.redirect( \'index.php\',{c:\'Webfrap.Profile.change\',profile:$S(\'#wgt-panel-switch-icon_theme\').val()} );'
    ));
    $codeSlctIconTheme = WgtForm::decorateElement( 'Icon Theme', 'wgt-panel-switch-icon_theme', $slctIconTheme ); 
    
    /*
     * Language switcher
     */
    $slctLSw = new WgtSelectboxLanguageSwitcher('language_switcher');
    $slctLSw->load();

    $slctLSw->addAttributes
    (array(
      'name'      =>  'switch_language',
      'id'        =>  'wgt-panel-switch_language',
      'class'     =>  'medium',
      'onchange'  => '$R.redirect( \'index.php\',{c:\'Webfrap.Profile.change\',profile:$S(\'#wgt-panel-switch_language\').val()} );'
    ));
    $codeSlctLSw = WgtForm::decorateElement( 'Language', 'wgt-panel-switch_language', $slctLSw ); 

    // budget items
    
    $sqlItems = <<<SQL
  SELECT
    item.address_value,
    type.name as type
  FROM
    wbfsys_address_item item
  JOIN
    wbfsys_address_item_type type
    on item.id_type = type.rowid
    
  WHERE
    id_user = {$user->getid()};
SQL;
    
    $contactItems     = $db->select( $sqlItems );
    $htmlContactItems = '';
    
    foreach( $contactItems as $contactItem )
    {
      $htmlContactItems .= <<<HTML
        <tr>
          <td>{$contactItem['type']}</td>
          <td></td>
          <td>{$contactItem['address_value']}</td>
          <td><button class="wgt-button" tabindex="-1" >{$iconDel}</button></td>
        </tr>
HTML;
    }
    
    if (!WBF_SHOW_MOCKUP )
    {
      return <<<HTML

  <li class="custom" >
  		
  	{$userForm->form()}
  	{$cItemForm->form()}
  
    <a>{$user->getFullname()}</a>
    <div class="sub subcnt bw63" style="height:200px;display:none;" >
    
      <fieldset>
        <legend>My Status</legend>
        
        <div class="left bw3" >
          {$codeSelectboxProfile}
          {$codeSlctLSw}
        </div>
        
        <div class="inline bw3" >
          {$codeSlctUiTheme}
          {$codeSlctIconTheme}
        </div>
        
      </fieldset>

    </div>
  </li>
    
HTML;

    }

    $html = <<<HTML

  <li class="custom" >
  		
  	{$userForm->form()}
  	{$cItemForm->form()}
  
    <a>{$user->getFullname()}</a>
    <div class="sub subcnt bw63" style="height:600px;display:none;" >
    
      <fieldset>
        <legend>My Status</legend>
        
        <div class="left bw3" >
          {$codeSelectboxProfile}
          {$codeSlctLSw}
        </div>
        
        <div class="inline bw3" >
          {$codeSlctUiTheme}
          {$codeSlctIconTheme}
        </div>
        
      </fieldset>
    
      <fieldset>
        <legend>My Data</legend>
        
        <div class="left bw3" >
          {$userForm->input('Name','wbfsys_role_user[name]',$userNode->name,array('autocomplete'=>'off'))}
          {$userForm->input('Firstname','core_person[firstname]',$personNode->firstname,array('autocomplete'=>'off'))}
          {$userForm->input('Lastname','core_person[lastname]',$personNode->lastname,array('autocomplete'=>'off'))}
        </div>
        
        <div class="inline bw3" >
          {$userForm->password('Password','wbfsys_role_user[password]')}
        </div>
        
        <div class="wgt-clear small" >&nbsp;</div>
        
        <div>
          <div class="left bw3" >&nbsp;</div>
          <div class="inline bw3" >
            {$userForm->submit('update my data')}
          </div>
        </div>
        
      </fieldset>
      
      <fieldset>
        <legend>Contact Items</legend>
        
        <div class="left bw3" >
          <div style="height:160px;overflow:auto;"  >
            <table class="wgt-table" style="width:360px;" >
              {$htmlContactItems}
            </table>
          </div>
        </div>

        
      </fieldset>
      
    </div>
  </li>
    
HTML;

    return $html;

  } // end public function render */

} // end class WgtElementMyData


