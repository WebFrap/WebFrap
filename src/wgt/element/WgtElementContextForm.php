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
class WgtElementContextForm
  extends WgtAbstract
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
    
    if( !WBF_SHOW_MOCKUP )
      return '';
    
    $user    = User::getActive();
    $db      = Db::getActive();
   
    $contextForm = new WgtFormBuilder
    (
      'ajax.php?c=Webfrap.ProfileContext.updateProfile', 
      'context-profile',
      'put',
      false
    );

    $html = <<<HTML

  <li class="custom" >

{$contextForm->form()}
  
    <a>Context</a>
    <div class="sub subcnt bw3" style="height:300px;display:none;" >
    
      <fieldset>
        <legend>Date Range</legend>
				
        {$contextForm->date('Start','start_date')}
        {$contextForm->date('End','end_date')}
        
      </fieldset>
    		
      <button 
      	class="wgt-button"
      	tabindex="-1" >Set Context</button>
      
    </div>
  </li>
    
HTML;

    return $html;

  } // end public function render */

} // end class WgtElementContextForm


