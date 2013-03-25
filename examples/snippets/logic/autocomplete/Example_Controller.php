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
 * Exception to throw if you want to throw an unspecific Exception inside the
 * bussines logic.
 * If you don't catch it it will be catched by the system and you will get an
 * Error Screen Inside the Applikation.
 *
 * @package WebFrap
 * @subpackage Example
 */
class Example_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array
  (
    'autocomplete' => array
    (
      'method'    => array('GET', 'POST'),
      'views'      => array('ajax')
    ),

  );


/*//////////////////////////////////////////////////////////////////////////////
// Form Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocomplete($request, $response)
  {

    // resource laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();

    // check the permissions
    if (!$acl->access('mod-project>mgmt-autocomplete:listing'  )) {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to access {@service@}',
          'wbf.message',
          array
          (
            'service' => $response->i18n->l('Autocomplete', 'wbf.label')
          )
        ),
        Response::FORBIDDEN
      );
    }


    // load request parameters an interpret as flags
    $params = $this->getListingFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'example-autocomplete';

    $view  = $response->loadView
    (
      'example-ajax',
      'Example',
      'displayAutocomplete',
      View::AJAX
    );
    /* @var $model Example_Model */
    $model  = $this->loadModel('Example');
    //$model->setAccess($access);
    $view->setModel($model);

    $searchKey  = $this->request->param('key', Validator::TEXT);

    $error = $view->displayAutocomplete($searchKey, $params);

    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if ($error) {
      return $error;
    }

    $response->setStatus(Response::OK);
    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return null;

  }//end public function service_autocomplete */

} // end class Controller */

