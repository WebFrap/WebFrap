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
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyActionLog_Crud_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// getter for the entities
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysTask_Entity
  */
  public function getEntityMyActionLog($objid = null )
  {

    $entityMyActionLog = $this->getRegisterd('entityMyActionLog');

    //entity my_task
    if (!$entityMyActionLog )
    {

      if (!is_null($objid ) )
      {
        $orm = $this->getOrm();

        if (!$entityMyActionLog = $orm->get( 'WbfsysTask', $objid) )
        {
          $this->getMessage()->addError
          (
            $this->i18n->l
            (
              'There is no wbfsystask with this id '.$objid,
              'wbfsys.task.message'
            )
          );
          return null;
        }

        $this->register('entityMyActionLog', $entityMyActionLog);

      } else {
        $entityMyActionLog   = new WbfsysTask_Entity() ;
        $this->register('entityMyActionLog', $entityMyActionLog);
      }

    }
    elseif ($objid && $objid != $entityMyActionLog->getId() )
    {
      $orm = $this->getOrm();

      if (!$entityMyActionLog = $orm->get( 'WbfsysTask', $objid) )
      {
        $this->getMessage()->addError
        (
          $this->i18n->l
          (
            'There is no wbfsystask with this id '.$objid,
            'wbfsys.task.message'
          )
        );
        return null;
      }

      $this->register('entityMyActionLog', $entityMyActionLog);
    }

    return $entityMyActionLog;

  }//end public function getEntityMyActionLog */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysTask_Entity $entity
  */
  public function setEntityMyActionLog($entity )
  {

    $this->register('entityMyActionLog', $entity );

  }//end public function setEntityMyActionLog */

