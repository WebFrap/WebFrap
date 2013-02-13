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
class WgtProcessFormSlice_Comment
  extends WgtProcessFormSlice
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WgtProcessForm $processForm
   * @return string
   */
  public function render( $processForm )
  {

    $i18n = $this->getI18n();

    $html = <<<HTML

        <div class="slice" >
          <h3>{$i18n->l('Comment','wbf.label')} <span class="wgt-required wcm wcm_ui_tip" title="{$i18n->l('Is Required','wbf.label')}" >*</span></h3>
          <div>
            <textarea 
              class="xlarge medium-height asgd-{$processForm->formId} flag-template" 
              name="{$processForm->process->name}[comment]"  ></textarea>
          </div>
        </div>

HTML;

    return $html;

  }//end public function render */
  
}//end class WgtProcessFormSlice_Comment 


