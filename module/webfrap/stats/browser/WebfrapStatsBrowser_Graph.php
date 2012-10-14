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
class WebfrapStatsBrowser_Graph
  extends LibGraphEz
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $type = 'line';
  
  /**
   * 
   */
  public function prepare()
  {
    
    $request = $this->getRequest();

    $this->data = new WebfrapStatsBrowser_Graph_Query();
    $this->data->fetch( '2012-01-01' );

    
    $this->width  = 400;
    $this->height = 300;
    
  }//end public function prepare */
  
  /**
   * @return void
   */
  public function render(  )
  {

    $this->graph = new ezcGraphLineChart();
    $this->graph->title = $this->title;
    
    $this->setDefaultSettings();
    
    // Add data
    foreach( $this->data as $label => $data )
    {
      $this->graph->data[$label] = new ezcGraphArrayDataSet( $data );
    }
    
  }//end public function render */



}//end class WebfrapStatsBrowser_Graph