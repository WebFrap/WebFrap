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
 * @subpackage Example
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class ExampleGraphArea_Widget extends WgtWidget
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($view, $tabId, $tabSize = 'medium')
  {

    $user     = $this->getUser();
    $view     = $this->getView();

    $profile  = $user->getProfileName();

    $now = date('Y-m-d');

    $sql = <<<SQL
  select count(project_project.rowid) ,
    project_project_status.name
  from
    project_project
  join
    project_project_status
      on project_project_status.rowid = project_project.id_status
  group by
    project_project_status.name
  where
    project_project.start_date <= '{$now}'
    and
    project_project.start_end => '{$now}'

SQL;

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} wcm wcm_chart_area" title="protocol"  >

      <div class="wcm wcm_graph_lines" style="width:600px;height:320px;" >
        <var class="data" >{
        "label": ["label A", "label B", "label C", "label D"],
        "values": [
        {
          "label": "date A",
          "values": [20, 40, 15, 5]
        },
        {
          "label": "date B",
          "values": [30, 10, 45, 10]
        },
        {
          "label": "date E",
          "values": [38, 20, 35, 17]
        },
        {
          "label": "date F",
          "values": [58, 10, 35, 32]
        },
        {
          "label": "date D",
          "values": [55, 60, 34, 38]
        },
        {
          "label": "date C",
          "values": [26, 40, 25, 99]
        }]

    }</var>
        <div style="width:75px;float:left;" >
        <ul class="legend" id="{$tabId}_menu"  >
        </ul>
        </div>
        <div  class="container" id="{$tabId}_container" style="width:524px;height:320px;" >
        </div>
      </div>

      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

}//end class ExampleGrapArea_Widget