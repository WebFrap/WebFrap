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
class WgtProcessForm
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// public interface attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * der Prozess
   * @var Process
   */
  public $process = null;

  /**
   * die id des formulars an welches die Prozessdaten gehängt werden
   * @var string
   */
  public $formId  = null;
  
  /**
   * Objekt mit relevanten Parametern zum bauen des Form Templates
   * @var string
   */
  public $params  = null;
  
  /**
   * Das Label des Prozesses
   * @var string
   */
  public $processLabel = null;

////////////////////////////////////////////////////////////////////////////////
// public interface attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $formId
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {

    $this->formId = $params->formId;
    $i18n         = $this->getI18n();
    
    Debug::console( "RENDER PROCESS", $this->process );
    
    if( !$this->process )
    {
      Debug::console( 'MISSING PROCESS' );
      return '';
    }

    $statusData = $this->process->getActiveNode();

    $iconStatus   = $this->icon( $statusData->icon , $statusData->label );
    $iconHistory  = $this->icon( 'process/history.png', 'History' );
    $iconDetails  = $this->icon( 'control/mask.png', 'Details' );
    $iconGraph    = $this->icon( 'process/chart.png', 'Chart' );


    $edges            = $this->process->getActiveEdges( );
    $actionHtml       = $this->renderEdgeActions( $edges, $params );
    $descriptionHtml  = $this->renderEdgeDescriptions( $edges, $params );

    $slides       = $this->process->getActiveSlices( );
    $slidesHtml   = '';
    
    if( $slides )
    {
      $slidesHtml .= '<div class="slides" >'.NL;
      
      foreach( $slides as $slide )
      {
        $slRenderer = $slide->getRenderer();
        $slidesHtml .= $slRenderer->render( $this, $slide );
      }
      
      $slidesHtml .= '</div>'.NL;
    }
    
    Debug::console( "Process Context key: wgt-process-{$this->process->name}-{$params->contextKey}");
    

    $html = <<<HTML

  <div class="inline" style="margin-left:3px;" >
    
    <button
        class="wcm wcm_ui_button wcm_ui_dropform wcm_ui_tip-top ui-state-default" 
        id="wgt-process-{$this->process->name}-{$params->contextKey}"
        title="Click to Change the Status"
      ><div class="left">{$iconStatus} Status: {$statusData->label}</div><div class="inline ui-icon ui-icon-triangle-1-s" > </div></button>
      
    <div class="wgt-process-{$this->process->name}-{$params->contextKey} hidden" >

      <div class="wgt-process-form" >

        <div 
        	class="wcm wcm_ui_tip-top wgt-panel title"
        	tooltip="{$this->processLabel}" >
          <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>
        </div>
        
        <div class="wgt-panel" >
        
          <button 
            class="wgt-button" 
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-history-{$this->process->name}')();" >{$iconHistory} Show History</button>
            
          <button 
            class="wgt-button" 
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-graph-{$this->process->name}')()" >{$iconGraph} Process Graph</button>
                
           <button 
            class="wgt-button" 
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-details-{$this->process->name}')();" >{$iconDetails} Details</button>
            
        </div>

        <div class="wgt-clear small" ></div>

        <div class="description" >
          <h3>{$i18n->l('Description','wbf.label')}</h3>
          <div class="description-active" >
            {$statusData->description}
          </div>
{$descriptionHtml}
        </div>

        <div class="action" >
          <h3>{$i18n->l('Action','wbf.label')}</h3>
          <ul class="actions" >
            {$actionHtml}
          </ul>
          <div class="wgt-clear" ></div>
        </div>

{$slidesHtml}

        <div class="wgt-clear small" ></div>
      </div>

    </div>
  </div>

HTML;

    return $html;

  }//end public function render */
  
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function renderDropForm( $params )
  {

    $this->formId = 'wgt-form_'.$params->inputId;
    $i18n         = $this->getI18n();
    
    Debug::console( "RENDER PROCESS", $this->process );
    
    if( !$this->process )
    {
      Debug::console( 'MISSING PROCESS' );
      return '';
    }

    $statusData = $this->process->getActiveNode();

    $iconStatus   = $this->icon( $statusData->icon , $statusData->label );
    $iconHistory  = $this->icon( 'process/history.png', 'History' );
    $iconDetails  = $this->icon( 'control/mask.png', 'Details' );
    $iconGraph    = $this->icon( 'process/chart.png', 'Chart' );

    /*
    <div class="wgt-panel" >
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/feedback.png" /> Request Feedback</button>
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/history.png" /> Show History</button>
    </div>
     */

    $edges            = $this->process->getActiveEdges( );
    $actionHtml       = $this->renderDropFormEdgeActions( $edges, $params );
    $descriptionHtml  = $this->renderEdgeDescriptions( $edges, $params );
    
    $slides       = $this->process->getActiveSlices( );
    $slidesHtml   = '';
    
    if( $slides )
    {
      $slidesHtml .= '<div class="slides" >'.NL;
      
      foreach( $slides as $slide )
      {
        $slRenderer = $slide->getRenderer();
        $slidesHtml .= $slRenderer->render( $this, $slide );
      }
      
      $slidesHtml .= '</div>'.NL;
    }
    
    
    $urlSwitchType = '';
    $appendToUrl  = '';
    
    if( $params->maskType )
    {
      $urlSwitchType = ucfirst($params->maskType);
    }
    
    if( $params->mask )
    {
      $appendToUrl   .= "&amp;mask={$params->mask}" ;
    }
    
    if( $params->ltype )
    {
      $appendToUrl   .= "&amp;ltpye={$params->ltype}";
    }
    
    if( $params->element )
    {
      $appendToUrl   .= "&amp;element={$params->element}";
    }
    
    if( $params->refId )
    {
      $appendToUrl   .= "&amp;refid={$params->refId}";
    }
    
    if( $params->viewId )
    {
      $appendToUrl   .= "&amp;view_id={$params->viewId}";
    }
    
    Debug::console( "Process Inputid: {$params->inputId} form: {$this->formId}");

    $html = <<<HTML

  <div class="wgt-process-form" >
    
    <form 
      method="put" 
      id="{$this->formId}"
      action="ajax.php?c={$this->process->processUrl}.switchStatus{$urlSwitchType}&amp;objid={$this->process->activStatus}{$appendToUrl}" ></form>
      
    <div 
    	class="wcm wcm_ui_tip-top wgt-panel title"
    	tooltip="{$this->processLabel}" >
      <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>
    </div>
    
    <div class="wgt-panel" >
    
      <button 
        class="wgt-button" 
        onclick="\$S('#{$params->inputId}').data('paction-history-{$this->process->name}')();" >{$iconHistory} Show History</button>
        
      <button 
        class="wgt-button" 
        onclick="\$S('#{$params->inputId}').data('paction-graph-{$this->process->name}')();" >{$iconGraph} Process Graph</button>
        
       <button 
        class="wgt-button" 
        onclick="\$S('#{$params->inputId}').data('paction-details-{$this->process->name}')();" >{$iconDetails} Details</button>
        
    </div>

    <div class="wgt-clear small" ></div>

    <div class="description" >
      <h3>{$i18n->l('Description','wbf.label')}</h3>
      <div class="description-active" >
        {$statusData->description}
      </div>
{$descriptionHtml}
    </div>

    <div class="action" >
      <h3>{$i18n->l('Action','wbf.label')}</h3>
      <ul class="actions" >
        {$actionHtml}
      </ul>
      <div class="wgt-clear" ></div>
    </div>

{$slidesHtml}
        
    <div class="wgt-clear small" ></div>
  </div>


HTML;

    $html .= $this->renderDropFormActionJs( $params );

    return $html;

  }//end public function renderDropForm */
  
  /**
   * @return string
   */
  public function renderTemplate( $view )
  {

    if( !$this->process )
    {
      Debug::console( 'MISSING PROCESS' );
      return 'Missing Process';
    }
    
    $i18n = $this->getI18n();
    
    $params       = $this->params;
    $this->formId = $params->formId;

    $statusData = $this->process->getActiveNode();

    $iconStatus   = $this->icon( $statusData->icon , $statusData->label );
    $iconHistory  = $this->icon( 'process/history.png', 'History' );


    $edges            = $this->process->getActiveEdges( );
    $actionHtml       = $this->renderTemplateEdgeActions( $edges, $params );
    $descriptionHtml  = $this->renderEdgeDescriptions( $edges, $params );
    
    $slides       = $this->process->getActiveSlices( );
    $slidesHtml   = '';
    
    if( $slides )
    {
      $slidesHtml .= '<div class="slides" >'.NL;
      
      foreach( $slides as $slide )
      {
        $slRenderer = $slide->getRenderer();
        $slidesHtml .= $slRenderer->render( $this );
      }
      
      $slidesHtml .= '</div>'.NL;
    }

    $html = <<<HTML

  <div style="width:650px;" class="wgt-space" >
  
    <form 
      method="put" 
      id="{$this->formId}"
      action="ajax.php?c={$this->process->processUrl}.switchStatus&amp;view_id={$view->id}&amp;objid={$this->process->activStatus}" ></form>

    <div class="half-b left" >
      <h3>{$i18n->l( 'Description', 'wbf.label' )}</h3>
      <div class="description-active" >
        {$statusData->description}
      </div>
{$descriptionHtml}
    </div>

    <div class="half-b right" >
      <h3>{$i18n->l( 'Action', 'wbf.label' )}</h3>
      <ul class="actions" >
        {$actionHtml}
      </ul>
      <div class="wgt-clear" ></div>
    </div>
    
    <div class="wgt-clear medium" ></div>

{$slidesHtml}
    
    <div class="wgt-clear small" ></div>
  </div>


HTML;

    return $html;

  }//end public function renderTemplate */

  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderEdgeActions( $edges, $params )
  {

    $html = '';
    $entity = $this->process->getEntity();
    
    $iconInfo = $this->icon( 'control/info.png' , 'Info' );

    foreach( $edges as $edge )
    {

      $iconNode = $this->icon( $edge->icon , $edge->label );

      $html .=<<<HTML

  <li>
    <button 
      class="wgt-button" 
      onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-{$this->process->name}-{$edge->key}')();" >
      {$iconNode} {$edge->label}
    </button> 

  </li>

HTML;

    /*
    
    <button 
      class="wgt-button info wcm wcm_ui_tip" 
      title="Klick for more information"  >
      {$iconInfo}
    </button>
     */

    }

    return $html;

  }//end protected function renderEdgeActions */
  
  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderDropFormEdgeActions( $edges, $params )
  {

    $html = '';
    $entity = $this->process->getEntity();
    
    $iconInfo = $this->icon( 'control/info.png' , 'Info' );

    foreach( $edges as $edge )
    {

      $iconNode = $this->icon( $edge->icon , $edge->label );

      $html .=<<<HTML

  <li>
    <button 
      class="wgt-button" 
      onclick="\$S('#{$params->inputId}').data('paction-{$this->process->name}-{$edge->key}')();" >
      {$iconNode} {$edge->label}
    </button> 

  </li>

HTML;

    }

    /*
    <button 
      class="wgt-button info wcm wcm_ui_tip" 
      title="Klick for more information"  >
      {$iconInfo}
    </button>
     */
    
    return $html;

  }//end protected function renderDropFormEdgeActions */
  
  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderTemplateEdgeActions( $edges, $params )
  {

    $html = '';
    $entity = $this->process->getEntity();
    
    $iconInfo = $this->icon( 'control/info.png' , 'Info' );

    foreach( $edges as $edge )
    {

      $iconNode = $this->icon( $edge->icon , $edge->label );

      $html .=<<<HTML

  <li>
    <button 
      class="wgt-button" 
      onclick="\$S('#{$this->formId}').data('paction-{$this->process->name}-{$edge->key}')();"
      id="wgt-button-{$this->process->name}-{$params->contextKey}-{$edge->key}" >
      {$iconNode} {$edge->label}
    </button> 

  </li>

HTML;

    }
    
    /*
    
    <button 
      class="wgt-button info wcm wcm_ui_tip" 
      id="wgt-button-info-{$this->process->name}-{$params->contextKey}-{$edge->key}"
      title="Klick for more information"  >
      {$iconInfo}
    </button>
     */

    return $html;

  }//end protected function renderTemplateEdgeActions */

  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderEdgeDescriptions( $edges, $params )
  {

    $html = '';

    foreach( $edges as $edge )
    {

      $html .= <<<HTML

  <div class="description-{$edge->key} hidden" >
    {$edge->description}
  </div>

HTML;

    }

    return $html;

  }//end protected function renderEdgeDescriptions */

  /**
   * @param TFlag $params
   * @return string
   */
  public function buildEdgeActionJs( $params )
  {

    if( !$this->process )
    {
      return '';
    }
    
    $edges  = $this->process->getActiveEdges( );
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = self.getObject().find("#wgt-process-{$this->process->name}-{$params->contextKey}").not('flag-touch');

    if( process ){
    
      process.addClass( 'flag-touch' );

      process.data( 'paction-history-{$this->process->name}', function(){
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });
      
      process.data( 'paction-details-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.form&objid={$this->process->activStatus}' );
        \$S.fn.miniMenu.close();
      });
      
      process.data( 'paction-graph-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}' );
        \$S.fn.miniMenu.close();
      });

    }
    else{
      alert("Missing Process Node!");
    }

