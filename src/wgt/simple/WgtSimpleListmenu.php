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
 * @package WebFrap
 * @subpackage wgt
 */
class WgtSimpleListmenu
{
  
  private static $default = null;
  
  /**
   * @return WgtSimpleListmenu
   */
  public static function getDefault()
  {
    
    if( !self::$default )
      self::$default = new WgtSimpleListmenu();
    
    return self::$default;
    
  }//end public static function getDefault */
  
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param array $actions
   * @param array $row
   */
  public function renderActions( $actions, $row )
  {
    
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
    
  }//end public function renderActions */
  
  /**
   * request an icon
   * @param string $name
   * @param string $alt
   * @return string
   */
  public function icon( $name , $alt )
  {
    return Wgt::icon( $name, 'xsmall', $alt );
  }//end public function icon */

}//end class WgtSimpleListmenu

