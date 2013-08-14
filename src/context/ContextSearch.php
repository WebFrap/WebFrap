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
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class ContextSearch extends Context
{
  
  /**
   * Order
   * @var array
   */
  public $order = array();
  
  /**
   * Die HTML Element ID
   * @var string
   */
  public $elid = null;
  
  
  /**
   * Freitext Suchstring
   * @var string
   */
  public $free = null;
  
  
  /**
   * Anker für Events
   * @var string
   */
  public $cbElement = null;
  

  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {
    
    /* Acl Stuff */
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
    
    /* List Stuff */
      
    // über den ltype können verschiedene listenvarianten gewählt werden
    // diese müssen jedoch vorhanden / implementiert sein
    if ($ltype   = $request->param('ltp', Validator::CNAME))
      $this->ltype    = $ltype;

    // append entries
    if ($append = $request->param('apd', Validator::BOOLEAN))
      $this->append    = $append;

      // start position of the query and size of the table
    $this->offset
      = $request->param('ofs', Validator::INT);

    // start position of the query and size of the table
    $this->start
      = $request->param('st', Validator::INT);

    if ($this->offset) {
      if (!$this->start)
        $this->start = $this->offset;
    }

    // stepsite for query (limit) and the table
    if (!$this->qsize = $request->param('qsz', Validator::INT))
      $this->qsize = Wgt::$defListSize;

    // order for the multi display element
    $this->order
      = $request->param('ord', Validator::CNAME);

    // Call Back element ID
    $this->cbElement
      = $request->param('cbe', Validator::CKEY  );

    // HTML Id for the target HTML List Element
    $this->elid
      = $request->param('elid', Validator::CKEY  );

    // flag for beginning seach filter
    if ($text = $request->param('bgn', Validator::TEXT  )) {
      // whatever is comming... take the first char
      $this->begin = $text[0];
    }

    // the model should add all inputs in the ajax request, not just the text
    // converts per default to false, thats ok here
    $this->fullLoad
      = $request->param('ful', Validator::BOOLEAN);

    // exclude whatever
    $this->exclude
      = $request->param('xcld', Validator::CKEY  );

    // keyname to tageting ui elements
    $this->keyName
      = $request->param('kn', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $this->objid
      = $request->param('objid', Validator::EID  );

    // order for the multi display element
    $this->targetMask
      = $request->param('target_mask', Validator::CNAME);
      
    /* Basic Search */
      
    // search free
    $this->free
      = $request->param('free', Validator::TEXT);

  }//end public function interpretRequest */

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

    if ($this->targetMask)
      $this->urlExt .= '&amp;target_mask='.$this->targetMask;

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

    if ($this->targetMask)
      $this->actionExt .= '&target_mask='.$this->targetMask;

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

} // end class ContextSearch
