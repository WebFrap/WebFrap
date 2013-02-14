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
class MyMessage_Table_Model extends Model
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
  * @return WbfsysMessage_Entity
  */
  public function getEntity( $objid = null )
  {

    return $this->getEntityMyMessage( $objid );

  }//end public function getEntity */
    
  /**
  * Setzen der Haupt Entity, unabhängig vom Maskenname
  * @param WbfsysMessage_Entity $entity
  */
  public function setEntity( $entity )
  {

    $this->setEntityMyMessage( $entity );

  }//end public function setEntity */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysMessage_Entity
  */
  public function getEntityMyMessage( $objid = null )
  {

    $response = $this->getResponse();
  
    if (!$entityMyMessage = $this->getRegisterd( 'main_entity' ) )
      $entityMyMessage = $this->getRegisterd( 'entityMyMessage' );

    //entity wbfsys_message
    if (!$entityMyMessage )
    {

      if (!is_null( $objid ) )
      {
        $orm = $this->getOrm();

        if (!$entityMyMessage = $orm->get( 'WbfsysMessage', $objid) )
        {
          $response->addError
          (
            $response->i18n->l
            (
              'There is no wbfsysmessage with this id '.$objid,
              'wbfsys.message.message'
            )
          );
          return null;
        }

        $this->register( 'entityMyMessage', $entityMyMessage );
        $this->register( 'main_entity', $entityMyMessage);

      }
      else
      {
        $entityMyMessage   = new WbfsysMessage_Entity() ;
        $this->register( 'entityMyMessage', $entityMyMessage );
        $this->register( 'main_entity', $entityMyMessage);
      }

    }
    elseif( $objid && $objid != $entityMyMessage->getId() )
    {
      $orm = $this->getOrm();

      if (!$entityMyMessage = $orm->get( 'WbfsysMessage', $objid) )
      {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no wbfsysmessage with this id '.$objid,
            'wbfsys.message.message'
          )
        );
        return null;
      }

      $this->register( 'entityMyMessage', $entityMyMessage);
      $this->register( 'main_entity', $entityMyMessage);
    }

    return $entityMyMessage;

  }//end public function getEntityMyMessage */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysMessage_Entity $entity
  */
  public function setEntityMyMessage( $entity )
  {

    $this->register( 'entityMyMessage', $entity );
    $this->register( 'main_entity', $entity );

  }//end public function setEntityMyMessage */

  /**
   * just fetch the post data without any required validation
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryData( $params )
  {

    $orm   = $this->getOrm();

    $data  = array();

    $data['my_message']  = $this->getEntityMyMessage();


    $tabData = array();

    foreach( $data as $tabName => $ent )
    {
      // prüfen ob etwas gefunden wurde
      if (!$ent )
      {
        Debug::console( "Missing Entity for Reference: ".$tabName );
        continue;
      }

      $tabData = array_merge( $tabData , $ent->getAllData( $tabName ) );

    }

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
   * ( wie über einen Array ) itteriert werden kann
   *
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   * @param array $condition Übergabe möglicher such Parameter
   *
   * @return LibSqlQuery
   *
   * @throws LibDb_Exception 
   *    wenn die Query fehlschlägt
   *    Datenbank Verbindungsfehler... etc ( siehe meldung )
   */
  public function search( $access, $params, $condition = array() )
  {

    // laden der benötigten resourcen
    $view         = $this->getView();
    $httpRequest = $this->getRequest();
    $response    = $this->getResponse();
    
    $db          = $this->getDb();
    $orm         = $db->getOrm();
    $user        = $this->getUser();



    // freitext suche
    if( $free = $httpRequest->param( 'free_search' , Validator::TEXT ) )
      $condition['free'] = $db->addSlashes( trim( $free ) );

      if (!$fieldsWbfsysMessage = $this->getRegisterd( 'search_fields_wbfsys_message' ) )
      {
         $fieldsWbfsysMessage   = $orm->getSearchCols( 'WbfsysMessage' );
      }

      if( $refs = $httpRequest->dataSearchIds( 'search_wbfsys_message' ) )
      {
        $fieldsWbfsysMessage = array_unique( array_merge
        (
          $fieldsWbfsysMessage,
          $refs
        ));
      }

      $filterWbfsysMessage     = $httpRequest->checkSearchInput
      (
        $orm->getValidationData( 'WbfsysMessage', $fieldsWbfsysMessage ),
        $orm->getErrorMessages( 'WbfsysMessage'  ),
        'search_wbfsys_message'
      );
      $condition['wbfsys_message'] = $filterWbfsysMessage->getData();

      if( $mRoleCreate = $httpRequest->data( 'search_wbfsys_message', Validator::EID, 'm_role_create'   ) )
        $condition['wbfsys_message']['m_role_create'] = $mRoleCreate;

      if( $mRoleChange = $httpRequest->data( 'search_wbfsys_message', Validator::EID, 'm_role_change'   ) )
        $condition['wbfsys_message']['m_role_change'] = $mRoleChange;

      if( $mTimeCreatedBefore = $httpRequest->data( 'search_wbfsys_message', Validator::DATE, 'm_time_created_before'   ) )
        $condition['wbfsys_message']['m_time_created_before'] = $mTimeCreatedBefore;

      if( $mTimeCreatedAfter = $httpRequest->data( 'search_wbfsys_message', Validator::DATE, 'm_time_created_after'   ) )
        $condition['wbfsys_message']['m_time_created_after'] = $mTimeCreatedAfter;

      if( $mTimeChangedBefore = $httpRequest->data( 'search_wbfsys_message', Validator::DATE, 'm_time_changed_before'   ) )
        $condition['wbfsys_message']['m_time_changed_before'] = $mTimeChangedBefore;

      if( $mTimeChangedAfter = $httpRequest->data( 'search_wbfsys_message}', Validator::DATE, 'm_time_changed_after'   ) )
        $condition['wbfsys_message']['m_time_changed_after'] = $mTimeChangedAfter;

      if( $mRowid = $httpRequest->data( 'search_wbfsys_message', Validator::EID, 'm_rowid'   ) )
        $condition['wbfsys_message']['m_rowid'] = $mRowid;

      if( $mUuid = $httpRequest->data( 'search_wbfsys_message', Validator::TEXT, 'm_uuid'    ) )
        $condition['wbfsys_message']['m_uuid'] = $mUuid;

    $query = $db->newQuery( 'WbfsysMessage_Table' );

    if( $params->dynFilters )
    {
      foreach( $params->dynFilters as $dynFilter  )
      {
        try 
        {
          $filter = $db->newFilter
          ( 
            'WbfsysMessage_Table_'.SParserString::subToCamelCase( $dynFilter ) 
          );
          
          if( $filter )
            $query->inject( $filter, $params );
        }
        catch( LibDb_Exception $e )
        {
          $response->addError( "Requested nonexisting filter ".$dynFilter ); 
        }

      }
    }
      
    // per exclude können regeln übergeben werden um bestimmte datensätze
    // auszublenden
    // wird häufig verwendet um bereits zugewiesenen datensätze aus zu blenden    
    if( $params->exclude )
    {

      $tmp = explode( '-', $params->exclude );

      $conName   = $tmp[0];
      $srcId     = $tmp[1];
      $targetId  = $tmp[2];

      $excludeCond = ' wbfsys_message.rowid NOT IN '
      .'( select '.$targetId .' from '.$conName.' where '.$srcId.' = '.$params->objid.' ) ';

      $query->setCondition( $excludeCond );

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

    }
    else
    {

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
   * just fetch the post data without any required validation
   *
   * @param int $id the id for the entity
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchSearchParams( $params, $id = null  )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();
    $view        = $this->getView();
    
    $response    = $this->getResponse();

    try
    {

      //management  wbfsys_message source wbfsys_message
      $entityMyMessage = $orm->newEntity( 'WbfsysMessage' );

      if (!$params->fieldsWbfsysMessage )
      {
        $params->fieldsWbfsysMessage  = $entityMyMessage->getCols
        (
          $params->categories
        );
      }

      // if the validation fails report
      $httpRequest->validateSearch
      (
        $entityMyMessage,
        'wbfsys_message',
        $params->fieldsWbfsysMessage
      );

      // register the entity in the mode registry
      $this->register
      ( 
        'entityMyMessage', 
        $entityMyMessage 
       );

      return !$response->hasErrors();
    }
    catch( InvalidInput_Exception $e )
    {
      return false;
    }

  }//end public function fetchSearchParams */

  /**
   * fill the elements in a search form
   *
   * @param LibTemplateWindow $view
   * @return boolean
   */
  public function searchForm( $view )
  {

    $searchFields = $this->getSearchFields();
  

    //entity wbfsys_message
    if(!$entityMyMessage = $this->getRegisterd( 'entityMyMessage' ) )
    {
      $entityMyMessage   = new WbfsysMessage_Entity() ;
    }

    $formWbfsysMessage    = $view->newForm( 'WbfsysMessage' );
    $formWbfsysMessage->setNamespace( 'WbfsysMessage' );
    $formWbfsysMessage->setPrefix( 'WbfsysMessage' );
    $formWbfsysMessage->createSearchForm
    (
      $entityMyMessage,
      ( isset($searchFields['wbfsys_message'])?$searchFields['wbfsys_message']:array() )
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
      'wbfsys_message' => array
      (
        'title',
      ),

    );

  }//end public function getSearchFields */
  
  
  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function archive( $params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try
    {
      if (!$entityMyMessage = $this->getRegisterd( 'entityMyMessage' ) )
      {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbf.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array( 'key' => 'entityMyMessage' )
          )
        );
      }
      
      $archStatusId = $orm->getIdByKey( 'WbfsysMessageStatus', 'archived' );

      if (!$orm->update( $entityMyMessage ) )
      {
        $entityText = $entityMyMessage->text();

        // hier wird erst mal nur eine meldung gemacht,
        // die rückgabe des fehlers passiert am ende der methode, wo
        // geprüft wird ob ein fehler in der queue existiert
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update Message {@label@}',
            'wbfsys.message.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );

      }
      else
      {
        $entityText = $entityMyMessage->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated Message {@label@}',
            'wbfsys.message.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );

        $saveSrc = false;


        $this->protocol
        (
          'edited Message: '.$entityText,
          'edit',
          $entityMyMessage
        );



        if( $saveSrc )
          $orm->update( $entityMyMessage );

      }
    }
    catch( LibDb_Exception $e )
    {
      return new Error( $e, Response::INTERNAL_ERROR );
    }

    // prüfen ob fehler in der message queue gelandet sind
    if( $response->hasErrors() )
    {
      // wenn ja geben wir dem controller ein Fehlerojekt zurück
      // das er behandeln soll
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    }
    else
    {
      return null;
    }

  }//end public function archive */

}//end class WbfsysMessage_Table_Model

