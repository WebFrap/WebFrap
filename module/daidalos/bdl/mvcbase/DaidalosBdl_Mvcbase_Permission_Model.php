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
class DaidalosBdl_Mvcbase_Permission_Model
  extends DaidalosBdlNode_Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der domainkey
   * eg: profile
   * @var string
   */
  public $domainKey = null;
  
  /**
   * Domain Class Part
   * eg: Profile
   * @var string
   */
  public $domainClass = null;
  

  /**
   * @var BdlNodeBaseAreaPermission
   */
  public $node = null;
  
  /**
   * @var BdlNodeBaseAreaPermissionRef
   */
  public $refNode = null;
  
  /**
   * @var BdlBaseNode
   */
  public $parentNode = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param DaidalosBdlModeller_Model $modeller  
   * @param int $idx  
   */
  public function loadBdlPermission( $modeller, $idx )
  {
    
    $this->modeller = $modeller;
    
    $className = 'BdlNode'.$this->domainClass;
    
    $this->parentNode  = new $className( $this->modeller->bdlFile );
    
    $this->node     = $this->parentNode->getPermissionByIndex( $idx );
    
  }//end public function loadBdlPermission */
  
  /**
   * @param DaidalosBdlModeller_Model $modeller  
   * @param int $idx  
   */
  public function loadBdlPermissionRef( $modeller, $path )
  {
    
    $this->modeller = $modeller;
    
    $className = 'BdlNode'.$this->domainClass;
    $this->parentNode  = new $className( $this->modeller->bdlFile );
    
    $this->refNode  = $this->parentNode->getRefByPath( $path );
    
  }//end public function loadBdlPermission */
  
  
  /**
   */
  public function loadParentNode( )
  {
    
    $className = 'BdlNode'.$this->domainClass;
    $this->parentNode = new $className( $this->modeller->bdlFile );
    
  }//end public function loadParentNode */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function insertByRequest( $request, $response )
  {
    
    $className = 'BdlNode'.$this->domainClass;
    $this->parentNode = new $className( $this->modeller->bdlFile );
    
    $domNode = $this->parentNode->createPermission( );
    
    $this->node = $domNode; 

    return $this->saveByRequest( $request, $response );
      
  }//end public function insertByRequest */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function updateByRequest( $request, $response )
  {

    return $this->saveByRequest( $request, $response );
      
  }//end public function updateByRequest */
  
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveByRequest( $request, $response )
  {

    if( $name = $request->data( 'permission', Validator::CKEY, 'name' ) )
    {
      $this->node->setName( $name );
    }
      
    if( $level = $request->data( 'permission', Validator::CKEY, 'level' ) )
      $this->node->setLevel( $level );
      
    $descriptions = $request->data( 'permission', Validator::TEXT, 'description' );
    if( $descriptions )
    {
      foreach( $descriptions as $lang => $content )
      {
        $this->node->setDescription( $lang, $content );
      }
    }
    else 
    {
      if( !$this->node->hasDescription( 'de' ) )
        $this->node->setDescription( 'de', SParserString::subToName($this->node->getName( )) );
      if( !$this->node->hasDescription( 'en' ) )
        $this->node->setDescription( 'en', SParserString::subToName($this->node->getName( )) );
    }
   
    $this->modeller->save();
    
    return $this->node;
      
  }//end public function saveByRequest */

  /**
   * @return int
   */
  public function getLastCreatedIndex()
  {
    
    $number = $this->parentNode->countAreaPermissions();
    
    if( !$number )
      return null;
    
    return $number -1;
    
  }//end public function getLastCreatedIndex */
  
  /**
   * @param int $idx
   * @return int
   */
  public function deleteByIndex( $idx )
  {
    
    if( !$this->parentNode )
      $this->loadParentNode();
    
    $this->parentNode->deletePermission( $idx );
    
    $this->modeller->save();
    
  }//end public function deleteByIndex */
  
/*//////////////////////////////////////////////////////////////////////////////
// References
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function insertRefByRequest( $path, $request, $response )
  {
    
    $className = 'BdlNode'.$this->domainClass;
    $this->parentNode = new $className( $this->modeller->bdlFile );
    
    $domNode    = $this->parentNode->createPermissionRef( $path );
    $this->refNode = $domNode; 

    return $this->saveRefByRequest( $request, $response );
      
  }//end public function insertByRequest */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function updateRefByRequest( $path, $request, $response )
  {

    $domNode    = $this->parentNode->getRefByPath( $path );
    $this->refNode = $domNode; 

    return $this->saveRefByRequest( $request, $response );
      
  }//end public function updateRefByRequest */
  
  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveRefByRequest( $request, $response )
  {

    if( $name = $request->data( 'ref', Validator::CKEY, 'name' ) )
    {
      $this->refNode->setName( $name );
    }
      
    if( $level = $request->data( 'ref', Validator::CKEY, 'level' ) )
      $this->refNode->setLevel( $level );
      
    $descriptions = $request->data( 'ref', Validator::TEXT, 'description' );
    if( $descriptions )
    {
      foreach( $descriptions as $lang => $content )
      {
        $this->refNode->setDescription( $lang, $content );
      }
    }
    else 
    {
      if( !$this->refNode->hasDescription( 'de' ) )
        $this->refNode->setDescription( 'de', $this->refNode->getName() );
      if( !$this->refNode->hasDescription( 'en' ) )
        $this->refNode->setDescription( 'en', $this->refNode->getName() );
    }
   
    $this->modeller->save();
    
    return $this->refNode;
      
  }//end public function saveByRequest */
  
  /**
   * @param string $path
   * @return int
   */
  public function getLastCreatedRefIndex( $path )
  {
    
    $number = $this->parentNode->countAreaRefPermissions( $path );
    
    if( !$number )
      return 0;
    
    return $number -1;
    
  }//end public function getLastCreatedRefIndex */
  
  /**
   * @param string $path
   * @param int $idx
   * @return int
   */
  public function deleteRefByIndex( $path )
  {
    
    if( !$this->parentNode )
      $this->loadParentNode( );
    
    $this->parentNode->deletePermissionRef( $path );
    
    $this->modeller->save();
    
  }//end public function deleteRefByIndex */

}//end class DaidalosBdl_Mvcbase_Permission_Model

