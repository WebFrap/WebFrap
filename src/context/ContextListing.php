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
class ContextListing
{

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

  /**
   * Der type der Liste, z.B. Table, Treetable, Selection
   * @var string
   */
  public $ltype = null;

  /**
   * Mit dem append flag wird gesteuer ob listenelemente mit ihrem push
   * den Body ersetzen oder etwas an ihn anhängen
   * @var boolean
   */
  public $append = null;

  /**
   * Liste der Suchwerte aus der Col Search
   * @var array / null wenn leer
   */
  public $colConditions = null;
  
  /**
   * Conditions für die query
   * @var array / null wenn leer
   */
  public $conditions = null;

  /**
   * Variable für Sortierinformationen
   * @var array / null wenn leer
   */
  public $order = null;

  /**
   * Eine List mit Filtern
   * @var TFlag
   */
  public $filter = null;
  
  /**
   * Extended Search filter
   * @var array
   */
  public $extSearch = array();

/*//////////////////////////////////////////////////////////////////////////////
// Protected data
//////////////////////////////////////////////////////////////////////////////*/

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
  protected $extSearchValidator = null;
  

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   */
  public function __construct($request, $extSearchValidator = null)
  {

    $this->filter = new TFlag();

    $filters = $request->param('filter', Validator::BOOLEAN);

    if ($filters) {
      foreach ($filters as $key => $value) {
        $this->filter->$key = $value;
      }
    }
    
  
    if ($request->paramExists('as')) {
      if ($extSearchValidator)
        $this->extSearchValidator = $extSearchValidator;
      else
        $this->extSearchValidator = new ValidSearchBuilder();
    }

    $this->interpretRequest($request);
    


  } // end public function __construct */
  
  

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
   *
   * Enter description here ...
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {
    
    if( $request->paramExists('as') ){
      $this->interpretExtendedSearch($request);
    }

    // the publish type, like selectbox, tree, table..
    if ($publish  = $request->param('publish', Validator::CNAME))
      $this->publish   = $publish;

    // über den ltype können verschiedene listenvarianten gewählt werden
    // diese müssen jedoch vorhanden / implementiert sein
    if ($ltype   = $request->param('ltype', Validator::CNAME))
      $this->ltype    = $ltype;

    // input type
    if ($input = $request->param('input', Validator::CKEY))
      $this->input    = $input;

    // input type
    if ($suffix = $request->param('suffix', Validator::CKEY))
      $this->suffix    = $suffix;

    // append entries
    if ($append = $request->param('append', Validator::BOOLEAN))
      $this->append    = $append;

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $this->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $this->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $this->aclKey    = $aclKey;

    // der name des knotens
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $this->aclNode    = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $this->aclLevel  = $aclLevel;

    // per default
    $this->categories = array();

      // start position of the query and size of the table
    $this->offset
      = $request->param('offset', Validator::INT);

    // start position of the query and size of the table
    $this->start
      = $request->param('start', Validator::INT);

    if ($this->offset) {
      if (!$this->start)
        $this->start = $this->offset;
    }

    // stepsite for query (limit) and the table
    if (!$this->qsize = $request->param('qsize', Validator::INT))
      $this->qsize = Wgt::$defListSize;

    // order for the multi display element
    $this->order
      = $request->param('order', Validator::CNAME);

    // target for a callback function
    $this->target
      = $request->param('target', Validator::CKEY  );

    // target for some ui element
    $this->targetId
      = $request->param('target_id', Validator::CKEY  );

    // flag for beginning seach filter
    if ($text = $request->param('begin', Validator::TEXT  )) {
      // whatever is comming... take the first char
      $this->begin = $text[0];
    }

    // the model should add all inputs in the ajax request, not just the text
    // converts per default to false, thats ok here
    $this->fullLoad
      = $request->param('full_load', Validator::BOOLEAN);

    // exclude whatever
    $this->exclude
      = $request->param('exclude', Validator::CKEY  );

    // keyname to tageting ui elements
    $this->keyName
      = $request->param('key_name', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $this->objid
      = $request->param('objid', Validator::EID  );

    // order for the multi display element
    $this->mask
      = $request->param('mask', Validator::CNAME);

  }//end public function interpretRequest */
  
  
  /**
   * Interpretieren von Extended Search Parametern
   * @param LibRequestHttp $request
   */
  public function interpretExtendedSearch($request)
  {
    
    $extSearchFields = $request->param('as');
    
    if (!$extSearchFields)
      return;
    
    foreach ($extSearchFields as $fKey => $extField) {
      
      if (isset($extField['parent'])) {
        
        if (!isset($this->extSearch[$extField['parent']]->sub)  )
          $this->extSearch[$extField['parent']]->sub = array();
          
        $this->extSearch[$extField['parent']]->sub[] = (object)$this->extSearchValidator->validate($extField, $this-> $fieldData);
          
      } else {
        
        $this->extSearch[$fKey] = (object)$extField;
        
      }
      
    }


  }//end public function interpretExtendedSearch */

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

    if ($this->mask)
      $this->urlExt .= '&amp;mask='.$this->mask;

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

    if ($this->mask)
      $this->actionExt .= '&mask='.$this->mask;

    return $this->actionExt;

  }//end public function toActionExt */

  /**
   * @param Context $context
   */
  public function importAcl($context)
  {

    // startpunkt des pfades für die acls
    $this->aclRoot   = $context->aclRoot;
    $this->aclRootId = $context->aclRootId;
    $this->aclKey    = $context->aclKey;
    $this->aclNode   = $context->aclNode;
    $this->aclLevel   = $context->aclLevel;

  }//end public function importAcl */

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

} // end class TFlagListing
