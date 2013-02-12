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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class MaintenanceDb_Index_Search_Ajax_View
  extends LibTemplateAjaxView
{

  /**
   * @param BdlNodeEntityAttribute $attribute
   * @param int $index
   * @param string $entityName
   */
  public function displaySearchResult( $result, $params )
  {

    $html = '';

    $pos = 1;
    foreach ($result as $row) {

      $html .= <<<XML
      <tr>
        <td class="pos" >{$pos}</td>
        <td>{$row['entity_name']}</td>
        <td>{$row['name']}</td>
        <td>{$row['title']}</td>
        <td>{$row['key']}</td>
        <td>{$row['description']}</td>
        <td>{$row['rank']}</td>
      </tr>
XML;
      ++$pos;
    }

    $this->setAreaContent( 'searchResult', <<<XML
<htmlArea selector="table#wgt-table-maintenance-db_index-search>tbody" action="html" ><![CDATA[
{$html}
]]></htmlArea>
XML
    );

  }//end public function displaySearchResult */

}//end class MaintenanceDb_Index_Search_Ajax_View
