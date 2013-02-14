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

/** Form Class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtProcessFormSlice_Responsibles extends WgtProcessFormSlice
{
/*//////////////////////////////////////////////////////////////////////////////
// render
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WgtProcessForm $processForm
   * @return string
   */
  public function render( $processForm )
  {

    $i18n = $this->getI18n();
    
    $responsibles = $processForm->process->getActiveResponsibles( );

    $html  = '';
    
    if( $responsibles )
    {
      $respEntries = '';
      
      foreach( $responsibles as $responsible )
      {
        $respEntries .= "<li><a class=\"wcm wcm_req_mtab\" href=\"maintab.php?c=Wbfsys.RoleUser.show&amp;objid={$responsible->userId}\" >{$responsible->lastname}, {$responsible->firstname}</a></li>".NL;
      }
      
      $html .= <<<HTML
      
        <div class="slice" >
          <h3>{$i18n->l('Responsible','wbf.label')}</h3>
          <div class="nearly-full wgt-space wgt-corner" >
            <ul>{$respEntries}</ul>
          </div>
          <div class="wgt-clear" ></div>
        </div>
      
HTML;
      
    }
    
    return $html;


  }//end public function render */

  

}//end class WgtProcessFormSlice_Responsible


