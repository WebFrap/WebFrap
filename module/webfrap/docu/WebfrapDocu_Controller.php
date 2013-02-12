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
class WebfrapDocu_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   *
   * method: Der Service kann nur mit den im Array vorhandenen HTTP Methoden
   *   aufgerufen werden. Wenn eine falsche Methode verwendet wird, gibt das
   *   System automatisch eine "Method not Allowed" Fehlermeldung zurück
   *
   * views: Die Viewtypen die erlaubt sind. Wenn mit einem nicht definierten
   *   Viewtype auf einen Service zugegriffen wird, gibt das System automatisch
   *  eine "Invalid Request" Fehlerseite mit einer Detailierten Meldung, und der
   *  Information welche Services Viewtypen valide sind, zurück
   *
   * public: boolean wert, ob der Service auch ohne Login aufgerufen werden darf
   *   wenn nicht vorhanden ist die Seite per default nur mit Login zu erreichen
   *
   * @var array
   */
  protected $options           = array
  (
    'open' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal', 'maintab' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal', 'maintab' )
    ),
    'save' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'menu' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'page' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

 /**
  *  @param LibRequestHttp $request
  *  @param LibResponseHttp $response
  * @throws LibRequest_Exception
  */
  public function service_show( $request, $response )
  {

    $params = $this->getFlags( $request );

    $key = $request->param( 'key', Validator::CKEY );

    if (!$key) {
      $key = 'index';
    }

    $fileKey = str_replace( '-', '/', $key );

    $view = $response->loadView
    (
      $key.'-help',
      'WebfrapDocuViewer',
      'displayShow',
      null,
      true
    );

    $view->displayShow( $fileKey, $params );

  }//end public function service_show */

 /**
  *  @param LibRequestHttp $request
  *  @param LibResponseHttp $response
  * @return boolean im fehler false
  *
  */
  public function service_open( $request, $response )
  {

    $key = $request->param( 'key', Validator::TEXT );

    if (!$key) {
      // ohne key kann nichts angezeigt werden
      throw new InvalidRequest_Exception
      (
        'Missing a valid key',
        Response::BAD_REQUEST
      );
    }

    $orm = $this->getOrm();

    $helpPage = $orm->getByKey( 'WbfsysDocuHelp', $key );

    if (!$helpPage) {
      // hielfeseiten erst mal nur für existierende Masken zulassen
      $mask = $orm->getByKey( 'WbfsysMask', $key );
      if (!$mask) {
        // ohne key kann nichts angezeigt werden
        throw new InvalidRequest_Exception
        (
          'Create a new help page is only allowed for existing Masks',
          Error::NOT_FOUND
        );
      }

      $helpPage = $orm->newEntity( 'WbfsysDocuHelp' );
      $helpPage->access_key = $key;
      $helpPage->id_mask = $mask;
      $helpPage->title = $mask->name;

      $orm->insert( $helpPage );

    }

    $view = $response->loadView
    (
      $key.'-help',
      'WebfrapDocu',
      'displayShow',
      null,
      true
    );

    $view->displayShow( $helpPage );

  }//end public function service_open */

 /**
  *  @param LibRequestHttp $request
  *  @param LibResponseHttp $response
  * @return boolean im fehler false
  *
  */
  public function service_edit( $request, $response )
  {

    $key = $request->param( 'key', Validator::TEXT );

    if (!$key) {
      // ohne key kann nichts angezeigt werden
      throw new InvalidRequest_Exception
      (
        'Missing a valid key',
        Response::BAD_REQUEST
      );
    }

    $orm = $this->getOrm();

    $helpPage = $orm->getByKey( 'WbfsysDocuHelp', $key );

    if (!$helpPage) {
      // hielfeseiten erst mal nur für existierende Masken zulassen
      $mask = $orm->getByKey( 'WbfsysMask', $key );
      if (!$mask) {
        // ohne key kann nichts angezeigt werden
        throw new InvalidRequest_Exception
        (
          'Create a new help page is only allowed for existing Masks',
          Error::NOT_FOUND
        );
      }

      $helpPage = $orm->newEntity( 'WbfsysDocuHelp' );
      $helpPage->access_key = $key;
      $helpPage->id_mask = $mask;
      $helpPage->title = $mask->name;

      $orm->insert( $helpPage );

    }

    $view = $response->loadView
    (
      $key.'-help' ,
      'WebfrapDocu_Edit',
      'displayForm',
      null,
      true
    );

    $view->displayForm( $helpPage );

  }//end public function service_open */

 /**
  *  @param LibRequestHttp $request
  *  @param LibResponseHttp $response
  * @return boolean im fehler false
  *
  */
  public function service_save( $request, $response )
  {

    $key     = $request->param( 'key', Validator::TEXT );
    $content = $request->data( 'content', Validator::TEXT );

    if (!$key) {
      // ohne key kann nichts angezeigt werden
      throw new InvalidRequest_Exception
      (
        'Missing a valid key',
        Response::BAD_REQUEST
      );
    }

    $orm = $this->getOrm();

    try {
      $helpPage = $orm->getByKey( 'WbfsysDocuHelp', $key );

      if (!$helpPage) {
        // hielfeseiten erst mal nur für existierende Masken zulassen
        $mask = $orm->getByKey( 'WbfsysMask', $key );
        if (!$mask) {
          // ohne key kann nichts angezeigt werden
          throw new InvalidRequest_Exception
          (
            'Create a new help page is only allowed for existing Masks',
            Error::NOT_FOUND
          );
        }

        $helpPage = $orm->newEntity( 'WbfsysDocuHelp' );
        $helpPage->access_key = $key;
        $helpPage->id_mask = $mask;
        $helpPage->title = $mask->name;
        $helpPage->content = $content;

        $orm->insert( $helpPage );

      } else {
        $helpPage->content = $content;
        $orm->update( $helpPage );
      }

      $response->addMessage( "Saved" );

    } catch ( Exception $e ) {
      $response->addError( "Failed to save the Help Page. Sorry :-(" );
    }

    if ( $request->paramExists( 'show' ) ) {
      $view = $response->loadView( $key.'-help' , 'WebfrapDocu', 'displayShow',  View::SUBWINDOW );

      if( !$view )
        throw new InvalidRequest_Exception( "This Viewtype is not implemented", Response::NOT_IMPLEMENTED );

      $view->displayShow( $helpPage );
    }

  }//end public function service_open */

 /**
  *  @param LibRequestHttp $request
  *  @param LibResponseHttp $response
  * @throws LibRequest_Exception
  */
  public function service_menu( $request, $response )
  {

    $params = $this->getFlags( $request );

    $key = $request->param( 'key', Validator::CKEY );

    $view   = $response->loadView
    (
      'webfrap_docu_menu',
      'WebfrapDocu_Menu',
      'displayMenu',
      View::MAINTAB
    );

    $view->displayMenu( $params );

  }//end public function service_menu */

 /**
  *  @param LibRequestHttp $request
  *  @param LibResponseHttp $response
  * @throws LibRequest_Exception
  */
  public function service_page( $request, $response )
  {

    $params = $this->getFlags( $request );

    $key    = $request->param( 'page', Validator::CKEY );

    if( !$key )
      $key = 'wbf';

    $model  = $this->loadModel( 'WebfrapDocu_Page' );

    $view   = $response->loadView
    (
      'webfrap_docu_page',
      'WebfrapDocu_Page',
      'displayPage',
      View::MAINTAB
    );
    /* @var $view WebfrapDocu_Page_Maintab_View */
    $view->setModel( $model );

    $view->displayPage( $key, $params );

  }//end public function service_page */

}//end class WebfrapDocu_Controller
