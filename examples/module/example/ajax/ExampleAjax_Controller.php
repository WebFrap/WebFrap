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
 * Dummy class for Extentions
 * This class will be loaded if the System requests for an Extention that
 * doesn't exist
 * @package WebFrap
 * @subpackage Core
 */
class ExampleAjax_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * en:
   * {
   * }
   * de:
   * {
   *   Alle Methoden welche direkt über ein CallTripple (c=Simple.Example.helloWorld)
   *   angesprochen werden können, müssen hier lowercase! im array angegeben werden.
   *
   *   Klappt nicht?
   *   Häufige Fehler / Fehlerquellen:
   *    - eintrag in callAble vergessen
   *    - eintrag nicht lowercase
   *    - buchstabendreher
   *    - methode ist nicht public und kann deshalb nicht aufgerufen werden
   *    - call tripple enthält weniger als genau 3 werte
   *    - beim aufruf das c= vor dem tripple vergessen
   *    - ? anstelle von & als url trenner
   * }
   * @var array
   */
  protected $callAble = array
  (
    'example',
    'layouts',
    'forms',

    'sendmessage',
    'sendwarning',
    'senderror',
    'showrequesttype',

    'changebox1',
    'boxnewclass',
    'boxtoggleclass'
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * de:
   * {
   * Einfach Hello World Methode
   *
   * Diese Methode kann über den Browser / Client direkt über das Tripple
   * http: erster parameter (per konvention)  "c=Simple.Example.helloWorld"
   * cli:  erster parameter (zwinge an erster stelle) "Simple.Example.helloWorld"
   * }
   *
   * @param TArray $params Container über den Statusflags vom Controller in die
   *  tieferen MVC Ebene transportiert werden können
   */
  public function example($params = null)
  {

    // get subview prüft ob eine passende view für den jeweils angefragten
    // viewtype vorhanden ist
    // wenn ja wird ein view objekt erstellt, wenn nicht
    // wird null zurückgegeben
    if (!$view = $response->loadView('exampleAjax', 'ExampleAjax')) {
      // invalid request erstellt eine standard fehlermeldung dass die anfrage
      // so nicht korrekt war
      // muss noch etwas verbessert werden
      $this->invalidRequest();

      // return false heißt es gab einen fehler
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
    $view->displayExample($params);

  }//end public function example


  /**
   *
   * de:
   * {
   *   vorhandene layout elemente
   * }
   *
   * @param TArray $params
   */
  public function layouts($params = null)
  {


    if (!$view = $response->loadView('exampleAjax', 'ExampleAjax')) {
      $this->invalidRequest();

      return false;
    }


    $params = $this->getFlags($params);
    $view->displayLayout($params);

  }//end public function layouts */

  /**
   *
   * de:
   * {
   *   formular
   * }
   *
   * @param TArray $params
   */
  public function forms($params = null)
  {


    if (!$view = $response->loadView('exampleAjax', 'ExampleAjax')) {
      $this->invalidRequest();

      return false;
    }

    $params = $this->getFlags($params);
    $view->displayForm($params);

  }//end public function forms */

/*//////////////////////////////////////////////////////////////////////////////
// Ajax replace methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param TArray $params
   */
  public function changeBox1($params = null)
  {

    if (!$view = $response->loadView('exampleAjax', 'ExampleAjax')) {
      $this->invalidRequest();

      return false;
    }

    $params = $this->getFlags($params);
    $view->displayData1($params);

  }//end public function changeBox1 */


  /**
   *
   * @param TArray $params
   */
  public function boxNewClass($params = null)
  {

    if (!$view = $response->loadView('exampleAjax', 'ExampleAjax')) {
      $this->invalidRequest();

      return false;
    }

    $params = $this->getFlags($params);
    $view->displayNewClass($params);

  }//end public function boxNewClass */

  /**
   *
   * @param TArray $params
   */
  public function boxToggleClass($params = null)
  {

    if (!$view = $response->loadView('exampleAjax', 'ExampleAjax')) {
      $this->invalidRequest();

      return false;
    }

    $params = $this->getFlags($params);
    $view->displayToggleClass($params);

  }//end public function boxToggleClass */

/*//////////////////////////////////////////////////////////////////////////////
// Simple Calls
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * send a message
   * @param TArray $params
   */
  public function sendMessage($params = null)
  {

    $response = $this->getResponse();
    $response->addMessage('a simple message');

  }//end public function sendMessage */

  /**
   * send a warning
   * @param TArray $params
   */
  public function sendWarning($params = null)
  {

    $response = $this->getResponse();
    $response->addWarning('a simple warning');

  }//end public function sendWarning */

  /**
   * send error
   * @param TArray $params
   */
  public function sendError($params = null)
  {

    $response = $this->getResponse();
    $response->addError('a simple error');

  }//end public function sendError */

  /**
   * send error
   * @param TArray $params
   */
  public function showRequestType($params = null)
  {

    $response = $this->getResponse();
    $request  = $this->getRequest();

    $response->addMessage('Request Method was: '. $request->method());

  }//end public function sendError */

} // end class ControllerCrud
