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
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAnnouncement_Crud_Edit_Area_View extends LibTemplateAreaView
{

 /**
  * Methode zum befüllen des WbfsysAnnouncement Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayForm($objid, $params)
  {

    // laden der mvc/utils adapter Objekte
    $request = $this->getRequest();

    $this->position = '#wgt-box-webfrap_announcement-form';

    // set the form template
    $this->setTemplate('webfrap/announcement/area/crud/form_edit');

    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'area';
    $params->viewId    = $this->getId();

    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=Webfrap.Announcement.update';
    $params->formId     = 'wgt-form-webfrap_announcement';

    // Setzen der letzten metadaten
    $this->addVar('params', $params);
    $this->addVar('context', 'edit');

    // Das Create Form Objekt erstellen und mit allen nötigen Daten befüllen
    $form = $this->newForm('WebfrapAnnouncement_Crud_Edit');
    $entity = $this->model->getEntity($objid);
    $form->setEntity($entity);

    // Form Action und ID setzen
    $form->setFormTarget($params->formAction, $params->formId, $params);

    // Form rendern
    $form->renderForm($params);

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayForm */

}//end class WebfrapAnnouncement_Crud_Edit_Area_View

