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
class WgtProcessFormSlice_Rating
  extends WgtProcessFormSlice
{
////////////////////////////////////////////////////////////////////////////////
// public interface attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * der Prozess
   * @var Process
   */
  public $processForm = null;

  /**
   * Objekt mit relevanten Parametern zum bauen des Form Templates
   * @var string
   */
  public $params  = null;

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

    if( $params )
      $this->params = $params;

    $this->processForm = $params->formId;
    $i18n              = $this->getI18n();

    $statusData = $this->process->getActiveNode();

    $iconStatus   = $this->icon( $statusData->icon , $statusData->label );
    $iconHistory  = $this->icon( 'process/history.png', 'History' );
    $iconDetails  = $this->icon( 'control/mask.png', 'Details' );

    $edges        = $this->process->getActiveEdges( );
    $responsibles = $this->process->getActiveResponsibles( );

    $actionHtml       = $this->renderEdgeActions( $edges, $params );
    $descriptionHtml  = $this->renderEdgeDescriptions( $edges, $params );

    $responsibleHtml  = '';

    if ($responsibles) {

      $respEntries = '';

      foreach ($responsibles as $responsible) {
        $respEntries .= "<li><a class=\"wcm wcm_req_mtab\" href=\"maintab.php?c=Wbfsys.RoleUser.show&amp;objid={$responsible->userId}\" >{$responsible->lastname}, {$responsible->firstname}</a></li>".NL;
      }

      $responsibleHtml .= <<<HTML

        <div class="forcefull" >
          <h3>{$i18n->l('Responsible','wbf.label')}</h3>
          <div class="nearly-full wgt-space wgt-corner" >
            <ul>{$respEntries}</ul>
          </div>
          <div class="wgt-clear" ></div>
        </div>

HTML;

    }

    $html = <<<HTML

  <li class="wgt-root" >

    <button
        class="wcm wcm_ui_button wcm wcm_ui_dropform wcm_ui_tip-top" id="wgt-process-{$this->process->name}-{$params->contextKey}"
        title="Click to Change the Status"
      >{$iconStatus} Status: {$statusData->label}</button>

    <div class="wgt-process-{$this->process->name}-{$params->contextKey} hidden" >

      <div class="wgt-process-form" >

        <div class="wgt-panel title" >
          <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>
        </div>

        <div class="wgt-panel" >

          <button
            class="wgt-button"
            tabindex="-1"
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-history-{$this->process->name}')();" >{$iconHistory} Show History</button>

           <button
            class="wgt-button"
            tabindex="-1"
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-details-{$this->process->name}')();" >{$iconDetails} Overview</button>

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

        <div class="comment" >
          <h3>{$i18n->l('Comment','wbf.label')} <span class="wgt-required wcm wcm_ui_tip" title="{$i18n->l('Is Required','wbf.label')}" >*</span></h3>
          <div>
            <textarea class="xlarge medium-height asgd-{$this->formId} flag-template" name="{$this->process->name}[comment]"  ></textarea>
          </div>
        </div>

{$responsibleHtml}

        <div class="wgt-clear small" ></div>
      </div>

    </div>
  </li>

HTML;

    return $html;

  }//end public function render */


  /**
   * @param TFlag $params
   * @return string
   */
  public function renderListForm( $params )
  {

    $this->formId = $params->formId;
    $i18n         = $this->getI18n();

    Debug::console( "RENDER PROCESS", $this->process );

    if (!$this->process) {
      Debug::console( 'MISSING PROCESS' );

      return '';
    }

    $statusData = $this->process->getActiveNode();

    $iconStatus   = $this->icon( $statusData->icon , $statusData->label );
    $iconHistory  = $this->icon( 'process/history.png', 'History' );
    $iconDetails  = $this->icon( 'control/mask.png', 'Details' );

    /*
    <div class="wgt-panel" >
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/feedback.png" /> Request Feedback</button>
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/history.png" /> Show History</button>
    </div>
     */

    $edges        = $this->process->getActiveEdges( );
    $responsibles = $this->process->getActiveResponsibles( );

    $actionHtml       = $this->renderListFormEdgeActions( $edges, $params );
    $descriptionHtml  = $this->renderEdgeDescriptions( $edges, $params );

    $responsibleHtml  = '';

    if ($responsibles) {

      $respEntries = '';

      foreach ($responsibles as $responsible) {
        $respEntries .= "<li><a class=\"wcm wcm_req_mtab\" href=\"maintab.php?c=Wbfsys.RoleUser.show&amp;objid={$responsible->userId}\" >{$responsible->lastname}, {$responsible->firstname}</a></li>".NL;
      }

      $responsibleHtml .= <<<HTML

        <div class="forcefull" >
          <h3>{$i18n->l('Responsible','wbf.label')}</h3>
          <div class="nearly-full wgt-space wgt-corner" >
            <ul>{$respEntries}</ul>
          </div>
          <div class="wgt-clear" ></div>
        </div>

HTML;

    }


    $urlSwitchType = '';
    $appendToUrl  = '';

    if ($params->maskType) {
      $urlSwitchType = ucfirst($params->maskType);
    }

    if ($params->mask) {
      $appendToUrl   .= "&amp;mask={$params->mask}" ;
    }

    if ($params->ltype) {
      $appendToUrl   .= "&amp;ltpye={$params->ltype}";
    }

    if ($params->element) {
      $appendToUrl   .= "&amp;element={$params->element}";
    }

    if ($params->refId) {
      $appendToUrl   .= "&amp;refid={$params->refId}";
    }

    if ($params->viewId) {
      $appendToUrl   .= "&amp;view_id={$params->viewId}";
    }

    $html = <<<HTML

  <div class="wgt-process-form" >

    <form
      method="put"
      id="{$params->formId}"
      action="maintab.php?c={$this->process->processUrl}.switchStatus{$urlSwitchType}&amp;objid={$this->process->activStatus}{$appendToUrl}" ></form>

    <div class="wgt-panel title" >
      <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>
    </div>

    <div class="wgt-panel" >

      <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#{$params->inputId}').data('paction-history-{$this->process->name}')();" >{$iconHistory} Show History</button>

       <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#{$params->inputId}').data('paction-details-{$this->process->name}')();" >{$iconDetails} Overview</button>

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

    <div class="comment" >
      <h3>{$i18n->l('Comment','wbf.label')} <span class="wgt-required wcm wcm_ui_tip" title="{$i18n->l('Is Required','wbf.label')}" >*</span></h3>
      <div>
        <textarea
          class="xlarge medium-height asgd-{$this->formId} flag-template"
          name="{$this->process->name}[comment]"  ></textarea>
      </div>
    </div>

{$responsibleHtml}

    <div class="wgt-clear small" ></div>
  </div>


HTML;

    $html .= $this->renderListFormActionJs( $params );

    return $html;

  }//end public function renderListForm */

  /**
   * @return string
   */
  public function renderTemplate( $view )
  {

    if (!$this->process) {
      Debug::console( 'MISSING PROCESS' );

      return 'Missing Process';
    }

    $i18n = $this->getI18n();

    $params = $this->params;
    $this->formId = $params->formId;

    $statusData = $this->process->getActiveNode();

    $iconStatus   = $this->icon( $statusData->icon , $statusData->label );
    $iconHistory  = $this->icon( 'process/history.png', 'History' );

    /*
    <div class="wgt-panel" >
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/feedback.png" /> Request Feedback</button>
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/history.png" /> Show History</button>
    </div>
     */

    $edges        = $this->process->getActiveEdges( );
    $responsibles = $this->process->getActiveResponsibles( );

    $actionHtml       = $this->renderTemplateEdgeActions( $edges, $params );
    $descriptionHtml  = $this->renderEdgeDescriptions( $edges, $params );

    $responsibleHtml  = '';

    if ($responsibles) {

      $respEntries = '';

      foreach ($responsibles as $responsible) {
        $respEntries .= "<li><a class=\"wcm wcm_req_mtab\" href=\"maintab.php?c=Wbfsys.RoleUser.show&amp;objid={$responsible->userId}\" >{$responsible->lastname}, {$responsible->firstname}</a></li>".NL;
      }

      $responsibleHtml .= <<<HTML

        <fieldset class="nearly_full" >
          <legend>{$i18n->l('Responsible','wbf.label')}</legend>
          <div class="nearly-full wgt-space" >
            <ul>{$respEntries}</ul>
          </div>
          <div class="wgt-clear" ></div>
        </fieldset>

HTML;

    }

    $html = <<<HTML

  <div style="width:650px;" class="wgt-space" >

    <form
      method="put"
      id="{$this->formId}"
      action="maintab.php?c={$this->process->processUrl}.switchStatus&amp;view_id={$view->id}&amp;objid={$this->process->activStatus}" ></form>

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

    <div class="forcefull" >
      <h3>{$i18n->l( 'Comment', 'wbf.label' )} <span class="wgt-required wcm wcm_ui_tip" title="{$i18n->l( 'Is Required', 'wbf.label' )}" >*</span></h3>
      <div>
        <textarea
          class="full large-height asgd-{$this->formId}"
          name="{$this->process->name}[comment]"
          style="width:99%"  ></textarea>
      </div>
    </div>

    <div class="wgt-clear medium" ></div>

{$responsibleHtml}

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

    foreach ($edges as $edge) {

      $iconNode = $this->icon( $edge->icon , $edge->label );

      $html .=<<<HTML

  <li>
    <button
      class="wgt-button"
      tabindex="-1"
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
  protected function renderListFormEdgeActions( $edges, $params )
  {

    $html = '';
    $entity = $this->process->getEntity();

    $iconInfo = $this->icon( 'control/info.png' , 'Info' );

    foreach ($edges as $edge) {

      $iconNode = $this->icon( $edge->icon , $edge->label );

      $html .=<<<HTML

  <li>
    <button
      class="wgt-button"
      tabindex="-1"
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

  }//end protected function renderListFormEdgeActions */

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

    foreach ($edges as $edge) {

      $iconNode = $this->icon( $edge->icon , $edge->label );

      $html .=<<<HTML

  <li>
    <button
      class="wgt-button"
      tabindex="-1"
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

    foreach ($edges as $edge) {

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

    if (!$this->process) {
      return '';
    }

    $edges  = $this->process->getActiveEdges( );
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = self.getObject().find("#wgt-process-{$this->process->name}-{$params->contextKey}").not('flag-touch');

    if (process) {
      process.addClass( 'flag-touch' );

      process.data( 'paction-history-{$this->process->name}', function(){
        \$R.get('modal.php?c=Process.Base.showHistory&amp;process={$this->process->activStatus}&amp;objid={$entity}&amp;entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });

      process.data( 'paction-details-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.form&amp;objid={$this->process->activStatus}' );
        \$S.fn.miniMenu.close();
      });

    }

HTML;

    foreach ($edges as $edge) {

      $html .= <<<HTML

    if (process) {
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        self.setChanged( false );
        \$R.form('{$params->formId}','&amp;process_edge={$edge->key}&amp;reload=true',{append:true});
      });
    }

HTML;

    }

    return $html;

  }//end public function buildEdgeActionJs */

  /**
   * @param TFlag $params
   * @return string
   */
  public function renderListFormActionJs( $params )
  {

    if (!$this->process) {
      return '';
    }

    $edges  = $this->process->getActiveEdges( );
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = \$S("#{$params->inputId}").not('flag-touch');

    if (process) {
      process.addClass( 'flag-touch' );

      process.data( 'paction-history-{$this->process->name}', function(){
        \$R.get('modal.php?c=Process.Base.showHistory&amp;process={$this->process->activStatus}&amp;objid={$entity}&amp;entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });

      process.data( 'paction-details-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.form&amp;objid={$this->process->activStatus}' );
        \$S.fn.miniMenu.close();
      });

    }

HTML;

    foreach ($edges as $edge) {

      $html .= <<<HTML

    if (process) {
      process.data( 'paction-{$this->process->name}-{$edge->key}', function(){
        \$R.form('{$params->formId}','&status={$edge->key}&reload=true',{append:true});
      });
    }

HTML;

    }

    return '<script type="application/javascript" >'.$html.'</script>';

  }//end public function renderListFormActionJs */


  /**
   * @param TFlag $params
   * @return string
   */
  public function buildTemplateEdgeActionJs( $params )
  {

    if (!$this->process) {
      return '';
    }

    $edges  = $this->process->getActiveEdges( );
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = self.getObject().find("#wgt-process-{$this->process->name}-{$params->contextKey}").not('flag-touch');

    if (process) {
      process.addClass( 'flag-touch' );

      process.data( 'paction-history-{$this->process->name}', function(){
        \$R.get('modal.php?c=Process.Base.showHistory&amp;process={$this->process->activStatus}&amp;objid={$entity}&amp;entity={$entity->getTable()}');
      });

      process.data( 'paction-details-{$this->process->name}', function(){
        \$R.get( 'maintab.php?c={$this->process->processUrl}.form&amp;objid={$this->process->activStatus}' );
      });

    }

HTML;

    foreach ($edges as $edge) {

      $html .= <<<HTML

    if (process) {
      \$S('#wgt-button-{$this->process->name}-{$params->contextKey}-{$edge->key}').click( function(){
        \$R.form('{$params->formId}','&amp;process_edge={$edge->key}',{append:true});
      });
    }

HTML;

    }

    return $html;

  }//end public function buildTemplateEdgeActionJs */

}//end class WgtProcessFormSlice_Rating
