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
class DaidalosBdlNode_Entity_Model extends DaidalosBdlNode_Model
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
  public function loadBdlNode($modeller )
  {
    
    $this->modeller = $modeller;
    
    $this->node     = new BdlNodeEntity($this->modeller->bdlFile );
    
  }//end public function loadBdlNode */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveRequest($request)
  {
    
    $response = $this->getResponse();
    
    $nodeKey = 'entity';
    
    
    if ($name = $request->data($nodeKey, Validator::CKEY, 'name' ) )
      $this->node->setName($name );
      
    if ($module = $request->data($nodeKey, Validator::CKEY, 'module' ) )
      $this->node->setModule($module );
      

    // label / description / docu
    $labels = $request->data($nodeKey, Validator::TEXT, 'label' );
    if ($labels )
    {
      foreach($labels as $lang => $content )
      {
        $this->node->setLabel($lang, $content );
      }
    } else {
      if (!$this->node->hasLabel( 'de' ) )
        $this->node->setLabel( 'de', $this->node->getName() );
      if (!$this->node->hasLabel( 'en' ) )
        $this->node->setLabel( 'en', $this->node->getName() );
    }
    
    $shortDescs = $request->data($nodeKey, Validator::TEXT, 'short_desc' );
    if ($shortDescs )
    {
      foreach($shortDescs as $lang => $content )
      {
        $this->node->setShortDesc($lang, $content );
      }
    } else {
      if (!$this->node->hasShortDesc( 'de' ) )
        $this->node->setShortDesc( 'de', $this->node->getDescriptionByLang( 'de' ) );
      if (!$this->node->hasShortDesc( 'en' ) )
        $this->node->setShortDesc( 'en', $this->node->getDescriptionByLang( 'en' ) );
    }
      
    $docus = $request->data($nodeKey, Validator::TEXT, 'docu' );
    if ($docus )
    {
      foreach($docus as $lang => $content )
      {
        $this->node->setDocu($lang, $content );
      }
    } else {
      if (!$this->node->hasDocu( 'de' ) )
        $this->node->setDocu( 'de', $this->node->getShortDescByLang( 'de' ) );
      if (!$this->node->hasDocu( 'en' ) )
        $this->node->setDocu( 'en', $this->node->getShortDescByLang( 'en' ) );
    }
    
    $this->modeller->save();
      
  }//end public function saveRequest */


}//end class DaidalosBdlNode_Entity_Model

