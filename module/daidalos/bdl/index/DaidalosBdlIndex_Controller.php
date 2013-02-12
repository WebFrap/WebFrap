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
class DaidalosBdlIndex_Controller
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
    'sync' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'recreate' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Backup & Restore
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sync( $request, $response )
  {

    $params = $this->getFlags( $request );

    $model  = $this->loadModel( 'DaidalosBdlIndex' );
    $model->modeller = $this->loadModel( 'DaidalosBdlModeller' );

    $model->syncIndex( );

  }//end public function service_sync */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_openEditor( $request, $response )
  {

    $params = $this->getFlags( $request );

    $key     = $request->param( 'key', Validator::CKEY );
    $file    = $request->param( 'bdl_file', Validator::TEXT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    /* @var $model DaidalosBdlModeller_Model */

    $model->key = $key;

    $type = $model->guessFileType( $file );

    if (!$type) {
      throw new InternalError_Exception('Failed to guess the type for the requested file');
    }

    $nodeKey = 'DaidalosBdlNode_'.SParserString::subToCamelCase($type);

    if ( !Webfrap::classLoadable($nodeKey.'_Model')) {
      throw new InternalError_Exception( 'Sorry there is no support for filetype: '.$type.' yet' );
    }

    $nodeModel = $this->loadModel( $nodeKey );
    $nodeModel->loadBdlNode( $model );

    $view   = $response->loadView
    (
      'daidalos_repo-'.$type.'-editor-'.md5($file),
      $nodeKey,
      'displayEditor',
      View::MAINTAB
    );

    $view->setModel( $nodeModel );

    $view->displayEditor( $params );

  }//end public function service_openEditor */

} // end class DaidalosBdlModeller_Controller
