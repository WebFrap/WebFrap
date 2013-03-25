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
class WebfrapAnnouncement_Table_Ajax_View extends LibTemplateAjaxView
{
 /**
  * de:
  * behandeln einer suchanfrage vom client
  * alles in allem recht unspektakulär, das ui element für die tabelle
  * wird geladen, mit daten befüllt und mit refresh als pushabel area objekt
  * direkt der ajax template engine übergeben
  *
  * @param TFlag $params
  * @return null|Error im Fehlerfall
  */
  public function displaySearch($params)
  {

    $access = $params->access;

    $ui    = $this->loadUi('WebfrapAnnouncement_Table');
    $ui->setModel($this->model);
    $ui->createListItem
    (
      $this->model->search($access, $params),
      $access,
      $params
    );

    // keine fehler? bestens
    // exceptions werden fallen gelassen
    return null;

  }//end public function displaySearch */

 /**
  * de:
  * Einfache insert methode.
  * Es wird ein neuer eintrag für das listenelement erstellt und über
  * das ajax interface in die liste gepusht
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayInsert($params)
  {

    $ui = $this->loadUi('WebfrapAnnouncement_Table');
    $ui->setModel($this->model);

    $ui->listEntry($params->access, $params, true);

    // kein fehler? alles bestens
    return null;

  }//end public function displayInsert */

 /**
  * de:
  * Einfache insert methode.
  * Es wird ein neuer eintrag für das listenelement erstellt und über
  * das ajax interface in die liste gepusht
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayUpdate($params)
  {

    $ui = $this->loadUi('WebfrapAnnouncement_Table');
    $ui->setModel($this->model);

    $ui->listEntry($params->access, $params, false);

    // kein fehler? alles bestens
    return null;

  }//end public function displayUpdate */

 /**
  * de: entfernen eines eintrags aus dem listenelement
  *
  * @param int $objid die rowid des gelöschten listenelements
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayDelete($objid, $params)
  {

    // if we got a target id we remove the element from the client
    if ($params->targetId) {
      $ui = $this->loadUi('WebfrapAnnouncement_Table');

      $ui->setModel($this->model);
      $ui->removeListEntry($objid, $params->targetId);
    }

    // kein fehler? alles bestens
    return null;

  }//end public function displayDelete */

}//end class WebfrapAnnouncement_Table_Ajax_View

