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
class WebfrapTag_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var array
   */
  protected $options           = array
  (
    'overlaydset' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'add' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'autocomplete' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'disconnect' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_overlayDset( $request, $response )
  {

    $element  = $request->param( 'element', Validator::EID );
    $dKey     = $request->param( 'dkey', Validator::TEXT );
    $objid    = $request->param( 'objid', Validator::EID );

    /* @var $view WebfrapHistory_Ajax_View  */
    $view = $response->loadView
    (
    	'webfrap-tag-dset',
    	'WebfrapTag',
    	'displayOverlay'
    );

    /* @var $model WebfrapTag_Model */
    $model = $this->loadModel( 'WebfrapTag' );

    $view->setModel( $model );
    $view->displayOverlay( $element, $dKey, $objid );

  }//end public function service_overlayDset */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_add( $request, $response )
  {

    /* @var $model WebfrapTag_Model */
    $model = $this->loadModel( 'WebfrapTag' );

    $name   = $request->data( 'name', Validator::TEXT );

    // gehen wir mal davon aus, dass die per autocomplete kam und wohl korrekt ist
    $id     = $request->data( 'tag_id', Validator::EID );

    // die sollte entweder per autocomplete kommen oder statisch im widget
    // vorhanden sein
    $refId  = $request->data( 'refid', Validator::EID );

    // sicher stellen, dass alle benötigten Informationen vorhanden sind
    if( !$refId || ( !$name && !$id ) )
    {
      throw new InvalidRequest_Exception
      (
        Error::INVALID_REQUEST_MSG,
        Error::INVALID_REQUEST
      );
    }

    if( $id )
    {
      $tagNode = $id;
    }
    else
    {
      $tagNode = $model->addTag( $name );
    }

    $conEntity = $model->addConnection( $tagNode, $refId );

    $view = $this->getTplEngine();
    $view->setRawJsonData(array
    (
      'label' => SFormatStrings::cleanCC($name),
      'tag_id' => (string)$tagNode,
      'ref_id' => (string)$conEntity,
    ));

  }//end public function service_add */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocomplete( $request, $response )
  {

    /* @var $model WebfrapTag_Model */
    $model = $this->loadModel( 'WebfrapTag' );

    $key   = $request->param( 'key', Validator::TEXT );

    // die sollte entweder per autocomplete kommen oder statisch im widget
    // vorhanden sein
    $refId  = $request->param( 'refid', Validator::EID );

      // sicher stellen, dass alle benötigten Informationen vorhanden sind
    if( !$key || !$refId )
    {
      throw new InvalidRequest_Exception
      (
        Error::INVALID_REQUEST_MSG,
        Error::INVALID_REQUEST
      );
    }

    $view = $this->getTplEngine();
    $view->setRawJsonData( $model->autocompleteByName( $key, $refId ) );

  }//end public function service_autocomplete */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_disconnect( $request, $response )
  {

    $id   = $request->param( 'objid', Validator::EID );

    /* @var $model WebfrapTag_Model */
    $model = $this->loadModel( 'WebfrapTag' );

    $model->disconnect($id);

  }//end public function service_disconnect */


} // end class WebfrapBookmark_Controller


