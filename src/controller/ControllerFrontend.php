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
class ControllerFrontend extends Controller
{

  /*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * get the form flags for this management
   * @param TFlag $params
   * @return TFlag
   */
  protected function getFormFlags ($request = null)
  {

    if (!$request)
      $request = Webfrap::$env->getRequest();

    return new ContextForm($request);

  } //end protected function getFormFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags ($request = null)
  {

    if (! $request)
      $request = Webfrap::$env->getRequest();

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
  protected function getListingFlags ($request = null)
  {

    if (! $request)
      $request = Webfrap::$env->getRequest();

    return new ContextListing($request);
    
  } //end protected function getListingFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getTabFlags ($request = null)
  {

    if (! $request)
      $request = Webfrap::$env->getRequest();

    return new ContextTab($request);

  } //end protected function getTabFlags */

} // end class ControllerFrontend
