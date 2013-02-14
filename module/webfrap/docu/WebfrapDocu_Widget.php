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
class WebfrapDocu_Widget extends WgtWidget
{
  /**
   * @param string $containerId die Id des Tab Containers in dem das Widget platziert wird
   * @param string $tabId die ID des Tabs für das Widget
   * @param string $tabSize die Höhe des Widgets in
   *
   * @return void
   */
  public function asTab( $containerId, $tabId, $tabSize = 'medium' )
  {

    // benötigte resourcen laden
    $user     = $this->getUser();
    $view     = $this->getView();
    $acl      = $this->getAcl();
    $db       = $this->getDb();
    $request  = $this->getRequest();

    $profile  = $user->getProfileName();

    $params   = new TFlagListing( $request );
    
    $content = '';
    
    $loader = new ExtensionLoader( 'index', 'data/docu/' );

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="Docu"  >
      <div class="wgt-panel title" ><h2>Docu</h2></div>
HTML;

    foreach( $loader as $file )
    {
      $html .= View::includeFile( PATH_GW.'data/docu/index/'.$file, $this ) ;
    }
    
    $html .=<<<HTML
      <div class="wgt-clear small" ></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

  /**
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function embed( $tabId, $tabSize = 'medium' )
  {
    // benötigte resourcen laden
    $user     = $this->getUser();
    $view     = $this->getView();
    $acl      = $this->getAcl();
    $db       = $this->getDb();
    $request  = $this->getRequest();

    $profile  = $user->getProfileName();

    $params   = new TFlagListing( $request );

    
    $loader = new ExtensionLoader( 'index', 'data/docu/' );

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="Docu"  >
      <div class="wgt-panel title" ><h2>Docu</h2></div>
HTML;

    foreach( $loader as $file )
    {
      $html .= View::includeFile( PATH_GW.'data/docu/index/'.$file, $this ) ;
    }
    
    $html .=<<<HTML
      <div class="wgt-clear small" ></div>
    </div>
HTML;

    return $html;

  }//end public function embed */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getSearchFlags( $params = null )
  {

    $request = $this->getRequest();

    if (!$params )
      $params = new TFlagListing( $request );

    // start position of the query and size of the table
    $params->start
      = $request->param('start', Validator::INT );

    // stepsite for query (limit) and the table
    if (!$params->qsize = $request->param( 'qsize', Validator::INT ) )
      $params->qsize = Wgt::$defListSize;

    // order for the multi display element
    $params->order
      = $request->param( 'order', Validator::CNAME );

    // target for a callback function
    $params->target
      = $request->param( 'target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
      = $request->param( 'target_id', Validator::CKEY  );

    // append ist das flag um in listenelementen die einträge
    // anhängen zu lassen anstelle den body zu pagen
    if( $append = $request->param( 'append', Validator::BOOLEAN ) )
      $params->append  = $append;

    // flag for beginning seach filter
    if( $text = $request->param( 'begin', Validator::TEXT ) )
    {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    return $params;

  }//end protected function getSearchFlags */

}// end class MyMessage_Widget

