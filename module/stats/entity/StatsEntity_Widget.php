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
class StatsEntity_Widget extends WgtWidget
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var StatsEntity_Widget_Query
   */
  protected $query = null;

  /**
   *
   * @var int
   */
  public $width = 850;

  /**
   *
   * @var int
   */
  public $height = 550;

  /**
   *
   * @var int
   */
  public $entityKey = 'core_person';

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($view, $tabId, $tabSize = 'medium' )
  {

    $user         = $this->getUser();
    $view         = $this->getView();
    $httpRequest  = $this->getRequest();

    $chartType  = $httpRequest->data('graph',Validator::CNAME);
    $entityKey  = $httpRequest->data('entity',Validator::INT);
    $startDate  = $httpRequest->data('start',Validator::DATE);

    $startDate = date('Y').'-01-01';

    $json = $this->load($this->entityKey, $startDate);

    // create selectox for easy assignments
    $selectbox = $view->newItem('tmp','Selectbox');
    $selectbox->addAttributes(array
    (
      'name'      => 'entity',
      'id'        => 'wgt_selectbox-widget-entities',
      //'onchange'  => '',
      'class'     => 'medium cursor',
    ));
    $selectbox->setWidth( 'medium' );
    $selectbox->setFirstfree( 'Select an Entity' );

    $selectbox->setData($this->query->fetchSelectbox() );
    $selectbox->setActive($entityKey);

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="Entity Chart"  >
      <div class="wgt-panel menu"  >

        <form
          id="wgt-form-chart-count-creation-search"
          action="ajax.php?c=Widget.StatsEntity.load&size=def&amp;target={$tabId}"
          method="post" >

          <div class="left" style="margin-right:5px;" >
            <button
              class="wgt-button"
              onclick="\$R.form('wgt-form-chart-count-creation-search');return false;" >Build Chart</button>
          </div>

          <div class="inline"  >
            <label>Entity</label>
            {$selectbox->element()}
          </div>

          <div class="inline" style="margin-left:20px;" >
            <label>Start</label>
            <input type="text" name="start" value="{$startDate}" class="wcm wcm_ui_date small" />
          </div>

          <div class="inline" style="margin-left:20px;" >
            <label>Chart Type:&nbsp;&nbsp;&nbsp;</label>
          </div>

          <div class="inline" style="margin-left:5px;border:1px dotted silver;padding:2px;" >
            <label>Area</label> <input name="graph" checked="checked" type="radio" value="area" />
            <label>Bar</label> <input name="graph" type="radio" value="bar" />
            <label>HBar</label> <input name="graph" type="radio" value="hbar" />
            <label>Pie</label> <input name="graph"  type="radio" value="pie" />
          </div>

        </form>

        <div class="wgt-clear xxsmall" ></div>

      </div>


      <div class="wgt-clear small" ></div>

      <div class="wcm wcm_chart_area" id="{$tabId}_graph" style="width:1000px;height:650px;" >
        <var class="data" >{$json}</var>
        <div style="width:150px;float:left;" ><ul class="legend" id="{$tabId}_menu"  ></ul></div>
        <div  class="container inline" id="{$tabId}_container" style="width:850px;height:670px;" ></div>
      </div>

      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function embed($view, $tabId, $tabSize = 'medium' )
  {

    $user         = $this->getUser();
    $view         = $this->getView();
    $httpRequest  = $this->getRequest();

    $chartType  = $httpRequest->data('graph',Validator::CNAME);
    $entityKey  = $httpRequest->data('entity',Validator::INT);
    $startDate  = $httpRequest->data('start',Validator::DATE);

    $startDate = date('Y').'-01-01';

    $json = $this->load($this->entityKey, $startDate);

    // create selectox for easy assignments
    $selectbox = $view->newItem('tmp','Selectbox');
    $selectbox->addAttributes(array
    (
      'name'      => 'entity',
      'id'        => 'wgt_selectbox-widget-entities',
      //'onchange'  => '',
      'class'     => 'medium cursor',
    ));
    $selectbox->setWidth('medium');
    $selectbox->setFirstfree( 'Select an Entity' );

    $selectbox->setData($this->query->fetchSelectbox() );
    $selectbox->setActive($entityKey);

    $boxWidth   = $this->width - 122;

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="Entity Chart"  >
      <div class="wgt-panel menu"  >

        <form
          id="wgt-form-chart-count-creation-search"
          action="ajax.php?c=Widget.StatsEntity.load&width={$this->width}&height={$this->height}&amp;target={$tabId}"
          method="post" >

          <input type="hidden" name="entity" value="{$this->entityKey}" />

          <div class="left" style="margin-right:5px;" >
            <button
              class="wgt-button"
              onclick="\$R.form('wgt-form-chart-count-creation-search');return false;" >Build Chart</button>
          </div>


          <div class="inline" style="margin-left:20px;" >
            <label>Start</label>
            <input type="text" name="start" value="{$startDate}" class="wcm wcm_ui_date small wgt-no-save" />
          </div>

          <div class="inline" style="margin-left:20px;" >
            <label>Chart Type:&nbsp;&nbsp;&nbsp;</label>
          </div>

          <div class="inline wgt-no-save" style="margin-left:5px;border:1px dotted silver;padding:2px;" >
            <label>Area</label> <input name="graph" class="wgt-no-save" checked="checked" type="radio" value="area" />
            <label>Bar</label> <input name="graph" class="wgt-no-save" type="radio" value="bar" />
            <label>HBar</label> <input name="graph" class="wgt-no-save" type="radio" value="hbar" />
            <label>Pie</label> <input name="graph" class="wgt-no-save"  type="radio" value="pie" />
          </div>

        </form>

        <div class="wgt-clear xxsmall" ></div>

      </div>


      <div class="wgt-clear small" ></div>

      <div class="wcm wcm_chart_area" id="{$tabId}_graph" style="width:{$this->width}px;height:{$this->height}px;" >
        <var class="data" >{$json}</var>
        <div style="width:120px;float:left;" ><ul class="legend" id="{$tabId}_menu"  ></ul></div>
        <div  class="container inline" id="{$tabId}_container" style="width:{$boxWidth}px;height:{$this->height}px;" ></div>
      </div>

      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function embed */


  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function runLoad($tabSize = 'medium'  )
  {

    $user         = $this->getUser();
    $view         = $this->getView();
    $httpRequest  = $this->getRequest();

    $tabId      = $httpRequest->param(  'target',Validator::CKEY  );
    $size       = $httpRequest->data(  'size',Validator::CNAME  );
    
    $chartType  = $httpRequest->data(  'graph',Validator::CNAME  );
    $entityKey  = $httpRequest->data(  'entity',Validator::CNAME  );
    $startDate  = $httpRequest->data(  'start',Validator::DATE  );
    
    $width      = $httpRequest->param(  'width',Validator::INT  );
    $height     = $httpRequest->param(  'height',Validator::INT  );

    $json = $this->load($entityKey, $startDate );


    if (!$width || !$height )
    {
      $width  = $this->width;
      $height = $this->height;
    }

    $boxWidth   = $width - 122;

    $code = <<<HTML
      <div class="wcm wcm_chart_{$chartType}" id="{$tabId}_graph" style="width:{$width}px;height:{$height}px;" >
        <var class="data" >{$json}</var>
        <div style="width:120px;float:left;" >
          <ul class="legend" id="{$tabId}_menu"  ></ul>
        </div>
        <div  class="container inline" id="{$tabId}_container" style="width:{$boxWidth}px;height:{$height}px;" >
        </div>
      </div>
HTML;

    $view->newArea
    (
      '#'.$tabId.'_graph',
      array
      (
        'replace',
        $code
      )
    );

  }//end public function runLoad */

  /**
   *
   * @param string $entityKey
   * @param string $startDate
   */
  public function load($entityKey , $startDate )
  {

    Debug::console("$entityKey , $startDate");

    $query  = new StatsEntity_Widget_Query();
    $this->query = $query;
    $data   = $query->fetch($entityKey, $startDate );

    //Message::addMessage('fkn test');

    $labels = array();
    $values = array();

    $labels[] = 'Entries Created';
    $labels[] = 'Entries Changed';

    foreach($data as $period => $row )
    {
      $key          = date('M',strtotime($period));
      $values[$key] = array
      (
        (isset($row['created'])?$row['created']:0),
        (isset($row['changed'])?$row['changed']:0)
      );
    }

    $jsonData = array();

    foreach($values as $period => $entries )
    {
      $tmp = '{"label": "'.$period.'",';
      $tmp .= '"values":['.implode(',',$entries).']}';
      $jsonData[] = $tmp;
    }

    $json = '{';
    $json .= '"label": ["'.implode('", "', $labels).'"],';
    $json .= '"values": [';
    $json .= implode( ',', $jsonData );
    $json .= ']}';

    return $json;

  }//end public function load */


}//end class ProjectChartBookings_Widget