HTML;
    
    foreach( $edges as $edge )
    {
    
      if( $edge->confirm )
      {
        
        $html .= <<<HTML

    if( process ){
      
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        self.setChanged( false );
        if( !\$S('input#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked') ){
          \$D.errorWindow( 'You have to confirm before trigger {$edge->label}' );
          return false;
        }
        \$R.form('{$params->formId}','&process_edge={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      }
      else 
      {
        
        $html .= <<<HTML

    if( process ){
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        self.setChanged( false );
        \$R.form('{$params->formId}','&process_edge={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      }

    }

    return $html;

  }//end public function buildEdgeActionJs */
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function renderDropFormActionJs( $params )
  {

    if( !$this->process )
    {
      return '';
    }
    
    $edges  = $this->process->getActiveEdges( );
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = \$S("#{$params->inputId}");
    var appendEvents = false;
    if( !process.is('flag-touch') ){
    
      process.addClass( 'flag-touch' );
      appendEvents = true;

      process.data( 'paction-history-{$this->process->name}', function(){
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });
      
      process.data( 'paction-details-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.form&objid={$this->process->activStatus}' );
        \$S.fn.miniMenu.close();
      });
      
      process.data( 'paction-graph-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}' );
        \$S.fn.miniMenu.close();
      });
    }

HTML;

    foreach( $edges as $edge )
    {
    
      if( $edge->confirm )
      {
        
        $html .= <<<HTML

    if( appendEvents ){
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        if( !\$S('#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked') ){
          \$D.errorWindow( 'You have to confirm before trigger {$edge->label}' );
          return false;
        }
        \$R.form('{$this->formId}','&status={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      }
      else 
      {
        
        $html .= <<<HTML

    if( appendEvents ){
    
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        \$R.form('{$this->formId}','&status={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      }

    }

    return '<script type="text/javascript" >(function(){'.$html.'})(window);</script>';

  }//end public function renderDropFormActionJs */
  
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function buildTemplateEdgeActionJs( $params )
  {

    if( !$this->process )
    {
      return '';
    }
    
    $edges  = $this->process->getActiveEdges( );
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = self.getObject().find('#{$params->formId}').not('flag-touch');

    if( process ){
      console.log('Found Process #{$params->formId}');
    
      process.addClass( 'flag-touch' );
      

      process.data( 'paction-history-{$this->process->name}', function(){
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
      });
      
      process.data( 'paction-details-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.form&objid={$this->process->activStatus}' );
      });
      
      process.data( 'paction-graph-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}' );
      });
    }
    else{
      alert('Missing Process #wgt-process-{$this->process->name}-{$params->contextKey}');
      console.error('Missing Process #wgt-process-{$this->process->name}-{$params->contextKey}');
    }


HTML;

    foreach( $edges as $edge )
    {
    
      if( $edge->confirm )
      {
        
        $html .= <<<HTML

    if( process ){
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        
        if( !\$S('#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked') ){
          \$D.errorWindow( 'You have to confirm before trigger {$edge->label}' );
          return false;
        }
        \$R.form('{$params->formId}','&process_edge={$edge->key}',{append:true});
      });
      console.log('Add pAction paction-{$this->process->name}-{$edge->key}');
    }


HTML;
      }
      else 
      {
        
        $html .= <<<HTML

    if( process ){
    
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        \$R.form('{$params->formId}','&process_edge={$edge->key}',{append:true});
      });
      console.log('Add pAction paction-{$this->process->name}-{$edge->key}');
    }


HTML;
      }

    }

    return $html;

  }//end public function buildTemplateEdgeActionJs */

}//end class WgtProcessForm


