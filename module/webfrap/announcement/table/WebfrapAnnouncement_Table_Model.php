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
class WebfrapAnnouncement_Table_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// getter for the entities
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * Erfragen der Haupt Entity unabhängig vom Maskenname
  * @param int $objid
  * @return WbfsysAnnouncement_Entity
  */
  public function getEntity($objid = null)
  {
    return $this->getEntityWbfsysAnnouncement($objid);

  }//end public function getEntity */

  /**
  * Setzen der Haupt Entity, unabhängig vom Maskenname
  * @param WbfsysAnnouncement_Entity $entity
  */
  public function setEntity($entity)
  {

    $this->setEntityWbfsysAnnouncement($entity);

  }//end public function setEntity */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysAnnouncement_Entity
  */
  public function getEntityWbfsysAnnouncement($objid = null)
  {

    $response = $this->getResponse();

    if (!$entityWebfrapAnnouncement = $this->getRegisterd('main_entity'))
      $entityWebfrapAnnouncement = $this->getRegisterd('entityWebfrapAnnouncement');

    //entity wbfsys_announcement
    if (!$entityWebfrapAnnouncement) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityWebfrapAnnouncement = $orm->get('WbfsysAnnouncement', $objid)) {
          $response->addError
          (
            $response->i18n->l
            (
              'There is no wbfsysannouncement with this id '.$objid,
              'wbfsys.announcement.message'
            )
          );

          return null;
        }

        $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
        $this->register('main_entity', $entityWebfrapAnnouncement);

      } else {

        $entityWebfrapAnnouncement   = new WbfsysAnnouncement_Entity() ;
        $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
        $this->register('main_entity', $entityWebfrapAnnouncement);
      }

    } elseif ($objid && $objid != $entityWebfrapAnnouncement->getId()) {
      $orm = $this->getOrm();

      if (!$entityWebfrapAnnouncement = $orm->get('WbfsysAnnouncement', $objid)) {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no wbfsysannouncement with this id '.$objid,
            'wbfsys.announcement.message'
          )
        );

        return null;
      }

      $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
      $this->register('main_entity', $entityWebfrapAnnouncement);
    }

    return $entityWebfrapAnnouncement;

  }//end public function getEntityWbfsysAnnouncement */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysAnnouncement_Entity $entity
  */
  public function setEntityWbfsysAnnouncement($entity)
  {

    $this->register('entityWebfrapAnnouncement', $entity);
    $this->register('main_entity', $entity);

  }//end public function setEntityWbfsysAnnouncement */

  /**
   * just fetch the post data without any required validation
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryData($params)
  {

    $orm   = $this->getOrm();
    $user  = $this->getUser();

    $data  = array();

    $data['wbfsys_announcement']  = $this->getEntityWbfsysAnnouncement();

    $tabData = array();

    foreach ($data as $tabName => $ent) {
      // prüfen ob etwas gefunden wurde
      if (!$ent) {
        Debug::console("Missing Entity for Reference: ".$tabName);
        continue;
      }

      $tabData = array_merge($tabData , $ent->getAllData($tabName));

    }

    // if we have a value, try to load the display field (codeTableRefFields 4)
    if ($data['wbfsys_announcement']->id_type) {
      $valWbfsysAnnouncementType = $orm->getField
      (
        'WbfsysAnnouncementType',
        'rowid = '.$data['wbfsys_announcement']->id_type,
        'name'
      );
      $tabData['wbfsys_announcement_type_name'] = $valWbfsysAnnouncementType;
    } else {
      // else just set an empty string, fastest way ;-)
      $tabData['wbfsys_announcement_type_name'] = '';
    }

    if ($data['wbfsys_announcement']->id_channel) {
      $valWbfsysAnnouncementChannel = $orm->getField
      (
        'WbfsysAnnouncementChannel',
        'rowid = '.$data['wbfsys_announcement']->id_channel,
        'name'
      );
      $tabData['wbfsys_announcement_channel_name'] = $valWbfsysAnnouncementChannel;
    } else {
      // else just set an empty string, fastest way ;-)
      $tabData['wbfsys_announcement_channel_name'] = '';
    }

    $userData = $user->getData();

    $tabData['wbfsys_role_user_name']  = $userData['name'];
    $tabData['core_person_lastname']   = $userData['lastname'];
    $tabData['core_person_firstname']  = $userData['firstname'];

    return $tabData;

  }// end public function getEntryData */

