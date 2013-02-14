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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlNode_Entity_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $attribute BdlNodeEntityAttribute
   */
  public function displayInsertAttribute($attribute )
  {
    
    $checkBoxPk = WgtForm::checkbox('Pk', 'is_pk', $attribute->getPk(), array('readonly'=>'readonly'),null,true );

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="table#wgt-grid-entity-attributes-table>tbody" action="append" ><![CDATA[
<tr>
  <td class="pos" >1</td>
  <td>{$attribute->getName()}</td>
  <td>{$attribute->getIsA()}</td>
  <td>{$attribute->getType()}</td>
  <td>{$attribute->getSize()}</td>
  <td>
    PK/FK/U/NN
  
  </td>
  <td>{$attribute->getDescriptionByLang('de')}</td>
  <td></td>
</tr>
]]></htmlArea>
XML
    );
    
    //$this->addJsCode( "\$S('#wgt-grid-entity-attributes-table').grid('');" );
    
  }//end public function displayInsertAttribute */

}//end class DaidalosBdlNode_Entity_Ajax_View

