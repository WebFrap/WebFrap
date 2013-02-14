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
class WgtForm
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the name of the key that is used in the ajax requests
   *
   * @example [$keyName][field]
   *
   * @var string $keyName
   */
  public $keyName   = null;

  /**
   * @var string
   */
  public $prefix   = null;

  /**
   * @var string
   */
  public $suffix   = null;

  /**
   * the fetch array with all attributes to fetch from the browser
   *
   * @var array $fields
   */
  public $fields    = array();

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
   * Mapp mit allen Entries die Readonly sein sollen
   * @var array
   */
  public $mapReadonly = array();
  

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
   * name of the entity for that form
   * @var Entity
   */
  public $entity    = null;

  /**
   * @var int
   */
  public $rowid     = null;

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
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter for the keyname
   *
   * @param string $name
   */
  public function setKeyName($name )
  {
    $this->keyName = $name;
  }//end public function setKeyName */

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
   * @return string
   */
  public function getSuffix($name )
  {
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
   * setter for the keyname
   *
   * @param string $fieldName
   * @param boolean $readOnly
   */
  public function setFieldReadonly($fieldName,  $readOnly = true )
  {
    
    if ( is_array($fieldName ) )
    {
      
      foreach ($fieldName as $key )
      {
        $this->mapReadonly[$key] = true;
      }
      
    } else {
      
      if ( isset($this->mapReadonly[$fieldName] ) )
      {
        if (!$readOnly )
          unset($this->mapReadonly[$fieldName] );
      } else {
        if ($readOnly )
          $this->mapReadonly[$fieldName] = true;
      }
      
    }
    
    
  }//end  public function setReadonly */
  
  /**
   * Setter for the readonly map
   * 
   * @param array $readOnlyMap
   */
  public function setReadonlyMap($readOnlyMap )
  {
    
    foreach ($readOnlyMap as $key )
    {
      $this->mapReadonly[$key] = true;
    }
    
  }//end public function setReadonlyMap */
  
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
   * @param array $roFields
   */
  public function setReadonlyFields($roFields )
  {
    
    $this->roFields = $roFields;
    
  }//end public function setReadonlyFields */
 
  /**
   * @param string $key 
   * @param string $fieldName 
   */
  public function fieldReadOnly($key, $fieldName )
  {
    
    if ($this->readOnly )
      return true;
          
    if (!isset($this->fields[$key][$fieldName] ) )
      return false;
    
    return $this->fields[$key][$fieldName]['required'];
        
  }//end public function isReadOnly */

  /**
   * setter for the keyname
   *
   * @param string $errors
   */
  public function setErrors($errors )
  {
    
    $this->errorMessages = $errors;
    
  }//end  public function setErrors */

  /**
   * setter for the keyname
   *
   * @param string $validation
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

    return $params;

  }//end public function checkNamedParams */

  /**
   * setter for the keyname
   *
   * @param string $validation
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

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibViewAjax $view
   * @return void
   */
  public function createForm($entity , $fetch = array() , $params = array() )
  {
    $this->view->addItem($this->items );
  }//end public function createForm */

  /**
   * check the values for an insert
   *
   * @param array $fields if fetch is empty fetch all
   * @param string $keyName if is null use default keyname
   * @return Entity
   */
  public function validateInsert($entity, $fields = array(), $keyName = null  )
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
  public function validateUpdate($entity, $fields = array(), $keyName = null  )
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
   * @param string $keyName
   * 
   * @return array all filtered data
   */
  public function validateMultiInsert($fields = array(), $keyName = null )
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
   * @param array $fields
   * @param string $keyName
   */
  public function validateMultiUpdate($fields = array(), $keyName = null )
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
        $tpObj->addData($data);
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
  public function validateMultiSave($fields = array(), $keyName = null )
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
  public function validate($fields = array(), $keyName = null )
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

/*//////////////////////////////////////////////////////////////////////////////
// Some Static help Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $action
   * @param string $id
   * @param string $method
   * 
   */
  public static function form($action, $id, $method = 'post' )
  {
    
    return <<<CODE
<form method="{$method}" action="{$action}" id="{$id}" ></form>
CODE;
    
  }//end public static function form */
  
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public static function input
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(), 
    $formId = null,
    $appendText = null,
    $size = 'medium'
  )
  {

    if ( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {
    
      $tmp = explode(',', $name);
      
      if ( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'text';
    
    if (!isset($attributes['class']) )
      $attributes['class']  = $size;
    
    if ($formId )
      $attributes['class']  .= ' asgd-'.$formId;
    
    if (!isset($attributes['name']) )
      $attributes['name']   = $inpName;
      
    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes );

    $helpIcon = '';
    $helpText = '';
    if ( is_array($label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} />{$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $html;

  }//end public static function input */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param string $loadUrl
   * @param string $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public static function autocomplete
  ( 
    $label, 
    $name, 
    $value = null,  
    $loadUrl = null,
    $attributes = array(), 
    $formId = null,
    $appendText = null,
    $size = 'medium'
  )
  {

    if ( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {
    
      $tmp = explode(',', $name);
      
      if ( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'text';
    
    if (!isset($attributes['class']) )
      $attributes['class']  = 'wcm wcm_ui_autocomplete '.$size;
    else 
      $attributes['class']  = 'wcm wcm_ui_autocomplete '.$size.' '.$attributes['class'];
    
    if ($formId )
      $attributes['class']  .= ' asgd-'.$formId;
    
    if (!isset($attributes['name']) )
      $attributes['name']   = $inpName;
      
    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes );

    $helpIcon = '';
    $helpText = '';
    if ( is_array($label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} /><var class="meta" >{"url":"{$loadUrl}"}</var>{$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $html;

  }//end public static function autocomplete */
  
  
  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   */
  public static function decorateInput
  ( 
    $label, 
    $id, 
    $element,
    $appendText = null
  )
  {


    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div class="wgt-input medium" style="width:200px;" >
    {$element}
    {$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $html;

  }//end public static function decorateInput */
 
  /**
   * @param string $name
   * @param string $id
   * @param string $element
   * @param string $appendText
   */
  public static function decorateElement
  ( 
    $label, 
    $id, 
    $element,
    $appendText = null
  )
  {

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label" >{$label}</label>
  <div class="wgt-input medium" style="width:200px;" >
    {$element->element()}
    {$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $html;

  }//end public static function decorateElement */
  
  
  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   */
  public static function wysiwyg
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(), 
    $formId = null,
    $append = null,
    $plain = false
  )
  {

    if ( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {
    
      $tmp = explode(',', $name);
      
      if ( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-wysiwyg-{$id}"; 
    }
    
    $attributes['class']  = 'wcm wcm_ui_wysiwyg medium ';
    
    if ($formId )
      $attributes['class']  .= ' asgd-'.$formId;
    
    if (!isset($attributes['name']) )
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes );
    
    $helpIcon = '';
    $helpText = '';
    if ( is_array($label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    if ($plain )
    {
      return <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label large" >{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input medium left" >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

  //<var id="{$id}-cfg-wysiwyg" >{"mode":"{$mode}"}</var>" 
  
    return $html;

  }//end public static function wysiwyg */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param string $attributes
   * @param string $formId
   */
  public static function upload
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(), 
    $formId = null,
    $clean = false
  )
  {

    if ( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {
    
      $tmp = explode(',', $name);
      
      if ( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']     = 'file';

    if (!isset($attributes['class']) )
      $attributes['class'] = 'medium';
    
    $attributes['class']    .= ' wgt-behind';
    
    if ($formId )
      $attributes['class']  .= ' asgd-'.$formId;
    
    $attributes['name']   = $inpName;
    $attributes['value']  = str_replace('"', '\"', $value);
    
    $attributes['onchange']   = "\$S('input#wgt-input-{$id}-display').val(\$S(this).val());\$S(this).attr('title',\$S(this).val());";

    $codeAttr = Wgt::asmAttributes($attributes );
    
    $icon = Wgt::icon( 'control/upload_image.png', 'xsmall', array('alt'=>"Upload Image") );

    if ($clean )
    {
      return <<<CODE

  <div style="position:relative;overflow:hidden;" class="wgt-input medium" >
    <input {$codeAttr} />
    <input 
      type="text" 
      class="medium wgt-ignore wgt-overlay" 
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button class="wgt-button wgt-overlay append" tabindex="-1" >
      {$icon}
    </button>
  </div>

CODE;
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div style="position:relative;" class="wgt-input medium" >
    <input {$codeAttr} />
    <input 
      type="text" 
      class="medium wgt-ignore wgt-overlay" 
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button class="wgt-button wgt-overlay append" tabindex="-1" >
      {$icon}
    </button>
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $html;

  }//end public static function upload */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $checked
   * @param string $attributes
   * @param string $formId
   * @param boolean $plain
   */
  public static function checkbox
  ( 
    $label, 
    $name,
    $checked, 
    $attributes = array(), 
    $formId     = null, 
    $plain      = false 
  )
  {

    if ( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {
    
      $tmp = explode(',', $name);
      
      if ( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'checkbox';
    
    if ($checked && 'false' != $checked )
      $attributes['checked']  = 'checked';
    
    if ($formId )
      $attributes['class']  = 'asgd-'.$formId;
    
    if (!isset($attributes['name'] ) )
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes );
    
    if ($plain )
      return "<input {$codeAttr} />";

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div class="wgt-input" >
    <input {$codeAttr} />
  </div>
</div>

CODE;

    return $html;

  }//end public static function checkbox */
  
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public static function sumField
  ( 
    $label, 
    $name, 
    $fields = array(), 
    $attributes = array(), 
    $formId = null,
    $appendText = null,
    $size = 'medium'
  )
  {

    if ( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {
    
      $tmp = explode(',', $name);
      
      if ( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'text';
    
    if (!isset($attributes['class']) )
      $attributes['class']  = $size;
      
    $attributes['class'] .= ' wcm wcm_form_sumfield';
    
    if ($formId )
      $attributes['class']  .= ' asgd-'.$formId;
    
    if (!isset($attributes['name']) )
      $attributes['name']   = $inpName;

    $attributes['wgt_fields'] = implode(',',$fields);

    $codeAttr = Wgt::asmAttributes($attributes );

    $helpIcon = '';
    $helpText = '';
    if ( is_array($label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} />{$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $html;

  }//end public static function sumField */


}//end class WgtForm