/*//////////////////////////////////////////////////////////////////////////////
// context: table
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Suchfunktion für das Listen Element
   *
   * Wenn suchparameter übergeben werden, werden diese automatisch in die
   * Query eingebaut, ansonsten wird eine plain query ausgeführt
   *
   * Berechtigungen werden bei bedarf berücksichtigt
   *
   * Am Ende wird ein geladenes Query Objekt zurückgegeben, über welches
   * (wie über einen Array) itteriert werden kann
   *
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   * @param array $condition Übergabe möglicher such Parameter
   *
   * @return LibSqlQuery
   *
   * @throws LibDb_Exception
   *    wenn die Query fehlschlägt
   *    Datenbank Verbindungsfehler... etc (siehe meldung)
   */
  public function search($access, $params, $condition = array())
  {

    // laden der mvc/utils adapter Objekte
    $view         = $this->getView();
    $httpRequest = $this->getRequest();
    $response    = $this->getResponse();

    $db          = $this->getDb();
    $orm         = $db->getOrm();
    $user        = $this->getUser();

    // freitext suche
    if ($free = $httpRequest->param('free_search' , Validator::TEXT))
      $condition['free'] = $db->escape(trim($free));

    if (!$fieldsWbfsysAnnouncement = $this->getRegisterd('search_fields_wbfsys_announcement')) {
       $fieldsWbfsysAnnouncement   = $orm->getSearchCols('WbfsysAnnouncement');
    }

    if ($refs = $httpRequest->dataSearchIds('search_webfrap_announcement')) {
      $fieldsWbfsysAnnouncement = array_unique(array_merge
      (
        $fieldsWbfsysAnnouncement,
        $refs
      ));
    }

    $filterWbfsysAnnouncement     = $httpRequest->checkSearchInput
    (
      $orm->getValidationData('WbfsysAnnouncement', $fieldsWbfsysAnnouncement),
      $orm->getErrorMessages('WbfsysAnnouncement'  ),
      'search_webfrap_announcement'
    );
    $condition['webfrap_announcement'] = $filterWbfsysAnnouncement->getData();

    if ($mRoleCreate = $httpRequest->data('search_webfrap_announcement', Validator::EID, 'm_role_create'   ))
      $condition['webfrap_announcement']['m_role_create'] = $mRoleCreate;

    if ($mRoleChange = $httpRequest->data('search_webfrap_announcement', Validator::EID, 'm_role_change'   ))
      $condition['webfrap_announcement']['m_role_change'] = $mRoleChange;

    if ($mTimeCreatedBefore = $httpRequest->data('search_webfrap_announcement', Validator::DATE, 'm_time_created_before'   ))
      $condition['webfrap_announcement']['m_time_created_before'] = $mTimeCreatedBefore;

    if ($mTimeCreatedAfter = $httpRequest->data('search_webfrap_announcement', Validator::DATE, 'm_time_created_after'   ))
      $condition['webfrap_announcement']['m_time_created_after'] = $mTimeCreatedAfter;

    if ($mTimeChangedBefore = $httpRequest->data('search_webfrap_announcement', Validator::DATE, 'm_time_changed_before'   ))
      $condition['webfrap_announcement']['m_time_changed_before'] = $mTimeChangedBefore;

    if ($mTimeChangedAfter = $httpRequest->data('search_webfrap_announcement}', Validator::DATE, 'm_time_changed_after'   ))
      $condition['webfrap_announcement']['m_time_changed_after'] = $mTimeChangedAfter;

    if ($mRowid = $httpRequest->data('search_webfrap_announcement', Validator::EID, 'm_rowid'   ))
      $condition['webfrap_announcement']['m_rowid'] = $mRowid;

    if ($mUuid = $httpRequest->data('search_webfrap_announcement', Validator::TEXT, 'm_uuid'    ))
      $condition['webfrap_announcement']['m_uuid'] = $mUuid;

    $query = $db->newQuery('WebfrapAnnouncement_Table');

    if ($params->dynFilters) {
      foreach ($params->dynFilters as $dynFilter) {
        try {
          $filter = $db->newFilter
          (
            'WbfsysAnnouncement_Table_'.SParserString::subToCamelCase($dynFilter)
          );

          if ($filter)
            $query->inject($filter, $params);
        } catch (LibDb_Exception $e) {
          $response->addError("Requested nonexisting filter ".$dynFilter);
        }

      }
    }

    // da die rechte scheins auf die komplette datenquelle vergeben wurden
    // kann hier auch einfach mit der ganzen quelle geladen werden
    // es wird davon ausgegangen, dass ein standard level definiert wurde
    // wenn kein standard level definiert wurde, werden die daten nur
    // aufgelistet ohne weitere interaktions möglichkeit
    $query->fetch
    (
      $condition,
      $params
    );

    return $query;

  }//end public function search */

  /**
   * just fetch the post data without any required validation
   *
   * @param int $id the id for the entity
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchSearchParams($params, $id = null  )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();
    $view        = $this->getView();

    $response    = $this->getResponse();

    try {

      //management  wbfsys_announcement source wbfsys_announcement
      $entityWebfrapAnnouncement = $orm->newEntity('WbfsysAnnouncement');

      if (!$params->fieldsWbfsysAnnouncement) {
        $params->fieldsWbfsysAnnouncement  = $entityWebfrapAnnouncement->getCols
        (
          $params->categories
        );
      }

      // if the validation fails report
      $httpRequest->validateSearch
      (
        $entityWebfrapAnnouncement,
        'webfrap_announcement',
        $params->fieldsWbfsysAnnouncement
      );

      // register the entity in the mode registry
      $this->register
      (
        'entityWebfrapAnnouncement',
        $entityWebfrapAnnouncement
       );

      return !$response->hasErrors();
    } catch (InvalidInput_Exception $e) {
      return false;
    }

  }//end public function fetchSearchParams */

  /**
   * fill the elements in a search form
   *
   * @param LibTemplateWindow $view
   * @return boolean
   */
  public function searchForm($view)
  {

    $searchFields = $this->getSearchFields();

    //entity wbfsys_announcement
    if (!$entityWebfrapAnnouncement = $this->getRegisterd('entityWebfrapAnnouncement')) {
      $entityWebfrapAnnouncement   = new WbfsysAnnouncement_Entity() ;
    }

    $formWbfsysAnnouncement    = $view->newForm('WebfrapAnnouncement');
    $formWbfsysAnnouncement->setNamespace('WebfrapAnnouncement');
    $formWbfsysAnnouncement->setPrefix('WebfrapAnnouncement');
    $formWbfsysAnnouncement->createSearchForm
    (
      $entityWebfrapAnnouncement,
      (isset($searchFields['webfrap_announcement'])?$searchFields['webfrap_announcement']:array())
    );

  }//end public function searchForm */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getSearchFields()
  {
    return array
    (
      'wbfsys_announcement' => array
      (
        'title',
        'id_type',
      ),

    );

  }//end public function getSearchFields */

}//end class WbfsysAnnouncement_Table_Model

