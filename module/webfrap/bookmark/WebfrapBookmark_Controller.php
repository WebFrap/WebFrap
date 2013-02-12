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
class WebfrapBookmark_Controller
  extends Controller
{

  /**
   * @var array
   */
  protected $options           = array
  (
    'add' => array
    (
      'method'	=> array( 'POST' ),
      'views' 	=> array( 'ajax' )
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
  public function service_add( $request, $response )
  {

    /* @var $modelBookmark WebfrapBookmark_Model */
    //$modelBookmark = $this->loadModel( 'WebfrapBookmark' );

    $userId = $this->getUser()->getId();

    $title = $request->data( 'wbfsys_bookmark', Validator::TEXT, 'title' );
    $url = $request->data( 'wbfsys_bookmark', Validator::TEXT, 'url' );
    $vid = $request->data( 'wbfsys_bookmark', Validator::EID, 'vid' );


    $orm = $this->getOrm();
    $bookmark = $orm->newEntity( 'WbfsysBookmark' );
    $bookmark->id_role = $userId;
    $bookmark->title = $title;
    $bookmark->url = $url;
    $bookmark->vid = $vid;

    $orm->insertIfNotExists( $bookmark, array( 'id_role', 'url' ) );

    $response->addMessage("Created bookmark");

  }//end public function service_add */


} // end class WebfrapBookmark_Controller


