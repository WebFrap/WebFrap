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
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class ControllerService extends Controller
{

  /**
   * @param string $methodeName
   * @param string $view
   */
  public function runIfCallable ($methodeName = null, $view = null)
  {

    $request = $this->getRequest();
    $response = $this->getResponse();

    if (is_null($methodeName))
      $methodeName = $this->activAction;

    if (method_exists($this, 'service_' . $methodeName)) {
      $methodeName = 'service_' . $methodeName;
      //$request, $response
      try {

        $error = $this->$methodeName($request, $response);

        if ($error && is_object($error)) {
          $this->errorPage($error);
        }

      } catch (Webfrap_Exception $error) {
        $this->errorPage($error);
      } catch (Webfrap $error) {
        $this->errorPage($error->getMessage(), Response::INTERNAL_ERROR);
      }

      return;
    } else {
      if (DEBUG)
        Debug::console($methodeName . ' is not callable!', $this->callAble);

      $response->addError('The action :' . $methodeName . ' is not callable!');

      $this->errorPage('The Action :' . $methodeName . ' is not callable!', Response::NOT_FOUND);

      return;
    }


  } //end public function runIfCallable */

  /**
   * get the form flags for this management
   * de:
   * {
   * prüfen ob die standard steuer flags vorhanden sind
   * }
   * @param TFlag $params
   * @return TFlag
   */
  protected function getFlags ($request)
  {
    return new ContextDefault($request);

  } //end protected function getFlags */

  /**
   * get the form flags for this management
   * @param TFlag $params
   * @return TFlag
   */
  protected function getFormFlags ($request)
  {
    return new ContextForm($request);

  } //end protected function getFormFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags ($request)
  {
    return new ContextCrud($request);

  } //end protected function getCrudFlags */

  /**
   * @lang de:
   * Auslesen der Listingflags
   *
   * @get_param: cname ltype,
   * Der Type der des Listenelements. Sollte sinnigerweise
   * der gleich type wie das Listenelement sein, für das die Suche angestoßen wurde
   *
   * @get_param: cname view_type,
   * Der genaue View Type, zb. Maintab, Subwindow etc.,
   * welcher verwendet wurde den eintrag zu erstellen.
   * Wird benötigt um im client die maske ansprechen zu können
   *
   * @get_param: cname mask,
   * Mask ist ein key mit dem angegeben wird welche
   * View genau verwendet werden soll. Dieser Parameter ist nötig, da es pro
   * tabelle mehrere management sichten geben kann die jeweils eigenen
   * listenformate haben
   *
   * @get_param: cname refid,
   * Wird benötigt wenn dieser Datensatz in Relation
   * zu einem Hauptdatensatz als referenz in einem Tab, bzw ManyToX Element
   * erstellt wurde.
   *
   * @get_param: cname view_id,
   * Die genaue ID der Maske. Wird benötigt um
   * die Maske bei der Rückgabe adressieren zu können
   *
   * @get_param: boolean append,
   * Flag das bei der Suche und dem Paging
   * in listenelementen zu einsatz kommt, wenn übergeben und true
   * werden die daten die zum client gepusht werden im listenelement
   * im body angehängt, standard aktion wäre das überschreiben
   * des body inhaltes
   *
   * @get_param: ckey a_root,
   * Die Rootarea des Pfades über den wir gerade in den rechten wandeln
   *
   * @get_param: ckey a_key,
   * Der key des knotens auf dem wir uns im pfad gerade befinden
   *
   * @get_param: int a_level,
   * Die aktuelle position im ACL Pfad
   *
   * @param TFlag $params
   *
   * @return TFlag
   */
  protected function getListingFlags ($request)
  {
    return new ContextListing($request);

  } //end protected function getListingFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getTabFlags ($request)
  {
    return new ContextTab($request);

  } //end protected function getTabFlags */

} // end class ControllerService
