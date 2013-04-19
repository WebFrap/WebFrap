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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 */
class WebfrapStatsSso_Graph extends LibGraphEz
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function prepare()
  {

    $this->data = new WebfrapStatsSso_Graph_Query();
    $this->data->fetch('2012-01-01');

    $this->width = 400;
    $this->height = 300;

  }//end public function prepare */

  /**
   * @return void
   */
  public function render()
  {

    $this->graph = new ezcGraphPieChart();
    $this->graph->title = $this->title;

    $this->setDefaultSettings();

    // Add data
    $this->graph->data['SSO Usage'] = new ezcGraphArrayDataSet(array('sso' => '33', 'no sso'=> '44'));

  }//end public function render */

}//end class WebfrapStatsBrowser_Graph