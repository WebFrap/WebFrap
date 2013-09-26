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
class ContextForm extends Context
{

  public $publish = null;

  public $targetId = null;

  public $target = null;

  public $targetMask = null;

  public $refId = null;

  public $ltype = null;

  /**
   *
   * Die Rootarea des Pfades über den wir gerade in den rechten wandeln
   * @var string $aclRoot
   */
  public $aclRoot = null;

  public $aclRootId = null;

  public $aclKey = null;

  public $aclLevel = null;

  public $aclNode = null;

  /**
   * Interpret the Userinput Flags
   *
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

     // the publish type, like selectbox, tree, table..
    if ($publish = $request->param('publish', Validator::CNAME))
      $this->publish = $publish;

    // if of the target element, can be a table, a tree or whatever
    if ($targetId = $request->param('target_id', Validator::CKEY))
      $this->targetId = $targetId;

    // callback for a target function in thr browser
    if ($target = $request->param('target', Validator::CKEY))
      $this->target = $target;

    // target mask key
    if ($targetMask = $request->param('target_mask', Validator::CNAME))
      $this->targetMask = $targetMask;

    // target mask key
    if ($refId = $request->param('refid', Validator::INT))
      $this->refId = $refId;

    // listing type
    if ($ltype = $request->param('ltype', Validator::CNAME))
      $this->ltype = $ltype;

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $this->aclRoot = $aclRoot;
    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $this->aclRootId = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $this->aclKey = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $this->aclLevel = $aclLevel;

    // der neue knoten
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $this->aclNode = $aclNode;

    // request elemet type, bei back to top ist es relevant zu wissen woher der
    // aufruf kam (in diesem fall von einem input)
    // könnte bei referenzen auch interessant werden
    // values: inp | ref
    if ($requestedBy = $request->param('rqtby', Validator::TEXT))
      $this->requestedBy = $requestedBy;
    
    if ($parentMask = $request->param('psmk', Validator::TEXT))
      $this->parentMask = $parentMask;

    // sprungpunkt für back to top
    if ($maskRoot = $request->param('m_root', Validator::TEXT))
      $this->maskRoot = $maskRoot;

    // per default
    $this->categories = array();

  }//end public function interpretRequest */

} // end class TFlagForm

