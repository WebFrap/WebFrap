<?php 
/*******************************************************************************
          _______          ______    _______      ______    _______
         |   _   | ______ |   _  \  |   _   \    |   _  \  |   _   |
         |   1___||______||.  |   \ |.  1   / __ |.  |   \ |.  1___|
         |____   |        |.  |    \|.  _   \|__||.  |    \|.  __)_
         |:  1   |        |:  1    /|:  1    \   |:  1    /|:  1   |
         |::.. . |        |::.. . / |::.. .  /   |::.. . / |::.. . |
         `-------'        `------'  `-------'    `------'  `-------'
                             __.;:-+=;=_.
                                    ._=~ -...    -~:
                     .:;;;:.-=si_=s%+-..;===+||=;. -:
                  ..;::::::..<mQmQW>  :::.::;==+||.:;        ..:-..
               .:.:::::::::-_qWWQWe .=:::::::::::::::   ..:::-.  . -:_
             .:...:.:::;:;.:jQWWWE;.+===;;;;:;::::.=ugwmp;..:=====.  -
           .=-.-::::;=;=;-.wQWBWWE;:++==+========;.=WWWWk.:|||||ii>...
         .vma. ::;:=====.<mWmWBWWE;:|+||++|+|||+|=:)WWBWE;=liiillIv; :
       .=3mQQa,:=====+==wQWBWBWBWh>:+|||||||i||ii|;=$WWW#>=lvvvvIvv;.
      .--+3QWWc:;=|+|+;=3QWBWBWWWmi:|iiiiiilllllll>-3WmW#>:IvlIvvv>` .
     .=___<XQ2=<|++||||;-9WWBWWWWQc:|iilllvIvvvnvvsi|\'\?Y1=:{IIIIi+- .
     ivIIiidWe;voi+|illi|.+9WWBWWWm>:<llvvvvnnnnnnn}~     - =++-
     +lIliidB>:+vXvvivIvli_."$WWWmWm;:<Ilvvnnnnonnv> .          .- .
      ~|i|IXG===inovillllil|=:"HW###h>:<lIvvnvnnvv>- .
        -==|1i==|vni||i|i|||||;:+Y1""'i=|IIvvvv}+-  .
           ----:=|l=+|+|+||+=:+|-      - --++--. .-
                  .  -=||||ii:. .              - .
                       -+ilI+ .;..
                         ---.::....

********************************************************************************
*
* @author      : Dominik Bonsch <db@s-db.de>
* @date        :
* @copyright   : s-db.de (Softwareentwicklung Dominik Bonsch) <contact@s-db.de>
* @distributor : s-db.de <contact@s-db.de>
* @project     : S-DB Modules
* @projectUrl  : http://s-db.de
* @version     : 1
* @revision    : 1
*
* @licence     : S-DB Business <contact@s-db.de>
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
class MyTask_Crud_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// getter for the entities
////////////////////////////////////////////////////////////////////////////////
    
  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysTask_Entity
  */
  public function getEntityMyTask( $objid = null )
  {

    $entityMyTask = $this->getRegisterd('entityMyTask');

    //entity my_task
    if( !$entityMyTask )
    {

      if( !is_null( $objid ) )
      {
        $orm = $this->getOrm();

        if( !$entityMyTask = $orm->get( 'WbfsysTask', $objid) )
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

        $this->register('entityMyTask', $entityMyTask);

      }
      else
      {
        $entityMyTask   = new WbfsysTask_Entity() ;
        $this->register('entityMyTask', $entityMyTask);
      }

    }
    elseif( $objid && $objid != $entityMyTask->getId() )
    {
      $orm = $this->getOrm();

      if( !$entityMyTask = $orm->get( 'WbfsysTask', $objid) )
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

      $this->register('entityMyTask', $entityMyTask);
    }

    return $entityMyTask;

  }//end public function getEntityMyTask */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysTask_Entity $entity
  */
  public function setEntityMyTask( $entity )
  {

    $this->register('entityMyTask', $entity );

  }//end public function setEntityMyTask */

