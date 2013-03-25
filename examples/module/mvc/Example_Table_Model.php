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
 * @subpackage ModCore
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class Example_Table_Model extends Model
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
  * @return CorePerson_Entity
  */
  public function getEntity($objid = null)
  {
    return $this->getEntityCorePerson($objid);

  }//end public function getEntity */

  /**
  * Setzen der Haupt Entity, unabhängig vom Maskenname
  * @param CorePerson_Entity $entity
  */
  public function setEntity($entity)
  {

    $this->setEntityCorePerson($entity);

  }//end public function setEntity */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return CorePerson_Entity
  */
  public function getEntityCorePerson($objid = null)
  {

    $response = $this->getResponse();

    if (!$entityCorePerson = $this->getRegisterd('main_entity'))
      $entityCorePerson = $this->getRegisterd('entityCorePerson');

    //entity core_person
    if (!$entityCorePerson) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityCorePerson = $orm->get('CorePerson', $objid)) {
          $response->addError
          (
            $response->i18n->l
            (
              'There is no coreperson with this id '.$objid,
              'core.person.message'
            )
          );

          return null;
        }

        $this->register('entityCorePerson', $entityCorePerson);
        $this->register('main_entity', $entityCorePerson);

      } else {
        $entityCorePerson   = new CorePerson_Entity() ;
        $this->register('entityCorePerson', $entityCorePerson);
        $this->register('main_entity', $entityCorePerson);
      }

    } elseif ($objid && $objid != $entityCorePerson->getId()) {
      $orm = $this->getOrm();

      if (!$entityCorePerson = $orm->get('CorePerson', $objid)) {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no coreperson with this id '.$objid,
            'core.person.message'
          )
        );

        return null;
      }

      $this->register('entityCorePerson', $entityCorePerson);
      $this->register('main_entity', $entityCorePerson);
    }

    return $entityCorePerson;

  }//end public function getEntityCorePerson */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param CorePerson_Entity $entity
  */
  public function setEntityCorePerson($entity)
  {

    $this->register('entityCorePerson', $entity);
    $this->register('main_entity', $entity);

  }//end public function setEntityCorePerson */

  /**
  * returns the activ entity with data, or creates a empty one
  * and returns it instead
  *
  * @return Address_Entity
  */
  public function getEntityAddress($mainEntity = null)
  {

    $response = $this->getResponse();

    $objid = null;

    if (!is_null($mainEntity))
      $objid = $mainEntity->id_address;

    $entityAddress = $this->getRegisterd('entityAddress');

    //entity core_person
    if (!$entityAddress) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityAddress = $orm->get('CoreAddress', $objid)) {
          $response->addWarning
          (
            $response->i18n->l
            (
              'Missing the reference dataset coreaddress with the id '.$objid,
              'core.person.message'
            )
          );

          $entityAddress = new CoreAddress_Entity;

          $entityAddress->setId($objid, true);
          $orm->insert($entityAddress, array(), false);

        }
        $this->register('entityAddress', $entityAddress);
      } else {
        $entityAddress   = new CoreAddress_Entity() ;
        $this->register('entityAddress', $entityAddress);
      }

    } elseif ($objid  && $objid != $entityAddress->getId()) {
      $orm = $this->getOrm();

      if (!$entityAddress = $orm->get('CoreAddress', $objid)) {
        $this->getResponse()->addError
        (
          $response->i18n->l
          (
            'Missing the reference dataset coreaddress with the id '.$objid,
            'core.person.message'
          )
        );

        $entityAddress = new CoreAddress_Entity;

        $entityAddress->setId($objid, true);
        $orm->insert($entityAddress);
      }

      $this->register('entityAddress', $entityAddress);
    }

    return $entityAddress;

  }//end public function getEntityAddress */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param EntityAddress $entity
  */
  public function setEntityAddress($entity)
  {

    $this->register('entityAddress', $entity);

  }//end public function setEntityAddress */

  /**
   * just fetch the post data without any required validation
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryData($params)
  {

    $orm   = $this->getOrm();
    $data  = array();

    $data['core_person']  = $this->getEntityCorePerson();
    $data['address'] = $this->getEntityAddress($data['core_person']);

    $tabData = array();

    foreach ($data as $tabName => $ent) {
      // prüfen ob etwas gefunden wurde
      if (!$ent) {
        Debug::console("Missing Entity for Reference: ".$tabName);
        continue;
      }

      $tabData = array_merge($tabData , $ent->getAllData($tabName));

    }

    return $tabData;

  }// end public function getEntryData */

