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
class DaidalosBdlNode_EntityAttribute_Model extends DaidalosBdlNode_Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var BdlNodeEntityAttribute
   */
  public $node = null;
  
  /**
   * @var BdlNodeEntity
   */
  public $entityNode = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param DaidalosBdlModeller_Model $modeller  
   * @param int $idx  
   */
  public function loadBdlAttribute($modeller, $idx )
  {
    
    $this->modeller = $modeller;
    $this->entityNode  = new BdlNodeEntity($this->modeller->bdlFile );
    
    $this->node     = $this->entityNode->getAttribute($idx );
    
  }//end public function loadBdlAttribute */

  /**
   * @param DaidalosBdlModeller_Model $modeller  
   */
  public function loadEntity($modeller = null )
  {
    
    if ($modeller )
      $this->modeller = $modeller;
    
    $this->entityNode = new BdlNodeEntity($this->modeller->bdlFile );
    
  }//end public function loadEntity */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function insertByRequest($request, $response )
  {
    
    if (!$this->entityNode )
      $this->loadEntity();
    
    $domNode = $this->entityNode->createAttribute( );
    
    $this->node = $domNode; 

    return $this->saveByRequest($request, $response );
      
  }//end public function insertByRequest */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function updateByRequest($request, $response )
  {

    return $this->saveByRequest($request, $response );
      
  }//end public function updateByRequest */
  
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveByRequest($request, $response )
  {

    $this->node->setName($request->data( 'attribute', Validator::CKEY, 'name' ) );
    $this->node->setType($request->data( 'attribute', Validator::CKEY, 'type' ) );
    $this->node->setIsA($request->data( 'attribute', Validator::CKEY, 'is_a' ) );
    $this->node->setSize($request->data( 'attribute', Validator::NUMERIC, 'size' ) );
    $this->node->setTarget($request->data( 'attribute', Validator::CKEY, 'target' ) );
    
    
    $this->node->setCategory($request->data( 'attribute', Validator::CKEY, 'category' ) );
    
    
    $this->node->setValidator($request->data( 'attribute', Validator::CKEY, 'validator' ) );
    $this->node->setMinSize($request->data( 'attribute', Validator::NUMERIC, 'min_size' ) );
    $this->node->setMaxSize($request->data( 'attribute', Validator::NUMERIC, 'max_size' ) );
    
    $this->node->setSearchFree($request->data( 'attribute', Validator::BOOLEAN, 'search_free' ) );
    $this->node->setSearchType($request->data( 'attribute', Validator::CKEY, 'search_type' ) );
    $this->node->setIndex($request->data( 'attribute', Validator::CKEY, 'index' ) );
    
    if ($request->data( 'attribute', Validator::BOOLEAN, 'unique' ) )
    {
      $this->node->setUnique( true );
    } else {
      $this->node->setUnique( false );
    }
    
    if ($request->data( 'attribute', Validator::BOOLEAN, 'required' ) )
    {
      $this->node->setRequired( true );
    } else {
      $this->node->setRequired( false );
    }
    
      
    // label / description / docu
    $labels = $request->data( 'attribute', Validator::TEXT, 'label' );
    if ($labels )
    {
      foreach($labels as $lang => $content )
      {
        $this->node->setLabel($lang, $content );
      }
    } else {
      if (!$this->node->hasLabel( 'de' ) )
        $this->node->setLabel( 'de', SParserString::subToName($this->node->getName())  );
      if (!$this->node->hasLabel( 'en' ) )
        $this->node->setLabel( 'en', SParserString::subToName($this->node->getName()) );
    }
    
    $descriptions = $request->data( 'attribute', Validator::TEXT, 'description' );
    if ($descriptions )
    {
      foreach($descriptions as $lang => $content )
      {
        $this->node->setDescription($lang, $content );
      }
    } else {
      if (!$this->node->hasDescription( 'de' ) )
        $this->node->setDescription( 'de', $this->node->getLabelByLang( 'de' ) );
      if (!$this->node->hasDescription( 'en' ) )
        $this->node->setDescription( 'en', $this->node->getLabelByLang( 'en' ) );
    }
      
    $docus = $request->data( 'attribute', Validator::TEXT, 'docu' );
    if ($docus )
    {
      foreach($docus as $lang => $content )
      {
        $this->node->setDocu($lang, $content );
      }
    } else {
      if (!$this->node->hasDocu( 'de' ) )
        $this->node->setDocu( 'de', $this->node->getDescriptionByLang( 'de' ) );
      if (!$this->node->hasDocu( 'en' ) )
        $this->node->setDocu( 'en', $this->node->getDescriptionByLang( 'en' ) );
    }
   
    $this->modeller->save();
    
    return $this->node;
      
  }//end public function saveByRequest */

  /**
   * @return int
   */
  public function getLastCreatedIndex()
  {
    
    $number = $this->entityNode->countAttributes();
    
    if (!$number )
      return 0;
    
    return $number -1;
    
  }//end public function getLastCreatedIndex */
  
  /**
   * @param int $idx
   * @return int
   */
  public function deleteByIndex($idx )
  {
    
    if (!$this->entityNode )
      $this->loadEntity();
    
    $this->entityNode->deleteAttribute($idx );
    
    $this->modeller->save();
    
  }//end public function deleteByIndex */

/*//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Erfragen der Attribute Definitionen
   * @return array
   */
  public function getDefinitions(  )
  {
    
    $db = $this->getDb();
    
    $defQuery = $db->newQuery( 'BdlDefinitionKey_Selectbox' );
    
    $defQuery->fetchSelectbox();
    
    return $defQuery;
    
  }//end public function getDefinitions */
  
  
}//end class DaidalosBdlNode_EntityAttribute_Model