////////////////////////////////////////////////////////////////////////////////
// crud methodes
////////////////////////////////////////////////////////////////////////////////
    
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
  public function insert( $params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try
    {
      if( !$entityMyTask = $this->getRegisterd('entityMyTask') )
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
            array( 'key' => 'entityMyTask' )
          )
        );
      }

      if( !$orm->insert($entityMyTask) )
      {
        // hier wird erst mal nur eine meldung gemacht,
        // die rückgabe des fehlers passiert am ende der methode, wo
        // geprüft wird ob ein fehler in der queue existiert
        $entityText = $entityMyTask->text();
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

      }
      else
      {
        $entityText  = $entityMyTask->text();

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
          $entityMyTask
        );



        if($saveSrc)
          $orm->update($entityMyTask);
      }

    }
    catch( LibDb_Exception $e )
    {
      return new Error( $e, Response::INTERNAL_ERROR );
    }

    if( $response->hasErrors() )
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
    }
    else
    {
      return null;
    }

  }//end public function insert */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function update( $params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try
    {
      if(!$entityMyTask = $this->getRegisterd('entityMyTask'))
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
            array( 'key' => 'entityMyTask' )
          )
        );
      }

      if(!$orm->update($entityMyTask))
      {
        $entityText = $entityMyTask->text();

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
        
      }
      else
      {
        $entityText = $entityMyTask->text();

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
          $entityMyTask
        );



        if($saveSrc)
          $orm->update($entityMyTask);

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

  }//end public function update */

  /**
   * en:
   * delete a dataset from the database
   *
   * de:
   * Löschen eines Datensatzes von der Datenbank
   *
   * @param WbfsysTask_Entity $entityMyTask
   * @param TFlag $params named parameters
   * @return void|Error im Fehlerfall
   */
  public function delete( $entityMyTask, $params  )
  {

    // laden der benötigten resource
    $response  = $this->getResponse();
    $orm       = $this->getOrm();

    try
    {
      // delete wirft eine exception wenn etwas schief geht
      $orm->delete( $entityMyTask );

      $response->addMessage
      (
        $response->i18n->l
        (
          'Successfully deleted Task {@label@}',
          'wbfsys.task.message',
          array( 'label' => $entityMyTask->text() )
        )
      );

        $response->protocol
        (
          'deleted Task: '.$entityMyTask,
          'delete',
          array('WbfsysTask',$entityMyTask)
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
            'label'=> $entityMyTask->text()
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

////////////////////////////////////////////////////////////////////////////////
// fetch methodes
////////////////////////////////////////////////////////////////////////////////
    
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
      $entityMyTask = $orm->newEntity('WbfsysTask');

      if( !$params->fieldsWbfsysTask )
      {
        if( isset( $fields['my_task'] )  )
          $params->fieldsWbfsysTask  = $fields['my_task'];
        else
          $params->fieldsWbfsysTask  = array();
      }

      // if the validation fails report
      $httpRequest->validateInsert
      (
        $entityMyTask,
        'my_task',
        $params->fieldsWbfsysTask
      );

      // register the entity in the mode registry
      $this->register('entityMyTask',$entityMyTask);

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
   * @param WbfsysTask_Entity $entityMyTask
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData( $entityMyTask, $params )
  {

    $view        = $this->getView();
    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    $fields      = $this->getEditFields();


    //entity WbfsysTask
    if( !$params->fieldsWbfsysTask )
    {
      if( isset($fields['my_task']) )
        $params->fieldsWbfsysTask = $fields['my_task'];
      else
        $params->fieldsWbfsysTask = array();
    }

    $httpRequest->validateUpdate
    (
      $entityMyTask,
      'my_task',
      $params->fieldsWbfsysTask
    );
    $this->register('entityMyTask',$entityMyTask);


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

    if( !$id )
    {
      $entityMyTask = new WbfsysTask_Entity;
    }
    else
    {

      $orm = $this->getOrm();

      if(!$entityMyTask = $orm->get( 'WbfsysTask',  $id ))
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
        $entityMyTask = new WbfsysTask_Entity;
      }
    }

    if( !$params->categories )
      $params->categories = array();

    if( !$params->fieldsWbfsysTask )
      $params->fieldsWbfsysTask  = $entityMyTask->getCols
      (
        $params->categories
      );

    $httpRequest->validate
    (
      $entityMyTask,
      'my_task',
      $params->fieldsWbfsysTask
    );
    $this->register( 'entityMyTask', $entityMyTask );

    return !$response->hasErrors();

  }//end public function fetchPostData */

////////////////////////////////////////////////////////////////////////////////
// get fields
////////////////////////////////////////////////////////////////////////////////
    
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

