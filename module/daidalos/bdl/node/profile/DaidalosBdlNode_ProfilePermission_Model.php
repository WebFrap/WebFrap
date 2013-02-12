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
class DaidalosBdlNode_ProfilePermission_Model
  extends DaidalosBdlNode_Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var BdlNodeProfileAreaPermission
   */
  public $node = null;

  /**
   * @var BdlNodeProfileAreaPermissionRef
   */
  public $refNode = null;

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
  public function loadBdlPermission( $modeller, $idx )
  {

    $this->modeller = $modeller;
    $this->profile  = new BdlNodeProfile( $this->modeller->bdlFile );

    $this->node     = $this->profile->getPermissionByIndex( $idx );

  }//end public function loadBdlPermission */

  /**
   * @param DaidalosBdlModeller_Model $modeller
   * @param int $idx
   */
  public function loadBdlPermissionRef( $modeller, $path )
  {

    $this->modeller = $modeller;
    $this->profile  = new BdlNodeProfile( $this->modeller->bdlFile );

    $this->refNode  = $this->profile->getRefByPath( $path );

  }//end public function loadBdlPermission */

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

    $domNode = $this->profile->createPermission( );

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

    if ( $name = $request->data( 'permission', Validator::CKEY, 'name' ) ) {
      $this->node->setName( $name );
    }

    if( $level = $request->data( 'permission', Validator::CKEY, 'level' ) )
      $this->node->setLevel( $level );

    $descriptions = $request->data( 'permission', Validator::TEXT, 'description' );
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

    $number = $this->profile->countAreaPermissions();

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

    if( !$this->profile )
      $this->loadProfile( );

    $this->profile->deletePermission( $idx );

    $this->modeller->save();

  }//end public function deleteByIndex */

////////////////////////////////////////////////////////////////////////////////
// References
////////////////////////////////////////////////////////////////////////////////

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function insertRefByRequest( $path, $request, $response )
  {

    $this->profile = new BdlNodeProfile( $this->modeller->bdlFile );

    $domNode    = $this->profile->createPermissionRef( $path );
    $this->refNode = $domNode;

    return $this->saveRefByRequest( $request, $response );

  }//end public function insertByRequest */

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function updateRefByRequest( $path, $request, $response )
  {

    $domNode    = $this->profile->getRefByPath( $path );
    $this->refNode = $domNode;

    return $this->saveRefByRequest( $request, $response );

  }//end public function updateRefByRequest */

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveRefByRequest( $request, $response )
  {

    if ( $name = $request->data( 'ref', Validator::CKEY, 'name' ) ) {
      $this->refNode->setName( $name );
    }

    if( $level = $request->data( 'ref', Validator::CKEY, 'level' ) )
      $this->refNode->setLevel( $level );

    $descriptions = $request->data( 'ref', Validator::TEXT, 'description' );
    if ($descriptions) {
      foreach ($descriptions as $lang => $content) {
        $this->refNode->setDescription( $lang, $content );
      }
    } else {
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

    $number = $this->profile->countAreaRefPermissions( $path );

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

    if( !$this->profile )
      $this->loadProfile( );

    $this->profile->deletePermissionRef( $path );

    $this->modeller->save();

  }//end public function deleteRefByIndex */

}//end class DaidalosBdlNode_ProfilePermission_Model