/*//////////////////////////////////////////////////////////////////////////////
// context: table
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Suchfunktion für das Listen Element
   *
   * Wenn Suchparameter übergeben werden, werden diese automatisch in die
   * Query eingebaut, ansonsten wird eine plain query ausgeführt
   *
   * Berechtigungen werden bei Bedarf berücksichtigt
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

    // laden der benötigten resourcen
    $view         = $this->getView();
    $httpRequest = $this->getRequest();
    $response    = $this->getResponse();

    $db          = $this->getDb();
    $orm         = $db->getOrm();
    $user        = $this->getUser();

    $extendedConditions = array();

    // freitext suche
    if ($free = $httpRequest->param('free_search' , Validator::TEXT))
      $condition['free'] = $db->addSlashes(trim($free));

      if (!$fieldsCorePerson = $this->getRegisterd('search_fields_core_person')) {
         $fieldsCorePerson   = $orm->getSearchCols('CorePerson');
      }

      if ($refs = $httpRequest->dataSearchIds('search_core_person')) {
        $fieldsCorePerson = array_unique(array_merge
        (
          $fieldsCorePerson,
          $refs
        ));
      }

      $filterCorePerson     = $httpRequest->checkSearchInput
      (
        $orm->getValidationData('CorePerson', $fieldsCorePerson),
        $orm->getErrorMessages('CorePerson'  ),
        'search_core_person'
      );
      $condition['core_person'] = $filterCorePerson->getData();

      if ($mRoleCreate = $httpRequest->param('search_core_person', Validator::EID, 'm_role_create'   ))
        $condition['core_person']['m_role_create'] = $mRoleCreate;

      if ($mRoleChange = $httpRequest->param('search_core_person', Validator::EID, 'm_role_change'   ))
        $condition['core_person']['m_role_change'] = $mRoleChange;

      if ($mTimeCreatedBefore = $httpRequest->param('search_core_person', Validator::DATE, 'm_time_created_before'   ))
        $condition['core_person']['m_time_created_before'] = $mTimeCreatedBefore;

      if ($mTimeCreatedAfter = $httpRequest->param('search_core_person', Validator::DATE, 'm_time_created_after'   ))
        $condition['core_person']['m_time_created_after'] = $mTimeCreatedAfter;

      if ($mTimeChangedBefore = $httpRequest->param('search_core_person', Validator::DATE, 'm_time_changed_before'   ))
        $condition['core_person']['m_time_changed_before'] = $mTimeChangedBefore;

      if ($mTimeChangedAfter = $httpRequest->param('search_core_person}', Validator::DATE, 'm_time_changed_after'   ))
        $condition['core_person']['m_time_changed_after'] = $mTimeChangedAfter;

      if ($mRowid = $httpRequest->param('search_core_person', Validator::EID, 'm_rowid'   ))
        $condition['core_person']['m_rowid'] = $mRowid;

      if ($mUuid = $httpRequest->param('search_core_person', Validator::TEXT, 'm_uuid'    ))
        $condition['core_person']['m_uuid'] = $mUuid;

      if
      (
        !$fieldsCoreAddress
          = $this->getRegisterd('search_fields_core_address')
      )
      {
        $fieldsCoreAddress    = $orm->getSearchCols('CoreAddress');
      }

      $filterCoreAddress      = $httpRequest->checkSearchInput
      (
        $orm->getValidationData('CoreAddress', $fieldsCoreAddress),
        $orm->getErrorMessages ('CoreAddress'),
        'search_core_address'
      );
      $condition['core_address'] = $filterCoreAddress->getData();

      if ($mRoleCreate = $httpRequest->param('search_core_address', Validator::EID, 'm_role_create'   ))
        $condition['core_address']['m_role_create'] = $mRoleCreate;

      if ($mRoleChange = $httpRequest->param('search_core_address', Validator::EID, 'm_role_change'   ))
        $condition['core_address']['m_role_change'] = $mRoleChange;

      if ($mTimeCreatedBefore = $httpRequest->param('search_core_address', Validator::DATE, 'm_time_created_before'   ))
        $condition['core_address']['m_time_created_before'] = $mTimeCreatedBefore;

      if ($mTimeCreatedAfter = $httpRequest->param('search_core_address', Validator::DATE , 'm_time_created_after'))
        $condition['core_address']['m_time_created_after'] = $mTimeCreatedAfter;

      if ($mTimeChangedBefore = $httpRequest->param('search_core_address', Validator::DATE, 'm_time_changed_before'  ))
        $condition['core_address']['m_time_changed_before'] = $mTimeChangedBefore;

      if ($mTimeChangedAfter = $httpRequest->param('search_core_address', Validator::DATE, 'm_time_changed_after'  ))
        $condition['core_address']['m_time_changed_after'] = $mTimeChangedAfter;

      if ($mRowid = $httpRequest->param('search_core_address', Validator::EID, 'm_rowid'))
        $condition['core_address']['m_rowid'] = $mRowid;

      if ($mUuid = $httpRequest->param('search_core_address', Validator::TEXT, 'm_uuid'))
        $condition['core_address']['m_uuid'] = $mUuid;

    $query = $db->newQuery('CorePerson_Table');
    $query->extendedConditions = $extendedConditions;

    if ($params->dynFilters) {
      foreach ($params->dynFilters as $dynFilter) {
        try {
          $filter = $db->newFilter
          (
            'CorePerson_Table_'.SParserString::subToCamelCase($dynFilter)
          );

          if ($filter)
            $query->inject($filter, $params);
        } catch (LibDb_Exception $e) {
          $response->addError("Requested nonexisting filter ".$dynFilter);
        }

      }
    }

    // per exclude können regeln übergeben werden um bestimmte datensätze
    // auszublenden
    // wird häufig verwendet um bereits zugewiesenen datensätze aus zu blenden
    if ($params->exclude) {

      $tmp = explode('-', $params->exclude);

      $conName   = $tmp[0];
      $srcId     = $tmp[1];
      $targetId  = $tmp[2];

      $excludeCond = ' core_person.rowid NOT IN '
      .'(select '.$targetId .' from '.$conName.' where '.$srcId.' = '.$params->objid.' and not '.$srcId.' is null) ';

      $query->setCondition($excludeCond);

    }

    // wenn der user nur teilberechtigungen hat, müssen die ACLs direkt beim
    // lesen der Daten berücksichtigt werden
    if
    (
      $access->isPartAssign || $access->hasPartAssign
    )
    {

      $validKeys  = $access->fetchListIds
      (
        $user->getProfileName(),
        $query,
        'table',
        $condition,
        $params
      );
            $query->fetchInAcls
      (
        $validKeys,
        $params
      );

    } else {

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

    }

    return $query;

  }//end public function search */

  /**
   * fill the elements in a search form
   *
   * @param LibTemplateWindow $view
   * @return boolean
   */
  public function searchForm($view)
  {

    $searchFields = $this->getSearchFields();

    //entity core_person
    if (!$entityCorePerson = $this->getRegisterd('entityCorePerson')) {
      $entityCorePerson   = new CorePerson_Entity() ;
    }

    $formCorePerson    = $view->newForm('CorePerson');
    $formCorePerson->setNamespace('CorePerson');
    $formCorePerson->setPrefix('CorePerson');
    $formCorePerson->createSearchForm
    (
      $entityCorePerson,
      (isset($searchFields['core_person'])?$searchFields['core_person']:array())
    );

    // management core_address source core_address
    if (!$entityCoreAddress = $this->getRegisterd('entityCoreAddress')) {
      $entityCoreAddress   =  new CoreAddress_Entity() ;
    }

    $formCoreAddress    = $view->newForm('CoreAddress');
    $formCoreAddress->setNamespace('CorePerson');
    $formCoreAddress->setPrefix('CoreAddress');
    $formCoreAddress->createSearchForm
    (
      $entityCoreAddress,
      (isset($searchFields['core_address'])?$searchFields['core_address']:array())
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
      'core_person' => array
      (
        'firstname',
        'lastname',
        'email',
      ),

    );

  }//end public function getSearchFields */

}//end class CorePerson_Table_Model

