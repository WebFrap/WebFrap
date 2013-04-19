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
 * @lang de:
 *
 * Codebeispiele für den Umgang mit den Validatoren und Santisizing Mechanismen
 *
 * @package WebFrap
 * @subpackage Core
 */
class ExampleValid_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Controller::$callAble
   */
  protected $callAble = array
  (
    'form',
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @lang de:
   * Formulöar mit allen existierenden Validatoren
   *
   * @param TParam $params Container über den Statusflags vom Controller in die
   *  tieferen MVC Ebene transportiert werden können
   */
  public function form($params = null)
  {

    // get subview prüft ob eine passende view für den jeweils angefragten
    // viewtype vorhanden ist
    // wenn ja wird ein view objekt erstellt, wenn nicht
    // wird null zurückgegeben
    if (!$view = $response->loadView('exampleValid', 'ExampleAjax')) {
      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist
      $this->errorPage
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );

      return false;
    }

    // ein paar steuerungs flags aus der url abfragen
    // je nach methoden type gibt es verschiedene Varianten von getFlags
    // params wird immer übergeben, ob nötig oder nicht, das hat son ein bisschen
    // die rollen von named parameters
    // TArray ist ein objekt mit nur virtuellen attributen
    // $tarray->keyExists gibt den zugewiesenen wert zurück
    // $tarray->keyNotExists immer null, es gib keinen unterschied zwischen wert = null und wert not exists
    $params = $this->getFlags($params);

    // ok anfrage war korrekt ab hier übernimmt das passende view objekt
    // neben display kann es auch displayXY geben
    // es muss also nicht zwingend display aufgerufen werden, die methoden
    // sollten jedoch alle mit display anfangen
    // alle display methoden haben immer mindestens einen parameter, nähmlich params
    // könne aber sonst belieblig viele parameter haben
    // pro MVC müssen die methoden für eine aufruf dann natürlich ein identisches interface haben
    $view->displayForm($params);

  }//end public function example

} // end class ControllerCrud
