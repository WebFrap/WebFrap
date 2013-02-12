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
class DaidalosBdlNode_ProfileBackpath_Model
  extends DaidalosBdlNode_Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var BdlNodeProfileAreaBackpath
   */
  public $node = null;

  /**
   * @var BdlNodeProfileAreaBackpathNode
   */
  public $pathNode = null;

  /**
   * @var BdlNodeProfile
   */
  public $profile = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param DaidalosBdlModeller_Model $modeller
   * @param int $idx
   */
  public function loadBdlBackpath( $modeller, $idx )
  {

    $this->modeller = $modeller;
    $this->profile  = new BdlNodeProfile( $this->modeller->bdlFile );

    $this->node     = $this->profile->getBackpathByIndex( $idx );

  }//end public function loadBdlBackpath */

  /**
   * @param DaidalosBdlModeller_Model $modeller
   * @param int $idx
   */
  public function loadBdlBackpathNode( $modeller, $path )
  {

    $this->modeller = $modeller;
    $this->profile  = new BdlNodeProfile( $this->modeller->bdlFile );

    $this->pathNode  = $this->profile->getBackpathNodeByPath( $path );

  }//end public function loadBdlBackpathNode */

  /**
   */
  public function loadProfile( )
  {

    $this->profile = new BdlNodeProfile( $this->modeller->bdlFile );

  }//end public function loadProfile */

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function insertByRequest( $request, $response )
  {

    $this->profile = new BdlNodeProfile( $this->modeller->bdlFile );

    $domNode = $this->profile->createBackpath( );

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

    if ( $name = $request->data( 'backpath', Validator::CKEY, 'name' ) ) {
      $this->node->setName( $name );
    }

    if( $level = $request->data( 'backpath', Validator::CKEY, 'level' ) )
      $this->node->setLevel( $level );

    $descriptions = $request->data( 'backpath', Validator::TEXT, 'description' );
    if ($descriptions) {
      foreach ($descriptions as $lang => $content) {
        $this->node->setDescription( $lang, $content );
      }
    } else {
      if( !$this->node->hasDescription( 'de' ) )
        $this->node->setDescription( 'de', $this->node->getName( ) );
      if( !$this->node->hasDescription( 'en' ) )
        $this->node->setDescription( 'en', $this->node->getName( ) );
    }

    $this->modeller->save();

    return $this->node;

  }//end public function saveByRequest */

  /**
   * @return int
   */
  public function getLastCreatedIndex()
  {

    $number = $this->profile->countBackpaths();

    if( !$number )

      return 0;

    return $number -1;

  }//end public function getLastCreatedIndex */

  /**
   * @param int $idx
   * @return int
   */
  public function deleteByIndex( $idx )
  {

    if( !$this->profile )
      $this->loadProfile( );

    $this->profile->deleteBackpath( $idx );

    $this->modeller->save();

  }//end public function deleteByIndex */

////////////////////////////////////////////////////////////////////////////////
// References
////////////////////////////////////////////////////////////////////////////////

  /**
   * Speichern des HTTP Requests
   * @param string $path
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function insertNodeByRequest( $path, $request, $response )
  {

    $this->profile = new BdlNodeProfile( $this->modeller->bdlFile );

    $domNode    = $this->profile->createBackpathNode( $path );
    $this->pathNode = $domNode;

    return $this->saveNodeByRequest( $request, $response );

  }//end public function insertNodeByRequest */

  /**
   * Speichern des HTTP Requests
   * @param string $path
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function updateNodeByRequest( $path, $request, $response )
  {

    $domNode    = $this->profile->getBackpathNodeByPath( $path );
    $this->pathNode = $domNode;

    return $this->saveNodeByRequest( $request, $response );

  }//end public function updateNodeByRequest */

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function saveNodeByRequest( $request, $response )
  {

    if ( $name = $request->data( 'node', Validator::CKEY, 'name' ) ) {
      $this->pathNode->setName( $name );
    }

    if( $level = $request->data( 'node', Validator::CKEY, 'level' ) )
      $this->pathNode->setLevel( $level );

    $descriptions = $request->data( 'node', Validator::TEXT, 'description' );
    if ($descriptions) {
      foreach ($descriptions as $lang => $content) {
        $this->pathNode->setDescription( $lang, $content );
      }
    } else {
      if( !$this->pathNode->hasDescription( 'de' ) )
        $this->pathNode->setDescription( 'de', $this->pathNode->getName() );
      if( !$this->pathNode->hasDescription( 'en' ) )
        $this->pathNode->setDescription( 'en', $this->pathNode->getName() );
    }

    $this->modeller->save();

    return $this->pathNode;

  }//end public function saveByRequest */

  /**
   * @param string $path
   * @return int
   */
  public function getLastCreatedNodeIndex( $path )
  {

    $number = $this->profile->countBackpathNodes( $path );

    if( !$number )

      return 0;

    return $number -1;

  }//end public function getLastCreatedNodeIndex */

  /**
   * @param string $path
   * @param string $path
   * @return int
   */
  public function deleteNodeByIndex( $path )
  {

    if( !$this->profile )
      $this->loadProfile( );

    $this->profile->deleteBackpathNode( $path );

    $this->modeller->save();

  }//end public function deleteNodeByIndex */

}//end class DaidalosBdlNode_ProfileBackpath_Model
