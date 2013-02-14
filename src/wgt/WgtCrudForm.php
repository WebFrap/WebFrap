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

/** Form Class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtCrudForm
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   * @var string
   */
  public $prefix   = null;

  /**
   *
   * Enter description here ...
   * @var string
   */
  public $suffix   = null;

  /**
   * should all fields be readonly
   *
   * @var boolean
   */
  public $readOnly  = false;

  /**
   * should all fields be refreshed in an ajax request
   *
   * @var boolean
   */
  public $refresh   = false;

  /**
   * should all fields be refreshed in an ajax request
   *
   * @var boolean
   */
  public $sendElement = false;

  /**
   * target key
   * @var string
   */
  public $target    = null;
  
  /**
   * target key
   * @var string
   */
  public $targetMask    = null;

  /**
   * in wich master namespace is the form actually (like management from model)
   * this variable is used to be able to adress the category in which the
   * datafields are actually, normaly they are named by the activ management view
   *
   * @var string $keyName
   */
  public $namespace = null;

  /**
   * the if of the from on wich this element is assigned
   *
   * @var string
   */
  public $assignedForm = null;

  /**
   * Die Contexturl des Forms, Masken, Acls, Refid etc
   *
   * @var string
   */
  public $contextUrl = null;
  
  /**
   * @var string
   */
  public $maskRoot = null;
  
  /**
   * Mapp mit allen Entries die Readonly sein sollen
   * @var array
   */
  public $mapReadonly = array();
  
  /**
   * name of the entity for that form
   * @var Entity
   */
  public $entity    = null;

  /**
   * @var int
   */
  public $rowid     = null;
  
  /**
   * @var LibAclPermission
   */
  public $access     = null;
  
  /**
   * Default werte welche per Request übergeben wurden
   * wird benötigt um diese in create next weitergeben zu können
   * @var array
   */
  public $externDefData     = array();

/*//////////////////////////////////////////////////////////////////////////////
// protected attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * name of the entity for that form
   *
   * @var string
   */
  protected $entityName = null;

  /**
   * Array mit allen Items / Inputelementen die in dem Form liegen
   * @var array
   */
  protected $fields      = array();
  
  /**
   * the activ view
   *
   * @var LibTemplateAjax
   */
  protected $view   = null;

  /**
   * the database object
   *
   * @var LibDbConnection
   */
  protected $db     = null;

  /**
   * the activ request object
   *
   * @var LibRequestPhp
   */
  protected $request    = null;

  /**
   * the activ request object
   *
   * @var LibResponsePhp
   */
  protected $response   = null;

  /**
   * the activ request object
   *
   * @var LibAclAdapter
   */
  protected $acl        = null;
  
  /**
   * Das User Object
   *
   * @var User
   */
  protected $user        = null;

  /**
   * Array mit allen Items / Inputelementen die in dem Form liegen
   * @var array
   */
  protected $items      = array();

  /**
   * Alle Daten die in das Form geschrieben wurden
   * @var array
   */
  protected $formInput  = array();

  /**
   * Fehlermeldungen
   * @var array
   */
  protected $errorMessages  = array();

  /**
   * Daten für die Validierung
   * @var array
   */
  protected $validation     = array();
  
  /**
   * Daten für listenelemente
   * 
   * Kann zb dazu verwendet werden selectboxes zu customizen
   * 
   * @var array
   */
  protected $listElementData     = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibTemplateAjax $view
   * @param LibRequestPhp $request
   */
  public function __construct($view = null,  $request = null )
  {

    $this->view = $view;

    if (!$request )
      $this->request = Request::getInstance();
    else
      $this->request = $request;

  }//end public function __construct */
  
/*//////////////////////////////////////////////////////////////////////////////
// Magic Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string $method
   * @var array $values
   */
  public function __call($method, $arguments )
  {
    
    if ( 'input_' == substr($method, 0,6) )
    {
      Log::warn( "Requested nonexisting Input: ".$method );
      return null;
    } else {
      throw new MethodNotExists_Exception($this, $method, $arguments);
    }
    
    
    
  }//end public function __call */
  
