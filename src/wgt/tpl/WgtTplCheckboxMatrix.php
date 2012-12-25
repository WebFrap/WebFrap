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
 * Template für ein Modal Element
 * @package WebFrap
 * @subpackage wgt/tpl
 */
class WgtTplCheckboxMatrix
{
  
  /**
   * @var string $id
   * @var string $inpId
   * @var string $formId
   * @var string $nameEntries
   * @var array $entries
   */
  public static function render( $id, $inpId, $formId, $nameEntries, $entries )
  {

    $codeEntries = '';
    foreach( $entries as $entry )
    {
      
      $checked = '';
      
      if( isset( $entry['checked'] ) && $entry['checked'] )
        $checked = ' checked="checked" ';
      
      $codeEntries .= <<<HTML
    <div>
    	<label>{$entry['label']}</label>
    	<div><input 
      type="checkbox"
      {$checked}
      name="{$nameEntries}[{$entry['id']}]"
      class="asgd-{$formId}"
      value="{$entry['value']}" /></div>
    </div>

HTML;
      
    }
    
    $code = <<<HTML
    
  <div id="{$id}" class="wgt-checkbox-matrix" >
    {$codeEntries}
  </div>
    
HTML;
    
    return $code;

  }//end public static function render */


}//end class WgtTplCheckboxMatrix


