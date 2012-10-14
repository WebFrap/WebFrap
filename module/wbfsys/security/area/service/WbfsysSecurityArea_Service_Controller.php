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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WbfsysSecurityArea_Service_Controller
  extends ControllerCrud
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
    'autocomplete' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
  );


////////////////////////////////////////////////////////////////////////////////
// Load Methodes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocomplete( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // check the permissions
    if( !$this->acl->access( 'mod-wbfsys>mgmt-wbfsys_security_area:listing'  ) )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to access {@service@}',
          'wbf.message',
          array
          (
            'service' => $response->i18n->l( 'Autocomplete', 'wbf.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }
    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_security_area-service-autocomplete';

    $view  = $this->tpl->loadView( 'WbfsysSecurityArea_Service_Ajax' );
    $model  = $this->loadModel( 'WbfsysSecurityArea_Service' );
    //$model->setAccess( $access );
    $view->setModel( $model );

    $searchKey  = $this->request->param( 'key', Validator::TEXT );

    $error = $view->displayAutocomplete( $searchKey, $params );

  }//end public function service_autocomplete */

}//end class WbfsysSecurityArea_Service_Controller

