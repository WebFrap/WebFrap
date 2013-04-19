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
class ExampleSimple_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/



/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function service_helloWorld($request, $response)
  {

    // einfachster weg, template direkt der standard template engine übergeben
    $this->tplEngine->setTemplate('simple/helloWorld');

    // zugriff im template per <?php echo $VAR->key ?\>
    $this->tplEngine->addVar('key','value');

    // übergabe mehrer variablen
    // type ist egal, lediglich der key muss unique sein
    $this->tplEngine->addVars(array(
      'key1' => 'val1',
      'key2' => array('array','geht','auch'), // <?php echo $VAR->key2[0] ?\>
    ));


    // erstellen eines einfachen UI Elements
    // die parameter im controller sind optional
    // wenn das element im template platziert werden soll, kann jedoch direkt
    // der key  als parameter übergeben werden sowie das view objekt in dessen template
    // das element vorhanden sein soll
    // einbinden im template per <?php echo $ELEMENT->keyFuersTemplate ?\>
    // spätestens toString löst das rendern des htmls im objekt aus
    $table = new SimpleExample_Table_Element('keyFuersTemplate',$this->tplEngine);

    // vorab aufruf einer bestimmten build methode
    // erstelltes html wird im objekt gespeichert erneutes aufrufen einer build methode
    // hat nach dem ersten aufruf keinen effekt mehr
    $table->build();


    // fertig
    // die ausgabe passiert nun automatisch anhand der daten im templatesystem

  }//end public function helloWorld


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
