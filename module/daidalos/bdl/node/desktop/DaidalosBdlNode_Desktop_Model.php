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
class DaidalosBdlNode_Desktop_Model
  extends DaidalosBdlNode_Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var BdlNodeDesktop
   */
  public $node = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param $modeller DaidalosBdlModeller_Model 
   */
  public function loadBdlNode( $modeller )
  {
    
    $this->modeller = $modeller;
    $this->node     = new BdlNodeDesktop( $this->modeller->bdlFile );
    
  }//end public function loadBdlNode */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveRequest( $request )
  {
    
    $response = $this->getResponse();
    
    if( $name = $request->data( 'desktop', Validator::CKEY, 'name' ) )
      $this->node->setName( $name );
      
    if( $extends = $request->data( 'desktop', Validator::CKEY, 'extends' ) )
      $this->node->setExtends( $extends );
      
    if( $module = $request->data( 'desktop', Validator::CKEY, 'module' ) )
      $this->node->setModule( $module );
      
    if( $navigation = $request->data( 'desktop', Validator::CKEY, 'navigation' ) )
      $this->node->setNavigationName( $navigation );
      
    if( $tree = $request->data( 'desktop', Validator::CKEY, 'tree' ) )
      $this->node->setTreeName( $tree );
      
    if( $workarea = $request->data( 'desktop', Validator::CKEY, 'workarea' ) )
      $this->node->setWorkareaName( $workarea );
      
      
    // label / description / docu
    $labels = $request->data( 'desktop', Validator::TEXT, 'label' );
    if( $labels )
    {
      foreach( $labels as $lang => $content )
      {
        $this->node->setLabel( $lang, $content );
      }
    }
    else 
    {
      if( !$this->node->hasLabel( 'de' ) )
        $this->node->setLabel( 'de', $this->node->getName() );
      if( !$this->node->hasLabel( 'en' ) )
        $this->node->setLabel( 'en', $this->node->getName() );
    }
    
    $shortDescs = $request->data( 'desktop', Validator::TEXT, 'short_desc' );
    if( $shortDescs )
    {
      foreach( $shortDescs as $lang => $content )
      {
        $this->node->setShortDesc( $lang, $content );
      }
    }
    else 
    {
      if( !$this->node->hasShortDesc( 'de' ) )
        $this->node->setShortDesc( 'de', $this->node->getLabelByLang( 'de' ) );
      if( !$this->node->hasShortDesc( 'en' ) )
        $this->node->setShortDesc( 'en', $this->node->getLabelByLang( 'en' ) );
    }
      
    $docus = $request->data( 'desktop', Validator::TEXT, 'docu' );
    if( $docus )
    {
      foreach( $docus as $lang => $content )
      {
        $this->node->setDocu( $lang, $content );
      }
    }
    else 
    {
      if( !$this->node->hasDocu( 'de' ) )
        $this->node->setDocu( 'de', $this->node->getShortDescByLang( 'de' ) );
      if( !$this->node->hasDocu( 'en' ) )
        $this->node->setDocu( 'en', $this->node->getShortDescByLang( 'en' ) );
    }
    
    $this->modeller->save();
      
  }//end public function saveRequest */

}//end class DaidalosBdlNodeProfile_Model

