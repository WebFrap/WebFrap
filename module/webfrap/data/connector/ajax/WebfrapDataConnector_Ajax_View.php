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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapDataConnector_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WebfrapDataConnector_Search_Request $searchReq
   * @return void
   */
  public function displaySearch($searchReq  )
  {

    $result = $this->model->search($searchReq);
    
    $menuBuilder = new WgtMenuBuilder_SplitButton($this);
    $menuBuilder->actions = array('connect');
    
    $menuBuilder->buttons  = array(
      'connect'    => array(
        Wgt::ACTION_JS,
        'Connect',
        '$S(\'#'.$searchReq->cbElement.'\').trigger(\'connect\',[\'{$id}\'])',
        'icon-external-link',
        '',
        null
      ),
    );
    
    
    $html = '';
    $pos  = 1;
    
    foreach ($result as $row) {

      $html .= <<<XML
      <tr>
        <td class="pos" >{$pos}</td>
        <td>{$row['entity_name']}</td>
        <td>{$row['title']}</td>
        <td>{$row['key']}</td>
        <td>{$row['description']}</td>
        <td>{$menuBuilder->buildRowMenu($row,$row['vid'])}</td>
      </tr>
XML;
      ++$pos;
    }

    $this->setAreaContent('searchResult', <<<XML
<htmlArea selector="table#{$searchReq->elid}>tbody" action="html" ><![CDATA[
{$html}
]]></htmlArea>
XML
    );

  }//end public function displaySearch */

} // end class WebfrapDataConnector_Ajax_View */

