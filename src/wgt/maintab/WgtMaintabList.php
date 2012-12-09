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
 *  Basisklassen für handgeschriebene listenbasierte Masken
 * 
 * @package WebFrap
 * @subpackage wgt
 * @since 0.9.2
 */
class WgtMaintabList
  extends WgtMaintab
{
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * List actions
   * @var array
   */
  protected $listActions = array();
  
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param array $actions
   * @param array $row
   */
  protected function renderActions( $actions, $row )
  {
    
    $code = array();
    
    foreach( $actions as $action )
    {
      switch( $action->type )
      {
        case 'request':
        {
          
          $code[] = <<<CODE

<button
	class="wgt-button" 
	onclick="\$R.{$action->method}('{$action->service}={$row['id']}');" >{$action->label}</button>
            
CODE;
          break;
        }
      }
    }
    
    
    return implode( '<br />', $code ); 
    
  }//end renderActions */


} // end class WgtMaintabList

