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
class DaidalosBdlNode_Docu_Model
  extends DaidalosBdlNode_Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var BdlNodeEntity
   */
  public $node = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param $modeller DaidalosBdlModeller_Model 
   */
  public function loadBdlNode( $modeller )
  {
    
    $this->modeller = $modeller;
    $this->node     = new BdlNodeDocu( $this->modeller->bdlFile );
    
  }//end public function loadBdlNode */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveRequest( $request )
  {
    
    $response = $this->getResponse();
    
    if( $name = $request->data( 'docu', Validator::CKEY, 'name' ) )
      $this->node->setName( $name );
      
    if( $module = $request->data( 'docu', Validator::CKEY, 'module' ) )
      $this->node->setModule( strtolower($module) );

    // title / content
    $titles = $request->data( 'docu', Validator::TEXT, 'label' );
    if( $titles )
    {
      foreach( $titles as $lang => $content )
      {
        $this->node->setTitle( $lang, $content );
      }
    }
    else 
    {
      if( !$this->node->hasTitle( 'de' ) )
        $this->node->setTitle( 'de', $this->node->getName() );
      if( !$this->node->hasTitle( 'en' ) )
        $this->node->setTitle( 'en', $this->node->getName() );
    }
    
    $shortDescs = $request->data( 'docu', Validator::TEXT, 'content' );
    if( $shortDescs )
    {
      foreach( $shortDescs as $lang => $content )
      {
        $this->node->setContent( $lang, $content );
      }
    }
    else 
    {
      if( !$this->node->hasContent( 'de' ) )
        $this->node->setContent( 'de', $this->node->getTitleByLang( 'de' ) );
      if( !$this->node->hasContent( 'en' ) )
        $this->node->setContent( 'en', $this->node->getTitleByLang( 'en' ) );
    }

    
    $this->modeller->save();
      
  }//end public function saveRequest */

}//end class DaidalosBdlNodeProfile_Model