/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setNamespace($name )
  {
    $this->namespace = $name;
  }//end public function setKeyName */

  /**
   * id of the assigned form
   * @param string
   */
  public function setAssignedForm($formId )
  {
    $this->assignedForm = $formId;
  }//end public function setKeyName */

  /**
   * setter for the keyname
   *
   * @param string $target
   */
  public function setTarget($target )
  {

    $this->target = $target;
  }//end public function setTarget */
  
  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setTargetMask($targetMask )
  {
    $this->targetMask = $targetMask;
  }//end public function setTargetMask */
  

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setPrefix($name )
  {
    $this->prefix = $name;
  }//end public function setKeyName */

  /**
   * setter for the keyname
   *
   * @param string $suffix
   */
  public function setSuffix($suffix )
  {
    $this->suffix = $suffix;
  }//end public function setSuffix */

  /**
   * getter for the suffix
   * @param boolean $asIdPart
   * @return string
   */
  public function getSuffix($asIdPart = false )
  {
    
    if ($asIdPart )
      return $this->suffix?'-'.$this->suffix:'';
    
    return $this->suffix;
    
  }//end public function getSuffix */

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setFields($data )
  {
    $this->fields = $data;
  }//end  public function setFields */

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function addFields($data )
  {

    if ( is_array($data) )
      $this->fields = array_merge($this->fields,$data);

    else
      $this->fields[] = $data;

  }//end public function addFields

  /**
   * setter for the keyname
   *
   * @param string $readOnly
   */
  public function setReadOnly($readOnly = true )
  {
    $this->readOnly = $readOnly;
  }//end  public function setReadonly */


  
  /**
   * @param boolean $fieldName 
   */
  public function isReadOnly($fieldName )
  {
    
    if ($this->readOnly )
      return true;
          
    return isset($this->mapReadonly[$fieldName] );
        
  }//end public function isReadOnly */
  
  /**
   * Setter for the readonly map
   * 
   * @param array $readOnlyMap
   */
  public function setReadonlyFields($roFields )
  {
    
    $this->roFields = $roFields;
    
  }//end public function setReadonlyFields */
 
  /**
   * @param string $key 
   * @param string $fieldName 
   * @return boolean
   */
  public function fieldReadOnly($key, $fieldName )
  {
    
    if ($this->readOnly )
      return true;
          
    if (!isset($this->fields[$key][$fieldName] ) )
      return false;
    
    return $this->fields[$key][$fieldName]['readonly'];
        
  }//end public function isReadOnly */
  
  /**
   * 
   * @param string $key 
   * @param string $fieldName 
   * @param array $state 
   * 
   */
  public function setFieldConstraint($key, $fieldName, array $state )
  {
    
    foreach($state as $subKey => $val )
    {
      $this->fields[$key][$fieldName][$subKey] = $val;
    }
    
  }//end public function setFieldConstraint */
  
  /**
   * @param string $key 
   * @param string $fieldName 
   * @param boolean $flag 
   * @return boolean
   */
  public function setFieldReadOnly($key, $fieldName, $flag = true )
  {
    
    $this->fields[$key][$fieldName]['readonly'] = $flag;
        
  }//end public function setFieldReadOnly */
  
  /**
   * @param string $key 
   * @param string $fieldName 
   * @return boolean
   */
  public function fieldRequired($key, $fieldName )
  {

    if (!isset($this->fields[$key][$fieldName] ) )
      return false;
    
    return $this->fields[$key][$fieldName]['required'];
        
  }//end public function fieldRequired */
  
  /**
   * @param string $key 
   * @param string $fieldName 
   * @param boolean $flag 
   * @return boolean
   */
  public function setFieldRequired($key, $fieldName, $flag = true )
  {

    $this->fields[$key][$fieldName]['required'] = $flag;
        
  }//end public function setFieldRequired */

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setErrors($errors )
  {
    
    $this->errorMessages = $errors;
    
  }//end  public function setErrors */

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setValidation($validation )
  {
    $this->validation = $validation;
  }//end  public function setValidation */
  
  /**
   * 
   * @param TFlag $params
   */
  public function setParams($params )
  {
    $this->params = $params;
  }//end  public function setParams */
  

  /**
   *
   * @param TFlag $params
   */
  public function checkNamedParams($params )
  {

    if (is_null($params ) )
      return new TFlag();

    // overwrite the default keyname, if exists
    if ($params->keyName )
      $this->keyName  = $params->keyName;

    // overwrite the default prefix, if exists
    if ($params->prefix )
      $this->prefix   = $params->prefix;

    // overwrite the default value readOnly, if exists
    if ($params->readOnly )
      $this->readOnly = $params->readOnly;

    // overwrite the default value refresh, if exists
    if ($params->refresh )
      $this->refresh  = $params->refresh;

    // overwrite the default value refresh, if exists
    if ($params->sendElement )
      $this->sendElement = $params->sendElement;

    // overwrite the default value refresh, if exists
    if ($params->target )
      $this->target   = $params->target;

    // overwrite the default value for namespace, if exists
    if ($params->namespace )
      $this->namespace   = $params->namespace;

    // overwrite the form assignment
    if ($params->assignedForm )
      $this->assignedForm   = $params->assignedForm;
      
    if ($params->maskRoot )
      $this->maskRoot   = $params->maskRoot;

    return $params;

  }//end public function checkNamedParams */

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function newItem($validation )
  {
    $this->validation = $validation;
  }//end  public function newItem */

  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {

    if (!$this->acl )
      $this->acl = Webfrap::$env->getAcl();

    return $this->acl;

  }//end public function getAcl */

  /**
   * @return LibResponseHttp
   */
  public function getResponse()
  {

    if (!$this->response)
      $this->response = Webfrap::$env->getResponse();

    return $this->response;

  }//end public function getResponse */
  
  
  /**
   * @return LibRequestPhp
   */
  public function getRequest()
  {

    if (!$this->request )
      $this->request = Webfrap::$env->getRequest();

    return $this->request;

  }//end public function getRequest */
  
  /**
   * @return LibDbConnection
   */
  public function getDb()
  {

    if (!$this->db )
      $this->db = Webfrap::$env->getDb();

    return $this->db;

  }//end public function getDb */
  
  /**
   * @return LibDbOrm
   */
  public function getOrm()
  {

    if (!$this->db )
      $this->db = Webfrap::$env->getDb();

    return $this->db->getOrm();

  }//end public function getOrm */

  /**
   * @return User
   */
  public function getUser()
  {

    if (!$this->user )
      $this->user = Webfrap::$env->getUser();

    return $this->user;

  }//end public function getUser */
  
  /**
   * @param User $user
   */
  public function setUser($user )
  {
    $this->user = $user;
  }//end public function setUser */
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * check the values for an insert
   *
   * @param array $fields if fetch is empty fetch all
   * @param string $keyName if is null use default keyname
   * @return Entity
   */
  public function validateInsert($entity, $fields = array() , $keyName = null  )
  {

    $fields   = $fields   ?: $this->fields;
    $keyName  = $keyName  ?: $this->keyName;
    
    $orm      = $this->getOrm();
    $request  = $this->getRequest();
    $response = $this->getResponse();
    
    $filter = $request->checkFormInput
    (
      $orm->getValidationData($this->entityName, $fields, true ),
      $orm->getErrorMessages($this->entityName ),// return all so it's just an internal reference for reading
      $keyName
    );

    $entity->addData($filter->getData() );

    if ($filter->hasErrors() )
    {
      $response->addError($filter->getErrorMessages() );
      return false;
    }

    return true;

  }//end public function validateInsert */

  /**
   * check the values for an update
   *
   * @param Entity $entity
   * @param array $fields
   * @param string $keyName
   * 
   * @return Entity
   */
  public function validateUpdate($entity, $fields = array() , $keyName = null  )
  {

    $fields   = $fields   ?: $this->fields;
    $keyName  = $keyName  ?: $this->keyName;
    
    $orm      = $this->getOrm();
    $request  = $this->getRequest();

    $filter = $request->checkFormInput
    (
      $orm->getValidationData(  $this->entityName,  $fields  ),
      $orm->getErrorMessages(   $this->entityName  ),
      $keyName
    );

    $entity->addData($filter->getData() );

    return $entity;

  }//end public function validateUpdate */

  /**
   * check the values for an insert
   *
   * @param array $fields
   * @param array $keyName
   * @return array all filtered data
   */
  public function validateMultiInsert($fields = array()  , $keyName = null )
  {

    $fields   = $fields   ?: $this->fields;
    $keyName  = $keyName  ?: $this->keyName;

    $orm      = $this->getOrm();
    $request  = $this->getRequest();

    $filtered = $request->checkMultiFormInput
    (
      $orm->getValidationData($this->entityName, $fields ),
      $orm->getErrorMessages($this->entityName ),
      $keyName
    );

    $entityName = $this->entityName.'_Entity';

    $tmp = array();
    foreach($filtered as $rowid => $data )
    {
      $tpObj = new $entityName();
      // unset rowids without merci, THIS... IS... INSERT... einseinself!!
      if ( array_key_exists( Db::PK, $data ) )
        unset($data[Db::PK]);

      $tpObj->addData($data);
      $tmp[$rowid] = $tpObj;
    }

    return $tmp;

  }//end public function validateMultiInsert */


  /**
   * check the values for an update
   *
   * @param Entity $entity
   * @param array $fields
   */
  public function validateMultiUpdate($fields = array()  , $keyName = null )
  {

    $fields   = $fields   ?: $this->fields;
    $keyName  = $keyName  ?: $this->keyName;
    
    $orm      = $this->getOrm();
    $request  = $this->getRequest();
    $response = $this->getResponse();

    $filtered = $request->checkMultiFormInput
    (
      $orm->getValidationData($this->entityName, $fields ),
      $orm->getErrorMessages($this->entityName ),
      $keyName
    );

    $entityName = $this->entityName.'_Entity';

    $entityList = array();
    foreach($filtered as $rowid => $data )
    {

      $tpObj = new $entityName();

      // ignore rowid
      if ( array_key_exists( Db::PK, $data ) )
      {
        
        // must convert to boolean true
        if ($data[Db::PK])
          $rowid = $data[Db::PK];

        unset($data[Db::PK]);
        
      }//end if

      if ( is_numeric($rowid ) )
      {
        $tpObj->setId( (int)$rowid );
        $tpObj->addData($data );
        $entityList[$rowid] = $tpObj;
      }//end if
      else
      {
        $response->addWarning( 'Got an invalid dataset for update' );
      }

    }//end foreach


    return $entityList;

  }//end public static function validateMultiUpdate */


  /**
   * check the values for an update
   *
   * @param array $fields
   * @param string $keyName
   */
  public function validateMultiSave($fields = array()  , $keyName = null )
  {

    $fields   = $fields   ?: $this->fields;
    $keyName  = $keyName  ?: $this->keyName;
    
    $orm      = $this->getOrm();
    $request  = $this->getRequest();

    $filtered = $request->checkMultiFormInput
    (
      $orm->getValidationData($this->entityName,$fields),
      $orm->getErrorMessages($this->entityName),
      $keyName
    );

    $entityName = $this->entityName.'_Entity';

    $entityList = array();
    foreach($filtered as $rowid => $data )
    {

      $tpObj = new $entityName();

      // ignore rowid
      if ( array_key_exists( Db::PK, $data ) )
      {
        unset($data[Db::PK]);
      }//end if

      if ( is_numeric($rowid ) )
      {
        $tpObj->setId((int)$rowid);

        if (DEBUG)
          Debug::console( 'the id '.$tpObj->id , $data);

      }//end if

      $tpObj->addData($data);
      $entityList[$rowid] = $tpObj;

    }//end foreach


    return $entityList;

  }//end public static function validateMultiSave */

 /**
  * just validate the post data
  * this method just returns an array an no entity as the other validate methodes
  * 
  * @param array $fields
  * @param string $keyName
  * 
  * @return array
  */
  public function validate($fields = array() , $keyName = null )
  {

    $fields   = $fields   ?:  $this->fields;
    $keyName  = $keyName  ?:  $this->keyName;
    
    $orm      = $this->getOrm();
    $request  = $this->getRequest();

    $filter = $request->checkSearchInput
    (
      $orm->getValidationData($this->entityName, $fields ),
      $orm->getErrorMessages($this->entityName ),
      $keyName
    );

    $tmp  = $filter->getData();
    $data = array();

    foreach($tmp as $key => $value   )
    {
      if (!is_null($value) )
        $data[$key] = $value;
    }

    return $data;

  }//end public function validate */

  /**
   * @param string $formAction
   * @param string $formId
   * @param TFlag $param
   * @param string $subkey
   */
  public function setFormTarget($formAction, $formId, $param, $subkey = null )
  {
    
    $contextUrl = '';

    // flag if the new entry should be added with connection action or CRUD actions
    if ($param->publish )
      $contextUrl .= '&amp;publish='.$param->publish;

    // the id of the html table where the new entry has to be added
    if ($param->targetId )
      $contextUrl .= '&amp;target_id='.$param->targetId;

    // target is a pointer to a js function that has to be called
    if ($param->target )
      $contextUrl .= '&amp;target='.$param->target;

    if ($param->input )
      $contextUrl .= '&amp;input='.$param->input;

    if ($param->suffix )
      $contextUrl .= '&amp;suffix='.$param->suffix;

    // target is a pointer to a js function that has to be called
    if ($param->refId )
      $contextUrl .= '&amp;refid='.$param->refId;

    // target is a pointer to a js function that has to be called
    if ($param->targetMask )
      $contextUrl .= '&amp;mask='.$param->targetMask;

    // which view type was used, important to close the ui element eg.
    if ($param->viewType )
      $contextUrl .= '&amp;view='.$param->viewType;

    // which view type was used, important to close the ui element eg.
    if ($param->viewId )
      $contextUrl .= '&amp;view_id='.$param->viewId;

    // list type
    if ($param->ltype )
      $contextUrl .= '&amp;ltype='.$param->ltype;


// ACLS

    // startpunkt des pfades für die acls
    if ($param->aclRoot )
      $contextUrl .= '&amp;a_root='.$param->aclRoot;
      
    // die root maske von der gestartet wurde
    if ($param->maskRoot )
      $contextUrl .= '&amp;m_root='.$param->maskRoot;
      
    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($param->aclRootId )
      $contextUrl .= '&amp;a_root_id='.$param->aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($param->aclKey )
      $contextUrl .= '&amp;a_key='.$param->aclKey;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($param->aclLevel )
      $contextUrl .= '&amp;a_level='.$param->aclLevel;

    // der neue knoten
    if ($param->aclNode )
      $contextUrl .= '&amp;a_node='.$param->aclNode;


    $this->contextUrl = $contextUrl;
      
    // add the action to the form
    $this->view->addVar( 'formAction'.$subkey, $formAction.$contextUrl );

    // formId
    $this->view->addVar( 'formId'.$subkey, $formId );
    
    $this->assignedForm = $formId;

  }//end public function setFormTarget */

/*//////////////////////////////////////////////////////////////////////////////
// Customizing der Daten
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   *
   */
  protected function customize()
  {
    
  }//end protected function customize */
  
  /**
   * Setzen der Default werte auf den entities
   */
  protected function setDefaultData()
  {
    
  }//end protected function setDefaultData */

}//end class WgtForm