/*//////////////////////////////////////////////////////////////////////////////
// crud methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * @lang en:
   * insert an entity
   * this method fetchs the activ entity from the registry an tries to
   * insert it at the database
   * all connected entities will be added too
   *
   * @lang de:
   * Methode zum erstellen eines neuen Datensatzes.
   * Die Methode geht davon aus, dass sich das zu speichernde Entity Objekt
   * in der Model Registry befindet
   *
   * @param TFlag $params named parameters
   * @return null|Error im Fehlerfall
   */
  public function insert($params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try
    {
      if (!$entityMyActionLog = $this->getRegisterd('entityMyActionLog') )
      {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbfsys.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array( 'key' => 'entityMyActionLog' )
          )
        );
      }

      if (!$orm->insert($entityMyActionLog) )
      {
        // hier wird erst mal nur eine meldung gemacht,
        // die rückgabe des fehlers passiert am ende der methode, wo
        // geprüft wird ob ein fehler in der queue existiert
        $entityText = $entityMyActionLog->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to create Task {@label@}',
            'wbfsys.task.message',
            array
            (
              'label'=>$entityText
            )
          )
        );

      } else {
        $entityText  = $entityMyActionLog->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully created Task {@label@}',
            'wbfsys.task.message',
            array('label'=>$entityText)
          )
        );
        $saveSrc = false;


        $response->protocol
        (
          'Created New Task: '.$entityText,
          'create',
          $entityMyActionLog
        );



        if ($saveSrc)
          $orm->update($entityMyActionLog);
      }

    }
    catch( LibDb_Exception $e )
    {
      return new Error($e, Response::INTERNAL_ERROR );
    }

    if ($response->hasErrors() )
    {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    } else {
      return null;
    }

  }//end public function insert */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function update($params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try
    {
      if (!$entityMyActionLog = $this->getRegisterd('entityMyActionLog'))
      {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbfsys.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array( 'key' => 'entityMyActionLog' )
          )
        );
      }

      if (!$orm->update($entityMyActionLog))
      {
        $entityText = $entityMyActionLog->text();

        // hier wird erst mal nur eine meldung gemacht,
        // die rückgabe des fehlers passiert am ende der methode, wo
        // geprüft wird ob ein fehler in der queue existiert
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update Task {@label@}',
            'wbfsys.task.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );
        
      } else {
        $entityText = $entityMyActionLog->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated Task {@label@}',
            'wbfsys.task.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );

        $saveSrc = false;


        $response->protocol
        (
          'edited Task: '.$entityText,
          'edit',
          $entityMyActionLog
        );



        if ($saveSrc)
          $orm->update($entityMyActionLog);

      }
    }
    catch( LibDb_Exception $e )
    {
      return new Error($e, Response::INTERNAL_ERROR );
    }

    // prüfen ob fehler in der message queue gelandet sind
    if ($response->hasErrors() )
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
    } else {
      return null;
    }

  }//end public function update */

  /**
   * en:
   * delete a dataset from the database
   *
   * de:
   * Löschen eines Datensatzes von der Datenbank
   *
   * @param WbfsysTask_Entity $entityMyActionLog
   * @param TFlag $params named parameters
   * @return void|Error im Fehlerfall
   */
  public function delete($entityMyActionLog, $params  )
  {

    // laden der benötigten resource
    $response  = $this->getResponse();
    $orm       = $this->getOrm();

    try
    {
      // delete wirft eine exception wenn etwas schief geht
      $orm->delete($entityMyActionLog );

      $response->addMessage
      (
        $response->i18n->l
        (
          'Successfully deleted Task {@label@}',
          'wbfsys.task.message',
          array( 'label' => $entityMyActionLog->text() )
        )
      );

        $response->protocol
        (
          'deleted Task: '.$entityMyActionLog,
          'delete',
          array('WbfsysTask',$entityMyActionLog)
        );



      return null;
    }
    catch( LibDb_Exception $e )
    {
      $response->addError
      (
        $response->i18n->l
        (
          'Failed to delete {@label@}',
          'wbfsys.msg',
          array
          (
            'label'=> $entityMyActionLog->text()
          )
        )
      );


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


  }//end public function delete */

/*//////////////////////////////////////////////////////////////////////////////
// fetch methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * de:
   * Laden aller POST key=>value paare aus dem request
   * Die Daten werden direkt validiert und in neue entity objekte passende
   * zur zieltabelle gepackt.
   * Bei invaliden werten werden die Fehlermeldungen direkt in die
   * Message Queue geschrieben.
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchInsertData(  $params )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    try
    {

      $fields = $this->getCreateFields();


      //management  my_task source my_task
      $entityMyActionLog = $orm->newEntity('WbfsysTask');

      if (!$params->fieldsWbfsysTask )
      {
        if ( isset($fields['my_task'] )  )
          $params->fieldsWbfsysTask  = $fields['my_task'];
        else
          $params->fieldsWbfsysTask  = array();
      }

      // if the validation fails report
      $httpRequest->validateInsert
      (
        $entityMyActionLog,
        'my_task',
        $params->fieldsWbfsysTask
      );

      // register the entity in the mode registry
      $this->register('entityMyActionLog',$entityMyActionLog);

      return !$this->getMessage()->hasErrors();
    }
    catch( InvalidInput_Exception $e )
    {
      return null;
    }

  }//end public function fetchInsertData */

  /**
   * fetch the update data from the http request object
   *
   * @param WbfsysTask_Entity $entityMyActionLog
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($entityMyActionLog, $params )
  {

    $view        = $this->getView();
    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    $fields      = $this->getEditFields();


    //entity WbfsysTask
    if (!$params->fieldsWbfsysTask )
    {
      if ( isset($fields['my_task']) )
        $params->fieldsWbfsysTask = $fields['my_task'];
      else
        $params->fieldsWbfsysTask = array();
    }

    $httpRequest->validateUpdate
    (
      $entityMyActionLog,
      'my_task',
      $params->fieldsWbfsysTask
    );
    $this->register('entityMyActionLog',$entityMyActionLog);


    // check if there where any errors if not fine
    return !$this->getMessage()->hasErrors();

  }//end public function fetchUpdateData */

  /**
   * just fetch the post data without any required validation
   *
   * @param TFlag $params named parameters
   * @param int $id the id for the entity
   *
   * @return boolean
   */
  public function fetchPostData($params, $id = null  )
  {

    $httpRequest = $this->getRequest();
    $response    = $this->getResponse();

    if (!$id )
    {
      $entityMyActionLog = new WbfsysTask_Entity;
    } else {

      $orm = $this->getOrm();

      if (!$entityMyActionLog = $orm->get( 'WbfsysTask',  $id ))
      {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no Task with the id: {@id@}',
            'wbfsys.task.message',
            array
            (
              'id' => $id
            )
          )
        );
        $entityMyActionLog = new WbfsysTask_Entity;
      }
    }

    if (!$params->categories )
      $params->categories = array();

    if (!$params->fieldsWbfsysTask )
      $params->fieldsWbfsysTask  = $entityMyActionLog->getCols
      (
        $params->categories
      );

    $httpRequest->validate
    (
      $entityMyActionLog,
      'my_task',
      $params->fieldsWbfsysTask
    );
    $this->register( 'entityMyActionLog', $entityMyActionLog );

    return !$response->hasErrors();

  }//end public function fetchPostData */

/*//////////////////////////////////////////////////////////////////////////////
// get fields
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * just fetch the post data without any required validation
   * @return array
   */
  public function getCreateFields()
  {

    return array
    (
      'my_task' => array
      (
        'm_parent',
        'title',
        'id_responsible',
        'id_principal',
        'http_url',
        'vid',
        'progress',
        'priority',
        'id_type',
        'id_status',
        'description',
        'id_vid_entity',
        'm_version',
      ),

    );

  }//end public function getCreateFields */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditFields()
  {

    return array
    (
      'my_task' => array
      (
        'm_parent',
        'title',
        'id_responsible',
        'id_principal',
        'http_url',
        'vid',
        'progress',
        'priority',
        'id_type',
        'id_status',
        'description',
        'id_vid_entity',
        'm_version',
      ),

    );

  }//end public function getEditFields */

}//end WbfsysTask_Crud_Model

