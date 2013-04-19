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
class ExampleAcl_Controller extends Controller
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
    'helloworld'
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   */
  public function umgangMitAcls1()
  {

    // arbeiten mit der zugriffskontrolle
    $acl = $this->getAcl();

    // prüfen ob der aktive user zugriffsrechte auf mindestens einer
    // der ebenen hat
    if (!$acl->access('mod-key/entity-key/mgmt-key:level')) {
      $this->accessDenied();

      return false;
    }

    // prüfen ob der aktive user zugriffsrechte auf mindestens einer
    // der ebenen hat und / oder diese partiell in relation zur entity
    // rechte können:
    // - global
    // - in relation zu einer tabelle
    // - in relatin zu einem datensatz
    // vergeben werden
    if (!$acl->access('mod-key/entity-key/mgmt-key:level',$entityObject)) {
      $this->accessDenied();

      return false;
    }

    // prüfen ob der aktive user die rolle admin in relation zu einem pfad hat
    if (!$acl->hasRole('admin', 'mod-key/entity-key/mgmt-key')) {
      $this->accessDenied();

      return false;
    }

    // auch hier kann die rolle in relation zu einer entität abgefragt werden
    if (!$acl->hasRole('admin', 'mod-key/entity-key/mgmt-key',$entityObject)) {
      $this->accessDenied();

      return false;
    }

  }//end public function umgangMitAcls1 */

  public function models1()
  {

    // model erstellen oder bereits erstelltes model laden
    // gib Model: SimpleExample_Model zurück
    $model = $this->loadModel('SimpleExample');

    // würde dasselbe objekt zurückgeben da wenn der 2te parameter leer ist
    // das der klassen name als key verwendet wird
    $model = $this->loadModel('SimpleExample');

    // erster aufruf erstellt ein neues model objekt: SimpleExample_Model
    $model2 = $this->loadModel('SimpleExample','nochEins');

    // 2ter aufruf gibt SimpleExample_Model objekt mit dem key: nochEins
    $model2 = $this->loadModel('SimpleExample','nochEins');

    // gleicher key bei unterschiedlicher klasse wird InvalidType Exception
    $model2 = $this->loadModel('AndereKlasse','nochEins');

  }//end public function models1 */

} // end class ControllerCrud
