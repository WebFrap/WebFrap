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
 *
 * @package WebFrap
 * @subpackage wgt
 */
class WgtListMenu
{

  /**
   * List actions
   * @var array
   */
  public $listActions = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Konstruktor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $listActions
   */
  public function __construct( $listActions = null )
  {
    
    if( $listActions )
    {
       
      if( is_string( $listActions ) )
      {
        $this->listActions = json_decode( $listActions );
      }
      else 
      {
        $this->listActions = $listActions;
      }
      
    }
    
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param array $row
   * @param array $actions
   */
  public function renderActions( $row, $actions = null )
  {
    
    if( is_null($actions) )
      $actions = $this->listActions;
    
    $code = array();
    
    foreach( $actions as $action )
    {
     
      $codeParams = '';
      if( isset( $action->params ) )
      {
        foreach( $action->params as $pName => $pKey )
        {
          $codeParams .= "&".$pName."=".( isset( $row[$pKey] ) ? $row[$pKey]:'' );
        }
      }
      
      $codeLabel = '';
      if( isset( $action->label ) )
      {
        $codeLabel = $action->label;
      }
      
      $codeIcon = '';
      if( isset( $action->icon ) )
      {
        $codeIcon = $this->icon( $action->icon, $codeLabel )." ";
      }
      
      switch( $action->type )
      {
        case 'request':
        {

          $code[] = <<<CODE

<button
	class="wgt-button" 
	onclick="\$R.{$action->method}('{$action->service}={$row['id']}{$codeParams}');" >{$codeIcon}{$codeLabel}</button>
            
CODE;
          break;
        }
      }
    }
    
    
    return implode( '<br />', $code ); 
    
  }//end renderActions */
  


} // end class WgtAbstract

