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
 * @subpackage Modprofiles
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyAnnouncement_Widget_Table_Ui extends MvcUi
{
/*//////////////////////////////////////////////////////////////////////////////
// Listing Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * just deliver changed table rows per ajax interface
  *
  * @param LibAclContainer $access
  * @param TFlag $params named parameters
  * {
  *   // Parameter die ausgewertet werden, oder weitergeleitet
  *
  *   @param: int start, Offset für die Listenelemente. Wird absolut übergeben und nicht
  *     mit multiplikator (50 anstelle von <strike>5 mal listengröße</strike>)
  *
  *   @param: int qsize, Die Anzahl der zu Ladenten Einträge. Momentan wird alles > 500 auf 500 gekappt
  *     alles kleiner 0 wird auf den standardwert von aktuell 25 gesetzt
  *
  *   @param: array(string fieldname => string [asc|desc]) order, Die Daten für die Sortierung
  *
  *   @param: char begin, Mit Begin wird ein Buchstabe übergeben, der verwendet wird die Listeelemente
  *     nach dem Anfangsbuchstaben zu filtern. Kann im Prinzip jedes beliebige Zeichen, also auch eine Zahl sein
  *
  *   @param: ckey target_id, Die HTML Id, des Zielelements. Diese ID is wichtig, wenn das HTML Element
  *     in dem das Suchergebniss platziert werden soll, eine andere ID als die in der Methode hinterlegt
  *     Standard HTML ID hat
  *
  *   @param: array listingActions, Ein Array welcher die Namen der Aktionen enthält
  *     die angezeigt werden sollen. Diese Aktionen werden direkt gesetzten.
  *     Vorsicht, ACLs mit dem Level > Access haben dann keine Wirkung mehr
  *
  *   @param: ckey searchFormId, Die HTML ID des Suchformulars, welches mit dem Listenelement
  *     verbunden ist.
  *     Auf diesem Formular TAG werden im Client alle für das Element relevanten Metadaten, z.B Daten zum Paging
  *     Sortierung etc. per jQuery.data() abgelegt
  *
  *   @param: boolean ajax, Ist true wenn die Anfrage über ein AJAX Interface gekommen ist, welches
  *     das Element als TemplateArea form und nicht als gerendertes HTML haben möchte
  *
  *   @param: boolean append, Append macht nur in Verbindung mit AJAX Request einen Sinn.
  *     Durch das Appendflag wird das HTML Element angewiesen den Inhalt des Listenelements im Browser
  *     um die gefundenen Einträge zu erweitern. Standard wäre alles im Body zu ersetzen
  *
  *
  *   @param: LibAclContainer access, Der Haupt-ACL-Container
  * }
  * @param boolean [default=false] $insert
  * @return void
  */
  public function listEntry($access, $params, $insert = false  )
  {

    $view = $this->getView();

    $table = new MyAnnouncement_Widget_Table_Element(null, $view);

    $table->addData($this->model->getEntryData($params));

    // den access container dem listenelement übergeben
    $table->setAccess($access);
    $table->setAccessPath($params, $params->aclKey, $params->aclNode);

    // if a table id is given use it for the table
    if ($params->targetId  )
      $table->id = $params->targetId;

    if (!is_null($params->listingActions)) {
      $table->addActions($params->listingActions);
    } else {
      $actions   = array();
      $actions[] = 'archive';

      $table->addActions($actions);
    }

    $table->insertMode = $insert;

    if (!$params->noParse)
      $view->setAreaContent('tabRowMyAnnouncement', $table->buildAjax());

    return $table;

  }// end public function listEntry */

  /**
   * de:
   * Zusammenstellen aller benötigten InputElement für ein Suchformular auf
   * die WbfsysAnnouncement listing maske
   *
   * @param WbfsysAnnouncement_Widget_Table_Model $model
   * @param TFlag $params
   * @return void
   */
  public function searchForm( $model, $params = null)
  {

    // laden der benötigten resourcen
    $view = $this->getView();

    $entityMyAnnouncement  = $model->getEntityMyAnnouncement();
    $fieldsMyAnnouncement  = $entityMyAnnouncement->getSearchCols();

    $formMyAnnouncement    = $view->newForm('WbfsysAnnouncement');
    $formMyAnnouncement->setNamespace('WbfsysAnnouncement');
    $formMyAnnouncement->setPrefix('WbfsysAnnouncement');
    $formMyAnnouncement->setKeyName('wbfsys_announcement');
    $formMyAnnouncement->createSearchForm
    (
      $entityMyAnnouncement,
      $fieldsMyAnnouncement
    );

  }//end public function searchForm */

}// end class WbfsysAnnouncement_Widget_Table_Ui

