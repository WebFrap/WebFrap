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
 * de:
 * {
 *  Diese Klasse wird zum emulieren von benamten parametern verwendet.
 *
 *  Dazu werden __get und __set implementiert.
 *  __get gibt entweder den passenden wert für einen key oder null zurück
 * }
 *
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Context
{

  /**
   * a container with the acl informations in this context
   * @var LibAclPermission
   */
  public $access = null;

  /**
   * startpunkt des pfades für die acls
   *
   * url param: 'a_root',  Validator::CKEY
   *
   * @var string
   */
  public $aclRoot = null;

  /**
   * Die Rootmaske des Datensatzes
   *
   * url param: 'm_root',  Validator::TEXT
   *
   * @var string
   */
  public $maskRoot = null;

  /**
   * die id des Datensatzes von dem aus der Pfad gestartet wurde
   *
   * url param: 'a_root_id', Validator::INT
   *
   * @var int
   */
  public $aclRootId = null;

  public $aclKey = null;

  public $aclLevel = null;

  public $aclNode = null;

  /**
   * @var string
   */
  public $parentMask = null;

  /**
   * Flag ob der Request Invalid war
   *
   * @var boolean
   */
  public $isInvalid = false;

  /**
   * @var string
   */
  public $order = array();

  /**
   * de:
   * {
   *   Container zum speichern der key / value paare.
   * }
   * @var array
   */
  protected $content = array();

  /**
   * @var string
   */
  protected $urlExt = null;

  /**
   * @var string
   */
  protected $actionExt = null;

  /**
   * @var string
   */
  protected $request = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibRequestHttp $request
   */
  public function __construct($request = null)
  {

    if ($request){
      $this->request = $request;
      $this->interpretRequest($request);
    }

  }// end public function __construct */

  /**
   * virtual __set
   * @see http://www.php.net/manual/de/language.oop5.overloading.php
   *
   * @param string $key
   * @param string $value
   */
  public function __set($key , $value)
  {
    $this->content[$key] = $value;
  }// end public function __set */

  /**
   * virtual __get
   * @see http://www.php.net/manual/de/language.oop5.overloading.php
   *
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    return isset($this->content[$key])
      ? $this->content[$key]
      : null;
  }// end public function __get */

  /**
   * @param LibRequestHttp $request
   */
  public function setRequest($request)
  {

    $this->request = $request;

  }//end public function setRequest */

  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    $this->interpretRequestAcls($request);

  }//end public function interpretRequest */

  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequestAcls($request)
  {

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $this->aclRoot = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $this->aclRootId = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $this->aclKey = $aclKey;

    // der name des knotens
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $this->aclNode = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $this->aclLevel = $aclLevel;

  }//end public function interpretRequestAcls */

  /**
   * @param Context $context
   */
  public function importAcl($context)
  {

    // startpunkt des pfades für die acls
    $this->aclRoot = $context->aclRoot;
    $this->aclRootId = $context->aclRootId;
    $this->aclKey = $context->aclKey;
    $this->aclNode = $context->aclNode;
    $this->aclLevel = $context->aclLevel;

  }//end public function importAcl */

  /**
   * @return string
   */
  public function toUrlExt()
  {

    if ($this->urlExt)
      return $this->urlExt;

    if ($this->aclRoot)
      $this->urlExt .= '&amp;a_root='.$this->aclRoot;

    if ($this->aclRootId)
      $this->urlExt .= '&amp;a_root_id='.$this->aclRootId;

    if ($this->aclKey)
      $this->urlExt .= '&amp;a_key='.$this->aclKey;

    if ($this->aclNode)
      $this->urlExt .= '&amp;a_node='.$this->aclNode;

    if ($this->aclLevel)
      $this->urlExt .= '&amp;a_level='.$this->aclLevel;

    return $this->urlExt;

  }//end public function toUrlExt */

  /**
   * @return string
   */
  public function toActionExt()
  {

    if ($this->actionExt)
      return $this->actionExt;

    if ($this->aclRoot)
      $this->actionExt .= '&a_root='.$this->aclRoot;

    if ($this->aclRootId)
      $this->actionExt .= '&a_root_id='.$this->aclRootId;

    if ($this->aclKey)
      $this->actionExt .= '&a_key='.$this->aclKey;

    if ($this->aclNode)
      $this->actionExt .= '&a_node='.$this->aclNode;

    if ($this->aclLevel)
      $this->actionExt .= '&a_level='.$this->aclLevel;

    return $this->actionExt;

  }//end public function toActionExt */

  /**
   * de:
   * {
   *   wenn geprüft werden muss ob ein key tatsächlich existiert, unabhäng davon
   *   ob der wert null ist, kann das mit exists getan werden
   *
   *   @example
   *   <code>
   *   if ($params->existingButNull)
   *     echo "will not be reached when key exists but ist null" // false;
   *
   *   if ($params->exists('existingButNull'))
   *      echo "will be reached when key exists but ist null" // true;
   *
   *   </code>
   * }
   * @param string $key
   */
  public function exists($key)
  {
    return array_key_exists($key , $this->content);
  }//end public function exists */

  /**
   * method to set the form data
   * @param TFlag $param
   */
  public function injectSearchFormData($view, $subkey = null)
  {

    $formAction = $this->searchFormAction;

    // the id of the html table where the new entry has to be added
    if ($this->targetId)
      $formAction .= '&amp;target_id='.$this->targetId;

    // flag if the new entry should be added with connection action or CRUD actions
    if ($this->publish)
      $formAction .= '&amp;publish='.$this->publish;

    // target is a pointer to a js function that has to be called
    if ($this->target)
      $formAction .= '&amp;target='.$this->target;

    if ($this->ltype)
      $formAction .= '&amp;ltype='.$this->ltype;

    // target is a pointer to a js function that has to be called
    if ($this->input)
      $formAction .= '&amp;input='.$this->input;

    // suffix is used to prevent namecolisions in form objects for the same
    // entity, on the same mask but diffrent datasets
    // suffix is normaly the objid, "search" oder "create"
    // it has to be transported during selection / filter requests, else the
    // data method is not able to target the correct input elements
    if ($this->suffix)
      $formAction .= '&amp;suffix='.$this->suffix;

    // they keyname is used to prevent naming colissions in forms
    if ($this->keyName)
      $formAction .= '&amp;key_name='.$this->keyName;

    // they keyname is used to prevent naming colissions in forms
    if ($this->fullLoad)
      $formAction .= '&amp;full_load=true';

    // check if there are things to exclude
    if ($this->exclude)
      $formAction .= '&amp;exclude='.$this->exclude;

    // which view type was used, important to close the ui element eg.
    if ($this->viewType)
      $formAction .= '&amp;view='.$this->viewType;

    // which view type was used, important to close the ui element eg.
    if ($this->viewId)
      $formAction .= '&amp;view_id='.$this->viewId;

    // append objid
    if ($this->objid)
      $formAction .= '&amp;objid='.$this->objid;

    if ($this->refIds) {
      foreach ($this->refIds as $key => $value) {
        $formAction .= '&amp;refids['.$key.']='.$value;
      }
    }

    if ($this->dynFilters) {
      foreach ($this->dynFilters as $value) {
        $formAction .= '&amp;dynfilter[]='.$value;
      }
    }

    // ACLS

    // startpunkt des pfades für die acls
    if ($this->aclRoot)
      $formAction .= '&amp;a_root='.$this->aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($this->aclRootId)
      $formAction .= '&amp;a_root_id='.$this->aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclKey)
      $formAction .= '&amp;a_key='.$this->aclKey;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclLevel)
      $formAction .= '&amp;a_level='.$this->aclLevel;

    // der neue knoten
    if ($this->aclNode)
      $formAction .= '&amp;a_node='.$this->aclNode;

    // add the action to the form
    $view->addVar('searchFormAction'.$subkey, $formAction);

    // check if there is a specific class for the crudform, if not use wcm wcm_req_ajax
    if (!$this->searchFormClass)
      $this->searchFormClass = 'wcm wcm_req_ajax';

    // add the class to the form
    $view->addVar('searchFormClass'.$subkey, $this->searchFormClass);

    // formId
    $view->addVar('searchFormId'.$subkey, $this->searchFormId);

  }//end public function injectSearchFormData */

  /**
   * method to set the form data
   * @param TFlag $param
   */
  public function buildSearchFormAction($formAction)
  {

    // the id of the html table where the new entry has to be added
    if ($this->targetId)
      $formAction .= '&amp;target_id='.$this->targetId;

    // flag if the new entry should be added with connection action or CRUD actions
    if ($this->publish)
      $formAction .= '&amp;publish='.$this->publish;

    // target is a pointer to a js function that has to be called
    if ($this->target)
      $formAction .= '&amp;target='.$this->target;

    // target is a pointer to a js function that has to be called
    if ($this->input)
      $formAction .= '&amp;input='.$this->input;

    // they keyname is used to prevent naming colissions in forms
    if ($this->keyName)
      $formAction .= '&amp;key_name='.$this->keyName;

    // suffix is used to prevent namecolisions in form objects for the same
    // entity, on the same mask but diffrent datasets
    // suffix is normaly the objid, "search" oder "create"
    // it has to be transported during selection / filter requests, else the
    // data method is not able to target the correct input elements
    if ($this->suffix)
      $formAction .= '&amp;suffix='.$this->suffix;

    if ($this->fullLoad)
      $formAction .= '&amp;full_load=true';

    // check if there are things to exclude
    if ($this->exclude)
      $formAction .= '&amp;exclude='.$this->exclude;

    // which view type was used, important to close the ui element eg.
    if ($this->viewType)
      $formAction .= '&amp;view='.$this->viewType;

    // which view type was used, important to close the ui element eg.
    if ($this->viewId)
      $formAction .= '&amp;view_id='.$this->viewId;

    // append objid
    if ($this->objid)
      $formAction .= '&amp;objid='.$this->objid;

    if ($this->refIds) {
      foreach ($this->refIds as $key => $value) {
        $formAction .= '&amp;refids['.$key.']='.$value;
      }
    }

    if ($this->dynFilters) {
      foreach ($this->dynFilters as $value) {
        $formAction .= '&amp;dynfilter[]='.$value;
      }
    }

    // ACLS

    // startpunkt des pfades für die acls
    if ($this->aclRoot)
      $formAction .= '&amp;a_root='.$this->aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($this->aclRootId)
      $formAction .= '&amp;a_root_id='.$this->aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclKey)
      $formAction .= '&amp;a_key='.$this->aclKey;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclLevel)
      $formAction .= '&amp;a_level='.$this->aclLevel;

    // der neue knoten
    if ($this->aclNode)
      $formAction .= '&amp;a_node='.$this->aclNode;

    return $formAction;

  }//end public function setFormAction */

  /**
   *
   * get the main oid, can be overwritten if needed
   * @param string $key
   * @param string $accessKey
   * @param string $validator
   * @return int/string
   */
  public function getOID($key = null, $accessKey = null, $validator = Validator::CKEY)
  {

    $request = $this->request;

    if ($key) {
      $id = $request->data($key, Validator::INT, 'rowid');

      if ($id) {
        Debug::console('got post rowid: '.$id);

        return $id;
      }
    }

    $id = $request->param('objid', Validator::INT);

    if (!$id && $accessKey) {
      if ($key) {
        $id = $request->data($key, $validator, $accessKey);

        if ($id) {
          Debug::console('got post rowid: '.$id);

          return $id;
        }
      }

      $id = $request->param($accessKey, $validator);

      Debug::console('got param '.$accessKey.': '.$id);

    } else {
      Debug::console('got param objid: '.$id);
    }

    return $id;

  }//end public function getOID

} // end class Context

